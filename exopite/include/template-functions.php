<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Exopite
 *
 * Functions:
 *  - exopite_categorized_blog (pluggable)
 *  - exopite_category_transient_flusher (pluggable)
 *  - exopite_post_meta (pluggable)
 *  - exopite_display_post_tags_categories (pluggable)
 *  - exopite_post_tags_and_categories (pluggable)
 *  - exopite_post_meta_date_badge (pluggable)
 *  - exopite_display_skip_to_content (pluggable)
 *  - exopite_content_top_padding (pluggable)
 *  - exopite_hooks_posts_divider (pluggable)
 *  - exopite_404_search_recommendations (pluggable)
 *  - exopite_404_content_search (pluggable)
 *  - exopite_filter_before_second_item (pluggable, Example filter)
 *  - exopite_hooks_posts_before_second_excerpt_item (pluggable, Example hook)
 *
 */

$exopite_settings = get_option( 'exopite_options' );

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
if ( ! function_exists( 'exopite_categorized_blog' ) ) {
	function exopite_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'exopite_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'exopite_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so exopite_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so exopite_categorized_blog should return false.
			return false;
		}
	}
}

/**
 * Flush out the transients used in exopite_categorized_blog.
 */
add_action( 'edit_category', 'exopite_category_transient_flusher' );
add_action( 'save_post',     'exopite_category_transient_flusher' );
if ( ! function_exists( 'exopite_category_transient_flusher' ) ) {
	function exopite_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'exopite_categories' );
	}
}

/**
 * Display post meta (sticky, author, date, comment count and edit link)
 */
