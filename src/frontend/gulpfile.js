var gulp          = require('gulp');
var notify        = require('gulp-notify');

var browserSync = 	require('browser-sync').create();

var sass = 			require('gulp-sass');
var autoprefixer = 	require('gulp-autoprefixer');
var gcmq = 			require('gulp-group-css-media-queries'); 
var cleanCSS = 		require('gulp-clean-css');
var cssmin        = require('gulp-cssmin');
var rename        = require('gulp-rename');

var include       = require('gulp-include');
var minify        = require('gulp-minify');
var exec          = require('child_process').exec;


let autoprefixBrowsers = ['> 1%', 'last 15 versions', 'firefox >= 4', 'safari 7', 'safari 8', 'IE 8', 'IE 9', 'IE 10', 'IE 11'];

gulp.task('browser-sync', function() {
	browserSync.init({
		proxy: 'http://172.18.178.227:31554/',
        notify: false,
        open: false,
	});
});

gulp.task('default', gulp.series('browser-sync'));

gulp.watch('./app/Views/**/*.scss')
    .on('change', function(path, stats) {
        setTimeout(function(){
            return browserSync.reload();
        }, 3000);
        setTimeout(function(){
            return gulp.src('app/Views/main.scss')
                .pipe(sass())
                .pipe(autoprefixer({
                    cascade: false
                }))
                .pipe(gcmq())
                .pipe(cleanCSS({
                    level: {
                        1: {
                            all: false,
                        }
                    },
                    format: 'beautify'
                }))
                .on('error', notify.onError(
                    {
                        mesage: "<%= error.message %>",
                        title : "Sass Error!"
                    }
                ))
                .pipe(cssmin())
                .pipe(gulp.dest('./public/static/css'))
                .pipe(browserSync.stream())
                .pipe(exec('php spark frontent:changeVersionFiles'));

        }, 1000);
    });
    
gulp.watch('./app/Views/**/*.php')
    .on('change', function () {
        setTimeout(function(){
            return browserSync.reload();
        }, 2000);
    });

    
gulp.watch('./app/Views/**/*.js')
    .on('change', function (a) {
        if(a == 'app/Views/modules/includeJs/main.js'
        || a == 'app\\Views\\modules\\includeJs\\main.js'){return false;}

        setTimeout(function(){
            return browserSync.reload();
        }, 2000);
        setTimeout(function(){
            gulp.src('app/Views/modules/includeJs/include.txt')
                .pipe(include({
                    extensions: 'js',
                }))
                .pipe(rename("main.js"))
                .pipe(gulp.dest('app/Views/modules/includeJs'))
                .pipe(browserSync.stream());
        }, 1000);

    });
    
gulp.watch('./app/Views/modules/includeJs/main.js')
    .on('change', function () {
        setTimeout(function(){
            return browserSync.reload();
        }, 2000);
        gulp.src('app/Views/modules/includeJs/main.js')
            .pipe(minify())
            .pipe(gulp.dest('./public/static/js'))
            .pipe(browserSync.stream())
            .pipe(exec('php spark frontent:changeVersionFiles'));
            
    });