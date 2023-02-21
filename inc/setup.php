<?php
/**
 * Setup theme
 *
 * @package Tangent
 */

namespace Tangent\Setup;

/**
 * Setup theme
 */
function theme_setup() {
	/*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	* If you're building a theme based on _s, use a find and replace
	* to change 'tangent' to the name of your theme in all the template files.
	*/
	load_theme_textdomain( 'tangent', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'tangent' ),
		)
	);

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'editor-styles' );

	/**
	 * Add support for Block Template Parts
	 *
	 * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#block-based-template-parts
	 */
	add_theme_support( 'block-template-parts' );
}
add_action( 'after_setup_theme', 'Tangent\Setup\theme_setup' );


/**
 * Custom login logo
 */
function custom_login_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );

	// We have a logo. Logo is go.
	if ( $custom_logo_id ) {
		$image = wp_get_attachment_image_src( $custom_logo_id, 'medium' );
		?>
		<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(<?php echo esc_attr( $image[0] ); ?>);
			height:<?php echo esc_attr( $image[2] ); ?>px;
			width:<?php echo esc_attr( $image[1] ); ?>px;
			background-size: <?php echo esc_attr( $image[1] ); ?>px <?php echo esc_attr( $image[2] ); ?>px;
			background-repeat: no-repeat;
			padding-bottom: 30px;
		}
		</style>
		<?php
	}
}
add_action( 'login_enqueue_scripts', 'Tangent\Setup\custom_login_logo' );


/**
 * Replace login logo link to homepage
 */
function custom_login_link() {
	return home_url();
}
add_filter( 'login_headerurl', 'Tangent\Setup\custom_login_link' );
