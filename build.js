// build.js
const fs = require("fs");
const path = require("path");
const { minify } = require("terser"); // Import Terser

// Function to combine and minify JS files
async function combineAndMinifyJsFiles(sourceDir, outputFile) {
  let combinedContent = "";

  try {
    // Read all files in the source directory
    const files = await fs.promises.readdir(sourceDir);

    // Filter out non-JS files
    const jsFiles = files.filter((file) => path.extname(file) === ".js");

    // Read, minify, and concatenate each JS file
    for (const file of jsFiles) {
      const filePath = path.join(sourceDir, file);
      const fileContent = await fs.promises.readFile(filePath, "utf8");

      try {
        const minified = await minify(fileContent, {
          compress: {
            drop_console: false, // Preserve console.log statements
          },
          output: {
            semicolons: true,
          },
        });

        if (minified.error) {
          console.error("Terser error:", minified.error);
          process.exit(1);
        }

        combinedContent += minified.code.replace(/,+/g, ";") + ";";
      } catch (minifyErr) {
        console.error("Could not minify file", filePath, minifyErr);
        process.exit(1);
      }
    }

    // Write the combined content to the output file
    await fs.promises.writeFile(outputFile, combinedContent);

    console.log(
      `Successfully combined and minified ${jsFiles.length} files into ${outputFile}`
    );
  } catch (readDirErr) {
    console.error("Could not list the directory.", readDirErr);
    process.exit(1);
  }
}

// Get the target directory from the command line arguments
const target = process.argv[2];

// Determine the source directory and output file based on the target
let sourceDir, outputFile;

if (target === "public") {
  sourceDir = path.join(__dirname, "public", "js"); // Adjust if needed
  outputFile = path.join(__dirname, "public", "script.js");
} else if (target === "admin") {
  sourceDir = path.join(__dirname, "admin", "js"); // Adjust if needed
  outputFile = path.join(__dirname, "admin", "script.js");
} else {
  console.error('Invalid target. Use "public" or "admin".');
  process.exit(1);
}

// Call the function to combine and minify the JS files
combineAndMinifyJsFiles(sourceDir, outputFile);
