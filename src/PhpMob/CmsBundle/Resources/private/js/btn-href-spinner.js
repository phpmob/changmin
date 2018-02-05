$(document).on('click', 'a.btn', function (e) {
    var $btn = $(this);

    $btn.spinner();
    $btn.addClass('disabled');
});
