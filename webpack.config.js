module.exports = [
    // admin
    {
        entry: './admin/assets/js/index.js',
        output: {
            filename: 'bundle.js',
            path: './src/assets/js/admin/'
        },
        plugins: [],
        loaders: []
    }
    // static
    // {
    //     entry: './assets/js/index.js',
    //     output: {
    //         filename: 'bundle.js',
    //         path: './src/assets/js'
    //     }
    // }
]