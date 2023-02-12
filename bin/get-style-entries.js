/**
 * This file is used to get all the root scss files in the src/scss folder for use
 * as entry points in the webpack.config.js file.
 */

const glob = require("glob");
const path = require("path");

/**
 * Get all the root style files in the indicated styles folder
 * and return an object with the relative output path as the key for each.
 *
 * @param {string} root The root folder to search for scss files; should be relative to the root of the theme with no leading or trailing slashes
 * @param {string} include The glob pattern to use to find style files
 * @param {string} outputFolder The folder to output the compiled style files in; should be relative to the root of the theme with no leading or trailing slashes
 * @returns
 */
function getStyleEntries(options) {
	const {
		root = "src/scss",
		include = "*.scss",
		outputFolder = "css",
	} = options;
	// get all root scss files in the src/scss folder
	const entries = glob.sync(root + "/" + include);

	// create an object with the relative output path as the key and the file path as the value
	const entriesWithKeys = entries.reduce((acc, entry) => {
		const name = "../" + outputFolder + "/" + path.parse(entry).name;
		acc[name] = path.resolve(entry);
		return acc;
	}, {});
	return entriesWithKeys;
}

// export the function so it can be used in the webpack.config.js file
module.exports.getStyleEntries = getStyleEntries;
