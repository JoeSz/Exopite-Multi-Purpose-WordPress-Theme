<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Admin area
 *
 * Functions:
 *  - enqueue_admin_styles_scripts (pluggable)
 *  - exopite_admin_thumbnails (pluggable)
 *  - exopite_thumbnail_column_title (pluggable)
 *  - exopite_thumbnail_columns_content (pluggable)
 *  - exopite_add_taxonomies_to_pages (pluggable)
 *  - exopite_category_and_tag_archives (pluggable)
 *  - exopite_replace_footer_admin (pluggable)
 *  Make the user role sortable in the WordPress user list
 *  - exopite_replace_footer_admin
 *  - exopite_pre_user_query
 *
 */
$exopite_enable_category_sticky = ( isset( $exopite_settings['exopite-enable-category-sticky'] ) ) ?
    $exopite_settings['exopite-enable-category-sticky'] :
    true;

ExopiteSettings::setValue( 'exopite-enable-category-sticky', $exopite_enable_category_sticky );
add_action( 'admin_enqueue_scripts', 'enqueue_admin_styles_scripts' );
if ( ! function_exists( 'enqueue_admin_styles_scripts' ) ) {
    function enqueue_admin_styles_scripts(){

        global $pagenow;

        if ( $pagenow == 'profile.php' ) {
            wp_enqueue_media();
        }

        // Load only in specific admin page(s)
        // http://wordpress.stackexchange.com/questions/1058/loading-external-scripts-in-admin-but-only-for-a-specific-post-type
        wp_register_style('admin_style', TEMPLATEURI . '/css/admin.css' , true, "all");
        wp_enqueue_style('admin_style');

        wp_register_script( 'exopite-admin-script', TEMPLATEURI . '/js/admin/admin.js', array( 'jquery' ), false, true);
        wp_enqueue_script( 'exopite-admin-script' );

        if ( ExopiteSettings::getValue('exopite-enable-category-sticky') ) {
            wp_register_script( 'exopite-category-sticky-admin-script', TEMPLATEURI . '/js/admin/category-sticky-admin.js', array( 'jquery' ), false, true);
            wp_enqueue_script( 'exopite-category-sticky-admin-script' );

            wp_register_script( 'exopite-category-sticky-editor-script', TEMPLATEURI . '/js/admin/category-sticky-editor.js', array( 'jquery' ), false, true);
            wp_enqueue_script( 'exopite-category-sticky-editor-script' );
        }

        if ( $pagenow == 'themes.php' || $pagenow == 'post.php' ) {

            wp_register_script( 'sticky-anything', TEMPLATEURI . '/js/jquery.sticky-anything.js', array( 'jquery' ), false, true);
            wp_enqueue_script( 'sticky-anything' );

            wp_register_script( 'sticky-anything-load', TEMPLATEURI . '/js/jquery.sticky-anything.load-admin.js', array( 'sticky-anything' ), false, true);
            wp_enqueue_script( 'sticky-anything-load' );

        }
    }
}

/**
 * Show featured or post first image on pages and posts list
 *
 * @link http://wordpress.stackexchange.com/questions/8427/change-order-of-custom-columns-for-edit-panels
 * @link http://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
 */
if ( ! function_exists( 'exopite_admin_thumbnails' ) ) {
	function exopite_admin_thumbnails() {

		add_filter( 'manage_posts_columns', 'exopite_thumbnail_column_title' );
		add_action( 'manage_posts_custom_column', 'exopite_thumbnail_columns_content', 10, 2 );
		add_filter( 'manage_pages_columns', 'exopite_thumbnail_column_title' );
		add_action( 'manage_pages_custom_column', 'exopite_thumbnail_columns_content', 10, 2 );

	}

	exopite_admin_thumbnails();
}

if ( ! function_exists( 'exopite_thumbnail_column_title' ) ) {
	function exopite_thumbnail_column_title($columns) {
		$new = array();
		foreach( $columns as $key => $title ) {
			if ( $key=='title' ) // Put the Image column before the Title column
				$new['featured_image'] = esc_attr__( 'Image', 'exopite' );
			$new[$key] = $title;
		}
		return $new;
	}
}

