<?php
/**
 * Displays the no posts found
 *
 * @package Skamstrupfestival
 */

$title_404_custom       = apply_filters( THEMEDOMAIN . '_title_404', get_theme_mod( THEMEDOMAIN . '_title_404', false ) );
$text_404_custom        = apply_filters( THEMEDOMAIN . '_text_404', get_theme_mod( THEMEDOMAIN . '_text_404', false ) );
$custom_404_page_custom = apply_filters( THEMEDOMAIN . '_custom_404_page', get_theme_mod( THEMEDOMAIN . '_custom_404_page', false ) );

$title_404_default = apply_filters( THEMEDOMAIN . '_404_title', __( '404 - Not Found', THEMEDOMAIN ) );
$text_404_default  = apply_filters( THEMEDOMAIN . '_404_content', __( 'The content you were looking for may have been moved or unpublished', THEMEDOMAIN ) );

if ( ! empty( $custom_404_page_custom ) ) {
	$title = get_the_title( $custom_404_page_custom );
} elseif ( ! empty( $title_404_custom ) ) {
	$title = $title_404_custom;
} else {
	$title = $title_404_default;
}

if ( ! empty( $text_404_custom ) ) {
	$text = $text_404_custom;
} else {
	$text = $text_404_default;
}

?>

<article class="post-wrapper post-wrapper--not-found">

	<header class="post-header">

		<h1 class="post-header__title"><?php echo $title; ?></h1>

	</header>

	<div class="post-content">

		<?php if ( ! empty( $custom_404_page_custom ) ) : ?>
			<?php echo get_post_field( 'post_content', $custom_404_page_custom ); ?>
		<?php else : ?>
			<p class="not-found-message"><?php echo $text; ?></p>
		<?php endif; ?>

		<?php if ( ! is_search() && ! get_theme_mod( THEMEDOMAIN . '_hide_search' ) ) : ?>
			<?php get_search_form(); ?>
		<?php endif; ?>

	</div>

</article>