if ( ! function_exists( 'exopite_post_meta' ) ) {
	function exopite_post_meta() {

		global $wp_query;
		global $posts;

		$exopite_settings = get_option( 'exopite_options' );

        $author = $date = $commentcount = $lastmodified = '';

		if ( get_post_type() === 'post' ) {
			echo '<ul class="list-inline entry-meta">';

			// If the post is sticky, mark it.
			if ( is_sticky() ) {
				echo '<li class="meta-featured-post"><i class="fa fa-thumb-tack"></i> ' . esc_attr__( 'Sticky', 'exopite' ) . ' </li>';
			}

			if( ! isset( $exopite_settings['exopite-single-meta-tags-to-display'] ) ||
                array_key_exists( 'author', $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) :
			// Get the post author.
			$author = sprintf(
				'<li class="meta-author">By <a href="%1$s" rel="author"%2$s>%3$s</a></li>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                WP_Schema::get_attribute( 'author', false ),
				get_the_author()
			);
			endif;

			if( ! isset( $exopite_settings['exopite-single-meta-tags-to-display'] ) ||
                array_key_exists( 'date', $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) :
			// Get the date.
			$date = '<li class="meta-date"> <a href="' . esc_url( get_site_url() ) . '/' . get_the_date( 'Y' ) . '/' . get_the_date( 'm' ) . '/' . get_the_date( 'd' ) . '" rel="date">' . get_the_date() . '</a> </li>';
			endif;

            if( ! isset( $exopite_settings['exopite-single-meta-tags-to-display'] ) ||
                array_key_exists( 'lastmodified', $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) :
            // Get last modification date.
            // https://andorwp.com/how-to-display-last-update-date-for-posts-and-pages-in-wordpress/
            $u_time = get_the_time('U');
            $u_modified_time = get_the_modified_time('U');

            if ($u_modified_time >= $u_time + 86400) {
                $lastmodified = '<li class="meta-last-modified"><time datetime="' . get_the_modified_time('Y-m-d') . '">';
                $lastmodified .= esc_attr__( ' Last modified on ', 'exopite' );
                $lastmodified .= get_the_modified_time( get_option( 'date_format' ) );
                $lastmodified .= '</time></li>';
            }
            endif;

			if( ! isset( $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ||
                ( array_key_exists( 'commentcount', $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) &&
                  $exopite_settings['exopite-show-comments'] ) ) :
				// Comments link.
				if ( comments_open() ) :
				//if ( comments_open() && ( is_single() || have_comments() ) ) :
					$commentcount = '<li class="meta-reply">';
                    ob_start();
					if ( is_single() ) {
						comments_popup_link(
                            esc_attr__( 'Let us know what you think!', 'exopite' ),
							esc_attr__( 'One comment so far', 'exopite' ),
							esc_attr__( 'View all % comments', 'exopite' )
						);
					} else {
						comments_popup_link(
                            wp_kses( __( '<i class="fa fa-comment" aria-hidden="true"></i>', 'exopite' ), ExopiteSettings::getValue( 'allowed-htmls' ) ),
							wp_kses( __( '<i class="fa fa-comment" aria-hidden="true"></i>', 'exopite' ), ExopiteSettings::getValue( 'allowed-htmls' ) ),
							wp_kses( __( '<i class="fa fa-comment" aria-hidden="true"></i>', 'exopite' ), ExopiteSettings::getValue( 'allowed-htmls' ) )
						);
					}
                    $commentcount .= ob_get_clean();
					$commentcount .= '</li>';
				endif;
			endif;

            $exopite_single_meta_tags_to_display = ( isset( $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) ?
                $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] :
                array( 'author' => 'enabled', 'date' => 'enabled', 'lastmodified' => 'enabled', 'commentcount' => 'enabled' );

            foreach ( $exopite_single_meta_tags_to_display as $key => $value) {

                switch ( $key ) {
                    case 'author':
                        echo $author;
                        break;
                    case 'date':
                        echo $date;
                        break;
                    case 'lastmodified':
                        echo $lastmodified;
                        break;
                    case 'commentcount':
                        echo $commentcount;
                        break;

                }
            }

			// Edit link.
			if ( is_user_logged_in() ) {
				echo ' <li class="meta-edit">';
				edit_post_link( esc_attr__( 'Edit', 'exopite' ), '', '' );
				echo '</li>';
			}
			echo "</ul>";
		}
	}
}

/**
 * Display and hook tags and categories
 */
add_action( 'exopite_hooks_post_footer', 'exopite_display_post_tags_categories', 10 );
add_action( 'exopite_hooks_posts_footer', 'exopite_display_post_tags_categories', 10 );
if ( ! function_exists( 'exopite_display_post_tags_categories' ) ) {
    function exopite_display_post_tags_categories() {

    	$exopite_settings = get_option( 'exopite_options' );

    	/*
    	 * Display tags and categories on post, posts
    	 */
    	if ( 'post' === get_post_type() &&
             ( ! isset( $exopite_settings['exopite-single-display-post-tags_categories'] ) ||
               $exopite_settings['exopite-single-display-post-tags_categories'] == true ) ) {

    		exopite_post_tags_and_categories();
    	}
    }
}

if ( ! function_exists( 'exopite_post_tags_and_categories' ) ) {
	function exopite_post_tags_and_categories() {

		$exopite_settings = get_option( 'exopite_options' );

		if ( ( ! isset( $exopite_settings['exopite-blog-display-tags_categories'] ) ||
               ! $exopite_settings['exopite-blog-display-tags_categories'] ) &&
             ! is_single() ) {
			return;
		}

		if ( isset( $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) &&
             empty( $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) return;

		// Tags
		if( ! isset( $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ||
            array_key_exists( 'categories', $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) :

    		// The categories. ?>
    		<ul class="tags-and-categories list-plain">
    		<?php $category_list = get_the_category_list( '/' );

    		if ( $category_list ) {
    			echo '<li class="meta-categories"> ' . $category_list . ' </li>';
    		}

        endif;

		// Categories
		if( ! isset( $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ||
            array_key_exists( 'tags', $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) :

    		// The tags.
    		$tag_list = get_the_tag_list( '', ' ' );

    		if ( $tag_list ) {
    			echo '<li class="meta-tags"> ' . $tag_list . ' </li>';
    		}

            ?>
    		</ul>
    		<?php
		endif;
	}
}

/**
 * Display post date meta in badge
 */
if ( ! function_exists( 'exopite_post_meta_date_badge' ) ) {
	function exopite_post_meta_date_badge() {

		$exopite_settings = get_option( 'exopite_options' );

		if( ! array_key_exists( 'badge', $exopite_settings['exopite-single-meta-tags-to-display']['enabled'] ) ) return;
		?>
		<div class="post-date-wrapper">
			<div class="post-date-month-day">
				<div class="post-date-month"><a href="<?php echo esc_url( get_site_url() ) . '/' . esc_html( get_the_date( 'Y' ) ) . '/' . esc_html( get_the_date( 'm' ) ); ?>" rel="date"><?php echo get_the_date( 'M' ) ?></a></div>
				<div class="post-date-day"><a href="<?php echo esc_url( get_site_url() ) . '/' . esc_html( get_the_date( 'Y' ) ) . '/' . esc_html( get_the_date( 'm' ) ) . '/' . esc_html( get_the_date( 'd' ) ); ?>" rel="date"><?php echo get_the_date( 'j' ) ?></a></div>
			</div>
			<div class="post-date-year"><a href="<?php echo esc_url( get_site_url() ) . '/' . esc_html( get_the_date( 'Y' ) ); ?>" rel="date"><?php echo get_the_date( 'Y' ) ?></a></div>
		</div>
		<?php
	}
}

/**
 * Display "skip to content" link
 */
/*
add_action( 'wp_body_top', 'exopite_display_skip_to_content', 10 );
if ( ! function_exists( 'exopite_display_skip_to_content' ) ) {
	function exopite_display_skip_to_content() { ?>
		<a class="skip-link" href="#content" title="<?php esc_html_e( 'Skip to content', 'exopite' ); ?>"><i class="fa fa-chevron-down" aria-hidden="true"></i>
</a>

	<?php }
}
*/

/**
 * Display "scroll to top" arrow
 */
add_action( 'wp_body_top', 'exopite_display_scroll_to_top', 20 );
if ( ! function_exists( 'exopite_display_scroll_to_top' ) ) {
	function exopite_display_scroll_to_top() {
		?>
		<a href="#" class="scrollToTop"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
	<?php }
}

/**
 * Set top padding for blog, archives and search
 */
add_action( 'exopite_hooks_content_container_top', 'exopite_content_top_padding', 10 );
if ( ! function_exists( 'exopite_content_top_padding' ) ) {
	function exopite_content_top_padding() {
		if ( ! is_single() || is_author() ) : ?>
		<div id="content-top-padding"></div>
		<?php endif;
	}
}

/**
 * Hook to display divider after each post in blog/posts list
 */
add_action( 'exopite_hooks_posts_display_divider', 'exopite_hooks_posts_divider', 10 );
if ( ! function_exists( 'exopite_hooks_posts_divider' ) ) {
	function exopite_hooks_posts_divider() {
		echo '<hr class="blog-divider">';
	}
}

if ( ! function_exists( 'exopite_delete_spam_comment_link' ) ) {
	function exopite_delete_spam_comment_link( $id ) {
		if ( current_user_can( 'edit_post' ) ) {
			echo '| <a href="' . admin_url( "comment.php?action=cdc&c=$id" ) . '">del</a> ';
			echo '| <a href="' . admin_url( "comment.php?action=cdc&dt=spam&c=$id" ) . '">spam</a>';
		}
	}
}

add_action( 'exopite_hooks_404_search_recommendations', 'exopite_404_search_recommendations', 10 );
if ( ! function_exists( 'exopite_404_search_recommendations' ) ) {
    function exopite_404_search_recommendations() {

        ?>
        <div class="row recommendations">
            <div class="col-12 col-md-4">
                <?php

                // Show recent posts
                the_widget( 'WP_Widget_Recent_Posts' );

                ?>
            </div>
            <div class="col-12 col-md-4">
                <?php

                // Only show the widget if site has multiple categories.
                if ( exopite_categorized_blog() ) :

                    ?>
                    <div class="widget widget_categories">
                        <h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'exopite' ); ?></h2>
                        <ul>
                        <?php
                            wp_list_categories( array(
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                                'show_count' => 1,
                                'title_li'   => '',
                                'number'     => 5,
                            ) );
                        ?>
                        </ul>
                    </div><!-- .widget -->
                    <?php
                endif;
                ?>
            </div>
            <div class="col-12 col-md-4">
                <?php

                /*
                 * Limit number of tags in WordPress tag cloud widget
                 *
                 * http://mekshq.com/limit-number-of-tags-in-wordpress-tag-cloud-widget/
                 *
                 * Register tag cloud filter callback
                 */
                add_filter('widget_tag_cloud_args', 'tag_widget_limit');

                //Limit number of tags inside widget
                function tag_widget_limit( $args ){

                    //Check if taxonomy option inside widget is set to tags
                    if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
                        $args['number'] = 20; //Limit number of tags
                    }

                    return $args;
                }

                the_widget( 'WP_Widget_Tag_Cloud' );

                ?>
            </div>
        </div>

        <?php

    }
}

add_action( 'exopite_hooks_404_content', 'exopite_404_content_search', 10 );
if ( ! function_exists( 'exopite_404_content_search' ) ) {
    function exopite_404_content_search() {

        $search = esc_attr( substr( $_SERVER['REQUEST_URI'], strrpos( $_SERVER['REQUEST_URI'], '/' ) + 1) );

        $args = array(
            'blog_first_full' => false,
            'blog-post-per-row' => 3,
            'show_not_found' => false,
            'query_args' => array(
                's' => $search,
                'posts_per_page' => 3,
            ),
        );

        function custom_excerpt_length( $length ) {
            return 15;
        }
        add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

        // Include a template this way, to passing variables
        include( locate_template( 'template-parts/loop.php' ) );

        // Display the loop
        echo the_loop( $args );

    }
}

/**
 * Hook and filter do display something inportant after Xth posts item
 *
 * Use with the erliama_filter_before_nth_item filter,
 * which contain the number of the specific post
 */
/*
add_filter( 'exopite_filter_before_nth_item', 'exopite_filter_before_second_item' );
if ( ! function_exists( 'exopite_filter_before_second_item' ) ) {
    function exopite_filter_before_second_item() {
        return 2;
    }
}

add_action( 'exopite_hooks_posts_before_nth_excerpt_item', 'exopite_hooks_posts_before_second_excerpt_item', 10 );
if ( ! function_exists( 'exopite_hooks_posts_before_second_excerpt_item' ) ) {
    function exopite_hooks_posts_before_second_excerpt_item() {
        echo "This is something important after the second post<br>";
        exopite_hooks_posts_display_divider();
    }
}
*/
