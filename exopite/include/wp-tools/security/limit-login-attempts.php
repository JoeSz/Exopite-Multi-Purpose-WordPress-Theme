<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.
/**
 * CLASS LIMIT LOGIN ATTEMPTS
 *
 * Prevent Mass WordPress Login Attacks by setting locking the system when login fail.
 * To be added in functions.php or as an external file.
 *
 * Source: https://coderwall.com/p/dc2bbg/limit-login-attemps
 */
if ( ! class_exists( 'Limit_Login_Attempts' ) ) {
    class Limit_Login_Attempts {

        //$erliama_mods=get_theme_mod("erliama-mods");
        var $failed_login_limit = 3;                   //Number of authentification accepted
        var $lockout_duration   = 60;                  //Stop authentification process for 30 minutes: 60*30 = 1800
        var $transient_name     = 'attempted_login';    //Transient used

        public function __construct() {
            //$exopite_settings = get_option( 'exopite_options' );
            $failed_login_limit = WPToolsSettings::getValue('security-lockout-threshold');
            $lockout_duration   = WPToolsSettings::getValue('security-lockout-duration');
            add_filter( 'authenticate', array( $this, 'check_attempted_login' ), 30, 3 );
            add_action( 'wp_login_failed', array( $this, 'login_failed' ), 10, 1 );
        }

        /**
         * Lock login attempts of failed login limit is reached
         */
        public function check_attempted_login( $user, $username, $password ) {
            if ( get_transient( $this->transient_name ) ) {
                $datas = get_transient( $this->transient_name );

                if ( $datas['tried'] >= $this->failed_login_limit ) {
                    $until = get_option( '_transient_timeout_' . $this->transient_name );
                    $time = $this->when( $until );

                    //Display error message to the user when limit is reached
                    return new WP_Error( 'too_many_tried', sprintf( esc_attr__( 'ERROR: You have reached authentification limit, you will be able to try again in %1$s.', 'exopite' ) , $time ) );
                }
            }

            return $user;
        }

        /**
         * Add transient
         */
        public function login_failed( $username ) {
            if ( get_transient( $this->transient_name ) ) {
                $datas = get_transient( $this->transient_name );
                $datas['tried']++;

                if ( $datas['tried'] <= $this->failed_login_limit )
                    set_transient( $this->transient_name, $datas , $this->lockout_duration );
            } else {
                $datas = array(
                    'tried'     => 1
                );
                set_transient( $this->transient_name, $datas , $this->lockout_duration );
            }
        }


        /**
         * Return difference between 2 given dates
         * @param  int      $time   Date as Unix timestamp
         * @return string           Return string
         */
        private function when( $time ) {
            if ( ! $time )
                return;

            $right_now = time();

            $diff = abs( $right_now - $time );

            $second = 1;
            $minute = $second * 60;
            $hour = $minute * 60;
            $day = $hour * 24;

            if ( $diff < $minute )
                return floor( $diff / $second ) . ' ' . esc_attr__( 'seconds', 'exopite' );

            if ( $diff < $minute * 2 )
                return esc_attr__( 'about 1 minute ago', 'exopite' );

            if ( $diff < $hour )
                return floor( $diff / $minute ) . ' ' . esc_attr__( 'minutes', 'exopite' );

            if ( $diff < $hour * 2 )
                return esc_attr__( 'about 1 hour', 'exopite' );

            return floor( $diff / $hour ) . ' ' . esc_attr__( 'hours', 'exopite' );
        }
    }
}

//Enable it:
new Limit_Login_Attempts();

