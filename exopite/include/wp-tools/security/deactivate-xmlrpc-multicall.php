<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

function shapeSpace_disable_xmlrpc_multicall($methods) {
    unset($methods['system.multicall']);
    return $methods;
}
add_filter('xmlrpc_methods', 'shapeSpace_disable_xmlrpc_multicall');
