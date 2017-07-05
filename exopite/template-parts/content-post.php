<?php
/**
 * Template part for displaying single post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$exopite_settings = get_option( 'exopite_options' );

/**
 * Get individual page/post settings
 */
$post_password_required = post_password_required();
$exopite_meta_data = get_post_meta( get_the_ID(), 'exopite_custom_page_options', true );
$show_title =  isset( $exopite_meta_data['exopite-meta-enable-title'] ) ? esc_attr( $exopite_meta_data['exopite-meta-enable-title'] ) : true;
$show_thumbnail = isset( $exopite_meta_data['exopite-meta-enable-thumbnail'] ) ? esc_attr( $exopite_meta_data['exopite-meta-enable-thumbnail'] ) : true;
$show_meta = isset( $exopite_meta_data['exopite-meta-enable-meta'] ) ? esc_attr( $exopite_meta_data['exopite-meta-enable-meta'] ) : true;
$exopite_display_author = isset( $exopite_meta_data['exopite-meta-display-author'] ) ? esc_attr( $exopite_meta_data['exopite-meta-display-author'] ) : false;
$exopite_display_post_nav = isset( $exopite_meta_data['exopite-meta-display-post-nav'] ) ? esc_attr( $exopite_meta_data['exopite-meta-display-post-nav'] ) : false;
$exopite_display_releated_posts = isset( $exopite_meta_data['exopite-meta-display-releated-posts'] ) ? esc_attr( $exopite_meta_data['exopite-meta-display-releated-posts'] ) : false;

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_entry_before();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_entry_top();

    /**
     * Display featured image (post thumbnail)
     */
    if ( has_post_thumbnail() && $show_thumbnail && is_single() && ! $post_password_required ) : // If has thumbnail and not hide it and single post ?>
	<div class="entry-thumbnail">
		<a href="<?php echo esc_url( wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full')[0] ); ?>"><?php the_post_thumbnail(); ?></a>
	</div><!-- .entry-thumbnail -->
    <?php endif;

    /**
     * Display header only if title ot meta are displayed
     */
    if ( $show_title || $show_meta && $exopite_settings['exopite-single-display-post-meta'] == true ): ?>
	<header class="entry-header">
		<?php

		/**
		 * Display the title
		 */
		if ( $show_title ) :

			the_title( '<h1 class="entry-title page-title">', '</h1>' );
		elseif ( ! $show_title && $post_password_required ) :

            // Title on password protected post
            ?>
			<h1><?php _e( 'Protected: This post is password protected.', 'exopite' ); ?></h1>
			<?php
		endif;

		/**
		 * Display the meta information like user/created date/category/tags/comment(s)/edit if logged in
		 */
        $exopite_single_display_post_meta = ( isset ( $exopite_settings['exopite-single-display-post-meta'] ) ) ?
            $exopite_settings['exopite-single-display-post-meta'] :
            true;

		if ( $show_meta && $exopite_single_display_post_meta && ! $post_password_required ) : ?>
		<div class="entry-meta">
			<?php

            exopite_post_meta();

            ?>
		</div><!-- .entry-meta -->
		<?php endif;

        // Exopite hooks (include/exopite-hooks.php)
		exopite_hooks_post_header();

		?>
	</header><!-- .entry-header -->
    <?php endif;

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_entry_content_before();

    ?>
	<div class="entry-content">
		<?php

		/**
		 * Display content or excerpt
		 */
		the_content( sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'exopite' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );

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
    tha_entry_content_after();

    ?>
	<footer class="entry-footer">
		<?php

        // Remove author bio based on meta settings
        if ( ! apply_filters( 'exopite-display-author-bio', $exopite_display_author ) ) :
            remove_action( 'exopite_hooks_post_footer', 'exopite_display_author_bio', 20 );
        endif;

        // Remove post navigation based on meta settings
        if ( ! apply_filters( 'exopite-hooks-post-footer', $exopite_display_post_nav ) ) :
            remove_action( 'exopite_hooks_post_footer', 'exopite_post_nav', 25 );
        endif;

        // Remove releated posts based on meta settings
        if ( ! apply_filters( 'exopite-display-releated-posts', $exopite_display_releated_posts ) ) :
            remove_action( 'exopite_hooks_post_footer', 'exopite_display_releated_posts', 30 );
        endif;

		/**
		 * Hook to display:
		 * 	  - tags and categories, 10 (include/template-functions.php)
		 * 	  - social share 		 15 (include/social-share.php)
		 * 	  - author bio,			 20 (include/template-functions.php)
		 * 	  - post navigation 	 25 (include/extra.php)
		 * 	  - releated posts 		 30 (include/extra.php)
		 */
		if ( ! $post_password_required ) exopite_hooks_post_footer();

        ?>
	</footer><!-- .entry-footer -->
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_entry_bottom();

    ?>
</article><!-- #post-## -->
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_entry_after();
