var gulp = require('./private/tasks.js')(require, {
    "paths": {
        "node": "./node_modules",
        "output": "../../web/assets/admin",
        "src": "./private",
        "js": [
            "{src}/js/boot.js",
            "{node}/jquery/dist/jquery.min.js",
            "{node}/tether/dist/tether.min.js",
            "{node}/bootstrap/dist/bootstrap.min.js",
            "{node}/selectize/dist/js/standalone/selectize.min.js",
            "{node}/sortablejs/Sortable.min.js",
            "{node}/pace/pace.min.js",
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
            "{node}/selectize/dist/css/selectize.css",
            "{src}/css/**",
            "./css/**"
        ],
        "copy": [
            ["{output}/img", "./img/**"],
            ["{output}/fonts", "./fonts/**"],
            ["{output}/img", "{src}/img/**"],
            ["{output}/fonts", "{src}/fonts/**"],
            ["{output}/fonts", "{node}/font-awesome/fonts/**"],
            ["{output}/fonts", "{node}/simple-line-icons/fonts/**"],
            ["{output}/flags", "{node}/flag-icon-css/flags/**"]
        ]
    }
});
