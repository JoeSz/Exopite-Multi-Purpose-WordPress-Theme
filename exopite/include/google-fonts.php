<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Create a Google fonts query.
 * Because it is heavy (especially with multiple fonts) I created to ways of loading.
 * First, is the regular enqueue with php and css.
 * The other one is JavaScript. In this case, it is loading only, when JavaScript libraries loading,
 * which if after page content is already loaded.
 * Only problem is, the font will change after content is loaded.
 *
 */
if ( ! function_exists( 'get_google_fonts' ) ) {
    function get_google_fonts() {
        /*
         * Check content, menu and h1 fonts in settings.
         * Add font only, if not added already.
         *
         * https://fonts.googleapis.com/css?family=Cantarell:i|Droid+Serif:700
         */
        $exopite_settings = get_option( 'exopite_options' );

        $google_fonts_noscrypt = 'Shadows+Into+Light+Two|';
        $google_fonts_async = "'Shadows Into Light Two',";

        if ( ! is_array( $exopite_settings['google_fonts'] ) ) {
            return array(
                'async' => '',
                'regular' => 'Shadows+Into+Light+Two|Roboto:300,500'
            );
        }

        // Loop trought fonts from options
        foreach( $exopite_settings['google_fonts'] as $family_name => $family_weight ) {

            // Different format for link and async js
            $google_fonts_async .= "'" . $family_name . ':';
            $google_fonts_noscrypt .= str_replace( ' ', '+', $family_name ) . ':';

            // Get font weights
            foreach ( $family_weight as $key => $weight ) {
                $google_fonts_async .= $weight . ',';
                $google_fonts_noscrypt .= $weight . ',';
            }

            /*
             * Add 500 if it is not already has been added
             * (if font is eg. 300, then bold will not work, if 500 not enqueued)
             */
            if ( ! in_array( '500', $family_weight ) ) {
                $google_fonts_async .= '500';
                $google_fonts_noscrypt .= '500';
            }

            $google_fonts_async = rtrim( $google_fonts_async, ',' );
            $google_fonts_noscrypt = rtrim( $google_fonts_noscrypt, ',' );

            // Add separator between fonts
            $google_fonts_async .= "',";
            $google_fonts_noscrypt .= '|';
        }

        // Get rid of last separator
        $google_fonts_async = rtrim( $google_fonts_async, ',' );
        $google_fonts_noscrypt = rtrim( $google_fonts_noscrypt, '|' );

        return array(
            'async' => $google_fonts_async,
            'regular' => $google_fonts_noscrypt
        );
    }
}
