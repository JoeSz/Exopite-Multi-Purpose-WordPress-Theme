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

?>
<!-- Logo top -->
<div class="container">
    <div class="row flex">
        <?php

        // Display sidebar "left" if the logo is in the center or right and logo left sidebar has widget
        if ( ( ( $left_or_right ) && $logo_center ) || ( $logo_right ) && $left_side_logo_widget_area ):

            // Set col width according to the displayed sidebars
            ?>
            <div class="col-12 <?php echo ( $both || $logo_center ) ? 'col-md-4' : 'col-md-8'; ?> left-logo-widget">
            <?php

            if ( $left_side_logo_widget_area && ( $logo_center || $logo_right ) ) {

                if ( has_action( 'exopite-left-side-logo-widget-area' ) ) {
                    do_action( 'exopite-left-side-logo-widget-area' );
                } else {
                    dynamic_sidebar( 'left-side-logo-widget-area' );
                }

            }

            ?>
            </div>
            <?php

        endif;

        // Display logo if on the left or in the center
        if ( $logo_left || $logo_center ) echo $logo;

        if ( ( ( $left_or_right ) && $logo_center ) || ( $logo_left ) && $right_side_logo_widget_area ):

            ?>
            <div class="col-12 <?php echo ( $both || $logo_center ) ? 'col-md-4' : 'col-md-8'; ?> right-logo-widget">
            <?php

            if ( $right_side_logo_widget_area && ( $logo_center || $logo_left ) ) {

                if ( has_action( 'exopite-right-side-logo-widget-area' ) ) {
                    do_action( 'exopite-right-side-logo-widget-area' );
                } else {
                    dynamic_sidebar( 'right-side-logo-widget-area' );
                }

            }

            ?>
            </div>
            <?php

        endif;

        if ( $logo_right ) echo $logo;

        ?>
    </div>
</div>
<!-- End logo top -->
