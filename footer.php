<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tangent
 */

?>

	<footer id="colophon" class="site-footer">

		<div class="site-info">
			<?php block_template_part( 'footer-credit' ); ?>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
