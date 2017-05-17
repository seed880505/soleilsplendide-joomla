var gulp = require('gulp'),
	sass = require('gulp-ruby-sass'),
	sourcemaps = require('gulp-sourcemaps'),
	gutil = require('gulp-util'),
	cleanCSS = require('gulp-clean-css'),
	uglify = require('gulp-uglify'),
	concat = require('gulp-concat'),
	autoprefixer = require('gulp-autoprefixer'),
	rename = require('gulp-rename');

gulp.task('sass', function () {
	return sass('templates/soleil/scss/soleil.scss', {sourcemap: true})
	.on('error', sass.logError)
	.pipe(autoprefixer({browsers: ['last 2 versions']}))
	.pipe(gulp.dest('templates/soleil/css'))
	.pipe(cleanCSS())
	.pipe(rename({suffix: '.min'}))
	.pipe(sourcemaps.write('.', {includeContent: false, sourceRoot: ''}))
	.pipe(gulp.dest('templates/soleil/css'));
});
gulp.task('bootstrap', function () {
	return sass('templates/soleil/scss/bootstrap.scss', {sourcemap: true})
	.on('error', sass.logError)
	.pipe(autoprefixer({browsers: ['last 2 versions']}))
	.pipe(gulp.dest('templates/soleil/css'))
	.pipe(cleanCSS())
	.pipe(rename({suffix: '.min'}))
	.pipe(sourcemaps.write('.', {includeContent: false, sourceRoot: ''}))
	.pipe(gulp.dest('templates/soleil/css'));
});
gulp.task('bootstrap-responsive', function () {
	return sass('templates/soleil/scss/bootstrap-responsive.scss', {sourcemap: true})
	.on('error', sass.logError)
	.pipe(autoprefixer({browsers: ['last 2 versions']}))
	.pipe(gulp.dest('templates/soleil/css'))
	.pipe(cleanCSS())
	.pipe(rename({suffix: '.min'}))
	.pipe(sourcemaps.write('.', {includeContent: false, sourceRoot: ''}))
	.pipe(gulp.dest('templates/soleil/css'));
});
gulp.task('font', function () {
	return sass('templates/soleil/scss/font.scss', {sourcemap: true})
	.on('error', sass.logError)
	.pipe(autoprefixer({browsers: ['last 2 versions']}))
	.pipe(gulp.dest('templates/soleil/css'))
	.pipe(cleanCSS())
	.pipe(rename({suffix: '.min'}))
	.pipe(sourcemaps.write('.', {includeContent: false, sourceRoot: ''}))
	.pipe(gulp.dest('templates/soleil/css'));
});

gulp.task('compress', function () {
	return gulp.src('templates/soleil/js/*.js')
	.pipe(concat('soleil.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('templates/soleil/js'));
});

gulp.task('default', ['bootstrap', 'bootstrap-responsive', 'font', 'sass', 'compress'], function () {
	console.log('Compiled!!!');
});

gulp.task('watch', ['default'], function () {
	gulp.watch('templates/soleil/scss/bootstrap.scss', ['bootstrap']);
	gulp.watch('templates/soleil/scss/bootstrap-responsive.scss', ['bootstrap-responsive']);
	gulp.watch('templates/soleil/scss/font.scss', ['font']);
	gulp.watch('templates/soleil/scss/conf.scss', ['sass']);
	gulp.watch('templates/soleil/scss/soleil.scss', ['sass']);
	console.log('watching...');
});


