<?php
/**
 * On save in CodeStar Options generate style.css and scripts.js form
 * css and js files based on settings.
 * In this way, css and js file size can be reduces for less data and more speed.
 */

if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

// Generate RGB from Hex color
function css_generate_rgb( $setting, $options ) {

    if ( preg_match( '/#([a-fA-F0-9]{3}){1,2}\b/', $options[$setting] ) ) {

        list( $r, $g, $b ) = sscanf( $options[$setting], "#%02x%02x%02x" );

        $options[$setting . '-rgb'] = "$r,$g,$b";
    } else {
        $options[$setting . '-rgb'] = $options[$setting];
    }

    return $options;
}

// Generate CSS background property
function css_generate_background( $setting, $options ) {
    if ( empty( $options[$setting]['image'] ) ) {
        $options[$setting]['css'] = $options[$setting]['color'];
    } else {
        $options[$setting]['css'] =
            $options[$setting]['color'] .
            ' url("' . $options[$setting]['image'] . '") ' .
            $options[$setting]['repeat'] . ' ' .
            $options[$setting]['position'];

            if ( $options[$setting]['size'] == 'cover' || $options[$setting]['size'] == 'contain' ) {
                $options[$setting]['css'] .= ' / ' . $options[$setting]['size'];
            }

            $options[$setting]['css'] .= ' ' . $options[$setting]['attachment'];
    }
    return $options;
}

// Generate Google font families to include
function add_google_font( $family, $weight, $google_fonts ) {
    if ( ! is_array( $google_fonts ) ) $google_fonts = array();
    if( ! array_key_exists( $family, $google_fonts ) || ! in_array( $weight, $google_fonts[$family] ) ) {
        $google_fonts[$family][] = ( $weight == 'regular' ) ? '400' : $weight;
    }
    return $google_fonts;
}

// Generate CSS font property
function css_generate_font( $setting, $options ) {
    if ( strpos( $options[$setting]['variant'], 'italic') !== false) {
        $options[$setting]['weight'] = str_replace( 'italic', '', $options[$setting]['variant'] );
        $options[$setting]['style'] = 'italic';
    } else {
        $options[$setting]['weight'] = $options[$setting]['variant'];
        $options[$setting]['style'] = 'normal';
    }

    if ( $options[$setting]['weight'] == 'regular' || $options[$setting]['weight'] == '' ) {
        $options[$setting]['weight'] = '400';
    }

    $prefix = $options[$setting]['font'];
    $options[$prefix . '_fonts'] = add_google_font( $options[$setting]['family'], $options[$setting]['weight'], $options[$prefix . '_fonts'] );

    // if ( ( isset( $options['exopite-use-google-fonts'] ) && $options['exopite-use-google-fonts'] ) || ! isset( $options['exopite-use-google-fonts'] ) ) {
    //     $options['google_fonts'] = add_google_font( $options[$setting]['family'], $options[$setting]['weight'], $options['google_fonts'] );
    // }


    return $options;
}

/**
 * Google Fonts Downloader
 * @link https://github.com/ediamin/google-fonts-downloader/blob/master/downloader.php
 *
 * Use:
 * Open the script in your browser and copy/paste the google <link ...> code in the input box and press "Download".
 * A sample <link ...> for Open Sans is there by default.
 * -- or --
 * download_google_fonts( $link ) where $list is like http://fonts.googleapis.com/css?family=Shadows+Into+Light+Two|Ubuntu:400,500|Roboto:400,500
 */
