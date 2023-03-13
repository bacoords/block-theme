<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Tangent
 */

namespace Tangent\Enqueue;

/**
 * Enqueue the `global.css` file.
 *
 * The `global.css` file is enqueued on all pages and is used for global styles.
 *
 * @return void
 */
function global_theme_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$css_version   = $theme_version . '.' . filemtime( get_template_directory() . '/css/global.css' );

	wp_enqueue_style( 'tangent-global-theme-style', get_template_directory_uri() . '/css/global.css', array(), $css_version );
}
add_action( 'wp_enqueue_scripts', 'Tangent\Enqueue\global_theme_styles' );

/**
 * Enqueue the `scripts.js` file and associated dependencies.
 *
 * The `scripts.js` file is enqueued on all pages and is used for global scripts.
 *
 * @return void
 */
function front_end_scripts() {

	$asset_file   = include get_template_directory() . '/js/scripts.asset.php';
	$dependencies = $asset_file['dependencies'];

	wp_enqueue_script( 'tangent-front-end-scripts', get_template_directory_uri() . '/js/scripts.js', $dependencies, $asset_file['version'], true );
}
add_action( 'wp_enqueue_scripts', 'Tangent\Enqueue\front_end_scripts' );

/**
 * Load all block stylesheets separately
 *
 * @return bool True to load all block stylesheets separately.
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Enqueue Per Block Stylesheets for any blocks that have a corresponding stylesheet in the css/ folder.
 *
 * The stylesheet filename must be in the format of `block-namespace--block-name.css`.
 *
 * @return void
 */
function enqueue_block_specific_styles() {

	/**
	 * Get all the block stylesheets with the block namespace/name as the key.
	 * e.g. array( 'core/group' => array( 'path' => '/path/to/file.css', 'src' => 'https://example.com/path/to/file.css' ) )
	 */
	$styled_blocks = get_block_specific_stylesheets();
	// Enqueue the stylesheet for each block.
	foreach ( $styled_blocks as $block_name => $stylesheet_path ) {
		$args = array(
			'handle' => $block_name,
			'path'   => $stylesheet_path['path'],
			'src'    => $stylesheet_path['src'],
		);
		wp_enqueue_block_style( $block_name, $args );
	}
}

add_action( 'after_setup_theme', 'Tangent\Enqueue\enqueue_block_specific_styles' );

/**
 * Get all the Block Specific CSS files in the css/ folder.
 *
 * @return array An array of all the CSS stylesheet information in the
 * `css/` folder keyed to the block name.
 */
function get_block_specific_stylesheets() {
	$get_all_css_files = glob( get_stylesheet_directory() . '/css/*.css' );
	$css_files         = array_reduce( $get_all_css_files, 'Tangent\Enqueue\associative_array_of_blocks_and_stylesheet_args', array() );
	return $css_files;
}

/**
 * Get the block name and stylesheet path from the filename and
 * create an array element for each block with the block name as the key
 * and the file path and URL in an array as the value.
 *
 * @param array  $accumulator The array of block names and stylesheet paths.
 * @param string $css_file The path to the CSS file.
 * @return array The array of block names and stylesheet paths.
 */
function associative_array_of_blocks_and_stylesheet_args( $accumulator, $css_file ) {
	// Hard coded values to exclude certain stylesheets.
	// TODO: Make this dynamic or provide a way to exclude stylesheets through /setup.php.
	$exclude_stylesheets = array( 'global.css', 'editor.css' );

	if ( in_array( basename( $css_file ), $exclude_stylesheets, true ) ) {
		return $accumulator;
	}

	$pattern = '/(.+)--(.+)\.css/i';  // e.g. core--group.css.
	preg_match( $pattern, basename( $css_file ), $matches );

	$block_name = $matches[1] . '/' . $matches[2];

	$accumulator[ $block_name ]['path'] = $css_file;
	$accumulator[ $block_name ]['src']  = str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $css_file );

	return $accumulator;
}

/**
 * Enqueue editor specific modifications in the Post Editor, Site Editor,
 * and Widgets Editor.
 *
 * This function enqueues the `editor.js` file found in `/src/js` and
 * adds extra dependencies depending on the current screen (post, widgets, site-editor).
 *
 * @return void
 */
function enqueue_editor_modifications() {
	$asset_file   = include get_template_directory() . '/js/editor.asset.php';
	$dependencies = $asset_file['dependencies'];

	// Add extra dependencies depending on the current screen.
	$screen = get_current_screen();
	switch ( $screen->base ) {
		case 'post':
			$dependencies[] = 'wp-edit-post';
			break;

		case 'widgets':
			$dependencies[] = 'wp-edit-widgets';
			break;

		case 'site-editor':
			$dependencies[] = 'wp-edit-site';
			break;
	}

	wp_enqueue_script( 'tangent-editor-modifications', get_template_directory_uri() . '/js/editor.js', $dependencies, $asset_file['version'], true );
}

add_action( 'enqueue_block_editor_assets', 'Tangent\Enqueue\enqueue_editor_modifications' );

/**
 * Enqueue the `comment-reply` script if threaded comments are enabled.
 *
 * @return void
 */
function enqueue_threaded_comment_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'comment_form_before', 'Tangent\Enqueue\enqueue_threaded_comment_reply' );

/**
 * Enqueue the `editor.css` file in the Block Editor.
 *
 * @return void
 */
function add_editor_styles() {
	add_editor_style( 'css/editor.css' );
}
add_action( 'after_setup_theme', 'Tangent\Enqueue\add_editor_styles' );



/**
 * Get all block folders in the blocks/ folder and register each block.
 * This will work for native blocks of any kind, as well as for ACF Blocks.
 *
 * Remember to create your blocks in src/blocks, then those will be compiled
 * to the blocks/ folder.
 *
 * @return void
 */
function register_blocks() {
	$block_folders = glob( get_stylesheet_directory() . '/blocks/*', GLOB_ONLYDIR );
	foreach ( $block_folders as $block_folder ) {
		// register_block_type( $block_folder );
	}
}

add_action( 'init', 'Tangent\Enqueue\register_blocks' );
