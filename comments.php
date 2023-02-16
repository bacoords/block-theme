<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tangent
 */

/**
 * Get the custom design tokens from the theme.json file settings section
 */
$design_tokens = \Tangent\Theme_Json\get_custom_design_tokens();
// See src/theme-json/settings/custom/comments.jsonc for the comments design tokens
$comments_design_tokens = $design_tokens['comments'];
$comment_label_single   = $comments_design_tokens['commentLabelSingle'];
$comment_label_plural   = $comments_design_tokens['commentLabelPlural'];
$comments_avatar_size   = $comments_design_tokens['avatarSize'];
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( '1' === $comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One ' . $comment_label_single . ' on &ldquo;%1$s&rdquo;', 'tangent' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s ' . $comment_label_single . ' on &ldquo;%2$s&rdquo;', '%1$s ' . $comment_label_plural . ' on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'tangent' ) ),
					number_format_i18n( $comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => $comments_avatar_size,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'tangent' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
