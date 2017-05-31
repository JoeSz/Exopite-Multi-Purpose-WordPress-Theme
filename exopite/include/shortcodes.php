<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * ToDo:
 * - test shortcodes
 */

/**
 * Add your shortcodes here
 *
 * @package Exopite
 *
 * Shortcodes:
 *  - Insert an image with hover effect                         [exopite-image-effect]
 *  - Display file                                              [exopite-loop]
 *  - Display loop                                              [exopite-display-file]
 *  - Display page content                                      [exopite-display-page-content slug="slug"]
 *  - Display sidebar						                    [exopite-display-sidebar]
 *  - Display any widget                                        [exopite-display-widget]
 *  - Include any PHP file                                      [exopite-include]
 *  - Shortcode menu 						                    [exopite-shortcode-menu]
 *  - Social menu 							                    [exopite-social-menu]
 *  - Display WooCommerce cart 				                    [exopite-woocommerce-cart]
 *  - Display Exopite or Yoast SEO Breadcrumbs if activated		[exopite-breadcrumbs]
 */

/*
 * Insert an image with hover effect
 * [exopite-image-effect image="image.ext"]
 */
add_shortcode( 'exopite-image-effect', 'exopite_image_effect' );
if ( ! function_exists( 'exopite_image_effect' ) ) {
    function exopite_image_effect( $args ) {
        $args = shortcode_atts(
            array(
                'image'   => '',
                'caption' => '',
                'class' => '',
                'style' => '',
                'effect' => 'effect-thumbnail',
                'link' => '',
                'alt' => '',
            ),
            $args
        );

        $ret = '';

        $image = esc_url( $args['image'] );
        $link = esc_url( $args['link'] );
        $caption = sanitize_text_field( $args['caption'] );
        $class = sanitize_text_field( $args['class'] );
        $effect = sanitize_text_field( $args['effect'] );
        $alt = sanitize_text_field( $args['alt'] );
        $style = wp_kses( $args['style'], array( 'style' => array() ) );


        if ( ! empty( $image ) ) {

            if ( ! empty( $link ) ) {
                $ret .= '<a href="' . $link . '">';
            }

            $ret .=  exopite_create_effect_image_frame( $image, $caption, $class, $style, $effect, $alt );

            if ( ! empty( $link ) ) {
                $ret .= '</a>';
            }

            return $ret;
        }

    }
}

/**
 * Display the exopite loop
 * [exopite-loop]
 */
add_shortcode( 'exopite-loop', 'loop' );
function loop( $args ) {

    // query_args: http://www.billerickson.net/code/wp_query-arguments/
    $args = shortcode_atts(array(
        'auto_paged' => true,
        'column_layout' => false,
        'gap' => false,
        'show_thumbnail' => false,
        'show_exceprt' => false,
        'custom-excerpt-more' => '',
        'blog_first_full' => true,
        'blog-layout' => 'image-left',
        'blog-post-per-row' => 1,
        'query_args' => array(
            'posts_per_page' => 3,
            'post_type' => 'post',
            'posts' => -1,
            // 'category' => '',
            // 'author' => '',
            // 'author_name' => '',
            // 'cat' => '',
            // 'category_name' => '',
            // 'category__and' => '',
            // 'category__in' => '',
            // 'category__not_in' => '',
            // 'tag' => '',
            // 'tag_id' => '',
            // 'tag__and' => '',
            // 'tag__in' => '',
            // 'tag__not_in' => '',
            // 'tag_slug__and' => '',
            // 'tag_slug__in' => '',
            // 'tax_query' => '',
            // 'p' => '',
            // 'name' => '',
            // 'page_id' => '',
            // 'pagename' => '',
            // 'pagename' => '',
            // 'post_parent' => '',
            // 'post__in' => '',
            // 'post__not_in' => '',
            // 'post_status' => '',
            // 'posts_per_archive_page' => '',
            // 'order' => '',
            // 'orderby' => '',
            // 'ignore_sticky_posts' => '',
            // 'year' => '',
            // 'monthnum' => '',
            // 'w' => '',
            // 'day' => '',
            // 'hour' => '',
            // 'meta_key' => '',
            // 'meta_value' => '',
            // 'meta_value_num' => '',
            // 'meta_compare' => '',
            // 'meta_query' => '',
            // 's' => '',
            // 'exact' => '',
            // 'sentence' => '',

        ),

    ), $args );

    include( locate_template( 'template-parts/loop.php' ) );

    return the_loop( $args );
}

/*
 * Display file from inside theme folder.
 *
 * [exopite-display-file filename="filename.ext"]
 */
