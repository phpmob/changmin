var PHPMOB_ASSET_PATH = document.currentScript.src.replace('/js/app.js', '').split('?')[0];
var initScripting = function (scope)
{
    SelectizeSetup('select, [data-chooser]', scope);

    $('.holderjs', scope).each(function () {
        Holder.run({ images: this });
    });

    $('.holderjs, img[src^="holder.js"]', scope).each(function () {
        Holder.run({images: this});
    });

    $('.holderjs, img[data-src^="holder.js"]', scope).each(function () {
        Holder.run({images: this});
    });

    $('[data-toggle="tooltip"]').tooltip();
};

$(function () {
    $(document).on('dom-node-inserted', function (e, scope) {
        initScripting(scope);
    });

    initScripting(document);
});
