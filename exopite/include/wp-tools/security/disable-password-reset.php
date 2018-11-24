<?php
/*
* Plugin Name: Disable Password Reset
* Description: Disable password reset functionality. Only users with administrator role will be able to change passwords from inside admin area.
* Version: 1.0
* Author: WPBeginner
* Author URI: http://wpbeginner.com
*/

class Password_Reset_Removed
{

	function __construct() {
		add_filter( 'show_password_fields', array( $this, 'disable' ) );
		add_filter( 'allow_password_reset', array( $this, 'disable' ) );
		add_filter( 'gettext',              array( $this, 'remove' ) );
	}

	function disable() {
		if ( is_admin() ) {
			$userdata = wp_get_current_user();
			$user = new WP_User( $userdata->ID );
			if ( !empty( $user->roles ) && is_array( $user->roles ) && $user->roles[0] == 'administrator' )
			return true;
		}
		return false;
	}

	function remove( $text ) {
		return str_replace( array( 'Lost your password?', 'Lost your password' ), '', trim( $text, '?' ) );
	}
}

$exopite_password_reset_removed = new Password_Reset_Removed();