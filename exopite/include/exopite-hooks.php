<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * File to create Exopite hooks
 *
 * Hooks:
 *  - exopite_hooks_before_hero_header
 *  - exopite_hooks_after_hero_header
 *  - exopite_hooks_menu_top
 *  - exopite_hooks_before_menu
 *  - exopite_hooks_after_menu
 *  - exopite_hooks_content_container_top
 *  - exopite_hooks_content_container_bottom
 *  - exopite_hooks_post_header
 *  - exopite_hooks_post_footer
 *  - exopite_hooks_page_footer
 *  - exopite_hooks_posts_header
 *  - exopite_hooks_posts_footer
 *  - exopite_hooks_posts_before_nth_excerpt_item
 *  - exopite_hooks_posts_display_divider
 *  - exopite_hooks_footer_sidebars
 *  - exopite_hooks_404_content
 *  - exopite_hooks_404_search_recommendations
 *
 * Filters:
 *  - exopite_filter_excerpt_allowed_tags:
 *      string, list allowed tags in excerpt
 *      defautl: <strong>,<em>,<i>,<b>
 *  - erliama_filter_before_nth_item filter
 *      integer, set post number to run exopite_hooks_posts_before_nth_excerpt_item hook
 *      before the excerpt, content or nothing
 */

function exopite_hooks_navigation_top() {
    do_action( 'exopite_hooks_navigation_top' );
}

function exopite_hooks_navigation_bottom() {
    do_action( 'exopite_hooks_navigation_bottom' );
}

function exopite_hooks_before_hero_header() {
    do_action( 'exopite_hooks_before_hero_header' );
}

function exopite_hooks_after_hero_header() {
    do_action( 'exopite_hooks_after_hero_header' );
}

function exopite_hooks_menu_top() {
    do_action( 'exopite_hooks_menu_top' );
}

function exopite_hooks_before_menu() {
    do_action( 'exopite_hooks_before_menu' );
}

function exopite_hooks_after_menu() {
    do_action( 'exopite_hooks_after_menu' );
}

function exopite_hooks_content_container_top() {
	do_action( 'exopite_hooks_content_container_top' );
}

function exopite_hooks_content_container_bottom() {
	do_action( 'exopite_hooks_content_container_bottom' );
}

/*
 * Single post hooks.
 */
function exopite_hooks_post_header() {
	do_action( 'exopite_hooks_post_header' );
}

/*
 * Hook to display on singe post:
 * 	  - tags and categories, 10 (include/template-functions.php)
 * 	  - social share 		 15 (include/social-share.php)
 * 	  - author bio,			 20 (include/template-functions.php)
 * 	  - post navigation 	 25 (include/extra.php)
 * 	  - releated posts 		 30 (include/extra.php)
 *
 * This hook will not show up on password protected post,
 * before the password is entered.
 */
function exopite_hooks_post_footer() {
	do_action( 'exopite_hooks_post_footer' );
}

/*
 * Page hook.
 */
/*
 * Hook to display on page:
 * 	  - social share 		 10 (include/social-share.php)
 *
 * This hook will not show up on password protected page,
 * before the password is entered.
 */
function exopite_hooks_page_footer() {
	do_action( 'exopite_hooks_page_footer' );
}

/*
 * Blog, search and archive hooks.
 */
function exopite_hooks_posts_header() {
	do_action( 'exopite_hooks_posts_header' );
}

/*
 * Hook to display on posts list:
 * 	  - tags and categories, 10 (include/template-functions.php)
 */
function exopite_hooks_posts_footer() {
	do_action( 'exopite_hooks_posts_footer' );
}

/*
 * Hook and filter do display something inportant after Xth posts item
 *
 * Use with the erliama_filter_before_nth_item filter,
 * which contain the number of the specific post
 * Example: 10 (include/template-functions.php)
 */
function exopite_hooks_posts_before_nth_excerpt_item() {
	do_action( 'exopite_hooks_posts_before_nth_excerpt_item' );
}

/*
 * Hook to display divider after each post in blog/posts list,
 * 10 (include/template-functions.php)
 */
function exopite_hooks_posts_display_divider() {
	do_action( 'exopite_hooks_posts_display_divider' );
}

function exopite_hooks_preheader_sidebars() {
	do_action( 'exopite_hooks_preheader_sidebars' );
}

/*
 * Display sidebar in the footer
 *  - footer sidebars,                       10 (include/sidebars.php)
 *  - copyright sidebars,                    20 (include/sidebars.php)
 *  - default sidebars
 *    (if no footer and copyright sidebars), 30 (include/sidebars.php)
 */
function exopite_hooks_footer_sidebars() {
    do_action( 'exopite_hooks_footer_sidebars' );
}

/*
 * Display content in 404 page template
 * - custom search based on "not found" url  10 (include/template-functions.php)
 */
function exopite_hooks_404_content() {
	do_action( 'exopite_hooks_404_content' );
}

/*
 * Display recommendations in 404 and search page template
 * - recommendations                         10 (include/template-functions.php)
 */
function exopite_hooks_404_search_recommendations() {
    do_action( 'exopite_hooks_404_search_recommendations' );
}
