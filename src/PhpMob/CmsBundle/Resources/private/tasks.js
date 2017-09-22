module.exports = function (require, config) {
    var gulp = require('gulp');
    var gulpif = require('gulp-if');
    var uglify = require('gulp-uglify');
    var uglifycss = require('gulp-uglifycss');
    var concat = require('gulp-concat');
    var sass = require('gulp-sass');
    var sourcemaps = require('gulp-sourcemaps');
    var order = require('gulp-order');
    var merge = require('merge-stream');
    var gutil = require('gulp-util');
    var fs = require('fs');
    var livereload = require('gulp-livereload');

    /**
     * @param file
     *
     * @return {Object}
     */
    var loadConfig = function (file) {
        return JSON.parse(String(fs.readFileSync(file)));
    };

    // TODO: parse with recucive
    var parseConfig = function (data) {
        var holders = {};
        var config = JSON.stringify(data);

        for (var k in data['paths']) {
            holders['{' + k + '}'] = data['paths'][k];
        }

        return JSON.parse(config.replace(/\{\w+\}/g, function (all) {
            return holders[all] || all;
        }));
    };

    var isProd = gutil.env.env === 'prod';
    var buildFile = function (name, ext) {
        if (isProd) {
            return name + '.min.' + ext;
        }

        return name + '.' + ext;
    };

    if (!config) {
        config = './private/config.yml.dist'
    }

    if (typeof config === 'string') {
        config = loadConfig(config);
    }

    config = parseConfig(config);

    gulp.task('script', function () {
        gulp.src(config['paths'].js)
            .pipe(concat(buildFile('app', 'js')))
            .pipe(gulpif(isProd, uglify()))
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(config['paths'].output + '/js'))
        ;
    });

    gulp.task('style', function () {
        var cssStream = gulp.src(config['paths'].css)
            .pipe(concat('css-files.css'))
        ;

        var sassStream = gulp.src(config['paths'].sass)
            .pipe(sass())
            .pipe(concat('sass-files.scss'))
        ;

        return merge(cssStream, sassStream)
            .pipe(order(['css-files.css', 'sass-files.scss']))
            .pipe(concat(buildFile('style', 'css')))
            .pipe(gulpif(isProd, uglifycss()))
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(config['paths'].output + '/css'))
            ;
    });

    gulp.task('copy', function () {
        for (var i = 0; i < config['paths'].copy.length; i++) {
            var copy = config['paths'].copy[i];
            gulp.src(copy[1]).pipe(gulp.dest(copy[0]));
        }
    });

    gulp.task('watching', function () {
        livereload.listen();

        gulp.watch(config['paths'].js, ['script']);
        gulp.watch(config['paths'].sass, ['style']);
        gulp.watch(config['paths'].css, ['style']);
    });

    gulp.task('default', ['script', 'style', 'copy']);
    gulp.task('watch', ['default', 'watching']);

    return gulp;
};
