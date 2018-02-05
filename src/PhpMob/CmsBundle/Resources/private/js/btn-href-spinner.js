$(document).on('click', 'a.btn', function (e) {
    var $btn = $(this);
    var href = $btn.attr('href');

    if ('#' === href || !href) {
        return;
    }

    $btn.spinner();
    $btn.addClass('disabled');
});
