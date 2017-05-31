<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$exopite_settings = get_option( 'exopite_options' );

$wc_archive_sidebar = 'right';
$wc_active_sidebar = is_active_sidebar( $exopite_settings['exopite-shop-sidebar-id'] );


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
        if ( $wc_archive_sidebar == 'left' ) {

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
    	 * @hooked WC_Structured_Data::generate_website_data() - 30
    	 */
    	do_action( 'woocommerce_before_main_content' );

        ?>
        <div id="primary" class="<?php if ( $wc_archive_sidebar != 'none' && $wc_active_sidebar ) : ?>col-md-9<?php else : ?>col-md-12<?php endif; ?> woocommerce-shop">
            <header class="woocommerce-products-header">
        		<?php

                if ( apply_filters( 'woocommerce_show_page_title', true ) ) :

                ?>
        			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                <?php

        		endif;

        			/**
        			 * woocommerce_archive_description hook.
        			 *
        			 * @hooked woocommerce_taxonomy_archive_description - 10
        			 * @hooked woocommerce_product_archive_description - 10
        			 */
        			do_action( 'woocommerce_archive_description' );
        		?>
            </header>
    		<?php

            if ( have_posts() ) :


    			/**
    			 * woocommerce_before_shop_loop hook.
    			 *
    			 * @hooked wc_print_notices - 10
    			 * @hooked woocommerce_result_count - 20
    			 * @hooked woocommerce_catalog_ordering - 30
    			 */
    			do_action( 'woocommerce_before_shop_loop' );

                woocommerce_product_loop_start();

                woocommerce_product_subcategories();

                while ( have_posts() ) : the_post();


    					/**
    					 * woocommerce_shop_loop hook.
    					 *
    					 * @hooked WC_Structured_Data::generate_product_data() - 10
    					 */
    					do_action( 'woocommerce_shop_loop' );

    				wc_get_template_part( 'content', 'product' );

                endwhile; // end of the loop.

                woocommerce_product_loop_end();
    			/**
    			 * woocommerce_after_shop_loop hook.
    			 *
    			 * @hooked woocommerce_pagination - 10
    			 */
    			do_action( 'woocommerce_after_shop_loop' );

    		elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) :

    				/**
    				 * woocommerce_no_products_found hook.
    				 *
    				 * @hooked wc_no_products_found - 10
    				 */
    				do_action( 'woocommerce_no_products_found' );

    		endif;

        		/**
        		 * woocommerce_after_main_content hook.
        		 *
        		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
        		 */
        		do_action( 'woocommerce_after_main_content' );
        	?>
            </div><!-- #primary -->
    	<?php

        // Sidebar on the right side
        if ( $wc_archive_sidebar == 'right' ) {

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
<?php get_footer( 'shop' ); ?>
