<?php
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Custom loop for index, archive and search.
 * Use the loop this way, do it can be used in templates and shortcodes as well.
 */

/**
* array_merge_recursive_overwrite()
*
* Similar to array_merge_recursive but keyed-valued are always overwritten.
* Priority goes to the 2nd array.
*
* @param $paArray1 array
* @param $paArray2 array
* @return array
*
* @link http://php.net/manual/en/function.array-merge-recursive.php#42663
*/
if ( ! function_exists( 'array_merge_recursive_overwrite' ) ) {
    function array_merge_recursive_overwrite( $paArray1, $paArray2 ) {
        if ( ! is_array( $paArray1 ) or ! is_array( $paArray2 ) ) {
            return $paArray2;
        }
        foreach ( $paArray2 AS $sKey2 => $sValue2 ) {
            $paArray1[$sKey2] = array_merge_recursive_overwrite( @$paArray1[$sKey2], $sValue2 );
        }
        return $paArray1;
    }
}

if ( ! function_exists( 'the_loop' ) ) {
    function the_loop( $args_input = array() ) {

        global  $wp_query;

        $page = '';

        $exopite_settings = get_option( 'exopite_options' );

        // Default options options
        $args_default = array(
            'column_layout' => false,
            'gap' => true,
            'show_thumbnail' => true,
            'show_exceprt' => true,
            'show_post_navigation' => true,
            'show_filter_before_nth_item' => false,
            'query_args' => array(),

        );

        // To handle archive with [exopite-loop] shortcode automatically. Eg.: custom archive page
        if ( is_archive() ) {
            if ( is_tag() ) $args_default['query_args']['tag'] = $wp_query->query_vars['tag'];
            if ( is_category() ) $args_default['query_args']['category_name'] = $wp_query->query_vars['category_name'];
            if ( is_date() ) {
                if ( is_year() ) {
                    $args['query']['year'] = $wp_query->query_vars['year'];
                }
                if ( is_year() || is_month() ) {
                    $args['query']['year'] = $wp_query->query_vars['year'];
                    $args['query']['monthnum'] = $wp_query->query_vars['monthnum'];
                }
                if ( is_year() || is_month() || is_day() ) {
                    $args['query']['year'] = $wp_query->query_vars['year'];
                    $args['query']['monthnum'] = $wp_query->query_vars['monthnum'];
                    $args['query']['day'] = $wp_query->query_vars['day'];
                }
            }
            if ( is_author() ) $args_default['query_args']['author_name'] = $wp_query->query_vars['author_name'];
        }

        // Overwrite default args with input
        $args = array_merge_recursive_overwrite( $args_default, $args_input );

        // Set excerpt more
        if ( isset( $args['custom-excerpt-more'] ) && ! empty( $args['custom-excerpt-more'] ) ) {
            ExopiteSettings::setValue( 'loop_exopite-custom-excerpt-more', $args['custom-excerpt-more'] );
            if ( ! function_exists( 'loop_exopite_excerpt_more' ) ) {
                function loop_exopite_excerpt_more( $more ) {

                    global $post;
                    return ExopiteSettings::getValue( 'loop_exopite-custom-excerpt-more' );

                }
            }
            add_filter( 'excerpt_more', 'loop_exopite_excerpt_more', 99 );
        }

        /*
         * Paging
         *
         * paged -> Used on the homepage, blogpage, archive pages and pages to calculate pagination.
         *          1st page is 0 and from there the number correspond to the page number
         *
         * page -> Use on a static front page and single pages for pagination. Pagination on these pages works
         *         the same, a static front page is treated as single page on pagination. By pagination on single pages,
         *         I mean that single posts can be broken down into multiple pages.
         *
         * http://wordpress.stackexchange.com/questions/180784/what-is-the-difference-between-paged-and-page/180785#180785
         *
         */
        if ( get_query_var( 'page' ) ) {

            // For static home pages:
            $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

        } elseif ( get_query_var( 'paged' ) ) {

            // For custom pages:
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        } else {

            // If not set, then set 1 as default
            $paged = 1;

        }

        // Add paged to args, overwrite if has been already set
        if ( is_array( $args['query_args'] ) ) {
            $args['query_args'] = array_merge( $args['query_args'], array( 'paged' => $paged, ) );
        } else {
            $args['query_args'] = array( 'paged' => $paged, );
        }

        if ( is_home() ) {

            /**
             * Normally you do not use custom query on index, search, archive, category,
             * so make pagination work, we define posts_per_page as the default here.
             */
            $args['query_args'] = array_merge( $args['query_args'], array( 'posts_per_page' => get_option( 'posts_per_page' ), ) );

        }

        /**
         * Default variables
         */
        $exopite_blog_first_full = ( isset( $exopite_settings['exopite-blog-first-full'] ) ) ?
            $exopite_settings['exopite-blog-first-full'] :
            true;
        $exopite_blog_layout = ( isset( $exopite_settings['exopite-blog-layout'] ) ) ?
            $exopite_settings['exopite-blog-layout'] :
            'image-left';
        $exopite_blog_post_per_row = ( isset( $exopite_settings['exopite-blog-post-per-row'] ) ) ?
            $exopite_settings['exopite-blog-post-per-row'] :
            1;
        $exopite_blog_no_gap = ( isset( $exopite_settings['exopite-blog-no-gap'] ) ) ?
            $exopite_settings['exopite-blog-no-gap'] :
            false;
        $exopite_blog_list_layout = ( isset( $exopite_settings['exopite-blog-list-layout'] ) ) ?
            $exopite_settings['exopite-blog-list-layout'] :
            'blog-list-right-sidebar';
        $exopite_blog_multi_column_layout_type = ( isset( $exopite_settings['exopite-blog-multi-column-layout-type'] ) ) ?
            $exopite_settings['exopite-blog-multi-column-layout-type'] :
            'normal';

        // If we want the first post as full width or want to display something after
        // Xnt post (on each page), then need to count the posts on the page.
        $post_count = 1;
        $blog_first_full = isset( $args['blog_first_full'] ) ? $args['blog_first_full'] : $exopite_blog_first_full;

        // Only true, if we want the first post as full width and this is the first page
        $is_blog_first_full = ( $blog_first_full && $paged == 1 );
        $blog_layout = isset( $args['blog-layout'] ) ? $args['blog-layout'] : $exopite_blog_layout;
        $posts_per_row = isset( $args['blog-post-per-row'] ) ? $args['blog-post-per-row'] : $exopite_blog_post_per_row;
        $multi_row = ( $posts_per_row > 1 );
        $blog_no_gap = isset( $args['blog-no-gap'] ) ? $args['blog-no-gap'] : $exopite_blog_no_gap;
        $blog_list_layout = isset( $args['blog-list-layout'] ) ? $args['blog-list-layout'] : $exopite_blog_list_layout;
        $blog_multi_column_layout_type = isset( $args['blog-multi-column-layout-type'] ) ?
            $args['blog-multi-column-layout-type'] :
            $exopite_blog_multi_column_layout_type;
        $colum_layout = ( $blog_multi_column_layout_type == 'column' );
        $masonry_layout = ( $blog_multi_column_layout_type == 'masonry' );
        $show_filter_before_nth_item = apply_filters( 'exopite_filter_before_nth_item', 1 );
        $show_not_found = isset( $args['show_not_found'] ) ? $args['show_not_found'] : true;

        /**
         * Calculate row classes
         */
        $row_class = 'row';
        if ( ! $is_blog_first_full || ! $blog_first_full ) {

            // This class is required for masonry, card-column layout
            $row_class .= ' content-row';

            if ( $blog_no_gap ) $row_class .= ' gap';
            if ( $colum_layout ) $row_class .= ' card-columns';
            if ( $masonry_layout ) $row_class .= ' masonry-container';

        }

        /**
         * Start the output
         * loop        -> container for loop output, need by infinite load to identify content
         * row         -> need for the first blog post if it is full width
         * content-row -> to hold normal articles (blog posts), it is a class for infinite load
         */
        $page .= '<div id="loop" class="blog-container"><div class="' . $row_class . '">';
        $ignore_sticky_posts = false;

        if ( ! is_search() ) {

            /*
             * START Deal with sticky posts
             *
             * Include sticky post without adding them as extra top of the "Settings/Reading" "Blog pages show at most" value.
             */
            $include_sticky = true;

            // ignore sticky posts
            $args['query_args']['ignore_sticky_posts'] = 1;

            // Sticky post allowed only on post post type
            if ( $include_sticky ) {

                /*
                 * http://www.kriesi.at/support/topic/sticky-posts-in-b-og-grid/
                 */
                // Get sticky posts IDs
                $sticky = get_option( 'sticky_posts' );

                //Query posts without stickies.
                $sticky_args = $args['query_args'];
                $sticky_args['post__not_in'] = $sticky;
                $sticky_args['posts_per_page'] = -1;

                /*
                 * Get only post ids from query
                 *
                 * @link http://wordpress.stackexchange.com/questions/166029/get-post-ids-from-wp-query/166034#166034
                 */
                $sticky_args['fields'] = 'ids';

                $posts_query = new WP_Query( $sticky_args );
                $posts_ids = $posts_query->posts;

                // Merge posts and sticky posts IDs (if any)
                if ( is_array( $sticky ) && is_array( $posts_ids ) ) {
                    $posts_ids = array_merge( $sticky, $posts_ids );
                }

                $args['query_args']['post__in'] = $posts_ids;

                /*
                 * Order by queried post IDs
                 *
                 * This is important to display sticky on the front.
                 */
                $args['query_args']['orderby'] = 'post__in';

            }
            // END Deal with sticky posts
        }
        // Get query
        $wp_query = new  WP_Query( $args['query_args'] );

        /**
         *  The loop
         *
         * If we want to work with action hooks or Theme Hook Alliance,
         * then we need to start output buffering,
         * so we can display this loop via shortcodes as well.
         */
        ob_start();

        if ( $wp_query->have_posts() ) :

            // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
            wp_content_while_before();

            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $blog_first_full_is_current = ( $is_blog_first_full && $post_count == 1  );

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 *
                 * Based on multiple or single column
                 */
                if ( $multi_row ) {

                    include( locate_template( 'template-parts/content-multi-column.php' ) );

                } else {

                    include( locate_template( 'template-parts/content-single-column.php' ) );

                }

                /**
                 * Hook and filter do display something important after Xth posts item
                 *
                 * This hook mainly for displaying an advertisement.
                 *
                 * Use with the erliama_filter_before_nth_item filter,
                 * which contain the number of the specific post
                 * priority and function: 10 (include/template-functions.php)
                 */
                if ( $args['show_filter_before_nth_item'] && $show_filter_before_nth_item == $post_count ) {

                    exopite_hooks_posts_before_nth_excerpt_item();

                }

                /*
                 * If first post with is 100%/full in blog list option, then after first post
                 * in the first page start a new row.
                 *
                 * Add card-columns if mansory and multi-row
                 */
                if ( $blog_first_full_is_current ) :
                    $row_class = ( $colum_layout  ) ? ' card-columns' : '';

                    if ( $blog_no_gap ) $row_class .= ' no-gap-container';
                    if ( isset( $exopite_settings['exopite-blog-multi-column-layout-type'] ) &&
                         $exopite_settings['exopite-blog-multi-column-layout-type'] == 'masonry' )
                        $row_class .= ' masonry-container';

                    ?>
                        </div>
                        <div class="row content-row<?php echo $row_class; ?>">
                    <?php

                endif;

                $post_count++;

            endwhile;

            // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
            wp_content_while_after();

        else :

            if ( $show_not_found ) :

                get_template_part( 'template-parts/content', 'none' );

            endif;

        endif;

        $page .= ob_get_contents();

        ob_end_clean();

        $page .= '</div>'; // end row / content-row

        // Post navigation
        if ( $args['show_post_navigation'] === null || $args['show_post_navigation'] ) {
            $page .= get_the_posts_pagination( array(
                'mid_size' => 2,
                'prev_text' => wp_kses( __('<i class="fa fa-chevron-left" aria-hidden="true"></i>'), array( 'i' => array( 'class' => array(), 'aria-hidden' => array() ) ) ),
                'next_text' => wp_kses( __('<i class="fa fa-chevron-right" aria-hidden="true"></i>'), array( 'i' => array( 'class' => array(), 'aria-hidden' => array() ) ) ),
            ) );
        }

        wp_reset_query();
        wp_reset_postdata();

        $page .= '</div>'; // end loop
        return $page;

    }
}
