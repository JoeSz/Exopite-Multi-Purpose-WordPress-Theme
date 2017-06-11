<?php
/**
 * Exopite sidebars/widget areas functions.
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/*
 * ToDo:
 * - change badge to "star" or ribbon
 * - change numerinc updown to - NR +
 * - plugins suggestions if woocommerce is activated
 *
 * @link https://www.skyverge.com/blog/get-woocommerce-page-urls/
 */

/*
 * Register WooCommerce sidebar
 */
register_sidebar( array(
    'name'          => esc_attr__( 'WooCommerce Sidebar', 'exopite' ),
    'id'            => 'shop',
    'description'   => esc_attr__( 'WooCommerce sidebar. Displayed on the side of the WooCommerce sites. Add widgets here.', 'exopite' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
) );

// WooCommerce Cart overview in menu
if ( ! function_exists( 'exopite_menu_get_wc_cart_overview' ) ) {
    function exopite_menu_get_wc_cart_overview() {

        $count = WC()->cart->cart_contents_count;

        $wc_cart_content = '<a class="cart-contents" href="' . WC()->cart->get_cart_url() . '" title="' . __( 'View your shopping cart' ) . '">';
        $wc_cart_content .= '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';

        if ( $count > 0 ) {

            $wc_cart_content .= '<span class="cart-contents-count">' . esc_html( WC()->cart->get_cart_contents_count() ). '</span>';
            $wc_cart_content .= '<span class="amount">' . wp_kses_data( WC()->cart->get_cart_subtotal() ) . '</span>';

        }

        $wc_cart_content .= '</a>';

        return $wc_cart_content;

    }
}

// WooCommerce cart content in menu (on overview hover)
if ( ! function_exists( 'exopite_menu_get_wc_cart_content' ) ) {
    function exopite_menu_get_wc_cart_content() {

        $items = WC()->cart->get_cart();

        $wc_cart_content = '<div class="wc-menu-cart-contents">';

        $wc_cart_content .= '
        <div class="dropdown-cart-wrap dropdown-cart-first">
            <div class="dropdown-cart-left dropdown-cart-link">
                <a href="' . WC()->cart->get_cart_url() . '">' . __( 'Cart', 'woocommerce' ) . '</a>
            </div>

            <div class="dropdown-cart-right dropdown-checkout-link">
                <a href="' .  WC()->cart->get_checkout_url() . '">' . __( 'Checkout', 'woocommerce' ) . '</a>
            </div>

            <div class="clear"></div>
        </div>';

        $wc_cart_content .= '<div class="cart-dropdown-inner woocommerce">';

        if ( $items ) {

            //foreach ( WC()->cart->get_cart() as $cart_item ) {
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

                $wc_cart_content .= '<div class="dropdown-cart-wrap"><a href="' . $cart_item['data']->get_permalink() . '"><div class="dropdown-cart-left">';
                $wc_cart_content .= $cart_item['data']->get_image();
                $wc_cart_content .= '</div><div class="dropdown-cart-right">';
                $wc_cart_content .= '<h5>' .  $cart_item['data']->get_title() . '</h5>';
                $wc_cart_content .= '<span class="dropdown-cart-price">' . $cart_item['quantity'] . ' x ' . $cart_item['data']->get_price_html() . '</span>';
                $wc_cart_content .= '</div>';
                $wc_cart_content .= '<div class="dropdown-cart-remove"><a href="' . esc_url( WC()->cart->get_remove_url( $cart_item_key ) ) . '" class="remove" data-product_id="' . $cart_item['data']->get_id() . '" title="' . __( 'Remove this item', 'woocommerce' ) . '">&times;</a></div>';
                $wc_cart_content .= '<div class="clear"></div></a></div>';
            }

        } else {

            $wc_cart_content .= '<div class="dropdown-cart-wrap cart-menu-empty"><a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . __( 'No products in the cart.', 'woocommerce' ) . '</a></div>';

        }

        $wc_cart_content .= '</div>';

        if ( $items ) {

            $wc_cart_content .= '<div class="dropdown-cart-wrap dropdown-cart-total">';
            $wc_cart_content .= '<div class="dropdown-cart-left"><h6>' . esc_html__( 'Subtotal', 'woocommerce' ) . '</h6></div>';
            $wc_cart_content .= '<div class="dropdown-cart-right"><h6>' . WC()->cart->get_cart_total() . '</h6></div>';
            $wc_cart_content .= '<div class="clear"></div>';
            $wc_cart_content .= '</div>';

        }

        return $wc_cart_content;

    }
}

/**
 * Hooks to add Cart icon, count and amount to menu if WC is active and to
 * ensure cart contents update when products are added to the cart via AJAX
 */
