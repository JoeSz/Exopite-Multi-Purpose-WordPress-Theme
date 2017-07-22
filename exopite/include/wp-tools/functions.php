<?php if ( !  defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = $u_agent;
    $platform = '';
    $version= '';

    //First get the platform?
    if ( preg_match( '/linux/i', $u_agent ) ) {
        $platform = 'Linux';
    }
    elseif ( preg_match( '/macintosh|mac os x/i', $u_agent ) ) {
        $platform = 'Mac';
    }
    elseif ( preg_match( '/windows|win32/i', $u_agent ) ) {
        $platform = 'Windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if ( preg_match( '/MSIE/i',$u_agent) && ! preg_match( '/Opera/i',$u_agent ) ) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif( preg_match( '/Firefox/i',$u_agent ) ) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif( preg_match( '/Chrome/i',$u_agent ) ) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif( preg_match( '/Safari/i',$u_agent ) ) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif( preg_match( '/Opera/i',$u_agent ) ) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif( preg_match( '/Netscape/i',$u_agent ) ) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array( 'Version', $ub, 'other');
    $pattern = '#( ?<browser>' . join( '|', $known) .
    ')[/ ]+( ?<version>[0-9.|a-zA-Z.]*)#';

    if ( ! preg_match_all( $pattern, $u_agent, $matches ) ) {
        // we have no matching number just continue
    }

    if ( isset( $matches['browser'] ) ) {
        // see how many we have
        $i = count( $matches['browser'] );

        if ( $i != 1) {

            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if ( strripos( $u_agent,"Version") < strripos( $u_agent,$ub ) ){
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }
    } else {
        $version="?";
    }

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern
    );
}


function get_ip_address( ) {
    // check for shared internet/ISP IP
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) && validate_ip( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

        // check if multiple ips exist in var
        if ( strpos( $_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ( $iplist as $ip) {
                if ( validate_ip( $ip ) )
                    return $ip;
            }
        } else {
            if ( validate_ip( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if ( ! empty( $_SERVER['HTTP_X_FORWARDED']) && validate_ip( $_SERVER['HTTP_X_FORWARDED'] ) ) {
        return $_SERVER['HTTP_X_FORWARDED'];
    }
    if ( ! empty( $_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip( $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] ) ) {
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }
    if ( ! empty( $_SERVER['HTTP_FORWARDED_FOR']) && validate_ip( $_SERVER['HTTP_FORWARDED_FOR'] ) ) {
        return $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if ( ! empty( $_SERVER['HTTP_FORWARDED']) && validate_ip( $_SERVER['HTTP_FORWARDED'] ) ) {
        return $_SERVER['HTTP_FORWARDED'];
    }

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip( $ip) {
    if ( strtolower( $ip) === 'unknown') {
        return false;
    }

    // generate ipv4 network address
    $ip = ip2long( $ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ( $ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers ( ints default to signed in PHP)
        $ip = sprintf( '%u', $ip);
        // do private network range checking
        if ( $ip >= 0 && $ip <= 50331647) return false;
        if ( $ip >= 167772160 && $ip <= 184549375) return false;
        if ( $ip >= 2130706432 && $ip <= 2147483647) return false;
        if ( $ip >= 2851995648 && $ip <= 2852061183) return false;
        if ( $ip >= 2886729728 && $ip <= 2887778303) return false;
        if ( $ip >= 3221225984 && $ip <= 3221226239) return false;
        if ( $ip >= 3232235520 && $ip <= 3232301055) return false;
        if ( $ip >= 4294967040) return false;
    }
    return true;
}
