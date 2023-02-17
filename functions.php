<?php
/**
 * Tangent functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tangent
 */

namespace Tangent;

/**
 * Load theme setup.
 */
require_once get_template_directory() . '/inc/setup.php';

/**
 * Enqueue scripts and styles.
 */
require_once get_template_directory() . '/inc/enqueue.php';

/**
 * Load navwalker class.
 */
require_once get_template_directory() . '/inc/class-tangent-navwalker.php';

/**
 * Load helpers to access design tokens from theme.json
 */
require_once get_template_directory() . '/inc/access-design-tokens.php';
