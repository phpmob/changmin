var gulp = require('./private/tasks.js')(require, {
    "paths": {
        "node": "./node_modules",
        "output": "../../web/assets/admin",
        "src": "./private",
        "js": [
            "{src}/js/boot.js",
            "{src}/app/dist/static/js/*.js",
            "{node}/jquery/dist/jquery.js",
            "{node}/jquery-confirm/dist/jquery-confirm.min.js",
            "{node}/pace-progress/pace.js",
            "{node}/tether/dist/js/tether.js",
            "{node}/popper.js/dist/umd/popper.js",
            "{node}/bootstrap/dist/js/bootstrap.js",
            "{node}/selectize/dist/js/standalone/selectize.min.js",
            "{node}/sortablejs/Sortable.min.js",
            "{node}/table-resizer/table-resize.js",
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
            "{node}/jquery-confirm/dist/jquery-confirm.min.css",
            "{node}/pace-progress/themes/blue/pace-theme-center-simple.css",
            "{node}/selectize/dist/css/selectize.css",
            "{node}/table-resizer/table-resize.css",
            "{src}/css/**",
            "./css/**"
        ],
        "copy": [
            ["{output}/img", "./img/**"],
            ["{output}/fonts", "./fonts/**"],
            ["{output}/img", "{src}/img/**"],
            ["{output}/fonts", "{src}/fonts/**"],
            ["{output}/fonts", "{src}/photon/fonts/**"],
            ["{output}/fonts", "{node}/font-awesome/fonts/**"],
            ["{output}/fonts", "{node}/simple-line-icons/fonts/**"],
            ["{output}/flags", "{node}/flag-icon-css/flags/**"]
        ]
    }
});
