const gulp = require('gulp');
const fs = require('fs');

const packageJson = require('../../package.json');

gulp.task("bump-ver", () => {
    const componentFilePath = './dist/js/vendors.js';
	let componentsJsTemp = fs.readFileSync(componentFilePath, 'utf-8');
    let componentJs = componentsJsTemp.replace('%version%', packageJson.version);
    fs.writeFileSync(componentFilePath, componentJs);

    const indexFilePath = './dist/index.html';
	let indexFileTemp = fs.readFileSync(indexFilePath, 'utf-8');
    let indexFile = indexFileTemp.replace(/%version%/g, packageJson.version);
    fs.writeFileSync(indexFilePath, indexFile);
});