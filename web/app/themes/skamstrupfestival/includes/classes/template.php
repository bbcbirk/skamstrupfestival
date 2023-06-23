<?php

namespace Skamstrupfestival\Theme;

class Template {

	// Metabox prefix in custom fields
	const PREFIX = 'skamstrupfestival_template';

	public $post_classes = [];

	public function __construct() {
		// Setup and load correct template.
		add_action( 'wp', [ $this, 'setup_template' ], 10 );
	}

	public static function get_prefix() {
		return THEMEDOMAIN;
	}

	/**
	 * Returns custom field ID with prefix
	 *
	 * @param  string $key
	 * @return string
	 */
	public static function get_key( $key ) {
		return sprintf( '%s_%s', self::get_prefix(), $key );
	}

	// Return customizer link
	public function get_post_customizer_link() {
		global $pagenow;

		if ( $pagenow != 'post.php' && $pagenow != 'post-new.php' ) {
			return;
		}

		if ( $pagenow == 'post.php' ) {
			$page_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : '';
		}

		if ( ! empty( $page_id ) ) {
			$url = '?url=' . urlencode( get_permalink( $page_id ) );
		} else {
			$url = '';
		}

		$customizer_link = admin_url( 'customize.php' ) . $url;

		return $customizer_link;
	}

	/**
	 * Init template parts
	 *
	 * @return void
	 */
	public function setup_template() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// Setup post classes
		$this->setup_post_classes();

		add_action( THEMEDOMAIN . '_loop', [ $this, 'get_template_content' ], 10 );
		add_filter( THEMEDOMAIN . '_show_sidebar', [ $this, 'show_sidebar' ], 10 );
		add_filter( 'body_class', [ $this, 'body_classes' ], 15 );
		add_filter( THEMEDOMAIN . '_content_class', [ $this, 'content_classes' ], 15 );
	}

	private function setup_post_classes() {
		if ( is_archive() || is_search() || is_home() || get_post_type() == 'employee' ) {
			$layout               = 'archive';
			$this->post_classes[] = 'fullwidth';
		} elseif ( is_404() ) {
			$layout               = 'error404';
			$this->post_classes[] = 'fullwidth';
		} else {
			$layout               = get_post_meta( get_the_ID(), self::get_key( 'template' ), true );
			$layout               = empty( $layout ) ? 'fullwidth' : $layout; // Default to left sidebar
			$this->post_classes[] = $layout;

			if ( has_post_thumbnail() ) {
				$this->post_classes[] = 'has-post-thumbnail';

				if ( is_page() && ( ! get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_hide_hero', true ) ) ) {
					$this->post_classes[] = 'has-hero-image';
				}
			}

			if ( is_page() && ! empty( get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_video', true ) ) ) {
				$this->post_classes[] = 'has-hero-video';
			}
		}

		$this->post_classes = apply_filters( THEMEDOMAIN . '_setup_post_classes', $this->post_classes, $layout );

		return $layout;
	}

	public function get_template_content() {
		return get_template_part( 'template-parts/content', $this->get_context() );
	}

	private function get_context() {

		if ( is_front_page() ) {
			$context = 'frontpage';
		} elseif ( is_home() ) {
			$context = 'archive';
		} elseif ( is_archive() || is_search() ) {
			$context = 'archive';
		} elseif ( is_page() ) {
			$context = 'page';
		} elseif ( is_singular() ) {
			$context = get_post_type();
		} else {
			$context = '';
		}

		return $context;
	}

	/**
	 * Add body classes
	 *
	 * @param  string $classes
	 * @return string
	 */
	public function body_classes( $classes ) {
		return array_merge( $classes, $this->post_classes );
	}

	/**
	 * Add content classes to wrapper
	 *
	 * @param  string $classes
	 * @return string
	 */
	public function content_classes( $class ) {
		if ( is_archive() || is_search() || is_home() ) {
			$class .= ' content-wrapper--archive';
		}

		return $class;
	}

	/**
	 * Show sidebar or not
	 *
	 * @param  bool $show_sidebar
	 * @param  int $post_id
	 * @return bool
	 */
	public function show_sidebar( $show_sidebar ) {
		$classes = array_intersect( $this->post_classes, [ 'fullwidth', 'grid', 'archive' ] );

		if ( ! empty( $classes ) ) {
			return false;
		}

		return $show_sidebar;
	}

}
