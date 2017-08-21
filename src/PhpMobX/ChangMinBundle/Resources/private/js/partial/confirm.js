$(document).on('click', '[data-delete-confirmation]', function (e) {
    e.preventDefault();

    var $el = $(this);

    $.confirm({
        theme: 'modern',
        title: 'Delete?',
        icon: 'icon icon-attention',
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
