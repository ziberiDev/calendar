const path = require('path');

module.exports = {
    mode: "development",
    entry: './resources/js/app.js',
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: "app.js",
        publicPath: "/"
    },
    watchOptions: {
        stdin: true
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                enforce: "pre",
                use: ['style-loader', 'css-loader', "source-map-loader"]
            }
        ],
    },
}