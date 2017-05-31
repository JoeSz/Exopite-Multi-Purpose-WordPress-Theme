/**
 * Calculate menu height for hero header
 */
 function changeHeroHeaderHeight() {
     if ( $(window).width() > ([#exopite-mobile-width]) ) {
         $( '.hero-header-wrapper' ).css( "height", ( $(window).height() - $( '#site-navigation' ).height() ) + 'px' );
     };
 }

 function setHeader() {
     $( '#site-navigation' ).addClass( 'hero-header-show-menu-below' );
     if ( $( '.hero-header-media' ).css( 'position' ) === 'fixed' ) $( '#masthead' ).css( 'background', 'transparent' );
     $( '.hero-header-media' ).css( 'height', '100vh' );
 }

 if ( $( '.hero-header-media' ).length && ( ! ( $( '#site-navigation' ).hasClass('fixed-top') || $( 'body' ).hasClass('hero-header-show-menu-off-below') ) ) ) {
     $( window ).on( 'resize', Exopite.throttle( changeHeroHeaderHeight, 250, 'resize' ) );
     changeHeroHeaderHeight();
     setHeader();
 }
