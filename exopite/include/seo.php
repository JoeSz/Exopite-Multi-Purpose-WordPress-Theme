<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Exopite
 *
 * Functions:
 *  - exopite_breadcrumb (pluggable)
 *  - exopite_generate_meta (pluggable)
 *  - exopite_add_noindex (pluggable)
 *
 */

/**
 * Display breadcrumbs without a plugin or Yoast SEO breadcrumbs if it is activated
 *
 * @link http://leejacksondev.com/adding-breadcrumbs-to-your-wordpress-theme-no-plugin-required/
 */
add_action( 'exopite_hooks_content_container_top', 'exopite_display_breadcrumbs', 15 );
if ( ! function_exists( 'exopite_display_breadcrumbs' ) ) {
    function exopite_display_breadcrumbs() {

        $exopite_settings = get_option( 'exopite_options' );

        if ( ! is_single() && ! $exopite_settings['exopite-blog-display-breadcrumbs'] ) return; // Blog
        if ( is_single() && ! $exopite_settings['exopite-single-display-breadcumbs'] ) return; // Post
        if ( is_page() && ! $exopite_settings['exopite-page-display-breadcrumbs'] ) return; // Page
        if ( ! ExopiteSettings::getValue( 'exopite-meta-enable-breadcrumbs' ) ) return;

        echo exopite_breadcrumbs();

    }
}

// Display breadcrumbs
if ( ! function_exists( 'exopite_breadcrumbs' ) ) {
    function exopite_breadcrumbs() {

        if ( function_exists( 'yoast_breadcrumb' ) ) {

            // If Yoast SEO exist and breadcrumbs is activated, use they breadcrumbs function for more flexibility
            yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' );

        } else {

            $divider = ' <span class="divider">&#187;</span> ';
            $home =  esc_attr__( 'Home', 'exopite' );
            $breadcrumb .= '<div class="exopite-breadcrumbs">';

            if ( ExopiteSettings::getValue( 'woocommerce-activated' ) ) {
                $shop_page_id = wc_get_page_id( 'shop' );
                $woocommerce_shop_title   = get_the_title( $shop_page_id );
            }

            if ( ! is_front_page() ) {

                $breadcrumb .= '<a href="' . get_option('home') .'">' . $home . '</a>' . $divider;

                if ( is_category() || is_single() ) {

                    $categories = get_the_category();
                    $last_category = key( array_slice( $categories, -1, 1, TRUE ) );
                    $category_divider = '& ';

                    // Category parents
                    if( is_category() ) {
                        $category_id = get_query_var('cat');
                    } else {
                        $category_id = $categories[0]->cat_ID;
                    }

                    $category_parents = explode( ';', rtrim( get_category_parents( $category_id, true, ';' ),';' ) );

                    $i = 0;
                    $len = count( $category_parents );

                    foreach( $category_parents as $category_parent ) {

                        if ( $i == $len - 1 ) {

                            if ( is_category() ) {

                                $breadcrumb .= strip_tags( $category_parent );

                            } else {

                                $breadcrumb .= $category_parent;

                            }

                        } else {

                            $breadcrumb .= $category_parent . $divider;

                        }

                        $i++;

                    }

                    if ( ExopiteSettings::getValue( 'woocommerce-activated' ) && is_product() ) {
                        $breadcrumb .= '<a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . $woocommerce_shop_title . '</a>';
                    }

                    if ( empty( $categories ) && ( ExopiteSettings::getValue( 'woocommerce-activated' ) && ! is_product() ) ) {

                        $post_type = get_post_type_object( get_post_type() );

                        if ( $post_type->has_archive ) {

                            $breadcrumb .= '<a href="' . get_site_url() . '/' . $post_type->rewrite['slug'] . '/">' . $post_type->labels->name . '</a>';

                        } else {

                            $breadcrumb .= $post_type->labels->name;

                        }

                    }
                    if ( is_single() ) {

                        $breadcrumb .= $divider;
                        $breadcrumb .= get_the_title();

                    }

                }  elseif ( is_tag() ) {

                    $breadcrumb .= single_tag_title( '', false );

                } elseif ( is_day() || is_month() || is_year() ) {

                    $breadcrumb .= esc_attr__( 'Archive for ', 'exopite' );

                    if ( is_day() ) {

                        $breadcrumb .= get_the_time('F jS, Y');

                    } elseif ( is_month() ) {

                        $breadcrumb .= get_the_time('F, Y');

                    } elseif ( is_year() ) {

                        $breadcrumb .= get_the_time('Y');

                    }

                } elseif ( is_author() ) {

                    $author = get_userdata( get_query_var('author') );
                    $breadcrumb .= esc_attr__( 'Author ', 'exopite' ) . $author->display_name;

                } elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {

                    $breadcrumb .= esc_attr__( 'Blog Archives', 'exopite' );

                } elseif ( is_search() ) {

                    $breadcrumb .= esc_attr__( 'Search results for ', 'exopite' ) . get_search_query();

                } elseif ( ExopiteSettings::getValue( 'woocommerce-activated' ) && is_shop() ) {

                    $breadcrumb .= $woocommerce_shop_title;

                } elseif ( is_tax() ) {


                    if ( ExopiteSettings::getValue( 'woocommerce-activated' ) ) {

                        $breadcrumb .= '<a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . $woocommerce_shop_title . '</a>' . $divider;
                    }

                    $breadcrumb .= single_term_title( '', false );

                } elseif ( is_home() ) {

                    $breadcrumb .= get_the_title( get_option('page_for_posts', true) );

                } else {

                    // e.g. Page
                    $post_parents_id = array_reverse( get_post_ancestors( get_the_ID() ) );

                    foreach ( $post_parents_id as $post_parent_id ) {

                        $breadcrumb .= '<a href="' . get_permalink( $post_parent_id ) . '">' . get_the_title( $post_parent_id ) . '</a>' . $divider;

                    }

                    if ( ExopiteSettings::getValue( 'woocommerce-activated' ) && is_cart() ) {

                        $breadcrumb .= '<a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . $woocommerce_shop_title . '</a>' . $divider;

                    }

                    $breadcrumb .= get_the_title();

                }

            } else {

                $breadcrumb .= $home;
            }

            $breadcrumb .= '</div>';

        }

        return $breadcrumb;
    }
}

