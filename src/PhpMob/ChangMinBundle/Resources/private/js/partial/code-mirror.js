window.CodeMirrorSetup = function () {
    var CodeMirrorInit = function (elId, mode) {
        if (window[elId] instanceof CodeMirror) {
            window[elId].refresh();
        } else {
            window[elId] = CodeMirror.fromTextArea($('#' + elId).get(0), {
                lineNumbers: true,
                indentWithTabs: false,
                mode: { name: mode, htmlMode: mode === 'twig' }
            });
        }
    };

    if ($('[data-code-mirror-mode]').length) {
        assets.require([PHPMOB_ASSET_PATH + '/css/codemirror.css', PHPMOB_ASSET_PATH + '/js/codemirror.js'], function () {
            $('textarea[data-code-mirror-mode]').each(function () {
                CodeMirrorInit($(this).attr('id'), $(this).data('code-mirror-mode'));
            });
        });
    }

    $(this).on('shown.bs.tab', function (e) {
        var $el = $(e.target).closest('.nav-item'),
            mode = $el.data('code-mirror-mode'),
            elId = $el.data('code-mirror-id')
        ;

        if (!mode) {
            return;
        }

        CodeMirrorInit(elId, mode);
    });
};
