<?php
/**
 * Helper functions
 * To call elsewhere in the theme (No hooks please!)
 *
 * @package Skamstrupfestival
 *
 */

namespace Skamstrupfestival\Theme;

/**
 * Special excerpt
 * Logic...
 * use custom excerpt if exists
 * elseif not check for and use 'read more' content
 * else use auto excerpt
 * @param int $post_id The id of the post
 */
function get_excerpt( $post_id = false ) {
	if ( ! $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$more_link = ' <a href="' . get_permalink( $post_id ) . '" class="read-more">' . __( 'Read more', THEMEDOMAIN ) . '</a>';
	$more_link = apply_filters( THEMEDOMAIN . '_excerpt_more_link', $more_link );

	// If we hook in
	$excerpt = apply_filters( THEMEDOMAIN . '_excerpt', false );

	if ( $excerpt ) {
		$excerpt = wp_trim_words( $excerpt, 20 );
	} elseif ( has_excerpt( $post_id ) ) {                  // If the post has an excerpt
		$excerpt = wp_trim_words( get_the_excerpt(), 30 );
	} elseif ( has_more() ) {                               // If we have a show more tag
		$excerpt = wp_trim_words( get_the_excerpt(), 30 );
	} elseif ( is_archive() || is_home() || is_search() ) { // On archive pages, default to first paragraph
		$excerpt = wp_trim_words( get_the_excerpt(), 30 );
	} else {                                                // Everywhere else don't show anything
		$excerpt = '';
	}
	return wpautop( $excerpt );
}

function excerpt() {
	echo get_excerpt();
}

function get_first_paragraph( $content ) {
	$content = wpautop( $content );

	$start = strpos( $content, '<p>' );
	$end   = strpos( $content, '</p>', $start );

	return wp_strip_all_tags( substr( $content, $start, $end - $start + 4 ) );
}

/**
 * Checks a post to see if it has a read more tag
 */
function has_more() {
	global $post;

	if ( isset( $post->post_content ) ) {
		return (bool) preg_match( '/<!--more(.*?)-->/', $post->post_content );
	}

	return false;
}

/**
 * adds inline css, taking an array of string of css rules. if using an array, use following structure. if string, just a normal css string.
 * This can be called inside shortcodes, widgets ect, where normal enque_style would work.
 * $css_array = [
 *      '.element-selector' => [
 *          'background-size' => 'contain',
 *      ],
 *  ];
 *
 * @param mixed:array|string $css
 * @param string $hook
 * @return bool
 */
function add_inline_css( $css = [], $handle = '' ) {

	if ( is_array( $css ) ) {
		$css_string = css_array_to_css( $css );
	} else {
		$css_string = $css;
	}

	if ( '' == $handle ) {
		$handle = THEMEDOMAIN;
	}

	$handle .= '-' . wp_hash( $css_string );

	wp_register_style( $handle, false );
	wp_enqueue_style( $handle );
	wp_add_inline_style( $handle, $css_string );

	return true;
}

/**
 * Converts an array to css rules
 *  $css_array = [
 *      '.element-selector' => [
 *          'background-size' => 'contain',
 *      ],
 *  ];
 *
 * @param array $rules
 * @param integer $indent
 * @return string
 */
function css_array_to_css( $rules, $indent = 0 ) {

	$css    = '';
	$prefix = str_repeat( '  ', $indent );
	foreach ( $rules as $key => $value ) {
		if ( is_array( $value ) ) {
			$selector   = $key;
			$properties = $value;

			$css .= $prefix . "$selector {\n";
			$css .= $prefix . css_array_to_css( $properties, $indent + 1 );
			$css .= $prefix . "}\n";
		} else {
			$property = $key;
			$css     .= $prefix . "$property: $value;\n";
		}
	}

	return $css;
}

/**
 * Find the primary term. - if no primary is found use first found, and if no, then the default term
 *
 * @param mixed $post
 * @return object
 */
function get_primary_category( $post = null ) : object {
	$post = get_post( $post );

	$yoast_primary_category_id = get_post_meta( $post->ID, '_yoast_wpseo_primary_category', true );

	if ( $yoast_primary_category_id ) {
		$term = get_term( $yoast_primary_category_id );
		if ( $term && ! is_wp_error( $term ) ) {
			return $term;
		}
	}

	$terms = (array) get_the_category( $post->ID );

	// Primary category not found. return first term;
	foreach ( $terms as $term ) {
		return $term;
	}

	// Terms was empty. - can happen after migrations, and programmatically creation of posts.
	// Find "default" term
	$default_category = get_option( 'default_category' );
	return get_term( $default_category );
}
