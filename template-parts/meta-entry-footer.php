<?php
/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @link https://developer.wordpress.org/themes/basics/template-tags/
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

// Hide category and tag text for pages.
if ( 'post' === get_post_type( $args['post_id'] ) ) {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'tangent' ), '', $args['post_id'] );
	if ( $categories_list ) {
		/* translators: 1: list of categories. */
		printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'tangent' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'tangent' ), '', $args['post_id'] );
	if ( $tags_list ) {
		/* translators: 1: list of tags. */
		printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'tangent' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! is_single( $args['post_id'] ) && ! post_password_required( $args['post_id'] ) && ( comments_open( $args['post_id'] ) || get_comments_number( $args['post_id'] ) ) ) {
	echo '<span class="comments-link">';
	comments_popup_link(
		sprintf(
			wp_kses(
				/* translators: %s: post title */
				__( 'Leave a Comment<span class="visually-hidden"> on %s</span>', 'tangent' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			wp_kses_post( get_the_title( $args['post_id'] ) )
		)
	);
	echo '</span>';
}

edit_post_link(
	sprintf(
		wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
			__( 'Edit <span class="visually-hidden">%s</span>', 'tangent' ),
			array(
				'span' => array(
					'class' => array(),
				),
			)
		),
		wp_kses_post( get_the_title( $args['post_id'] ) )
	),
	'<span class="edit-link">',
	'</span>',
	$args['post_id']
);
