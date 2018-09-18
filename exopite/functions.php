<?php
/**
 * Exopite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * ToDo:
 * - check jquery-ui, bootstrap411, fontawesome470 before enqueue
 * - create a checker function/class to see which as been enqueued (also combined)
 * - update to Bootstrap 4 beta 3
 * - single navigation on custom post type (first, last)
 * - desc for
 *  - Menu alignment (Top, Left)
 *  - Footer content (Widget or Page)
 *  - Preheader content ( -"- )
 *  - author and releated
 *  - Site branding type (Image or Widget)
 *  - Hero header type (Image, self hosting , Youtube or Google video)
 *  - Content layout (Wide or Boxed)
 *  - Blog item content length (full, exceprt, image)
 * - sidebar design: sidebar bg, widget bg, border-right, border-between
 * - footer top: border or shadow
 */

/*
 * filter e.g.:
 *
add_filter( 'exopite-desktop-logo', 'test', 10 );
function test( $logo ) {
    global $post;
    if ( '703' == $post->ID ) {
        return '';
    }
    return $logo;
}
 */
// Class to deal with options
if ( ! class_exists( 'ExopiteSettings' ) ) {
    class ExopiteSettings
    {
        public static $options = array();

        static public function setValue($key, $value) {
            ExopiteSettings::$options[$key] = $value;
        }

        static public function getValue($key) {
            if ( isset( ExopiteSettings::$options[$key] ) ) {
                return ExopiteSettings::$options[$key];
            } else {
                return null;
            }

        }

        static public function deleteValue($key) {
            unset( ExopiteSettings::$options[$key] );
        }

        static public function checkValue($key) {
            if ( array_key_exists( $key, ExopiteSettings::$options ) ) {
                return true;
            } else {
                return false;
            }
        }

    }
}

$exopite_settings = get_option( 'exopite_options' );

$exopite_content_width = ( isset( $exopite_settings['exopite-content-width'] ) ) ? $exopite_settings['exopite-content-width'] : 1050;
ExopiteSettings::setValue( 'exopite-content-width', $exopite_content_width );

ExopiteSettings::setValue( 'woocommerce-activated', in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
ExopiteSettings::setValue( 'allowed-htmls', array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
    'i' => array(
        'stlye' => array(),
        'class' => array()
    ),
    'b' => array(),
    'hr' => array(),
) );

/**
 * ----------------------------------------------------------------------------------------
 * 1.0 - Define constants.
 * ----------------------------------------------------------------------------------------
 */
define( 'EXOPITE_VERSION',  '20180916' );
defined( 'TEMPLATEPATH' ) or define( 'TEMPLATEPATH', get_template_directory() );
define( 'TEMPLATEURI', get_template_directory_uri() );
defined( 'STYLESHEETPATH' ) or define( 'STYLESHEETPATH', get_stylesheet_directory() );
define( 'SITEURL', site_url() );
define( 'SCRIPTS', TEMPLATEPATH . '/js' );
define( 'INC', TEMPLATEPATH . '/include' );
define( 'PLUGINS', INC . '/plugins' );

/**
 * Handle custom fonts
 */
require_once INC . '/generate_custom_fonts_css.php';

/**
 * Handle maintenance mode
 */
require_once INC . '/maintenance.php';

/*
 * Plugin installation and activation for WordPress themes.
 * Install and activate reqired and recommented plguins
 */
require_once PLUGINS . '/tgm-plugin-activation-init.php';

/**
 * Handle theme update
 */
require_once INC . '/update.php';

/*
 * CodeStar Framework
 *
 * http://codestarframework.com/
 *
 * Keep CodeSar Framework in a plugin and override settings inside theme,
 * in this way, the framework can be shared.
 * In this hook, after save, run some checks and generate JS and CSS file
 */
if ( is_admin() && defined( 'EXOPITE_CORE_URL' ) ) add_filter( 'cs_validate_save', 'exopite_cs_framework_save_options' );
function exopite_cs_framework_save_options( $options ) {

    require_once join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, 'cs-framework-override', 'on_save_options.php' ) );

    return on_save_options( $options );

}

