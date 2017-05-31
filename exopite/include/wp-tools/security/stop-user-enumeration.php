<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

/**
 * Stop User Enumeration in WordPress
 *
 * @link https://perishablepress.com/stop-user-enumeration-wordpress/
 */
add_filter('redirect_canonical', 'security_stop_user_enumeration', 10, 2);
if ( ! function_exists( 'security_stop_user_enumeration' ) ) {
    function security_stop_user_enumeration( $redirect, $request ) {
        if ( preg_match( '/\?author=([0-9]*)(\/*)/i', $request ) ) {
            wp_redirect( get_site_url(), 301 );
            die();
        } else {
            return $redirect;
        }
    }
}
