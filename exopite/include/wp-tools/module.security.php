<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

defined( 'SECURITY_BASEDIR' ) or define( 'SECURITY_BASEDIR', BASEDIR . "security" . DIRECTORY_SEPARATOR );
/*
 * Load secrutiy modules
 */
if ( WPToolsSettings::getValue( 'security-enabled' ) ) {

    if ( WPToolsSettings::getValue( 'security-limit-login-attempts' ) && is_file( SECURITY_BASEDIR . 'limit-login-attempts.php' ) ) {
        include_once SECURITY_BASEDIR . 'limit-login-attempts.php';
    }

    if ( WPToolsSettings::getValue( 'security-turn-off-login-errors' ) && is_file( SECURITY_BASEDIR . 'hide-login-error-messages.php' ) ) {
        include_once SECURITY_BASEDIR . 'hide-login-error-messages.php';
    }

    if ( ! is_admin() && WPToolsSettings::getValue( 'security-stop-user-enumeration' ) && is_file( SECURITY_BASEDIR . 'stop-user-enumeration.php' ) ) {
        include_once SECURITY_BASEDIR . 'stop-user-enumeration.php';
    }

    if ( WPToolsSettings::getValue( 'security-disable-xmlrpc' ) && is_file( SECURITY_BASEDIR . 'xmlprc.php' ) ) {
        include_once SECURITY_BASEDIR . 'xmlprc.php';
    }

    if ( WPToolsSettings::getValue( 'security-disable-rest-api' ) && is_file( SECURITY_BASEDIR . 'disable-json-api.php' ) ) {
        include_once SECURITY_BASEDIR . 'disable-json-api.php';
    }

    if ( WPToolsSettings::getValue( 'security-prevent-script-injection' ) && is_file( SECURITY_BASEDIR . 'prevent-malicious-url-requests.php' ) ) {
        include_once SECURITY_BASEDIR . 'prevent-malicious-url-requests.php';
    }

    if ( WPToolsSettings::getValue( 'security-comment-flood-check-referer' ) && is_file( SECURITY_BASEDIR . 'check-comment-referer.php' ) ) {
        include_once SECURITY_BASEDIR . 'check-comment-referer.php';
    }

    if ( WPToolsSettings::getValue( 'security-disable-file-editor-in-admin' ) && is_file( SECURITY_BASEDIR . 'disable-file-editor-in-admin.php' ) ) {
        include_once SECURITY_BASEDIR . 'disable-file-editor-in-admin.php';
    }

    if ( WPToolsSettings::getValue( 'security-email-on-failed-login' ) && is_file( SECURITY_BASEDIR . 'security-send-email-on-failed-login.php' ) ) {
        include_once SECURITY_BASEDIR . 'security-send-email-on-failed-login.php';
    }

}
