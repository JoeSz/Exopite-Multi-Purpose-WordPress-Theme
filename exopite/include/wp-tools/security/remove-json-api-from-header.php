<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

if ( ( isset( $exopite_settings['exopite-security-disable-rest-api'] ) &&
       $exopite_settings['exopite-security-disable-rest-api']
     ) ||
     ( isset( $exopite_settings['exopite-security-rest-api-only-authenticated'] ) &&
       $exopite_settings['exopite-security-rest-api-only-authenticated'] && ! is_user_logged_in()
     )
   ) {

    add_action( 'after_setup_theme', 'remove_json_from_header' );
    if ( ! function_exists( 'remove_json_from_header' ) ) {

        function remove_json_from_header () {

            /**
             * Remove JSON API form source
             * @link https://wordpress.stackexchange.com/questions/211467/remove-json-api-links-in-header-html/212472#212472
             */
            // Remove the REST API lines from the HTML Header
            remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
            remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

            // Remove oEmbed discovery links.
            remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

            // Remove oEmbed-specific JavaScript from the front-end and back-end.
            remove_action( 'wp_head', 'wp_oembed_add_host_js' );


        }

    }

}
