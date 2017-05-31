<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

get_header();

$exopite_settings = get_option( 'exopite_options' );

$archive_id = '';

/*
 * Check if any archive is assing to a page
 *
 * Sometimes it is good if we can customize the archive page.
 * In this case, the page can be used for customazations and then,
 * can be use a plugin or eg. WordPress or SiteOrigin PageBuilder Posts widget
 * to display the archive posts.
 */

if ( is_category() && $exopite_settings['exopite-archive-page-category'] ) {

    $archive_id = $exopite_settings['exopite-archive-page-category-id'];

} elseif ( is_tag() && $exopite_settings['exopite-archive-page-tag'] ) {

    $archive_id = $exopite_settings['exopite-archive-page-tag-id'];

} elseif ( is_author() && $exopite_settings['exopite-archive-page-author'] ) {

    $archive_id = $exopite_settings['exopite-archive-page-author-id'];

} elseif ( is_day() && $exopite_settings['exopite-archive-page-daily'] ) {

    $archive_id = $exopite_settings['exopite-archive-page-daily-id'];

} elseif ( is_month() && $exopite_settings['exopite-archive-page-monthly'] ) {

    $archive_id = $exopite_settings['exopite-archive-page-monthly-id'];

} elseif ( is_year() && $exopite_settings['exopite-archive-page-yearly'] ) {

    $archive_id = $exopite_settings['exopite-archive-page-yearly-id'];

} elseif ( $exopite_settings['exopite-archive-page-other'] ) {

    $archive_id = $exopite_settings['exopite-archive-page-other-id'];

}

if ( isset( $archive_id ) && ! empty( $archive_id) && FALSE !== get_post_status( $archive_id ) ) {

    include( locate_template( 'template-parts/archive-from-page.php' ) );

} else {

    // Display default archive template
    include( locate_template( 'template-parts/archive.php' ) );

}

get_footer();
