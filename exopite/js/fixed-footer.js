/**
 * Fixed footer
 */
 // Only if fixed footer
 function setFixedFooterHeight() {
     // Adjust content margin to fixed footer height
     if ( $( '#colophon' ).css("position") === "fixed" ) {
         $( '#content' ).css( 'margin-bottom', $( '#colophon' ).height() + 'px' );
     }
 }

 $( window ).on( 'resize scroll', Exopite.throttle( setFixedFooterHeight, 200, 'scroll' ) );
