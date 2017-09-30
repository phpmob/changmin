(function (factory) {
    "use strict";

    if (typeof define === "function" && define.amd) {
        define(["jquery"], factory);
    }
    else {
        /* jshint sub:true */
        factory(jQuery);
    }
})(function ($) {
    "use strict";

    $.fn.vsubmit = function (options) {
        var defaults = {
            debug: true,
            errorClass: 'has-error',
            validClass: 'success',
            errorElement: "span",

            // add error class
            highlight: function (element, errorClass, validClass) {
                $(element).parents("div.form-group")
                    .addClass(errorClass)
                    .removeClass(validClass);
            },

            // add error class
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".has-error")
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
});
