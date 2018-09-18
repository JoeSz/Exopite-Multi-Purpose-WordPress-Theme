<?php
/**
 * Template part for displaying posts, archives and search.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$post_password_required = post_password_required();

$article_classes = 'col-md-12 single-column';

// To add default image
if ( $post_password_required ) $article_classes .= ' has-post-thumbnail';

// Add first-full class if exopite-blog-first-full activated and this is the first.
if ( $blog_first_full_is_current ) $article_classes .= ' first-full';

/**
 * Add image-aside class if image on the left or right side and only one post per row,
 * if not exopite-blog-first-full selected and this is the first
 */
if ( ! ( $blog_layout == 'image-top' || $blog_layout == 'image-none' ) && ! $multi_row && ! $blog_first_full_is_current ) {
    $article_classes .= ' image-aside';
} elseif ( $blog_layout == 'image-top'  && ! $multi_row ) {
    $article_classes .= ' image-top ';
}

if ( ( get_post_format() == 'video' || get_post_format() == 'audio' ) && ! empty( get_post_meta( get_the_id(), 'media_thumbnail', true ) ) ) {
    $article_classes .= ' has-post-thumbnail ';
}

/**
 * Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
 *
 * wp_post_before hook will not show up with infinite scrolling
 */
wp_post_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $article_classes ); ?>>
	<div class="article-container">
		<?php wp_post_top();
        /**
         * Display thumbnail here if multipe posts in one row or
         * if image on top, left or zigzag and even
         * and not 'image-none' selected
         */
        if ( ( $multi_row && $blog_layout != 'image-none' ) ||

            $blog_first_full_is_current ) {

            /**
             * exopite_display_post_thumbnail located in include/media.php
             * If we have multiple posts in one row, then display image always in top
             */
            exopite_display_post_thumbnail( '', $blog_first_full_is_current, get_the_title(), false );

        } else {

            switch ( $blog_layout ) {
                case 'image-zigzag':
                    if ( $wp_query->current_post % 2 == 0 ) {
                        exopite_display_post_thumbnail( ' image-left', $blog_first_full_is_current, get_the_title(), false );
                    }
                    break;
                case 'image-left':
                    exopite_display_post_thumbnail( ' image-left', $blog_first_full_is_current, get_the_title(), false );
                    break;
                case 'image-top':
                    exopite_display_post_thumbnail( '', true, get_the_title(), false );
                    break;
            }

        }

        //CONTENT
        include(locate_template('template-parts/content-post-entry.php'));

		/**
		 * Display thumbnail here if image on right or zigzag and odd
		 */
		if ( ! $blog_first_full_is_current ) {

			switch ( $blog_layout ) {
				case 'image-zigzag':
					if ( $wp_query->current_post % 2 == 1 ) {
						exopite_display_post_thumbnail( ' image-right', false, get_the_title(), false );
					}
					break;
				case 'image-right':
					exopite_display_post_thumbnail( ' image-right', false, get_the_title(), false );
					break;
			}

		} ?>
			<footer class="entry-footer">
				<?php

				/**
				 * Hook to display:
				 * 	  - tags and categories, 10 (include/template-function.php)
				 */
				if ( ! $post_password_required ) exopite_hooks_posts_footer();

                ?>
			</footer><!-- .entry-footer -->
		<?php

        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
        wp_post_bottom();

		if ( ! $blog_first_full_is_current || ! is_sticky() ) :

			/**
			 * Hook to display post divider, run after each post in blog,
			 * priority and function: 10 (include/template-functions.php)
			 */
			exopite_hooks_posts_display_divider();
		endif;

        ?>
	</div><!-- article-container -->
</article><!-- #post-## -->
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
wp_post_after();
