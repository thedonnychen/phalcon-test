const Path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");
const UglifyJsPlugin          = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

module.exports = {
	entry: './src/js/main.js',
	output: {
		path: Path.resolve(__dirname, 'dist'),
		filename: 'amplus.bundle.min.js',
		publicPath: "/dist"
	},
	optimization: {
		minimizer: [
			new UglifyJsPlugin({
				cache    : true,
				parallel : true,
				sourceMap: true   // set to true if you want JS source maps
			}),
			new OptimizeCSSAssetsPlugin({})
		]
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: "amplus.bundle.min.css"
		})
	],
	module: {
		rules: [
			{
				test   : /\.js$/,
				exclude: /node_modules/,
				use    : {
					loader: "babel-loader"
				}
			},
			{
				test: /\.(sass|scss)$/,
				use: [
					MiniCssExtractPlugin.loader, // creates style nodes from JS strings
					{
						loader: "css-loader", // translates CSS into CommonJS
						options: { url: false, sourceMap: false }
					},
					{
						loader: "postcss-loader"
					},
					{
						loader: "sass-loader", // compiles Sass to CSS
						options: { sourceMap: false }
					}
				]
			}
		],
	}
};