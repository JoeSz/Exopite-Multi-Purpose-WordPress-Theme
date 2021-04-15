<?php
/**
 * The header for our theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Exopite
 *
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Settings from admin option codestar framework
 */
$exopite_settings = get_option( 'exopite_options' );

/**
 * Set defaults
 * It is no default values from option framework, until exopite-core plugin is installed and activated.
 */
$exopite_menu_alignment = ( isset( $exopite_settings['exopite-menu-alignment'] ) ) ?
    $exopite_settings['exopite-menu-alignment'] :
    'top';
$exopite_desktop_logo_position = ( isset( $exopite_settings['exopite-desktop-logo-position'] ) ) ?
    $exopite_settings['exopite-desktop-logo-position'] :
    'top';
$exopite_desktop_logo_alignment = ( isset( $exopite_settings['exopite-desktop-logo-alignment'] ) ) ?
    $exopite_settings['exopite-desktop-logo-alignment'] :
    'text-center flex-center';
$exopite_desktop_menu_horizontal_alignment = ( isset( $exopite_settings['exopite-desktop-menu-horizontal-alignment'] ) ) ?
    $exopite_settings['exopite-desktop-menu-horizontal-alignment'] :
    'menu-center';
$exopite_desktop_menu_vertical_alignment = ( isset( $exopite_settings['exopite-desktop-menu-vertical-alignment'] ) ) ?
    $exopite_settings['exopite-desktop-menu-vertical-alignment'] :
    'menu-middle';
$exopite_mobile_menu_search = ( isset( $exopite_settings['exopite-mobile-menu-search'] ) ) ?
    $exopite_settings['exopite-mobile-menu-search'] :
    true;
$exopite_mobile_menu_position = ( isset( $exopite_settings['exopite-mobile-menu-position'] ) ) ?
    $exopite_settings['exopite-mobile-menu-position'] :
    'left';
$exopite_settings_enable_hero_header = ( isset( $exopite_settings['exopite-enable-hero-header-front-page'] ) ) ?
    $exopite_settings['exopite-enable-hero-header-front-page'] :
    true;
$exopite_menu_full_width = ( isset( $exopite_settings['exopite-menu-full-width'] ) ) ?
    $exopite_settings['exopite-menu-full-width'] :
    false;

/**
 * Possibility to override menu with filter
 */
$exopite_menu_alignment = apply_filters( 'exopite-menu-alignment', $exopite_menu_alignment );
$exopite_desktop_logo_position = apply_filters( 'exopite-desktop-logo-position', $exopite_desktop_logo_position );
$exopite_desktop_logo_alignment = apply_filters( 'exopite-desktop-logo-alignment', $exopite_desktop_logo_alignment );
$exopite_desktop_menu_horizontal_alignment = apply_filters( 'exopite-desktop-menu-horizontal-alignment', $exopite_desktop_menu_horizontal_alignment );
$exopite_desktop_menu_vertical_alignment = apply_filters( 'exopite-desktop-menu-vertical-alignment', $exopite_desktop_menu_vertical_alignment );
$exopite_mobile_menu_search = apply_filters( 'exopite-mobile-menu-search', $exopite_mobile_menu_search );
$exopite_mobile_menu_position = apply_filters( 'exopite-mobile-menu-position', $exopite_mobile_menu_position );
$exopite_settings_enable_hero_header  = apply_filters( 'exopite-enable-hero-header-front-page', $exopite_settings_enable_hero_header );
$exopite_menu_full_width  = apply_filters( 'exopite-menu-full-width', $exopite_menu_full_width );

$exopite_menu_search = ( isset( $exopite_settings['exopite-desktop-menu-search'] ) && $exopite_settings['exopite-desktop-menu-search'] == false ) ? false : true;
$exopite_menu_search =  apply_filters( 'exopite-desktop-menu-search', $exopite_menu_search );
/**
 * Individual page/post settings
 */
$exopite_meta_data_type = 'exopite_custom_post_options';
if ( is_page() ) {
    $exopite_meta_data_type = 'exopite_custom_page_options';
}
$exopite_meta_data = get_post_meta( get_queried_object_ID(), $exopite_meta_data_type, true );

