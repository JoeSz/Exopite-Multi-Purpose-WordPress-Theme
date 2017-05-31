<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exopite
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_entry_before();

?>
<section class="no-results not-found">
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_entry_top();

    ?>
	<header class="page-header">
		<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'exopite' ); ?></h2>
	</header><!-- .page-header -->
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_entry_content_before();

    ?>
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

            ?>
            <div class="row">
                <div class="col-12 text-center">
                    <p><?php printf( esc_attr__( 'Ready to publish your first post? %1$sGet started here%2$s.', 'exopite' ), '<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">', '</a>' ); ?></p>
                </div>
            </div>
		    <?php

        elseif ( is_search() ) :

            ?>
            <div class="row">
                <div class="col-12 text-center">
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'exopite' ); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 offset-md-4">
                    <?php

                    get_search_form();

                    ?>
                </div>
            </div>
            <?php

		else :

            ?>
            <div class="row">
                <div class="col-12 text-center">
                    <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'exopite' ); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 offset-md-4">
                    <?php

                    get_search_form();

                    ?>
                </div>
            </div>
            <?php

		endif; ?>
	</div><!-- .page-content -->
	<?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_entry_content_after();
    tha_entry_bottom();

    ?>
</section><!-- .no-results -->
<?php

// Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
tha_entry_after();