add_action( 'after_setup_theme', 'exopite_setup' );
if ( ! function_exists( 'exopite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function exopite_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Exopite, use a find and replace
	 * to change 'exopite' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'exopite', TEMPLATEPATH . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Enable shortcodes in text widgets
	 *
	 * @link https://wordpress.org/support/topic/shortcode-in-text-widget-1
     * @link http://stackoverflow.com/questions/27277610/wordpress-shortcodes-in-footer-wont-work/27593600#27593600
	 */
    add_filter( 'widget_text', 'shortcode_unautop' );
	add_filter( 'widget_text', 'do_shortcode' );

    /**
     * Enable oembed in text widgets
     *
     * @link https://www.wpbeginner.com/wp-tutorials/how-to-enable-oembed-in-wordpress-text-widgets/
     */
    add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
    add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 8 );

    // This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_attr__( 'Primary Menu', 'exopite' ),
		'mobile' => esc_html__( 'Mobile Menu (optional)', 'exopite' ),
		'footer' => esc_html__( 'Footer Menu', 'exopite' ),
		'shortcode' => esc_html__( 'Shortcode Menu', 'exopite' ),
		'social' => esc_html__( 'Social Menu', 'exopite' ),
	) );

    /**
     * Declare WooCommerce support in third party theme
     *
     * @link https://docs.woocommerce.com/document/declare-woocommerce-support-in-third-party-theme/
     */
    add_theme_support( 'woocommerce' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

    add_theme_support( 'post-formats', array(
        // 'aside',
        // 'gallery',
        'link',
        'image',
        'quote',
        // 'status',
        'video',
        'audio',
        // 'chat',
    ) );

	/**
	 * Security
	 * remove junk from head
     *
	 * @link http://bhoover.com/remove-unnecessary-code-from-your-wordpress-blog-header/
	 */
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );  // prev link
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.

    /**
     * Remove JSON API links from header
     * for SEO reasons, XOVI issue a warning for too long urls.
     * This will not disable JSON API.
     *
     * @link https://wordpress.stackexchange.com/questions/211467/remove-json-api-links-in-header-html/212472#212472
     */
    // Remove the REST API lines from the HTML Header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    // Turn off oEmbed auto discovery.
    add_filter( 'embed_oembed_discover', '__return_false' );

    // Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    /*
     * Add Custom Post Type Support After Activating the Page Builder Plugin
     *
     * @link https://siteorigin.com/thread/add-custom-post-type-support-after-activating-the-page-builder-plugin/
     */
    /*
     * This will run IF pagebuilde already activated, need to check hooks and hook in siteorigin activation
     */
    if ( class_exists( 'SiteOrigin_Panels_Settings' ) ) {
        $post_types = SiteOrigin_Panels_Settings::single()->get( 'post-types' );
        $post_types[] = 'exopite-sections';
        SiteOrigin_Panels_Settings::single()->set( 'post-types', $post_types );
    }

	/**
	 * Allow HTML in author bio section
	 */
	remove_filter( 'pre_user_description', 'wp_filter_kses' );

    /**
     * Register theme specific image sizeses
     *
     * @link https://havecamerawilltravel.com/photographer/wordpress-thumbnail-crop
     */
    // Default sizes
    add_image_size( 'blog-list-full', 1020, 400, true );
    add_image_size( 'blog-list-multiple', 480, 320, true );
    add_image_size( 'releated', 330, 220, array( 'center', 'center' ) );
    add_image_size( 'avatar', 145, 145, array( 'center', 'center' ) );

    /*
     * Redirect to "Install Required Plugins" after theme activation.
     * Maybe for some user, it is not clear, theme required exopite-core plugin.
     */
    global $pagenow;
    if ( is_admin() &&
         'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

        // Check if get_plugins() function exists. This is required on the front end of the
        // site, since it is in a file that is normally only loaded in the admin.
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $installed_plugins = get_plugins();

        if ( ! isset( $installed_plugins['exopite-core/exopite-core.php'] ) ) {

            wp_redirect( admin_url( 'themes.php?page=tgmpa-install-plugins' ) );

        }

    }

}
endif;

