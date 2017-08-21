var gulp = require('gulp');
var chug = require('gulp-chug');
var gutil = require('gulp-util');
var concat = require('gulp-concat');

var env = gutil.env.env;
var stage = gutil.env.stage;

var stagePathAdmin = './vendor/phpmob/chang-admin-bundle/Resources/private/gulpfile.js';

if ('dev' === stage) {
    stagePathAdmin = './src/PhpMob/ChangMinBundle/Resources/private/gulpfile.js';
}

gulp.task('theme', function () {
    gulp.src('./app/themes/**/gulpfile.js', {read: false})
        .pipe(chug({
            'tasks': ['default'],
            'args': [
                '--env=' + env,
                '--stage=' + stage
            ]
        }))
    ;
});

gulp.task('default', ['admin', 'theme']);
