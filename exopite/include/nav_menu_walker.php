<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * The navigation menu walker for our theme.
 *
 * @package Exopite
 *
 */

// creating the class for outputing the custom navigation menu
if( ! class_exists( 'Exopite_Menu_Walker' ) ){
    class Exopite_Menu_Walker extends Walker_Nav_Menu {

        private $top_level_items = 0;
        private $top_level_count = 0;

        function start_el( &$output, $item, $depth = 0, $args = Array(), $id = 0 ) {

            // for counting the parent middle menu item
            // rewrite: http://wordpress.stackexchange.com/questions/208872/counting-top-level-items-in-a-custom-menu-walker
            if( $depth == 0 ){
                if( $this->top_level_count == 0 ){
                    $menus = wp_get_nav_menu_items($args->menu->term_id, array(
                        'meta_query' => array( array(
                            'key' => '_menu_item_menu_item_parent',
                            'value' => '0'
                        ))
                    ));
                    $this->top_level_items = sizeOf($menus);
                }

                $this->top_level_count++;

                if( ceil( $this->top_level_items / 2 ) + 1 == $this->top_level_count ){
                    $center_nav_menu_item = apply_filters( 'exopite_center_nav_menu_item', '' );
                    if( ! empty( $center_nav_menu_item ) ){
                        $output .= '<li class="exopite-center-nav-menu-item" >' . $center_nav_menu_item . '</li>' . PHP_EOL;
                    }
                }
            }

            global $wp_query;
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            $classes[] = 'menu-item-' . sanitize_title( $item->title );

            $ids = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID );

            $output .= $indent . '<li id="' . $ids . '" class="' . esc_attr( join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) ) .'">';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

            // add something before and after top menu item (filter)
            $prepend = apply_filters( 'exopite-main-menu-top-level-before-item', '');
            $append = apply_filters( 'exopite-main-menu-top-level-after-item', '');
            $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

            if($depth != 0) {
                $description = $append = $prepend = "";
            }

            $item_output  = $args->before;
            $item_output .= ( ! empty( $item->url ) ) ? '<a' . $attributes . '>' : '<div>';
            $item_output .= $args->link_before . $prepend . apply_filters( 'the_title', $item->title, $item->ID ) . $append;
            $item_output .= $description . $args->link_after;
            $item_output .= ( ! empty( $item->url ) ) ? '</a>' : '</div>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

    }
}
