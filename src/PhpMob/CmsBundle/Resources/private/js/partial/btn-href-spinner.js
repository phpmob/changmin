$(document).on('click', 'a.btn', function (e) {
    var $btn = $(this);
    var href = $btn.attr('href');

    if ('#' === href || !href) {
        return;
    }

    $btn.addClass('disabled');

    if ('undefined' !== typeof $btn.data('no-spin')) {
        return;
    }

    $btn.spinner();
});
