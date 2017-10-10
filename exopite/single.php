<?php
/**
 * The template for displaying right sidebar single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * Get theme options
 * Get individual post settings
 */
$exopite_settings = get_option( 'exopite_options' );
$exopite_meta_data = get_post_meta( get_the_ID(), 'exopite_custom_post_options', true );

/*
 * Display "before content sidebar" sidebar from page/post meta
 *
 * Check this first, so if no any sidebar assigned to content top, do not run other codes
 */
if ( isset( $exopite_meta_data['exopite-meta-before-content-sidebar-id'] ) &&
    $exopite_meta_data['exopite-meta-before-content-sidebar-id'] != 'none' ) {

    include( locate_template( 'template-parts/content-top-sidebar.php' ) );

}

// Determinate sidebar location, default right side
$sidebar = 'right';
if ( isset( $exopite_meta_data['exopite-meta-sidebar-layout'] ) ) {
    switch ( $exopite_meta_data['exopite-meta-sidebar-layout'] ) {
        case 'exopite-meta-sidebar-left':
            $sidebar = 'left';
            break;
        case 'exopite-meta-sidebar-none':
            $sidebar = 'none';
            break;
    }
}

get_header();

?>
	<div class="container with-right-sidebar">
		<?php

        // Exopite hooks (include/exopite-hooks.php)
        exopite_hooks_content_container_top();

        ?>
		<div class="row">
            <?php

            // Sidebar on the left side
            if ( $sidebar == 'left' ) get_sidebar();

            ?>
			<div id="primary" class="<?php if ( $sidebar != 'none' ) : ?>col-md-9<?php else : ?>col-md-12<?php endif; ?> content-area">
				<main id="main" class="site-main"<?php WP_Schema::get_attribute( 'site-main' ); ?>>
				<?php

                // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                tha_content_top();
				tha_content_while_before();

				while ( have_posts() ) : the_post();

                    // Possibility to use content-custom-post-type.php, if not exist post will be loaded
                    $page_template_type = ( locate_template( 'template-parts/content-' . get_post_type() . '.php') != '') ? get_post_type() : 'post';

                    get_template_part( 'template-parts/content', apply_filters( 'exopite-post-content-template-part-slug', $page_template_type ) );

					/**
					 * If comments are open or we have at least one comment, load up the comment template.
					 */
					if ( ( comments_open() ||
                         get_comments_number() ) &&
                        ( ! isset( $exopite_settings['exopite-show-comments'] ) || $exopite_settings['exopite-show-comments'] == true ) ) :
						comments_template();
					endif;

				endwhile; // End of the loop.

                // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                tha_content_while_after();
				tha_content_bottom();

                ?>
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php

            // Sidebar on the right side
            if ( $sidebar == 'right' ) get_sidebar();

            ?>
		</div><!-- .row -->
	</div><!-- .container -->
<?php

get_footer();
