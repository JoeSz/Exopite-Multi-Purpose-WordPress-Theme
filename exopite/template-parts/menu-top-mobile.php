<?php
/**
 * The top menu mobile part for our theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Exopite
 *
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

?>
<div class="row menu-collapser flex">
    <?php

    /*
     * Display this column only, if mobile search is on and menu is on the right side
     */
    if ( $exopite_mobile_menu_search && $exopite_mobile_menu_position === 'right' ) : ?>
    <div class="col-3 mobile-menu-left">
        <?php

        do_action( 'expote-extend-mobile-menu', '' );

        ?>
    </div>
    <?php

    /*
     * If menu on the left side
     */
    elseif ( $exopite_mobile_menu_position === 'left' ) : ?>
    <div class="col-3 mobile-menu-left">
        <?php echo $exopite_mobile_hamburger_icon; ?>
    </div>
    <?php endif;

    ?>
    <div class="<?php if ( $exopite_mobile_menu_search ) : echo 'col-6 text-center'; else: echo 'col-9'; endif; ?> <?php if ( $exopite_mobile_menu_position === 'left' ) echo 'text-right'; ?>">
        <?php

        /*
         * If no mobile search is activated, then place logo on the right and use its space too
         */
        if ( $exopite_mobile_logo != '' ) echo $exopite_mobile_logo;

        ?>
    </div>
    <?php

    /*
     * Display this column only, if mobile search is on and menu is on the left side
     */
    if ( $exopite_mobile_menu_search && $exopite_mobile_menu_position === 'left' ) : ?>
    <div class="col-3 mobile-menu-right">
        <?php

        do_action( 'expote-extend-mobile-menu', '' );

        ?>
    </div>
    <?php

    /*
     * If menu on the right side
     */
    elseif ( $exopite_mobile_menu_position === 'right' ) : ?>
    <div class="col-3 mobile-menu-right">
        <?php echo $exopite_mobile_hamburger_icon; ?>
    </div>
    <?php

    endif;

    ?>
</div>
<?php

/*
 * Display mobile menu if exist
 */
if ( has_nav_menu( 'mobile' ) ):
    wp_nav_menu(
        array(
            'theme_location'    => 'mobile',
            'menu_id'           => apply_filters( 'exopite-mobile-menu', 'mobile-menu' ), //using 22658.88 kB memory
            'items_wrap'        => apply_filters( 'exopite-mobile-menu-wrap', '<ul id="mobile-menu" class="menu-row row slimmenu">%3$s</ul>' ),
            'container'         => false,
            )
        );
endif;
