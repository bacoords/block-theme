const fs = require("fs-extra");
const jsonc = require("jsonc");
const { readFileSync } = require("fs");
const { join, parse, sep } = require("path");
const glob = require("glob");
const set = require("lodash.set");

/**
 * Parses the file with the given parser if provided or jsonc.parse() by default.
 * @param {string} filePath
 * @param {function} parser
 * @returns parsed file
 */
function parseFile(filePath, parser = jsonc.parse) {
	const buff = readFileSync(filePath);
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
function processMatch(result, root, filePath, parser) {
	const fullPath = join(root, filePath);

	const what = parseFile(fullPath, parser);
	const where = getKey(filePath);
	// if we are in the blocks directory, we need to combine the block namespace and name into one key
	const inBlocksObject = where[1] === "blocks";
	if (inBlocksObject) {
		// if the file is in the blocks directory, we need to add the block name to the key
		const blockNamespace = where[2];
		const blockName = where[3];
		where[2] = `${blockNamespace}/${blockName}`;
		where.splice(3, 1);
	}
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
function combineJSONC(root, options = {}) {
	// get the options, set defaults
	const { parser = jsonc.parse, include = "*.jsonc", exclude } = options;

	// get the files
	const matches = glob.sync(include, {
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
	matches.map((filePath) => processMatch(result, root, filePath, parser));
	// await asyncMap(matches, (filePath) =>
	// 	processMatch(result, root, filePath, parser),
	// );

	return result;
}

/**
 * Creates a theme.json file from the provided directory (defaults to src/theme-json directory) in the root of the project.
 * @returns void
 */
function createThemeJson(path = "src/theme-json") {
	// Combine the JSONC files in the themejson directory into a JSON object
	const themeJson = combineJSONC(path);

	// Write the theme.json file
	let themeJsonObject = JSON.stringify(themeJson, null, 2);
	fs.writeFileSync("theme.json", themeJsonObject);
}

// run themeJson creator
createThemeJson();
