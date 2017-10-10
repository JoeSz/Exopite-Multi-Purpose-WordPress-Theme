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

$sidebar_id = exopite_get_sidebar_id();

// Check if selected sidebar is active
if ( ! is_active_sidebar( $sidebar_id ) ) return;

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_sidebars_before();

?>
<aside id="secondary" class="col-md-3 widget-area sidebar main-sidebar" aria-label="Primary Sidebar"<?php WP_Schema::get_attribute( 'sidebar' ); ?>>
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
