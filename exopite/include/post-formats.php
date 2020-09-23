<?php
// Exit if accessed directly
defined('ABSPATH') or die( 'You cannot access this page directly.' );

/**
 * VIDEO POST TYPE AND METABOX
 */
/**
 * Register meta box(es).
 */
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );
function wpdocs_register_meta_boxes() {
	$post_format = get_post_format();
	switch ( $post_format ) {
		case 'video':
			add_meta_box( 'meta-box-id', esc_attr__( 'Featured Video', 'exopite' ), 'exopite_override_features_media_callback', 'post', 'side', 'low' );
			break;
		case 'audio':
			add_meta_box( 'meta-box-id', esc_attr__( 'Featured Audio', 'exopite' ), 'exopite_override_features_media_callback', 'post', 'side', 'low' );
			remove_meta_box( 'postimagediv', 'post.php', 'side' );
			break;
	}
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
if ( ! function_exists( 'exopite_override_features_media_callback' ) ) {
	function exopite_override_features_media_callback( $post ) {

		// Display code/markup goes here. Don't forget to include nonces!

		$post_format = get_post_format();
		$media_url = '';
		$button = '';

		switch ( $post_format ) {
			case 'video':
				$media_url = esc_url( get_post_meta( $post->ID,'media_thumbnail', true ) );
				$button = esc_attr__( 'Choose a Video', 'exopite' );
				break;
			case 'audio':
				$media_url = esc_url( get_post_meta( $post->ID,'media_thumbnail', true ) );
				$button = esc_attr__( 'Choose an Audio', 'exopite' );
				break;
		}

		?>
		<div id="featured-media-meta-box">
			<label for="media_URL">
				<input id="media_URL" type="text" size="36" name="media_URL" value="<?php echo $media_url; ?>" />
				<input id="upload_media_button" class="button" data-media-type="<?php echo $post_format; ?>" type="button" value="<?php echo $button; ?>" />

				<p class="howto">
					<?php
						if ( $post_format == 'video' ) {
							esc_attr_e( 'Choose a video from the media library or paste and url (eg. youtube)', 'exopite' );
						} elseif ( $post_format == 'audio' ) {
							esc_attr_e( 'Choose an andio from the media library', 'exopite' );
						}

						esc_attr_e( ' then, update your post/page to save it.', 'exopite' );
					?>
				</p>
				<?php
				if ( $post_format == 'video' ) :
					?>
						<p class="howto">
							<?php esc_attr_e( 'If you have selected featured image, that will be the poster of the video.', 'exopite' ); ?>
						</p>
					<?php

					$site_url = get_site_url();
					if ( substr( $media_url, 0, strlen( $site_url ) ) == $site_url ||
						substr( $site_url, 0, 12 ) == '/wp-content/' ) :
						?>
						<video class="video" controls>
							<source src="<?php echo $media_url; ?>" type="video/mp4" id="vidsrc">
							Your browser does not support HTML5 video.
						</video>
						<?php
					else:
						echo wp_oembed_get( $media_url, array( 'width' => 255 ) );
					endif;

				endif;

				?>
			</label>
		</div>
		<?php
	}
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
add_action( 'save_post', 'wpdocs_save_meta_box' );
function wpdocs_save_meta_box( $post_id ) {

	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( isset( $_POST['media_URL'] ) ) {
		update_post_meta( $post_id, 'media_thumbnail', esc_url( $_POST['media_URL'] ) );
	}

}
