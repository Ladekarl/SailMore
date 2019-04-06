'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var php = require('gulp-connect-php');
var browserSync = require('browser-sync').create();

gulp.task('sass', function () {
    return gulp.src('sass/**/*.scss') // Gets all files ending with .scss in app/scss
        .pipe(sass())
        .pipe(gulp.dest(''))
        .pipe(browserSync.reload({
            stream: true
        }))
});

gulp.task('php', function () {
    php.server({base: './', port: 80, keepalive: true});
});

gulp.task('browserSync', function () {
    browserSync.init({
        proxy: 'sailmore',
        baseDir: './',
        open: true,
        notify: false
    });
});

gulp.task('dev', ['sass', 'browserSync'], function () {
    gulp.watch('sass/**/*.scss', ['sass']);
    gulp.watch('./**/*.php', browserSync.reload);
});