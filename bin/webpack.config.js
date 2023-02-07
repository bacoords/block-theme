const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require('path');

module.exports = {
	...defaultConfig,
	entry: {
		blocks:
	}
	module: {
	  rules: [
		{
		  test: /\.s[ac]ss$/i,
		  use: [
			// Compiles Sass to CSS
			"sass-loader",
		  ],
		},
	  ],
	},
  };