<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * Custom media functions for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Exopite
 *
 * Functions:
 *  - exopite_custom_image_sizes_name (pluggable)
 *  - exopite_remove_emojicons (pluggable)
 *  - exopite_filter_media_comment_status (pluggable)
 *  - exopite_create_effect_image_frame (pluggable)
 *  - exopite_display_post_thumbnail (pluggable)
 *  - get_featured_image (pluggable)
 *  - get_post_first_image (pluggable)
 *
 */

/*
 * Loop trough user definied image sizes in options
 *
 * @link https://code.tutsplus.com/tutorials/using-custom-image-sizes-in-your-theme-and-resizing-existing-images--wp-24815
 */
if ( isset( $exopite_settings['exopite-thumbnail-sizes'] ) && is_array( $exopite_settings['exopite-thumbnail-sizes'] ) ) {

    foreach ( $exopite_settings['exopite-thumbnail-sizes'] as $key => $sizes ) {
        if ( isset( $sizes['exopite-thumbnail-size-crop'] ) ) {
            $crop = ( $sizes['exopite-thumbnail-size-crop'] ) ? $sizes['exopite-thumbnail-size-crop'] : false;
        } else {
            $crop = false;
        }

        //$title = sanitize_text_field( $sizes['exopite-thumbnail-size-title'] );
        $thumbnail_size_title = sanitize_title( $sizes['exopite-thumbnail-size-title'] );
        add_image_size( $thumbnail_size_title, $sizes['exopite-thumbnail-size-dimention']['width']['value'], $sizes['exopite-thumbnail-size-dimention']['height']['value'], $crop );
    }

    ExopiteSettings::setValue( 'exopite-thumbnail-sizes', $exopite_settings['exopite-thumbnail-sizes'] );

}

/*
 * Define "readable" image sizes name
 */
add_filter( 'image_size_names_choose', 'exopite_custom_image_sizes_name' );
if ( ! function_exists( 'exopite_custom_image_sizes_name' ) ) {
    function exopite_custom_image_sizes_name( $default_sizes ) {

        $custom_sizes = array(
            'releated' => 'Releated',
            'avatar' => 'Avatar',
            'blog-list-full' => 'Blog list full',
            'blog-list-multiple' => 'Blog list multiple',
        );

        $exopite_thumbnail_sizes = ExopiteSettings::getValue( 'exopite-thumbnail-sizes' );

        if ( is_array( $exopite_thumbnail_sizes ) ) {
            foreach ( $exopite_thumbnail_sizes as $key => $sizes ) {
                $thumbnail_size_title = sanitize_title( $sizes['exopite-thumbnail-size-title'] );
                $custom_sizes[$thumbnail_size_title] = $sizes['exopite-thumbnail-size-title'];
            }
        }

        return array_merge( $default_sizes, $custom_sizes );
    }
}

/**
 * Remove emojicons
 * @link https://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2/185578#185578
 */
if ( isset( $exopite_settings['exopite-remove-emojicons'] ) && $exopite_settings['exopite-remove-emojicons'] ) {

    add_action( 'init', 'exopite_remove_emojicons' );

    if ( ! function_exists( 'exopite_remove_emojicons' ) ) {
        function exopite_remove_emojicons() {

            // all actions related to emojis
            remove_action( 'admin_print_styles', 'print_emoji_styles' );
            remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'wp_print_styles', 'print_emoji_styles' );
            remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
            remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
            remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

            // filter to remove the DNS prefetch by returning false on filter emoji_svg_url
            add_filter( 'emoji_svg_url', '__return_false' );
        }
    }

}

/**
 * How to Disable Comments on WordPress Media Attachments
 *
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-disable-comments-on-wordpress-media-attachments/
 */
if ( isset( $exopite_settings['exopite-disable-media-comments'] ) && $exopite_settings['exopite-disable-media-comments'] ) {

    add_filter( 'comments_open', 'exopite_filter_media_comment_status', 10 , 2 );

    if ( ! function_exists( 'exopite_filter_media_comment_status' ) ) {
        function exopite_filter_media_comment_status( $open, $post_id ) {
            $post = get_post( $post_id );
            if( $post->post_type == 'attachment' ) {
                return false;
            }
            return $open;
        }
    }

}

/**
 * Create image with animation
 */
