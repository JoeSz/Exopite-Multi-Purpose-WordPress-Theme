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
 *  - exopite_set_image_meta_upon_image_upload (pluggable)
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

            $divider = ' '. apply_filters( 'exopite-breadcrumbs-divider', '<span class="divider">&#187;</span>' ) . ' ';
            $home =  esc_attr__( 'Home', 'exopite' );
            $breadcrumb = '<div class="exopite-breadcrumbs">' . apply_filters( 'exopite-breadcrumbs-before', '' );

            if ( ExopiteSettings::getValue( 'woocommerce-activated' ) ) {
                $shop_page_id = wc_get_page_id( 'shop' );
                $woocommerce_shop_title   = get_the_title( $shop_page_id );
            }

            if ( ! is_front_page() ) {

                $breadcrumb .= '<a href="' . get_option('home') .'">' . apply_filters( 'exopite-breadcrumbs-home-name', $home ) . '</a>' . $divider;

                if ( is_category() || ( is_single() && "post" == get_post_type() ) ) {

                    $categories = get_the_category();
                    $last_category = key( array_slice( $categories, -1, 1, TRUE ) );
                    $category_divider = apply_filters( 'exopite-breadcrumbs-category-divider', '&' ) . ' ';

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

                }  elseif ( is_single() && ( 'post' != get_post_type() && 'page' != get_post_type() ) ) {

                    $obj = get_post_type_object( get_post_type() );
                    $cpt_archive = get_post_type_archive_link( $obj->name );
                    $breadcrumb .= ( empty( $cpt_archive ) ) ? $obj->labels->singular_name : '<a href="' . $obj->slug . '">' . $obj->labels->singular_name . '</a>';
                    $breadcrumb .= $divider;
                    $breadcrumb .= get_the_title();

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

            $breadcrumb .=  apply_filters( 'exopite-breadcrumbs-after', '' ) . '</div>';

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

    if ( ! function_exists( 'yoast_breadcrumb' ) ) add_action( 'wp_head', 'exopite_generate_meta', 1 );
    if ( ! function_exists( 'exopite_generate_meta' ) ) {

        function exopite_generate_meta() {
            global $post;

            if ( ! isset( $post ) ) return;

            $exopite_meta_data_type = 'exopite_custom_post_options';
            if ( is_page() ) {
                $exopite_meta_data_type = 'exopite_custom_page_options';
            }
            $exopite_meta_data = get_post_meta( get_queried_object_ID(), $exopite_meta_data_type, true );

            $exopite_meta_allow_follow = isset( $exopite_meta_data['exopite-meta-seo-allow-follow'] ) ? $exopite_meta_data['exopite-meta-seo-allow-follow'] : true;
            $exopite_meta_allow_index = isset( $exopite_meta_data['exopite-meta-seo-allow-index'] ) ? $exopite_meta_data['exopite-meta-seo-allow-index'] : true;
            $exopite_meta_description = isset( $exopite_meta_data['exopite-meta-description'] ) ? $exopite_meta_data['exopite-meta-description'] : '';
            $exopite_meta_keywords = isset( $exopite_meta_data['exopite-meta-keywords'] ) ? $exopite_meta_data['exopite-meta-keywords'] : '';

            $exopite_meta_allow_follow = apply_filters( 'exopite-meta-no-follow', esc_attr( $exopite_meta_allow_follow ) );
            $exopite_meta_allow_index = apply_filters( 'exopite-meta-no-index', esc_attr( $exopite_meta_allow_index ) );
            $exopite_meta_description = apply_filters( 'exopite-meta-description', esc_attr( $exopite_meta_description ) );
            $exopite_meta_keywords = apply_filters( 'exopite-meta-keywords', esc_attr( $exopite_meta_keywords ) );

            if ( empty( $exopite_meta_description ) ) {
                // Get user defined excerpt if exist or the post content.
                $exopite_meta_description = ( empty( $post->post_excerpt ) ) ? $post->post_content : $post->post_excerpt;
            }

            // Trim on end of the sentence or comma after the limit.
            $exopite_meta_description = get_custom_excerpt( $exopite_meta_description, 20, false, false, '...', true );
            $exopite_meta_description = strip_shortcodes( $exopite_meta_description );

            // Get post thumbnail if exist or site logo.
            $img_src = get_featured_image( $post->ID );

            if ( ! $img_src ) {

                $exopite_settings = get_option( 'exopite_options' );

                $img_src = ( isset( $exopite_settings['exopite-desktop-logo'] ) ) ?
                    wp_get_attachment_image_src( $exopite_settings['exopite-desktop-logo'], 'full' )[0] :
                    '';

            }

            $img_src = esc_attr( $img_src );

            if ( ! $exopite_meta_allow_follow || ! $exopite_meta_allow_index ) {

                $exopite_robots_rules = array();
                $exopite_robots_rules[] = ( ! $exopite_meta_allow_follow ) ? 'nofollow' : '';
                $exopite_robots_rules[] = ( ! $exopite_meta_allow_index ) ? 'noindex' : '';

                $exopite_robots_rules = implode( ',', $exopite_robots_rules );
                $exopite_robots_rules = trim( $exopite_robots_rules,',' );

                if ( ! empty( $exopite_robots_rules ) ) {
                    echo '<meta name="robots" content="' . $exopite_robots_rules . '">';
                }

            }

            $user_meta = get_user_meta( get_the_author_meta( 'ID' , $post->post_author ) );

            ?><!-- Exopite SEO - This site is optimized with Exopite Theme - https://www.joeszalai.org/exopite/ -->
<meta name="description" content="<?php echo esc_html( $exopite_meta_description ); ?>" />
<?php if ( ! empty( $exopite_meta_keywords ) ) : ?>
<meta name="keywords" content="<?php echo esc_html( $exopite_meta_keywords ); ?>">
<?php endif; ?>
<!-- Facebook (and some others) use the Open Graph protocol: see http://ogp.me/ for details -->
<meta property="og:title" content="<?php echo esc_html( get_the_title() . ' - ' .get_bloginfo( 'name' ) ); ?>"/>
<meta property="og:description" content="<?php echo esc_html( $exopite_meta_description ); ?>"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php esc_url( the_permalink() ); ?>"/>
<meta property="og:site_name" content="<?php echo esc_html( get_bloginfo() ); ?>"/>
<meta property="og:image" content="<?php echo esc_url( $img_src ); ?>"/>
<meta property="og:locale" content="<?php echo get_locale() ?>" />
<meta property="og:updated_time" content="<?php echo get_the_modified_time( 'c' ); ?>" />
<?php if( ! empty( esc_url( $user_meta['facebook'][0] ) ) ) : ?>
<meta property="article:author" content="<?php echo esc_url( $user_meta['facebook'][0] ); ?>" />
<?php endif; ?>
<meta property="article:section" content="<?php echo strip_tags( get_the_category_list(',') ); ?>" />
<meta property="article:published_time" content="<?php echo get_the_time( 'c' ); ?>" />
<meta property="article:modified_time" content="<?php echo get_the_modified_time( 'c' ); ?>" />
<!-- Twitter: see https://dev.twitter.com/docs/cards/types/summary-card for details -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?php echo esc_html( $exopite_meta_description ); ?>" />
<meta name="twitter:title" content="<?php echo esc_html( get_the_title() . ' - ' .get_bloginfo( 'name' ) ); ?>" />
<meta name="twitter:image" content="<?php echo esc_url( $img_src ); ?>" />
<meta name="twitter:site" content="<?php echo esc_html( get_bloginfo() ); ?>">
<meta name="twitter:url" content="<?php esc_url( the_permalink() ); ?>">
<?php if( ! empty( esc_url( $user_meta['twitter'][0] ) ) ) : ?>
<meta name="twitter:creator" content="@<?php
    $twitter = explode('/', esc_url( $user_meta['twitter'][0] ) );
    $id = array_pop( $twitter ); // 123
    echo esc_html( $id );
?>" />
<?php endif; ?>
<!-- /Exopite SEO. -->
<?php

        }
    }
}

/**
 * Add noindex on archives and search
 */
if ( ! function_exists( 'yoast_breadcrumb' ) ) add_action( 'wp_head', 'exopite_add_noindex' );
if ( ! function_exists( 'exopite_add_noindex' ) ) {
    function exopite_add_noindex() {

        $exopite_settings = get_option( 'exopite_options' );

        if( ( is_author() || is_date() || is_search() || is_category() || is_tag()  || is_404() ) && $exopite_settings['exopite-noidex-archives-enabled'] ) {

            echo '<meta name="robots" content="noindex,follow" />';

        }

    }
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @link https://wordpress.stackexchange.com/questions/228183/custom-attribute-for-the-title-tag-with-wp-title/228225#228225
 */
if (has_action('wp_head','_wp_render_title_tag') == 1) {
    remove_action('wp_head','_wp_render_title_tag',1);
    add_action('wp_head','custom_wp_render_title_tag_filtered',1);
}

function custom_wp_render_title_tag_filtered() {
    if ( function_exists( '_wp_render_title_tag' ) ) {
        ob_start();
        _wp_render_title_tag();
        $titletag = ob_get_contents();
        ob_end_clean();
    } else {
        $titletag = '';
    }
    echo apply_filters('wp_render_title_tag_filter',$titletag);
}

add_filter('wp_render_title_tag_filter','custom_wp_render_title_tag');
function custom_wp_render_title_tag($titletag) {
    $titletag = str_replace( '<title>', '<title itemprop="name">', $titletag );
    return $titletag;
}

/*
 * Automatically Set the WordPress Image Title, Alt-Text & Other Meta
 *
 * @link https://brutalbusiness.com/automatically-set-the-wordpress-image-title-alt-text-other-meta/
 */
add_action( 'add_attachment', 'exopite_set_image_meta_upon_image_upload' );
if ( ! function_exists( 'exopite_set_image_meta_upon_image_upload' ) ) {

    function exopite_set_image_meta_upon_image_upload( $post_ID ) {

        // Check if uploaded file is an image, else do nothing

        if ( wp_attachment_is_image( $post_ID ) ) {

            $my_image_title = get_post( $post_ID )->post_title;

            // Sanitize the title:  remove hyphens, underscores & extra spaces:
            $my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );

            // Sanitize the title:  capitalize first letter of every word (other letters lower case):
            $my_image_title = ucwords( strtolower( $my_image_title ) );

            // Create an array with the image meta (Title, Caption, Description) to be updated
            // Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
            $my_image_meta = array(
                'ID'        => $post_ID,            // Specify the image (ID) to be updated
                'post_title'    => $my_image_title,     // Set image Title to sanitized title
                'post_excerpt'  => $my_image_title,     // Set image Caption (Excerpt) to sanitized title
                'post_content'  => $my_image_title,     // Set image Description (Content) to sanitized title
            );

            // Set the image Alt-Text
            update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

            // Set the image meta (e.g. Title, Excerpt, Content)
            wp_update_post( $my_image_meta );

        }
    }

}
