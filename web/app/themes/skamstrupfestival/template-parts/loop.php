<?php

if ( have_posts() && ! is_404() ) {
	while ( have_posts() ) {

		the_post();

		do_action( THEMEDOMAIN . '_loop' );

		do_action( THEMEDOMAIN . '_post_' . get_the_ID() );

	}
} elseif ( is_search() ) {

	get_template_part( 'template-parts/search', 'not-found' );

} else {

	get_template_part( 'template-parts/content', '404' );

}
