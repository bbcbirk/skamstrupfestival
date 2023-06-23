<?php
/**
 * Hooks for the frontend
 *
 * @package Skamstrupfestival
 *
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference
 */

namespace Skamstrupfestival\Theme;

/**
 * Add taxonomy class to the body tag.
 */
function body_classes( $classes ) {
	global $post;

	if ( isset( $post ) && isset( $post->post_type ) ) {
		$classes[] = $post->post_type;
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	if ( is_tax() ) {
		$classes[] = 'taxonomy';
	}

	return $classes;
}

add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );

/**
 * Redirect attachments to their attachment page.
 * If no parent is found it will redirect to the full size of the image.
 */
function attachment_redirect() {
	if ( ! is_attachment() ) {
		return;
	}

	$parent   = wp_get_post_parent_id( get_the_ID() );
	$redirect = $parent ? get_the_permalink( $parent ) : get_the_guid( get_the_ID() );

	wp_redirect( $redirect );
	exit;
}

add_action( 'template_redirect', __NAMESPACE__ . '\attachment_redirect' );

/**
 * Apply custom picture element srcset schemas.
 */
function add_srcset_schemas( $schemas ) {
	$new_schemas = [
		'hero'          => [
			[
				'media'  => '(min-width: 1041px)',
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-hero-xl',
						'descriptor' => 'w',
						'value'      => 1440,
					],
				],
			],
			[
				'media'  => '(min-width: 721px)',
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-hero-l',
						'descriptor' => 'w',
						'value'      => 1040,
					],
				],
			],
			[
				'media'  => '(min-width: 401px)',
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-hero-m',
						'descriptor' => 'w',
						'value'      => 720,
					],
				],
			],
			[
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-hero-s',
						'descriptor' => 'w',
						'value'      => 400,
					],
				],
			],
		],
		'post-featured' => [
			[
				'media'  => '(min-width: 1041px)',
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-post-featured-xl',
						'descriptor' => 'w',
						'value'      => 1440,
					],
				],
			],
			[
				'media'  => '(min-width: 721px)',
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-post-featured-l',
						'descriptor' => 'w',
						'value'      => 1040,
					],
				],
			],
			[
				'media'  => '(min-width: 401px)',
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-post-featured-m',
						'descriptor' => 'w',
						'value'      => 720,
					],
				],
			],
			[
				'srcset' => [
					[
						'size'       => 'skamstrupfestival-post-featured-s',
						'descriptor' => 'w',
						'value'      => 400,
					],
				],
			],
		],
	];

	return array_merge( $schemas, $new_schemas );
}

add_filter( 'skamstrupfestival_picture_sources', __NAMESPACE__ . '\add_srcset_schemas' );

function new_excerpt_more( $more ) {
	return '...';
}

add_filter( 'excerpt_more', __NAMESPACE__ . '\new_excerpt_more' );

/**
 * Loads custom webfonts in page head section
 */
function custom_google_fonts() {
	$google_fonts_url = 'https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap';
	?>

	<link
		rel="preconnect"
		href="https://fonts.gstatic.com"
		crossorigin
	/>

	<link
		rel="preload"
		as="style"
		href="<?php echo $google_fonts_url; ?>"
	/>

	<link
		rel="stylesheet"
		href="<?php echo $google_fonts_url; ?>"
		media="print" onload="this.media='all'"
	/>

	<noscript>
		<link
			rel="stylesheet"
			href="<?php echo $google_fonts_url; ?>"
		/>
	</noscript>

	<?php
}

add_action( 'wp_head', __NAMESPACE__ . '\custom_google_fonts', 10 );
