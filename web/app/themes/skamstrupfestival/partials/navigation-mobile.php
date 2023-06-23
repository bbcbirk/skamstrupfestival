<?php if ( has_nav_menu( 'main-nav' ) ) : ?>
	<div class="nav-mobile">

		<div class="nav-mobile-inner">

			<?php do_action( THEMEDOMAIN . '_before_mobile_navigation' ); ?>

			<?php if ( has_nav_menu( 'mobile-nav' ) ) : ?>

				<?php mobile_menu(); ?>

			<?php endif; ?>

			<?php do_action( THEMEDOMAIN . '_after_mobile_navigation' ); ?>

		</div>

	</div>
<?php endif; ?>
