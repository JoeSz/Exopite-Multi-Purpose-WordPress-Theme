<?php
/**
 * The logo top template for Exopite theme.
 *
 * On logo top, register sidebar (widget area) on the left or right or both side of the logo
 *
 * @package Exopite
 *
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

if ( ! $exopite_show_desktop_logo ) $exopite_logo = '';
$exopite_top_sidebar_width_small = ( empty( $exopite_logo ) ) ? 'col-md-6' : 'col-md-4';
$exopite_top_sidebar_width_long  = ( empty( $exopite_logo ) ) ? 'col-md-12' : 'col-md-8';

?>
<!-- Logo top -->
<div class="<?php echo $exopite_menu_container; ?> ">
    <div class="row flex">
        <?php

        // Display sidebar "left" if the logo is in the center or right and logo left sidebar has widget
        if ( ( ( $exopite_left_or_right ) && $exopite_logo_center ) || ( $exopite_logo_right ) && $exopite_left_side_logo_widget_area ):

            // Set col width according to the displayed sidebars
            ?>
            <div class="col-12 <?php echo ( $exopite_both || $exopite_logo_center ) ? $exopite_top_sidebar_width_small : $exopite_top_sidebar_width_long; ?> left-logo-widget">
            <?php

            if ( $exopite_left_side_logo_widget_area && ( $exopite_logo_center || $exopite_logo_right ) ) {

                if ( has_action( 'exopite-left-side-logo-widget-area' ) ) {
                    apply_filters( 'exopite-left-side-of-logo-top', do_action( 'exopite-left-side-logo-widget-area' ) );
                } else {
                    apply_filters( 'exopite-left-side-of-logo-top', dynamic_sidebar( 'left-side-logo-widget-area' ) );
                }

            }

            ?>
            </div>
            <?php

        endif;

        // Display logo if on the left or in the center
        if ( $exopite_logo_left || $exopite_logo_center ) echo $exopite_logo;

        if ( ( ( $exopite_left_or_right ) && $exopite_logo_center ) || ( $exopite_logo_left ) && $exopite_right_side_logo_widget_area ):

            ?>
            <div class="col-12 <?php echo ( $exopite_both || $exopite_logo_center ) ? $exopite_top_sidebar_width_small : $exopite_top_sidebar_width_long; ?> right-logo-widget">
            <?php

            if ( $exopite_right_side_logo_widget_area && ( $exopite_logo_center || $exopite_logo_left ) ) {

                if ( has_action( 'exopite-right-side-logo-widget-area' ) ) {
                    apply_filters( 'exopite-right-side-of-logo-top', do_action( 'exopite-right-side-logo-widget-area' ) );
                } else {
                    apply_filters( 'exopite-right-side-of-logo-top', dynamic_sidebar( 'right-side-logo-widget-area' ) );
                }

            }

            ?>
            </div>
            <?php

        endif;

        if ( $exopite_logo_right ) echo $exopite_logo;

        ?>
    </div>
</div>
<!-- End logo top -->
