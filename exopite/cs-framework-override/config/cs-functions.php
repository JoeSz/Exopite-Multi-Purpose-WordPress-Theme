<?php defined('ABSPATH') or die( 'You cannot access this page directly.' );

// List registered image sizes
if ( ! function_exists( 'exopite_get_image_sizes' ) ) {
    function exopite_get_image_sizes( $slug = false ) {
        $image_sizes = get_intermediate_image_sizes();
        $image_sizes = sanitize_string_or_array( $image_sizes );
        if ( $slug ) {
            foreach ( $image_sizes as $key => $value ) {
                if ( $value == $slug ) {
                    return $key;
                }
            }
            return 0;
        } else {
            return $image_sizes;
        }

    }
}

// List all registered sidebars
if ( ! function_exists( 'get_sidebars' ) ) {
    function get_sidebars( $add_empty = false ) {
        $sidebars = array();
        if( $add_empty ) $sidebars += ['none' => esc_attr__( 'none' )]; // Use WordPress translation
        foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
            $sidebars += [$sidebar['id'] => esc_attr( $sidebar['name'] )];
        }
        return $sidebars;
    }
}

// Check localhost
if ( ! function_exists( 'is_localhost' ) ) {
    function is_localhost() {
        $localhost = array('127.0.0.1', "::1");
        if( in_array( $_SERVER['REMOTE_ADDR'], $localhost ) ) {
            return esc_attr__( ' For localhost you could use ', 'exopite' ) . ' <a href="https://wordpress.org/plugins/wp-mail-smtp/" target="_blank">WP Mail SMTP</a>.';
        }
    }
}

// Get section (custom post type for preheader and footer)
if ( ! function_exists( 'get_sections' ) ) {
    function get_sections() {

        $args = array( 'post_type' => 'exopite-sections', 'posts_per_page' => -1 );
        $loop = new WP_Query( $args );
        $sections = array();

        while ( $loop->have_posts() ) : $loop->the_post();
            $sections += [get_the_ID() => get_the_title()];
        endwhile;

        return $sections;
    }
}
