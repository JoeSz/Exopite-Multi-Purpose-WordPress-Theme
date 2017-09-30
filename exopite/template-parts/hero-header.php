<?php
/**
 * The template for displaying hero header.
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * Site specific settings
 * - img/video/youtube
 * - branding (widget, text or image)
 */

if ( ! isset( $exopite_settings['exopite-hero-header-image'] ) ||
     ! isset( $exopite_settings['exopite-hero-header-youtube-id'] ) ||
     ! isset( $exopite_settings['exopite-hero-header-video'] ) ||
     ! isset( $exopite_settings['exopite-hero-header-google-video-id'] ) ) {
    return;
}

// Hero header media type
$exopite_hero_header_type = ( is_front_page() ) ? $exopite_settings['exopite-hero-header-type'] : $exopite_meta_data['exopite-hero-header-type'];

switch ( $exopite_hero_header_type ) {
    case 'image':
        $exopite_hero_header_image = ( is_front_page() ) ?
            wp_get_attachment_image_src( $exopite_settings['exopite-hero-header-image'], 'full' )[0] :
            wp_get_attachment_image_src( $exopite_meta_data['exopite-hero-header-image'], 'full' )[0];
        if ( empty( $exopite_hero_header_image ) ) return;
        break;
    case 'youtube':
        $exopite_hero_header_youtube = ( is_front_page() ) ? $exopite_settings['exopite-hero-header-youtube-id'] : $exopite_meta_data['exopite-hero-header-youtube-id'];
        if ( empty( $exopite_hero_header_youtube ) ) return;
        break;
    case 'video':
        $exopite_hero_header_video = ( is_front_page() ) ? $exopite_settings['exopite-hero-header-video'] : $exopite_meta_data['exopite-hero-header-video'];
        if ( empty( $exopite_hero_header_video ) ) return;
        break;
    case 'googledrive':
        $exopite_hero_header_google_drive = ( is_front_page() ) ? $exopite_settings['exopite-hero-header-google-video-id'] : $exopite_meta_data['exopite-hero-header-google-video-id'];
        if ( empty( $exopite_hero_header_google_drive ) ) return;
        break;
}

// site branding alignment
$exopite_hero_header_alignment_classes = ( is_front_page() ) ?
    $exopite_settings['exopite-hero-header-site-branding-horizontal'] . ' ' . $exopite_settings['exopite-hero-header-site-branding-vertical'] :
    $exopite_meta_data['exopite-hero-header-site-branding-horizontal'] . ' ' . $exopite_meta_data['exopite-hero-header-site-branding-vertical'];

$exopite_hero_header_parallax = ( $exopite_settings['exopite-enable-hero-header-parallax'] && $exopite_settings['exopite-enable-hero-header-fixed'] ) ? 'parallax ' : '';

$exopite_hero_header_site_branding = '';

// site branding type
$exopite_hero_header_site_branding_type = ( is_front_page() ) ?
    $exopite_settings['exopite-hero-header-site-branding-type'] :
    $exopite_meta_data['exopite-hero-header-site-branding-type'];

// overlay and color
$exopite_display_hero_header_overlay = false;
$meta_hero_header_overlay_color = ( isset( $exopite_meta_data['exopite-hero-header-overlay-color'] ) ) ? $exopite_meta_data['exopite-hero-header-overlay-color'] : null;

if ( ( $exopite_settings['exopite-hero-header-overlay-color'] !== 'rgba(0,0,0,0)' || $meta_hero_header_overlay_color !== 'rgba(0,0,0,0)' ) &&
     ( $exopite_settings['exopite-hero-header-overlay-color'] !== null || $meta_hero_header_overlay_color !== null ) ) {
    $exopite_display_hero_header_overlay = true;

    $exopite_hero_overlay_color = ( $meta_hero_header_overlay_color == 'rgba(0,0,0,0)' || $meta_hero_header_overlay_color == null ) ?
        $exopite_settings['exopite-hero-header-overlay-color'] :
        $meta_hero_header_overlay_color;
}


