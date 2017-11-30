<?php
/*
 * Hooks:
 * - rest_pre_dispatch
 * - rest_request_before_callbacks
 * - rest_dispatch_request
 * - rest_request_after_callbacks
 * - rest_jsonp_enabled
 * - rest_enabled
 * - rest_pre_serve_request
 * - rest_authentication_errors
 */
add_action( 'rest_pre_dispatch', 'deactivate_rest_api' );
add_action( 'rest_authentication_errors', 'deactivate_rest_api' );
function deactivate_rest_api() {
    status_header( 405 );
    die( '{"code":"rest_api_disabled","message":"REST API services are disabled on this site.","data":{"status":405}}' );
}

// Remove the REST API endpoint.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
