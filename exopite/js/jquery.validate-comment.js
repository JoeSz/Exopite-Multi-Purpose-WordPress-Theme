(function ( $,window, document ) {
    'use strict';

    $.fn.validator = function(options) {

        function isValidEmailAddress(emailAddress) {
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            return pattern.test(emailAddress);
        };

        this.each(function() {

            var settings = $.extend( {}, options );

            $(this).submit(function(e) {

                var valid = true;
                var $this = $( this );

                $.each(settings, function(index, value) {

                    var $element = $this.find( index );
                    // Prevent error on not existing fields (like comment if user logged in)
                    if (!$element.length) return;
                    var element_value = $element.val();

                    $element.removeClass('error');
                    if ( value == 'email' ) {
                        if ( ! isValidEmailAddress( element_value ) ) {
                            $element.addClass('error');
                            valid = false;
                        };
                    } else {
                        if ( element_value < value ) {
                            $element.addClass('error');
                            valid = false;
                        };
                    };

                });

                if( ! valid ) {
                    e.preventDefault();
                }

            });

        });
    };

}( jQuery,window, document ));

;(function( $ ) {
    "use strict";

    $( document ).ready(function() {

        $('#commentform').validator({
            'textarea': 10,
            '#author': 3,
            '#email': 'email',
        });
    });

}(jQuery));
