var gulp = require("gulp");
var gutil = require("gulp-util");
var webpack = require("webpack");
var webpackConfig = require("./webpack.config.js");
var execSync = require('child_process').execSync;

var bootstrap = function() {
    gutil.log("bootstrapping");
    execSync('php bootstrap.php');
}

gulp.task("default", ["webpack:build-dev"], function() {
    gulp.watch(["admin/assets/**/*"], ["webpack:build-dev"]);
    // gulp.watch([
        // "src/assets/css/**/*", 
        // "admin/assets/css/**/*"], [""])
});

// Production build
gulp.task("build", ["webpack:build"]);

gulp.task("webpack:build", function(callback) {
    // modify some webpack config options
    var myConfig = Object.create(webpackConfig).map(function(config) {
        config.plugins = config.plugins.concat(
            new webpack.DefinePlugin({
                "process.env": {
                    // This has effect on the react lib size
                    "NODE_ENV": JSON.stringify("production")
                }
            }),
            new webpack.optimize.DedupePlugin(),
            new webpack.optimize.UglifyJsPlugin()
        );

        return config;
    });

    // run webpack
    webpack(myConfig, function(err, stats) {
        if(err) throw new gutil.PluginError("webpack:build", err);
        gutil.log("[webpack:build]", stats.toString({
            colors: true
        }));

        bootstrap();
        callback();
    });
});

// modify some webpack config options
var myDevConfig = Object.create(webpackConfig).map(function(config) {
    config.devtool = "sourcemap";
    config.debug = true;
    
    return config;
});

// create a single instance of the compiler to allow caching
var devCompiler = webpack(myDevConfig);

gulp.task("webpack:build-dev", function(callback) {
    // run webpack
    devCompiler.run(function(err, stats) {
        if(err) throw new gutil.PluginError("webpack:build-dev", err);
        gutil.log("[webpack:build-dev]", stats.toString({
            colors: true
        }));

        bootstrap();
        callback();
    });
});
