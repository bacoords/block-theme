const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const RemovePlugin = require("remove-files-webpack-plugin");
const path = require("path");
const { getEntries } = require("./get-entries");
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
		...getEntries({ root: "src/js", include: "*.js", outputFolder: "js" }),
		...getEntries({
			root: "src/scss",
			include: "*.scss",
			outputFolder: styleOutputFolder,
		}),
		...getEntries({
			root: "src/scss/blocks",
			include: "**/*.scss",
			outputFolder: styleOutputFolder,
			blockDir: true,
		}),
		"../src/scss/utils/breakpoints": path.resolve(
			process.cwd(),
			"src/theme-json/settings/custom",
			"breakpoints.jsonc",
		),
		"../theme.json": path.resolve(
			process.cwd(),
			"src/theme-json",
			"index.jsonc",
		),
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.jsonc$/,
				exclude: /theme-json\/index\.jsonc$/,
				type: "asset/resource",
				generator: {
					filename: "../src/scss/utils/[name].scss",
				},
				use: "jsonc-scss-loader",
			},
			{
				test: /theme-json\/index\.jsonc$/,
				type: "asset/resource",
				generator: {
					filename: "../theme.json",
				},
				use: "theme-json-loader",
			},
		],
	},
	resolveLoader: {
		alias: {
			"jsonc-scss-loader": path.resolve(process.cwd(), "bin/jsonc-to-scss.js"),
			"theme-json-loader": path.resolve(process.cwd(), "bin/theme-json.js"),
		},
	},
	output: {
		...defaultConfig.output,
		// change the output path for blocks to the blocks/ folder
		path: path.resolve(process.cwd(), "blocks"),
		assetModuleFilename: "../src/scss/utils/[name].scss",
	},
	plugins: [
		new RemovePlugin({
			/**
			 * After compilation permanently removes
			 * the extra `.js`, `.php`, and `.js.map` files in the output folders
			 */

			after: {
				log: false,
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
					{
						folder: "./src/scss/utils",
						method: (absoluteItemPath) => {
							return new RegExp(/\.php$/, "m").test(absoluteItemPath);
						},
					},
					{
						folder: "./src/scss/utils",
						method: (absoluteItemPath) => {
							return new RegExp(/(\.js)(\.map)*$/, "m").test(absoluteItemPath);
						},
					},
					{
						folder: ".",
						method: (absoluteItemPath) => {
							return new RegExp(/(json\.js)(\.map)*$/, "m").test(
								absoluteItemPath,
							);
						},
					},
					{
						folder: ".",
						method: (absoluteItemPath) => {
							return new RegExp(/theme\.json\.asset\.php$/, "m").test(
								absoluteItemPath,
							);
						},
					},
				],
			},
		}),
		...defaultConfig.plugins,
	],
	cache: false,
};

// Return Configuration
module.exports = config;
