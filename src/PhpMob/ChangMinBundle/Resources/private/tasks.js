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

    if (!config) {
        config = './private/config.yml.dist'
    }

    if (typeof config === 'string') {
        config = loadConfig(config);
    }

    config = parseConfig(config);

    gulp.task('codemirror', function () {
        var paths = [
            config.paths.node + '/codemirror/lib/codemirror.js',
            config.paths.node + '/codemirror/mode/twig/twig.js',
            config.paths.node + '/codemirror/mode/xml/xml.js',
            config.paths.node + '/codemirror/mode/yaml/yaml.js',
            config.paths.node + '/codemirror/mode/css/css.js',
            config.paths.node + '/codemirror/mode/javascript/javascript.js',
        ];

        gulp.src(paths)
            .pipe(concat('codemirror.js'))
            .pipe(gulpif(isProd, uglify()))
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(config['paths'].output + '/js'))
        ;

        gulp.src(config.paths.node + '/codemirror/lib/codemirror.css')
            .pipe(gulpif(isProd, uglifycss()))
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(config['paths'].output + '/css'))
        ;
    });

    gulp.task('script', function () {
        gulp.src(config['paths'].js)
            .pipe(concat('app.js'))
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
            .pipe(concat('style.css'))
            .pipe(gulpif(isProd, uglifycss()))
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(config['paths'].output + '/css'))
            ;
    });

    gulp.task('copy', function () {
        var i = 0, howManyTimes = config['paths'].copy.length;
        function f() {
            var copy = config['paths'].copy[i];
            gulp.src(copy[1]).pipe(gulp.dest(copy[0]));
            i++;
            if( i < howManyTimes ){
                setTimeout( f, 200 );
            }
        }
        f();
    });

    gulp.task('watching', function () {
        livereload.listen();

        gulp.watch(config['paths'].js, ['script']);
        gulp.watch(config['paths'].sass, ['style']);
        gulp.watch(config['paths'].css, ['style']);
    });

    gulp.task('default', ['codemirror', 'script', 'style', 'copy']);
    gulp.task('watch', ['default', 'watching']);

    return gulp;
};
