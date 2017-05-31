<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

get_header();

?>
	<div class="container">
		<div class="row">
			<div id="primary" class="col-md-12 content-area">
				<main id="main" class="site-main">
					<?php

                    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                    tha_content_top();

                    ?>
					<section class="error-404 not-found">
						<?php

                        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                        tha_entry_before();
						tha_entry_top();

                        ?>
						<header class="page-header">
                            <h1 class="page-title"><?php esc_html_e( "404", 'exopite' ); ?></h1>
							<h2 class="page-subtitle"><?php esc_html_e( "We apologies for the inconvenience, but we couldn't find the page you were looking for.", 'exopite' ); ?></h2>
							<h3 class="page-subtitle"><?php esc_html_e( 'Maybe you followed a bad link or typed a wrong URL?', 'exopite' ); ?></h3>
						</header><!-- .page-header -->
						<?php

                        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                        tha_entry_content_before();

                        ?>
						<div class="page-content">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p><?php esc_html_e( 'Maybe try one of the links below or a search?', 'exopite' ); ?></p>
                                </div>
                            </div>
                            <div class="row row-margin-bottom">
                                <div class="col-12 col-md-4 offset-md-4 text-center">
                                    <?php

                                    get_search_form();

                                    ?>
                                    <a href="<?php echo esc_url( get_site_url() ); ?>" class="btn btn-material btn-readmore"><?php esc_html_e( 'Go to homepage', 'exopite' ) ?></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php

                                    /*
                                     * Hook to display search on the 404 page from the url
                                     * (include/template-functions.php -> exopite_hooks_404_content)
                                     *
                                     * Exopite hooks (include/exopite-hooks.php)
                                     */
                                    exopite_hooks_404_content();

                                    ?>
                                </div>
                            </div>
                            <?php

                            /*
                             * Hook to display recommendations on 404 and search sites.
                             * Like:
                             *  - top 5 recent posts
                             *  - top 5 moust use categories
                             *  - top 20 tag in tag cloud
                             *
                             * (include/template-functions.php -> exopite_404_search_recommendations)
                             *
                             * Exopite hooks (include/exopite-hooks.php)
                             */
                            exopite_hooks_404_search_recommendations();

                            ?>

						</div><!-- .page-content -->
						<?php

                        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                        tha_entry_content_after();
						tha_entry_bottom();

                        ?>
					</section><!-- .error-404 -->
					<?php

                    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                    tha_content_bottom();
                    tha_entry_after();

                    ?>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .row -->
	</div><!-- .container -->
<?php

get_footer();