if ( isset( $exopite_settings['exopite-woocommerce-show-cart-in-menu'] ) && $exopite_settings['exopite-woocommerce-show-cart-in-menu'] ) {

    add_filter( 'wp_nav_menu_items', 'exopite_menu_wc_cart', 9, 2 );
    add_filter( 'woocommerce_add_to_cart_fragments', 'exopite_menu_wc_cart_fragment' );

}

/**
 * Add Cart icon, count and amount to menu if WC is active
 * @link https://www.faizamer.my/cart-icon-woocommerce/
 */
if ( ! function_exists( 'exopite_menu_wc_cart' ) ) {
    function exopite_menu_wc_cart( $items, $args ) {

        if ( $args->theme_location == 'primary' || $args->theme_location == 'mobile' ) {
            if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

                $items .= '<li class="woocommerce-cart-menu menu-item">';
                $items .= apply_filters( 'exopite-woocommerce-cart-menu-overview', exopite_menu_get_wc_cart_overview() );
                $items .= '<ul id="cart-dropdown" class="sub-menu">';
                $items .= apply_filters( 'exopite-woocommerce-cart-menu-content', exopite_menu_get_wc_cart_content() );
                $items .= '</ul>';
                $items .= '</li>';

            }
        }
        return $items;
    }
}

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
if ( ! function_exists( 'exopite_menu_wc_cart_fragment' ) ) {
    function exopite_menu_wc_cart_fragment( $fragments ) {

        $count = WC()->cart->cart_contents_count;

        $fragment_cart_overview = apply_filters( 'exopite-woocommerce-cart-menu-overview', exopite_menu_get_wc_cart_overview() );
        $fragment_cart_content = apply_filters( 'exopite-woocommerce-cart-menu-content', exopite_menu_get_wc_cart_content() );

        $fragments['a.cart-contents'] = $fragment_cart_overview;
        $fragments['div.wc-menu-cart-contents'] = $fragment_cart_content;

        return $fragments;
    }
}


/**
 * Change wrapper for theme compatibility
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Remove Woocommerce breadcrumbs
 */
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

/*
* Return a new number of maximum columns for shop archives
* @param int Original value
* @return int New number of columns
*/

$exopite_woocommerce_shop_product_per_row = ( isset( $exopite_settings['exopite-woocommerce-shop-product-per-row'] ) ) ?
    $exopite_settings['exopite-woocommerce-shop-product-per-row'] :
    3;
ExopiteSettings::setValue( 'exopite-woocommerce-shop-product-per-row', $exopite_woocommerce_shop_product_per_row );
add_filter( 'loop_shop_columns', 'exopite_woocommerce_shop_product_per_row', 1, 10 );
if ( ! function_exists( 'exopite_woocommerce_shop_product_per_row' ) ) {
    function exopite_woocommerce_shop_product_per_row( $number_columns ) {
        return ExopiteSettings::getValue( 'exopite-woocommerce-shop-product-per-row' );
    }

}

/*
 * Change number of products displayed per page
 * @link https://docs.woocommerce.com/document/change-number-of-products-displayed-per-page/
 */
$exopite_woocommerce_shop_product_per_page = ( isset( $exopite_settings['exopite-woocommerce-shop-product-per-page'] ) ) ?
    $exopite_settings['exopite-woocommerce-shop-product-per-page'] :
    9;
ExopiteSettings::setValue( 'exopite-woocommerce-shop-product-per-page', $exopite_woocommerce_shop_product_per_page );
add_filter( 'loop_shop_per_page', 'exopite_woocommerce_shop_product_per_page', 20 );
if ( ! function_exists( 'exopite_woocommerce_shop_product_per_page' ) ) {
    function exopite_woocommerce_shop_product_per_page( $cols ) {
        // $cols contains the current number of products per page based on the value stored on Options -> Reading
        // Return the number of products you wanna show per page.
        return ExopiteSettings::getValue( 'exopite-woocommerce-shop-product-per-page' );
    }
}

/*
 * Add categories to product items on shop page
 */
if ( ! isset( $exopite_settings['exopite-woocommerce-categories-product-shop'] ) || $exopite_settings['exopite-woocommerce-categories-product-shop'] ) {
    add_action('woocommerce_shop_loop_item_title','exopite_woocommerce_categories_product_shop', 0);
}
if ( ! function_exists( 'exopite_woocommerce_categories_product_shop' ) ) {
    function exopite_woocommerce_categories_product_shop(){
      ?>
      <div class="wc-category uppercase smaller text-uppercase text-nowrap">
            <?php

            global $product;
            echo wc_get_product_category_list( $product->get_id() );

            ?>
       </div>
       <?php
    }
}

