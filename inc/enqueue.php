<?php
/**
 * Enqueue scripts and styles.
 *
 * @package BlockTheme
 */

namespace BlockTheme\Enqueue;

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

	wp_enqueue_style( 'block-theme-global-theme-style', get_template_directory_uri() . '/css/global.css', array(), $css_version );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\global_theme_styles' );

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

	wp_enqueue_script( 'block-theme-front-end-scripts', get_template_directory_uri() . '/js/scripts.js', $dependencies, $asset_file['version'], true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\front_end_scripts' );

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

		case 'site-editor':
			$dependencies[] = 'wp-edit-site';
			break;
	}

	wp_enqueue_script( 'block-theme-editor-modifications', get_template_directory_uri() . '/js/editor.js', $dependencies, $asset_file['version'], true );
}

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_editor_modifications' );



/**
 * Enqueue the `editor.css` file in the Block Editor.
 *
 * @return void
 */
function add_editor_styles() {
	add_editor_style( 'css/editor.css' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\add_editor_styles' );
