<?php $image_id = apply_filters( THEMEDOMAIN . '_archive_hero_image_id', 0 ); ?>

<?php if ( $image_id ) : ?>
	<div class="">
		<div class="">
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'skamstrupfestival-hero-xl',
				false,
				[
					'data-picture'             => 'hero-breaker',
					'data-picture-class'       => 'hero__picture',
					'data-picture-image-class' => 'hero__image',
				]
			);
			?>
		</div>
	</div>
<?php endif; ?>
