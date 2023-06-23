<?php
/**
 * This whole file needs a different html structure.
 * It's based on Foundation and I guess we need a another structure for whatever menu we'll be styling.
 */
?>

<?php do_action( THEMEDOMAIN . '_before_main_nav' ); ?>

<?php if ( has_nav_menu( 'main-nav' ) ) : ?>
	<nav class="<?php echo apply_filters( THEMEDOMAIN . '_menu_wrapper_class', 'menu-wrapper' ); ?>">

		<?php if ( has_nav_menu( 'main-nav' ) ) : ?>

			<?php main_menu(); ?>

		<?php endif; ?>

		<?php if ( has_nav_menu( 'mobile-nav' ) ) : ?>

			<button type="button" class="hamburger" aria-label="<?php _e( 'Menu', THEMEDOMAIN ); ?>">
				<span class="hamburger__icon"></span>
			</button>

		<?php endif; ?>

	</nav>
<?php endif; ?>

<?php if ( ! get_theme_mod( THEMEDOMAIN . '_hide_search' ) ) : ?>
	<div class="<?php echo apply_filters( THEMEDOMAIN . '_header_search_class', 'header-search' ); ?>">

		<button type="button" class="header-search__button" aria-label="toggle search">
			<span class="header-search__icon" aria-hidden="true"></span>
			<span class="header-search__text">toggle search</span>
		</button>

	</div>
<?php endif; ?>

<?php do_action( THEMEDOMAIN . '_after_main_nav' ); ?>
