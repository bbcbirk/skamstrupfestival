<?php

namespace Skamstrupfestival\Theme;

use Carbon_Fields\Container;
use Carbon_Fields\Field\Field;

class Hero {

	const METABOX_ID = THEMEDOMAIN . '_hero_settings';

	public function __construct() {
		$this->meta_box_args = [
			'id'         => self::get_metabox_id(),
			'title'      => __( 'Hero', THEMEDOMAIN ),
			'post_types' => [ 'page' ],
			'context'    => 'normal',
			'priority'   => 'high',
		];

		add_action( 'carbon_fields_register_fields', [ $this, 'create_meta_box' ] );
	}

	public static function get_metabox_id() {
		return self::METABOX_ID;
	}

	/**
	 * Returns custom field ID with prefix.
	 *
	 * @param  string $key
	 * @return string
	 */
	public static function get_meta_key( $key ) {
		return sprintf( '%s_%s', self::get_metabox_id(), $key );
	}

	public function fields() {
		$fields   = [];
		$fields[] = $this->hide_hero_field();
		$fields[] = $this->formatted_title_field();
		$fields[] = $this->introtext_field();
		$fields[] = $this->link_field();
		$fields[] = $this->link_text_field();
		$fields[] = $this->video_field();
		return $fields;
	}

	// CUSTOM FIELD FUNCTIONS START

	public function hide_hero_field() {
		return Field::make( 'checkbox', self::get_meta_key( 'hide_hero' ), __( 'Hide hero', THEMEDOMAIN ) )
			->set_option_value( 'on' );
	}

	public function formatted_title_field() {
		return Field::make( 'textarea', self::get_meta_key( 'formatted_title' ), __( 'Alternative title', THEMEDOMAIN ) )
			->set_rows( 4 )
			->set_help_text( 'Use a different title than the page title. HTML inline elements are allowed (e.g. links and bold text).' );
	}

	public function introtext_field() {
		return Field::make( 'textarea', self::get_meta_key( 'introtext' ), __( 'Intro text', THEMEDOMAIN ) )
			->set_rows( 4 );
	}

	public function link_field() {
		return Field::make( 'text', self::get_meta_key( 'link' ), __( 'Link', THEMEDOMAIN ) );
	}

	public function link_text_field() {
		return Field::make( 'text', self::get_meta_key( 'link_text' ), __( 'Link text', THEMEDOMAIN ) );
	}

	public function video_field() {
		return Field::make( 'file', self::get_meta_key( 'video' ), __( 'Hero Video', THEMEDOMAIN ) )
			->set_type( [ 'video' ] )
			->set_help_text( 'Use a looping video instead of an image. Ignored if left empty.' );

	}

	// CUSTOM FIELD FUNCTIONS END

	public function create_meta_box() {

		Container::make( 'post_meta', $this->meta_box_args['id'], $this->meta_box_args['title'] )
			->set_context( $this->meta_box_args['context'] )
			->set_priority( $this->meta_box_args['priority'] )
			->where( 'post_type', 'IN', $this->meta_box_args['post_types'] )
			->add_fields( $this->fields() );
	}

}

new Hero();
