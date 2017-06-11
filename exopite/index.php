<?php
/**
 * The main template file (Blog list or fall-back).
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

// Display blog page content too
$page_for_posts_id = get_option('page_for_posts');
$exopite_meta_data = get_post_meta( get_queried_object_ID(), 'exopite_custom_page_options', true );
$show_content = isset( $exopite_meta_data['exopite-enable-blog-content'] ) ? $exopite_meta_data['exopite-enable-blog-content'] : false;

$exopite_settings = get_option( 'exopite_options' );

$exopite_blog_list_layout = ( isset( $exopite_settings['exopite-blog-list-layout'] ) ) ? $exopite_settings['exopite-blog-list-layout'] : 'blog-list-right-sidebar';

// Calculate width (sidebar or no sidebar) to match content width
$active_sidebar_1 = is_active_sidebar( 'sidebar-1' );
$content_class = ( $active_sidebar_1 && ( $exopite_blog_list_layout == 'blog-list-left-sidebar' || $exopite_blog_list_layout == 'blog-list-right-sidebar' ) ) ? 'col-md-9' : 'col-md-12';

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
get_header();

?>

	<div class="container">
		<?php

        // Exopite hooks (includes/exopite-hooks.php)
        exopite_hooks_content_container_top();

		/*
		 * Display blog title if it is not turned off
		 */
		if ( isset( $exopite_settings['exopite-blog-display-title'] ) && $exopite_settings['exopite-blog-display-title'] ) : ?>
		<div class="row">
			<header class="<?php echo $content_class; ?>">
				<h1 class="page-title" itemprop="headline"><?php echo $exopite_settings['exopite-blog-title']; // Display the blog title ?></h1>
			</header>
		</div>
		<?php
        endif;

        ?>
		<div class="row">
			<?php

			/**
			 * Check left, right or no sidebar and set bootstrap col settings accordingly
			 */
            // Display sidebar if sidebar is on the left side
			if ( $active_sidebar_1 && $exopite_blog_list_layout == 'blog-list-left-sidebar' ) get_sidebar();

            ?>
			<div id="primary" class="<?php echo $content_class; ?> content-area">
				<main id="main" class="site-main">
				<?php

                /*
                 * Theme Hook Alliance hook
                 * GitHub: https://github.com/zamoose/themehookalliance
                 * File:   include/plugins/tha-theme-hooks.php
                 */
                tha_content_top();

                // Display blog page content before loop
                if ( $show_content ) {
                    echo get_post_field( 'post_content', $page_for_posts_id );
                }

				// Include a template this way, to passing variables
                include( locate_template( 'template-parts/loop.php' ) );

                // Display the loop
                echo the_loop();

                // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    			tha_content_bottom();

                ?>
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php

            // Display sidebar if sidebar is on the right side
            if ( $active_sidebar_1 && $exopite_blog_list_layout == 'blog-list-right-sidebar' ) get_sidebar();

            ?>
		</div><!-- .row -->
		<?php

        // Exopite hooks (include/exopite-hooks.php)
        exopite_hooks_content_container_bottom();

        ?>
	</div><!-- .container -->
<?php

get_footer();
