'use strict';

// -----------------------------------------------------------------------------
// Dependencies
// -----------------------------------------------------------------------------
var p = require('./package.json');
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var zip = require('gulp-zip');
var gulpIgnore = require('gulp-ignore');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var livereload = require('gulp-livereload');
var svgSymbols = require('gulp-svg-symbols');
var sourcemaps = require('gulp-sourcemaps');
var filter = require('gulp-filter');


// -----------------------------------------------------------------------------
// Configuration
// -----------------------------------------------------------------------------

// var themeNameSlug = 'OriginTheme';
var themeNameSlug = p.name;
var svgInput = './src/svg/*.svg';
var sassInput = './src/scss/**/*.scss';
var sassOutput = './dist/';
var autoprefixerOptions = { browsers: ['last 2 versions', '> 5%', 'Firefox ESR'] };

var jsInput = './src/js/**.js';

var jsPlugins = [
  'src/js/utils.js',
  'src/js/app.js'
];


// -----------------------------------------------------------------------------
// Sass compilation
// -----------------------------------------------------------------------------

gulp.task('sass', function () {
  return gulp
    .src(sassInput)
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(rename('app.min.css'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(sassOutput))
    .pipe(filter("**/*.css"))
    .pipe(livereload());
});


// -----------------------------------------------------------------------------
// SVG Sprite
// -----------------------------------------------------------------------------

gulp.task('svg_sprite', function () {
  return gulp.src(svgInput)
    .pipe(svgSymbols())
    .pipe(gulp.dest('dist'));
});


// -----------------------------------------------------------------------------
// Concat JS files
// -----------------------------------------------------------------------------

gulp.task('scripts', function(){
  return gulp.src(jsPlugins)
    .pipe(concat('app.js'))
    .pipe(gulp.dest('dist'))
    .pipe(rename('app.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('dist'))
    .pipe(livereload());
});


// -----------------------------------------------------------------------------
// Watchers
// -----------------------------------------------------------------------------

gulp.task('watch', function() {
  livereload.listen();

  gulp.watch([sassInput], ['sass'])
    .on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });

  gulp.watch([jsInput], ['scripts'])
    .on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });

  gulp.watch([svgInput], ['svg_sprite'])
    .on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });
});


// -----------------------------------------------------------------------------
// Production build
// -----------------------------------------------------------------------------

gulp.task('release', function () {
  return gulp.src(['**/*', '!' + themeNameSlug + '.zip', '!./node_modules', '!./node_modules/**', '!.git'])
    .pipe(zip(themeNameSlug + '.zip'))
    .pipe(gulp.dest('./'));
});


// -----------------------------------------------------------------------------
// Build task
// -----------------------------------------------------------------------------

gulp.task('build', ['svg_sprite', 'sass', 'scripts']);


// -----------------------------------------------------------------------------
// Default task
// -----------------------------------------------------------------------------

gulp.task('default', ['svg_sprite', 'sass', 'scripts', 'watch']);
