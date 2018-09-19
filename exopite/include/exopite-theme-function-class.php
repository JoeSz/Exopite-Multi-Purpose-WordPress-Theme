<?php

if ( ! class_exists( 'Exopite_Theme_Functions' ) ) {
	class Exopite_Theme_Functions {

		public static $options;

		public static function init() {

			self::$options = get_option( 'exopite_options' );

		}

		public static function get_sidebar_content_ratio() {

			$exopite_sidebar_ratio = intval( self::$options['exopite-sidebar-ratio'] );

			if ( ! isset( $exopite_sidebar_ratio ) ||
				! is_numeric( $exopite_sidebar_ratio ) ||
				( $exopite_sidebar_ratio < 1 || $exopite_sidebar_ratio > 6 )
				) {

				$exopite_sidebar_ratio = 3;

			}

			return array(
				'sidebar' => $exopite_sidebar_ratio,
				'content' => ( 12 - $exopite_sidebar_ratio ),
			);

		}

		public static function get_content_classes( $post_id, $extra_classes = array() ) {

			$post_type = get_post_type( $post_id );

			if ( $post_type != 'page' ) {
				$post_type = 'post';
			}

			$exopite_meta_data = get_post_meta( $post_id, 'exopite_custom_' . $post_type . '_options', true );

			$classes = array();

			if ( isset( $exopite_meta_data['exopite-meta-sidebar-layout'] ) &&
				 $exopite_meta_data['exopite-meta-sidebar-layout'] != 'exopite-meta-sidebar-none'
			   ) {

				$classes[] = 'col-md-' . self::get_sidebar_content_ratio()['content'];

			} else {
				$classes[] = 'col-md-12';
			}

			if ( ! is_array( $extra_classes ) ) {
				$extra_classes = explode( ' ', $extra_classes );
			}

			$classes = array_filter( array_merge( $classes, $extra_classes ) );

			/**
			 * Remove multiple whitespaces.
			 */
			return preg_replace( '/\s+/', ' ', implode( ' ', $classes ) );

		}

	}
}