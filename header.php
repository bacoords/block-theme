<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tangent
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="visually-hidden" href="#primary"><?php esc_html_e( 'Skip to content', 'tangent' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			if ( ! has_custom_logo() ) :
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$site_description = get_bloginfo( 'description', 'display' );
				if ( $site_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $site_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			<?php else : ?>
				<?php the_custom_logo(); ?>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">

			<button class="menu-toggle" aria-haspopup="true" data-micromodal-trigger="navigation-modal" aria-label="<?php esc_html_e( 'Primary Menu', 'tangent' ); ?>">
				<span class="menu-icon"><span></span></span>
			</button>

			<div id="navigation-modal" class="menu-modal" aria-hidden="true">

				<div tabindex="-1" data-micromodal-close>

					<div role="dialog" aria-modal="true" aria-label="<?php esc_html_e( 'Menu', 'tangent' ); ?>" >

						<header>
							<button class="menu-close" aria-label="<?php esc_html_e( 'Close Menu', 'tangent' ); ?>" data-micromodal-close>
								<span class="menu-icon"><span></span></span>
							</button>
						</header>

						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'container_id'   => 'navigation-modal-content',
								'depth'          => 2,
								'walker'         => new Tangent\Navwalker\Tangent_Walker(),
							)
						);
						?>

					</div>
				</div>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
