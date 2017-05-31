<?php
/**
 * Erliama search form
 *
 * Source: http://buildwpyourself.com/wordpress-search-form-template/
 */
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

?>
<form role="search" method="get" id="search-form" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group search-widget">
		<input type="text" class="form-control" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
        <input type="hidden" name="post_type" value="<?php echo get_post_type(); ?>" />
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit" value="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
		</span>
    </div><!-- /input-group -->
</form>
