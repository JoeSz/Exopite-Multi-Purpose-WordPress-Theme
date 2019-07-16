<?php

add_action( 'wp_enqueue_scripts', 'exopite_child_scripts', 20 );
function exopite_child_scripts() {

	// enqueue child style after parent
	wp_enqueue_style( 'exopite-child-style', get_stylesheet_uri() );

}

add_filter( 'wp_check_filetype_and_ext', 'add_custom_upload_mimes', 10, 4 );
function add_custom_upload_mimes( $data, $file, $filename, $mimes ) {
    $allowed_ext = array( 'svg', 'woff', 'woff2', 'ttf' );
    $ext = array_pop( explode( '.', $filename ) );
    if ( ! in_array( $ext, $allowed_ext ) ) {
        return $data;
    }
    $wp_filetype = wp_check_filetype( $filename, $mimes );
    $ext = $wp_filetype['ext'];
    $type = $wp_filetype['type'];
    $proper_filename = $data['proper_filename'];
    return compact( 'ext', 'type', 'proper_filename' );
}