// add to your theme's functions.php file
add_filter('upload_mimes', 'add_custom_upload_mimes');
function add_custom_upload_mimes($existing_mimes) {
    $existing_mimes['otf'] = 'application/x-font-otf';
    $existing_mimes['woff'] = 'application/x-font-woff';
    $existing_mimes['ttf'] = 'application/x-font-ttf';
    $existing_mimes['svg'] = 'image/svg+xml';
    $existing_mimes['eot'] = 'application/vnd.ms-fontobject';
    return $existing_mimes;
}

// Put post thumbnails into rss feed
add_filter('the_excerpt_rss', 'exopite_feed_post_thumbnail');
add_filter('the_content_feed', 'exopite_feed_post_thumbnail');
function exopite_feed_post_thumbnail($content) {
	global $post;
	if( has_post_thumbnail( $post->ID ) ) {
		$content = '' . $content;
	}
	return $content;
}


// /**
//  * Change search url structure from ?S=[term] to /search/term
//  * @link http://www.paulund.co.uk/redirect-wordpress-searches
//  *
//  * Leave here as example
//  * Will interfer with search form fields. It will clear "post_type".
//  */
// add_action('template_redirect', 'exopite_redirect_search' );
// if ( ! function_exists( 'exopite_redirect_search' ) ) {
// 	function exopite_redirect_search() {
// 		if ( is_search() && ! empty( $_GET['s'] ) ) {
// 			wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
// 			exit();
// 		}
// 	}
// }

/**
 * If only one search result then open page
 *
 * @link http://www.wpbeginner.com/wp-tutorials/auto-redirect-when-wordpress-search-query-only-returns-one-match/
 *
 * Leave here as example
 * I think, it is confusing for some user.
 */
// add_action('template_redirect', 'exopite_redirect_single_search_result');
// if ( ! function_exists( 'exopite_redirect_single_search_result' ) ) {
// 	function exopite_redirect_single_search_result() {
// 		if ( is_search() ) {
// 			global $wp_query;
// 			if ($wp_query->post_count == 1) {
// 				wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
// 			}
// 		}
// 	}
// }

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
add_action( 'after_setup_theme', 'exopite_content_width', 0 );
	if ( ! function_exists( 'exopite_content_width' ) ) {
	function exopite_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'exopite_content_width', ExopiteSettings::getValue( 'exopite-content-width') );
	}
}

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
add_action( 'widgets_init', 'exopite_widgets_init' );
if ( ! function_exists( 'exopite_widgets_init' ) ) {
	function exopite_widgets_init() {
		require_once( INC . '/sidebars.php' );
	}
}

/**
 * Change predefined variables in template file and optionally remove HTML comments.
 *
 * @link https://codex.wordpress.org/Class_Reference/Walker
 */
require_once INC . '/exopite-template.class.php';

/**
 * Replace WordPress nav menu walker to mobile menu and logo center function.
 *
 * @link https://codex.wordpress.org/Class_Reference/Walker
 */
require_once INC . '/nav_menu_walker.php';

/**
 * Add extra author contact methodes and skills.
 */
require_once INC . '/wp-tools/init.php';

/**
 * Add extra author contact methodes and skills.
 */
require_once INC . '/author-functions.php';

/**
 * Enqueue scripts and styles for admin area.
 */
require_once INC . '/backend-functions.php';

/**
 * Handle post formats for this theme.
 */
require_once INC . '/post-formats.php';

/**
 * Custom media functions for this theme.
 */
require_once INC . '/media.php';

/**
 * Custom template tags for this theme.
 */
require_once INC . '/template-functions.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once INC . '/extras.php';

/**
 * Search engine optimizations.
 */
require_once INC . '/seo.php';

/**
 * Search functions.
 */
require_once INC . '/search-functions.php';

/**
 * Sections custom post type.
 */
require_once INC . '/cpt-sections.php';

/**
 * Generate Google fonts query.
 */
require_once INC . '/google-fonts.php';

