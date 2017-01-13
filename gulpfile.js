var gulp = require("gulp");
var sass = require("gulp-sass");

gulp.task('sass', function() {
    return gulp.src('./src/NoInc/SimpleStorefrontBundle/Resources/public/scss/styles.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./web/css'));
});

gulp.task('default', ['sass'], function() {
    gulp.watch('./src/NoInc/SimpleStorefrontBundle/Resources/public/scss/*.scss', ['sass']);
    gulp.watch('./src/NoInc/SimpleStorefrontBundle/Resources/public/scss/_*.scss', ['sass']);
    gulp.watch('./src/NoInc/SimpleStorefrontBundle/Resources/public/scss/**/*.scss', ['sass']);
});
