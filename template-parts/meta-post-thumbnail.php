<?php
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @link https://developer.wordpress.org/themes/basics/template-tags/
 *
 * @package Tangent
 */

$args = wp_parse_args(
	$args,
	array(
		'post_id' => get_the_ID(),
	)
);

if ( post_password_required( $args['post_id'] ) || is_attachment( $args['post_id'] ) || ! has_post_thumbnail( $args['post_id'] ) ) {
	return;
}

if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php echo get_the_post_thumbnail( $args['post_id'] ); ?>
	</div><!-- .post-thumbnail -->

<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink( $args['post_id'] ); ?>" aria-hidden="true" tabindex="-1">
		<?php
			echo get_the_post_thumbnail(
				$args['post_id'],
				'post-thumbnail',
				array(
					'alt' => the_title_attribute(
						array(
							'echo' => false,
						)
					),
				)
			);
		?>
	</a>

	<?php
endif; // End is_singular().
