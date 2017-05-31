<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$exopite_settings = get_option( 'exopite_options' );

$wc_single_sidebar = 'right';
$wc_active_sidebar = is_active_sidebar( $exopite_settings['exopite-product-sidebar-id'] );

get_header( 'shop' );

?>
<div class="container">
    <?php

    // Exopite hooks (include/exopite-hooks.php)
    exopite_hooks_content_container_top();

    ?>
    <div class="row">
        <?php

        // Sidebar on the left side
        if ( $wc_single_sidebar == 'left' ) {

            /**
             * woocommerce_sidebar hook.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            do_action( 'woocommerce_sidebar' );

        }

    	/**
    	 * woocommerce_before_main_content hook.
    	 *
    	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
    	 * @hooked woocommerce_breadcrumb - 20
    	 */
    	do_action( 'woocommerce_before_main_content' );

        ?>
        <div id="primary" class="<?php if ( $wc_single_sidebar != 'none' && $wc_active_sidebar ) : ?>col-md-9<?php else : ?>col-md-12<?php endif; ?> content-area">
        <?php

        while ( have_posts() ) : the_post();

    		wc_get_template_part( 'content', 'single-product' );

    	endwhile; // end of the loop.

        ?>
        </div><!-- #primary -->
        <?php

    	/**
    	 * woocommerce_after_main_content hook.
    	 *
    	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    	 */
    	do_action( 'woocommerce_after_main_content' );

        // Sidebar on the right side
        if ( $wc_single_sidebar == 'right' ) {

            /**
             * woocommerce_sidebar hook.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            do_action( 'woocommerce_sidebar' );

        }

        ?>
    </div>
</div>
<?php

get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
