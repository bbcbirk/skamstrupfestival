<?php
$hide_hero       = apply_filters( THEMEDOMAIN . '_hero_hide_hero', get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_hide_hero', true ) );
$formatted_title = apply_filters( THEMEDOMAIN . '_hero_formatted_title', get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_formatted_title', true ) );
$excerpt         = apply_filters( THEMEDOMAIN . '_hero_excerpt', get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_introtext', true ) );
$link            = apply_filters( THEMEDOMAIN . '_hero_link', get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_link', true ) );
$link_text       = apply_filters( THEMEDOMAIN . '_hero_link_text', get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_link_text', true ) );
$video_id        = apply_filters( THEMEDOMAIN . '_hero_video_id', get_post_meta( get_the_ID(), '_' . THEMEDOMAIN . '_hero_settings_video', true ) );
$hero_class      = apply_filters( THEMEDOMAIN . '_hero_class', '' );
$hero_text_class = apply_filters( THEMEDOMAIN . '_hero_text_wrap_class', '' );

if ( has_post_thumbnail() && empty( $video_id ) ) {
	$hero_class      .= ' hero--with-image';
	$hero_text_class .= ' hero__text-wrap--with-image';
} elseif ( ! empty( $video_id ) ) {
	$hero_class      .= ' hero--with-video';
	$hero_text_class .= ' hero__text-wrap--with-video';
}

// $css = [];
//
// $handle = 'hero';
//
// \Skamstrupfestival\Theme\add_inline_css( $css, $handle );
?>

<?php if ( ! $hide_hero ) : ?>
	<header class="hero<?php echo $hero_class; ?>">
		<div class="hero__text-wrap <?php echo $hero_text_class; ?>">

			<?php if ( $excerpt ) : ?>

				<p class="hero__excerpt"><?php echo $excerpt; ?></p>

			<?php endif; ?>

			<h1 class="hero__title"><?php echo $formatted_title ? '<span class="hero__formatted-title-text">' . $formatted_title . '</span>' : get_the_title(); ?></h1>

			<?php do_action( THEMEDOMAIN . '_hero_label' ); ?>

			<?php if ( $link && $link_text ) : ?>
				<div class="hero__link-wrapper">
					<a class="hero__link <?php echo $link_class; ?>" href="<?php echo $link; ?>" style="<?php echo $link_inline_style; ?>">
						<?php echo $link_text; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

	<?php if ( has_post_thumbnail() && empty( $video_id ) ) : ?>

		<div class="hero__image-wrap responsive-background-image">
			<?php
			$image_size         = 'skamstrupfestival-hero-xl';
			$image_data_picture = 'hero';

			$img_tag = wp_get_attachment_image( get_post_thumbnail_id(), $image_size, false );

			$atts = [
				'data-picture'             => $image_data_picture,
				'data-picture-class'       => 'hero__picture',
				'data-picture-image-class' => 'hero__image',
			];

			echo apply_filters( 'post_thumbnail_html', $img_tag, get_the_ID(), get_post_thumbnail_id(), '', $atts );
			?>
		</div>

	<?php elseif ( ! empty( $video_id ) ) : ?>
		<div class="hero__video-wrap responsive-background-video">
			<?php
			$atts = [
				'autoplay'          => true,
				'muted'             => true,
				'loop'              => true,
				'data-video-class'  => 'hero__video',
				'data-figure-class' => 'hero__figure',
				'data-video'        => $video_id,
			];

			echo apply_filters( 'video_html', '<video></video>', $video_id, $atts );
			?>
		</div>
	<?php endif; ?>

		<?php do_action( THEMEDOMAIN . '_after_hero_content' ); ?>

	</header>
<?php endif; ?>
