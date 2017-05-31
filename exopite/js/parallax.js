/**
 * Parallax effect for hero header
 */
 function moveSelector() {

     var $overlay = $( '#content' );
     var scale = 0.3;

     var windowTop = $(window).scrollTop();
     var overlayTop = $overlay.offset().top;

     $(".parallax").each(function(i){

         // only when in range
         if( ( overlayTop - windowTop ) > 0 ){
             var pos = Math.floor( $(window).scrollTop() * scale );
             $(this).css({"margin-top": "-" + pos + "px"});

         }

     });
 }

 $( window ).on( 'resize scroll', Exopite.throttle( moveSelector, 20, 'scroll' ) );

