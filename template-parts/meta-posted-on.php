<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tangent
 *
 * @param args array {
 *    Optional. Array of arguments.
 *
 *    @type int $post_id The post ID. Default is the current post ID.
 *
 * }
 */

$args = wp_parse_args(
	$args,
	array(
		'post_id' => get_the_ID(),
	)
);

$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
if ( get_the_time( 'U', $args['post_id'] ) !== get_the_modified_time( 'U', $args['post_id'] ) ) {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated visually-hidden" datetime="%3$s">%4$s</time>';
}

$time_string = sprintf(
	$time_string,
	esc_attr( get_the_date( DATE_W3C, $args['post_id'] ) ),
	esc_html( get_the_date( '', $args['post_id'] ) ),
	esc_attr( get_the_modified_date( DATE_W3C, $args['post_id'] ) ),
	esc_html( get_the_modified_date( '', $args['post_id'] ) )
);

$posted_on = sprintf(
	/* translators: %s: post date. */
	esc_html_x( 'Posted on %s', 'post date', 'tangent' ),
	'<a href="' . esc_url( get_permalink( $args['post_id'] ) ) . '" rel="bookmark">' . $time_string . '</a>'
);
?>

<span class="posted-on"><?php echo $posted_on; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
