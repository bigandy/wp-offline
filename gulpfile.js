/* global require */
var gulp = require('gulp'),
	gutil = require('gulp-util'),
	uglify = require('gulp-uglify'),
	concat = require('gulp-concat'),
	eslint = require('gulp-eslint'),
	stripDebug = require('gulp-strip-debug'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifyCSS = require('gulp-minify-css'),
	livereload = require('gulp-livereload'),
	sourcemaps = require('gulp-sourcemaps'),
	scsslint = require('gulp-scss-lint'),
	phpcs = require('gulp-phpcs'),
	cheerio = require('gulp-cheerio'),
	svgStore = require('gulp-svgstore'),
	svgmin = require('gulp-svgmin');

gulp.task('sprites', function () {
	return gulp.src([
			'images/svg/*.svg'
		])
		.pipe(svgStore({ inlineSvg: true }))

		.pipe(cheerio(function ($) {
			$('svg').attr('class',  'svg-sprite');
		}))
		.pipe(svgmin({
			plugins:
				[{
					cleanupIDs: false
				}]
			}))
		.pipe(gulp.dest('build/images/svg'));
});

// for use in css background images or inline within <img />.
gulp.task('svg-min', function () {
	return gulp.src('images/svg/*.svg')
		.pipe(svgmin())
		.pipe(gulp.dest('build/images/svg'));
});

gulp.task('png-min', function () {
	return gulp.src('images/*.png')
		.pipe(imagemin({
			use: [pngquant()]
		}))
		.pipe(gulp.dest('build/images/png'));
});

// concat and minify the js
gulp.task('js', ['js-lint'], function () {
	gulp.src([
			'bower_components/foundation/js/foundation/foundation.js',
			'js/main.js',
		])
		.pipe(uglify().on('error', gutil.log))
		.pipe(concat('script.min.js'))
		.pipe(gulp.dest('build/js'))
		.pipe(livereload());
});

gulp.task('js-lint', function() {
	gulp.src([
			'js/main.js'
		])
		.pipe(eslint())
		.pipe(eslint.format());
});

// sass
gulp.task('sass', function () {
	gulp.src('./scss/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
				includePaths: ['bower_components/foundation/scss'],
				errLogToConsole: true,
				outputStyle: 'compressed'
			})
			.on('error', sass.logError))
		.pipe(autoprefixer({
			browsers: 'IE 9, last 2 versions'
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('.'))
		.pipe(livereload());
});

// Production sass
gulp.task('sass-production', function () {
	gulp.src('./scss/**/*.scss')
		.pipe(sass({
			includePaths: ['bower_components/foundation/scss'],
			errLogToConsole: true,
			outputStyle: 'compressed'
			})
			.on('error', sass.logError))
		.pipe(gulp.dest('.'));
});

gulp.task('scss-lint', function () {
	gulp.src([
			'scss/**/*.scss',
			'!scss/style.scss' // ignore this file so can include commenting in it.
		])
		.pipe(scsslint({
			'config': '.scss-lint.yml',
		}));
});

gulp.task('wordpress-lint', function () {
	return gulp.src([
			'./**/*.php',
			'!lib/tlc-transients/*',
			'!functions/metaboxes.php',
			'!node_modules/**/*.php'
		])
		.pipe(phpcs({
			standard: 'code.ruleset.xml'
		}))
		.pipe(phpcs.reporter('log'));
});

// Rerun the task when a file changes
gulp.task('watch', function () {
	gulp.watch('js/**/*', ['js']);
	gulp.watch('scss/**/*', ['sass', 'scss-lint']);
	gulp.watch('images/svg/*.svg', ['sprites', 'svg-min']);
	gulp.watch('images/*.png', ['png-min']);

	gulp.watch('**/*.php').on('change', function(file) {
		livereload.changed(file.path);
	});

	livereload.listen();
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', [
	'js',
	'watch',
	'sprites'
]);

// Run `gulp lint` to lint all your code
gulp.task('lint', [
	'scss-lint',
	'js-lint',
	'wordpress-lint',
]);

gulp.task('deploy', [
	'lint', // makes sure that your code passes the tests
	'js-production',
	'sass-production',
]);
