<?php
/**
 * This file provides helper function to access the design tokens from
 * the `theme.json`.
 *
 * @package Tangent
 */

namespace Tangent\Theme_Json;

/**
 * Get the custom design tokens from the theme.json file settings section
 *
 * @return array The custom design tokens
 */
function get_custom_design_tokens() {

	$theme_json_settings = get_theme_json_data( 'settings' );
	return $theme_json_settings['custom'];

}

/**
 * Get theme.json settings from the theme.json file
 *
 * @param string $section The section to get from the theme.json file. Must be a root level section (settings, styles, etc)
 * @return array The theme.json $section asked for
 */
function get_theme_json_data( $section = null ) {
	$theme_json = new \WP_Theme_JSON_Resolver();
	$theme_json_from_theme = $theme_json->get_theme_data();
	$theme_json_data = $theme_json_from_theme->get_data();

	return $section ? $theme_json_data[$section] : $theme_json_data;
}
