$( '.mobile-button-hamburger' ).on('click', function () {
    console.log( '1' );
    $( '.menu-overlay-wrapper' ).addClass( 'show' );
    $( 'body.menu-overlay' ).addClass( 'fixed-content' );
});

$( '.menu-overlay-close' ).on('click', function () {
    console.log( '2' );
    $( '.menu-overlay-wrapper' ).removeClass( 'show' );
    $( 'body' ).removeClass( 'fixed-content' );
});

$( document.documentElement ).keyup(function (event) {

    if ( event.keyCode == 27 ) {

        if ( $( '.menu-overlay-wrapper' ).hasClass( 'show' ) ) {
            $( '.menu-overlay-wrapper' ).removeClass( 'show' );
            $( 'body.menu-overlay' ).removeClass( 'fixed-content' );
        }
    }

});
