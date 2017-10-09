var AllowExternalWidgetExtension = function (widget) {
    var exts = window['PhpMobWidgetExtensions'] || [];
    var i;

    for (i = 0; i < exts.length; i++) {
        new exts[i](widget);
    }
};
