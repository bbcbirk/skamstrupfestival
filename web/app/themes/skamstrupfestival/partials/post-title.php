<?php
namespace Skamstrupfestival\Theme;

?>

<h1 class="post-header__title" itemprop="name headline"><?php the_title(); ?></h1>

<?php do_action( THEMEDOMAIN . '_article_title' ); ?>
