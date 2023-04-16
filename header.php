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

$active_sidebars = is_dynamic_sidebar() ? 'has-sidebar' : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( $active_sidebars ); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="visually-hidden" href="#primary"><?php esc_html_e( 'Skip to content', 'tangent' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container-wide">
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
					<?php block_template_part( 'site-logo' ); ?>
				<?php endif; ?>
			</div>

			<?php get_template_part( 'template-parts/navigation', 'offcanvas' ); ?>
		</div>
	</header>
