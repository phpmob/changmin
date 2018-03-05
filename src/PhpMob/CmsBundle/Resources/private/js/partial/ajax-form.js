/**
 *  [data-reload] : bool | null
 *  [data-redirect] : url | null
 *  [data-callback] : string(name of function) | null
 *  [data-ajax-error] : string (Message to display) | null
 */
$(document).on('submit', 'form[data-ajax-form]', function (e) {
    e.preventDefault();

    var $form = $(this);
    var data = new FormData();
    var url = $form.attr('action') || $form.data('ajax-form');
    var $submit = $form.find('button[type=submit]');

    $form.find('input[type=file]').each(function (i, f) {
        if (f.files[0]) {
            data.append(f.name, f.files[0]);
        }
    });

    $.each($form.serializeArray(), function (i, f) {
        data.append(f.name, f.value);
    });

    $form
        .addClass('loading')
        .find('.alert-error').hide()
    ;

    $submit.spinner('add');
    var $buttons = $form.find('button,.btn').attr('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        // all status
        complete: function (jqXHR) {
            $submit.spinner('remove');
            $buttons.attr('disabled', false);

            if($form.data('callback')) {
                window[$form.data('callback')].call(this, $form, null, jqXHR);
                return;
            }

            var location = jqXHR.getResponseHeader('x-sylius-location');

            // should use `x-sylius-location`
            if (301 === jqXHR.status || 302 === jqXHR.status) {
                var _location = jqXHR.responseJSON[$form.data('location') || 'location'];

                if (_location) {
                    return window.location.href = _location;
                }

                if (location) {
                    return window.location.href = location;
                }

                return window.location.reload();
            }

            if (location) {
                return window.location.href = location;
            }
        },
        // 200 status
        success: function (res, textStatus, jqXHR) {
            $submit.spinner('remove');

            if (!res) {
                return;
            }

            var $res = $(res);
            // valid form
            if (!$res.find('.is-invalid').length) {
                if ($form.data('reload')) {
                    window.location.reload();
                    return;
                }

                if ($form.data('redirect')) {
                    window.location.href = $form.data('redirect');
                    return;
                }
            }

            if($form.data('callback')) {
                window[$form.data('callback')].call(this, $form, $res, jqXHR);
                return;
            }

            var $resForm = $res.is('form') ? $res : $res.find('form');
            $form.replaceWith($resForm);

            $(document).trigger('dom-node-inserted', [$resForm]);

            // activate modal
            var $modal = $resForm.find('.modal');

            if ($modal.length) {
                $modal.modal('show');
            }

            if ($resForm.hasClass('modal')) {
                $resForm.modal('show');
            }
        }
    });

    return false;
});
