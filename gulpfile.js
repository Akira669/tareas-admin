'use strict';

const gulp = require('gulp');
const gulpServer = require('gulp-live-server');
const chalk = require('chalk');

gulp.task('default',function(){
	console.log("jalo");
});

gulp.task('develop',['publish','server'],function(){
	console.log(chalk.green('......Iniciando modo development......'));
});

gulp.task('prod',['server'],function(){
	console.log('production');
});

gulp.task('server',function(){
		let server = gulpServer.static('public',8080);
		server.start();
});

gulp.task('publish',['concatCSS','concatJS'],function(){
	gulp.src('src/*.html')
		.pipe(gulp.dest('public'));
});

gulp.task('concatJS',function(){
	gulp.src('resources/js/*.js')
		.pipe(gulp.dest('public'))
});

gulp.task('concatCSS',function(){
	gulp.src('resources/css/*.css')
		.pipe(gulp.dest('public'));
});






