<?php
/**
 * Exopite sidebars/widget areas functions.
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * ToDo:
 * - sanitize
 */

/*
 * Register main sidebar
 */
register_sidebar( array(
    'name'          => esc_attr__( 'Sidebar', 'exopite' ),
    'id'            => 'sidebar-1',
    'description'   => esc_attr__( 'Main sidebar. Displayed on the side of the site. Add widgets here.', 'exopite' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
) );

$exopite_settings = get_option( 'exopite_options' );

$exopite_sidebar_preheader_full_width = ( isset( $exopite_settings['exopite-sidebar-preheader-full-width'] ) ) ?
    $exopite_settings['exopite-sidebar-preheader-full-width'] :
    true;
$exopite_preheader_content = ( isset( $exopite_settings['exopite-preheader-content'] ) ) ? $exopite_settings['exopite-preheader-content'] : 'widget';

ExopiteSettings::setValue( 'exopite-sidebar-preheader-full-width', $exopite_sidebar_preheader_full_width );
ExopiteSettings::setValue( 'exopite-preheader-content', $exopite_preheader_content );

/*
 * Register user definied sidebars
 */
if ( isset( $exopite_settings['exopite-sidebars'] ) && is_array( $exopite_settings['exopite-sidebars'] ) ) {
    foreach ( $exopite_settings['exopite-sidebars'] as $key => $sidebar ) {

        if ( $sidebar['exopite-sidebar-name'] == "" ) continue;

        register_sidebar( array(
            'name'          => esc_attr( $sidebar['exopite-sidebar-name'] ),
            'id'            => esc_variable( $sidebar['exopite-sidebar-name'] ),
            'description'   => esc_attr( $sidebar['exopite-sidebar-description'] ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

    }
}

$has_footer_menu = has_nav_menu( 'footer' );

if ( ! function_exists( 'exopite_register_sidebars' ) ) {
    function exopite_register_sidebars( $count, $sidebar_settings, $active_sidebars_variable_name = null ) {
        $active_sidebars = array();
        for ($i=0; $i < $count; $i++) {
            if ( $sidebar_settings[$i]['id'] == "" ) continue;
            register_sidebar( array(
                'name' =>  $sidebar_settings[$i]['title'],
                'id' => $sidebar_settings[$i]['id'],
                'description' => $sidebar_settings[$i]['description'],
                'before_widget' => '<div id="%1$s" class="widget-container widget-area %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );

            if ( is_active_sidebar( $sidebar_settings[$i]['id'] ) ) $active_sidebars[] = $sidebar_settings[$i]['id'];
        }

        ExopiteSettings::setValue( $active_sidebars_variable_name, $active_sidebars );
    }
}

if ( ! function_exists( 'exopite_display_sidebars' ) ) {
    function exopite_display_sidebars( $active_sidebars_variable_name, $sidebar_class, $column_presets = 'equal', $add_container = true ) {

        $active_sidebars = ExopiteSettings::getValue( $active_sidebars_variable_name );

        $active_sidebars_count = count( $active_sidebars );
        if ( $active_sidebars_count === 0 ) return;

        switch ( $column_presets ) {
            case '12':
                $cols_sidebars = array( 4, 8 );
                break;
            case '21':
                $cols_sidebars = array( 8, 4 );
                break;
            case '112':
                $cols_sidebars = array( 3, 3, 6 );
                break;
            case '121':
                $cols_sidebars = array( 3, 6, 3 );
                break;
            case '211':
                $cols_sidebars = array( 6, 3, 3 );
                break;
            default:
                $cols_sidebars = 12 / $active_sidebars_count;
                break;
        }

        echo '<div class="' . $sidebar_class . '-background">'; // Background image/color
        $container = 'container';
        if ( ExopiteSettings::getValue( 'exopite-sidebar-preheader-full-width' ) && $sidebar_class == 'preheader' ) {
            $container = 'container-fluid';
        }
        if ( $add_container ) echo '<div class="' . $container . '">'; // Container to hold content width
        echo '<div class="row row-' . $sidebar_class . '">'; // Row for columns
        foreach ( $active_sidebars as $sidebar_id ) {
            if ( is_array( $cols_sidebars ) ) {
                echo '<div class="col-md-' . array_shift( $cols_sidebars ) . '">';
            } else {
                echo '<div class="col-md-' . $cols_sidebars . '">';
            }
            dynamic_sidebar( $sidebar_id );// Active sidebar by id
            echo '</div>';
        }
        echo '</div><!-- .row .row-' . $sidebar_class . ' -->';
        if ( $add_container ) echo '</div><!-- .container -->';
        echo '</div><!-- .' . $sidebar_class . '-background -->';
    }
}

/*
 * Preheader sidebar
 */
if ( isset( $exopite_settings['exopite-sidebar-preheader-count'] ) && $exopite_settings['exopite-sidebar-preheader-count'] > 0 ) {
    $sidebar_settings_preheader =  array(
         array( 'title' => esc_attr__( 'Preheader Widget Area - First', 'exopite' ),
            'id' => 'preheader-widget-area-first',
            'description' => esc_attr__( 'First preheader widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
         array( 'title' => esc_attr__( 'Preheader Widget Area - Second', 'exopite' ),
            'id' => 'preheader-widget-area-second',
            'description' => esc_attr__( 'Second preheader widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
         array( 'title' => esc_attr__( 'Preheader Widget Area - Third', 'exopite' ),
            'id' => 'preheader-widget-area-third',
            'description' => esc_attr__( 'Third preheader widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
         array( 'title' => esc_attr__( 'Preheader Widget Area - Fourth', 'exopite' ),
            'id' => 'preheader-widget-area-fourth',
            'description' => esc_attr__( 'Fourth preheader widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
     );

    // Preheader widget areas
    exopite_register_sidebars( $exopite_settings['exopite-sidebar-preheader-count'], $sidebar_settings_preheader, 'active_preheader_sidebars' );

}

if ( isset( $exopite_settings['exopite-menu-alignment'] ) ) {
    if ( $exopite_settings['exopite-menu-alignment'] == 'top' ) {
        add_action( 'tha_header_before', 'display_preheader_sidebar', 10 );
    } else {
        add_action( 'tha_content_before', 'display_preheader_sidebar', 10 );
    }
}

function display_preheader_sidebar() {

    if ( has_filter( 'exopite-preheader-content' ) ) {
        apply_filters( 'exopite-preheader-content' );
    } elseif ( ExopiteSettings::getValue( 'exopite-preheader-content' ) == 'widget' ) {
        exopite_display_sidebars( 'active_preheader_sidebars', 'preheader' );
    } elseif ( ExopiteSettings::getValue( 'exopite-preheader-content' ) == 'page' ) {
        include( locate_template( 'template-parts/preheader-from-page.php' ) );
    }

}

/*
 * Side of the logo sidebar, Only show up if it is not empty, logo in top of the menu and not centriert.
 */
if ( isset( $exopite_settings['exopite-desktop-logo-position'] ) && (
     $exopite_settings['exopite-desktop-logo-position'] == 'top' ||
     $exopite_settings['exopite-desktop-logo-position'] == 'top-in-menu' ) ) {

    if ( $exopite_settings['exopite-desktop-logo-alignment'] == 'text-right flex-right' || $exopite_settings['exopite-desktop-logo-alignment'] == 'text-center flex-center' ) {

        $sidebar_settings_left_side_logo_widget_area =  array(
            array( 'title'    => esc_attr__( 'Left side of the logo Widget Area', 'exopite' ),
                'id'          => 'left-side-logo-widget-area',
                'description' => esc_attr__( 'Left side of the logo widget area. Only show up if it is not empty, logo in top of the menu and logo on the right side or centriert.', 'exopite' ),
            ),
        );

        exopite_register_sidebars( 1, $sidebar_settings_left_side_logo_widget_area );

    }

    if ( $exopite_settings['exopite-desktop-logo-alignment'] == 'text-left flex-left' || $exopite_settings['exopite-desktop-logo-alignment'] == 'text-center flex-center' ) {

        $sidebar_settings_right_side_logo_widget_area =  array(
            array( 'title'    => esc_attr__( 'Right side of the logo Widget Area', 'exopite' ),
                'id'          => 'right-side-logo-widget-area',
                'description' => esc_attr__( 'Right side of the logo widget area. Only show up if it is not empty, logo in top of the menu and logo on the left side or  centriert.', 'exopite' ),
            ),
        );

        exopite_register_sidebars( 1, $sidebar_settings_right_side_logo_widget_area );

    }

}

/*
 * Hero header site branding sidebar
 */
if ( isset( $exopite_settings['exopite-enable-hero-header'] ) &&
     $exopite_settings['exopite-enable-hero-header'] &&
     $exopite_settings['exopite-hero-header-site-branding-type'] == 'widget' ) {

    $sidebar_settings_below_menu =  array(
        array( 'title'    => esc_attr__( 'Hero header site branding Widget Area', 'exopite' ),
            'id'          => 'sidebar-site-branding',
            'description' => esc_attr__( 'Hero header site branding widget area. Only show up if it is not empty.', 'exopite' ),
        ),
    );

    // Hero header site branding sidebar widget areas
    exopite_register_sidebars( 1, $sidebar_settings_below_menu );
}

/*
 * Menu top sidebar
 */
if ( isset( $exopite_settings['exopite-sidebar-menu-top-count'] ) && $exopite_settings['exopite-sidebar-menu-top-count'] > 0 ) {
    $sidebar_settings_top_menu =  array(
        array( 'title' => esc_attr__( 'Menu top Widget Area - First', 'exopite' ),
            'id' => 'menu-top-widget-area-first',
            'description' => esc_attr__( 'First menu top widget area, part of the menu area. Only show up if it is not empty.', 'exopite' ),
        ),
        array( 'title' => esc_attr__( 'Menu top Widget Area - Second', 'exopite' ),
            'id' => 'menu-top-widget-area-second',
            'description' => esc_attr__( 'Second menu top widget area, part of the menu area. Only show up if it is not empty.', 'exopite' ),
        ),
        array( 'title' => esc_attr__( 'Menu top Widget Area - Third', 'exopite' ),
            'id' => 'menu-top-widget-area-third',
            'description' => esc_attr__( 'Third menu top widget area, part of the menu area. Only show up if it is not empty.', 'exopite' ),
        ),
        array( 'title' => esc_attr__( 'Menu top Widget Area - Fourth', 'exopite' ),
            'id' => 'menu-top-widget-area-fourth',
            'description' => esc_attr__( 'Fourth menu top widget area, part of the menu area. Only show up if it is not empty.', 'exopite' ),
        ),
    );

    // Preheader widget areas
    exopite_register_sidebars( $exopite_settings['exopite-sidebar-menu-top-count'], $sidebar_settings_top_menu, 'active_top_menu_sidebars' );

    add_action( 'exopite_hooks_menu_top', 'display_top_menu_sidebar', 10 );
    function display_top_menu_sidebar() {
        exopite_display_sidebars( 'active_top_menu_sidebars', 'top_menu' );
    }
}

/*
 * Below menu sidebar on left menu
 */
if ( isset( $exopite_settings['exopite-menu-alignment'] ) && $exopite_settings['exopite-menu-alignment'] != 'top' ) {
    $sidebar_settings_below_menu =  array(
        array( 'title' => esc_attr__( 'Below the menu Widget Area', 'exopite' ),
            'id' => 'below_menu-widget-area',
            'description' => esc_attr__( 'Below the menu widget area. Only show up if it is not empty.', 'exopite' ),
        ),
    );

    // Below menu widget areas
    exopite_register_sidebars( 1, $sidebar_settings_below_menu, 'active_below_menu_sidebars' );

    add_action( 'tha_header_bottom', 'display_below_menu_sidebar', 10 );
    function display_below_menu_sidebar() {
        exopite_display_sidebars( 'active_below_menu_sidebars', 'below_menu' );
    }
}

/*
 * After header sidebar
 */
if ( isset( $exopite_settings['exopite-sidebar-after-header-count'] ) && $exopite_settings['exopite-sidebar-after-header-count'] > 0 ) {
    $sidebar_settings_after_header =  array(
        array( 'title' => esc_attr__( 'After the header Widget Area - First', 'exopite' ),
            'id' => 'after_header-widget-area-first',
            'description' => esc_attr__( 'First after the header widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
        array( 'title' => esc_attr__( 'After the header Widget Area - Second', 'exopite' ),
            'id' => 'after_header-widget-area-second',
            'description' => esc_attr__( 'Second after the header widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
        array( 'title' => esc_attr__( 'After the header Widget Area - Third', 'exopite' ),
            'id' => 'after_header-widget-area-third',
            'description' => esc_attr__( 'Third after the header widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
        array( 'title' => esc_attr__( 'After the header Widget Area - Fourth', 'exopite' ),
            'id' => 'after_header-widget-area-fourth',
            'description' => esc_attr__( 'Fourth after the header widget area in a full width row. Only show up if it is not empty.', 'exopite' ),
        ),
    );

    // Preheader widget areas
    exopite_register_sidebars( $exopite_settings['exopite-sidebar-after-header-count'], $sidebar_settings_after_header, 'active_after_header_sidebars' );

    add_action( 'tha_header_after', 'display_after_header_sidebar', 10 );
    function display_after_header_sidebar() {
        exopite_display_sidebars( 'active_after_header_sidebars', 'after_header' );
    }
}

/*
 * Register user definied footer sidebars
 */
if ( isset( $exopite_settings['exopite-menu-alignment'] ) &&
     is_array( $exopite_settings['exopite-footer-sidebar-areas'] ) &&
     $exopite_settings['exopite-footer-content'] == 'widget' ) {

    function footer_column_count( $preset, $count ) {
        // Footer widget areas
        switch ( $preset ) {
            case '12':
                // no break
            case '21':
                return $footer_column_count = 2;
                break;
            case '112':
                // no break
            case '121':
                // no break
            case '211':
                return $footer_column_count = 3;
                break;
            default:
                return $footer_column_count = $count;
                break;
        }
    }

    function createVariableName( $var ) {
        return sanitize_text_field( strtolower( preg_replace( '/\s+/', '', $var ) ) );
    }

    $exopite_footer_sidebar_areas_index = 0;

    foreach ( $exopite_settings['exopite-footer-sidebar-areas'] as $key => $sidebar ) {

        if ( isset( $sidebar['exopite-footer-sidebar-area-count'] ) && $sidebar['exopite-footer-sidebar-area-count'] > 0 ) {
            $sidebar_settings_footer =  array(
                array( 'title' => esc_attr__( 'Footer', 'exopite' ) . ' ' . $sidebar['exopite-footer-sidebar-area-name'] . ' - ' . esc_attr__( 'First', 'exopite' ),
                    'id' => createVariableName( $sidebar['exopite-footer-sidebar-area-name'] ) . '-' . 'footer-widget-area-first',
                    'description' => esc_attr__( 'First footer widget area. Only show up if it is not empty.', 'exopite' ),
                ),
                array( 'title' => esc_attr__( 'Footer', 'exopite' ) . ' ' . $sidebar['exopite-footer-sidebar-area-name'] . ' - ' . esc_attr__( 'Second', 'exopite' ),
                    'id' => createVariableName( $sidebar['exopite-footer-sidebar-area-name'] ) . '-' . 'footer-widget-area-second',
                    'description' => esc_attr__( 'Second footer widget area. Only show up if it is not empty.', 'exopite' ),
                ),
                array( 'title' => esc_attr__( 'Footer', 'exopite' ) . ' ' . $sidebar['exopite-footer-sidebar-area-name'] . ' - ' . esc_attr__( 'Third', 'exopite' ),
                    'id' => createVariableName( $sidebar['exopite-footer-sidebar-area-name'] ) . '-' . 'footer-widget-area-third',
                    'description' => esc_attr__( 'Third footer widget area. Only show up if it is not empty.', 'exopite' ),
                ),
                array( 'title' => esc_attr__( 'Footer', 'exopite' ) . ' ' . $sidebar['exopite-footer-sidebar-area-name'] . ' - ' . esc_attr__( 'Fourth', 'exopite' ),
                    'id' => createVariableName( $sidebar['exopite-footer-sidebar-area-name'] ) . '-' . 'footer-widget-area-fourth',
                    'description' => esc_attr__( 'Fourth footer widget area. Only show up if it is not empty.', 'exopite' ),
                ),
            );


            exopite_register_sidebars( footer_column_count( $sidebar['exopite-footer-sidebar-area-preset'], $sidebar['exopite-footer-sidebar-area-count'] ), $sidebar_settings_footer, 'active_footer_sidebars' . $exopite_footer_sidebar_areas_index );

            $exopite_footer_sidebar_areas_index++;
        }


    }

    ExopiteSettings::setValue( 'exopite-footer-sidebar-areas', $exopite_settings['exopite-footer-sidebar-areas'] );

    add_action( 'exopite_hooks_footer_sidebars', 'display_footer_sidebar_areas', 10 );
    function display_footer_sidebar_areas() {

        $exopite_footer_sidebar_areas_index = 0;

        echo '<div class="footer-background">';

        foreach ( ExopiteSettings::getValue( 'exopite-footer-sidebar-areas' ) as $key => $sidebar ) {

            if ( isset( $sidebar['exopite-footer-sidebar-area-count'] ) && $sidebar['exopite-footer-sidebar-area-count'] > 0 ) {

                exopite_display_sidebars( 'active_footer_sidebars' . $exopite_footer_sidebar_areas_index, createVariableName( 'footer' . '-' . $sidebar['exopite-footer-sidebar-area-name'] ), $sidebar['exopite-footer-sidebar-area-preset'] );

                $exopite_footer_sidebar_areas_index++;

            }
        }

        echo '</div>';

    }

}

/*
 * Copyright sidebar
 */
if ( ( isset( $exopite_settings['exopite-sidebar-copyright-count'] ) && $exopite_settings['exopite-sidebar-copyright-count'] > 0 ) || $has_footer_menu ) {
    $copyrigt_column_count = ( isset( $exopite_settings['exopite-sidebar-copyright-count'] ) ) ?
                                                        $exopite_settings['exopite-sidebar-copyright-count'] :
                                                        0;
    if ( $copyrigt_column_count === 0 && $has_footer_menu ) {
        $copyrigt_column_count = 1;
    }

    $cols_copyright_sidebars =  ( $copyrigt_column_count == 0 ) ? 1 : 12 / $copyrigt_column_count;

    $sidebar_settings_copyright =
        array(
            array( 'title' => esc_attr__( 'Copyright Widget Area - Left', 'exopite' ),
                'id' => 'copyright-widget-area-left',
                'description' => esc_attr__( 'Left copyright widget area. Only show up if it is not empty.', 'exopite' ),
            ),
            array( 'title' => esc_attr__( 'Copyright Widget Area - Right', 'exopite' ),
                'id' => 'copyright-widget-area-right',
                'description' => esc_attr__( 'Right copyright widget area. Only show up if it is not empty and/or footer menu not empty.', 'exopite' ),
            ),
        );

    // Copyright widget areas
    if ( $copyrigt_column_count > 0 ) {
        exopite_register_sidebars( $copyrigt_column_count, $sidebar_settings_copyright, 'active_copyright_sidebars' );

    }

    add_action( 'exopite_hooks_footer_sidebars', 'display_copyright_sidebar', 20 );
    function display_copyright_sidebar() {

        $active_copyright_sidebars = ExopiteSettings::getValue('active_copyright_sidebars');

        // Process copyright widget row
        // Check active sidebar(s) and footer menu
        $copyright_widget_area_left  = ( is_array( $active_copyright_sidebars ) && in_array( 'copyright-widget-area-left', $active_copyright_sidebars ) ) ? 1 : 0;
        $copyright_widget_area_right = ( is_array( $active_copyright_sidebars ) && in_array( 'copyright-widget-area-right', $active_copyright_sidebars ) ) ? 1 : 0;
        $footer_menu         = ( has_nav_menu( 'footer' ) ) ? 1 : 0;

        // Check if any sidebar need to be activated
        if ( $copyright_widget_area_left || $copyright_widget_area_right || $footer_menu ) :

            // Calculte copyright bootstrap col amount (1 or 2)
            $cols_copyright_sidebars = $copyright_widget_area_left;
            if ( $copyright_widget_area_right || $footer_menu ) $cols_copyright_sidebars++;

            $cols_copyright_sidebars = 12 / $cols_copyright_sidebars; ?>
            <div class="copyright-background">
                <div class="container">
                    <div class="row row-copyright">
                    <?php
                    // Check copyright left need to be activated
                    if ( $copyright_widget_area_left ): ?>
                        <div class="col-md-<?php echo $cols_copyright_sidebars; ?>">
                        <?php dynamic_sidebar( 'copyright-widget-area-left' ); ?>
                        </div>
                    <?php endif ?>
                    <?php
                    // Check copyright right need to be activated
                    if ( $copyright_widget_area_right || $footer_menu ): ?>
                        <div class="col-md-<?php echo $cols_copyright_sidebars; ?>">
                        <?php
                            // Show sidebar and/or menu
                            if ( $copyright_widget_area_right ) dynamic_sidebar( 'copyright-widget-area-right' );
                            if ( $footer_menu ) wp_nav_menu(
                                array(
                                    'theme_location'  => 'footer',
                                    'menu_id'       => 'footer-menu',
                                )
                            );
                        ?>
                        </div>
                    <?php endif ?>
                    </div><!-- .row .row-copyright -->
                </div><!-- .container -->
            </div><!-- .copyright-background -->
        <?php endif;
    }
}

/**
 * Display the Widget ID
 *
 * @link http://spicemailer.com/wordpress/get-widget-id-wordpress/
 */
add_action('in_widget_form', 'spice_get_widget_id');
function spice_get_widget_id($widget_instance) {

    // Check if the widget is already saved or not.
    if ($widget_instance->number=="__i__"){

        echo '<p class="exopite-widget-id"><strong>Widget ID</strong>: <span>' . esc_html__( 'save the widget first!', 'exopite' ) . '</span></p>';

    }  else {

        echo '<p class="exopite-widget-id"><strong>Widget ID:</strong> <span>' .$widget_instance->id . '</span></p>';

    }
}

function exopite_get_sidebar_id() {

    // Get sidebar by ID on single or on archive pages if set by post meta
    if ( is_singular() || ( isset( $archive_id ) && ! empty( $archive_id ) ) ) {

        /*
         * Individual page/post settings
         */
        $exopite_meta_data_type = 'exopite_custom_post_options';
        if ( is_page() ) {
            $exopite_meta_data_type = 'exopite_custom_page_options';
        }
        $exopite_meta_data = get_post_meta( get_queried_object_ID(), $exopite_meta_data_type, true );

        $sidebar_id = ( isset( $exopite_meta_data['exopite-meta-sidebar-id'] ) ) ? $exopite_meta_data['exopite-meta-sidebar-id'] : 'sidebar-1' ;

    } else {

        /*
         * Settings from admin option framework
         */
        $exopite_settings = get_option( 'exopite_options' );

        // Default sidebar
        $sidebar_id = 'sidebar-1' ;

        // If sidebar is set in options
        if ( isset( $exopite_settings['exopite-blog-sidebar-id'] ) && is_home() ) {
            $sidebar_id = $exopite_settings['exopite-blog-sidebar-id'];
        }

        // If sidebar is set in options
        if ( isset( $exopite_settings['exopite-blog-sidebar-id'] ) && is_archive() ) {
            $sidebar_id = $exopite_settings['exopite-blog-sidebar-id'];
        }

    }

    return $sidebar_id;

}
