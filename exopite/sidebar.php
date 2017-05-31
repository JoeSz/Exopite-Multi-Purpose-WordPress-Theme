<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

// Get sidebar by ID on single or on archive pages if set by post meta
if ( is_singular() || ( isset( $archive_id ) && ! empty( $archive_id ) ) ) {

    /*
     * Individual page/post settings
     */
    $exopite_meta_data = get_post_meta( get_the_ID(), 'exopite_custom_page_options', true );
    $sidebar_id = ( isset( $exopite_meta_data['exopite-meta-sidebar-id'] ) ) ? $exopite_meta_data['exopite-meta-sidebar-id'] : 'sidebar-1' ;

} else {

    /*
     * Settings from admin option framework
     */
    $exopite_settings = get_option( 'exopite_options' );

    // Default sidebar
    $sidebar_id = 'sidebar-1' ;

    // If sidebar is set in options
    if ( isset( $exopite_settings['exopite-blog-sidebar-id'] ) && is_home() ) {
        $sidebar_id = $exopite_settings['exopite-blog-sidebar-id'];
    }

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

    // Display selected sidebar
    apply_filters( 'exopite-sidebar', dynamic_sidebar( $sidebar_id ) );

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_sidebar_bottom();

    ?>
</aside><!-- #secondary -->
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_sidebars_after();
