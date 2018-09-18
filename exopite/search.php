<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

get_header();

$exopite_settings = get_option( 'exopite_options' );
?>

	<div class="container">
		<?php

        // Exopite hooks (include/exopite-hooks.php)
        exopite_hooks_content_container_top();

        ?>
		<div class="row">
            <header class="col-md-12 page-header">
                <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'exopite' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header><!-- .page-header -->
			<div id="primary" class="col-md-12 content-area">
				<main id="main" class="site-main"<?php WP_Schema::get_attribute( 'site-main' ); ?>>
				<?php

                // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                wp_content_top();

				if ( have_posts() && strlen( get_search_query() ) ) :
				?>
					<h3 class="page-subtitle text-center"><?php echo $wp_query->found_posts . ' ' . esc_html__( 'results found.', 'exopite' ); ?></h3>
				<?php

                    $args = array();
                    $args[ 'query_args' ]['s'] = esc_html( get_search_query() );

                    // Get the theme loop
					include( locate_template( 'template-parts/loop.php' ) );

                    // and display it
                    echo the_loop( $args );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
				<?php

                // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                wp_content_bottom();

                ?>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .row -->
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

        // Exopite hooks (include/exopite-hooks.php)
        exopite_hooks_content_container_bottom();


        ?>
	</div><!-- .container -->
<?php

get_footer();
