// js/add-font-display-swap.js
const fs = require("fs");
const path = require("path");
const glob = require("glob");

// Resolve project root (one level up from this script's folder)
const projectRoot = path.resolve(__dirname, "..");

// Find all CSS files inside the css/ folder
const cssFiles = glob.sync("css/**/*.css", {
  cwd: projectRoot,
  absolute: true,
});

console.log("Found CSS files:", cssFiles);

cssFiles.forEach((file) => {
  let css = fs.readFileSync(file, "utf8");

  // Add font-display: swap if not present inside @font-face blocks
  const updatedCss = css.replace(/@font-face\s*{[^}]*}/g, (match) => {
    if (!/font-display\s*:/i.test(match)) {
      return match.replace(/}/, "  font-display: swap;\n}");
    }
    return match;
  });

  if (updatedCss !== css) {
    fs.writeFileSync(file, updatedCss, "utf8");
    console.log(`✅ Added font-display: swap in ${file}`);
  } else {
    console.log(`ℹ️ No changes needed in ${file}`);
  }
});
