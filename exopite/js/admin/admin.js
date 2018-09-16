; (function ($) {
    "use strict";

    $(document).ready(function () {

        // Custom Avatar thumbnail

        /* WP Media Uploader */
        var _exopite_media = true;
        var _orig_send_attachment;
        if (typeof wp.media === "function") {
            _orig_send_attachment = wp.media.editor.send.attachment;
        }

        $('.delete-avatar-image').on('click', function (event) {
            var $wrapper = $(this).parents('.exopite-profile-upload-options');
            var $img = $wrapper.find('#exopite-user-avatar-img');
            var $id = $wrapper.find('#exopite-user-avatar_image_id');

            $id.val('');
            $img.attr('src', '').hide();
            $(this).hide();
        });

        $('.exopite-user-avatar-image').click(function () {

            var button = $(this),
                textbox_id = $(this).attr('data-id'),
                textbox_url = $(this).attr('data-url'),
                image_id = $(this).attr('data-src'),
                _exopite_media = true;

            wp.media.editor.send.attachment = function (props, attachment) {

                if (_exopite_media && (attachment.type === 'image')) {

                    $('#' + textbox_id).val(attachment.id);
                    $('#' + image_id).attr('src', attachment.url).show();
                    $('.delete-avatar-image').show();

                } else {
                    alert('Please select a valid image file');
                }
            };

            wp.media.editor.open(button);
            return false;

        });

        // $('#video-metabox.postbox').css('margin-top', '30px');

        var custom_uploader;
        $('#upload_media_button').click(function (e) {

            e.preventDefault();

            var allowedTypes = $(this).data('media-type');

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose ' + allowedTypes,
                button: {
                    text: 'Choose ' + allowedTypes,
                },
                multiple: false,
                library: {
                    // https://wordpress.stackexchange.com/questions/264115/show-only-images-and-videos-in-a-wp-media-window
                    // type: ['video']
                    type: [allowedTypes]
                },
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function (attachment) {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#media_URL').val(attachment.url);

            });

            //Open the uploader dialog
            custom_uploader.open();

        });





    });

}(jQuery));
