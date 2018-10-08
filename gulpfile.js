var elixir = require('laravel-elixir');
var gulp = require('gulp');
var fs = require('fs');
var obfuscate = require('gulp-obfuscate');
var file = require('gulp-file');
var rename = require('gulp-rename');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
});

gulp.task('prueba',function(){

    console.log("Launching obfuscation...");
    var options = Array();
    options["exclude"] = Array('pause','amount','break', 'case', 'catch', 'continue',
                        'debugger', 'default', 'delete', 'do', 'else', 'finally', 'for',
                        'function', 'if', 'in', 'instanceof', 'new', 'return', 'switch',
                        'this', 'throw', 'try', 'typeof', 'var', 'void', 'while',
                        'with', 'prototype', 'null', 'true', 'false', 'NaN',
                        'undefined', 'Infinity', 'ಠ_ಠ', 'H͇̬͔̳̖̅̒ͥͧẸ̖͇͈͍̱̭̌͂͆͊_C͈OM̱̈́͛̈ͩ͐͊ͦEͨ̓̐S̬̘͍͕͔͊̆̑̈́̅');

    return gulp.src('./public/js/pacman.js.bk')
                    .pipe(obfuscate(options))
                    .pipe(rename('pacman.js'))
                    .pipe(gulp.dest('./public/js/'));

});

gulp.task('uglify', function() {
    var result = UglifyJS.minify("prueba.js");
    fs.writeFile('_uglify.js', result.code);
});
