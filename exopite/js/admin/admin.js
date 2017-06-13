;(function( $ ) {
    "use strict";

    $( document ).ready(function() {

        // Custom Avatar thumbnail

        /* WP Media Uploader */
        var _exopite_media = true;
        var _orig_send_attachment;
        if ( typeof wp.media === "function" ) {
            _orig_send_attachment = wp.media.editor.send.attachment;
        }

        $( '.delete-avatar-image' ).on('click', function( event ) {
            var $wrapper = $( this ).parents( '.exopite-profile-upload-options' );
            var $img = $wrapper.find( '#exopite-user-avatar-img' );
            var $id = $wrapper.find( '#exopite-user-avatar_image_id' );

            $id.val('');
            $img.attr( 'src', '' ).hide();
            $( this ).hide();
        });

        $( '.exopite-user-avatar-image' ).click( function() {

            var button = $( this ),
                textbox_id = $( this ).attr( 'data-id' ),
                textbox_url = $( this ).attr( 'data-url' ),
                image_id = $( this ).attr( 'data-src' ),
                _exopite_media = true;

            wp.media.editor.send.attachment = function( props, attachment ) {

                if ( _exopite_media && ( attachment.type === 'image' ) ) {

                    $( '#' + textbox_id ).val( attachment.id );
                    $( '#' + image_id ).attr( 'src', attachment.url ).show();
                    $( '.delete-avatar-image' ).show();

                } else {
                    alert( 'Please select a valid image file' );
                }
            };

            wp.media.editor.open( button );
            return false;

        } );

    });

}(jQuery));
