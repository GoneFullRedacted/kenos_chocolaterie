// Gulpfile.js - Streamlined Configuration for Modular LESS
var gulp = require('gulp');
var less = require('gulp-less');
var sourcemaps = require('gulp-sourcemaps');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var plumber = require('gulp-plumber');
var path = require('path');

// Configuration des chemins
// Simplification de la configuration pour un usage plus générique
const paths = {
  less: {
    // La source globale est définie ici, le `base` sera utilisé pour maintenir la structure
    src: './public/assets/styles/Less/**/*.less',
    dest: './public/assets/styles/css/',
    // Les fichiers partiels (commençant par _) sont exclus de la compilation
    ignore: '!./public/assets/styles/Less/**/_*.less'
  }
};

// Gestion des erreurs
function handleError(err) {
  console.log('\n');
  console.log('LESS Error:');
  console.log('File: ' + err.filename);
  console.log('Line: ' + err.line);
  console.log('Column: ' + err.column);
  console.log('Message: ' + err.message);
  console.log('\n');
  this.emit('end');
}

// Tâche de compilation LESS (mode développement)
gulp.task('less', function() {
  return gulp
    // Utilisation de la `src` globale et exclusion des fichiers partiels
    // L'option `base` est cruciale pour conserver la structure des dossiers de sortie.
    .src([paths.less.src, paths.less.ignore], { base: './public/assets/styles/Less/' })
    .pipe(plumber({ errorHandler: handleError }))
    .pipe(sourcemaps.init())
    .pipe(less({
      paths: [path.join(__dirname, 'public/assets/styles/Less')]
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.less.dest));
});

// Tâche de minification pour la production
gulp.task('less:prod', function() {
  return gulp
    // Utilisation de la `src` globale pour la compilation de production
    .src([paths.less.src, paths.less.ignore], { base: './public/assets/styles/Less/' })
    .pipe(plumber({ errorHandler: handleError }))
    .pipe(less({
      paths: [path.join(__dirname, 'public/assets/styles/Less')]
    }))
    .pipe(cleanCSS({
      compatibility: 'ie8',
      level: 2
    }))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.less.dest));
});

// Tâche de surveillance
gulp.task('watch', function() {
  // `watch` surveille tous les fichiers LESS, y compris les partiels
  gulp.watch(paths.less.src, gulp.series('less'));
});

// Tâche par défaut (développement)
gulp.task('default', gulp.series('less', 'watch'));

// Tâche de build pour la production
gulp.task('build', gulp.series('less:prod'));