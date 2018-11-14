var webpack = require( 'webpack' );
var path = require( 'path' );
var MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    mode: 'production',
    devtool: 'source-map',
    entry: {
        'backend': ['./src/main-backend.js', './src/scss/main-backend.scss'],
    },
    output: {
        path: path.resolve( __dirname, 'dist' ),
        filename: 'bears-import-demo-[name].bundle.js',
    },
    plugins: [
        new MiniCssExtractPlugin({
          // Options similar to the same options in webpackOptions.output
          // both options are optional
          filename: "./css/bears-import-demo-[name].css",
          chunkFilename: "./css/bears-import-demo-[id].css"
        })
    ],
    module: {
        rules: [
          {
            test: /\.scss$/,
            use: [
                MiniCssExtractPlugin.loader,
                { loader: 'css-loader', options: { url: false, sourceMap: true } },
                { loader: 'sass-loader', options: { sourceMap: true } }
            ]
          }
        ]
    }

}