/**
 * Dynamically create description for the page. On Yoast SEO install, disable it
 *
 * @link http://www.wprecipes.com/how-to-automatically-create-meta-description-from-content
 * @link https://www.elegantthemes.com/blog/tips-tricks/how-to-add-open-graph-tags-to-wordpress
 */
if ( ! defined('WPSEO_VERSION') ) {

    add_action('wp_head', 'exopite_generate_meta', 1);
    if ( ! function_exists( 'exopite_generate_meta' ) ) {

        function exopite_generate_meta() {
            global $post;

            if ( ! isset( $post ) ) return;

            // Get user defined excerpt if exist or the post content.
            $meta = ( empty( $post->post_excerpt ) ) ? $post->post_content : $meta = $post->post_excerpt;

            //$meta = strip_shortcodes( $meta );

            // Trim on end of the sentence or comma after the limit.
            $meta = get_custom_excerpt( $meta, 20, false, false, '', true );

            // Get post thumbnail if exist or site logo.
            $img_src = get_featured_image( $post->ID );

            if ( ! $img_src ) {

                $exopite_settings = get_option( 'exopite_options' );

                $img_src = ( isset( $exopite_settings['exopite-desktop-logo'] ) ) ?
                    wp_get_attachment_image_src( $exopite_settings['exopite-desktop-logo'], 'full' )[0] :
                    '';

            }

            $img_src = esc_attr( $img_src );

            ?>
<meta name="description" content="<?php echo $meta; ?>" />
<!-- Facebook (and some others) use the Open Graph protocol: see http://ogp.me/ for details -->
<meta property="og:title" content="<?php the_title(); ?>"/>
<meta property="og:description" content="<?php echo esc_html( $meta ); ?>"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php esc_url( the_permalink() ); ?>"/>
<meta property="og:site_name" content="<?php echo esc_html( get_bloginfo() ); ?>"/>
<meta property="og:image" content="<?php echo esc_url( $img_src ); ?>"/>
<meta property="og:locale" content="<?php echo get_locale() ?>" />
<!-- Twitter: see https://dev.twitter.com/docs/cards/types/summary-card for details -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?php echo $meta; ?>" />
<meta name="twitter:title" content="<?php the_title(); ?>" />
<meta name="twitter:image" content="<?php echo esc_url( $img_src ); ?>" />
<meta name="twitter:site" content="<?php echo esc_html( get_bloginfo() ); ?>">
<meta name="twitter:url" content="<?php esc_url( the_permalink() ); ?>"><?php

        }
    }
}

/**
 * Add noidex on archives and search
 */
add_action( 'wp_head', 'exopite_add_noindex' );
if ( ! function_exists( 'exopite_add_noindex' ) ) {
    function exopite_add_noindex() {

        $exopite_settings = get_option( 'exopite_options' );

        if( ( is_author() || is_date() || is_search() || is_category() || is_tag() ) && $exopite_settings['exopite-noidex-archives-enabled'] ) {

            echo '<meta name="robots" content="noindex,follow" />';

        }

    }
}


