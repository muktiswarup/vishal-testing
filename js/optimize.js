// scripts/optimize.js
const fs = require("fs-extra");
const path = require("path");
const glob = require("glob");
const cheerio = require("cheerio");
const { minify: minifyHtml } = require("html-minifier-terser");
const postcss = require("postcss");
const purgecss = require("@fullhuman/postcss-purgecss");
const cssnano = require("cssnano");
const sharp = require("sharp");
const imagemin = require("imagemin");
const imageminMozjpeg = require("imagemin-mozjpeg");
const imageminPngquant = require("imagemin-pngquant");

const SRC_DIR = "emnar-pharma";
const OUT_DIR = "optimized";
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
          ignoreCustomFragments: [/<\?php[\s\S]*?\?>/], // 🚀 Don't touch PHP tags
        });
        await fs.writeFile(file, minified, "utf8");
      } catch (e) {
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
      const originalOptimized = await imagemin([srcPath], {
        plugins: [
          imageminMozjpeg({ quality: 78 }),
          imageminPngquant({ quality: [0.7, 0.85] }),
        ],
      });
      if (originalOptimized[0]) {
        await fs.writeFile(srcPath, originalOptimized[0].data);
      }

      // responsive sizes + formats
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

async function addImageDimensions() {
  const files = glob.sync(`${OUT_DIR}/**/*.{html,php}`);
  for (const file of files) {
    let html = await fs.readFile(file, "utf8");
    const $ = cheerio.load(html, { decodeEntities: false });
    let modified = false;

    const imgs = $("img");
    for (let i = 0; i < imgs.length; i++) {
      const img = imgs[i];
      const $img = $(img);

      if (!$img.attr("width") || !$img.attr("height")) {
        let src = $img.attr("src");
        if (!src) continue;

        const imgPath = path.resolve(path.dirname(file), src.split("?")[0].split("#")[0]);
        if (!fs.existsSync(imgPath)) continue;

        try {
          const metadata = await sharp(imgPath).metadata();
          if (metadata.width && metadata.height) {
            $img.attr("width", metadata.width);
            $img.attr("height", metadata.height);
            modified = true;
          }
        } catch {
          // ignore errors for missing/unreadable images
        }
      }
    }

    if (modified) {
      await fs.writeFile(file, $.html(), "utf8");
      console.log(`Added dimensions in: ${file}`);
    }
  }
}

async function transformHtmlImages() {
  const htmlFiles = glob.sync(`${OUT_DIR}/**/*.{html,php}`);
  await Promise.all(
    htmlFiles.map(async (file) => {
      let html = await fs.readFile(file, "utf8");
      const $ = cheerio.load(html, { decodeEntities: false });

      $("img").each((_, el) => {
        const $el = $(el);
        if (!$el.attr("loading")) $el.attr("loading", "lazy");
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
  // 🚫 Removed JS minify step
  await optimizeImages();
  await addImageDimensions();
  await transformHtmlImages();
  console.log("✅ Optimization complete (without JS minify).");
}

main();
