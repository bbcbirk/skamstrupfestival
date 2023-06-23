<?php

namespace Skamstrupfestival\Theme;

/**
 * Avoids returning random page if empty search string
 */
function search_filter( $query_vars ) {
	if ( ! is_admin() ) {
		if ( isset( $query_vars['s'] ) && $query_vars['s'] == '' ) {
			$query_vars['s'] = ' ';
		}
	}

	return $query_vars;
}

add_filter( 'request', __NAMESPACE__ . '\search_filter' );

/**
 * Redirect search query params to use /search/<search-query>
 *
 * @return void
 */
function redirect_search_url() {
	if ( is_search() && ! empty( $_GET['s'] ) ) {
		wp_redirect( get_search_link( get_query_var( 's' ) ) );
		exit();
	}
}

// add_action( 'template_redirect', __NAMESPACE__ . '\redirect_search_url' );
