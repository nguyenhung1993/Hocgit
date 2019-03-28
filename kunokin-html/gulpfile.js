var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    ejs = require("gulp-ejs"),
    sass = require("gulp-sass"),
    sourcemaps = require('gulp-sourcemaps'),
    minifyCss = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    fs = require('fs');

gulp.task('ejs', function () {
    var tmp_file = './ejs/template.ejs',
        json_file = './ejs/data/pages.json',
        json = JSON.parse(fs.readFileSync(json_file)),
        page_data = json.pages;
    for (var i = 0; i < page_data.length; i++) {
        var bread1 = page_data[i].bread1;
        var bread2 = page_data[i].bread2;
        var bread3 = page_data[i].bread3;
        var bread4 = page_data[i].bread4;
        var bread1_url = page_data[i].bread1_url;
        var bread2_url = page_data[i].bread2_url;
        var bread3_url = page_data[i].bread3_url;
        var BREADCRUMBS = "";
        var id = page_data[i].id,
            parentId1 = page_data[i].parentId1,
            parentId2 = page_data[i].parentId2,
            parentId3 = page_data[i].parentId3,
            parentId4 = page_data[i].parentId4,
            depth = page_data[i].depth,
            RELATIVE_PATH = "";
        if (depth == 0) {
            RELATIVE_PATH = "./"
        } else if (depth == 1) {
            RELATIVE_PATH = "../"
        } else if (depth == 2) {
            RELATIVE_PATH = "../../"
        } else if (depth == 3) {
            RELATIVE_PATH = "../../../"
        } else if (depth == 4) {
            RELATIVE_PATH = "../../../../"
        }
        if (bread1 != "") {
            BREADCRUMBS = "<a href='/recruit/'>ホーム</a> &#xFF1E; <span>" + bread1 + "</span>"
        }
        if (bread2 != "") {
            BREADCRUMBS = "<a href='/recruit/'>ホーム</a> &#xFF1E; <span><a href='" + bread1_url + "'>" + bread1 + "</a></span> &#xFF1E; <span>" + bread2 + "</span>"
        }
        if (bread3 != "") {
            BREADCRUMBS = "<a href='/recruit/'>ホーム</a> &#xFF1E; <span><a href='" + bread1_url + "'>" + bread1 + "</a></span> &#xFF1E; <span><a href='" + bread2_url + "'>" + bread2 + "</a></span> &#xFF1E; <span>" + bread3 + "</span>"
        }
        if (bread4 != "") {
            BREADCRUMBS = "<a href='/recruit/'>ホーム</a> &#xFF1E; <span><a href='" + bread1_url + "'>" + bread1 + "</a></span> &#xFF1E; <span><a href='" + bread2_url + "'>" + bread2 + "</a></span> &#xFF1E; <span><a href='" + bread3_url + "'>" + bread3 + "</a></span> &#xFF1E; <span>" + bread4 + "</span>"
        }
        if (parentId4 != "") {
            parentId1 = parentId1 + "/" + parentId2 + "/" + parentId3 + "/" + parentId4
        } else if (parentId3 != "") {
            parentId1 = parentId1 + "/" + parentId2 + "/" + parentId3
        } else if (parentId2 != "") {
            parentId1 = parentId1 + "/" + parentId2
        }
        gulp.src(tmp_file)
            .pipe(plumber())
            .pipe(ejs({
                pageData: page_data[i],
                RELATIVE_PATH: RELATIVE_PATH,
                BREADCRUMBS: BREADCRUMBS
            }))
            .pipe(rename(id + '.html'))
            .pipe(gulp.dest('./' + parentId1))
    }
});

gulp.task("sass", function () {
    gulp.src("scss/**/*scss")
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(autoprefixer({browsers: ['last 3 versions', 'ie >= 10']}))
        .pipe(minifyCss({advanced: false}))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest("./css"));
});

gulp.task('watch', function () {
    gulp.watch('ejs/**/*.ejs', ['ejs']);
    gulp.watch('scss/*.scss', ['sass']);
});