$exopite_show_desktop_logo = isset( $exopite_meta_data['exopite-meta-desktop-logo'] ) ? $exopite_meta_data['exopite-meta-desktop-logo'] : true;
$exopite_show_menu = isset( $exopite_meta_data['exopite-meta-enable-menu'] ) ? $exopite_meta_data['exopite-meta-enable-menu'] : true;
$exopite_show_header = isset( $exopite_meta_data['exopite-meta-enable-header'] ) ? $exopite_meta_data['exopite-meta-enable-header'] : true;
$exopite_body_classes = isset( $exopite_meta_data['exopite-meta-enable-menu'] ) ? esc_attr( $exopite_meta_data['exopite-meta-extra-body-classes'] ) : '';
$exopite_display_breadcrumbs = isset( $exopite_meta_data['exopite-meta-enable-breadcrumbs'] ) ? $exopite_meta_data['exopite-meta-enable-breadcrumbs'] : true;
$exopite_display_preheader_sidebar = isset( $exopite_meta_data['exopite-meta-enable-preheader-sidebar'] ) ? $exopite_meta_data['exopite-meta-enable-preheader-sidebar'] : true;
ExopiteSettings::setValue( 'exopite-meta-enable-breadcrumbs', $exopite_display_breadcrumbs );

// Check if diplay hero header
$exopite_meta_data_enable_hero_header = isset( $exopite_meta_data['exopite-enable-hero-header'] ) ? $exopite_meta_data['exopite-enable-hero-header'] : false;
$exopite_display_hero_header = false;

/**
 * Hero header
 * In settings control the front page,
 * in meta control other than front page.
 *
 * Display hero header if:
 * - hero header enabled in settings and this is the font apge
 * - hero header enabled in settings and page settings (meta) and not front page
 */
if( isset( $exopite_settings['exopite-enable-hero-header'] ) && $exopite_settings['exopite-enable-hero-header'] ) {
    if ( ( is_front_page() && $exopite_settings_enable_hero_header ) || (  ! is_front_page() && $exopite_meta_data_enable_hero_header ) ) {
        $exopite_display_hero_header = true;
    }
}

// Hero header extra inline style to override height dinamically from page meta
$exopite_override_hero_header_height = false;
if ( $exopite_display_hero_header && isset( $exopite_meta_data['exopite-hero-header-height'] ) && $exopite_meta_data['exopite-hero-header-height'] > 0 && $exopite_settings['exopite-hero-header-height'] != $exopite_meta_data['exopite-hero-header-height'] ) {
    $exopite_override_hero_header_height = true;

    add_action('wp_print_scripts', function() use( $exopite_meta_data ) {
        ?><style type="text/css">@supports(object-fit: cover){.meta-height{height:<?php echo $exopite_meta_data['exopite-hero-header-height']; ?>vh !important;}}</style><?php
    });

}

$exopite_override_hero_header_min_height = false;
if ( $exopite_display_hero_header && isset( $exopite_meta_data['exopite-hero-header-min-height'] ) && $exopite_meta_data['exopite-hero-header-min-height'] > 0 && $exopite_settings['exopite-hero-header-min-height'] != $exopite_meta_data['exopite-hero-header-min-height'] ) {
    $exopite_override_hero_header_min_height = true;

    add_action('wp_print_scripts', function() use( $exopite_meta_data ) {
        ?><style type="text/css">@supports(object-fit: cover){.meta-height{min-height:<?php echo $exopite_meta_data['exopite-hero-header-min-height']; ?>px !important;}}</style><?php
    });

}

// Determinate if Load Google fonts async or enqueue in the normal way.
// Google font async is loading by javascript
$exopite_html_class = ( isset( $exopite_settings['exopite-load-google-fonts-async'] ) && ! $exopite_settings['exopite-load-google-fonts-async'] ) ? 'class="wf-active" ' : '';

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
wp_doctype();
/**
 * Minifying HTML output
 * Start output buffering
 */
if ( isset( $exopite_settings['exopite-minify-html'] ) &&
     $exopite_settings['exopite-minify-html'] &&
     class_exists( 'Exopite_Minifier' ) ) {

    ob_start();
}

?>
<!DOCTYPE html>
<html <?php echo apply_filters( 'exopite-html-classes', $exopite_html_class ); ?><?php language_attributes(); ?>>
<head>
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
wp_head_top();

?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, shrink-to-fit=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php

// https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head
wp_head();

