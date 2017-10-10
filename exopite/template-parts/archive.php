<?php
/**
 * The default template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
// Exit if accessed directly
defined('ABSPATH') or die( __( 'You cannot access this page directly.', 'exopite' ) );

$sidebar_id = exopite_get_sidebar_id();
$active_sidebar = is_active_sidebar( $sidebar_id );

$content_class = ( $active_sidebar && ( $exopite_settings['exopite-blog-list-layout'] == 'blog-list-left-sidebar' || $exopite_settings['exopite-blog-list-layout'] == 'blog-list-right-sidebar' ) ) ? 'col-md-9' : 'col-md-12';

$exopite_settings = get_option( 'exopite_options' );
?>
    <div class="container">
        <?php

        // Exopite hooks (include/exopite-hooks.php)
        exopite_hooks_content_container_top();

        ?>
        <div class="row">
            <header class="<?php echo $content_class; ?> page-header">
                <h1 class="page-title" itemprop="headline">
                    <?php

                        $args = array();

                        if ( is_category() ) {
                            // Category

                            // Display title
                            echo '<span>' . single_cat_title( '', false ) . '</span>';

                            // Set WP_Query args
                            $args['query_args']['category_name'] = $wp_query->queried_object->slug;

                        } elseif ( is_tag() ) {

                            printf( esc_html__( 'Tagged in', 'exopite' ) . ' %s', '<span>' . single_tag_title( '', false ) . '</span>' );
                            $args['query_args']['tag'] = $wp_query->queried_object->slug;

                        } elseif ( is_author() ) {

                            /* Queue the first post, that way we know
                             * what author we're dealing with (if that is the case).
                            */
                            the_post();
                            printf( esc_attr__( 'Author', 'exopite' ) . ' %s', '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . esc_attr( get_the_author() ) . '</a></span>' );

                            $args['query_args']['author'] = get_the_author_meta( "ID" );

                            /* Since we called the_post() above, we need to
                             * rewind the loop back to the beginning that way
                             * we can run the loop properly, in full.
                             */
                            rewind_posts();

                        } elseif ( is_day() ) {

                            printf( esc_attr__( 'Daily Archives: %s', 'exopite' ), '<span>' . get_the_date() . '</span>' );
                            $args['query_args']['date_query'] = array(
                                    array(
                                        'year'  => get_the_date( 'Y' ),
                                        'month' => get_the_date( 'm' ),
                                        'day'   => get_the_date( 'd' ),
                                    ),
                                );

                        } elseif ( is_month() ) {

                            $time = get_post_time(
                                    get_option( 'date_format' ),      // format
                                    TRUE,          // GMT
                                    get_the_ID(),  // Post ID
                                    TRUE           // translate, use date_i18n()
                                );

                            printf( esc_attr__( 'Monthly Archives: %s', 'exopite' ), '<span>' . get_the_date( 'Y F' ) . '</span>' );
                            $args['query_args']['date_query']  = array(
                                    array(
                                        'year'  => get_the_date( 'Y' ),
                                        'month' => get_the_date( 'm' ),
                                    ),
                                );

                        } elseif ( is_year() ) {

                            printf( esc_attr__( 'Yearly Archives: %s', 'exopite' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
                            $args['query_args']['date_query']  = array(
                                    array(
                                        'year' => get_the_date( 'Y' ),
                                    ),
                                );

                        } elseif ( get_post_type() === 'post' ) {

                            esc_attr_e( 'Archives', 'exopite' );

                        } else {
                            // Default (for custom post types)

                            $post_type = get_post_type_object( get_post_type() );
                            printf( esc_attr__( 'Archives for %s', 'exopite' ), '<span>' . esc_html( $post_type->labels->singular_name ) . '</span>' );
                            $args['query_args']['post_type'] =  get_post_type();

                        }
                    ?>
                </h1>
                <?php
                    if ( is_category() ) {

                        // display an optional category description
                        $category_description = category_description();
                        if ( ! empty( $category_description ) )
                            echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

                    } elseif ( is_tag() ) {

                        // display an optional tag description
                        $tag_description = tag_description();
                        if ( ! empty( $tag_description ) )
                            echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
                    }
                ?>
            </header><!-- .page-header -->
        </div>
        <div class="row">
            <?php

            // Display sidebar on the right side.
            if ( $active_sidebar && $exopite_settings['exopite-blog-list-layout'] == 'blog-list-left-sidebar' ) get_sidebar();

            ?>
            <div id="primary" class="<?php echo $content_class; ?> content-area">
                <main id="main" class="site-main"<?php WP_Schema::get_attribute( 'site-main' ); ?>>
                <?php

                // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                tha_content_top();

                if ( have_posts() ) :

                    /**
                     * Diplay author bio on a author page (archive)
                     */
                    if ( is_author() && get_the_author_meta( 'description' ) ) {
                        exopite_author_meta();
                    }

                    // Display theme loop
                    include( locate_template( 'template-parts/loop.php' ) );
                    echo the_loop( $args );

                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif;

                // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
                tha_content_bottom();

                ?>
                </main><!-- #main -->
            </div><!-- #primary -->
            <?php

            // Display sidebar on the right side.
            if ( $active_sidebar && $exopite_settings['exopite-blog-list-layout'] == 'blog-list-right-sidebar' ) get_sidebar();

            ?>
        </div><!-- .row -->
        <?php

        // Exopite hooks (include/exopite-hooks.php)
        exopite_hooks_content_container_bottom();

        ?>
    </div><!-- .container -->

