<?php
/**
 * Function hooks for index
 *
 * @link https://docs.woocommerce.com/wc-apidocs/hook-docs.html
 *
 * @package Skamstrupfestival
 */

namespace Skamstrupfestival\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SkamstrupfestivalPrimaryFunctions {

	/**
	 * @var object Instance of this class.
	 */
	protected static $instance = null;

	/**
	 * Returns the instance of this class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {

		add_action( THEMEDOMAIN . '_primary', [ __CLASS__, 'content_wrapper_markup_open' ], 30 );
		add_action( THEMEDOMAIN . '_primary', [ __CLASS__, 'loop_markup' ], 50 );
		add_action( THEMEDOMAIN . '_primary', [ __CLASS__, 'content_wrapper_markup_close' ], 70 );
		add_action( THEMEDOMAIN . '_primary_content', [ __CLASS__, 'main_loop_markup_inner_open' ], 30 );
		add_action( THEMEDOMAIN . '_primary_content', [ __CLASS__, 'main_loop_markup_inner_close' ], 70 );

		// Main loop
		add_action( THEMEDOMAIN . '_primary_content', [ __CLASS__, 'main_loop' ], 50 );

	}

	/**
	 * Function to get site index wrapper
	 */
	public static function content_wrapper_markup_open() {
		?>

		<div id="content" class="<?php echo apply_filters( THEMEDOMAIN . '_content_class', 'site-content', 10 ); ?>" aria-label="<?php echo __( 'Site content', THEMEDOMAIN ); ?>">

			<section class="post-header" aria-label="<?php echo __( 'Page content head section', THEMEDOMAIN ); ?>">

				<?php do_action( THEMEDOMAIN . '_primary_content_top' ); ?>

			</section>

		<?php
	}

	/**
	 * Function to get site index wrapper
	 */
	public static function loop_markup() {
		?>

		<?php do_action( THEMEDOMAIN . '_primary_content' ); ?>

		<?php
	}

	/**
	 * Function to get site index wrapper
	 */
	public static function content_wrapper_markup_close() {
		?>

			<section class="post-footer" aria-label="<?php echo __( 'Content footer section', THEMEDOMAIN ); ?>">

			<?php do_action( THEMEDOMAIN . '_primary_content_bottom' ); ?>

			</section>

		</div>

		<?php
	}

	/**
	 * Function to get site loop inner opening markup
	 */
	public static function main_loop_markup_inner_open() {
		?>

		<div id="primary" class="primary" aria-label="<?php echo __( 'Primary content', THEMEDOMAIN ); ?>">

			<main id="main" class="site-main" role="main">

		<?php
	}

	/**
	 * Function to get site loop inner closing markup
	 */
	public static function main_loop_markup_inner_close() {
		?>

			</main>

			<?php apply_filters( THEMEDOMAIN . '_show_sidebar', true, get_the_ID() ) ? get_sidebar() : false; ?>

		</div>

		<?php
	}

	/**
	 * Function to get site index inner opening markup
	 */
	public static function main_loop() {
		?>

		<?php get_template_part( 'template-parts/loop' ); ?>

		<?php
	}

}

SkamstrupfestivalPrimaryFunctions::instance();
