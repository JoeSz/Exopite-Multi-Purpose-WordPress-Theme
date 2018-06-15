<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, shrink-to-fit=no">
<title><?php echo bloginfo( 'name' ); ?> &#8250; <?php _e( 'Maintenance', 'exopite' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php
// Exit if accessed directly
defined('ABSPATH') or die( __( 'You cannot access this page directly.', 'exopite' ) );

/*
 * check type
 * - if section
 *   display section
 * - if text
 *   display content and bg image
 */

$exopite_settings = get_option( 'exopite_options' );

/**
 * Generate Google fonts query.
 */
require_once( INC . '/google-fonts.php' );

/**
 * Enqueue scripts and styles.
 */
require( INC . '/enqueue.php' );

require_once( TEMPLATEPATH . '/cs-framework-override/on_save_options.php' );

$exopite_settings = css_generate_background( 'exopite-maintenance-backgorund', $exopite_settings );

if ( isset( $exopite_settings['google_fonts'] ) && ! empty( $exopite_settings['google_fonts'] ) ) {

    // Do not load is downlaod locally, it is then already inculded in css
    if ( ! ( isset( $exopite_settings['exopite-download-google-fonts'] ) && $exopite_settings['exopite-download-google-fonts'] ) ) {

        $google_fonts = get_google_fonts();
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo 'http' . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . '://fonts.googleapis.com/css?family=' . $google_fonts['regular'] ?>">
        <?php

    } else {
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() . '/css/google-fonts.css'; ?>">
        <?php
    }
}

?>
<style type="text/css">
<?php
if ( isset( $exopite_settings['custom_fonts'] ) && ! empty( $exopite_settings['custom_fonts'] ) ) {
    echo generate_custom_fonts_css( $exopite_settings, TEMPLATEPATH . '/css/' );
}
?>
body,h1,h2,h3,h4,h5,h6,p {
    font-family: "<?php echo $exopite_settings['exopite-font-content']['family']; ?>";
    font-weight: <?php echo $exopite_settings['exopite-font-content']['weight']; ?>;
}
body {
    font-size: <?php echo $exopite_settings['exopite-font-content']['size']; ?>px;
    line-height: <?php echo $exopite_settings['exopite-font-content']['height']; ?>px;
    background: <?php echo $exopite_settings['exopite-maintenance-backgorund']['css']; ?>;
}
.full {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom:0;
}
.absolute-center {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    flex-direction: column;
}
#content {
    text-align: center;
}
</style>
</head>
<body>
    <div class="full">
        <div class="absolute-center">
        <?php
        if ( empty( $exopite_settings['exopite-maintenance-text'] ) ) :
            ?>
            <div id="header">
                <h1><?php echo __( 'Temporarly down for maintenance', 'exopite' ); ?></h1>
            </div>
            <div id="content">
                <h3><?php _e( 'We should be back online shortly.', 'exopite' ); ?></h3>
                <p><a href="<?php echo get_site_url() . '/wp-login.php'; ?>">Login</a></p>
            </div>
            <?php
        else :

            /**
             * Apply WordPress content filters to maintenance content
             *
             * @link https://themehybrid.com/weblog/how-to-apply-content-filters
             */
            add_filter( 'exopite_maintenance_content', 'wptexturize'       );
            add_filter( 'exopite_maintenance_content', 'convert_smilies'   );
            add_filter( 'exopite_maintenance_content', 'convert_chars'     );
            add_filter( 'exopite_maintenance_content', 'wpautop'           );
            add_filter( 'exopite_maintenance_content', 'shortcode_unautop' );
            add_filter( 'exopite_maintenance_content', 'do_shortcode'      );
            $content = apply_filters( 'exopite_maintenance_content', $exopite_settings['exopite-maintenance-text'] );
            echo $content;

        endif;
        ?>
        </div>
    </div>
</body>
</html>
