<?php
/**
 * The template for displaying archive with a page assigned.
 * Basically display the content of the assigned page by ID.
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

// New query with the page ID
$archive_page_query = new WP_Query( 'page_id=' . $archive_id );

// Get post meta for individual page settings
$exopite_meta_data = get_post_meta( $id, 'exopite_custom_page_options', true );

// Determinate sidebar position, default right
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

// get theme options
$exopite_settings = get_option( 'exopite_options' );

?>
    <div class="container with-right-sidebar">
        <?php

        // Exopite hooks (include/exopite-hooks.php)
        exopite_hooks_content_container_top();

        ?>
        <div class="row">
            <?php

            // Display sidebar on the right
            if ( $sidebar == 'left' ) get_sidebar();

            ?>
            <div id="primary" class="<?php if ( $sidebar != 'none' ) : ?>col-md-9<?php else : ?>col-md-12<?php endif; ?> content-area">
                <main id="main" class="site-main" tabindex="-1">
                    <?php

                    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                    tha_content_top();
                    tha_content_while_before();

                    while ( $archive_page_query->have_posts() ) : $archive_page_query->the_post();

                        get_template_part( 'template-parts/content', 'page' );

                    endwhile; // End of the loop.

                    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                    tha_content_while_after();
                    tha_content_bottom();

                    ?>
                </main><!-- #main -->
            </div><!-- #primary -->
            <?php

            // Display sidebar on the right
            if ( $sidebar == 'right' ) include( locate_template( 'sidebar.php' ) );

            ?>
        </div><!-- .row -->
    </div><!-- .container -->
<?php

wp_reset_postdata();
