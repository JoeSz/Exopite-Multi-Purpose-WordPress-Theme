<?php
/**
 * The top menu part for our theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Exopite
 *
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$exopite_items_wrap = ( has_nav_menu( 'mobile' ) ) ?
    apply_filters( 'exopite-desktop-mobile-menu-wrap', '<div id="cssmenu" class="menu-row menu-both"><ul id="desktop-menu" class="desktop-menu">%3$s</ul></div>' ) :
    apply_filters( 'exopite-desktop-menu-wrap', '<ul id="menu" class="desktop-menu slimmenu">%3$s</ul>' );

wp_nav_menu(
    array(
        'theme_location'    => 'primary',
        'menu_id'           => apply_filters( 'exopite-primary-menu', 'primary-menu' ), //using 22658.88 kB memory
        'items_wrap'        => $exopite_items_wrap,
        'container'         => false,
        'walker'            => new Exopite_Menu_Walker(),
    )
);