add_shortcode( 'exopite-display-file', 'exopite_display_file' );
if ( ! function_exists( 'exopite_display_file' ) ) {
	function exopite_display_file( $atts ) {
		$args = shortcode_atts(
		    array(
		        'filename'   => '',
		        'error' => 'true',
		    ),
		    $atts
		);

        $filename = sanitize_text_field( $args['filename'] );
        $error = sanitize_text_field( $args['error'] );

        if ( empty( $filename ) ) return __( 'ERROR: File name can not be empty!', 'exopite' );

		if ( strtolower( sanitize_text_field( $args['error'] ) ) === 'true') {
			$error = true;
		} else {
			$error = false;
		}

        //$filename = TEMPLATEURI . '/' . $filename;
		$filename = join( DIRECTORY_SEPARATOR, array( TEMPLATEPATH, $filename ) );

        if ( ! file_exists( $filename ) ) return __( ' ERROR: File not found!', 'exopite' );

        /**
         * Initialize custom templater
         */
        if( class_exists( 'Exopite_Template' ) ) {
            Exopite_Template::$filename = $filename;
            return Exopite_Template::get_template();
        } else {
            ob_start();
            include $filename;
            return ob_get_clean();
        }

	}
}

/*
 * Display page/post content via slug
 *
 * [exopite-display-page-content page="slug"]
 */
add_shortcode( 'exopite-display-page-content', 'exopite_display_page_content' );
if ( ! function_exists( 'exopite_display_page_content' ) ) {
    function exopite_display_page_content( $atts ) {

        $args = shortcode_atts(
            array(
                'slug'   => '',
            ),
            $atts
        );

        // Get slug from attr
        $page_slug = sanitize_text_field( $args['slug'] );

        // Get page by slug
        // https://gist.github.com/davidpaulsson/9224518
        $page = get_page_by_path( $page_slug );

        // Get ID from page object
        $id = ( $page ) ? $page->ID : false;

        if ( $id ) {

            // http://wordpress.stackexchange.com/questions/20037/wp-query-by-just-the-id
            $args = array(
              'p'         => $id, // ID of a page, post, or custom type
              'post_type' => 'any'
            );

            // http://wordpress.stackexchange.com/questions/173844/apply-filtersthe-content-content-vs-do-shortcodecontent
            $q = new WP_Query( $args );

            $content = '';

            if( $q->have_posts() ) {

                while( $q->have_posts() ) {

                    $q->the_post();

                    ob_start();
                    the_content();
                    $content = ob_get_contents();
                    ob_end_clean();

                }

                wp_reset_postdata();

                return $content;
            }

        }

    }
}

// [exopite-display-sidebar id="sidebar-id"]
add_shortcode( 'exopite-display-sidebar', 'exopite_display_sidebar' );
if ( ! function_exists( 'exopite_display_sidebar' ) ) {
    function exopite_display_sidebar( $atts ) {
        $args = shortcode_atts(
            array(
                'id'   => '',
            ),
            $atts
        );

        $sidebar_id = sanitize_text_field( $args['id'] );
        if ( ! is_dynamic_sidebar( $sidebar_id ) && ! is_active_sidebar( $sidebar_id ) ) return null;

        ob_start();
        dynamic_sidebar( $sidebar_id );
        $sidebar = ob_get_contents();
        ob_end_clean();
        return $sidebar;
    }
}

/**
 * Usage:
 *  - in PHP:       <?php exopite_display_widget( array( 'name'=>'SiteOrigin_Widget_PostCarousel_Widget' ) ); ?>
 *  - as shortcode: [exopite-display-widget name='SiteOrigin_Widget_PostCarousel_Widget']
 *
 * args:
 *  - name:      (string) (required) widget registered name
 *  - setings:   (array|string) (optional) The widget's instance settings. Either an array or query-style string. See each widget below for examples.
 *  - arguments: (array|string) (optional) The widget's sidebar args. Either an array or query-style string.
 *
 * Source: http://codex.wordpress.org/Function_Reference/the_widget
 *         https://digwp.com/2010/04/call-widget-with-shortcode/
 */
add_shortcode( 'exopite-display-widget', 'exopite_display_widget' );
if ( ! function_exists('exopite_display_widget') ) {
    function exopite_display_widget( $atts ) {
        $args = shortcode_atts(
            array(
                'name' => '',
                'settings'   => '',
                'arguments' => '',
            ),
            $atts
        );

        $name = sanitize_string_or_array( $args['name'] );
        $settings = sanitize_string_or_array( $args['settings'] );
        $arguments = sanitize_string_or_array( $args['arguments'] );
        if ( $name == "" ) return null;

        /**
         * Get all registered widgets
         *
         * @link http://wordpress.stackexchange.com/questions/118684/get-a-list-of-all-widgets-registered-in-wordpress-admin-widgets-area
         */
        if (! empty ( $GLOBALS['wp_widget_factory'] ) ) {
            $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
        }
        // Check if widget exist
        if ( in_array( $name, $widgets ) ) {

            ob_start();
            the_widget( $name, $settings, $arguments );
            return ob_get_clean();

        } else {

            return null;

        }
    }
}

function sanitize_string_or_array( $input ) {
    // Source: https://wordpress.stackexchange.com/questions/24736/wordpress-sanitize-array/26464#26464
    if ( is_array ( $input ) ) {
        foreach ( $input as &$item ) {
            $item = esc_attr( $item );
        }
        unset( $item );
    } else {
        $input = esc_attr( $input );
    }
    return $input;
}

