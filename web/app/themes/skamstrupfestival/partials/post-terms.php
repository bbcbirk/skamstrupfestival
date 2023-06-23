<?php if ( has_category() || has_tag() ) : ?>

	<?php if ( has_category() ) : ?>
		<div class="categories">
			<h2 class="categories__title"><?php _e( 'Categories', THEMEDOMAIN ); ?></h2>
			<?php the_category(); ?>
		</div>
	<?php endif; ?>

	<?php if ( has_tag() ) : ?>
		<div class="tags">
			<h2 class="tags__title"><?php _e( 'Tags', THEMEDOMAIN ); ?></h2>
			<?php the_tags( '<ul class="tags__list"><li class="tags__item">', '</li><li class="tags__item">', '</li></ul>' ); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>
