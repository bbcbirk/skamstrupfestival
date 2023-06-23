<?php
/**
 * @package Skamstrupfestival
 *
 */

namespace Skamstrupfestival\Theme;

// Do not access this file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HeroVideo {

	public function __construct() {
		add_filter( 'video_html', [ __CLASS__, 'hero_add_video_element' ], 9999, 5 );
	}

	/**
	 * Make the markup of an video.
	 * Only works on images where a data-video attribute is set.
	 *
	 * @param string       $html              The video HTML.
	 * @param int          $attachment_id     The video ID.
	 * @param string       $attr              String of html attributes.
	 */
	public static function hero_add_video_element( $html, $attachment_id, $attr ) {

		// return early if there is no data-video attribute
		if ( empty( $attr['data-video'] ) ) {
			return $html;
		}

		/**
		 * Build Src
		 */
		$source_html = '';

		// Add src
		$video_src = ! empty( wp_get_attachment_url( $attachment_id ) ) ? ' src="' . wp_get_attachment_url( $attachment_id ) . '"' : '';

		// Add mime type
		$video_mime = ! empty( get_post_mime_type( $attachment_id ) ) ? ' type="' . get_post_mime_type( $attachment_id ) . '"' : '';

		// Add source tag
		$source_html .= sprintf( '<source%s%s />', $video_src, $video_mime );

		/**
		 * Build Video
		 */
		// Set video class if sent in $attr
		$video_class  = isset( $attr['data-video-class'] ) && ! empty( $attr['data-video-class'] ) ? ' class="' . $attr['data-video-class'] . '"' : '';
		$figure_class = isset( $attr['data-figure-class'] ) && ! empty( $attr['data-figure-class'] ) ? ' class="' . $attr['data-figure-class'] . '"' : '';

		// Video Attributes
		$autoplay = isset( $attr['autoplay'] ) && ! empty( $attr['autoplay'] ) ? ' autoplay' : '';
		$muted    = isset( $attr['muted'] ) && ! empty( $attr['muted'] ) ? ' muted' : '';
		$loop     = isset( $attr['loop'] ) && ! empty( $attr['loop'] ) ? ' loop' : '';

		// Wrap html in video element
		return sprintf( '<figure%s><video%s%s%s%s%s></video></figure>', $figure_class, $autoplay, $muted, $loop, $video_class, $video_src );
	}

}
