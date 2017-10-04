<?php
/**
 * The excerpt function
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Custom function to generate excerpt.
 * Keep allowed html tags, and new lines as well, remove only multiple lines and white spaces
 * Crop content only on comma or the end of the sentence.
 */
if ( ! function_exists( 'exopite_allowedtags' ) ) {
    function exopite_allowedtags() {
    // Add custom tags to this string
        return apply_filters( 'exopite_filter_excerpt_allowed_tags', '<strong>,<em>,<i>,<b>' );
    }
}

if ( ! function_exists( 'get_custom_excerpt' ) ) {
    function get_custom_excerpt( $input, $lenght = 20, $allow_tags = true, $allow_line_breaks = true, $excerpt_end = '', $force = false ) {

        $input = strip_shortcodes( $input );

        if ( $allow_tags ) {
            $input = strip_tags( $input, exopite_allowedtags() ); /* IF you need to allow just certain tags. Delete if all tags are allowed */
        } else {
            $input = strip_tags( $input );
        }

        if ( $allow_line_breaks ) {
            $regex_multiple_line_break = '/(?:(?:\r\n|\r|\n)\s*){2}/s';
            $input = preg_replace( $regex_multiple_line_break, ' ', $input );
        } else {
            $input = preg_replace('/\s+/', ' ', $input);
        }

        $tokens = array();
        $output = '';
        $count = 0;

        // Divide the string into tokens; HTML tags, or words, followed by any whitespace
        preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $input, $tokens);

        if ( ! $tokens[0] ) {
            if ( str_word_count( $input, 0 ) > $lenght ) {
                $words = str_word_count( $input, 2 );
                $pos = array_keys( $words );
                $output = substr( $input, 0, $pos[$lenght] );
            }
        } else {
            foreach ( $tokens[0] as $token ) {

                if ( $count >= $lenght && ( preg_match('/[\,\;\?\.\!]\s*$/uS', $token ) || $force ) ) {
                // Limit reached, continue until , ; ? . or ! occur at the end
                    $output .= trim( $token );
                    break;
                }

                // Add words to complete sentence
                $count++;

                // Append what's left of the token
                $output .= $token;
            }
        }



        if ( str_word_count( $input ) >= $lenght && $excerpt_end != '' ) $output .= $excerpt_end;

        return $output;
    }
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'exopite_custom_wp_trim_excerpt');
if ( ! function_exists( 'exopite_custom_wp_trim_excerpt' ) ) :
    function exopite_custom_wp_trim_excerpt( $exopite_excerpt, $excerpt_excerpt_word_count = 55 ) {

        global $post;

        if ( post_password_required( $post ) ) {

            // Use WordPress translation file (no slug)
            return esc_attr__( 'There is no excerpt because this is a protected post.' );
        }

        $exopite_settings = get_option( 'exopite_options' );
        $excerpt_excerpt_word_count = $exopite_settings['exopite-blog-except-length'];

        // Set default excerpt
        $excerpt_end = apply_filters( 'excerpt_end', ' ... ' );
        $excerpt_button = apply_filters( 'excerpt_button', '<p><a class="btn btn-material btn-readmore" href="'. esc_url( get_permalink() ) . '">' . __( 'Read More', 'exopite' ) . '</a></p>' );

        // Apply filter if any
        $excerpt_more = apply_filters( 'excerpt_more', $excerpt_button );

        $raw_excerpt = $exopite_excerpt;

        if ( '' == $exopite_excerpt ) {

            $exopite_excerpt = get_the_content('');
            $excerpt_length = apply_filters( 'excerpt_length', $excerpt_excerpt_word_count );

            $exopite_excerpt = get_custom_excerpt( $exopite_excerpt, $excerpt_length );

            $exopite_excerpt = trim( force_balance_tags( $exopite_excerpt ) );

            // Apply excerpt more only if content is longer then the excerpt
            if ( str_word_count( $exopite_excerpt ) <= $excerpt_length ) $excerpt_more = apply_filters( 'excerpt_no_more', $excerpt_button );

            // Add read more after the content and return
            return $exopite_excerpt . $excerpt_end . $excerpt_more;
        }

        // Custom exceprt
        return $raw_excerpt . $excerpt_button;

    }

endif;
