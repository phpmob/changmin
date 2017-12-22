$(document).on('form:submit', 'form', function (e) {
    e.preventDefault();

    var $form = $(this);
    var $submit = $form.find('button[type=submit]');

    $submit.spinner();

    $form.find('button,.btn').attr('disabled', true);

    this.submit();
});

$(document).on('submit', 'form:not([data-special]):not([data-ajax-form]):not([data-vsubmit])', function (e) {
    e.preventDefault();
    $(this).trigger('form:submit')
});
