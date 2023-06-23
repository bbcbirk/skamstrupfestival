<?php
/**
 * Displays the search form
 *
 * @link http://codex.wordpress.org/Function_Reference/get_search_form
 * @package WordPress
 */
?>

<div class="header-search__form-wrap">
	<form class="header-search__form" role="search" method="get" action="<?php echo home_url(); ?>/">
		<input class="header-search__field" type="search" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e( 'Enter searchword…', THEMEDOMAIN ); ?>" />
		<button type="submit" class="header-search__button" aria-label="toggle search">
			<span class="header-search__icon" aria-hidden="true"></span>
		</button>
	</form>
</div>
