/**
 * Functions and scripts related to the theme.
 */
var $win = $(window);
var isFixedTop = false;
if ( $( '.fixed-top' ).length ) isFixedTop = true;

$( window ).on( 'resize scroll', Exopite.throttle( scrollResize, 200, 'scroll' ) );

function scrollResize() {
    scrollToTop();
    if ( isFixedTop ) siteFixedTop();
}

function adminBarheight() {
    return ( $( '#wpadminbar' ).length && $( '#wpadminbar' ).css( 'position' ) === 'fixed' ) ? $( '#wpadminbar' ).height() : 0;
}

// siteFixedTop
$( window ).on('scroll', function () {
    if ( isFixedTop && ! $( window ).scrollTop() ) {
        siteFixedTop();
    }
});
if ( isFixedTop ) siteFixedTop();

function siteFixedTop() {
    /*
     * Check if page scrolled
     * abuse 0 == false :)
     *
     * Source: http://stackoverflow.com/questions/3074802/how-to-check-if-webpage-page-is-scrolled/3075251#3075251
     */

    if( $( window ).scrollTop() == 0 ) { // abuse 0 == false :)
        $( '.fixed-top' ).removeClass('scrolled floating-menu').addClass( 'normal-menu' );
    } else {
        $( '.fixed-top' ).removeClass( 'normal-menu' ).addClass('scrolled floating-menu');
    }

    $( '#site-navigation' ).css( 'top', adminBarheight() + 'px' );
}

// Check to see if the window is top if not then display button
// Source: http://www.paulund.co.uk/how-to-create-an-animated-scroll-to-top-with-jquery
function scrollToTop() {
    if ( $win.scrollTop() > 200 ) {
        $( '.scrollToTop' ).fadeIn();
    } else {
        $( '.scrollToTop' ).fadeOut();
    }
}

$( '.skip-link' ).on( 'click', function( e ) {
    e.preventDefault();
    var contentTop = $( '#content' ).offset().top;
    contentTop -= $( '#site-navigation' ).height();
    contentTop -= adminBarheight();
    $("html, body").animate({ scrollTop: contentTop }, 300);
});

// Click event to scroll to top
$( '.scrollToTop' ).click(function() {
    $( 'html, body' ).animate( { scrollTop : 0 }, 800 );
    return false;
}).trigger( 'blur' );

// SEARCH
// ToDo
//  - make a plugin (selector).fullSearch();
//    ( https://www.sitepoint.com/good-jquery-plugin-template )
//    ( https://css-tricks.com/snippets/jquery/jquery-plugin-template )
//    ( https://learn.jquery.com/plugins/basic-plugin-creation/ )
$( '.full-search-menu' ).on( "click", function( e ) {
    e.preventDefault();
    $( 'body' ).css( 'overflow', 'hidden' );
    $( '.full-search' ).css( 'visibility', 'visible' ).animate({opacity: 1}, 200, function() {
        $( '#full-search-field' ).focus();
    });
});

$( '.full-search' ).keyup( function (e) {
    if ( $( this ).css('opacity') != 0 && e.keyCode == 27 ) {
        closeSearch();
    }
});

function closeSearch() {
    $( '.full-search' ).animate( {opacity: 0}, 200, function( e ) {
        $( this ).css( 'visibility', 'hidden' );
    });
    $( 'body' ).css( 'overflow', '' );
    $( '.full-search .search-field' ).removeClass( 'search-empty' );
}

$( '.search-close, .search-inner' ).on( "click", function() {
    closeSearch();
});

$( '.full-search .search-field' ).on( 'input', function(event) {
    if ( $( this ).val() ) { $( this ).removeClass( 'search-empty' ); }
});

$( '.search-form' ).on( 'click', function( e ) {
    e.stopPropagation();
});

$( '.search-form' ).on( 'submit', function( e ) {
    var $input = $( this ).find( '.search-field' );
    if ( $input.val() == '' ) {
        e.preventDefault();
        $input.addClass( 'search-empty' );
        $input.focus();
    }
});
