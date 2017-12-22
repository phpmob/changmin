PhpMobCms.inits.push(function (scope) {
    // apply vsubmit plugin
    $('form[data-vsubmit]', scope).each(function () {
        $(this).vsubmit($.extend({
            submitHandler: function (form) {
                $(form).trigger('form:submit')
            }
        }, window[$(this).data('vsubmit')]));
    });
});
