<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );
/**
 * ToDo:
 * - if sidebar active add post abstand
 * - design pasword protected
 */

/*
 * Individual page/post settings
 */
$post_password_required = post_password_required();
$exopite_meta_data = get_post_meta( get_the_ID(), 'exopite_custom_page_options', true );
$show_title = isset( $exopite_meta_data['exopite-meta-enable-title'] ) ? esc_attr( $exopite_meta_data['exopite-meta-enable-title'] ) : true;
$show_thumbnail = isset( $exopite_meta_data['exopite-meta-enable-thumbnail'] ) ? esc_attr( $exopite_meta_data['exopite-meta-enable-thumbnail'] ) : true;

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
wp_post_before();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    wp_post_top();

    ?>
	<div class="entry-thumbnail">
		<?php

		/**
		 * Display featured image (post thumbnail)
		 */
		if ( has_post_thumbnail() && $show_thumbnail && ! $post_password_required ) : // If has thumbnail and not hide it and single post ?>
			<a href="<?php echo esc_url( wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full')[0] ); ?>"><?php the_post_thumbnail(); ?></a>
		<?php endif; ?>
	</div><!-- .entry-thumbnail -->
	<header class="entry-header">
		<?php

		if ( $show_title ) :

            // Display title
			the_title( '<h1 class="entry-title page-title">', '</h1>' );
		elseif ( ! $show_title && $post_password_required ) :

            // Title nn passwrod protected pages
            ?>
			<h1 class="entry-title"><?php _e( 'Protected: This post is password protected.', 'exopite' ); ?></h1>
			<?php
		endif;

		?>
	</header><!-- .entry-header -->
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    wp_post_content_before();

    ?>
	<div class="entry-content">
		<?php

			the_content();

            /*
             * Displays page-links for paginated posts (i.e. includes the <!--nextpage--> Quicktag one or more times).
             * https://codex.wordpress.org/Function_Reference/wp_link_pages
             */
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'exopite' ),
				'after'  => '</div>',
			) );

		?>
	</div><!-- .entry-content -->
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    wp_post_content_after();

    ?>
	<footer class="entry-footer">
		<?php

			if ( ! $post_password_required ) exopite_hooks_page_footer();

            // If user can edit post
            // https://codex.wordpress.org/Template_Tags/get_edit_post_link
            if ( get_edit_post_link() ) {

    			edit_post_link(
    				sprintf(
    					// translators: %s: Name of current post
    					esc_html__( 'Edit %s', 'exopite' ),
    					the_title( '<span class="screen-reader-text">"', '"</span>', false )
    				),
    				'<span class="edit-link">',
    				'</span>'
    			);
            }

		?>
	</footer><!-- .entry-footer -->
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    wp_post_bottom();

    ?>
</article><!-- #post-## -->
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
wp_post_after();
