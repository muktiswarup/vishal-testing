// js/convert-to-picture-and-imageset.js
const fs = require("fs");
const path = require("path");
const cheerio = require("cheerio");

const sizes = [320, 640, 1024, 1920];

/**
 * Process HTML/PHP files → Replace <img> with <picture> + WebP sources
 */
function processHTMLorPHP(filePath) {
  let html = fs.readFileSync(filePath, "utf8");
  const $ = cheerio.load(html, { decodeEntities: false });
  let modified = false;

  $("img").each((_, el) => {
    const $img = $(el);
    const src = $img.attr("src");

    if (!src || src.includes("data:")) return; // Skip inline images

    const ext = path.extname(src).toLowerCase();
    const baseName = path.basename(src, ext);
    const dirName = path.dirname(src);

    const picture = $("<picture></picture>");

    // Add responsive WebP sources
    sizes.forEach((size) => {
      picture.append(
        `<source srcset="${dirName}/${size}w/${baseName}_${size}w.webp" media="(max-width: ${size}px)" type="image/webp">`
      );
    });

    // Fallback <img> in original format
    const imgFallback = $img.clone();
    imgFallback.attr("src", `${dirName}/${baseName}${ext}`);
    picture.append(imgFallback);

    $img.replaceWith(picture);
    modified = true;
  });

  if (modified) {
    fs.writeFileSync(filePath, $.html(), "utf8");
    console.log(`✅ Updated <img> → <picture> in ${filePath}`);
  }
}

/**
 * Process CSS files → Replace background-image with image-set() including WebP
 */
function processCSS(filePath) {
  let css = fs.readFileSync(filePath, "utf8");
  let modified = false;

  css = css.replace(
    /(background(?:-image)?\s*:\s*)([^;]+)(;?)/gi,
    (match, prefix, value, suffix) => {
      const parts = value.split(/\s*,\s*/).map((bg) => {
        const urlMatch = /url\(["']?([^"')]+)["']?\)/i.exec(bg);
        if (!urlMatch) return bg;

        const imgPath = urlMatch[1];
        const ext = path.extname(imgPath).toLowerCase();
        const baseName = path.basename(imgPath, ext);
        const dirName = path.dirname(imgPath);

        // Build WebP set
        const webpSet = sizes
          .map(
            (size) =>
              `url("${dirName}/${size}w/${baseName}_${size}w.webp") ${size}w`
          )
          .join(", ");

        // Build fallback set
        const fallbackSet = sizes
          .map(
            (size) =>
              `url("${dirName}/${size}w/${baseName}_${size}w${ext}") ${size}w`
          )
          .join(", ");

        modified = true;
        return `
${prefix}${bg}${suffix}
${prefix}-webkit-image-set(${webpSet}); 
${prefix}image-set(${webpSet});
${prefix}-webkit-image-set(${fallbackSet});
${prefix}image-set(${fallbackSet});`;
      });

      return parts.join(", ");
    }
  );

  if (modified) {
    fs.writeFileSync(filePath, css, "utf8");
    console.log(`🎨 Updated background-image in ${filePath}`);
  }
}

/**
 * Recursively walk through directories
 */
function walk(dir) {
  fs.readdirSync(dir).forEach((file) => {
    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);

    if (stat.isDirectory()) {
      walk(fullPath);
    } else if (/\.(php|html)$/i.test(file)) {
      processHTMLorPHP(fullPath);
    } else if (/\.css$/i.test(file)) {
      processCSS(fullPath);
    }
  });
}

// Start from project root (one level up from /js/)
walk(path.resolve(__dirname, ".."));
