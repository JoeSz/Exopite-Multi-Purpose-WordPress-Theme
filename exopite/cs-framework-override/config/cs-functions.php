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

add_action( 'cs_websafe_fonts_variants', 'cs_websafe_fonts_variants_custom', 10, 1 );
function cs_websafe_fonts_variants_custom( $variants ) {
    return array(
        '300',
        '300italic',
        'regular',
        'italic',
        '600',
        '600italic',
        '700',
        '700italic',
        'inherit'
    );
}

add_action( 'cs_typography_family', 'cs_typography_family_custom', 10, 2 );
function cs_typography_family_custom( $family_value, $typography ) {
    $exopite_settings = get_option( 'exopite_options' );

    $default_custom_variants =  array(
        '300',
        '300italic',
        '400',
        '400italic',
        '600',
        '600italic',
        'inherit'
    );

    // file_put_contents( get_stylesheet_directory() . '/settings.log', date('Y-m-d H:i:s') . ' - ' . var_export( $exopite_settings, true ) . PHP_EOL, FILE_APPEND );

    if ( isset( $exopite_settings['exopite-custom-fonts'] ) && ! empty( $exopite_settings['exopite-custom-fonts'] ) ) {
        echo '<optgroup label="'. esc_html__( 'Custom Fonts', 'cs-framework' ) .'">';
        foreach ( $exopite_settings['exopite-custom-fonts'] as $custom_font ) {
            echo '<option value="'. $custom_font['exopite-local-font-name'] .'" data-variants="'. implode( '|', $default_custom_variants ) .'" data-type="custom"'. selected( $custom_font['exopite-local-font-name'], $family_value, true ) .'>'. $custom_font['exopite-local-font-name'] .'</option>';
        }
        echo '</optgroup>';
    }

}
