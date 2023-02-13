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
	$styled_blocks = get_block_specific_stylesheets();

	foreach ( $styled_blocks as $block_name => $stylesheet_path ) {
		$args = array(
			'handle' => $block_name,
			'src'    => $stylesheet_path,
		);
		wp_enqueue_block_style( $block_name, $args );
	}
}

// function to get all css files in the css/ folder
function get_css_files() {
	$get_all_css_files = glob( get_stylesheet_directory() . '/css/*.css' );
	$css_files = array_reduce( $get_all_css_files, 'Tangent\Enqueue\associative_array_of_filenames_and_filepaths', array() );
	return $css_files;
}

function associative_array_of_filenames_and_filepaths( $accumulator, $css_file ) {
	$exclude_stylesheets = array( 'global.css', 'editor.css' );
	if ( in_array( basename( $css_file ), $exclude_stylesheets, true ) ) {
		return $accumulator;
	}
	$accumulator[basename( $css_file )] = str_replace(get_stylesheet_directory(), get_stylesheet_directory_uri(), $css_file);
	return $accumulator;
}


function get_block_specific_stylesheets() {
	$stylesheets = get_css_files();
	$blocks_with_custom_stylesheets = array();
	$pattern = "/(.+)--(.+)\.css/i"; // e.g. core--default.css
	foreach ( $stylesheets as $stylesheet => $stylesheet_path ) {
		preg_match( $pattern, $stylesheet, $matches );
		$block_name = $matches[2];
		$block_namespace = $matches[1];
		$blocks_with_custom_stylesheets[ $block_namespace . '/' . $block_name ] = $stylesheet_path;
	}
	return $blocks_with_custom_stylesheets;
}
add_action( 'after_setup_theme', 'Tangent\Enqueue\enqueue_block_specific_custom_styles' );
