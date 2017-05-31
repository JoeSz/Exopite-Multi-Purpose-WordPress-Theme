<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$exopite_settings = get_option( 'exopite_options' );

// Default sidebar
$sidebar_id = 'shop' ;

// If sidebar is set in options
if ( isset( $exopite_settings['exopite-shop-sidebar-id'] ) && is_shop() ) {

    $sidebar_id = $exopite_settings['exopite-shop-sidebar-id'];

} elseif ( isset( $exopite_settings['exopite-product-sidebar-id'] ) && is_product() ) {

    $sidebar_id = $exopite_settings['exopite-product-sidebar-id'];

}

// Check if selected sidebar is active
if ( ! is_active_sidebar( $sidebar_id ) ) return;

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_sidebars_before();

?>
<aside id="secondary" class="col-md-3 widget-area sidebar main-sidebar" aria-label="Primary Sidebar" itemscope itemtype="http://schema.org/WPSideBar">
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_sidebar_top();

apply_filters( 'exopite-woocommerce-sidebar', dynamic_sidebar( $sidebar_id ) );

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_sidebar_bottom();

?>
</aside>
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_sidebars_after();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
