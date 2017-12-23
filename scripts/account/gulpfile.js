require('../cms/private/tasks.js')(require, {
    "paths": {
        "node": "./node_modules",
        "output": "../../web/assets/account",
        "js": [
            "{node}/croppie/croppie.js",
            "./js/partial/**",
            "./js/start.js"
        ],
        "sass": [
            "./sass/**"
        ],
        "css": [
            "{node}/croppie/croppie.css",
            "./css/**"
        ],
        "copy": [
            ["{output}/img", "./img/**"],
            ["{output}/fonts", "./fonts/**"]
        ]
    }
});
