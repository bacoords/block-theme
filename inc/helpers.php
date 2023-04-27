<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Tangent
 */

namespace Tangent\Helpers;

/**
 * Get an SVG file from the imgs/ folder in the theme, update its attributes if necessary and return it as a string.
 *
 * @param string $filename The name of the SVG file to get.
 * @param array $attributes (optional) An array of attributes to add/modify to the SVG file.
 * @param string $directory (optional) The directory to look for the SVG file in, defaults to 'imgs'.
 * @return string|WP_Error The SVG file as a string or a WP_Error object if there was an error.
 */
function get_svg( $filename, $attributes = array(), $directory = 'imgs' ) {
	// Get the SVG file.
	$svg = file_get_contents( get_template_directory() . '/' . $directory . '/' . $filename . '.svg' );

	$errors = new \WP_Error();

	// If there was an error retrieving the SVG file, return a WP_Error object.
	if ( ! $svg ) {
		$svg_error_message = sprintf(
			/* translators: %1$s: SVG file name, %2$s: SVG directory */
			__( 'There was an error retrieving the SVG file "%1$s" from the "%2$s" directory.', 'tangent' ),
			$filename . '.svg',
			$directory
		);

		$errors->add(
			'svg_file_not_found',
			$svg_error_message,
			array(
				'svg_file' => $filename . '.svg',
				'svg_directory' => $directory,
			)
		);
		return $errors;

	}

	// Initialize the SVG tag processor.
	$update_svg = new \WP_HTML_Tag_Processor( $svg );
	$update_svg->next_tag();

	// If there are attributes to add, add them.
	if ( ! empty( $attributes ) ) {
		foreach ( $attributes as $attribute => $value ) {
			// If the attribute is 'class', add the class to the SVG file without overwriting the existing classes.
			if ( 'class' === $attribute ) {
				$update_svg->add_class( $value );
				continue;
			}
			// Otherwise, set/update the attribute with the new value
			$update_svg->set_attribute( $attribute, $value );
		}
	}

	// Return the SVG file.
	return $update_svg->get_updated_html();
}
