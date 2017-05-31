<?php
/**
 * Template part for displaying posts, archives and search with multiple column.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$article_classes = 'multi-column';
$article_classes .= ( $exopite_settings['exopite-blog-multi-column-layout-type'] == 'masonry' ) ? ' masonry' : '';

$post_password_required = post_password_required();

// To add default image class on password protected posts
if ( $post_password_required ) $article_classes .= ' has-post-thumbnail';

// Add no-gap class if gap is disabled
if ( $blog_no_gap && ! $blog_first_full_is_current ) $article_classes .= ' no-gap';

/*
 * Add card class if column layout with multiple column selected and this is not the first post with a full width
 */
if ( $blog_multi_column_layout_type == 'column' && $multi_row && ! $blog_first_full_is_current ) {
	$article_classes .= ' card';
} else {
    // Add col-md-6 on multi-column (but not column layout) and no sidebar and not to first post with full width
	if ( ( $posts_per_row > 2 || ( $multi_row  && $blog_list_layout == 'blog-list-without-sidebar' ) ) && ! $blog_first_full_is_current ) {
		$article_classes .= ' col-md-6';
	} else {
		$article_classes .= ' col-md-12';
	}
}

/*
 * Calculate Bootstrap columns for multi post per row,
 * if exopite-blog-first-full selected, then first article image on top and 100% size
 *
 * Do not add calculated columns if 'mansory' (column)
 */
if ( ! $blog_first_full_is_current && $blog_multi_column_layout_type != 'column' ) {

	// Add calculated columns if not mansory, for mansory layout float and width not needed.
	$article_classes .= ' col-lg-' . ( 12 / $posts_per_row );

} elseif ( $blog_first_full_is_current ) {

	// Add first-full class if exopite-blog-first-full activated and this is the first.
	$article_classes .= ' first-full';

}

/*
 * Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
 *
 * Beware: tha_entry_before hook will not show up with infinite scrolling!
 */
tha_entry_before();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $article_classes ); ?>>
	<div class="article-container">
		<?php

        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
        tha_entry_top();

		/*
		 * Display thumbnail here if multipe posts in one row or
		 * if image on top, left or zigzag and even
		 * and not 'image-none' selected
		 */
		if ( ( $multi_row && $blog_layout != 'image-none' ) ||
			$blog_first_full_is_current ) {

            $full_thumbnail = false;

            if ( ( $posts_per_row == 2 &&
                   $blog_list_layout == 'blog-list-without-sidebar' ) ||
                 ( $blog_first_full_is_current ) ) {
                $full_thumbnail = true;
            }

			/*
			 * exopite_display_post_thumbnail located in include/media.php
			 * If we have multiple posts in one row, then display image alwasy in top
			 */
			exopite_display_post_thumbnail( '', $full_thumbnail, get_the_title(), true );
		}

        //CONTENT
        include(locate_template('template-parts/content-post-entry.php'));

        ?>
			<footer class="entry-footer">
				<?php

				/*
				 * Hook to display:
				 * 	  - tags and categories, 10 (include/template-function.php)
				 */
				if ( ! $post_password_required ) exopite_hooks_posts_footer();

                ?>
			</footer><!-- .entry-footer -->
		<?php

        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
        tha_entry_bottom();

        ?>
	</div><!-- article-container -->
</article><!-- #post-## -->
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_entry_after();

?>