/**
 * Enqueue scripts and styles.
 */
require_once INC . '/enqueue.php';

/**
 * One click demo importer.
 */
// require_once PLUGINS . '/dt-demo-importer/init.php';
// require_once PLUGINS . '/dt-demo-importer/execute.php';

/**
 * Modifies tag cloud widget min and max font sizes.
 */
add_filter('widget_tag_cloud_args','exopite_set_tag_cloud_sizes');
if ( ! function_exists( 'exopite_set_tag_cloud_sizes' ) ) {
	function exopite_set_tag_cloud_sizes($args) {
		$args['smallest'] = 8;
		$args['largest'] = 16;
		return $args;
	}
}

/**
 * Exopite shortcodes
 */
require_once INC . '/shortcodes.php';

/**
 * Change the default excerpt, cut content,
 * only on comma or on sentence end.
 * Preserve some formatting.
 */
require_once 'template-parts/the_excerpt.php';

if ( isset( $exopite_settings['exopite-custom-excerpt-more-enabled'] ) && $exopite_settings['exopite-custom-excerpt-more-enabled'] ) {
    ExopiteSettings::setValue( 'exopite-custom-excerpt-more', $exopite_settings['exopite-custom-excerpt-more'] );
    if ( ! function_exists( 'exopite_excerpt_more' ) ) {
        function exopite_excerpt_more( $more ) {
            global $post;
            return ExopiteSettings::getValue( 'exopite-custom-excerpt-more' );
        }
    }
    add_filter( 'excerpt_more', 'exopite_excerpt_more', 98 );
}

// Add Theme Options to Admin Bar (to save time!)
add_action( 'admin_bar_menu', 'admin_bar_theme_editor_option', 100 );
if ( ! function_exists( 'admin_bar_theme_editor_option' ) ) {

    function admin_bar_theme_editor_option() {

        global $wp_admin_bar;
        if ( !is_super_admin() || !is_admin_bar_showing() ) return;
        $wp_admin_bar->add_menu( array(
            'id' => 'theme-options',
            'title' => __('Theme Options'),
            'href' => admin_url( 'themes.php?page=cs-framework')
        ) );

    }

}
//---------------------------------- PLUGINS -----------------------------------

/**
 * Plugin Name: T5 Comment moderation links
 * Version:     2012.06.04
 * Author:      Thomas Scholz <info@toscho.de>
 * Author URI:  http://toscho.de
 * License:     MIT
 * License URI: http://www.opensource.org/licenses/mit-license.php
 */
add_filter( 'edit_comment_link', 'exopite_comment_mod_links', 10, 2 );
if ( ! function_exists( 'exopite_comment_mod_links' ) ) {

    /**
     * Adds Spam and Delete links to the Sdit link.
     *
     * @wp-hook edit_comment_link
     * @param   string  $link Edit link markup
     * @param   int $id Comment ID
     * @return  string
     */
    function exopite_comment_mod_links( $link, $id ) {
        $template = ' <a class="comment-edit-link" href="%1$s%2$s">%3$s</a>';
        $admin_url = admin_url( "comment.php?c=$id&action=" );

        // Mark as Spam.
        $link .= sprintf( $template, $admin_url, 'cdc&dt=spam', __( 'Spam' ) );
        // Delete.
        $link .= sprintf( $template, $admin_url, 'cdc', __( 'Delete' ) );

        // Approve or unapprove.
        $comment = get_comment( $id );

        if ( '0' === $comment->comment_approved ) {

            $link .= sprintf( $template, $admin_url, 'approvecomment', __( 'Approve' ) );

        } else {

            $link .= sprintf( $template, $admin_url, 'unapprovecomment', __( 'Unapprove' ) );
        }

        return $link;
    }
}

