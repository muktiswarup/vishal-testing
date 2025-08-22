// js/convert-webp.js
const sharp = require("sharp");
const fs = require("fs");
const path = require("path");
const glob = require("glob");

// Always point to project root (parent of /js/)
const projectRoot = path.resolve(__dirname, "..");

// Find all jpg, jpeg, png inside any "images" folder
const imageFiles = glob.sync("**/images/**/*.{jpg,jpeg,png}", {
  cwd: projectRoot,
  nodir: true,
  absolute: true,
});

console.log(`Found ${imageFiles.length} images to convert to WebP`);

imageFiles.forEach((filePath) => {
  const ext = path.extname(filePath).toLowerCase();
  const outputPath = path.join(
    path.dirname(filePath),
    path.basename(filePath, ext) + ".webp"
  );

  sharp(filePath)
    .toFormat("webp")
    .toFile(outputPath)
    .then(() => console.log(`Converted to WebP: ${outputPath}`))
    .catch((err) => console.error(`Error converting ${filePath}:`, err));
});
