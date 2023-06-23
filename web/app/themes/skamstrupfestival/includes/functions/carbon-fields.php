<?php

add_action( 'after_setup_theme', 'carbon_load' );

function carbon_load() {
	require_once( get_template_directory() . '/vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}
