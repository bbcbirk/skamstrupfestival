<?php

namespace Skamstrupfestival\Theme;

/**
 * Setup sidebars
 */
function setup_sidebars() {
	$sidebar = new Sidebar();

	$sidebar->add(
		[
			'name'              => __( 'Sidebar', THEMEDOMAIN ),
			'id'                => 'sidebar-1',
			'description'       => __( 'This is the primary sidebar. Shows up on all pages.', THEMEDOMAIN ),
			'hook'              => 'sidebar',
			'before_widget'     => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'      => '</aside>',
			'conditional'       => 'is_search',
			'conditional_state' => false,
		]
	);

	$sidebar->add(
		[
			'name'          => __( 'Footer', THEMEDOMAIN ),
			'id'            => 'footer-sidebar',
			'class'         => 'footer',
			'hook'          => 'footer',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		]
	);
}
