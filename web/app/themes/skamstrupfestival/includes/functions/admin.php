<?php
/**
 * Everything that modifies the administration screens
 *
 * @package Skamstrupfestival
 *
 */

namespace Skamstrupfestival\Theme\Admin;

function login_logo() {
	?>

	<style type="text/css">
		#login h1 {
			background: #fff;
			padding: 20px;
			margin-bottom: 20px;
		}
		#login h1 a {
			content: url('<?php echo get_stylesheet_directory_uri() . '/assets/dist/img/logo.svg'; ?>');
			background-image: none;
			width: auto;
			height: auto;
			margin: 0 auto;
			max-width: 100%;
		}
	</style>
	<?php
}

add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\login_logo' );
