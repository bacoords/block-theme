const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const RemovePlugin = require("remove-files-webpack-plugin");
const path = require("path");
const { getStyleEntries } = require("./get-style-entries");
const { getScriptEntries } = require("./get-script-entries");
// styleOutputFolder should be relative to the root of the theme with no leading or trailing slashes
const styleOutputFolder = "css";
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
		...getScriptEntries({ outputFolder: "js" }),
		...getStyleEntries({ outputFolder: styleOutputFolder }),
	},
	module: {
		...defaultConfig.module,
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
						folder: styleOutputFolder,
						method: (absoluteItemPath) => {
							return new RegExp(/\.js/, "m").test(absoluteItemPath);
						},
					},
					{
						folder: styleOutputFolder,
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
