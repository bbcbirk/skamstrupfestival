<?php
/**
 * Template part used as a fallback if no other template parts match
 *
 * @package Skamstrupfestival
 */
?>

<article id="article-<?php the_ID(); ?>" <?php post_class( 'post-wrapper' ); ?>>

	<?php do_action( THEMEDOMAIN . '_before_article_content' ); ?>

	<div class="post-content">

		<?php the_content(); ?>

	</div>

	<?php do_action( THEMEDOMAIN . '_after_article_content' ); ?>

</article>
