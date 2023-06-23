<?php

$image_id = apply_filters( THEMEDOMAIN . '_post_featured', get_post_thumbnail_id(), 10 );

$caption = get_posts(
	[
		'p'         => $image_id,
		'post_type' => 'attachment',
	]
);

?>

<?php if ( has_post_thumbnail() && ! empty( $caption[0]->post_excerpt ) ) : ?>

	<div class="post-image-meta">

		<?php echo wpautop( $caption[0]->post_excerpt ); ?>

	</div>

<?php endif; ?>
