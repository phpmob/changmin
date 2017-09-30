(function (factory) {
    "use strict";

    if (typeof define === "function" && define.amd) {
        define(["jquery"], factory);
    }
    else {
        /* jshint sub:true */
        factory(jQuery);
    }
})(function ($) {
    "use strict";

    var animationEnd = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";

    $.fn.animate = function (name) {
        var animationName = "animated " + name;
        this
            .addClass(animationName)
            .one(animationEnd, function () {
                $(this).removeClass(animationName);
            })
        ;

        return this;
    };
});
