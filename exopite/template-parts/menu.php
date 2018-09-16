<?php
/**
 * The menu template for Exopite theme.
 *
 * @package Exopite
 *
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$exopite_menu_left = $exopite_menu_alignment == 'left';
$exopite_menu_container = ( $exopite_menu_full_width ) ? 'container-fluid' : 'container';

// Logo position
$exopite_logo_left_pos = $exopite_logo_right_pos = $exopite_logo_top_pos = $exopite_logo_top_in_menu_pos = $exopite_logo_center_pos = false;
switch ( $exopite_desktop_logo_position ) {
    case 'left':
        $exopite_logo_left_pos = true;
        break;
    case 'right':
        $exopite_logo_right_pos = true;
        break;
    case 'top':
        $exopite_logo_top_pos = true;
        break;
    case 'top-in-menu':
        $exopite_logo_top_in_menu_pos = true;
        break;
    case 'center':
        $exopite_logo_center_pos = true;
        break;
}

// Logo alignment
$exopite_logo_left = $exopite_logo_right = $exopite_logo_center = false;
switch ( $exopite_desktop_logo_alignment ) {
    case 'text-left flex-left':
        $exopite_logo_left = true;
        break;
    case 'text-right flex-right':
        $exopite_logo_right = true;
        break;
    case 'text-center flex-center':
        $exopite_logo_center = true;
        break;
}

// Sidebars
$exopite_left_side_logo_widget_area = is_active_sidebar( 'left-side-logo-widget-area' );
$exopite_right_side_logo_widget_area = is_active_sidebar( 'right-side-logo-widget-area' );

$exopite_logo_top = $exopite_logo_top_pos || $exopite_logo_top_in_menu_pos;
$exopite_logo_menu_center = ( $exopite_desktop_logo_position == 'center' );
$exopite_both = $exopite_left_side_logo_widget_area && $exopite_right_side_logo_widget_area && $exopite_logo_center;
$exopite_left_or_right = $exopite_left_side_logo_widget_area || $exopite_right_side_logo_widget_area;

/**
 *  2  1
 *  3  2
 *  4  3
 *  6  4
 *  12 6
 */

$exopite_logo_ratio_lg = isset( $exopite_settings['exopite-logo-ratio'] ) ? intval( $exopite_settings['exopite-logo-ratio'] ) : 3;
switch ( $exopite_logo_ratio_lg ) {

    case 1:
        $exopite_logo_ratio_md = 2;
        break;
    case 2:
        $exopite_logo_ratio_md = 3;
        break;
    case 4:
        $exopite_logo_ratio_md = 6;
        break;
    case 6:
        $exopite_logo_ratio_md = 12;
        break;
    default:
        $exopite_logo_ratio_md = 4;
        break;

}

// Alignment classes
$exopite_logo_alignment_classes = ( $exopite_logo_top || $exopite_menu_left || $exopite_settings['exopite-logo-ratio'] != 3 ) ? '' : ' col-md-4 col-lg-3';
$exopite_logo_in_menu = ( $exopite_logo_top || $exopite_menu_left ) ? '' : ' logo-in-menu';
$exopite_logo_alignment_classes .= ( ( $exopite_logo_top && $exopite_logo_center && ( $exopite_left_or_right ) ) ||
                             ( $exopite_logo_left && $exopite_right_side_logo_widget_area ) ||
                             ( $exopite_logo_right && $exopite_left_side_logo_widget_area ) ) ?
                             ' col-md-4' : '';
if ( ( $exopite_settings['exopite-logo-ratio'] != 3 ) ) {

    $exopite_logo_alignment_classes .= ' col-md-' . $exopite_logo_ratio_md . ' col-lg-' . $exopite_logo_ratio_lg;
    $exopite_menu_ratio_md = 12 - $exopite_logo_ratio_md;
    $exopite_menu_ratio_lg = 12 - $exopite_logo_ratio_lg;
    $exopite_menu_alignment_classes = ( $exopite_logo_top || $exopite_menu_left || $exopite_logo_menu_center ) ? '' : ' col-md-' . $exopite_menu_ratio_md . ' col-lg-' . $exopite_menu_ratio_lg;

} else {

    $exopite_menu_alignment_classes = ( $exopite_logo_top || $exopite_menu_left || $exopite_logo_menu_center ) ? '' : ' col-md-8 col-lg-9';

}




