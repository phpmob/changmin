require('./private/tasks.js')(require, {
    "paths": {
        "output": "../../web/assets/account",
        "js": [
            "./js/partial/**",
            "./js/start.js"
        ],
        "sass": [
            "./sass/**"
        ],
        "css": [
            "./css/**"
        ],
        "copy": [
            ["{output}/img", "./img/**"],
            ["{output}/fonts", "./fonts/**"]
        ]
    }
});
