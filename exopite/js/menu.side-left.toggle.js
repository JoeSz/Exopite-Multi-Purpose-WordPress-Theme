/**
 * Menu toggle for side menu
 */
 $( "#menu-toggle" ).click(function(e) {
     e.preventDefault();
     $( "#page" ).toggleClass( "toggled" );
 });

 function calculateTop() {
     var adminBarheight = ( $( '#wpadminbar' ).length && $( '#wpadminbar' ).css( 'position' ) === 'fixed' ) ? $( '#wpadminbar' ).height() : 0;
     $( "#menu-toggle" ).css( 'top', adminBarheight + 'px' );
     $( "#masthead" ).css( 'top', adminBarheight + 'px' );
 }

 calculateTop();
 $( window ).on( 'resize', Exopite.throttle( calculateTop, 250, 'resize' ) );
