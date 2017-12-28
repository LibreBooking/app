// Credit: https://codepen.io/jaysalvat/pen/agLyf //
function dropzone(element)
{
    element.on('dragover', function() {
        $(this).addClass('hover');
    });

    element.on('dragleave', function() {
        $(this).removeClass('hover');
    });

    element.find('input').on('change', function(e) {
        var file = this.files[0];

        element.removeClass('hover');

        element.addClass('dropped');
        element.find('img').remove();

        if ((/^image\/(gif|png|jpeg)$/i).test(file.type)) {
            var reader = new FileReader(file);

            reader.readAsDataURL(file);

            reader.onload = function(e) {
                var data = e.target.result,
                    $img = $('<img />').attr('src', data).fadeIn();

                element.find('div').html($img);
            };
        } else {
            var ext = file.name.split('.').pop();

            element.find('div').html(ext);
        }
    });
}