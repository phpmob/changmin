$(function () {
    // toggle opened collapse
    $('.navbar .collapse').on('show.bs.collapse', function () {
        $(this).closest('.navbar').find('.collapse.show').removeClass('show');
    });
});