// Branding (widget, image or text)
if ( $exopite_hero_header_site_branding_type == 'widget' ) {

    if ( is_active_sidebar( 'sidebar-site-branding' ) ) {
        ob_start();
        dynamic_sidebar( 'sidebar-site-branding' );
        $exopite_hero_header_site_branding = ob_get_contents();
        ob_end_clean();
    }

} elseif ( $exopite_hero_header_site_branding_type == 'image' ) {

    $exopite_hero_header_site_branding_image_url = ( is_front_page() ) ?
        wp_get_attachment_image_src( $exopite_settings['exopite-hero-header-site-branding-image'], 'full' )[0] :
        wp_get_attachment_image_src( $exopite_meta_data['exopite-hero-header-site-branding-image'], 'full' )[0];

    if ( $exopite_hero_header_site_branding_image_url ) {
        $exopite_hero_header_site_branding = '<a href="' . SITEURL . '"><img src="' . $exopite_hero_header_site_branding_image_url . '" alt="Site Branding"></a>';
    }

} elseif  ( $exopite_hero_header_site_branding_type == 'text' ) {

    $exopite_hero_header_site_branding = '<div class="site-branding-text">' . $exopite_meta_data['exopite-hero-header-site-branding-text'] . '</div>';

}
?>
<!-- Hero header -->
<div class="hero-header-wrapper"<?php if ( $exopite_override_hero_header_height ) echo ' style="height:' . $exopite_meta_data['exopite-hero-header-height'] . 'vh;min-height:' . $exopite_meta_data['exopite-hero-header-min-height'] . 'px;"'; ?>>
    <a class="hero-header-skip-to-content" href="#content" title="Skip to content"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
    <div class="hero-header">
<?php

// Video
if ( $exopite_hero_header_type == 'video') :

?>
    <video id="hero-header-video" class="<?php echo $exopite_hero_header_parallax; if ( $exopite_override_hero_header_height ) echo ' meta-height '; ?>hero-header-media video-control no-lazy" muted autoplay="" loop="" src="<?php echo esc_html( $exopite_hero_header_video ); ?>" width="2000" height="1200"></video>
    <?php

    if ( $exopite_display_hero_header_overlay ) :
        ?>
        <div class="hero-header-overlay" style="background:<?php echo $exopite_hero_overlay_color; ?>;"></div>
        <?php
    endif;

    if ( ! empty( $exopite_hero_header_site_branding ) ) : ?>
        <div class="site-branding <?php echo $exopite_hero_header_alignment_classes; ?>"><?php echo $exopite_hero_header_site_branding; ?></div>
        <?php
    endif;

// Image
elseif ( $exopite_hero_header_type == 'image' ) :

?>
    <img id="hero-header-image" class="<?php echo $exopite_hero_header_parallax; if ( $exopite_override_hero_header_height ) echo ' meta-height '; ?>hero-header-media" src="<?php echo $exopite_hero_header_image; ?>" alt="hero header">
    <?php

    if ( $exopite_display_hero_header_overlay ) :
        ?>
        <div class="hero-header-overlay" style="background:<?php echo $exopite_hero_overlay_color; ?>;"></div>
        <?php
    endif;

    if ( ! empty( $exopite_hero_header_site_branding ) ) :
        ?>
        <div class="site-branding <?php echo $exopite_hero_header_alignment_classes; ?>"><?php echo $exopite_hero_header_site_branding; ?></div>
        <?php
    endif;

// Youtube
elseif ( $exopite_hero_header_type == 'youtube' ) :

?>
    <iframe id="hero-header-youtube" class="<?php echo $exopite_hero_header_parallax; ?>no-max-height hero-header-media" allowfullscreen="1" title="YouTube video player" src="https://www.youtube.com/embed/<?php echo $exopite_hero_header_youtube; ?>?autoplay=1&amp;controls=0&amp;hd=1&amp;disablekb=1&amp;fs=0&amp;iv_load_policy=3&amp;loop=1&amp;modestbranding=1&amp;playsinline=1&amp;rel=0&amp;showinfo=0&amp;enablejsapi=1&amp;origin=http%3A%2F%2Flocalhost&amp;widgetid=1&playlist=<?php echo $exopite_hero_header_youtube; ?>" width="2000" height="1200" frameborder="0" volume="0"></iframe>
    <?php
    if ( ! empty( $exopite_hero_header_site_branding ) ) : ?>
        <div class="site-branding <?php echo $exopite_hero_header_alignment_classes; ?>"><?php echo $exopite_hero_header_site_branding; ?></div>
    <?php endif;

// Google drive
elseif ( $exopite_hero_header_type == 'googledrive' ) :

?>
    <iframe id="hero-header-youtube" class="<?php echo $exopite_hero_header_parallax; ?>no-max-height hero-header-media" src="https://drive.google.com/file/d/<?php echo $exopite_hero_header_google_drive; ?>/preview?autoplay=1&amp;loop=1" width="2000" height="1200" frameborder="0" volume="0"></iframe>
    <?php
    if ( ! empty( $exopite_hero_header_site_branding ) ) : ?>
        <div class="site-branding <?php echo $exopite_hero_header_alignment_classes; ?>"><?php echo $exopite_hero_header_site_branding; ?></div>
    <?php endif;

endif;
?>
    </div>
</div>
<!-- End hero-header -->
