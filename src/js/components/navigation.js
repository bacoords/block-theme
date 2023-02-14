import MicroModal from 'micromodal';

// Open on click functionality.
function closeSubmenus( element ) {
	element
		.querySelectorAll( '[aria-expanded="true"]' )
		.forEach( function ( toggle ) {
			toggle.setAttribute( 'aria-expanded', 'false' );
		} );
}


// Based on https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/navigation/view.js
function toggleSubmenuOnClick( event ) {
	const buttonToggle = event.target.closest( '[aria-expanded]' );
	const isSubmenuOpen = buttonToggle.getAttribute( 'aria-expanded' );

	if ( isSubmenuOpen === 'true' ) {
		closeSubmenus( buttonToggle.closest( '.menu-item' ) );
	} else {
		// Close all sibling submenus.
		const parentElement = buttonToggle.closest(
			'.menu-item'
		);
		const navigationParent = buttonToggle.closest(
			'.sub-menu, .menu-modal'
		);
		navigationParent
			.querySelectorAll( '.menu-item' )
			.forEach( function ( child ) {
				if ( child !== parentElement ) {
					closeSubmenus( child );
				}
			} );
		// Open submenu.
		buttonToggle.setAttribute( 'aria-expanded', 'true' );
	}
}

// Necessary for some themes such as TT1 Blocks, where
// scripts could be loaded before the body.
window.addEventListener( 'load', () => {
	const submenuButtons = document.querySelectorAll(
		'.sub-menu-toggle'
	);
	
	submenuButtons.forEach( function ( button ) {
		button.addEventListener( 'click', toggleSubmenuOnClick );
	} );

	// Close on click outside.
	document.addEventListener( 'click', function ( event ) {
		const navigationMenus = document.querySelectorAll(
			'.has-accessible-submenu > .menu'
		);
		navigationMenus.forEach( function ( menu ) {
			if ( ! menu.contains( event.target ) ) {
				closeSubmenus( menu );
			}
		} );
	} );
	// Close on focus outside or escape key.
	document.addEventListener( 'keyup', function ( event ) {
		const submenuBlocks = document.querySelectorAll(
			'.menu-item.menu-item-has-children'
		);
		submenuBlocks.forEach( function ( block ) {
			if ( ! block.contains( event.target ) ) {
				closeSubmenus( block );
			} else if ( event.key === 'Escape' ) {
				const toggle = block.querySelector( '[aria-expanded="true"]' );
				closeSubmenus( block );
				// Focus the submenu trigger so focus does not get trapped in the closed submenu.
				toggle?.focus();
			}
		} );
	} );

	// Initializes offcanvas modal.
	MicroModal.init();
} );