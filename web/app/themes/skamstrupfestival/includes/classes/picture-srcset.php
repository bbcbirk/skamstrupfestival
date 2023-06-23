<?php
/**
 * Custom picture sources for responsive images.
 *
 * @package Skamstrupfestival
 *
 */

namespace Skamstrupfestival\Theme;

// Do not access this file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PictureSrcset {

	public function __construct() {
		add_filter( 'post_thumbnail_html', [ __CLASS__, 'image_add_picture_element' ], 9999, 5 );
	}

	/**
	 * Change the markup of an image to a picture.
	 * Only works on images where a data-picture attribute is set.
	 *
	 * @param string       $html              The post thumbnail HTML.
	 * @param int          $post_id           The post ID.
	 * @param string       $post_thumbnail_id The post thumbnail ID.
	 * @param string|array $size              The post thumbnail size.
	 * @param string       $attr              String of html attributes.
	 */
	public static function image_add_picture_element( $html, $post_id, $post_thumbnail_id, $size, $attr ) {

		// return early if there is no data-picture attribute
		if ( empty( $attr['data-picture'] ) ) {
			return $html;
		}

		// Get source schema.
		$schema = apply_filters( 'skamstrupfestival_picture_sources', [] );

		// Check for relevant definition.
		if ( empty( $schema[ $attr['data-picture'] ] ) ) {
			return $html;
		}

		// Set image class if set in $attr
		if ( ! empty( $attr['data-picture-image-class'] ) ) {
			$html = str_replace( 'class="', 'class="' . $attr['data-picture-image-class'] . ' ', $html );
		}

		$source_html = '';

		// Add each image source
		foreach ( $schema[ $attr['data-picture'] ] as $source ) {

			// add media
			$media = ( ! empty( $source['media'] ) ) ? ' media="' . $source['media'] . '"' : '';

			// Add srcset
			$srcset_array = [];
			foreach ( $source['srcset'] as $src ) {
				$url            = wp_get_attachment_image_url( $post_thumbnail_id, $src['size'] );
				$srcset_array[] = sprintf( '%s %s%s', $url, $src['value'], $src['descriptor'] );
			}
			$srcset = sprintf( ' srcset="%s"', implode( ', ', $srcset_array ) );

			// Add sizes
			$sizes = ( ! empty( $source['sizes'] ) ) ? sprintf( ' sizes="%s"', $source['sizes'] ) : '';

			// Add source tag
			$source_html .= sprintf( '<source%s%s%s />', $media, $srcset, $sizes );
		}

		// Set picture class if sent in $attr
		$picture_class = ! empty( $attr['data-picture-class'] ) ? $attr['data-picture-class'] : '';

		// Build picture html
		$string = $picture_class ? '<picture class="' . $picture_class . '">%s%s</picture>' : '<picture>%s%s</picture>';

		// Wrap html in picture element
		return sprintf( $string, $source_html, $html );
	}

}
