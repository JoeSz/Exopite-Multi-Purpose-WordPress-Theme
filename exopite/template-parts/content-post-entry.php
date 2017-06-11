<?php
/**
 * Template part for displaying posts, archives and search entry content.
 *
 * @package Exopite
 */
/**
 * ToDo:
 * - search highlight
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

// Display only if title and/or meta and/or content lenght is not none
if ( ! isset( $exopite_settings['exopite-blog-display-post-title'] ) ||
     ( $exopite_settings['exopite-blog-display-post-title'] ||
       $exopite_settings['exopite-blog-display-post-meta'] ||
       $exopite_settings['exopite-blog-post-content-lenght'] != 'none' ) ) :

?>
<div class="entry-content-container">
    <?php

    // Display header only if title and/or meta is enabled
    if ( ! isset( $exopite_settings['exopite-blog-display-post-title'] ) ||
         ( $exopite_settings['exopite-blog-display-post-title'] ||
           $exopite_settings['exopite-blog-display-post-meta'] ) ) :

        ?>
        <header class="entry-header">
            <?php

            /*
             * Display the title?
             */
            if ( ! isset( $exopite_settings['exopite-blog-display-post-title'] ) || $exopite_settings['exopite-blog-display-post-title'] ) {
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            }

            /*
             * Display the meta information like user/created date/category/tags/comment(s)/edit if logged in
             */
            if ( 'post' === get_post_type() &&
                 ( ! isset( $exopite_settings['exopite-blog-display-post-meta'] ) ||
                   $exopite_settings['exopite-blog-display-post-meta'] ) &&
                 ! $post_password_required ) :

                ?>
                <div class="entry-meta">
                    <?php exopite_post_meta(); // (include/template-function.php) ?>
                </div><!-- .entry-meta -->
                <?php
            endif;

            // Exopite hooks (include/exopite-hooks.php)
            exopite_hooks_posts_header();

            ?>
        </header><!-- .entry-header -->
        <?php

    endif; // Display entry-header

    // Display content only if lenght is not none
    if ( ! isset( $exopite_settings['exopite-blog-post-content-lenght'] ) ||
         $exopite_settings['exopite-blog-post-content-lenght'] != 'none' ) :

        // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
        tha_entry_content_before();

        ?>
        <div class="entry-content">
        <?php

        /*
         * If post is password protected, then show message and if excerpt on, then show "Read more" button
         */
        if ( $post_password_required ) : ?>
            <p>
                <?php _e( 'This post is password protected.', 'exopite' ); ?>
            </p>
            <?php
            if ( $exopite_settings['exopite-blog-post-content-lenght'] == 'excerpt' ) : ?>
                <p>
                    <a class="btn btn-material btn-readmore" href="<?php echo esc_url( get_permalink() ); ?>">Read More…</a>
                </p>
            <?php
            endif;

        else :

            /*
             * Display content, excerpt or none
             */
            $exopite_blog_post_content_lenght = ( isset ( $exopite_settings['exopite-blog-post-content-lenght'] ) ) ?
                $exopite_settings['exopite-blog-post-content-lenght'] :
                'full';

            switch ( $exopite_blog_post_content_lenght ) {
                case 'full':

                    echo apply_filters('the_content', get_the_content( sprintf(
                        /* translators: %s: Name of current post. */
                        wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'exopite' ), array( 'span' => array( 'class' => array() ) ) ),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    ) ) );

                    break;
                case 'excerpt':

                    // Here will come the search highlight function.
                    if ( is_search() ) {
                        //search_excerpt_highlight();
                        /*
                        $excerpt = get_the_excerpt();
                        $keys = implode('|', explode(' ', get_search_query()));
                        $excerpt = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $excerpt);
                        */
                        //echo "SEARCH<br>";
                    } else {
                        //echo get_the_excerpt();
                        //echo "NO SEARCH<br>";

                    }
                    echo get_the_excerpt();

                    break;
            }
            endif;
        ?>
        </div><!-- .entry-content -->
        <?php
    endif; // Display entry-content

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_entry_content_after(); ?>

</div><!-- .entry-content-container -->
<?php
endif; // Display entry-content-container
