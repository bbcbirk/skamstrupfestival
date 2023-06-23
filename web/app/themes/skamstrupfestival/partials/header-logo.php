<div class="<?php echo apply_filters( THEMEDOMAIN . '_logo_class', 'logo' ); ?>">

	<a class="logo__link" href="<?php echo home_url(); ?>" rel="home" title="<?php _e( 'Home', THEMEDOMAIN ); ?>">

		<?php if ( file_exists( get_stylesheet_directory() . '/assets/dist/img/logo.svg' ) ) : ?>
		<img class="logo__image" src="<?php echo get_stylesheet_directory_uri() . '/assets/dist/img/logo.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
		<?php else : ?>
		<span class="logo__text"><?php bloginfo( 'name' ); ?></span>
		<?php endif; ?>

	</a>

</div> <!-- logo -->
