<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * Create a custom post type section,
 * to create and assign this to footer and preheader.
 * Do not use a normal page or post, because in this case,
 * it is not in search, it is not visible in front end and all.
 */

add_action( 'init', 'exopite_register_cpt_sections' );

if ( ! function_exists( 'exopite_register_cpt_sections' ) ) {
    function exopite_register_cpt_sections() {

        $labels = array(
            'name' => __( 'Sections', 'exopite' ),
            'singular_name' => __( 'Section', 'exopite' ),
            'add_new' => __( 'Add Section', 'exopite' ),
            'add_new_item' => __( 'Add Section', 'exopite' ),
            'edit_item' => __( 'Edit Section', 'exopite' ),
            'new_item' => __( 'New Section', 'exopite' ),
            'view_item' => __( 'View Section', 'exopite' ),
            'search_items' => __( 'Search Section', 'exopite' ),
            'not_found' => __( 'Not Found', 'exopite' ),
            'not_found_in_trash' => __( 'Not Found In Trash', 'exopite' ),
            'parent_item_colon' => __( 'Parent Section:', 'exopite' ),
            'menu_name' => __( 'Preheader & Footer', 'exopite' ),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'supports' => array( 'editor', 'custom-fields', 'revisions', 'title' ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'has_archive' => false,
            'query_var' => true,
            'can_export' => false,
            'rewrite' => false,
            'capability_type' => 'post',
            'show_in_menu' => 'themes.php'
        );

        register_post_type( 'exopite-sections', $args );
    }
}
