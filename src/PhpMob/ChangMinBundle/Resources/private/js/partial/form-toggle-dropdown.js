$(document).on('submit', '.toggle-dropdown form', function (e) {
    e.preventDefault();

    var $form = $(this);

    $.confirm({
        theme: 'modern',
        title: 'Confirmation',
        icon: 'fa fa-question-circle-o',
        content: $form.data('message') || 'Do you want to continue?',
        buttons: {
            confirm: {
                text: 'Yes, I do!',
                btnClass: 'btn-info',
                action: function (e) {
                    $form.addClass('disabled');

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        cache: false,
                        processData: true,
                        dataType: 'json',
                        success: function (res, textStatus, jqXHR) {
                           window.location.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $form.removeClass('disabled');

                            alert(textStatus);
                        }
                    });

                }
            },
            cancel: {
                text: 'No'
            }
        }
    });
});
