var _ajaxModalRunning = false;
$(document).on('click', '[data-ajax-modal]', function (e) {
    e.preventDefault();

    var $me = $(this);
    var modalId = $me.data('id') || 'ajax-modal';
    var reload = $me.data('reload') || true;
    var sizing = $me.data('sizing') || '';

    if (sizing) {
        sizing = ' modal-' + sizing;
    }

    var _createModal = function () {
        return $('<div />').addClass('modal').attr('id', modalId).html(
            '<div class="modal-dialog' + sizing + '">' +
            '<div class="modal-content">' +
            '<div class="modal-body">' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    };

    var $modal = $('#' + modalId);

    if (!$modal.length) {
        $modal = _createModal();
    }

    $modal.addClass('modal--loading');
    $modal.modal('show');

    if (false === reload) {
        return;
    }

    var $body = $modal.find('.modal-body');
    $body.html('<span class="text-muted">Loading ...</span>');

    if (false !== _ajaxModalRunning && 'function' === typeof _ajaxModalRunning.abort) {
        _ajaxModalRunning.abort();
    }

    var url = $me.attr('href');

    if ('#' === url || !url) {
        url = $me.data('ajax-modal');
    }

    _ajaxModalRunning = $.ajax({
        async: true,
        type: 'GET',
        url: url,
        success: function (res) {
            var $res = $(res);
            $body.html($res);
            $modal.removeClass('modal--loading');

            _ajaxModalRunning = false;

            $(document).trigger('dom-node-inserted', [$res]);
        }
    });
});
