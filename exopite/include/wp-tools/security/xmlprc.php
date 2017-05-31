<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

/**
 * Disable XML-RPC in WordPress
 *
 * @link http://www.wpbeginner.com/plugins/how-to-disable-xml-rpc-in-wordpress/
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
