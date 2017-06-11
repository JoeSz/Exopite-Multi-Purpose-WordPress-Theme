<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Class to handle plugin activations and deactivations tasks
 *
 * ToDo:
 * - hooks (action) for actions (activated, deactivated, both)
 *         (filter) for plugins to check and theme option slug
 */
class Exopite_Plugin_Management {

    private static $active_plugins = array();
    private static $saved_plugins = array();

    public static $options_slug = 'exopite_options';
    public static $theme_options = array();
    public static $plugins_to_check = array(
        'woocommerce/woocommerce.php',
        'siteorigin-panels/siteorigin-panels.php',
    );

    public static function activated_actions( $changed ) {

        do_action( 'exopite-plugin-management-activated-actions' );

    }

    public static function deactivated_actions( $changed ) {

        do_action( 'exopite-plugin-management-deactivated-actions' );

    }

    public static function on_chanche_actions( $activated, $deactivated ) {

        do_action( 'exopite-plugin-management-on-chanche-actions' );

        if ( in_array( 'woocommerce/woocommerce.php', array_merge( $activated, $deactivated ) ) ) {

            require_once join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, 'cs-framework-override', 'on_save_options.php' ) );
            on_save_options( self::$theme_options );

        }

        if ( in_array( 'siteorigin-panels/siteorigin-panels.php', $activated ) ) {

            $post_types = SiteOrigin_Panels_Settings::single()->get( 'post-types' );
            if ( ! in_array( 'exopite-sections', $post_types ) ) {

                $post_types[] = 'exopite-sections';
                SiteOrigin_Panels_Settings::single()->set( 'post-types', $post_types );

            }

        }

    }

    private static function save_plugin_list() {

        if ( ! is_array( self::$active_plugins ) )  self::$active_plugins = array();

        self::$theme_options['active-plugins'] = self::$active_plugins;
        update_option( self::$options_slug , self::$theme_options );
        return self::$active_plugins;

    }

    private static function init() {

        // Get active plugins
        self::$active_plugins = get_option('active_plugins');

        // Get theme options
        self::$theme_options = get_option( self::$options_slug );

        // Get saved active plugins from theme options
        // For first use or when on plugins are activated
        if ( ! isset( self::$theme_options['active-plugins'] ) || ! is_array( self::$theme_options['active-plugins'] ) || ! is_array( self::$active_plugins ) ) {

            // Save active plugins
            self::save_plugin_list();

            // Return empty array
            return false;

        } else {

            self::$saved_plugins = self::$theme_options['active-plugins'];

            return true;

        }

    }

    private static function check_activated_plugins() {

        if ( ! self::init() ) return array();

        $actived = array();

        // Loop trough active plugins
        foreach ( self::$active_plugins as $active_plugin ) {

            // If plugin is in our checklist
            if ( in_array( $active_plugin, self::$plugins_to_check ) ) {

                // If plugin is active and not saved as active (now activated)
                if ( ! in_array( $active_plugin, self::$saved_plugins ) ) {

                    $actived[] = $active_plugin;

                }

            }

        }

        return $actived;

    }

    private static function check_deactivated_plugins() {

        if ( ! self::init() ) return array();

        $retval = array();

        // If no active plugins, then return our plugin list
        if ( ! is_array( self::$active_plugins ) || empty( self::$active_plugins ) ) {

            $retval = self::$plugins_to_check;

        } else {

            $deactived = array();

            // Loop trough saved plugins
            foreach ( self::$saved_plugins as $saved_plugin ) {

                // If plugin is in our checklist
                if ( in_array( $saved_plugin, self::$plugins_to_check ) ) {

                    // If plugin is not an active plugin (now deactivated)
                    if ( ! in_array( $saved_plugin, self::$active_plugins ) ) {

                        $deactived[] = $saved_plugin;

                    }

                }

            }

            $retval = $deactived;

        }

        return $retval;

    }

    public static function on_activated() {

        $changed = self::check_activated_plugins();

        self::save_plugin_list();

        if ( ! empty( $changed ) ) {

            self::activated_actions( $changed );

        }

    }

    public static function on_deactivated() {

        $changed = self::check_deactivated_plugins();

        self::save_plugin_list();

        if ( ! empty( $changed ) ) {

            self::deactivated_actions( $changed );

        }

    }

    public static function on_activation_changed() {

        $activated = self::check_activated_plugins();
        $deactivated = self::check_deactivated_plugins();

        self::save_plugin_list();

        if ( ! empty( $activated ) || ! empty( $deactivated ) ) {

            self::on_chanche_actions( $activated, $deactivated );

        }

    }

}
