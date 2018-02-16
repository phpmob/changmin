var _AjaxEmbedded = function (scope) {
    var _load = function ($container, url) {
        $container.addClass('ajax--loading');

        $.ajax({
            async: true,
            type: 'GET',
            url: url,
            success: function (res) {
                var $res = $(res);
                $container.html($res);
                $(document).trigger('dom-node-inserted', [$res]);
                $container.removeClass('ajax--loading');

                $res.find('a[href]').each(function () {
                    var $link = $(this);
                    var url = $link.attr('href');

                    if ($container.data('ajax-embedded') !== url.split('?')[0]) {
                        return;
                    }

                    $link.on('click', function (e) {
                        e.preventDefault();
                        _load($container, $link.attr('href'));
                    })
                });
            }
        });
    };

    $('[data-ajax-embedded]', scope).each(function () {
        var $me = $(this);
        var url = $me.data('ajax-embedded');

        _load($me, url);
    });
};
