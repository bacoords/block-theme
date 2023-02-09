const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");

module.exports = {
	...defaultConfig,
	entry: {
		scripts: path.resolve(process.cwd(), "src/js", "index.js"),
	},
};
