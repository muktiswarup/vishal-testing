// js/add-font-display-swap.js
const fs = require("fs");
const path = require("path");
const glob = require("glob");

const projectRoot = path.resolve(".");
const cssFiles = glob.sync("**/*.css", {
  cwd: projectRoot,
  absolute: true,
});

cssFiles.forEach((file) => {
  let css = fs.readFileSync(file, "utf8");

  // Match @font-face blocks (multiline-safe, non-greedy)
  const updatedCss = css.replace(/@font-face\s*{[^}]*?}/gs, (match) => {
    if (!/font-display\s*:/i.test(match)) {
      // Preserve indentation if possible
      const indent = (match.match(/\n(\s*)[^\n]*\}/) || [,"  "])[1];
      return match.replace(/}$/, `${indent}font-display: swap;\n}`);
    }
    return match;
  });

  if (updatedCss !== css) {
    fs.writeFileSync(file, updatedCss, "utf8");
    console.log(`✅ Added font-display: swap in ${file}`);
  }
});
