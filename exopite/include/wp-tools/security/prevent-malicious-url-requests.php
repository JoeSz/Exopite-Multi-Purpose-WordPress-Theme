<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

/**
 * Create A Plug-In To Protect Your Blog From Malicious URL Requests
 *
 * Hackers and evil-doers often use malicious queries to find and attack a blog’s weak spots.
 * WordPress has good default protection, but enhancing it is possible.
 *
 * @link https://www.smashingmagazine.com/2010/07/10-useful-wordpress-security-tweaks/
 */
add_action( 'wp', 'security_prevent_script_injection' );
if ( ! function_exists( 'security_prevent_script_injection' ) ) {
    function security_prevent_script_injection() {
        global $user_ID;

        if( ! current_user_can( 'level_10' )) {
            if ( strlen( $_SERVER['REQUEST_URI'] ) > 255 ||
                stripos( $_SERVER['REQUEST_URI'], 'eval(' ) ||
                stripos( $_SERVER['REQUEST_URI'], 'CONCAT' ) ||
                stripos( $_SERVER['REQUEST_URI'], 'UNION+SELECT' ) ||
                stripos( $_SERVER['REQUEST_URI'], 'GLOBALS(' ) ||
                stripos( $_SERVER['REQUEST_URI'], '_REQUEST' ) ||
                stripos( $_SERVER['REQUEST_URI'], '/localhost' ) ||
                stripos( $_SERVER['QUERY_STRING'], '127.0.0.1' ) ||
                stripos( $_SERVER['REQUEST_URI'], '/config.' ) ||
                stripos( $_SERVER['REQUEST_URI'], 'wp-config.' ) ||
                stripos( $_SERVER['REQUEST_URI'], 'etc/passwd' ) ||
                stripos( $_SERVER['REQUEST_URI'], '<' ) ||
                stripos( $_SERVER['REQUEST_URI'], 'base64' ) ) {
                @header( 'HTTP/1.1 403 Forbidden' );
                @header( 'Status: 403 Forbidden') ;
                @header( 'Connection: Close' );
                @exit;
            }
        }
    }
}
