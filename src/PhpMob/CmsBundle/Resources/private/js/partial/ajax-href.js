$(document).on('click', '[data-ajax-href]', function (e) {
    e.preventDefault();

    var $el = $(this);
    var $insertTarget = $($el.data('target') || 'body');
    var $faIcon = $el.find('.fa');

    $el.attr('disabled', true).addClass('disabled');

    if ($faIcon.length) {
        $faIcon.addClass('fa-spin');
    }

    $.ajax({
        async: true,
        type: 'GET',
        url: $(this).data('ajax-href'),
        success: function (res) {
            var $res = $(res);
            $insertTarget.append($res);

            $(document).trigger('dom-node-inserted', [$res]);

            $el.attr('disabled', false).removeClass('disabled');

            if ($faIcon.length) {
                $faIcon.removeClass('fa-spin');
            }

            // activate modal
            var $modal = $res.find('.modal');

            if ($modal.length) {
                $modal.modal('show');
            }

            if ($res.hasClass('modal')) {
                $res.modal('show');
            }
        }
    });
});
