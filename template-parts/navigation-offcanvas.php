<?php
/**
 * Template part for displaying the offcanvas navigation.
 *
 * @package Tangent
 */

?>
<?php
// don't render the navigation if no menu is assigned.
if ( has_nav_menu( 'menu-1' ) ) {
	?>
<nav id="site-navigation" class="offcanvas-navigation">

	<button class="menu-toggle link-button" aria-haspopup="true" data-micromodal-trigger="navigation-modal" aria-label="<?php esc_html_e( 'Primary Menu', 'tangent' ); ?>">
		<span class="menu-icon"><span></span></span>
	</button>

	<div id="navigation-modal" class="menu-modal" aria-hidden="true">

		<div tabindex="-1" data-micromodal-close>

			<div role="dialog" aria-modal="true" aria-label="<?php esc_html_e( 'Menu', 'tangent' ); ?>" >

				<header>
					<button class="menu-close link-button" aria-label="<?php esc_html_e( 'Close Menu', 'tangent' ); ?>" data-micromodal-close>
						<span class="menu-icon"><span></span></span>
					</button>
				</header>

				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'menu-1',
							'menu_id'         => 'primary-menu',
							'container_id'    => 'navigation-modal-content',
							'container_class' => 'has-accessible-submenu',
							'depth'           => 2,
							'walker'          => new Tangent\Navwalker\Tangent_Navwalker(),
						)
					);
				?>

			</div>
		</div>
	</div>
</nav>
<?php } ?>
