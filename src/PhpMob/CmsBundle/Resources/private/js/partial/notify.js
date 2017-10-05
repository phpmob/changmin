Noty.overrideDefaults({
    layout: 'topRight',
    theme: 'nest',
    timeout: 5000,
    closeWith: ['click', 'button'],
    animation: {
        open: 'animated bounceInRight',
        close: 'animated bounceOutRight'
    }
});

Noty.message = function (type, options) {
    if (typeof options === 'string') {
        options = {
            type: type,
            text: options
        };
    }

    new Noty(options).show();
};

Noty.alert = function (options) {
    Noty.message('alert', options);
};

Noty.success = function (options) {
    Noty.message('success', options);
};

Noty.warning = function (options) {
    Noty.message('warning', options);
};

Noty.error = function (options) {
    Noty.message('error', options);
};

Noty.info = function (options) {
    Noty.message('info', options);
};
