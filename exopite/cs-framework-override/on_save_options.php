<?php
/**
 * On save in CodeStar Options generate style.css and scripts.js form
 * css and js files based on settings.
 * In this way, css and js file size can be reduces for less data and more speed.
 */

if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

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

    $options['google_fonts'] = add_google_font( $options[$setting]['family'], $options[$setting]['weight'], $options['google_fonts'] );

    return $options;
}

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

// Generate Google font families to include
function add_google_font( $family, $weight, $google_fonts ) {
    if( ! array_key_exists( $family, $google_fonts ) || ! in_array( $weight, $google_fonts[$family] ) ) {
        $google_fonts[$family][] = ( $weight == 'regular' ) ? '400' : $weight;
    }
    return $google_fonts;
}

if ( ! function_exists( 'on_save_options' ) ) {
    function on_save_options( $options ) {

        $options['exopite-theme-version'] = EXOPITE_VERSION;
        $options['theme-uri'] = TEMPLATEURI;
        $options['theme-prefix'] = get_template();

        $menu_top = ( $options['exopite-menu-alignment'] == 'top' );
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

        // Menu font
        $options['google_fonts'] = array();
        $options = css_generate_font( 'menu-font', $options );
        $options = css_generate_font( 'exopite-font-content', $options );
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
            'fonts.css',
            'basic.css',
            'typography.css',
            'sidebar.css',
            'blog.css',
            'blog.sticky.css',
            'comments.css',
        );

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

        if ( $menu_top ) {
            $css_files[] = 'menu.top.css';
            $css_files[] = 'menu.mobile.css';

        } elseif ( $options['exopite-menu-alignment'] == 'left' ) {
            $css_files[] = 'menu.side-left.css';
            $css_files[] = 'footer.menu-left.css';
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
             $options['exopite-blog-multi-column-layout-type'] == 'masonry' &&
             $options['exopite-infiniteload-add-page-number'] == false ) {
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

        if ( $options['exopite-load-google-fonts-async'] ) {
            $js_files[] = 'google-font-async.js';
        }

        if ( ! $menu_top ) {
            $js_files[] = 'menu.side-left.toggle.js';
        }

        if ( $woocomerce_activated ) {
            $js_files[] = 'woocommerce.js';
        }

        $js_files[] = 'document-ready.close.js';

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
        $generate->generate_css();
        $generate->combine_js();

        return $options;

    }
}

