$( '.woocommerce' ).on( 'click', '.remove', function(event) {
    event.preventDefault();

    var WCRemoveUrl = $( this ).attr( 'href' );

    var $ajaxCarts = $( '.woocommerce' ).filter( '.cart-dropdown-inner, .widget_shopping_cart' );

    $ajaxCarts.addClass( 'loading loader' );

    $.get( WCRemoveUrl, function( data, status ) {
        if ( status === 'success' ) {
            // https://stackoverflow.com/questions/41782403/force-woocommerce-to-update-fragment/42429600#42429600

            $( document.body ).trigger( 'wc_fragment_refresh' );
            $( document.body ).on( 'wc_fragments_refreshed', function() {

                $ajaxCarts.removeClass( 'loading loader' );

            } );

        } else {

            $ajaxCarts.removeClass( 'loading loader' );

        }

    });

    return false;

});
