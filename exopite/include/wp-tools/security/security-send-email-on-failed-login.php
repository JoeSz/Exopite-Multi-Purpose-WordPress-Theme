<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

add_action( 'wp_authenticate', 'log_login', 10, 2 );
function log_login( $username, $password ) {

    if ( ! empty( $username ) && ! empty( $password ) ) {

        $check = wp_authenticate_username_password( NULL, $username, $password );
        if ( is_wp_error( $check ) ) {

            $ua = getBrowser();
            $agent = $ua['name'] . " " . $ua['version'];

            $referrer = ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF'];
            if ( strstr( $referrer, 'wp-login' ) ) {
                $ref = 'wp-login.php';
            }

            if ( strstr( $referrer, 'wp-admin' ) ) {
                $ref = 'wp-admin/';
            }

            $contact_errors = false;

            // get the posted data
            $name = "WordPress " . get_bloginfo( 'name' );
            $email_address = get_bloginfo('admin_email' );

            // write the email content
            $header = "MIME-Version: 1.0\n";
            $header .= "Content-Type: text/html; charset=utf-8\n";
            $header .= "From: $name <$email_address>\n";

            $message = "Failed login attempt on <a href='" . get_site_url() . "/" . $ref . "' target='_blank'>" . $name . "</a><br>" . PHP_EOL;
            $message .= 'IP: <a href="http://whatismyipaddress.com/ip/' . get_ip_address() . '" target="_blank">' . get_ip_address() . "</a><br>" . PHP_EOL;
            $message .= 'WhoIs: <a href="https://who.is/whois-ip/ip-address/' . get_ip_address() . '" target="_blank">' . get_ip_address() . "</a><br>" . PHP_EOL;
            $message .= "Browser: " . $agent . "<br>" . PHP_EOL;
            $message .= "OS: " . $ua['platform'] . "<br>" . PHP_EOL;
            $message .= "Date: " . date('Y-m-d H:i:s') . "<br>" . PHP_EOL;
            $message .= "Referrer: " . $referrer . "<br>" . PHP_EOL;
            $message .= "User Agent: " . $ua['userAgent'] . "<br>" . PHP_EOL;
            $message .= "Username: " . $username . "<br>" . PHP_EOL;
            $message .= "Password: " . $password . "<br>" . PHP_EOL;

            $subject = "Failed login attempt - " . $name;
            $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

            $to = ( empty( WPToolsSettings::getValue( 'security-email' ) ) ) ? $email_address : WPToolsSettings::getValue( 'security-email' );

            if ( ! empty( $to ) ) {

                // send the email using wp_mail()
                if ( ! wp_mail( $to, $subject, $message, $header ) ) {
                    $contact_errors = true;
                }
            }

        }
    }
}

