<?php
/**
 * Displays the no search results found
 *
 * @package Skamstrupfestival
 */
?>

<article class="post-wrapper post-wrapper--search-not-found">

	<p class="search-not-found-message"><?php printf( __( 'Sorry, we didn\'t find any results for <strong>%s</strong>.', THEMEDOMAIN ), get_search_query() ); ?></p>

</article>
