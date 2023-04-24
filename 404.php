<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Tangent
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">

			<div class="entry-content">
				<?php block_template_part( '404-page' ); ?>
			</div>

		</section>

	</main>

<?php
get_footer();
