<?php
/**
 * The main template file. Acts as the sole entry point for the theme and all template files.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skamstrupfestival
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

do_action( THEMEDOMAIN . '_primary' );

get_footer();
