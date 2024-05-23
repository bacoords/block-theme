<?php
/**
 * Enqueue scripts, styles, and functionality for blocks.
 *
 * @package BlockTheme
 */

namespace BlockTheme\Enqueue\Blocks;

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

	$theme_version = wp_get_theme()->get( 'Version' );
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
			'ver'    => $theme_version . '.' . filemtime( $stylesheet_path['path'] ),
		);
		wp_enqueue_block_style( $block_name, $args );
	}
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\enqueue_block_specific_styles' );

/**
 * Get all the Block Specific CSS files in the css/ folder.
 *
 * @return array An array of all the CSS stylesheet information in the
 * `css/` folder keyed to the block name.
 */
function get_block_specific_stylesheets() {
	$get_all_css_files = glob( get_stylesheet_directory() . '/css/*.css' );
	$css_files         = array_reduce( $get_all_css_files, __NAMESPACE__ . '\associative_array_of_blocks_and_stylesheet_args', array() );
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
	$exclude_stylesheets = array( 'global.css', 'global-rtl.css', 'editor.css', 'editor-rtl.css' );

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
		register_block_type( $block_folder );
	}
}

add_action( 'init', __NAMESPACE__ . '\register_blocks' );

/**
 * Enqueue assets for blocks when specifically requested.
 *
 * Heavily inspired by the Core function wp_enqueue_registered_block_scripts_and_styles()
 * See: https://developer.wordpress.org/reference/functions/wp_enqueue_registered_block_scripts_and_styles/
 *
 * @param string|array $blocks The block name(s) to enqueue assets for, e.g. 'core/group'. Accepts a single block name or an array of block names.
 *
 * @return void
 */
function selectively_enqueue_block_assets( $blocks ) {
	$block_registry = \WP_Block_Type_Registry::get_instance();

	// If passed a single block name, convert it to an array.
	if ( ! is_array( $blocks ) ) {
		$blocks = array( $blocks );
	}

	// Enqueue assets for each block.
	foreach ( $blocks as $block ) {
		$block_type = $block_registry->get_registered( $block );
		if ( ! $block_type ) {
			continue;
		}

		// Front-end and editor styles.
		foreach ( $block_type->style_handles as $style_handle ) {
			wp_enqueue_style( $style_handle );
		}

		// Front-end and editor scripts.
		foreach ( $block_type->script_handles as $script_handle ) {
			wp_enqueue_script( $script_handle );
		}
	}
}
