const gulp = require('gulp');
const replace = require('gulp-string-replace');
const concat = require('gulp-concat');
const rename = require("gulp-rename");
const runSequence = require('run-sequence');
const fs = require('fs');
const config = require('../../../../../mocms/config.json'); // Fetching client config params

gulp.task('custom-modules', (cb) => {
	return runSequence(
		['custom-modules:copy:vue', 'custom-modules:copy:custom'],
	cb);
});

// Copy VUE client components
gulp.task('custom-modules:copy:vue', () => {
    return gulp.src('../../../mocms/components/**/*.vue')
        .pipe(replace(/..\/vendor\/fe\/src\//g, '')) // Replace path for custom-modules to point correctly to CMS modules
        .pipe(replace(/..\/..\/..\/node_modules/g, config.nodeModulesPath))  // Replace path for custom-modules to point correctly from CMS modules to client node_modules
    	.pipe(gulp.dest('./fe/src/custom-components'));
});

// Copy main file of client components
gulp.task('custom-modules:copy:custom', () => {
    return gulp.src('../../../mocms/custom.js')
        .pipe(replace(/\/vendor\/fe\/src/g, ''))  // Replace path for custom-modules to point correctly to CMS modules
        .pipe(replace(/..\/..\/..\/node_modules/g, config.nodeModulesPath))  // Replace path for custom-modules to point correctly from CMS modules to client node_modules
        .pipe(replace(/components\//g, ''))
    	.pipe(gulp.dest('./fe/src/custom-components'));
});