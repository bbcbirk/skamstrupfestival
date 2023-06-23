<?php
namespace Skamstrupfestival\Theme;

use Skamstrupfestival\Theme\Template;
use WP_Query;

class Sidebar {

	public $sidebars   = [];
	public $current_id = '';

	public function __construct() {
		//$this->add_widget_pages();

		add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
		add_action( 'wp', [ $this, 'display_sidebars' ] );
	}

	public function add( $sidebar_args ) {

		$sidebar_defaults = [
			'name'              => '',
			'id'                => '',
			'class'             => '',
			'descrition'        => '',
			'before_widget'     => '<div id="%1$s" class="widget %2$s">',
			'after_widget'      => '</div>',
			'hook'              => '',
			'priority'          => 10,
			'main_site'         => false,
			'global'            => false,
			'conditional'       => '',
			'conditional_state' => true,
		];

		$sidebar = array_merge( $sidebar_defaults, $sidebar_args );

		$this->sidebars[] = $sidebar;
	}

	/*
	public function add_widget_pages() {
		$query = new WP_Query(
			[
				'post_type'  => 'page',
				'meta_key'   => Template::get_key( 'template' ),
				'meta_value' => 'widget-page',
			]
		);

		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post ) {
				$this->add(
					[
						'name'        => $post->post_title,
						'id'          => "page-{$post->ID}",
						'description' => sprintf( __( 'Widget area specific to %s', THEMEDOMAIN ), $post->post_title ),
						'hook'        => 'post_' . $post->ID,
					]
				);
			}
		}
	}
	*/

	public function register_sidebars() {

		$sidebars = $this->get_sidebars();

		if ( empty( $sidebars ) ) {
			return;
		}

		foreach ( $sidebars as $sidebar ) {

			if ( $sidebar['main_site'] && ! is_main_site() ) {
				return;
			}

			register_sidebar(
				[
					'id'            => $sidebar['id'],
					'name'          => $sidebar['name'],
					'description'   => isset( $sidebar['description'] ) ? $sidebar['description'] : '',
					'before_widget' => $sidebar['before_widget'],
					'after_widget'  => $sidebar['after_widget'],
					'before_title'  => '<h4 class="widgettitle">',
					'after_title'   => '</h4>',
				]
			);
		}
	}

	public function get_sidebars() {
		return apply_filters( 'get_sidebars', $this->sidebars );
	}

	public function display_sidebars() {

		$sidebars = $this->get_sidebars();

		if ( empty( $sidebars ) ) {
			return;
		}

		foreach ( $sidebars as $sidebar ) {

			if ( ! is_active_sidebar( $sidebar['id'] ) && ! $sidebar['global'] ) {
				continue;
			}

			$display_sidebar = true;

			if ( strstr( $sidebar['hook'], 'post_' ) && is_search() ) {
				$display_sidebar = false;
			}

			if ( ! empty( $sidebar['conditional'] ) && function_exists( $sidebar['conditional'] ) && $sidebar['conditional'] !== 'is_admin' ) {
				$display_sidebar = ( (bool) call_user_func( $sidebar['conditional'] ) == (bool) $sidebar['conditional_state'] );
			}

			if ( $display_sidebar ) {
				// We use closures to pass through the sidebar args array. Possible from PHP 5.3+
				// http://php.net/manual/de/functions.anonymous.php
				add_action(
					$this->get_hook( $sidebar['hook'] ),
					function() use ( $sidebar ) {
						$this->sidebar_template( $sidebar );
					},
					$sidebar['priority']
				);
			}
		}
	}

	public function sidebar_template( $sidebar ) {

		if ( ! isset( $sidebar['id'] ) && ! $sidebar['id'] ) {
			return;
		}

		$sidebar_id = $sidebar['id'];

		$classes[] = 'widget-area';

		if ( isset( $sidebar['class'] ) ) {
			$classes[] = $sidebar['class'];
		}

		if ( $sidebar['global'] && is_multisite() ) {

			$global_elements = new GlobalElements();
			$global_elements->set_widget_transient( $sidebar_id );
			$global_sidebar = get_site_transient( $sidebar_id );

			echo '<div id="' . $sidebar_id . '" class="' . implode( ' ', $classes ) . '">';
				// echo '<div class="widget-wrap">';
					echo $global_sidebar;
				// echo '</div>';
			echo '</div>';
		} else {

			echo '<div id="' . $sidebar_id . '" class="' . implode( ' ', $classes ) . '">';
				// echo '<div class="widget-wrap">';
					dynamic_sidebar( $sidebar_id );
				// echo '</div>';
			echo '</div>';
		}
	}

	public function get_hook( $hook ) {
		return THEMEDOMAIN . '_' . $hook;
	}

}
