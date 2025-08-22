// js/optimize.js
const fs = require("fs-extra");
const path = require("path");
const glob = require("glob");
const cheerio = require("cheerio");
const { minify: minifyHtml } = require("html-minifier-terser");
const postcss = require("postcss");
const purgecss = require("@fullhuman/postcss-purgecss");
const cssnano = require("cssnano");
const sharp = require("sharp");

// Always resolve project root (parent of /js/)
const projectRoot = path.resolve(__dirname, "..");

const SRC_DIR = path.join(projectRoot, "emnar-pharma");
const OUT_DIR = path.join(projectRoot, "optimized");
const IMG_WIDTHS = [320, 640, 1024];

async function ensureOut() {
  await fs.remove(OUT_DIR);
  await fs.ensureDir(OUT_DIR);
}

async function copyStatic() {
  await fs.copy(SRC_DIR, OUT_DIR);
}

async function minifyHtmlPhpFiles() {
  const files = glob.sync(`${OUT_DIR}/**/*.{html,php}`);
  await Promise.all(
    files.map(async (file) => {
      let content = await fs.readFile(file, "utf8");
      try {
        const minified = await minifyHtml(content, {
          collapseWhitespace: true,
          removeComments: true,
          removeRedundantAttributes: true,
          keepClosingSlash: true,
          minifyCSS: true,
          minifyJS: false, // 🚫 disable JS minification
          ignoreCustomFragments: [/<\?php[\s\S]*?\?>/], // 🚀 keep PHP safe
        });
        await fs.writeFile(file, minified, "utf8");
      } catch {
        console.warn(`Skipping minify for ${file} (likely PHP issue)`);
      }
    })
  );
}

async function processCssFiles() {
  const cssFiles = glob.sync(`${OUT_DIR}/**/*.css`);
  const contentFiles = glob.sync(`${OUT_DIR}/**/*.{html,php,js}`, { nodir: true });

  const purge = purgecss({
    content: contentFiles,
    safelist: {
      standard: [
        /^container(-fluid)?$/,
        /^row$/,
        /^col(-.*)?$/,
        /^btn(-.*)?$/,
        /^navbar(-.*)?$/,
        /^d-(sm|md|lg|xl|xxl)?-(flex|block|none)$/,
        /^show$/,
        /^fade$/,
        /^active$/,
        /^carousel(-.*)?$/,
      ],
    },
  });

  await Promise.all(
    cssFiles.map(async (file) => {
      let css = await fs.readFile(file, "utf8");
      const out = await postcss([purge, cssnano({ preset: "default" })]).process(
        css,
        { from: file, to: file }
      );
      await fs.writeFile(file, out.css, "utf8");
    })
  );
}

async function optimizeImages() {
  const imgFiles = glob.sync(`${OUT_DIR}/images/**/*.{png,jpg,jpeg}`, { nodir: true });

  await Promise.all(
    imgFiles.map(async (srcPath) => {
      const dir = path.dirname(srcPath);
      const base = path.basename(srcPath, path.extname(srcPath));

      // optimize original
      const buffer = await sharp(srcPath)
        .jpeg({ quality: 78 })
        .png({ quality: 80, compressionLevel: 8 })
        .toBuffer();
      await fs.writeFile(srcPath, buffer);

      // responsive webp + avif
      await Promise.all(
        IMG_WIDTHS.map(async (w) => {
          await sharp(srcPath)
            .resize({ width: w, withoutEnlargement: true })
            .toFormat("webp", { quality: 72 })
            .toFile(path.join(dir, `${base}-${w}.webp`));

          await sharp(srcPath)
            .resize({ width: w, withoutEnlargement: true })
            .toFormat("avif", { quality: 40 })
            .toFile(path.join(dir, `${base}-${w}.avif`));
        })
      );
    })
  );
}

async function transformHtmlImages() {
  const htmlFiles = glob.sync(`${OUT_DIR}/**/*.{html,php}`);
  await Promise.all(
    htmlFiles.map(async (file) => {
      let html = await fs.readFile(file, "utf8");
      const $ = cheerio.load(html, { decodeEntities: false });

      $("img").each((_, el) => {
        const $el = $(el);
        const src = $el.attr("src");
        if (!src) return;

        const ext = path.extname(src);
        const base = path.basename(src, ext);

        // add lazy-loading
        if (!$el.attr("loading")) $el.attr("loading", "lazy");

        // replace <img> with <picture>
        const picture = `
          <picture>
            <source srcset="images/${base}-320.webp 320w, images/${base}-640.webp 640w, images/${base}-1024.webp 1024w" type="image/webp">
            <source srcset="images/${base}-320.avif 320w, images/${base}-640.avif 640w, images/${base}-1024.avif 1024w" type="image/avif">
            <img src="${src}" loading="lazy" alt="${$el.attr("alt") || ""}">
          </picture>
        `;
        $el.replaceWith(picture);
      });

      await fs.writeFile(file, $.html(), "utf8");
    })
  );
}

async function main() {
  await ensureOut();
  await copyStatic();
  await minifyHtmlPhpFiles();
  await processCssFiles();
  await optimizeImages();
  await transformHtmlImages();
  console.log("Optimization complete (without JS minify).");
}

main();
