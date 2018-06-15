<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Change variables in CSS "templetes", then minify and combine CSS and JS files.
 *
 * Basically create scripts.js from the selected js files inside /js/ folder by combine them.
 * Do the same with CSS, but minify them first. Output is the theme style.css file.
 *
 * Required exopite-core plugin,
 * Exopite_Minifier: plugins/exopite-core/include/exopite-minifier.class.php
 * Exopite_Template: plugins/exopite-core/include/exopite-template.class.php
 */

if ( ! class_exists( 'Exopite_Minify_Combine' ) ) {
    class Exopite_Minify_Combine {

        public $css_files = array();
        public $js_files = array();
        public $js_files_no_minification = array();
        public $options = array();
        public $user_css = "";
        public $user_js = "";

        public function combine_js() {


            if ( ! isset( $this->options ) || empty( $this->options ) ) return;

            // Set variables to replace
            Exopite_Template::$variables_array = $this->options;

            // Set output file
            $core_file = TEMPLATEPATH . '/js/scripts.js';
            $path = TEMPLATEPATH . '/js/';
            $data = '';
            $data_no_minification = '';

            // Loop trought all seelcted js files in folder and preocess them
            foreach ( $this->js_files as $filename ) {

                if ( ! file_exists( $path . $filename ) ) continue;

                Exopite_Template::$filename = $path . $filename;

                // Store processed file as fregment in data variable
                $data .= Exopite_Template::get_template();

            }

            // Loop trought all seelcted js files in folder and preocess them
            foreach ( $this->js_files_no_minification as $filename ) {

                if ( ! file_exists( $path . $filename ) ) continue;

                Exopite_Template::$filename = $path . $filename;

                // Store processed file as fregment in data variable
                $data_no_minification .= Exopite_Template::get_template();

            }

            // Get user js at the end
            $data .= $this->user_js;

            $output = $data_no_minification;
            if ( class_exists( 'Exopite_Minifier' ) ) {
                $output .= Exopite_Minifier::minify_js( $data );
            } else {
                $output .= $data;
            }

            // Write it down
            file_put_contents( $core_file, $output );

        }

        public function generate_css() {

            if ( ! isset( $this->options ) || empty( $this->options ) ) return;

            $path = TEMPLATEPATH . '/css/';
            $template = '';

            $template .= generate_custom_fonts_css( $this->options, $path );

            //Template = new Template;
            Exopite_Template::$variables_array = $this->options;

            $core_file = TEMPLATEPATH . '/style.css';

            // Write version in css fragment
            Exopite_Template::$variables_array['version'] = EXOPITE_VERSION;

            // Inslude "_first.css" without minfing. This contains WordPress required theme header infos.
            Exopite_Template::$filename = $path . '_first.css';
            $data = Exopite_Template::get_template();

            // Write last generated
            $data .= '/* Generated: ' . date("Y-m-d H:i:s") . ' */' . PHP_EOL;

            $data .= ( class_exists( 'Exopite_Minifier' ) ) ? Exopite_Minifier::minify_css( $template ) : $template;

            foreach ( $this->css_files as $filename ) {

                if ( ! file_exists( $path . $filename ) ) continue;

                Exopite_Template::$filename = $path . $filename;

                $template = Exopite_Template::get_template();

                $data .= ( class_exists( 'Exopite_Minifier' ) ) ? Exopite_Minifier::minify_css( $template ) : $template;

            }

            // Include "_last.css" and user css at end of the css files
            if ( class_exists( 'Exopite_Minifier' ) ) {
                $data .= Exopite_Minifier::minify_css( file_get_contents( $path . '/_last.css' ) );
                $data .= Exopite_Minifier::minify_css( $this->user_css );
            } else {
                $data .= file_get_contents( $path . '/_last.css' );
                $data .= $this->user_css;
            }

            file_put_contents( $core_file, $data );

        }

    }
}