function download_google_fonts( $link ) {

    $regex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

	// Check if there is a url in the text
	if( preg_match( $regex_url, $link, $url ) ) {

        $css_dir = get_template_directory() . '/css';
        $font_dir = get_template_directory() . "/fonts/google_fonts";
		$css_file = $css_dir . '/google-fonts.css';

        $google_css = $url[0];

		$google_css = rtrim( $google_css, "'" );
		$ch = curl_init();
        $fp = fopen ( $css_file, 'w+' );
		$ch = curl_init( $google_css );
        /**
         * Set User-Agent to get woff files instead of ttf
         * @link http://php.net/manual/en/function.curl-setopt.php
         * @link https://stackoverflow.com/questions/17801094/php-curl-how-to-add-the-user-agent-value-or-overcome-the-servers-blocking-curl-r/17801135#17801135
         */
        $agent = 'Mozilla/60.0 (compatible; MSIE 11.0; Windows NT 10; SV1)';
        curl_setopt( $ch, CURLOPT_USERAGENT, $agent );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 50 );
        curl_setopt( $ch, CURLOPT_FILE, $fp );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_exec( $ch );
		curl_close( $ch );
        fclose( $fp );

    	// get the download css content
        $css_file_contents = file_get_contents( $css_file );
        if ( preg_match_all( $regex_url, $css_file_contents, $fonts ) ) {
			$fonts = $fonts[0];

            // Get files list
            $font_files = array();
            foreach ( $fonts as $i => $font ) {
				$font = rtrim( $font, ")" );
				$font_file = explode( "/", $font );
                $font_file = array_pop( $font_file );
                $font_files[$font] = $font_file;
            }

            // DEBUG
            // file_put_contents( get_stylesheet_directory() . '/font.log', date('Y-m-d H:i:s') . ' - FONTFILE: ' . var_export( $font_files, true ) . PHP_EOL, FILE_APPEND );

            if ( ! file_exists( $font_dir ) ) mkdir( $font_dir );

            // Delete file(s) which not in css file
            foreach( glob("$font_dir/*") as $file ) {
                if( ! in_array( basename($file), $font_files, true ) ) unlink($file);
            }

            foreach ( $font_files as $font => $font_file ) {

                // Do not download if exist
                if ( ! file_exists( $font_dir . '/' . $font_file ) ) {
                    // download font
                    $ch = curl_init();
                    $fp = fopen ( $font_dir . "/{$font_file}", 'w+' );
                    $ch = curl_init( $font );
                    curl_setopt( $ch, CURLOPT_TIMEOUT, 50 );
                    curl_setopt( $ch, CURLOPT_FILE, $fp );
                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
                    curl_exec( $ch );
                    curl_close( $ch );
                    fclose( $fp );
                }

                // replace string
				$css_file_contents = str_replace( $font, get_template_directory_uri() . "/fonts/google_fonts/{$font_file}", $css_file_contents );
			}
			$fh = fopen ( $css_file, 'w+' );
			fwrite( $fh, $css_file_contents );
			fclose( $fh );

        }
	}
}

