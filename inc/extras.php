<?php
/**
 * Custom template tags for this theme
 *
 * @package Tangent
 */

namespace Tangent\Extras;

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
add_action( 'login_enqueue_scripts', 'Tangent\Extras\custom_login_logo' );


/**
 * Replace login logo link to homepage
 */
function custom_login_link() {
	return home_url();
}
add_filter( 'login_headerurl', 'Tangent\Extras\custom_login_link' );
