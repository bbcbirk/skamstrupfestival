<?php if ( has_post_thumbnail() ) : ?>

	<div class="post-featured">

		<div class="post-featured__image-wrap">
			<?php
			the_post_thumbnail(
				'skamstrupfestival-post-featured-xl',
				[
					'data-picture'             => 'post-featured',
					'data-picture-class'       => 'post-featured__picture',
					'data-picture-image-class' => 'post-featured__image',
				]
			);
			?>
		</div>

	</div>

<?php endif; ?>

<?php do_action( THEMEDOMAIN . '_after_post_featured' ); ?>
