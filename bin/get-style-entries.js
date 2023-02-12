/**
 * This file is used to get all the root scss files in the src/scss folder for use
 * as entry points in the webpack.config.js file.
 */

const glob = require("glob");
const path = require("path");

function getStyleEntries() {
	// get all root scss files in the src/scss folder
	const entries = glob.sync("src/scss/*.scss");

	// create an object with the relative output path as the key and the file path as the value
	const entriesWithKeys = entries.reduce((acc, entry) => {
		const name = "../css/" + path.basename(entry);
		acc[name] = path.resolve(entry);
		return acc;
	}, {});

	return entriesWithKeys;
}

// export the function so it can be used in the webpack.config.js file
module.exports.getStyleEntries = getStyleEntries;
