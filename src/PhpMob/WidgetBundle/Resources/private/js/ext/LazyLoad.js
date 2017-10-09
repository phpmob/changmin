var LazyLoadWidgetExtension = function (widget) {
    if ('onscreen' !== widget.options['visibility'] || !widget.$element.is(':visible')) {
        return;
    }

    new Waypoint({
        element: widget.$element[0],
        offset: '200%',
        handler: function () {
            if ('away' === widget.options['visibility']) {
                return;
            }

            widget.load();
        }
    });
};
