(function () {
    // run each time when dom insert
    PhpMobCms.runInit = function (scope) {
        $.each(PhpMobCms.inits || [], function (i, fn) {
            fn.call(this, scope);
        });
    };

    // run one time after dom ready
    PhpMobCms.runDefer = function (scope) {
        $.each(PhpMobCms.defers || [], function (i, fn) {
            fn.call(this, scope);
        });
    };

    // run one time before dom ready
    var boots = PhpMobCms.boots || [];

    for (var i = 0; i < boots.length; i++) {
        boots[i].call(this, document);
    }
}());
