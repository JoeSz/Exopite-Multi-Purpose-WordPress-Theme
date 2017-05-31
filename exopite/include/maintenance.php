<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * Maintenance mode
 */
if ( ! function_exists( 'load_maintanence' ) ) {
    function load_maintanence() {

        header('HTTP/1.0 503 Service Unavailable');
        include_once( get_template_directory() . '/template-parts/maintenance.php' );
        exit();

    }
}

if ( isset( $exopite_settings['exopite-activate_maintenance'] ) && $exopite_settings['exopite-activate_maintenance'] ) {
    if( ! is_user_logged_in() ) {
        if( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {

            load_maintanence();

        }
    }
}
