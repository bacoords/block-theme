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
			<header class="entry-header">
				<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'tangent' ); ?></h1>
			</header>

			<div class="entry-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'tangent' ); ?></p>

					<?php
					get_search_form();
					?>

			</div>
		</section>

	</main>

<?php
get_footer();
