<?php
/**
 * Template part for page as preheader.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$exopite_settings = get_option( 'exopite_options' );

// Add container if content is boxed
if ( ( ! $exopite_settings['exopite-sidebar-preheader-full-width'] || $exopite_settings['exopite-content-layout'] == 'boxed' ) ) : ?>
    <div class="container">
<?php
endif;

/*
 * Alternative, but it does not call the_conent filter and
 * if I call or use setup_postdata, it will call the page content
 * instead of the "footer" content
 */
/*
 * From "regular" post/page
 *
 * $id = $exopite_settings['exopite-preheader-from-page'];
 * $pre_header = get_post( $id );
 * the_content();
 */
$args = array(
    'post_type' => 'exopite-sections',
    'p' => apply_filters( 'exopite-preheader-from-page', $exopite_settings['exopite-preheader-from-page'] )
);

$preheader_from_page_query = new WP_Query( $args );

while( $preheader_from_page_query->have_posts() ): $preheader_from_page_query->the_post();

    the_content();

endwhile;

wp_reset_postdata();

if ( ( ! $exopite_settings['exopite-sidebar-preheader-full-width'] || $exopite_settings['exopite-content-layout'] == 'boxed' ) ) : ?>
    </div><!-- .container -->
<?php
endif;