if ( ! function_exists( 'exopite_thumbnail_columns_content' ) ) {
	function exopite_thumbnail_columns_content( $column_name, $post_ID ) {
		if ($column_name == 'featured_image') {
			$post_featured_image = get_featured_image($post_ID);
			if ($post_featured_image) {
				// HAS A FEATURED IMAGE
				ob_start();
				the_post_thumbnail( array(40, 40), 'admin-list-thumb' );
				$featured_image = ob_get_clean();
				if ( function_exists('has_post_thumbnail') && has_post_thumbnail( $post_ID ) ) {
					echo '<a href="' . wp_get_attachment_image_src( get_post_thumbnail_id( $post_ID ), 'full' )[0] . '">';
					echo $featured_image;
					echo "</a>";
				} else {
					echo $featured_image;
				}
			} else {
				// NO FEATURED IMAGE, SHOW THE DEFAULT ONE
				echo '<img style="width: 40px; height: 40px;" src="' . esc_url( get_bloginfo( 'template_url' ) ) . '/img/placeholder.png" />';
			}
		}
	}
}

/**
 * How to Add Categories and Tags to Pages in WordPress
 *
 * @link http://spicemailer.com/wordpress/add-categories-tags-pages-wordpress/
 */
add_action( 'init', 'exopite_add_taxonomies_to_pages' );
if ( ! function_exists( 'exopite_add_taxonomies_to_pages' ) ) {
	function exopite_add_taxonomies_to_pages() {
		register_taxonomy_for_object_type( 'post_tag', 'page' );
		register_taxonomy_for_object_type( 'category', 'page' );
	}
}

if ( ! is_admin() ) {
	add_action( 'pre_get_posts', 'exopite_category_and_tag_archives' );
}
if ( ! function_exists( 'exopite_category_and_tag_archives' ) ) {
	function exopite_category_and_tag_archives( $wp_query ) {
		$my_post_array = array('post','page');

		if ( $wp_query->get( 'category_name' ) || $wp_query->get( 'cat' ) )
			$wp_query->set( 'post_type', $my_post_array );

		if ( $wp_query->get( 'tag' ) )
			$wp_query->set( 'post_type', $my_post_array );
	}
}

/**
 * Replace admin footer
 */
add_filter('admin_footer_text', 'exopite_replace_footer_admin');
if ( ! function_exists( 'exopite_replace_footer_admin' ) ) {
    function exopite_replace_footer_admin() {

        ob_start();
        timer_stop(1);
        $timer = ob_get_contents();
        ob_end_clean();

        echo '<p class="alignleft">Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="http://joe.szalai.org" target="_blank">Joe Szalai</a> | WordPress Tutorials: <a href="http://www.wpbeginner.com" target="_blank">WPBeginner</a>';
        echo '&nbsp;| <span class="admin-stats">'. sprintf(  '%d queries in %s seconds, using %.2f kB memory',
            get_num_queries(),
            $timer,
            memory_get_peak_usage() / 1024
        ) . '</span></p>';
    }
}

/**
 * Make the user role sortable in the WordPress user list
 *
 * @link http://fastwpdesign.co.uk/how-to-make-the-user-role-sortable-in-the-wordpress-user-list/
 */
if ( is_admin() ) {
    add_filter( 'manage_users_sortable_columns', 'exopite_user_sortable_columns' );
    add_action('pre_user_query','exopite_pre_user_query');
}

function exopite_user_sortable_columns( $columns ) {
    $columns['role'] = 'role';
    return $columns;
}

function exopite_pre_user_query( $user_search ) {
    global $wpdb,$current_screen;

    if ( 'users' != $current_screen->id ) return;

    $vars = $user_search->query_vars;

    if ('role' == $vars['orderby']) {
        $user_search->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='{$wpdb->prefix}user_level')";
        $user_search->query_orderby = ' ORDER BY UPPER(m1.meta_value) '. $vars['order'];
    }
}
