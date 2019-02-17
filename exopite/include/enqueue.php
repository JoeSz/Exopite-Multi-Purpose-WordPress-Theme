<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Enqueue styles.
 *
 * Load with CDN if possible
 *
 * @link https://gtmetrix.com/why-use-a-cdn.html
 *
 * What is a CDN?
 *
 * A CDN is essentially a network of geographically dispersed servers.
 * Each CDN node (also called Edge Servers) caches the static content of a site like the images,
 * CSS/JS files and other structural components. The majority of an end-user's page load time is
 * spent on retrieving this content, and so it makes sense to provide these "building blocks"
 * of a site in as many server nodes as possible, distributed throughout the world.
 *
 * Why do I need a CDN?
 *
 * The number one reason for using a CDN is to improve your user's experience in terms of speed,
 * and as we know - speed matters!
 */

$exopite_settings = get_option( 'exopite_options' );

if ( ! function_exists( 'load_google_fonts' ) ) {
    function load_google_fonts() {

        $exopite_settings = get_option( 'exopite_options' );

        // Do not load is downlaod locally, it is then already inculded in css
        if ( ! ( isset( $exopite_settings['exopite-download-google-fonts'] ) && $exopite_settings['exopite-download-google-fonts'] ) ) {

            // If load Google fonts not async
            if ( isset( $exopite_settings['exopite-load-google-fonts-async'] ) && ! $exopite_settings['exopite-load-google-fonts-async'] ) {

                if ( ! is_admin() ){

                    // Generate Google fonts query string from options.
                    // include/google-fonts.php
                    $google_fonts = get_google_fonts();

                    wp_enqueue_style( 'wpb-google-fonts', 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://fonts.googleapis.com/css?family=' . $google_fonts['regular'], false );
                }

            }

        }

    }
}

if ( ! is_admin() ) add_action( 'wp_enqueue_scripts', 'load_exopite_styles' );
if ( ! function_exists( 'load_exopite_styles' ) ) {
	function load_exopite_styles() {

        $exopite_options = get_option( 'exopite_options' );

        if ( ! isset( $exopite_options['exopite-seo-use_cdns'] ) || $exopite_options['exopite-seo-use_cdns'] ) {

            /**
             * CDNs
             *
             * Get Bootstrap 4
             */
            wp_enqueue_style( 'bootstrap-431', 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '' ) . '://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', false, '4.3.1' );

            /* Get font awsome */
            wp_enqueue_style( 'font-awesome-470', 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's': '' ) . '://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false, '470' );

        }

        // Load google fonts in any selected
        if ( isset( $exopite_options['google_fonts'] ) && ! empty( $exopite_options['google_fonts'] ) ) {
            load_google_fonts();
        }

        /**
         * Enqueue scripts and styles with automatic versioning.
         *
         * https://www.doitwithwp.com/enqueue-scripts-styles-automatic-versioning/
         */
        /* Main stylesheet */
        $theme_css_path = TEMPLATEPATH . DIRECTORY_SEPARATOR . 'style.css';
        wp_enqueue_style( 'style', TEMPLATEURI . '/style.css', false, filemtime( $theme_css_path ) );

        /* User stylesheet */
        $theme_custom_css_uri = TEMPLATEURI . '/css/custom.css';
        $theme_custom_css_path = join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, 'css', 'custom.css' ) );
        wp_enqueue_style( 'custom', $theme_custom_css_uri, false, filemtime( $theme_custom_css_path ) );



	}
}

/**
 * Enqueue scripts.
 */
if ( ! is_admin() ) add_action( 'wp_enqueue_scripts', 'load_exopite_scripts', 100 );
if ( ! function_exists( 'load_exopite_scripts' ) ) {
	function load_exopite_scripts() {

        $exopite_options = get_option( 'exopite_options' );

        if ( ! isset( $exopite_options['exopite-seo-use_cdns'] ) || $exopite_options['exopite-seo-use_cdns'] ) {

            /**
             * CDNs
             *
             * Get Bootstrap 4
             */
            wp_enqueue_script( 'jquery-popper-1147', 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '' ) . ':////cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array( 'jquery' ), '1.14.7', true );

            wp_enqueue_script( 'bootstrap-431-js', 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '' ) . "://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js", array( 'jquery', 'jquery-popper-1147' ), '4.3.1', true );

        }

		/**
		 * Adds support for pages with threaded comments
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

        $theme_js_uri = TEMPLATEURI . '/js/scripts.js';
        $theme_js_path = join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, 'js', 'scripts.js' ) );
        wp_register_script( 'exopite-custom-scripts', $theme_js_uri, array( 'jquery' ), filemtime( $theme_js_path ), true);
        wp_enqueue_script( 'exopite-custom-scripts' );

        if ( isset( $exopite_options['exopite-blog-post-per-row'] ) &&
            ( $exopite_options['exopite-blog-post-per-row'] > 1  &&
              $exopite_options['exopite-blog-multi-column-layout-type'] == 'masonry' ) ) {

            wp_localize_script( 'exopite-custom-scripts', 'masonry',
                array(
                    'columns' => $exopite_options['exopite-blog-post-per-row'],
                )
            );
        }

        $theme_custom_js_uri = TEMPLATEURI . '/js/custom.js';
        $theme_custom_js_path = join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, 'js', 'custom.js' ) );
        wp_register_script( 'exopite-custom-js', $theme_custom_js_uri, array( 'jquery' ), filemtime( $theme_custom_js_path ), true);
        wp_enqueue_script( 'exopite-custom-js' );

	}
}
