<?php
/**
 * The full page search for our theme.
 *
 * @package Exopite
 *
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

?>
<!-- Full-search -->
<div class="full-search">
    <div class="search-inner">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input id="full-search-field" class="search-field title-font" placeholder="<?php echo esc_attr( 'Search…', 'exopite' ); ?>" value="" name="s" type="text">
            <div class="search-submit">
                <i class="fa fa-search"></i>
            </div>
            <input type="hidden" name="post_type" value="<?php echo get_post_type(); ?>" />
            <input class="search-submit" value="Search" type="submit" style="opacity: 0;">
            <div class="search-close">
                <i class="fa fa-times"></i>
            </div>
        </form>
    </div>
</div>
<!-- End full-search -->
