<?php
/**
 * BlockTheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BlockTheme
 */

namespace BlockTheme;

/**
 * Load theme setup.
 */
require_once get_template_directory() . '/inc/setup.php';

/**
 * Enqueue general scripts and styles.
 */
require_once get_template_directory() . '/inc/enqueue.php';

/**
 * Enqueue blocks related scripts, styles, and functionality.
 */
require_once get_template_directory() . '/inc/enqueue-blocks.php';
