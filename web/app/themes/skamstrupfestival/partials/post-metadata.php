<div class="post-meta">
	<div class="post-meta__author">
		<span class="post-meta__author__title"><?php _e( 'Written by:', THEMEDOMAIN ); ?></span>
		<span class="post-meta__author__value"><?php the_author_meta( 'display_name', $post->post_author ); ?></span>
	</div>

	<div class="post-meta__date">
		<span class="post-meta__date__title"><?php _e( 'Date:', THEMEDOMAIN ); ?></span>
		<time class="post-meta__date__value time" datetime="<?php the_time( 'Y-m-d' ); ?>">
			<?php echo get_the_date( get_option( 'date_format' ) ); ?>
		</time>
	</div>

	<?php if ( has_category() ) : ?>
	<div class="post-meta__categories">
		<span class="post-meta__categories__title"><?php _e( 'Categories:', THEMEDOMAIN ); ?></span>
		<?php the_category(); ?>
	</div>
	<?php endif; ?>

	<?php if ( has_tag() ) : ?>
	<div class="post-meta__tags">
		<span class="post-meta__tags__title"><?php _e( 'Tags:', THEMEDOMAIN ); ?></span>
		<?php the_tags( '<ul class="tags__list"><li class="tags__item">', ', </li><li class="tags__item">', '</li></ul>' ); ?>
	</div>
	<?php endif; ?>

</div>
