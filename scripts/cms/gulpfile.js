require('./private/tasks.js')(require, {
    "paths": {
        "node": "./node_modules",
        "output": "../../web/assets/cms",
        "src": "./private",
        "js": [
            "{src}/js/boot.js",
            "{src}/app/dist/static/js/*.js",
            "{node}/jquery/dist/jquery.js",
            "{node}/jquery-confirm/dist/jquery-confirm.min.js",
            "{node}/jquery-validation/dist/jquery.validate.js",
            "{node}/jquery-validation/dist/jquery.additional-methods.js",
            "{node}/tether/dist/js/tether.js",
            "{node}/popper.js/dist/umd/popper.js",
            "{node}/bootstrap/dist/js/bootstrap.js",
            "{src}/js/lib/**",
            "{src}/js/partial/**",
            "./js/partial/**",
            "{src}/js/start.js"
        ],
        "sass": [
            "{src}/sass/**",
            "./sass/**"
        ],
        "css": [
            "{node}/animate.css/animate.css",
            "{node}/jquery-confirm/dist/jquery-confirm.min.css",
            "{src}/css/**",
            "./css/**"
        ],
        "copy": [
            ["{output}/img", "./img/**"],
            ["{output}/fonts", "./fonts/**"],
            ["{output}/img", "{src}/img/**"],
            ["{output}/fonts", "{src}/fonts/**"],
            ["{output}/fonts", "{node}/font-awesome/fonts/**"]
        ]
    }
});
