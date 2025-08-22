// js/resize-images.js
const sharp = require("sharp");
const fs = require("fs");
const path = require("path");
const glob = require("glob");

const sizes = [320, 640, 1024, 1920];

// Get absolute path to project root
const projectRoot = path.resolve(".");

// Find all jpg/jpeg/png images inside any `images` folder
const imageFiles = glob.sync("**/images/**/*.{jpg,jpeg,png}", {
  cwd: projectRoot,
  nodir: true,
  absolute: false, // keep relative for nice output paths
});

console.log(`Found ${imageFiles.length} images to resize...`);

imageFiles.forEach((relativePath) => {
  const ext = path.extname(relativePath).toLowerCase();
  const baseName = path.basename(relativePath, ext);
  const dir = path.dirname(relativePath);

  const absInputPath = path.join(projectRoot, relativePath); // absolute path for sharp

  sizes.forEach((size) => {
    const outputDir = path.join(projectRoot, dir, `${size}w`);
    if (!fs.existsSync(outputDir)) {
      fs.mkdirSync(outputDir, { recursive: true });
    }

    const outputPath = path.join(outputDir, `${baseName}_${size}w${ext}`);

    sharp(absInputPath)
      .resize(size)
      .toFile(outputPath)
      .then(() => console.log(`✅ Created: ${outputPath}`))
      .catch((err) =>
        console.error(`❌ Error processing ${absInputPath}:`, err.message)
      );
  });
});