if ( ! function_exists( 'on_save_options' ) ) {
    function on_save_options( $options ) {

        $options['exopite-theme-version'] = EXOPITE_VERSION;
        $options['theme-uri'] = TEMPLATEURI;
        $options['theme-prefix'] = get_template();

        $menu_top = ( $options['exopite-menu-alignment'] == 'top' || $options['exopite-menu-alignment'] == 'overlay' );
        $woocomerce_activated = ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );

        $options['exopite-desktop-width'] = $options['exopite-mobile-width'] + 1;

        /*
         * Generate css rules
         */
        // Body background
        $options = css_generate_background( 'exopite-body-backgorund', $options );
        // Prehader background
        $options = css_generate_background( 'exopite-sidebar-preheader-backgorund', $options );
        // Content background
        $options = css_generate_background( 'exopite-content-backgorund', $options );
        // Menu background
        $options = css_generate_background( 'exopite-desktop-menu-backgorund', $options );
        // Footer background
        $options = css_generate_background( 'exopite-footer-background', $options );
        // Footer background
        $options = css_generate_background( 'exopite-hero-header-show-menu-below-backgorund', $options );

        $options = css_generate_rgb( 'exopite-font-content-alternative', $options );
        $options = css_generate_rgb( 'exopite-font-content-link', $options );

        // Menu font
        $options['google_fonts'] = array();
        $options = css_generate_font( 'menu-font', $options );
        $options = css_generate_font( 'exopite-font-content', $options );
        $options = css_generate_font( 'exopite-font-footer', $options );
        $options = css_generate_font( 'exopite-font-copyright', $options );
        $options = css_generate_font( 'exopite-font-h1', $options );

        //exopite-enable-desktop-menu-toggle
        if ( ! $menu_top ) {
            if ( $options['exopite-enable-desktop-menu-toggle'] ) {
                $options['exopite-enable-desktop-menu-toggle-display-css'] = 'block';
            } else {
                $options['exopite-enable-desktop-menu-toggle-display-css'] = 'none';
            }
        }

        /*
         * Add required style files
         */
        $required_files = array(
            'bootstrap-custom.css',
            'flex.css',
            'basic.css',
            'typography.css',
            'sidebar.css',
            'blog.css',
            'blog.sticky.css',
            'comments.css',
        );

        //exopite-seo-use_cdns
        if ( isset( $options['exopite-seo-use_cdns'] ) && ! $options['exopite-seo-use_cdns'] ) {
            array_unshift( $required_files, 'font-awesome.4.7.0.min.css', 'bootstrap.4.1.1.min.css' );
        }

        // Download Google Fonts
        if ( isset( $options['exopite-download-google-fonts'] ) && $options['exopite-download-google-fonts'] ) {
            $google_fonts = get_google_fonts();
            download_google_fonts( 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://fonts.googleapis.com/css?family=' . $google_fonts['regular'] );
            array_unshift( $required_files, 'google-fonts.css' );
        }

        /*
         * Additional style files based on settings
         */
        $css_files = array(
            'blog.card.css',
            'blog.comments.css',
            'blog.meta.css',
            'blog.multi-column.css',
            'blog.post.categories-tags.css',
            'blog.thumbnail.css',
            'breadcrumbs.css',
            'copyright.css',
            'footer.css',
            'post.author.css',
            'post.navigation.css',
            'post.releated.css',
            'search-full.css',
            'sidebar.css',
            'social.css',
        );

        $css_files[] = 'effect.' . $options['exopite-image-hover-effect'] . '.css';

        $options['exopite-font-content-link-underline-css'] = 'text-decoration: ';
        $options['exopite-font-content-link-underline-css'] .= ( $options['exopite-font-content-link-underline'] ) ? 'underline;' : 'none;';
        $options['exopite-font-content-link-hover-underline-css'] = 'text-decoration: ';
        $options['exopite-font-content-link-hover-underline-css'] .= ( $options['exopite-font-content-link-hover-underline'] ) ? 'underline;' : 'none;';


        if ( $menu_top ) {
            $css_files[] = 'menu.top.css';
            $css_files[] = 'menu.mobile.css';

        } elseif ( $options['exopite-menu-alignment'] == 'left' ) {
            $css_files[] = 'menu.side-left.css';
            $css_files[] = 'footer.menu-left.css';
        }

        if ( $options['exopite-menu-alignment'] == 'overlay' ) {
            $css_files[] = 'menu.top.overlay.css';
        }

        if ( $menu_top && $options['exopite-desktop-logo-position'] == 'center') {
            $css_files[] = 'menu.top.logo.center.css';
        }

        if ( $options['exopite-blog-multi-column-layout-type'] == 'column' ) {
            $css_files[] = 'blog.card.css';
        }

        if ( $menu_top && $options['exopite-floation-menu-enabled'] ) {
            $css_files[] = 'menu.floating.css';
        }

        if ( $menu_top && ! $options['exopite-floating-menu-logo'] ) {
            $css_files[] = 'menu.floating.logo.css';
        }

        if ( $options['exopite-sidebar-footer-enable-slide-up'] ) {
            if ( $options['exopite-content-layout'] == 'wide' ) {
                $css_files[] = 'footer.fixed.css';
                if ( ! $menu_top ) {
                    $css_files[] = 'footer.menu-left.fixed.css';
                }
                if ( ! $options['exopite-sidebar-footer-enable-slide-up-mobile'] ) {
                    $css_files[] = 'footer.mobile.fixed.css';
                }
            }
        }

        if ( $options['exopite-seo-mark-external-links'] ) {
            $css_files[] = 'seo.nofollow.css';
        }

        if ( $options['exopite-blog-multi-column-layout-type'] == 'normal' && $options['exopite-blog-post-per-row'] > '1' && $options['exopite-blog-same-height'] ) {
            $css_files[] = 'blog.multi-column.equal-height.css';
        }

        if (  $options['exopite-content-layout'] == 'wide' ) {
            $css_files[] = 'layout.wide.css';
            $css_files[] = 'footer.wide.css';
        }

        if ( $menu_top && $options['exopite-content-layout'] == 'wide' ) {
            $css_files[] = 'menu.top.wide.css';
            if ( $options['exopite-floation-menu-enabled'] ) {
                $css_files[] = 'menu.floating.wide.css';
            }
        } elseif ( $options['exopite-content-layout'] == 'boxed' ) {
            $css_files[] = 'layout.boxed.css';
            $css_files[] = 'footer.boxed.css';

            if ( $menu_top ) {
                $css_files[] = 'layout.menu-top.boxed.css';
                $css_files[] = 'menu.top.boxed.css';
                if ( $options['exopite-floation-menu-enabled'] ) {
                    $css_files[] = 'menu.floating.boxed.css';
                }
            } else {
                $css_files[] = 'layout.menu-left.boxed.css';
            }

        }

        if ( $options['exopite-enable-hero-header'] == true ) {
            $css_files[] = 'hero-header.css';

            if ( $options['exopite-enable-hero-header-fixed'] == true ) {
                $options['exopite-enable-hero-header-fixed-css'] = 'fixed';
            } else {
                $options['exopite-enable-hero-header-fixed-css'] = 'relative';
            }

            if ( $options['exopite-enable-hero-header-show-menu-below'] ) {
                $css_files[] = 'hero-header-show-menu-below.css';
            }

        }

        if ( $woocomerce_activated ) {

            $css_files[] = 'woocommerce.css';
        }

        /*
         * Add required script files
         */
        $js_files = array(
            'jquery.validate-comment.js',
        );

        //exopite-seo-use_cdns
        if ( isset( $options['exopite-seo-use_cdns'] ) && ! $options['exopite-seo-use_cdns'] ) {
            $js_files[] = 'popper.1.14.3.min.js';
            $js_files[] = 'bootstrap.4.1.1.min.js';
        }

        $js_files_no_minification = array();

        if ( $menu_top ) {
            $js_files[] = 'jquery.slimmenu.js';
        }

        if ( $menu_top && $options['exopite-floation-menu-enabled'] ) {
            $js_files[] = 'jquery.sticky-anything.js';
            $js_files[] = 'jquery.sticky-anything.load.js';
            if ( ! $options['exopite-mobile-menu-floation-enabled'] ) {
                $options['exopite-floation-menu-minscreenwidth'] = 'minscreenwidth: ' . ( $options['exopite-mobile-width'] + 1 ) . ',';
            }
        }

        $js_files[] = 'document-ready.open.js';

        if ( $options['exopite-blog-post-per-row'] > 1 &&
             $options['exopite-blog-multi-column-layout-type'] == 'masonry' ) {
            $js_files_no_minification[] = 'macy.min.js';
            $js_files[] = 'macy.load.js';
        }

        $js_files[] = 'exopite.js';

        if ( $menu_top ) {
            $js_files[] = 'jquery.detect-menu-off-screen.js';
        }

        if ( $options['exopite-enable-hero-header'] ) {
            $js_files[] = 'hero-header.js';

            if ( $options['exopite-enable-hero-header-parallax'] && $options['exopite-enable-hero-header-fixed']  ) {
                $js_files[] = 'parallax.js';
            }

            if ( $menu_top && $options['exopite-enable-hero-header-show-menu-below'] ) {
                $js_files[] = 'hero-header-show-menu-below.js';
            }

        }

        if ( $options['exopite-sidebar-footer-enable-slide-up'] ) {
            $js_files[] = 'fixed-footer.js';
        }

        if ( $options['exopite-load-google-fonts-async'] && ! ( isset( $options['exopite-download-google-fonts'] ) && $options['exopite-download-google-fonts'] ) ) {
            $js_files[] = 'google-font-async.js';
        }

        if ( ! $menu_top ) {
            $js_files[] = 'menu.side-left.toggle.js';
        }

        if ( $options['exopite-menu-alignment'] == 'overlay' ) {
            $js_files[] = 'menu.overlay.js';
        }

        if ( $woocomerce_activated ) {
            $js_files[] = 'woocommerce.js';
        }

        $js_files[] = 'document-ready.close.js';

        $css_files = apply_filters( 'exopite-css-files-before-combine-minify', $css_files );
        $js_files = apply_filters( 'exopite-js-files-before-combine-minify', $js_files );

        $css_files = array_merge( $required_files, $css_files );

        // Load minify and combine class and generate css and js output
        require_once join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, 'include', 'minify-combine.class.php' ) );
        $generate = new Exopite_Minify_Combine();
        $generate->css_files = $css_files;
        $generate->js_files = $js_files;
        $generate->js_files_no_minification = $js_files_no_minification;
        $generate->options = $options;
        $generate->user_css = ( isset( $options['exopite-css'] ) ) ? $options['exopite-css'] : '';
        $generate->user_js = ( isset( $options['exopite-js'] ) ) ? $options['exopite-js'] . $options['exopite-js-analytics'] : '';
        //$generate->user_js = ( isset( $options['exopite-js'] ) ) ? $options['exopite-js'] : '';
        $generate->generate_css();
        $generate->combine_js();

        return $options;

    }
}
