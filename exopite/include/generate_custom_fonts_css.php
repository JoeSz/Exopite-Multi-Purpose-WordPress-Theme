<?php

// if ( ! function_exists( 'generate_custom_fonts_css' ) && class_exists( 'Exopite_Template' ) ) {
if ( ! function_exists( 'generate_custom_fonts_css' ) ) {
    function generate_custom_fonts_css( $exopite_options, $path ) {
        /*
        @font-face {
        font-family: 'MyWebFont';
        src: url('myfont.woff2') format('woff2'),
            url('myfont.woff') format('woff'),
            url('myfont.ttf') format('truetype');
        }
        */
        /**
         * Deal with fonts
         * - need to loop custom_fonts
         * - need to include custom fonts
         * https://stackoverflow.com/questions/36105194/are-eot-ttf-and-svg-still-necessary-in-the-font-face-declaration/36110385#36110385
         * https://creativemarket.com/blog/the-missing-guide-to-font-formats
         * https://css-tricks.com/snippets/css/using-font-face/
         */
        if ( isset( $exopite_options['custom_fonts'] ) && ! empty( $exopite_options['custom_fonts'] ) ) {
            $processed = array();
            foreach ( $exopite_options['custom_fonts'] as $key => $value) {
                if ( ! in_array( $key, $processed ) ) {
                    $processed[] = $key;
                    $font_files = array();
                    foreach ( $exopite_options['exopite-custom-fonts'] as $exopite_custom_font ) {
                        if ( $exopite_custom_font['exopite-local-font-name'] == $key ) {

                            if ( isset( $exopite_custom_font['exopite-local-font-ttf'] ) && ! empty( $exopite_custom_font['exopite-local-font-ttf'] ) ) {
                                $font_files[] = "url('" . $exopite_custom_font['exopite-local-font-ttf'] . "') format('truetype')";
                            }

                            if ( isset( $exopite_custom_font['exopite-local-font-woff'] ) && ! empty( $exopite_custom_font['exopite-local-font-woff'] ) ) {
                                $font_files[] = "url('" . $exopite_custom_font['exopite-local-font-woff'] . "') format('woff')";
                            }

                            if ( isset( $exopite_custom_font['exopite-local-font-woff2'] ) && ! empty( $exopite_custom_font['exopite-local-font-woff2'] ) ) {
                                $font_files[] = "url('" . $exopite_custom_font['exopite-local-font-woff2'] . "') format('woff2')";
                            }

                        }
                    }
                    Exopite_Template::$variables_array = array(
                        'font-family' => $key,
                        'font-src'    => implode( ',' . PHP_EOL, $font_files ),
                    );
                    Exopite_Template::$filename = $path . 'font-face.css';
                    return Exopite_Template::get_template();
                }
            }
        }
    }
}
