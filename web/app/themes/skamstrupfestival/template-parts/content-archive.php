<?php
/**
 * Template part for archive pages
 *
 * @package Skamstrupfestival
 */

if ( get_post_type( get_the_ID() ) == 'page' ) {
	$hero_id    = apply_filters( THEMEDOMAIN . '_hero_post_id', get_the_ID() );
	$hero_title = apply_filters( THEMEDOMAIN . '_hero_title', get_post_meta( $hero_id, THEMEDOMAIN . '_formatted_title', true ) );
}
?>

<article id="article-<?php the_ID(); ?>" <?php post_class( 'listed-post' ); ?>>

	<?php do_action( THEMEDOMAIN . '_before_archive_article' ); ?>

	<a class="listed-post__link" href="<?php the_permalink(); ?>" rel="bookmark">

		<div class="listed-post__content">
			<h2 class="listed-post__title">
				<?php if ( get_post_type( get_the_ID() ) == 'page' && ! empty( $hero_title ) ) : ?>

					<?php echo $hero_title; ?>

				<?php else : ?>

					<?php echo get_the_title(); ?>

				<?php endif; ?>
			</h2>

			<?php get_template_part( 'partials/post', 'excerpt' ); ?>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>

			<div class="listed-post__image">
				<div class="listed-post__image-wrap">
					<div class="listed-post__image-inner">
						<?php
						the_post_thumbnail(
							'skamstrupfestival-post-archive',
							[
								'data-picture'             => 'post-archive',
								'data-picture-class'       => 'post-archive__picture',
								'data-picture-image-class' => 'post-archive__image',
							]
						);
						?>
					</div>
				</div>
			</div>

		<?php endif; ?>
	</a>

	<?php do_action( THEMEDOMAIN . '_after_archive_article' ); ?>

</article>
