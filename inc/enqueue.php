<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Tangent
 */

namespace Tangent\Enqueue;

/**
 * Enqueue the `global.css` file.
 */
function global_theme_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );

	$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/global.css' );

	wp_enqueue_style( 'tangent-global-theme-style', get_template_directory_uri() . '/css/global.css', array(), $css_version );
}
add_action( 'wp_enqueue_scripts', 'Tangent\Enqueue\global_theme_styles' );

/**
 * Enqueue the `scripts.js` file and associated dependencies.
 */
function front_end_scripts() {

	$asset_file = include get_template_directory() . '/js/scripts.asset.php';
	$dependencies = $asset_file['dependencies'];

	wp_enqueue_script( 'tangent-front-end-scripts', get_template_directory_uri() . '/js/scripts.js', $dependencies, $asset_file['version'], );
}
add_action( 'wp_enqueue_scripts', 'Tangent\Enqueue\front_end_scripts' );

add_filter( 'should_load_separate_core_block_assets', '__return_true' );

function enqueue_block_specific_custom_styles() {
	/*
	 * Load additional block styles.
	 */
		$styled_blocks = ['post-author'];
	foreach ( $styled_blocks as $block_name ) {
		$args = array(
			'handle' => "twentytwentytwo-$block_name",
			'src'    => get_theme_file_uri( "assets/css/blocks/$block_name.css" ),
		);
		wp_enqueue_block_style( "core/$block_name", $args );
	}
}

// function to get all css files in the css/ folder
function get_css_files() {
	$css_files = glob( get_template_directory() . '/css/*.css' );
	$css_files = array_reduce( $css_files, 'Tangent\Enqueue\css_file_keys', array() );
	$css_files = array_filter( $css_files, 'Tangent\Enqueue\exclude_stylesheets', ARRAY_FILTER_USE_KEY );
	echo '<pre>' . var_export($css_files, true) . '</pre>';

	return $css_files;
}

function css_file_keys( $accumulator, $css_file ) {
	$accumulator[basename( $css_file )] = $css_file;
	return $accumulator;
}

function exclude_stylesheets( $stylesheet ) {
	$exclude_stylesheets = array( 'global.css', 'editor.css' );
	if ( in_array( $stylesheet, $exclude_stylesheets, true ) ) {
		return false;
	}
	return true;
}
