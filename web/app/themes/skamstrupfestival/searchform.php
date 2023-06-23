<?php
/**
 * Displays the search form
 *
 * @link http://codex.wordpress.org/Function_Reference/get_search_form
 * @package Skamstrupfestival
 *
 */
?>

<form class="search-form" role="search" method="get" action="<?php echo home_url(); ?>/">
	<label for="s" class="screen-reader-text"><?php echo esc_attr( __( 'Hit enter to Search...', THEMEDOMAIN ) ); ?></label>
	<input class="search-form__field" type="search" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php echo __( 'Hit enter to Search...', THEMEDOMAIN ); ?>" />
	<button type="submit" class="search-form__button" aria-label="toggle search">
		<svg class="search-form__icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18.98 18.344l-5.276-5.276a7.162 7.162 0 0 0 1.808-4.755c0-3.97-3.23-7.2-7.2-7.2s-7.2 3.23-7.2 7.2 3.23 7.2 7.2 7.2a7.16 7.16 0 0 0 4.755-1.809l5.277 5.277.637-.637zM8.313 14.612a6.307 6.307 0 0 1-6.3-6.3c0-3.473 2.827-6.3 6.3-6.3 3.474 0 6.3 2.827 6.3 6.3 0 3.474-2.826 6.3-6.3 6.3z" fill="#333" stroke="#333" stroke-width=".6"/></svg>
	</button>
</form>
