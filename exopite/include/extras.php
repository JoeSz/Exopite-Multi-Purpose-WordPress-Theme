<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Exopite
 *
 * Functions:
 *  - esc_variable (pluggable)
 *  - conditional statements for browser and OS detections
 *  - exopite_body_classes (pluggable)
 *  - exopite_post_nav (pluggable)
 *  - exopite_display_releated_posts (pluggable)
 *  - exopite_releated_posts (pluggable)
 *
 */

/**
 * Escape variable
 *
 * Create variable from a "title"
 */
if ( ! function_exists( 'esc_variable' ) ) {
    function esc_variable( $variable ) {

        $variable = esc_html( $variable );

        //Lower case everything
        $variable = strtolower( $variable );

        //Make alphanumeric (removes all other characters)
        $variable = preg_replace("/[^a-z0-9_\s-]/", "", $variable );

        //Clean up multiple dashes or whitespaces
        $variable = preg_replace("/[\s-]+/", " ", $variable );

        //Convert whitespaces and underscore to dash
        $variable = preg_replace("/[\s_]/", "-", $variable);

        return $variable;

    }
}

/*
 * Add conditional statements
 * @link: https://clicknathan.com/web-design/wordpress-mobile-conditional-statement/
 */
function is_ipad() { // if the user is on an iPad
    $is_ipad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
    if ($is_ipad)
        return true;
    else return false;
}
function is_ios() { // if the user is on any iOS Device
    global $is_iphone;
    if ( $is_iphone || is_ipad() || is_ipod() )
        return true;
    else return false;
}
function is_android() { // detect ALL android devices
    $is_android = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
    if ( $is_android )
        return true;
    else return false;
}
function is_android_mobile() { // detect only Android phones
    $is_android   = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
    $is_android_m = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile');
    if ( $is_android && $is_android_m )
        return true;
    else return false;
}
function is_android_tablet() { // detect only Android tablets
    global $is_iphone;
    if ( is_android() && !is_android_mobile() )
        return true;
    else return false;
}
function is_mobile_device() { // detect Android Phones, iPhone or iPod
    global $is_iphone;
    if ( is_android_mobile() || $is_iphone )
        return true;
    else return false;
}
function is_tablet() { // detect Android Tablets and iPads
    if ( ( is_android() && !is_android_mobile() ) || is_ipad() )
        return true;
    else return false;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
add_filter( 'body_class', 'exopite_body_classes' );
if ( ! function_exists( 'exopite_body_classes' ) ) {
	function exopite_body_classes( $classes ) {

        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $is_edge;

        global $post;
        $post_slug = ( isset( $post->post_name ) ) ? $post->post_name : '';

        $classes[] = get_post_type() . '-' . $post_slug;

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

        if ( has_post_thumbnail() ) $classes[] = 'has-post-thumbnail';

        /**
         * Display browser engine name as class in body
         *
         * @link https://www.smashingmagazine.com/2009/08/10-useful-wordpress-hook-hacks/
         */
        if ( ! is_admin() ) {
            if( $is_lynx ) $classes[] = 'lynx';
            elseif( $is_gecko ) $classes[] = 'gecko';
            elseif( $is_opera ) $classes[] = 'opera';
            elseif( $is_NS4 ) $classes[] = 'ns4';
            elseif( $is_safari ) $classes[] = 'safari';
            elseif( $is_chrome ) $classes[] = 'chrome';
            elseif( $is_IE ) $classes[] = 'ie';
            elseif( $is_edge ) $classes[] = 'edge';
            else $classes[] = 'unknown';

            if ( is_mobile_device() ) {
                $classes[] = 'mobile';
                if( $is_iphone ) $classes[] = 'iphone';
                elseif( is_android() ) $classes[] = 'android';
            } elseif ( is_tablet() ) {
                $classes[] = 'tablet';
                if ( is_android_tablet() ) $classes[] = 'android-tablet';
                if ( is_ipad() ) $classes[] = 'ipad';
            }
        }

		return $classes;
	}
}

/**
 * Diplay post navigation on a single post
 */
add_action( 'exopite_hooks_post_footer', 'exopite_post_nav', 25 );
if ( ! function_exists( 'exopite_post_nav' ) ) {
	function exopite_post_nav() {

		$exopite_settings = get_option( 'exopite_options' );

		$in_same_term = $exopite_settings['exopite-single-navigation-same-term'];
		$is_infinite = $exopite_settings['exopite-single-navigation-inifnite'];

		if ( $in_same_term ) {

			// Get current post categories
			$categories = get_the_category();
			$categories_array = array();
			foreach ($categories as $category) {
				$categories_array[] = $category->term_id;
			}
			$categories_string = implode(",", $categories_array);

		}

	    $prev_post = get_previous_post( $in_same_term );
	  	if ( isset ( $prev_post->ID ) ) {

	  		$prev_post_id = $prev_post->ID;
	  		$prev_post_text = esc_attr__( 'Previous post', 'exopite' );

		} else {

			if ( $is_infinite ) {

				// Inifnite loop, after last post, jump to first and vice versa
				// Source: http://wplancer.com/infinite-next-and-previous-post-looping-in-wordpress/
			    $last = ( $in_same_term ) ?
                    new WP_Query('posts_per_page=1&category__in='.$categories_string.'&order=DESC') :
                    new WP_Query('posts_per_page=1&order=DESC');

			    $last->the_post();
			    $prev_post_id = get_the_id();
			  	wp_reset_query();
			  	$prev_post_text = esc_attr__('Last post', 'exopite');

		  	} else {

		  		$prev_post_id = '';

		  	}

		}

	    $next_post = get_next_post($in_same_term);
	  	if ( isset ( $next_post->ID ) ) {

	  		$next_post_id = $next_post->ID;
	  		$next_post_text = esc_attr__('Next post', 'exopite');

		} else {

			if ( $is_infinite ) {

				$first = ( $in_same_term ) ?
                    new WP_Query('posts_per_page=1&category__in='.$categories_string.'&order=ASC') :
                    new WP_Query('posts_per_page=1&order=ASC');
				$first->the_post();
		    	$next_post_id = get_the_id();
		    	wp_reset_query();
		    	$next_post_text = esc_attr__('First post', 'exopite');

	    	} else {

	    		$next_post_id = '';

	    	}

		}

		if ( $prev_post_id == get_the_id() ) $prev_post_id = ''; // Do not display the current page
		if ( $next_post_id == get_the_id() ) $next_post_id = '';
		if ( $prev_post_id == $next_post_id ) $next_post_id = ''; // If only 2 posts in category, do not display two times

		// Don't display row if no next, previous, first or last post exist
		if ( ($prev_post_id != '' ) || ($next_post_id != '' )  ) : ?>
			<div class="exopite-single-post-navigation" role="navigation">
				<div class="row">
					<div class="col-12">
						<h3><?php esc_attr_e( 'Post navigation', 'exopite' ); ?></h3>
					</div>
				</div>
				<div class="row">
					<div id="prev" class="col-12 col-sm-6">
						<?php

                        if ($prev_post_id != '' ) :

                        ?>
							<a href="<?php echo get_the_permalink($prev_post_id); ?>" rel="previous" class="secondary-box">
								<i class="fa fa-angle-left" aria-hidden="true"></i>
								<?php

                                if ( has_post_thumbnail( $prev_post_id ) ) :

								   	echo get_the_post_thumbnail( $prev_post_id, array( 80,80 ), array( 'class' => 'animation' ) );

								else:

                                    ?>
    								<img src="http://dummyimage.com/80x80/616161/ffffff.jpg&text=<?php esc_attr_e( 'Prev', 'exopite' ); ?>" class="animation" alt="prev">
    								<?php

                                endif;

                                ?>
								<div class="single-post-nav-title">
									<div class="single-post-navigation"><?php echo $prev_post_text; ?></div>
									<p class="single-post-navigation-title"><?php echo get_the_title($prev_post_id); ?></p>
								</div>
							</a>
						<?php

                        endif;

                        ?>
					</div>

					<div id="next" class="col-12 col-sm-6">
						<?php

                        if ($next_post_id != '' ) :

                            ?>
							<a href="<?php echo esc_url( get_the_permalink( $next_post_id ) ); ?>" rel="next" class="secondary-box">
								<i class="fa fa-angle-right" aria-hidden="true"></i>
								<?php

                                if ( has_post_thumbnail( $next_post_id ) ) :

							    	echo get_the_post_thumbnail( $next_post_id, array( 80,80 ), array( 'class' => 'animation' ) );

								else:

                                    ?>
    								<img src="http://dummyimage.com/80x80/616161/ffffff.jpg&text=<?php esc_attr_e( 'Next', 'exopite' ); ?>" class="animation" alt="next">
    								<?php

                                endif;

                                ?>
								<div class="single-post-nav-title">
									<div class="single-post-navigation"><?php echo $next_post_text; ?></div>
									<p class="single-post-navigation-title"><?php echo get_the_title($next_post_id); ?></p>
								</div>
						    </a>
						<?php

                        endif;

                        ?>
					</div>
				</div>
			</nav>
		<?php endif;
	}
}

/**
 * Diplay releated posts by categories and tags on a single post
 */
add_action( 'exopite_hooks_post_footer', 'exopite_display_releated_posts', 30 );
if ( ! function_exists( 'exopite_display_releated_posts' ) ) {
	function exopite_display_releated_posts() {

		$exopite_settings = get_option( 'exopite_options' );

		exopite_releated_posts(
			array(
				'categories_amount'         => $exopite_settings['exopite-single-releated-posts-categories-amount'],
				'categories_per_row'        => $exopite_settings['exopite-single-releated-posts-categories-per-row'],
				'categories_title'          => esc_attr__( 'You might also like:', 'exopite' ),
				),
			array(
				'tags_amount'         => $exopite_settings['exopite-single-releated-posts-tags-amount'],
				'tags_per_row'        => $exopite_settings['exopite-single-releated-posts-tags-per-row'],
				'tags_title'          => esc_attr__( 'You might also like:', 'exopite' ),
				)
			);
	}
}

if ( ! function_exists( 'exopite_releated_posts' ) ) {
	function exopite_releated_posts( $categories, $tags ) {

		global $post;

		// Exit if nothing to show
		if ( ( empty( $tags ) ) || ( empty( $categories ) ) ) return;
		if ( ( ! is_array( $tags ) ) || ( ! is_array( $categories ) ) ) return;

		// Defaults
		$tags_amount = 0;
		$tags_per_row = 0;  //(1-4)
		$tags_title = '';
        $tags_show_title = true;
        $tags_show_exceprt = true;
        $tags_excerpt_length = 10;
        $tags_excerpt_end = '...';
        $tags_thumbnail_size = 'releated';

		$categories_amount = 0;
		$categories_per_row = 0; //(1-4)
		$categories_title = '';
        $categories_show_title = true;
        $categories_show_exceprt = true;
        $categories_excerpt_length = 10;
        $categories_excerpt_end = '...';
        $categories_thumbnail_size = 'releated';

		// Convert user input
		if( isset( $tags['tags_amount'] ) ) $tags_amount = intval( esc_attr( $tags['tags_amount'] ) );
		if( isset( $tags['tags_per_row'] ) ) $tags_per_row = intval( esc_attr( $tags['tags_per_row'] ) );
		if( isset( $tags['tags_title'] ) ) $tags_title = esc_attr( $tags['tags_title'] );
        if( isset( $tags['tags_show_title'] ) ) $tags_show_title = esc_attr( $tags['tags_show_title'] );
        if( isset( $tags['tags_show_exceprt'] ) ) $tags_show_exceprt = esc_attr( $tags['tags_show_exceprt'] );
        if( isset( $tags['tags_excerpt_length'] ) ) $tags_excerpt_length = intval( esc_attr( $tags['tags_excerpt_length'] ) );
        if( isset( $tags['tags_excerpt_end'] ) ) $tags_excerpt_end = esc_attr( $tags['tags_excerpt_end'] );
        if( isset( $tags['tags_thumbnail_size'] ) ) $tags_thumbnail_size = esc_attr( $tags['tags_thumbnail_size'] );

		if( isset( $categories['categories_amount'] ) ) $categories_amount = intval( esc_attr( $categories['categories_amount'] ) );
		if( isset( $categories['categories_per_row'] ) ) $categories_per_row = intval( esc_attr( $categories['categories_per_row'] ) );
		if( isset( $categories['categories_title'] ) ) $categories_title = esc_attr( $categories['categories_title'] );
        if( isset( $categories['categories_show_title'] ) ) $categories_show_title = esc_attr( $categories['categories_show_title'] );
        if( isset( $categories['categories_show_exceprt'] ) ) $categories_show_exceprt = esc_attr( $categories['categories_show_exceprt'] );
        if( isset( $categories['categories_excerpt_length'] ) ) $categories_excerpt_length = intval( esc_attr( $categories['categories_excerpt_length'] ) );
        if( isset( $categories['categories_excerpt_end'] ) ) $categories_excerpt_end = esc_attr( $categories['categories_excerpt_end'] );
        if( isset( $categories['categories_thumbnail_size'] ) ) $categories_thumbnail_size = esc_attr( $categories['categories_thumbnail_size'] );

		// Make sure, column is not bigger then 4
		if ( $tags_per_row > 4 ) $tags_per_row = 4;
		if ( $categories_per_row > 4 ) $categories_per_row = 4;

        // Add Bootstrap cols
		if ( $tags_per_row > 0 && $tags_amount > 0 ) :

			switch ($tags_per_row) {
				case 2:
					$tags_bootstrap_column = 'col-12 col-sm-6 col-md-6 col-lg-6';
					break;
				case 3:
					$tags_bootstrap_column = 'col-12 col-sm-6 col-md-4 col-lg-4';
					break;
				case 4:
					$tags_bootstrap_column = 'col-6 col-sm-6 col-md-4 col-lg-3';
					break;
				default:
					$tags_bootstrap_column = 'col-12 col-sm-12 col-md-12 col-lg-12';
					break;
			}

			// Get post tags
		    $tags = wp_get_post_tags($post->ID);

		    if ($tags) {

		    	// Get IDs from tag objects
			    $tag_ids = array();
			    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

			    // Set query args and run query
			    $args=array(
				    'tag__in'               => $tag_ids,
				    'post__not_in'          => array( $post->ID ),
				    'posts_per_page'        => $tags_amount, // Number of related posts to display.
				    'ignore_sticky_posts'   => 1
			    );
			    $my_query = new wp_query( $args );

			    // If any posts, then loop then trough
			    if ( $my_query->have_posts() ):

                    ?>
					<div class="row exopite-releated-posts-by-tags">
						<div class="col-12">
				    		<h3><?php echo $tags_title; ?></h3>
				    	</div>
				    <?php

                    while( $my_query->have_posts() ) :

					    $my_query->the_post();
					    ?>
						<div class="<?php echo $tags_bootstrap_column; ?>">
							<div class="related-posts secondary-box">
								<div class="related-thumb clearfix">
								<?php

                                // If has thumbnail, display it, if not, display dummy image
                                if ( has_post_thumbnail() ) :

                                    ?>
									<a href="<?php the_permalink(); ?>"><?php echo exopite_create_effect_image_frame( get_the_post_thumbnail( get_the_ID(), $tags_thumbnail_size ), get_the_title() ); ?></a>
								    <?php

                                else:

                                    ?>
									<a href="<?php the_permalink(); ?>"><?php
										$dummy_img = '<img src="http://dummyimage.com/300x200/616161/ffffff.jpg&text=' . get_the_title() . '" alt="title">';
										echo exopite_create_effect_image_frame( $dummy_img, get_the_title() );
										?></a>
								    <?php

                                endif;

                                ?>
								</div>
                                <?php

                                // Show title
                                if ( $tags_show_title ) :

                                    ?>
    								<div class="related-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
                                    <?php

                                endif;

                                // Show excerpt
                                if ( $tags_show_exceprt ) :

                                    ?>
                                    <div class="releated-excerpt"><?php

                                        /*
                                         * template-parts/the_excerpt.php
                                         * get_custom_excerpt( $input, $lenght = 20, $allow_tags = true, $allow_line_breaks = true, $excerpt_end = '', $force = false )
                                         */
                                        echo get_custom_excerpt( get_the_content(), $tags_excerpt_length, true, false, $tags_excerpt_end, true );
                                    ?></a></div>
                                    <?php

                                endif;

                                ?>
							</div>
						</div>
			    	    <?php

				    endwhile;

				    ?>
				    </div>
				    <?php

			    endif;
		    }

	        wp_reset_query();

		endif;

		if ( ( $categories_per_row > 0 ) && ( $categories_amount > 0 ) ):

			switch ($categories_per_row) {
				case 2:
					$category_bootstrap_column = 'col-12 col-sm-6 col-md-6 col-lg-6 margin-bottom-15';
					break;
				case 3:
					$category_bootstrap_column = 'col-12 col-sm-6 col-md-4-sidebar col-lg-4 margin-bottom-15';
					break;
				case 4:
					$category_bootstrap_column = 'col-6 col-sm-6 col-md-4-sidebar col-lg-3 margin-bottom-15';
					break;
				default:
					$category_bootstrap_column = 'col-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-15';
					break;
			}

		    $categories_to_display = get_the_category($post->ID);

		    if ($categories_to_display) {

			    $categories_ids = array();
			    foreach($categories_to_display as $individual_category) $category_ids[] = $individual_category->term_id;

			    $args=array(
    			    'category__in' => $category_ids,
    			    'post__not_in' => array($post->ID),
    			    'posts_per_page'=> $categories_amount, // Number of related posts to display.
    			    'ignore_sticky_posts'=>1,
			    );
			    $my_query = new wp_query( $args );

			    if ( $my_query->have_posts() ):

                    ?>
				    <div class="row exopite-releated-posts-by-categories">
				    	<div class="col-12">
				    		<h3><?php echo $categories_title; ?></h3>
				    	</div>
				    <?php

                    while( $my_query->have_posts() ) :

					    $my_query->the_post();
				    	?>
						<div class="<?php echo $category_bootstrap_column; ?>">
							<div class="related-posts secondary-box">
								<div class="related-thumb clearfix">
								<?php

                                if ( has_post_thumbnail() ) :

                                    ?>
									<a href="<?php the_permalink(); ?>"><?php echo exopite_create_effect_image_frame( get_the_post_thumbnail( get_the_ID(), $categories_thumbnail_size ), get_the_title() ); ?></a>
								    <?php

                                else:

                                    ?>
									<a href="<?php the_permalink(); ?>"><?php
										$dummy_img = '<img src="http://dummyimage.com/300x200/616161/ffffff.jpg&text=' . get_the_title() . '" alt="title">';
										echo exopite_create_effect_image_frame( $dummy_img, get_the_title() );
										?></a>
								    <?php

                                endif;

                                ?>
								</div>
                                <?php

                                // Show title
                                if ( $categories_show_title ) :

                                    ?>
    								<div class="related-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
                                    <?php

                                endif;

                                // Show excerpt
                                if ( $categories_show_exceprt ) :

                                    ?>
    								<div class="releated-excerpt"><?php

                                        /*
                                         * template-parts/the_excerpt.php
                                         * get_custom_excerpt( $input, $lenght = 20, $allow_tags = true, $allow_line_breaks = true, $excerpt_end = '', $force = false )
                                         */
                                        echo get_custom_excerpt( get_the_content(), $categories_excerpt_length, true, true, $categories_excerpt_end, true );
                                    ?></a></div>
                                    <?php

                                endif;

                                ?>
							</div>
						</div>
				    	<?php

                    endwhile;

                    ?>
				    </div>
				    <?php

			    endif;

		    }

		    wp_reset_query();

		endif;
	}
}
