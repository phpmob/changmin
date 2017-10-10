/**
 *  [data-reload] : bool | null
 *  [data-redirect] : url | null
 *  [data-callback] : string(name of function) | null
 *  [data-ajax-error] : string (Message for display) | null
 */
$(document).on('submit', 'form[data-ajax-form]', function (e) {
    e.preventDefault();

    var $form = $(this);
    var data = new FormData();
    var url = $form.data('ajax-form') || $form.attr('action');

    $form.find('input[type=file]').each(function (i, f) {
        data.append(f.name, f.files[0] || "");
    });

    $.each($form.serializeArray(), function (i, f) {
        data.append(f.name, f.value);
    });

    $form
        .find('.alert-error').hide();

    $form
        .addClass('loading')
        .append('<div class="' + ($form.data('loading') || 'changmin-loading-pulse') + '"/>')
    ;

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function (res, textStatus, jqXHR) {
            var $res = $(res);

            if ($form.data('reload')) {
                window.location.reload();
                return;
            }

            if ($form.data('redirect')) {
                window.location.href = $form.data('redirect');
                return;
            }

            if($form.data('callback')) {
                window[$form.data('callback')].call(this, $form);
            }

            $form.replaceWith($res);
            $(document).trigger('dom-node-inserted', [$res]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $form.removeClass('loading');
            if ($form.data('ajax-error')) {
                $form
                    .find('.alert-error').show()
                    .find('.error-message').text($form.data('ajax-error'))
                ;
            }
        }
    });

    return false;
});
