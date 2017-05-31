<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

/**
 * Deny Access to No Referer Requests
 *
 * When a spam-bot comes in, it hits the file directly and usually does not leave a referrer.
 *
 * @link https://codex.wordpress.org/Combating_Comment_Spam/Denying_Access
 */
add_action('check_comment_flood', 'security_comment_flood_check_referrer');
if ( ! function_exists( 'security_comment_flood_check_referrer' ) ) {
    function security_comment_flood_check_referrer() {
        if ( ! isset( $_SERVER['HTTP_REFERER'] ) || $_SERVER['HTTP_REFERER'] == '' ) {
            wp_die( esc_attr__( 'Please enable referrers in your browser!' ) );
        }
    }
}
