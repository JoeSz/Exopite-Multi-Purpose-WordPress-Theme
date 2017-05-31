/**
 * This gist demonstrates how to properly load jQuery within the context of WordPress-targeted JavaScript so that you don't
 * have to worry about using things such as 'noConflict' or creating your own reference to the jQuery function.
 *
 * @version 1.1
 *
 * ToDo: concatenate and minify for production -> https://jscompress.com/
 */
;(function( $ ) {
    "use strict";

    $( document ).ready(function() {

        $('.cs-header').stickThis({
            fixedClass: 'floating-menu',
            staticClass: 'normal-menu',
            zindex: 11,
        });

        $('#major-publishing-actions').stickThis({
            fixedClass: 'floating-post-save',
            zindex: 11,
        });
    });

}(jQuery));
