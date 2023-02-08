<?php
/**
 * Setup theme
 *
 * @package Tangent
 */

namespace Tangent\Enqueue;

/**
 * Setup theme
 */
function global_theme_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );

	$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/global.css' );

	wp_enqueue_style( 'tangent-global-theme-style', get_template_directory_uri() . '/css/global.css', array(), $css_version );
}
add_action( 'wp_enqueue_scripts', 'Tangent\Enqueue\global_theme_styles' );