if ( ! function_exists( 'exopite_create_effect_image_frame' ) ) {
    function exopite_create_effect_image_frame( $image, $caption, $class = '', $style = '', $effect = 'effect-thumbnail', $alt = '' ) {

        if ( ! empty( $style ) ) $style = ' style="' . $style . '"';

        /**
         * Check if $image start with '<img'
         * if not, it is the whole <img...> tag
         */
        if ( 0 !== strpos( $image, '<img' ) ) {

            $image = '<img src="' . $image . '"';

            if ( ! empty( $alt ) ) $image .= ' alt="' . $alt . '"';

            $image .= '>';

        }

        $frame  = '<figure class="' . $effect . $class . '"' . $style . '>';
        $frame .= $image;
        $frame .= '<figcaption><div class="figure-caption animation">' . $caption . '</div></figcaption>';
        $frame .= '</figure>';

        return $frame;
    }
}

/**
 * Get featured image if exist or post first image
 */
if ( ! function_exists( 'get_featured_image' ) ) {
    function get_featured_image( $post_ID ) {

        $post_thumbnail_id = get_post_thumbnail_id( $post_ID );

        if ( $post_thumbnail_id ) {

            $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'featured_preview' );

            return $post_thumbnail_img[0];

        } else {

            return get_post_first_image();

        }
    }
}

/**
 * Get The First Image From a Post
 *
 * Working for post content only. Some page builders (like GoodLayers) store data in meta, insted of content.
 *
 * @link Source: https://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post/
 */
if ( ! function_exists( 'get_post_first_image' ) ) {
    function get_post_first_image() {

        // Source: https://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post/
        global $post, $posts;

        if ( ! isset( $post->post_content ) || $post->post_content == null || is_404() ) return false;

        $first_img = '';
        ob_start();
        ob_end_clean();

        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

        if ( isset( $matches[1][0] ) ) {

            return $matches[1][0];

        } else {

            return false;

        }

    }
}


/**
 * Display featured image on post/blog list
 */
if ( ! function_exists( 'exopite_display_post_thumbnail' ) ) {
    function exopite_display_post_thumbnail( $class = '', $full_size = false, $caption = '', $multiple_thumbnail = false ) {

        /**
         * Display thumbnail az image or background-image
         *
         * Get settings
         */
        $exopite_settings = get_option( 'exopite_options' );

        // Get all thumbnail sizes
        $thumbnails = get_intermediate_image_sizes();

        /**
         * Get medium image size
         *
         * Check if user definied image size is exist, if not, use dafault
         */
        if ( isset( $exopite_settings['exopite-blog-list-thumbnail-size-medium'] ) &&
             array_key_exists( $exopite_settings['exopite-blog-list-thumbnail-size-medium'] , $thumbnails ) ) {
            $thumbnail_slug_medium = get_intermediate_image_sizes()[$exopite_settings['exopite-blog-list-thumbnail-size-medium']];
        } else {
            $thumbnail_slug_medium = 'blog-list-multiple';
        }

        // Get full image size
        if ( isset( $exopite_settings['exopite-blog-list-thumbnail-size-large'] ) &&
             array_key_exists( $exopite_settings['exopite-blog-list-thumbnail-size-large'] , $thumbnails ) ) {
            $thumbnail_slug_large = get_intermediate_image_sizes()[$exopite_settings['exopite-blog-list-thumbnail-size-large']];
        } else {
            $thumbnail_slug_large = 'blog-list-full';
        }

        $thumbnail_size = ( $full_size )  ? $thumbnail_slug_large : $thumbnail_slug_medium;
        $thumbnail_size_class = ( $multiple_thumbnail ) ? ' image-same-size' : '';
        $thumbnail_container_style = "";
        $thumbnail_url = "";

        /**
         * Display featured image (post thumbnail)
         */
        if ( ! is_singular() &&
             ( ! isset( $exopite_settings['exopite-blog-display-thumbnail'] ) ||
               $exopite_settings['exopite-blog-display-thumbnail'] == true ) ) :

            if ( has_post_thumbnail() && $multiple_thumbnail && ! post_password_required() ) {

                // If multiple image in the row, then display them in the same size (looks better)
                $thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size );
                $url = $thumbnail_url['0'];
                $thumbnail_container_style = 'background-image: url(' . $url . ');';

            } elseif ( has_post_thumbnail() && post_password_required() ) {

                $thumbnail_size_class .= ' image-protected';

            }

            $post_format = get_post_format();

            $media = '';

            /**
             * If post format is video or audio, display media insted of thumbnail.
             */
            $allowed_formats = array( 'video', 'audio' );
            if ( in_array( $post_format, $allowed_formats ) ) {
                $media_url = esc_url( get_post_meta( get_the_id(), 'media_thumbnail', true ) );

                switch ( $post_format ) {
                    case 'video':
                        $thumbnail_url = ( has_post_thumbnail() ) ? esc_url( wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full')[0] ) : false;

                        if ( ! empty( $media_url )  && ! post_password_required() ) :
                            $site_url = get_site_url();
                            $poster = ( $thumbnail_url ) ? ' poster="' . $thumbnail_url . '"' : '';
                            $media .= '<div class="clearfix entry-thumbnail-video-container">';

                            if ( substr( $media_url, 0, strlen( $site_url ) ) == $site_url ||
                                substr( $site_url, 0, 12 ) == '/wp-content/' ) :

                                $media .= '<video class="video" controls' .  $poster . '>';
                                $media .= '<source src="' . $media_url . '" type="video/mp4" id="vidsrc">';
                                $media .= esc_html__( 'Your browser does not support HTML5 video.', 'exopite' );
                                $media .= '</video>';

                            else:
                                $media .=  wp_oembed_get( $media_url, array( 'width' => 400 ) );
                            endif;

                            $media .= '</div>';

                        endif;
                        break;
                    case 'audio':
                        $ext = pathinfo( $media_url, PATHINFO_EXTENSION );
                        $format = '';

                        switch ( $ext ) {
                            case 'mp3':
                                $format = 'audio/mpeg';
                                break;
                            case 'ogg':
                                $format = 'audio/ogg';
                                break;
                            case 'wav':
                                $format = 'audio/wav';
                                break;
                        }

                        $media .= '<audio class="audio" controls>';
                        $media .= '<source src="' . $media_url . '" type="' . $format . '">';
                        $media .= esc_html__( 'Your browser does not support HTML5 audio.', 'exopite' );
                        $media .= '</audio>';
                        break;
                        // If no post format selected

                }
            }

            if ( empty( $media ) && has_post_thumbnail() ) {
                $media .= '<a href="' . esc_url( get_permalink() ) . '">';
                $image = ( ! $multiple_thumbnail && ! post_password_required() ) ? get_the_post_thumbnail( null, $thumbnail_size ) : '';
                $media .= exopite_create_effect_image_frame( $image, $caption, ' entry-thumbnail' . $thumbnail_size_class, $thumbnail_container_style );
                $media .= '</a>';
            }
            ?>
                <div class="clearfix entry-thumbnail-container<?php echo $class; ?>">
                    <?php echo $media; ?>
                </div><!-- .entry-thumbnail-container -->
            <?php
        endif;
    }
}

