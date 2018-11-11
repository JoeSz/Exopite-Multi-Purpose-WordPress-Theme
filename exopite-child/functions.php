<?php

function exopite_child_scripts() {

	// enqueue style
	wp_enqueue_style('exopite-child-style', get_stylesheet_uri());

}
add_action( 'wp_enqueue_scripts', 'exopite_child_scripts' );