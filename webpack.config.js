const path = require('path');

module.exports = {
    mode: "development",
    entry: './resources/js/app.js',
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: "app.js",
        publicPath: "/"
    },
    watch: false,
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    }
}