<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

class WPToolsSettings
{
    public static $options = array();
    public static $theme_options = array();
    private static $theme_prefix;

    static public function setThemeOptions( $value ) {
        self::$theme_options = $value;
        self::$theme_prefix = ( isset( $value['theme-prefix'] ) ) ? $value['theme-prefix'] : '';
    }

    static public function setValue( $key, $value ) {
        self::$options[$key] = $value;
    }

    static public function setDefault( $key, $value ) {
        if ( ! isset( self::$theme_options[self::$theme_prefix . '-' . $key] ) ) {
            self::$options[$key] = $value;
        } else {
            self::$options[$key] = self::$theme_options[self::$theme_prefix . '-' . $key];
        }
    }

    static public function getValue( $key ) {
        if ( isset( self::$options[$key] ) ) {
            return self::$options[$key];
        } else {
            return null;
        }

    }

    static public function deleteValue($key) {
        unset( self::$options[$key] );
    }

    static public function checkValue($key) {
        if ( array_key_exists( $key, self::$options ) ) {
            return true;
        } else {
            return false;
        }
    }
}

function load_settings() {
    // get Theme settings
    $theme_settings = get_option( 'exopite_options' );

    WPToolsSettings::setThemeOptions( $theme_settings );
    WPToolsSettings::setDefault( 'security-enabled', true );
    WPToolsSettings::setDefault( 'security-limit-login-attempts', false );
    WPToolsSettings::setDefault( 'security-lockout-threshold', '3' );
    WPToolsSettings::setDefault( 'security-lockout-duration', '10' );
    WPToolsSettings::setDefault( 'security-turn-off-login-errors', true );
    WPToolsSettings::setDefault( 'security-disable-file-editor-in-admin', true );
    WPToolsSettings::setDefault( 'security-stop-user-enumeration', true );
    WPToolsSettings::setDefault( 'security-disable-xmlrpc', true );
    WPToolsSettings::setDefault( 'security-disable-rest-api', false );
    WPToolsSettings::setDefault( 'security-rest-api-only-authenticated', false );
    WPToolsSettings::setDefault( 'security-prevent-script-injection', true );
    WPToolsSettings::setDefault( 'security-comment-flood-check-referer', true );
    WPToolsSettings::setDefault( 'security-send-email-on-failed-login', true );
    WPToolsSettings::setDefault( 'security-email', '' );
    WPToolsSettings::setDefault( 'security-email-on-failed-login', '' );
    WPToolsSettings::setDefault( 'security-disable-password-reset', false );

}

if( ! function_exists( 'wp_toos_init' ) ) {
    function wp_toos_init() {

        load_settings();

        defined( 'WPT_VERSION' ) or define( 'WPT_VERSION', '1.0' );
        defined( 'BASEDIR' ) or define( 'BASEDIR', dirname(__FILE__) . DIRECTORY_SEPARATOR );

        $modules = array(
            'functions.php',
            'module.security.php',
        );

        foreach ( $modules as &$module ) {
            if( is_file( BASEDIR .  $module ) )  {
                include_once BASEDIR . $module;
            }
        }

    }
}
add_action( 'init', 'wp_toos_init', 10 );
