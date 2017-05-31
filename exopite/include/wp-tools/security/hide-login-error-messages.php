<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

/**
 * Hide WordPress Login Error Messages
 *
 * Recently, one of our users asked us how they can disable login hints in WordPress.
 * By default, WordPress show error messages when someone enters incorrect username or password on the login page.
 * These error messages can be used as a hint to guess a username, user email address, or password. In this article,
 * we will show you how to disable login hints in WordPress login error messages.
 *
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-disable-login-hints-in-wordpress-login-error-messages/
 */
add_filter( 'login_errors', 'security_turn_off_login_errors' );
if ( ! function_exists( 'security_turn_off_login_errors' ) ) {
    function security_turn_off_login_errors( $error ){

        global $errors;
        $err_codes = $errors->get_error_codes();

        if ( ! in_array( 'too_many_tried', $err_codes ) ) {

            // For security reason
            return esc_attr__('Access denied!', 'exopite');
        }

        return $error;
    }
}
