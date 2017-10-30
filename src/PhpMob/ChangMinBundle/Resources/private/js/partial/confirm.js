$(document).on('click', '[data-delete-confirmation]', function (e) {
    e.preventDefault();

    var $el = $(this);

    $.confirm({
        theme: 'modern',
        title: 'Delete?',
        icon: 'fa fa-attention',
        content: $el.data('message') || 'Do you want to delete this item?',
        buttons: {
            confirm: {
                text: 'Yes, I do!',
                btnClass: 'btn-danger',
                action: function (e) {
                    $el.addClass('disabled');

                    if ($el.is('a')) {
                        window.location.href = $el.attr('href');
                    } else {
                        $el.closest('form').submit();
                    }
                }
            },
            cancel: {
                text: 'No'
            }
        }
    });
});

$(document).on('click', '[data-confirmation]', function (e) {
    e.preventDefault();

    var $el = $(this);

    $.confirm({
        theme: 'modern',
        title: 'Confirmation',
        icon: 'fa fa-question-circle-o',
        content: $el.data('message') || 'Do you want to continue?',
        buttons: {
            confirm: {
                text: 'Yes, I do!',
                btnClass: 'btn-info',
                action: function (e) {
                    $el.addClass('disabled');

                    if ($el.is('a')) {
                        window.location.href = $el.attr('href');
                    } else {
                        $el.closest('form').submit();
                    }
                }
            },
            cancel: {
                text: 'No'
            }
        }
    });
});
