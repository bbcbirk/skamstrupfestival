<?php

namespace Skamstrupfestival\Theme;

class Breadcrumb {
	/**
	 * @var object Instance of this class.
	 */
	protected static $instance = null;

	public $item_classes;
	public $breadcrumbs_id;
	public $breadcrumbs_class;
	public $home_title;
	public $custom_taxonomy;

	public function __construct() {
		$this->breadcrumbs_class = 'breadcrumbs';
		$this->item_classes      = [ $this->breadcrumbs_class . '__item' ];
		$this->home_title        = __( 'Home', THEMEDOMAIN );
	}

	/**
	 * Returns the instance of this class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function start() {
		return sprintf( '<ul class="%s">', $this->breadcrumbs_class );
	}

	public function end() {
		return '</ul>';
	}

	public function home() {
		return sprintf( '<li class="%1$s %2$s__item--home"><a class="%2$s__link" href="%3$s">%4$s</a></li>', implode( ' ', $this->item_classes ), $this->breadcrumbs_class, get_home_url(), $this->home_title );
	}

	public function item( $title ) {
		return sprintf( '<li class="%s">%s</li>', implode( ' ', $this->item_classes ), $title );
	}

	public function item_cat( $title ) {
		$this->item_classes = [
			'breadcrumbs__item',
			$this->breadcrumbs_class . '__item--cat',
		];

		return $this->item( $title );
	}

	public function item_current( $title ) {
		$this->item_classes = [
			'breadcrumbs__item',
			$this->breadcrumbs_class . '__item--current',
		];

		return $this->item( $title );
	}

	public function item_cpt( $post_type ) {
		$post_type_object = get_post_type_object( $post_type );

		return sprintf(
			'<li class="%1$s %2$s__item--post-type %2$s__item--post-type-%3$s">
				<a class="%2$s__link" href="%4$s">%5$s</a>
			</li>',
			implode( ' ', $this->item_classes ),
			$this->breadcrumbs_class,
			$post_type,
			get_post_type_archive_link( $post_type ),
			$post_type_object->labels->name
		);
	}

	public function item_parent( $post ) {
		return sprintf(
			'<li class="%1$s %2$s__item--parent-page %2$s__item--parent-page-%3$s">
				<a class="%2$s__link" href="%4$s">%5$s</a>
			</li>',
			implode( ' ', $this->item_classes ),
			$this->breadcrumbs_class,
			$post,
			get_permalink( $post ),
			get_the_title( $post )
		);
	}

	public function item_link( $title, $link ) {
		return sprintf(
			'<li class="%1$s %2$s__item--parent">
				<a class="%2$s__link" href="%4$s">%3$s</a>
			</li>',
			$this->item_classes,
			$this->breadcrumbs_class,
			$title,
			$link
		);
	}

	public function display() {
		global $post;

		// Do not display on the homepage
		if ( is_front_page() ) {
			return;
		}

		$breadcrumb  = $this->start();
		$breadcrumb .= $this->home();

		if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {
			$breadcrumb .= $this->item_current( post_type_archive_title( '', false ) );
		}

		if ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {
			$post_type = get_post_type();

			if ( $post_type != 'post' ) {
				$breadcrumb .= $this->item_cpt( $post_type );
			}

			$breadcrumb .= $this->item_current( get_queried_object()->name );
		}

		if ( is_home() ) {
			$breadcrumb .= $this->item_current( get_queried_object()->post_title );
		}

		if ( is_single() ) {
			$post_type = get_post_type();

			if ( $post_type != 'post' ) {
				$breadcrumb .= $this->item_cpt( $post_type );
			}

			// @TODO This needs tidying up
			// Get post category info
			$category = get_the_category();

			if ( ! empty( $category ) ) {
				$categorie_values = array_values( $category );
				$last_category    = end( $categorie_values ); // Get last category post is in

				// Get parent any categories and create array
				$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
				$cat_parents     = explode( ',', $get_cat_parents );

				// Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				foreach ( $cat_parents as $parents ) {
					$breadcrumb .= $this->item_cat( $parents );
				}
			}

			// s($post->ID);
			// s(get_the_ID());
			// s(get_object_taxonomies(get_post()));

			// @TODO Find a nicer / cleaner implementation for custom taxonomies
			// Could use a filter to hook in and add custom taxonomies
			$custom_taxonomy = 'inspiration-category';
			$taxonomy_exists = taxonomy_exists( $custom_taxonomy );
			if ( empty( $last_category ) && ! empty( $custom_taxonomy ) && $taxonomy_exists ) {

				$taxonomy_terms = get_the_terms( get_the_ID(), $custom_taxonomy );

				if ( $taxonomy_terms ) {
					$cat_id   = $taxonomy_terms[0]->term_id;
					$cat_link = get_term_link( $taxonomy_terms[0]->term_id, $custom_taxonomy );
					$cat_name = $taxonomy_terms[0]->name;
				}
			}

			// Check if the post is in a category
			if ( ! empty( $last_category ) ) {
				// echo $cat_display;
				// $breadcrumb .= $this->item_current( get_the_title() );

			} elseif ( ! empty( $cat_id ) ) { // Else if post is in a custom taxonomy
				$breadcrumb .= $this->item_link( $cat_name, $cat_link );
			}

			$breadcrumb .= $this->item_current( get_the_title() );
		}

		if ( is_category() ) {
			$breadcrumb .= $this->item_current( single_cat_title( '', false ) );
		}

		if ( is_page() ) {

			if ( $post->post_parent ) {
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) ); // If child page, get parents

				foreach ( $ancestors as $ancestor ) {
					$breadcrumb .= $this->item_parent( $ancestor );
				}
			}

			$breadcrumb .= $this->item_current( get_the_title() );
		}

		if ( is_tag() ) {
			$term_id       = get_query_var( 'tag_id' );
			$taxonomy      = 'post_tag';
			$args          = 'include=' . $term_id;
			$terms         = get_terms( $taxonomy, $args );
			$get_term_id   = $terms[0]->term_id;
			$get_term_slug = $terms[0]->slug;
			$get_term_name = $terms[0]->name;

			$breadcrumb .= $this->item_current( $get_term_name );

		}

		if ( is_day() ) {
			$title       = get_the_time( 'Y' ) . ' Archives';
			$link        = get_year_link( get_the_time( 'Y' ) );
			$breadcrumb .= $this->item_link( $title, $link );

			$title       = get_the_time( 'M' ) . ' Archives';
			$link        = get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) );
			$breadcrumb .= $this->item_link( $title, $link );

			$title       = get_the_time( 'jS' ) . ' ' . get_the_time( 'M' );
			$breadcrumb .= $this->item_current( $title );
		}

		if ( is_month() ) {
			$title       = get_the_time( 'Y' ) . ' Archives';
			$link        = get_year_link( get_the_time( 'Y' ) );
			$breadcrumb .= $this->item_link( $title, $link );

			$title       = get_the_time( 'M' ) . ' Archives';
			$breadcrumb .= $this->item_current( $title );
		}

		if ( is_year() ) {
			$title       = get_the_time( 'Y' ) . ' Archives';
			$breadcrumb .= $this->item_current( $title );
		}

		if ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );

			$title       = 'Author: ' . $userdata->display_name;
			$breadcrumb .= $this->item_current( $title );
		}

		if ( get_query_var( 'paged' ) ) {
			$title       = __( 'Page', THEMEDOMAIN ) . ' ' . get_query_var( 'paged' );
			$breadcrumb .= $this->item_current( $title );
		}

		if ( is_search() ) {
			$title       = 'Search results for: ' . get_search_query();
			$breadcrumb .= $this->item_current( $title );
		}

		if ( is_404() ) {
			$breadcrumb .= $this->item_current( '404' );
		}

		$breadcrumb .= $this->end();

		echo $breadcrumb;
	}

}

/**
 * Instantiate the plugin
 */
function breadcrumb() {
	return Breadcrumb::instance();
}