// If load Google fonts async
if ( ( isset( $exopite_settings['exopite-load-google-fonts-async'] ) && $exopite_settings['exopite-load-google-fonts-async'] ) && ! ( isset( $exopite_settings['exopite-download-google-fonts'] ) && $exopite_settings['exopite-download-google-fonts'] ) ) {
    get_template_part( 'template-parts/font-async' );
} elseif ( isset( $exopite_settings['google-font-files'] ) ) {
    /**
     * Add preload to local Google font files.
     * If not local, we can not change the css which load the fonts.
     */
    //google-font-files
    foreach ( $exopite_settings['google-font-files'] as $key => $google_font_file ) {
        ?>
        <link rel="preload" crossorigin="anonymous" href="<?php echo $google_font_file; ?>" as="font">
        <?php
    }
}

/**
 * Preload FontAwesome if local.
 */
if ( isset( $exopite_settings['exopite-seo-use_cdns'] ) && ! $exopite_settings['exopite-seo-use_cdns'] ) :
    ?>
    <link rel="preload" crossorigin="anonymous" href="<?php echo get_template_directory_uri(); ?>/fonts/fontawesome-webfont.woff2?v=4.7.0" as="font">
    <?php
endif;

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
wp_head_bottom();

?>
</head>
<body <?php body_class( explode( ' ', apply_filters( 'exopite-body-classes', $exopite_body_classes ) ) ); ?><?php WP_Schema::get_attribute( 'body' ); ?>>
<?php

/***
 * Hook display:
 *  - Skip to content, 10 (include/template-functions.php)
 */
wp_body_top();

if ( isset( $exopite_settings['exopite-menu-alignment'] ) && $exopite_settings['exopite-menu-alignment'] == 'overlay' ) {
    include( locate_template( 'template-parts/menu-overlay.php' ) );
}

// Full page search
if ( $exopite_menu_search ||$exopite_mobile_menu_search ) {
    get_template_part( 'template-parts/full-search' );
}

// Diplay hero header on top menu
if ( $exopite_menu_alignment == 'top' && apply_filters( 'exopite-display-hero-header', $exopite_display_hero_header ) ) :

    include( locate_template( 'template-parts/hero-header.php' ) );

endif;

?>
<div id="page" class="site">
    <?php

    // If show header
    if ( apply_filters( 'exopite-enable-header', $exopite_show_header ) ) :

        // Remove preheader hooks, if preheader isn't displayed
        if ( ! $exopite_display_preheader_sidebar ) :
            remove_action( 'exopite_hooks_navigation_top', 'display_preheader_sidebar', 10 );
            remove_action( 'wp_header_before', 'display_preheader_sidebar', 10 );
            remove_action( 'wp_content_before', 'display_preheader_sidebar', 10 );
        endif;

        /**
         * Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
         *
         * Hook display:
         *  - pre header widgets, 10 (include/sidebars.php)
         *    'exopite-preheader-content' filter, widget or page
         */
        wp_header_before();

        // Show/Hide menu
        if ( apply_filters( 'exopite-enable-menu', $exopite_show_menu ) ) :

            include( locate_template( 'template-parts/menu.php' ) );

        endif; // Hide menu

        /**
         * Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
         *
         * Hook display:
         *  - if header on top: after header widgets, 10 (include/sidebars.php)
         */
        wp_header_after();

    endif;
    ?>
    <div id="content-with-footer">
        <?php

        // Menu toggle for side menu
        if ( isset( $exopite_menu_alignment ) && $exopite_menu_alignment == 'left' ) : ?>
        <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
        <?php
        endif;

        // Diplay hero header on side menu
        if( $exopite_menu_alignment != 'top' && apply_filters( 'exopite-display-hero-header', $exopite_display_hero_header ) ) :

            include( locate_template( 'template-parts/hero-header.php' ) );

        endif;

        /**
         * Add boxed marker to side menu on layout boxed,
         * to add color or image background to preheader, content and footer.
         */
        if ( $exopite_menu_alignment == 'left' && $exopite_settings['exopite-content-layout'] == 'boxed' ) : ?>
        <div id="boxed-content">
        <?php
        endif;

        /**
         * Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
         *
         * Hook display:
         *  - if header on left: after header widgets, 10 (include/sidebars.php)
         */
        wp_content_before();

        ?>
        <div id="content" class="site-content content primary">
