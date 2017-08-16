// submit form via button outside `form` element
$(document).on('click', '[data-submit-form]', function () {
    var $el = $(this);
    var $form = $('form[name=' + $el.data('submit-form') + ']');

    $form
        .one('submit', function () {
            $el.attr('disabled', true).addClass('disabled');
        })
        .find('button[type=submit]')
        .click()
    ;
});

$(document).on('submit', 'form', function (e) {
    // disable button submit trigg eg. in toolbar
    if (this.name) {
        var $relateSubmitButton = $('[data-submit-form=' + this.name + ']');

        if ($relateSubmitButton.length) {
            $relateSubmitButton.attr('disabled', true).addClass('disabled');
        }
    }
});
