<?php
/**
 * Template part for page as footer.
 *
 * Get page content by ID and display inside the footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$args = array(
    'post_type' => 'exopite-sections',
    'p' => apply_filters( 'exopite-footer-from-page', $exopite_settings['exopite-footer-from-page'] )
);

$footer_from_page_query = new WP_Query( $args );

?>
<div class="footer-background">
<?php

// Add container if content is boxed
if ( ! $exopite_settings['exopite-footer-from-page-full-width'] || $exopite_settings['exopite-content-layout'] == 'boxed' ) : ?>
    <div class="container">
<?php
endif;

// loop through the query (even though it's just one page)
while ( $footer_from_page_query->have_posts() ) : $footer_from_page_query->the_post();

    the_content();

endwhile;

if ( ! $exopite_settings['exopite-footer-from-page-full-width'] || $exopite_settings['exopite-content-layout'] == 'boxed' ) : ?>
    </div><!-- .container -->
<?php
endif;

?>
</div><!-- .footer-background -->
<?php

// reset post data (important, don't leave out!)
wp_reset_postdata();
