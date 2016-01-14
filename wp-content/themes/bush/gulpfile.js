// production? true/false
var is_prod = false;

// require dependencies
var gulp         = require('gulp'),
    rename       = require('gulp-rename'),
    compass      = require('gulp-compass'),
    autoprefix   = require('gulp-autoprefixer'),
    uglify       = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    watch = require('gulp-watch'),
    livereload = require('gulp-livereload');

// task
gulp.task('default', [
    'scripts',
    'images',
    'compass',
    'watch',
]);

// compass
gulp.task('compass', function() {
    gulp.src('./scss/**/*.scss')
        .pipe(compass({
            sass: 'scss',
            css: 'stylesheets',
            font: 'font',
            javascript: 'js',
            image: 'images',
            import_path: [
                'bower_components/foundation-sites/scss',
            ],
            style: is_prod ? 'compressed' : 'nested',
            comments: !is_prod,
            source_map: !is_prod,
            time: true
        }))
        .pipe(autoprefix('last 4 version'))
        .pipe(gulp.dest('stylesheets'))
        .pipe(livereload());
});

// javascript
gulp.task('scripts', function() {
    gulp.src('js/app.js')
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest('js'))
        .pipe(livereload());
});

// images
gulp.task('images', function() {
    gulp.src([
            '!images/**/*.min.{png,jpg,gif,svg}',
            'images/**/*.{png,jpg,gif,svg}'
        ])
        .pipe(rename({ suffix: '.min' }))
        .pipe(imagemin({
            optimizationLevel: 7,
            progressive: true,
            interlaced: true,
            multipass: true
        }))
        .pipe(gulp.dest('images'))
        .pipe(livereload());
});

//watch
gulp.task('watch', function() {
    livereload.listen();
    gulp.watch('scss/**/*.scss', ['compass']);
    gulp.watch('js/app.js', ['scripts']);
    gulp.watch([
        '!images/**/*.min.{png,jpg,gif,svg}',
        'images/**/*.{png,jpg,gif,svg}'
    ], ['images']);
});