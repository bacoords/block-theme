/**
 * This file is used to get all the root files in the provided folder for use
 * as entry points in the webpack.config.js file.
 */

const glob = require("glob");
const path = require("path");

/**
 * Get all the root files in the indicated folder
 * and return an object with the relative output path as the key for each.
 *
 * @param {string} root The root folder to search for files; should be relative to the root of the theme with no leading or trailing slashes
 * @param {string} include The glob pattern to use to find files
 * @param {string} outputFolder The folder to output the compiled files in; should be relative to the root of the theme with no leading or trailing slashes
 * @param {bool} blockDir indicates if the sub directory structure should be used to create the output file name for block stylesheets
 * @returns
 */
function getEntries(options) {
	const {
		root = "src/scss",
		include = "*.scss",
		outputFolder = "css",
		blockDir = false,
	} = options;
	// get all root scss files in the src/scss folder
	const entries = glob.sync(root + "/" + include);

	// create an object with the relative output path as the key and the file path as the value
	const entriesWithKeys = entries.reduce((acc, entry) => {
		// skip the index file
		if ("index" === path.parse(entry).name) return acc;
		const outputDir = "../" + outputFolder + "/";
		const name = blockDir
			? getBlockStylesheetName(entry)
			: path.parse(entry).name;
		acc[outputDir + name] = path.resolve(entry);
		return acc;
	}, {});
	return entriesWithKeys;
}

function getBlockStylesheetName(filePath) {
	const pathParts = filePath.split(path.sep);
	if (pathParts.length) {
		const fileName = pathParts[pathParts.length - 1];
		pathParts[pathParts.length - 1] = path.parse(fileName).name;
	}
	const blockNamespace = pathParts[pathParts.length - 2];
	const blockName = pathParts[pathParts.length - 1];
	return blockNamespace + "--" + blockName;
}

// export the function so it can be used in the webpack.config.js file
module.exports = { getEntries };
