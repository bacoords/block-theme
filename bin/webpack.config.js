const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const RemovePlugin = require("remove-files-webpack-plugin");
const path = require("path");

/**
 * Custom Webpack Configuration
 *
 * Adds the ability to compile extra scripts and CSS files for the theme.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-scripts/#webpack-config
 */
var config = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		"../js/scripts": path.resolve(process.cwd(), "src/js", "index.js"),
		"../css/editor": path.resolve(process.cwd(), "src/scss", "editor.scss"),
		"../css/global": path.resolve(process.cwd(), "src/scss", "global.scss"),
	},

	output: {
		...defaultConfig.output,
		// change the output path for blocks to the blocks/ folder
		path: path.resolve(process.cwd(), "blocks"),
	},
	plugins: [
		new RemovePlugin({
			/**
			 * After compilation permanently removes
			 * the extra .js and .php files in the css folder
			 */
			after: {
				test: [
					{
						folder: "./css",
						method: (absoluteItemPath) => {
							return new RegExp(/\.js/, "m").test(absoluteItemPath);
						},
					},
					{
						folder: "./css",
						method: (absoluteItemPath) => {
							return new RegExp(/\.php$/, "m").test(absoluteItemPath);
						},
					},
				],
			},
		}),
		...defaultConfig.plugins,
	],
};

// Return Configuration
module.exports = config;
