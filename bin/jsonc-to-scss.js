/**
 * A webpack loader to generate SCSS maps from JSONC files.
 * @author Aurooba Ahmed
 */

// Description: This file is used to generate the breakpoints.scss file
// from the theme.json file. This file is then imported into the global.scss
// file. This allows us to use the breakpoints in our scss files.

var path = require("path");
var jsonc = require("jsonc");

module.exports = function (content) {
	var contentPath = this.resourcePath;
	var parsedContentPath = path.parse(this.resourcePath);
	var parsedObject = {};
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
	this.addDependency(contentPath);

	function jsontoSCSS(object, indent) {
		// Make object root properties into scss variables
		var scss = "";
		for (var key in object) {
			scss +=
				"$" + key + ":" + JSON.stringify(object[key], null, indent) + ";\n";
		}

		if (!scss) {
			return scss;
		}

		// Store string values (so they remain unaffected)
		var storedStrings = [];
		scss = scss.replace(/(["'])(?:(?=(\\?))\2.)*?\1/g, function (str) {
			var id = "___JTS" + storedStrings.length;
			storedStrings.push({ id: id, value: str });
			return id;
		});

		// Convert js lists and object into scss lists and maps
		scss = scss.replace(/[{\[]/g, "(").replace(/[}\]]/g, ")");

		// Put string values back (now that we're done converting)
		storedStrings.forEach(function (str) {
			str.value = str.value.replace(/["']/g, "");
			scss = scss.replace(str.id, str.value);
		});

		return scss;
	}
	console.log("Generating SCSS from JSONC file");
	var scss = jsontoSCSS(scssVars, "\t");
	return scss;
};