// [exopite-include slug="form"]
// [exopite-include slug="sub-folder/filename_without_extension"]
// https://wordpress.stackexchange.com/questions/49675/include-php-file-in-content-using-shortcode/215174#215174
add_shortcode('exopite-include', 'exopite_include_file');
if ( ! function_exists( 'exopite_include_file' ) ) {
    function exopite_include_file( $atts ) {
        $args = shortcode_atts( array(
            'slug' => 'NULL',
        ), $atts );

        $slug = sanitize_text_field( $args['slug'] );

        if( $slug != 'NULL' ) {
            ob_start();
            get_template_part( $slug );
            return ob_get_clean();
        }
    }
}

/**
 * Display Exopite shortcode menu. You can crate the menu in wp-admin/Appearance/Menus.
 *
 * [exopite-shortcode-menu]
 */
add_shortcode( 'exopite-shortcode-menu', 'exopite_shortcode_menu' );
if ( ! function_exists( 'exopite_shortcode_menu' ) ) {
	function exopite_shortcode_menu( $atts ) {
		$args = shortcode_atts(
		    array(
		        'image_url' => '',
		    ),
		    $atts
		);

		// If herader image set then two column, otherwise only one
		$has_image = false;
		// Get logo
		$image_url = esc_url( $args['image_url'] );

		if ( isset( $image_url ) && $image_url !== "" && URL_exists( $image_url ) ) {
			$has_image = true;
		}

		if ( has_nav_menu( 'shortcode' ) ):
            ob_start();
            ?>

    		<nav id="shortcode-menu-nav" class="shortcode-menu-nav-class" role="navigation">
    			<div class="no-padding-header-widget">

    				<div class="shortcode-menu-collapser"><?php if ( $has_image ): ?><img id="shortcode-menu-logo" class="shortcode-menu-logo-class" src="<?php echo $image_url; ?>"><?php endif; ?><div class="shortcode-menu-collapse-button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div></div>
    				<?php
    				wp_nav_menu( array(
    							'theme_location' 	=> 'shortcode',
    							'container'			=> '',
    						    'container_id' 		=> 'shortcode-menu-container',
    						    'container_class' 	=> 'shortcode-menu-container-class',
    						    'items_wrap' 		=> '<ul id="shortcode-menu-ul" class="shortcode-menu-ul-class">%3$s</ul>',
    						    'depth'				=> '3',
    						    'pretag'			=> 'shortcode-',
    						    'echo' 				=> true,
            					'fallback_cb' 		=> '__return_false'
    							) );
    				?>
    			</div>
    		</nav><!-- #site-navigation -->
    		<?php

        return ob_get_clean();

        else:

			return esc_attr__( 'Please create menu and add pages to "Shortcode Menu" first!', 'exopite' );

		endif;
	}
}

/**
 * Display Exopite social menu. You can crate the menu in wp-admin/Appearance/Menus.
 *
 * @link http://justintadlock.com/archives/2013/08/07/social-media-nav-menus
 * @link http://justintadlock.com/archives/2013/08/14/social-nav-menus-part-2
 *
 * [exopite-social-menu]
 */
add_shortcode( 'exopite-social-menu', 'exopite_social_menu' );
if ( ! function_exists( 'exopite_social_menu' ) ) {
	function exopite_social_menu() {

		if ( has_nav_menu( 'social' ) ) {
            return wp_nav_menu(
				array(
					'theme_location'  => 'social',
					'container'       => 'div',
					'container_id'    => 'menu-social',
					'container_class' => 'social-menu',
					'menu_id'         => 'menu-social-items',
					'menu_class'      => 'menu-items',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'fallback_cb'     => '',
                    'echo'            => false,
				)
			);
		}
	}
}

if ( ( class_exists( 'WooCommerce' ) ) && ( ! function_exists( 'exopite_display_woocommerce_cart' ) ) ) {
	add_shortcode( 'exopite-woocommerce-cart', 'exopite_display_woocommerce_cart' );
	function exopite_display_woocommerce_cart( $atts ) {

		$args = shortcode_atts(
		    array(
		        'if-empty' => '',
		    ),
		    $atts
		);

		$if_empty = true;

		$if_empty = esc_attr( $args['if-empty'] );

		global $woocommerce;

		$viewing_cart = esc_attr__('View your shopping cart', 'exopite');
		$start_shopping = esc_attr__('Start shopping', 'exopite');
		$cart_url = $woocommerce->cart->get_cart_url();
		$shop_page_url = esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		$cart_contents = sprintf( _n('%d item', '%d items', $cart_contents_count, 'exopite'), esc_attr( $cart_contents_count ) );
		$cart_total = $woocommerce->cart->get_cart_total();

		if ( $cart_contents_count > 0 || $if_empty ) {
			if ($cart_contents_count == 0) {
				$menu_item = '<a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
			} else {
				$menu_item = '<a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
			}

			$menu_item .= '<i class="fa fa-shopping-cart">&nbsp;</i> ';

			$menu_item .= $cart_contents.' - '. $cart_total;
			$menu_item .= '</a>';
		}

		return $menu_item;
	}
}

/**
 * Display Exopite Breadcumbs
 *
 * [exopite-breadcrumbs]
 */
add_shortcode( 'exopite-breadcrumbs', 'exopite_breadcrumbs' );
