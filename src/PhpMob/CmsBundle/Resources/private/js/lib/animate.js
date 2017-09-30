(function ($) {
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

}(jQuery));
