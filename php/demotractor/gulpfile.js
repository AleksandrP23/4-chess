const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();
const del = require('del');

// Пути к файлам
const paths = {
    scss: {
        src: 'assets/scss/**/*.scss',
        dest: 'assets/css/'
    },
    js: {
        src: 'assets/js/src/**/*.js',
        dest: 'assets/js/'
    },
    html: 'templates/**/*.php'
};

// Очистка директории сборки
function clean() {
    return del(['assets/css/style.min.css', 'assets/js/script.min.js']);
}

// Компиляция SCSS в CSS
function styles() {
    return gulp.src(paths.scss.src)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(cleanCSS())
        .pipe(concat('style.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.scss.dest))
        .pipe(browserSync.stream());
}

// Сборка и минификация JS
function scripts() {
    return gulp.src(paths.js.src)
        .pipe(sourcemaps.init())
        .pipe(concat('script.min.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.js.dest))
        .pipe(browserSync.stream());
}

// Запуск сервера разработки
function serve() {
    browserSync.init({
        proxy: 'localhost', // Замените на ваш локальный хост UMI.CMS
        port: 3000
    });

    // Отслеживание изменений
    gulp.watch(paths.scss.src, styles);
    gulp.watch(paths.js.src, scripts);
    gulp.watch(paths.html).on('change', browserSync.reload);
}

// Отслеживание изменений файлов
function watchFiles() {
    gulp.watch(paths.scss.src, styles);
    gulp.watch(paths.js.src, scripts);
}

// Экспорт задач
exports.clean = clean;
exports.styles = styles;
exports.scripts = scripts;
exports.serve = serve;
exports.watch = watchFiles;

// Основные команды
exports.build = gulp.series(clean, gulp.parallel(styles, scripts));
exports.dev = gulp.series(exports.build, serve);
exports.default = exports.build;