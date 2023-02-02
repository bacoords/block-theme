const fs = require("fs-extra");
const jsonc = require("jsonc");
const { readFile } = require("fs");
const { join, parse, sep } = require("path");
const { promisify } = require("util");
const glob = require("glob");
const set = require("lodash.set");
const asyncReadFile = promisify(readFile);
const asyncGlob = promisify(glob);
const asyncMap = (arr, callback) =>
	Promise.all(arr.map((...args) => callback(...args)));

/**
 * Parses the file with the given parser if provided or jsonc.parse() by default.
 * @param {string} filePath
 * @param {function} parser
 * @returns parsed file
 */
async function parseFile(filePath, parser = jsonc.parse) {
	const buff = await asyncReadFile(filePath);
	const text = buff.toString();
	try {
		return parser(text);
	} catch (parseError) {
		throw new Error(`Couldn't parse ${filePath}. Error: ${parseError}`);
	}
}

/**
 * Gets the key for the object based on the path.
 * @param {string} path
 * @returns key
 */
function getKey(path) {
	const parts = path.split(sep);
	if (parts.length) {
		const fileName = parts[parts.length - 1];
		parts[parts.length - 1] = parse(fileName).name;
	}
	return parts;
}

/**
 * Matches the file path to the result object.
 * @param {object} result
 * @param {string} root
 * @param {string} filePath
 * @param {function} parser
 * @returns {object} result
 */
async function processMatch(result, root, filePath, parser) {
	const fullPath = join(root, filePath);
	const what = await parseFile(fullPath, parser);
	const where = getKey(filePath);
	set(result, where, what);
	return result;
}

/**
 * Combines JSON files in a directory into a single object.
 *
 * The algorithm is as follows:
 * It creates a key with the file name without the `.jsonc` extension.
 * The value will be the contents of the file parsed in JSON, stripping the comments.
 * The value of all the files in the directory will be combined into a single object, recursively, to include subdirectories.
 *
 *
 * @param {string} root - The path to a folder that contains the files and subdirectories
 * @param {object} [options] - options for customizing the behavior of the algorithm
 * @param {function} [options.parser=jsonc.parse] - a custom parser that receives the contents of the file as the only argument and returns the parsed value.
 * @param {string} [options.include='*.jsonc'] - a glob pattern for what to include, defaults to `*.jsonc`
 * @param {string} [options.exclude] - a glob pattern for what to exclude
 *
 * @throws An error if it can't access or parse a file or directory.
 * @returns {object} A JavaScript object (or an array if that's what the data represents).
 */
async function combineJSONC(root, options = {}) {
	// get the options, set defaults
	const { parser, include = "*.jsonc", exclude } = options;

	// get the files
	const matches = await asyncGlob(include, {
		// glob options: https://www.npmjs.com/package/glob#options
		ignore: exclude,
		cwd: root,
		mark: true,
		nocase: true,
		nodir: true,
		matchBase: true,
	});

	// process the files
	const result = {};
	await asyncMap(matches, (filePath) =>
		processMatch(result, root, filePath, parser),
	);

	return result;
}

/**
 * Creates a theme.json file from the themejson directory in the root of the project.
 * @returns void
 */
async function createThemeJson() {
	// Combine the JSONC files in the themejson directory into a JSON object
	const themeJson = await combineJSONC("src/theme-json");

	// Write the theme.json file
	let themeJsonObject = JSON.stringify(themeJson, null, 2);
	fs.writeFileSync("theme.json", themeJsonObject);
}

createThemeJson();
