var AutoRefreshWidgetExtension = function (widget) {
    if (!widget.isLoaded()) {
        return;
    }

    if (!widget.options['auto_refresh']) {
        return;
    }

    // should not show loading indicator on auto refresh widget.
    widget.options['mask_mode'] = 'none';

    // will re init when content loaded
    // set and then clear, use setTimeout insteadof setInterval ... we need to wait until loaded
    // http://stackoverflow.com/questions/729921
    var autoRefreshInterval;

    if ('onscreen' === widget.options['auto_refresh']) {
        if (!widget.$element.is(':visible')) {
            return;
        }

        new Waypoint.Inview({
            element: widget.$element[0],
            entered: function () {
                autoRefreshInterval = setTimeout(function () {
                    widget.load({});
                    clearTimeout(autoRefreshInterval);
                }, widget.options['auto_refresh_timer']);
            },
            exited: function () {
                clearTimeout(autoRefreshInterval);
            }
        });
    } else {
        autoRefreshInterval = setTimeout(function () {
            widget.load({});
            clearTimeout(autoRefreshInterval);
        }, widget.options['auto_refresh_timer']);
    }
};