/**
 * Replace iframe to embed.
 *
 * @link https://gist.github.com/amielucha/d23fb0663b3af0565bb9
 * @link https://www.safaribooksonline.com/library/view/regular-expressions-cookbook/9780596802837/ch08s02.html
 */
// add_filter( 'video_embed_html', 'exopite_change_oembed_result', 99, 4 );
// add_filter( 'embed_oembed_html', 'exopite_change_oembed_result', 99, 4 );
// add_filter( 'oembed_result', 'exopite_change_oembed_result', 10, 3 );
if ( ! function_exists( 'exopite_change_oembed_result' ) ) {
    function exopite_change_oembed_result( $html, $url, $args, $post_id = 0 ) {

        preg_match_all('@(<iframe(?:.*?)</iframe>)@s', $html, $matches, PREG_SET_ORDER);

        $$html = preg_replace(
            array('/<iframe/', '/<\/iframe>/'),
            array('<embed', '</embed>'),
            $html
        );

        return $html;

    }
}

/**
 * HTML Replacement - Support for a custom class attribute in the native gallery shortcode
 */
add_filter( 'post_gallery', function( $html, $attr, $instance )
{
    add_filter( 'gallery_style', function( $html ) use ( $attr )
    {
        if ( isset( $attr['class'] ) || isset( $attr['data-mode'] ) ) {

            $class = ( isset( $attr['class'] ) ) ? esc_attr( $attr['class'] ) . ' ' : '';
            $mode = ( isset( $attr['data-mode'] ) ) ? 'data-mode="' . esc_attr( $attr['data-mode'] ) . '" ' : '';
            unset( $attr['class'] );

            // Modify & replace the current class attribute
            $html = str_replace(
                "class='gallery ",
                sprintf(
                    $mode . "class='gallery %s",
                    $class
                ),
                $html
            );
        }
        return $html;
    } );

    return $html;
}, 10 ,3 );