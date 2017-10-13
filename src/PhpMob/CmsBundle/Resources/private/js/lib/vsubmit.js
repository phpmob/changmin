(function ($) {
    $.fn.vsubmit = function (options) {
        var defaults = {
            debug: true,
            errorClass: 'is-invalid',
            validClass: '',
            errorElement: "p",
            focusInvalid: false,

            // add error class
            highlight: function (element, errorClass, validClass) {
                $(element)
                    .addClass(errorClass)
                    .removeClass(validClass);
            },

            // add error class
            unhighlight: function (element, errorClass, validClass) {
                $(element)
                    .removeClass(errorClass)
                    .addClass(validClass);
            },

            // submit handler
            submitHandler: function (form) {
                form.submit();
            },

            invalidHandler: function (form) {
                $(form).animate('shake');
            }
        };

        $(this).validate($.extend(defaults, options));

        return this;
    };
}(jQuery));
