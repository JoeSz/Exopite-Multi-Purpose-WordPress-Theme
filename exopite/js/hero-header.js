/**
 * Hero Header
 */
//http://stackoverflow.com/questions/4646998/play-pause-html-5-video-using-jquery/21492858#21492858

var videoAutoPaused = false;
var $videoTag = $('.video-control');

$( '.video-control' ).on( 'click', function(event) {
    this[this.paused ? 'play' : 'pause']();
});

$( '.hero-header-skip-to-content' ).on( 'click', function(event) {
    event.preventDefault();
    //var navigationHeight = $( '#site-navigation' ).height();
    var top = $( '#content' ).offset().top - $( '#site-navigation' ).height();

    $("html, body").animate({
        scrollTop: top
    }, 500);
});

$( '.hero-header-overlay' ).on( 'click', function() {
    if ( ! $videoTag.length ) return;
    if ( $videoTag.get(0).paused ) {
        $videoTag.get(0).play();
    } else {
        $videoTag.get(0).pause();
    }
});

function HTML5VideoHandle() {

    if ( $( '#content' ).offset().top < $( window ).scrollTop() ) {
        if ( ! $videoTag.get(0).paused ) {
            $videoTag.get(0).pause();
            videoAutoPaused = true;
        }
    } else {
        if ( $videoTag.get(0).paused && videoAutoPaused ) {
            $videoTag.get(0).play();
            videoAutoPaused = false;
        }
    }

}

// Hero header above footer, so footer is not visible.
// If we scroll below the hero header, then change footer z-index
// so footer is visible (over hero header)
function makeFooterVisible() {
    //if( $( window ).scrollTop() + $( window ).height() > ( $( '.hero-header' ).height() * 1.5 ) ) {
    if( $( window ).scrollTop() > ( $(document).height() / 2 ) ) {
        $( '.site-footer' ).css( 'z-index', 1 );
    } else {
        $( '.site-footer' ).css( 'z-index', -1 );
    }
}

makeFooterVisible();

$( window ).on( 'resize scroll', Exopite.throttle( makeFooterVisible, 50, 'scroll' ) );
if ( $videoTag.length ) $( window ).on( 'resize scroll', Exopite.throttle( HTML5VideoHandle, 300, 'scroll' ) );
