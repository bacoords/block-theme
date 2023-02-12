/**
 * A webpack loader to generate SCSS maps from JSONC files.
 * Heavily inspired by `json-to-scss`: https://www.npmjs.com/package/json-to-scss
 */

var path = require("path");
var jsonc = require("jsonc");
var terminal = require("terminal-overwrite");
var clc = require("cli-color");

module.exports = function (content) {
	// get the path of the file being loaded
	var contentPath = this.resourcePath;
	// parse the path into an object of its parts
	var parsedContentPath = path.parse(this.resourcePath);
	// create an object to hold the parsed jsonc file
	var parsedObject = {};
	// create an object attach the filename as the key to the parsed object
	var scssVars = {};
	if (parsedContentPath.ext === ".jsonc") {
		// parse the jsonc file into regular JSON
		parsedObject = jsonc.parse(content);

		// assign the filename as the key for all the file contents
		// this generates a map keyed to the filename
		scssVars[parsedContentPath.name] = parsedObject;
	} else {
		throw "Invalid file type (" + parsedContentPath.ext + ")";
	}

	this.cacheable();
	// add the file as a dependency so webpack knows to rebuild when it changes
	this.addDependency(contentPath);

	// generate the scss from the jsonc file, with a tab indent
	var scss = jsontoSCSS(scssVars, "\t");
	if (scss) {
		terminal(
			`\n${clc.green.bold("Generating SCSS from JSONC file:")} "${
				parsedContentPath.base
			}".\n`,
		);
	}
	return scss;

	/**
	 * Converts a JSON object into a SCSS string
	 *
	 * @param {object} object a JSON object
	 * @param {string|int} indent the number of spaces to indent the scss
	 * @returns {string} the scss string
	 */
	function jsontoSCSS(object, indent) {
		var scss = "";

		// turn all keys into scss variables by adding the $ prefix
		for (var key in object) {
			scss +=
				"$" + key + ":" + JSON.stringify(object[key], null, indent) + ";\n";
		}
		if (!scss) {
			return scss;
		}

		// Store string values for both keys and values (so they remain unaffected)
		var storedStrings = [];
		// capture any values surrounded by matching quotes and replacing them with keycodes
		scss = scss.replace(/(["'])(?:(?=(\\?))\2.)*?\1/g, function (string) {
			var key = "_aajts" + storedStrings.length;
			storedStrings.push({ key: key, value: string });
			return key;
		});
		// Convert jsonc lists and object into scss lists and maps
		scss = scss.replace(/[{\[]/g, "(").replace(/[}\]]/g, ")");

		// Put string values back in place (now that we're done converting the brackets)
		storedStrings.forEach(function (string) {
			// remove quotation marks
			string.value = string.value.replace(/["']/g, "");
			// replace the key names with the original string values
			// replace the value names with the original string values
			scss = scss.replace(string.key, string.value);
		});

		return scss;
	}
};
