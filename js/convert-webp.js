// js/convert-webp.js
const sharp = require("sharp");
const fs = require("fs");
const path = require("path");
const glob = require("glob");

const projectRoot = path.resolve(".");
const imageFiles = glob.sync("**/{images,images1}/**/*.{jpg,jpeg,png}", {
  cwd: projectRoot,
  nodir: true,
  absolute: true,
});

console.log(`Found ${imageFiles.length} images to convert to WebP`);

(async () => {
  for (const filePath of imageFiles) {
    const ext = path.extname(filePath).toLowerCase();
    const outputPath = path.join(
      path.dirname(filePath),
      path.basename(filePath, ext) + ".webp"
    );

    try {
      await sharp(filePath).toFormat("webp").toFile(outputPath);
      console.log(`✅ Converted to WebP: ${outputPath}`);
    } catch (err) {
      console.error(`❌ Error converting ${filePath}:`, err.message);
    }
  }
})();
