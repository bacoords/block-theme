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
	/**
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	* If you're building a theme based on _s, use a find and replace
	* to change 'tangent' to the name of your theme in all the template files.
	*/
	load_theme_textdomain( 'tangent', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

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

	/**
	 * Remove support for the core block pattern library.
	 *
	 * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#disabling-the-default-block-patterns
	 */
	remove_theme_support( 'core-block-patterns' );

	/**
	 * Remove duotone filter SVGs from loading on the frontend if default
	 * and custom duotones are disabled.
	 */
	$theme_json_color_settings = wp_get_global_settings( array( 'color' ) );

	if ( ! $theme_json_color_settings['customDuotone'] && ! $theme_json_color_settings['defaultDuotone'] ) {
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );
	}
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );

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
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\custom_login_logo' );


/**
 * Replace login logo link to homepage
 */
function custom_login_link() {
	return home_url();
}
add_filter( 'login_headerurl', __NAMESPACE__ . '\custom_login_link' );