add_action( 'current_screen', 'this_screen' );
function this_screen() {

    if ( ! defined( 'EXOPITE_CORE_URL' ) ) return;

    $current_screen = get_current_screen();

    /*
     * 'plugins'                               -> check if any changes general
     * 'appearance_page_tgmpa-install-plugins' -> on required or recommended plugin activation
     * 'appearance_page_cs-framework'          -> if all plugin installed
     */
    $screens = array( 'plugins' , 'appearance_page_tgmpa-install-plugins', 'appearance_page_cs-framework' );

    if( in_array( $current_screen->id, $screens ) ) {

        // Only on plugins is admin area and if user can de/activate plugins
        if ( current_user_can( 'activate_plugins' ) ) {

            require_once INC . '/plugin-management.class.php';

            Exopite_Plugin_Management::on_activation_changed();

        }

    }

}

/**
 * Include Theme Hook Alliance hooks.
 *
 * Source: https://github.com/zamoose/themehookalliance/blob/master/tha-theme-hooks.php
 *
 * Child theme authors and plugin developers need a consistent set of entry points to allow
 * for easy customization and altering of functionality. Core WordPress offers a suite of
 * [action hooks](http://codex.wordpress.org/Plugin_API/Action_Reference/) and
 * [template tags](http://codex.wordpress.org/Template_tags) but does not cover many of the
 * common use cases. The Theme Hook Alliance is a community-driven effort to agree on a set
 * of third-party action hooks that THA themes pledge to implement in order to give that
 * desired consistency.
 *
 * UPDATE:
 * Renamed and refactor to support original WordPress template hooks idea.
 * @link https://core.trac.wordpress.org/ticket/21506
 */
// require_once PLUGINS . '/tha-theme-hooks.php';
require_once INC . '/general-template-hooks.php';

/**
 * Exopite hooks
 */
require_once INC . '/exopite-hooks.php';

// Not working well with page builders, because its store content in meta fields.
// Load contact form 7 scripts & styles only when needed to save memory and time.
// add_action( 'wp_enqueue_scripts', 'exopite_wcs_cf7_scripts_conditional_load', 99 );
// if ( ! function_exists( 'exopite_wcs_cf7_scripts_conditional_load' ) ) {
// 	function exopite_wcs_cf7_scripts_conditional_load() {
// 		$load_scripts = false;
// 		if ( is_singular() ) {
// 			$post = get_post();
// 			if( ! has_shortcode( $post->post_content, 'contact-form-7' ) ) {
// 				wp_dequeue_script( 'contact-form-7' );
// 				wp_dequeue_style( 'contact-form-7' );
// 			}
// 		}
// 	}
// }

/*
 * Category Sticky Post
 *
 * Category Sticky Post allows you to mark a post to be displayed - or stuck -
 * to the top of each archive page for the specified category.
 *
 * Author:    Tom McFarlin <tom@tommcfarlin.com>
 * License:   GPL-2.0+
 * Link:      http://tommcfarlin.com/category-sticky-post/
 * Copyright: 2013 - 2015 Tom McFarlin
 */
if ( isset( $exopite_settings['exopite-enable-category-sticky'] ) && $exopite_settings['exopite-enable-category-sticky'] ) {
    require_once PLUGINS . '/class-category-sticky-post.php';
    add_action( 'after_setup_theme', array( 'Category_Sticky_Post', 'get_instance' ) );
}

/**
 * GZip compression for less data and more speed.
 */
if ( isset( $exopite_settings['exopite-seo-gzip-enabled'] ) && $exopite_settings['exopite-seo-gzip-enabled'] && ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) ) {
    require_once PLUGINS . '/filosofo-gzip-compression.php';
}

if ( ExopiteSettings::getValue( 'woocommerce-activated' ) ) {

    /**
     * WooCommerce releated functions.
     */
    require_once INC . '/woocommerce.php';
}

/**
 * This file incorporates code from Manta WordPress Theme,
 * Copyright (c) 2013 - 2016, PremiumWP https://wordpress.org/themes/manta.
 * Stargazer WordPress Theme is distributed under the terms of the GNU GPL.
 *
 * @link https://schema.org/docs/gs.html
 */
require_once PLUGINS . '/class-wp-schema.php';

//-------------------------------- END PLUGINS ---------------------------------
if ( file_exists( get_template_directory() . '/functions-extra.php' ) ) include get_template_directory() . '/functions-extra.php';
