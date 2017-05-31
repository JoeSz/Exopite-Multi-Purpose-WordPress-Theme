/**
 * Sticky anything without cloning it - jQuery plugin
 *
 * GitHub: https://github.com/JoeSz/Sticky-anything-without-cloning-it
 *
 * Version: 1.2.3
 *
 * The Sticky anything without cloning it plugin allows you to make any element on your page "sticky"
 * as soon as it hits the top of the page when you scroll down. Although this is commonly used to keep
 * menus at the top of your page, the plugin actually allows you to make ANY element sticky
 * (such as a Call To Action box, a logo, etc.)
 */
/*
 * ToDo:
 * - stick more element on top (add a variable to store fixed element heights++)
 * - Mobile menu
 *   - do not fix if menu open
 *   - if menu fixed, make sure it is scrollbar
 *   - prevent background to scroll
 *   - on resize close menu and unfix and remove notouch!
 *   + see: mobile-menu (do not fix if menu open)
 */
(function($) {
'use strict';

    $.fn.stickThis = function( options ) {

        var inViewport = function( $el ) {
            // http://stackoverflow.com/questions/24768795/get-the-visible-height-of-a-div-with-jquery/26831113#26831113
            var elH = $el.outerHeight(),
                H   = $(window).height(),
                r   = $el[0].getBoundingClientRect(), t=r.top, b=r.bottom;
            return Math.max(0, t>0? Math.min(elH, H-t) : (b<H?b:H));
        };

        var toggleTouch = function( $mobileMenu, $that ) {

            // Add a timeout, make sure, expanded class is there
            setTimeout( function() {

                // Disable scoll and touch move Only if it is fixed
                var isFixed = $that.css("position") === 'fixed';

                if ( isFixed && $mobileMenu.hasClass( 'expanded' ) ) {

                    // Add noscroll class to html and body
                    $( 'body' ).addClass( 'noscroll' );
                    $( 'html' ).addClass( 'noscroll' );

                    // Disable touch move (for iOS)
                    $( 'body' ).on("touchmove", function(event) {
                        event.preventDefault();
                    });

                    $( $mobileMenu ).on('touchmove', function(event){

                        // Calculate menu real height
                        var tot = 0;
                        $( $mobileMenu ).children( 'li:visible' ).each(function() { tot += $(this).height(); });

                        // If menu is bigger then the visible part of the menu,
                        // enable touch move
                        if( tot > inViewport( $mobileMenu ) ) {
                            event.stopPropagation();
                        }

                    });

                } else {
                    $( 'body' ).removeClass( 'noscroll' );
                    $( 'html' ).removeClass( 'noscroll' );
                    $( 'body' ).off( 'touchmove' );

                }

            }, 200);


        };

        var stickIt = function( stickyTop, zindex, fixedClass, staticClass, $that, callingEvent, mobileWidth, fixedOnStart ) {
            var placeholder = $that.next();
            var placeholderTop = placeholder.offset().top;
            var selectorHeight = $that.outerHeight();
            var isFixed = $that.css("position") === 'fixed';
            var fixedInit = false;

            // Check WordPress admin bar
            var adminBarheight = ( $( '#wpadminbar' ).length && $( '#wpadminbar' ).css( 'position' ) === 'fixed' ) ? $( '#wpadminbar' ).height() : 0;
            stickyTop += adminBarheight;

            if ( ( $( window ).scrollTop() > ( ( placeholderTop - stickyTop ) - selectorHeight ) ) && ! isFixed ) {
                // Element top reached or above desired top position and element is not fixed (yet)

                if ( ! fixedOnStart ) {
                    $that.removeClass( staticClass );
                    $that.addClass( fixedClass );
                    $that.css( {'position': 'fixed', top: stickyTop + 'px'} );
                    if ( $( window ).width() < ( mobileWidth + 1 ) ) {
                        var menuHeight = $('.menu-collapser').height();
                        placeholder.css( {height: menuHeight} );
                    } else {
                        placeholder.css( {height: selectorHeight} );
                    }
                }

                fixedInit = true;

                /**
                 * Add hook if element become fixed
                 * Can be used e.g. refresh masonry container, etc...
                 * @link https://gist.github.com/JoeSz/6aa061ff48eaf1af658d3adf9d71ec37
                 */
                if ( typeof wp.hooks !== 'undefined' ) wp.hooks.doAction( 'sticky-anything-on-fixed' );

            } else if ( ( $( window ).scrollTop() <= ( placeholderTop - stickyTop ) ) && isFixed && ! fixedOnStart ) {
                // Placeholder element top reached or below desired top position

                $that.removeClass( fixedClass );
                $that.addClass( staticClass );
                $that.removeAttr( 'style' );
                placeholder.css( {height: 0} );

                /**
                 * Add hook if element become unfixed
                 * Can be used e.g. refresh masonry container, etc...
                 * @link https://gist.github.com/JoeSz/6aa061ff48eaf1af658d3adf9d71ec37
                 */
                if ( typeof wp.hooks !== 'undefined' ) wp.hooks.doAction( 'sticky-anything-on-unfixed' );
            }

            // Set element left and right position, z-index and max-width only
            // on scroll if just become fixed or
            // on resize, but only if it is fixed
            if ( fixedInit || ( isFixed && callingEvent == 'resize' ) ) {

                // Calculate element position based on placeholder position
                var placeholderRight = ( $( window ).width() - ( placeholder.offset().left + placeholder.outerWidth() ) );

                $that.css({
                    'max-width': placeholder.outerWidth() + 'px',
                    left: placeholder.offset().left,
                    right: placeholderRight,
                    'z-index': zindex
                });
            }
        };

        this.each(function() {

            var settings = $.extend({
                // Default
                top: 0,
                minscreenwidth: 0,
                maxscreenwidth: 99999,
                fixedClass: 'sticked',
                staticClass: 'static',
                placeholderClass: 'sticky-placeholder',
                zindex: 1,
                mobileTrigger: '#mobile-trigger',
                mobileMenu: '.slimmenu',
                mobileWidth: 767
            }, options );

            var $that = $( this );
            var $mobileMenu = $( settings.mobileMenu );
            var fixedOnStart = ( $that.css("position") === 'fixed' );

            // Insert an empty div, for placeholder and measuring purposes
            $( '<div></div>' ).addClass( $( this ).attr( 'class' ) ).addClass( settings.placeholderClass ).css( 'background-color', $( this ).css( 'backgroundColor' ) ).insertAfter( this );

            $( settings.mobileTrigger ).on('click', function(event) {
                toggleTouch( $mobileMenu, $that );
            });

            var checkFixed = function( callingEvent ) {

                if ( callingEvent === 'resize' ) toggleTouch( $mobileMenu, $that );

                // Calculating actual viewport width
                var e = window, a = 'inner';
                if ( ! ( 'innerWidth' in window ) ) {
                    a = 'client';
                    e = document.documentElement || document.body;
                }
                var viewport = e[ a + 'Width' ];

                if ( ( viewport >= settings.minscreenwidth ) && ( viewport <= settings.maxscreenwidth ) && // inside min and max
                     ( viewport >= settings.mobileWidth || ( viewport < settings.mobileWidth && ! $mobileMenu.hasClass( 'expanded' ) ) ) ) { // mobile width and menu is not opened

                    // Stick it in desired viewport range
                    stickIt( settings.top, settings.zindex, settings.fixedClass, settings.staticClass, $that, callingEvent, settings.mobileWidth, fixedOnStart );
                }
            };

            $( window ).on( 'scroll', Exopite.throttle( checkFixed, 30, 'scroll' ) );
            $( window ).on( 'resize', Exopite.throttle( checkFixed, 100, 'resize' ) );

            return this;

        });
    };


}(jQuery));

