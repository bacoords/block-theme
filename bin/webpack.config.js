const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const path = require("path");

/* ---------------
 * Main config
 * ---------------*/
var config = {
	...defaultConfig,
	entry: {
		"js/scripts": path.resolve(process.cwd(), "src/js", "index.js"),
		"css/editor": path.resolve(process.cwd(), "src/scss", "editor.scss"),
		"css/global": path.resolve(process.cwd(), "src/scss", "global.scss"),
	},
	module: {
		...defaultConfig.module,
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
					},
					{
						loader: "css-loader",
						options: {
							sourceMap: true,
							url: false,
						},
					},
					"sass-loader",
				],
			},
		],
	},
};

// var configGlobalCSS = Object.assign({}, config, {
// 	name: "configCSS",
// 	entry: {

// 	},
// 	output: {
// 		path: path.resolve("./css"),
// 		filename: "[name].css",
// 		chunkFilename: "[name].chunk.js",
// 	},
// 	plugins: [new MiniCssExtractPlugin()],
// 	module: {
// 		rules: [
// 			{
// 				test: /\.s[ac]ss$/i,
// 				use: [
// 					{
// 						loader: MiniCssExtractPlugin.loader,
// 					},
// 					{
// 						// Interprets CSS
// 						loader: "css-loader",
// 						options: {
// 							importLoaders: 2,
// 						},
// 					},
// 					{
// 						loader: "sass-loader", // 将 Sass 编译成 CSS
// 					},
// 				],
// 			},
// 		],
// 	},
// });

// Return Array of Configurations
module.exports = [config];
