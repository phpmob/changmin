jQuery(document).on('change', 'input[type=file]', function () {
    var fieldVal = $(this).val();
    if (fieldVal !== undefined || fieldVal !== "") {
        function preview(input, fileName, previewArea) {
            if (input.files && input.files[0] && (/\.(gif|jpg|jpeg|png)$/i).test(fileName)) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    previewArea.attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        var fieldVals = fieldVal.split('\\');
        var fileName = fieldVals[fieldVals.length - 1];

        jQuery(this).next(".custom-file-control").attr('data-content', fileName);

        var $previewArea = jQuery('.phpmob-image-preview');

        if ($previewArea.length) {
            preview(this, fileName, $previewArea);
        }
    }
});