// Logos
$exopite_desktop_logo = ( isset( $exopite_settings['exopite-desktop-logo'] ) ) ?
    wp_get_attachment_image_src( $exopite_settings['exopite-desktop-logo'], 'full' )[0] :
    '';

$exopite_mobile_logo = ( isset( $exopite_settings['exopite-mobile-menu-logo'] ) ) ?
    wp_get_attachment_image_src( $exopite_settings['exopite-mobile-menu-logo'], 'full' )[0] :
    '';

$exopite_desktop_logo = apply_filters( 'exopite-desktop-logo', $exopite_desktop_logo );
$exopite_mobile_logo = apply_filters( 'exopite-mobile-logo', $exopite_mobile_logo );

$exopite_enable_fixed_header = isset( $exopite_meta_data['exopite-enable-fixed-header'] ) ?
    $exopite_meta_data['exopite-enable-fixed-header'] :
    false;

$exopite_mobile_hamburger_icon = apply_filters( 'exopite-mobile-hamburger-icon', '<div class="mobile-button mobile-button-hamburger">
    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
    <span class="icon-text">MENU</span>
</div>' );

ExopiteSettings::setValue( 'logo_url', $exopite_desktop_logo );
ExopiteSettings::setValue( 'desktop-menu-search', '<div class="full-search-menu mobile-button mobile-button-search"><i class="fa fa-search" aria-hidden="true"></i></div>' );

if ( ! function_exists( 'exopite_create_logo' ) ) {
    function exopite_create_logo() {
        if ( ExopiteSettings::getValue( 'logo_url' ) == "") return;
        return '<a href="' . apply_filters( 'exopite-desktop-logo-url', SITEURL ) . '"><img src="' . ExopiteSettings::getValue( 'logo_url' ) . '" class="logo" alt="Desktop Logo"></a>';
    }
}

/**
 * MAIN MENU
 *
 * Assemble logo image, I put it in a variable, because I may have to display
 * before, after or top of the menu, depends on the logo left or right settings.
 */
$exopite_logo = apply_filters( 'exopite-logo', '<div class="desktop-menu desktop-menu-logo col-12' . $exopite_logo_alignment_classes . ' ' . $exopite_desktop_logo_alignment . $exopite_logo_in_menu . '">' . exopite_create_logo() . '</div>' );

/**
 * MOBILE MENU
 *
 * If there is no mobile logo set, use desktop version
 */
$exopite_mobile_logo_img = ( $exopite_mobile_logo != '' ) ? $exopite_mobile_logo : $exopite_desktop_logo;


$exopite_mobile_logo = ( $exopite_mobile_logo_img == '' ) ? '' : '<a href="' . SITEURL . '">
        <img src="' . $exopite_mobile_logo_img . '" class="logo" alt="Mobile Logo">
    </a>';

if ( $exopite_mobile_menu_search ) {
    add_action( 'expote-extend-mobile-menu', 'add_mobile_menu_search' );
    if ( ! function_exists( 'add_mobile_menu_search' ) ) {
        function add_mobile_menu_search() {
            echo apply_filters( 'exopite-menu-search-icon', ExopiteSettings::getValue( 'desktop-menu-search' ) );
        }
    }
}

/***
 * Add search to menu
 */
if ( $exopite_menu_search ) {
    add_filter( 'wp_nav_menu_items', 'exopite_child_add_top_search_menu', 10, 2 );
}
if ( ! function_exists( 'exopite_child_add_top_search_menu' ) ) {
    function exopite_child_add_top_search_menu( $items, $args ) {
        if ( $args->theme_location == 'primary' ) {
            $items .= '<li class="full-search-menu-wrapper"><a class="full-search-menu" href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>';
        }
        return $items;
    }
}

if ( $exopite_logo_center_pos ) add_filter( 'exopite_center_nav_menu_item', 'exopite_create_logo' );

?><header id="masthead" class="site-header menu-alignment-<?php echo $exopite_menu_alignment; ?>"<?php WP_Schema::get_attribute( 'site-header' ); ?>>
    <?php tha_header_top();

    /**
     * If desktop logo is on top, then display here.
     */
    if ( $exopite_logo_top_pos ) include( locate_template( 'template-parts/logo-top.php' ) );

    ?>
    <nav id="site-navigation" class="row-menu main-navigation normal-menu<?php if ( $exopite_enable_fixed_header && ! $exopite_menu_left ) echo ' fixed-top'; ?>"<?php WP_Schema::get_attribute( 'main-navigation' ); ?>>
        <?php

        // Display contant above menu from page meta
        if ( isset( $exopite_meta_data['exopite-meta-above-menu-content'] ) &&
             ! empty( $exopite_meta_data['exopite-meta-above-menu-content'] ) ) :

            // Add container if not full width
            if ( ! $exopite_meta_data['exopite-meta-above-menu-content-full'] ) : ?>
            <div class="container">
                <div class="row flex">
                   <div class="col-12">
            <?php endif;

                /**
                 * Blog: http://wordpress.stackexchange.com/questions/199308/get-meta-value-when-the-page-is-a-blog-archive
                 * Run shortcode on content
                 */
                echo do_shortcode( $exopite_meta_data['exopite-meta-above-menu-content'] );

            if ( ! $exopite_meta_data['exopite-meta-above-menu-content-full'] ) : ?>
                    </div>
                </div>
            </div>
            <?php endif;

        endif;

        /**
         * If desktop logo is on top but inside the menu, then display here.
         */
        if ( $exopite_logo_top_in_menu_pos ) include( locate_template( 'template-parts/logo-top.php' ) );

        ?>
        <div class="<?php echo $exopite_menu_container; ?> ">
            <div class="row flex">
                <?php

                /**
                 * Hook display:
                 *  - top menu widgets, 10 (include/sidebars.php)
                 */
                exopite_hooks_menu_top();

                /**
                 * If logo is on the left, then display here.
                 */
                if ( $exopite_logo_left_pos ) echo $exopite_logo;

                /**
                 * Mobile menu buttons and search field.
                 */
                ?>
                <div class="flex col-12 <?php echo $exopite_menu_alignment_classes . ' ' . $exopite_desktop_menu_horizontal_alignment . ' ' . $exopite_desktop_menu_vertical_alignment; ?>">
                    <?php

                    /**
                     * Display mobile menu only, if menu on the top.
                     */
                    // if ( $exopite_menu_alignment == 'top' ) :

                    //     include( locate_template( 'template-parts/menu-top.php' ) );


                    // endif;

                    if ( $exopite_menu_alignment == 'top' || $exopite_menu_alignment == 'overlay' ) {

                        include( locate_template( 'template-parts/menu-top-mobile.php' ) );

                    }

                    /**
                     * Display primary menu and if mobile menu not exist, use this menu to mobile menu as well
                     */
                    if ( has_nav_menu( 'primary' ) ):

                        exopite_hooks_before_menu();

                        switch ( $exopite_menu_alignment ) {


                            case 'left':
                            case 'top':

                                include( locate_template( 'template-parts/menu-top.php' ) );

                                break;

                            case 'overlay':

                                ?><div class="overlay-desktop"><?php

                                echo $exopite_mobile_hamburger_icon;

                                if ( $exopite_menu_search ) {

                                    if ( has_nav_menu( 'primary' ) ) {

                                        echo ExopiteSettings::getValue( 'desktop-menu-search' );

                                    }

                                }

                                ?></div><?php

                                break;

                        }

                        exopite_hooks_after_menu();

                    endif;
                    ?>
                </div>
                <?php

                /**
                 * If desktop logo is on the right, then display here
                 */
                if ( $exopite_logo_right_pos ) echo $exopite_logo;

                ?>
            </div>
        </div>
    </nav><!-- #site-navigation -->
    <?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_header_bottom();

    ?>
</header><!-- #masthead -->
<?php
