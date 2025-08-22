// js/add-img-dimensions.js
const fs = require("fs");
const path = require("path");
const glob = require("glob");
const cheerio = require("cheerio");
const sharp = require("sharp");

const projectRoot = path.resolve(".");
const files = glob.sync("**/*.{html,php}", {
  cwd: projectRoot,
  absolute: true,
});

async function addDimensions() {
  for (const file of files) {
    let html = fs.readFileSync(file, "utf8");
    const $ = cheerio.load(html, { decodeEntities: false });
    let modified = false;

    const imgs = $("img");
    for (let i = 0; i < imgs.length; i++) {
      const $img = $(imgs[i]);
      const src = $img.attr("src");
      if (!src || /^https?:\/\//i.test(src)) continue; // skip external

      if (!$img.attr("width") || !$img.attr("height")) {
        // Resolve relative or absolute paths
        const cleanSrc = src.split("?")[0].split("#")[0];
        const imgPath = src.startsWith("/")
          ? path.join(projectRoot, cleanSrc)
          : path.resolve(path.dirname(file), cleanSrc);

        if (!fs.existsSync(imgPath)) continue;

        try {
          const metadata = await sharp(imgPath).metadata();
          if (metadata.width && metadata.height) {
            $img.attr("width", metadata.width);
            $img.attr("height", metadata.height);
            modified = true;
          }
        } catch {
          // ignore invalid/unreadable images
        }
      }
    }

    if (modified) {
      fs.writeFileSync(file, $.html(), "utf8");
      console.log(`✅ Updated dimensions in: ${file}`);
    }
  }
}

addDimensions().catch(console.error);
