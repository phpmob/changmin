$(document).on('change', '.profile-picture-input', function (e) {
    var inputName = this.name;
    var $crop;
    var $img = $('.profile-picture');
    var $form = $(this).closest('form');
    var $submit = $form.find('button[type=submit]');

    function preview(input) {
        if (input.files && input.files[0] && (/\.(gif|jpg|jpeg|png)$/i).test($(input).val())) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $crop = $img.croppie({
                    viewport: {width: 150, height: 150},
                    boundary: {width: 200, height: 200}
                });

                $crop.croppie('bind', {
                    url: e.target.result
                });

                $submit.show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    if (this.value !== undefined || this.value !== "") {
        preview(this);

        $form.on('submit', function (e) {
            var fd = new FormData();

            $crop.croppie('result', {
                type: 'base64',
                size: 'original'
            }).then(function (resp) {
                $.each($form.serializeArray(), function (i, f) {
                    fd.append(f.name, f.value);
                });

                fd.append(inputName, resp);

                $submit.spinner('add').attr('disabled', true);

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: fd,
                    cache: false,
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function (res, textStatus, jqXHR) {
                        var $res = $(res);

                        $form.replaceWith($res);

                        $(document).trigger('dom-node-inserted', [$res]);
                    }
                });
            });

            return false;
        });
    }
});
