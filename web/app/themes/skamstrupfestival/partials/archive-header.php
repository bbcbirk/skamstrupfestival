<header class="archive-header">

	<?php do_action( THEMEDOMAIN . '_before_archive_header' ); ?>

	<h1 class="archive-header__title">
		<?php if ( is_home() ) : ?>
			<?php echo get_the_title( get_option( 'page_for_posts', true ) ); ?>

		<?php elseif ( is_search() ) : ?>
			<span class="archive-header__prefix"><?php _e( 'Search Results for:', THEMEDOMAIN ); ?> </span><?php echo esc_attr( get_search_query() ); ?>

		<?php elseif ( is_category() ) : ?>
			<?php single_cat_title(); ?>

		<?php elseif ( is_tag() ) : ?>
			<?php single_tag_title(); ?>

		<?php elseif ( is_tax() ) : ?>
			<?php single_term_title(); ?>

		<?php elseif ( is_post_type_archive() ) : ?>
			<?php post_type_archive_title(); ?>

		<?php elseif ( is_day() ) : ?>
			<span class="archive-header__prefix"><?php _e( 'Archive:', THEMEDOMAIN ); ?> </span><?php the_time( 'l, F j, Y' ); ?>

		<?php elseif ( is_month() ) : ?>
			<span class="archive-header__prefix"><?php _e( 'Archive:', THEMEDOMAIN ); ?> </span><?php the_time( 'F Y' ); ?>

		<?php elseif ( is_year() ) : ?>
			<span class="archive-header__prefix"><?php _e( 'Archive:', THEMEDOMAIN ); ?> </span><?php the_time( 'Y' ); ?>

		<?php elseif ( is_author() ) : ?>
			<?php global $post; ?>
			<span class="archive-header__prefix"><?php _e( 'Author:', THEMEDOMAIN ); ?> </span><?php the_author_meta( 'display_name', $post->post_author ); ?>

		<?php endif; ?>
	</h1>

	<?php $taxonomy = isset( get_queried_object()->taxonomy ) ? get_queried_object()->taxonomy : 'post_tag'; ?>

	<?php $term_description = apply_filters( THEMEDOMAIN . '_term_description', term_description( 0, $taxonomy ) ); ?>

	<?php if ( ! empty( $term_description ) ) : ?>

		<div class="archive-header__description">
			<?php echo do_shortcode( wpautop( $term_description ) ); ?>
		</div>

	<?php endif; ?>

	<?php do_action( THEMEDOMAIN . '_after_archive_header' ); ?>

</header>
