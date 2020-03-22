<?php

add_action( 'wp_enqueue_scripts', 'exopite_child_scripts', 20 );
function exopite_child_scripts() {

	// enqueue child style after parent
	wp_enqueue_style( 'exopite-child-style', get_stylesheet_uri() );

}
