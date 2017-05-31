<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Individual page/post settings
 *
 * I think it is a better way, to get options in the header and the footer to, like put it in a global variable,
 * because WordPress will cache options.
 */
$exopite_settings = get_option( 'exopite_options' );
$exopite_meta_data = get_post_meta( get_the_ID(), 'exopite_custom_page_options', true );
$show_footer = isset( $exopite_meta_data['exopite-meta-enable-footer'] ) ? esc_attr( $exopite_meta_data['exopite-meta-enable-footer'] ) : true;
?>
        </div><!-- #content -->
		<?php

        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
        tha_content_after();

        // Hide footer
		if ( apply_filters( 'exopite-enable-footer', $show_footer ) ) :

        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
		tha_footer_before();

        ?>
		<footer id="colophon" class="site-footer <?php if( $exopite_settings['exopite-sidebar-footer-enable-slide-up'] && $exopite_settings['exopite-content-layout'] == 'wide' ) echo ' fixed'; ?>" itemscope="itemscope" itemtype="https://schema.org/WPFooter">
			<?php tha_footer_top();

            /**
             * Use page for footer
             */
            if ( $exopite_settings['exopite-footer-content'] == 'page' ) :

                include( locate_template( 'template-parts/footer-from-page.php' ) );

            else:

                /*
                 * Hook to display sidebar in the footer
                 *  - footer sidebars,                       10 (include/sidebars.php)
                 *  - copyright sidebars,                    20 (include/sidebars.php)
                 */
                exopite_hooks_footer_sidebars();

            endif;

            // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
			tha_footer_bottom();

            ?>
		</footer><!-- #colophon -->
		<?php

        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
        tha_footer_after();

		endif; // Hide footer

        // Close (#boxed-content boxed) marker to side menu on layout boxed,
        // to add color or image background to preheader, content and footer.
        if ( $exopite_settings['exopite-menu-alignment'] == 'left' && $exopite_settings['exopite-content-layout'] == 'boxed' ) :
        ?>
        </div><!-- #boxed-content -->
        <?php
        endif;

        ?>
	</div><!-- #content-with-footer -->
</div><!-- #page -->
<?php

tha_body_bottom();

/*
 * Minifying HTML output
 * Stop output buffering and display page.
 * Display page before wp_footer, so let JavaScript-block rerendering after content is shown.
 * (do not block content rerendering)
 */
if ( $exopite_settings['exopite-minify-html'] && class_exists( 'Exopite_Minifier' ) ) {
    $content = ob_get_clean();
    echo Exopite_Minifier::minify_html( $content );
}

wp_footer();

?>
</body>
</html>


