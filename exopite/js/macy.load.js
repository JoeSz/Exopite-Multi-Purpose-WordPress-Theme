var container = '.content-row.masonry-container';

 if (( typeof masonry.columns !== 'undefined' || masonry.columns !== null ) && $( container + ' article' ).hasClass( 'multi-column' )  ) {

    Macy.init({
        container: container,
        margin: 0,
        columns: masonry.columns,
        widthToContainer: true,
        breakAt: {
            854: 2,
            550: 1
        }
    });

    if ( typeof wp.hooks !== 'undefined' ) {

        wp.hooks.addAction( 'infiniteload-load-success', function(){
            Macy.recalculate();
        }, 10 );

    }

}
