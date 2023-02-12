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
		"../src/scss/abstracts/breakpoints": path.resolve(
			process.cwd(),
			"src/theme-json/settings/custom",
			"breakpoints.jsonc",
		),
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.jsonc$/,
				type: "asset/resource",
				generator: {
					filename: "../src/scss/abstracts/[name].scss",
				},
				use: "jsonc-scss-loader",
			},
		],
	},
	resolveLoader: {
		alias: {
			"jsonc-scss-loader": path.resolve(process.cwd(), "bin/jsonc-to-scss.js"),
		},
	},
	output: {
		...defaultConfig.output,
		// change the output path for blocks to the blocks/ folder
		path: path.resolve(process.cwd(), "blocks"),
		assetModuleFilename: "../src/scss/abstracts/[name].scss",
	},
	plugins: [
		new RemovePlugin({
			/**
			 * After compilation permanently removes
			 * the extra `.js`, `.php`, and `.js.map` files in the output folders
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
					{
						folder: "./src/scss/abstracts",
						method: (absoluteItemPath) => {
							return new RegExp(/\.php$/, "m").test(absoluteItemPath);
						},
					},
					{
						folder: "./src/scss/abstracts",
						method: (absoluteItemPath) => {
							return new RegExp(/(\.js)(\.map)*$/, "m").test(absoluteItemPath);
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
