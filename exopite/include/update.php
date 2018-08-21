<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Automatic Updates For Private And Commercial Themes
 *
 * @link http://w-shadow.com/blog/2011/06/02/automatic-updates-for-commercial-themes/
 * @link https://github.com/YahnisElsts/plugin-update-checker
 * @link https://github.com/YahnisElsts/wp-update-server
 */
if ( is_admin() && ! class_exists( 'ThemeUpdateChecker' ) ) {
    require_once join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, 'include', 'plugins', 'theme-update-checker.php' ) );

    $MyThemeUpdateChecker = new ThemeUpdateChecker (
        'exopite', //Theme slug. Usually the same as the name of its directory.
        'https://update.joeszalai.org/?action=get_metadata&slug=exopite' //Metadata URL.
    );

}
