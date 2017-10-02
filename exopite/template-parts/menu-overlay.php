<?php
/**
 * The menu template for Exopite theme.
 *
 * @package Exopite
 *
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );
/*
 * ToDo:
 * - if no submenu, after each other
 * - if submenu, then side by side (4/3/2 xl/lg/md)
 * - widgets :) - done
 */
$exopite_desktop_logo = ( isset( $exopite_settings['exopite-desktop-logo'] ) ) ?
    wp_get_attachment_image_src( $exopite_settings['exopite-desktop-logo'], 'full' )[0] :
    '';


add_filter( 'nav_menu_css_class_top_level', 'special_nav_class', 10, 3 );
function special_nav_class( $classes, $item, $args ) {
    $extra = array();
    if ( 'primary' === $args->theme_location ) {
        $extra = array( 'col-12', 'col-md-6', 'col-xl-3', 'text-center' );
    }

    return array_merge( $classes, $extra );
}

?>
<div class="menu-overlay-wrapper">
    <div class="menu-overlay-inner">
        <div class="menu-overlay-content container">
            <div class="row row-overlay-top">
                <div class="col-2"></div>
                <div class="col-8 text-center">
                    <a href="<?php echo apply_filters( 'exopite-desktop-logo-url', SITEURL ); ?>"><img src="<?php echo $exopite_desktop_logo; ?>" class="logo" alt="Desktop Logo"></a>
                </div>
                <div class="col-2 text-right">
                    <i class="fa fa-times menu-overlay-close" aria-hidden="true"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                        <?php
                        $exopite_items_wrap = apply_filters( 'exopite-desktop-menu-wrap', '<ul id="menu-overlay" class="desktop-menu-overlay row">%3$s</ul>' );

                        wp_nav_menu(
                            array(
                                'theme_location'    => 'primary',
                                'menu_id'           => apply_filters( 'exopite-primary-menu', 'primary-menu-overlay' ), //using 22658.88 kB memory
                                'items_wrap'        => $exopite_items_wrap,
                                'container'         => false,
                                'walker'            => new Exopite_Menu_Walker(),
                            )
                        );
                        ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12 menu-overlay-widget-col">
                    <?php dynamic_sidebar( 'sidebar-menu-overlay' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