/*
 * Remove Default Add To cart button from Grid
 */
if ( ! isset( $exopite_settings['exopite-woocommerce-remove-add-to-cart-shop'] ) || $exopite_settings['exopite-woocommerce-remove-add-to-cart-shop'] ) {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

/*
 * Remove and add Product image
 */
if ( ! isset( $exopite_settings['exopite-woocommerce-remove-product-image'] ) || $exopite_settings['exopite-woocommerce-remove-product-image'] ) {
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
}

/*
 * Remove Ratings
 */
if ( ! isset( $exopite_settings['exopite-woocommerce-remove-ratings'] ) || $exopite_settings['exopite-woocommerce-remove-ratings'] ) {
    add_action('woocommerce_shop_loop_item_title','exopite_woocommerce_remove_ratings', 0);
}
if ( ! function_exists( 'exopite_woocommerce_remove_ratings' ) ) {
    function exopite_woocommerce_remove_ratings(){
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    }
}

$exopite_woocommerce_releated_per_page = ( isset ( $exopite_settings['exopite-woocommerce-releated-per-page'] ) ) ?
    $exopite_settings['exopite-woocommerce-releated-per-page'] :
    4;

$exopite_woocommerce_releated_columns = ( isset( $exopite_settings['exopite-woocommerce-releated-columns'] ) ) ?
    $exopite_settings['exopite-woocommerce-releated-columns'] :
    4;

if ( $exopite_woocommerce_releated_per_page == 0 ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
} else {
    ExopiteSettings::setValue( 'exopite-woocommerce-releated-columns', $exopite_woocommerce_releated_columns );
    ExopiteSettings::setValue( 'exopite-woocommerce-releated-per-page', $exopite_woocommerce_releated_per_page );
    function woocommerce_output_related_products() {
        woocommerce_related_products(
            array(
                'posts_per_page' => ExopiteSettings::getValue( 'exopite-woocommerce-releated-per-page' ),
                'columns' => ExopiteSettings::getValue( 'exopite-woocommerce-releated-columns' )
            )
        );
    }
}

/*
 * Replace shop page title
 * Using this block of code you can quickly, replace the title of your shop. Just substitute the return value with your preferred name.
 *
 * @link https://theme4press.com/20-useful-woocommerce-snippets-wordpress-themes/
 */
if ( isset( $exopite_settings['exopite-shop-title'] ) && ! empty( $exopite_settings['exopite-shop-title'] ) ) {

    ExopiteSettings::setValue( 'exopite-shop-title', $exopite_settings['exopite-shop-title'] );

    add_filter( 'woocommerce_page_title', 'exopite_woocommerce_shop_page_title');
    if ( ! function_exists( 'exopite_woocommerce_shop_page_title' ) ) {
        function exopite_woocommerce_shop_page_title( $page_title ) {

            if( 'Shop' == $page_title) {

                return ExopiteSettings::getValue( 'exopite-shop-title' );

            }

        }
    }


}

/*
 * Display new badge for the amount of days
 */
if ( isset( $exopite_settings['exopite-woocommerce-new-badge-days'] ) && $exopite_settings['exopite-woocommerce-new-badge-days'] > 0 ) {
    ExopiteSettings::setValue( 'exopite-woocommerce-new-badge-days', $exopite_settings['exopite-woocommerce-new-badge-days'] );
    add_action( 'woocommerce_before_shop_loop_item_title', 'exopite_woocommerce_shop_new_badge', 30 );
}
if ( ! function_exists( 'exopite_woocommerce_shop_new_badge' ) ) {
    function exopite_woocommerce_shop_new_badge() {
        $post_date = strtotime( get_the_time( 'Y-m-d' ) );
        $days_to_show = ExopiteSettings::getValue( 'exopite-woocommerce-new-badge-days' );

        if ( ( time() - ( 60 * 60 * 24 * $days_to_show ) ) < $post_date ) {
            echo '<span class="woocommerce-new-badge">' . esc_attr__( 'NEW', 'exopite' ) . '</span>';
        }
    }
}

/**
 * Remove product in the cart using ajax in woocommerce
 *
 * @link https://stackoverflow.com/questions/41782403/force-woocommerce-to-update-fragment/42429600#42429600
 * @link https://stackoverflow.com/questions/21900865/remove-product-in-the-cart-using-ajax-in-woocommerce
 */
add_action( 'wp_ajax_product_remove', 'product_remove' );
add_action( 'wp_ajax_nopriv_product_remove', 'product_remove' );
function product_remove() {

    $cart = WC()->cart;

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
        if( $cart_item['product_id'] == $_POST['product_id'] ){
            $cart->remove_cart_item( $cart_item_key );
        }
    }

    die();
}
