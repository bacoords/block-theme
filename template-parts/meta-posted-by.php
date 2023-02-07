<?php
/**
 * Displays the author of the current post.
 *
 * @link https://developer.wordpress.org/themes/basics/template-tags/
 *
 * @package Tangent
 */

$byline = sprintf(
	/* translators: %s: post author. */
	esc_html_x( 'by %s', 'post author', 'tangent' ),
	'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
);
?>

<span class="byline"><?php echo $byline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
