<?php

// namespace Skamstrupfestival\Theme;

/**
 * Main navigation
 */
function main_menu() {
	wp_nav_menu(
		[
			'container'       => false,
			'container_class' => '',
			'menu_class'      => 'menu',
			'theme_location'  => 'main-nav',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 2,
		]
	);
}

/**
 * Mobile navigation
 */
function mobile_menu() {
	wp_nav_menu(
		[
			'container'       => false,
			'container_class' => '',
			'menu_class'      => 'menu-mobile',
			'theme_location'  => 'mobile-nav',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 2,
		]
	);
}
