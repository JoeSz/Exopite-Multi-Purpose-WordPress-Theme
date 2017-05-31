<?php
/*
 * Exopite
 *
 * Display content top sidebar template
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

// Check this first, so if no any sidebar assigned to content top, do not run other codes
if( is_active_sidebar( $exopite_meta_data['exopite-meta-before-content-sidebar-id'] ) ) {

    $before_content_sidebar_id = $exopite_meta_data['exopite-meta-before-content-sidebar-id'];

    if ( $exopite_meta_data['exopite-meta-before-content-sidebar-full-width'] ) {

        add_action('tha_content_before', function() use ( $before_content_sidebar_id ) {
            dynamic_sidebar( $before_content_sidebar_id );
        });

    } else {

        add_action('exopite_hooks_content_container_top', function() use ( $before_content_sidebar_id ) {
            dynamic_sidebar( $before_content_sidebar_id );
        }, 10);

    }

}
