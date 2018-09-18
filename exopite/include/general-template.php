<?php
/**
 * Fire the wp_doctype hook
 *
 * Intended to be immediately before HTML <html> tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_doctype' hook.
 */
function wp_doctype() {
	do_action( 'wp_doctype' );
}

/**
 * Fire the wp_body_top hook
 *
 * Intended to be immediately inside opening HTML <body> hook
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_body_top' hook.
 */
function wp_body_top() {
	do_action( 'wp_body_top' );
}

/**
 * Fire the wp_body_bottom hook
 *
 * Intended to be immediately inside closing HTML </body> tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_body_bottom' hook.
 */
function wp_body_bottom() {
	do_action( 'wp_body_bottom' );
}

/**
 * Fire the wp_header_before hook
 *
 * Intended to be immediately before opening HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_before' hook.
 */
function wp_header_before() {
	do_action( 'wp_header_before' );
}

/**
 * Fire the wp_header_top hook
 *
 * Intended to be immediately inside opening HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_top' hook.
 */
function wp_header_top() {
	do_action( 'wp_header_top' );
}

/**
 * Fire the wp_header_bottom hook
 *
 * Intended to be immediately inside closing HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_bottom' hook.
 */
function wp_header_bottom() {
	do_action( 'wp_header_bottom' );
}

/**
 * Fire the wp_header_before hook
 *
 * Intended to be immediately after closing HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_before' hook.
 */
function wp_header_after() {
	do_action( 'wp_header_after' );
}

/**
 * Fire the wp_content_before hook
 *
 * Intended to be immediately before opening HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_before' hook.
 */
function wp_content_before() {
	do_action( 'wp_content_before' );
}

/**
 * Fire the wp_content_top hook
 *
 * Intended to be immediately inside opening HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_top' hook.
 */
function wp_content_top() {
	do_action( 'wp_content_top' );
}

/**
 * Fire the wp_content_bottom hook
 *
 * Intended to be immediately inside closing HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_bottom' hook.
 */
function wp_content_bottom() {
	do_action( 'wp_content_bottom' );
}

/**
 * Fire the wp_content_after hook
 *
 * Intended to be immediately after closing HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_after' hook.
 */
function wp_content_after() {
	do_action( 'wp_content_after' );
}

/**
 * Fire the wp_post_before hook
 *
 * Intended to be immediately before opening HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_before' hook.
 */
function wp_post_before() {
	do_action( 'wp_post_before' );
}

/**
 * Fire the wp_post_top hook
 *
 * Intended to be immediately inside opening HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_top' hook.
 */
function wp_post_top() {
	do_action( 'wp_post_top' );
}

/**
 * Fire the wp_post_bottom hook
 *
 * Intended to be immediately inside closing HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_bottom' hook.
 */
function wp_post_bottom() {
	do_action( 'wp_post_bottom' );
}

/**
 * Fire the wp_post_after hook
 *
 * Intended to be immediately after closing HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_after' hook.
 */
function wp_post_after() {
	do_action( 'wp_post_after' );
}

/**
 * Fire the wp_comments_before hook
 *
 * Intended to be immediately before the comments template
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_comments_before' hook.
 */
function wp_comments_before() {
	do_action( 'wp_comments_before' );
}

/**
 * Fire the wp_comments_after hook
 *
 * Intended to be immediately after the comments template
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_comments_after' hook.
 */
function wp_comments_after() {
	do_action( 'wp_comments_after' );
}

/**
 * Fire the wp_sidebar_before hook
 *
 * Intended to be immediately before opening sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebar_before' hook.
 */
function wp_sidebar_before() {
	do_action( 'wp_sidebar_before' );
}

/**
 * Fire the wp_sidebar_top hook
 *
 * Intended to be immediately inside opening sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebar_top' hook.
 */
function wp_sidebar_top() {
	do_action( 'wp_sidebar_top' );
}

/**
 * Fire the wp_sidebar_bottom hook
 *
 * Intended to be immediately inside closing sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebar_bottom' hook.
 */
function wp_sidebar_bottom() {
	do_action( 'wp_sidebar_bottom' );
}

/**
 * Fire the wp_sidebar_after hook
 *
 * Intended to be immediately after closing sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebar_after' hook.
 */
function wp_sidebar_after() {
	do_action( 'wp_sidebar_after' );
}

/**
 * Fire the wp_footer_before hook
 *
 * Intended to be immediately before opening HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_before' hook.
 */
function wp_footer_before() {
	do_action( 'wp_footer_before' );
}

/**
 * Fire the wp_footer_top hook
 *
 * Intended to be immediately inside opening HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_top' hook.
 */
function wp_footer_top() {
	do_action( 'wp_footer_top' );
}

/**
 * Fire the wp_footer_bottom hook
 *
 * Intended to be immediately inside closing HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_bottom' hook.
 */
function wp_footer_bottom() {
	do_action( 'wp_footer_bottom' );
}

/**
 * Fire the wp_footer_after hook
 *
 * Intended to be immediately after closing HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_after' hook.
 */
function wp_footer_after() {
	do_action( 'wp_footer_after' );
}
