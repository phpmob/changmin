var OnClickWidgetExtension = function (widget) {
    var defaultCallback = function (mode) {
        return $.proxy(function (e) {
            var options = widget.$ticker.data('widget-' + mode) || {};

            e.preventDefault();
            widget.$ticker = $(e.target);
            widget.load.call(widget, DeepExtend(options, { mode: mode }));
        }, widget);
    };

    widget.$element.on('click', '[data-widget-reload]', defaultCallback('reload'));
    widget.$element.on('click', '[data-widget-more]', defaultCallback('more'));
    widget.$element.on('click', '[data-widget-pull]', defaultCallback('pull'));
    widget.$element.on('click', '[data-widget-prev]', defaultCallback('prev'));
    widget.$element.on('click', '[data-widget-next]', defaultCallback('next'));

    widget.$element.on('click', '[data-widget-submit]', $.proxy(function (e) {
        e.preventDefault();
        widget.$ticker = $(e.target);
        widget.submit.call(widget);
    }, widget));
};
