jQuery(document).on('change', 'input[type=file]', function () {
    var fieldVal = $(this).val();
    if (fieldVal !== undefined || fieldVal !== "") {
        function showPreview(input, fileName, previewArea) {
            function getExtension(filename) {
                var parts = filename.split('.');
                return parts[parts.length - 1];
            }

            function isImage(filename) {
                var ext = getExtension(filename);
                switch (ext.toLowerCase()) {
                    case 'jpg':
                    case 'gif':
                    case 'bmp':
                    case 'png':
                        return true;
                }

                return false;
            }

            if (input.files && input.files[0] && isImage(fileName)) {
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
            showPreview(this, fileName, $previewArea);
        }
    }
});
