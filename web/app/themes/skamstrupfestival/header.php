<?php
/**
 * Displays the header HTML.
 *
 * @link http://codex.wordpress.org/Stepping_into_Templates#Basic_Template_Files
 *
 * @package Skamstrupfestival
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<?php do_action( THEMEDOMAIN . '_head_top' ); ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<?php wp_head(); ?>

	<?php do_action( THEMEDOMAIN . '_head_bottom' ); ?>

</head>

<body <?php body_class(); ?>>

	<?php do_action( THEMEDOMAIN . '_body_top' ); ?>

	<?php do_action( THEMEDOMAIN . '_header' ); ?>
