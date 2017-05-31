<?php

/*
 Plugin Name: GZIP Output
 Plugin URI: http://www.ilfilosofo.com/blog/2008/02/22/wordpress-gzip-plugin/
 Version: 1.1
 Description: Allow GZIPped output for your WordPress blog.  Restores functionality removed in WordPress 2.5.
 Author: Austin Matzko
 Author URI: http://www.ilfilosofo.com/
 */

/* Copyright 2008 Austin Matzko    if.website at gmail.com License: GPL 2 */

function filosofo_gzip_compression() {
	// don't use on TinyMCE
	if (stripos($_SERVER['REQUEST_URI'], 'wp-includes/js/tinymce') !== false) {
		return false;
	}
	// can't use zlib.output_compression and ob_gzhandler at the same time
	if ( ( ini_get( 'zlib.output_compression' ) == 'On' || ini_get( 'zlib.output_compression_level' ) > 0 ) || ini_get( 'output_handler' ) == 'ob_gzhandler' ) {
		return false;
	}

	if ( extension_loaded( 'zlib' ) ) {
		ob_start( 'ob_gzhandler' );
	}
}
add_action('init', 'filosofo_gzip_compression');
// keep it from conflicting with older versions, if someone activates it on a pre-WP 2.5 site
//add_filter('option_gzipcompression', create_function('$a','return false;'));
?>
