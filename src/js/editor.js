/**
 * WordPress dependencies
 */
import {
	unregisterBlockType,
	unregisterBlockStyle,
	unregisterBlockVariation,
	registerBlockStyle,
	registerBlockVariation,
} from '@wordpress/blocks';
import { dispatch } from '@wordpress/data';
import domReady from '@wordpress/dom-ready';

/**
 * Register block styles
 *
 * @type {Object} Add the names of blocks and styles to register here
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
 */
const registerBlockStyles = {
	// "core/cover": [
	// 	{
	// 		name: "hero",
	// 		label: "Hero",
	// 	},
	// ]
};

/**
 * Register block variations
 *
 * @type {Object} Add the names of blocks and variations to register here
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-variations/
 */
const registerBlockVariations = {
	// "core/columns": {
	// 	name: "three-columns-wide-left",
	// 	title: "50 / 25 / 25",
	// 	description: "Three columns; wide left column",
	// 	innerBlocks: [
	// 		["core/column", { width: "50%" }],
	// 		["core/column", { width: "25%" }],
	// 		["core/column", { width: "25%" }],
	// 	],
	// 	scope: ["block"],
	// },
};

/**
 * Unregister blocks
 *
 * @type {Array} Add the names of blocks to unregister here
 * @see https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#using-a-deny-list
 */
const unregisterBlocks = [
	// "core/verse"
];

/**
 * Remove editor panels
 *
 * @type {Array} Add the names of panels to remove here
 * @see https://developer.wordpress.org/block-editor/reference-guides/data/data-core-edit-post/#removeeditorpanel
 */
const removeEditorPanels = [
	//"discussion-panel"
];

/**
 * Remove block styles
 *
 * @type {Object} Add the names of blocks and styles to remove here
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
 */
const unregisterBlockStyles = {
	// "core/button": "outline",
};

/**
 * Remove block variations
 *
 * @type {Object} Add the names of blocks and variations to remove here
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-variations/
 */
const unregisterBlockVariations = {
	// "core/columns": "two-columns-two-thirds-one-third",
};

/**
 * Here we hook into the editor initialization and unregister the blocks,
 * remove editor panels, remove block styles, remove block variations,
 * register block styles, and register block variations – all as defined above.
 */
domReady( function () {
	Object.keys( registerBlockStyles ).forEach( ( block ) => {
		registerBlockStyle( block, registerBlockStyles[ block ] );
	} );
	Object.keys( registerBlockVariations ).forEach( ( block ) => {
		registerBlockVariation( block, registerBlockVariations[ block ] );
	} );
	unregisterBlocks.forEach( ( block ) => {
		unregisterBlockType( block );
	} );

	// Only run if we are in the post editor
	if ( null !== dispatch( 'core/edit-post' ) ) {
		const { removeEditorPanel } = dispatch( 'core/edit-post' );
		removeEditorPanels.forEach( ( panel ) => {
			removeEditorPanel( panel );
		} );
	}
	Object.keys( unregisterBlockStyles ).forEach( ( block ) => {
		unregisterBlockStyle( block, unregisterBlockStyles[ block ] );
	} );
	Object.keys( unregisterBlockVariations ).forEach( ( block ) => {
		unregisterBlockVariation( block, unregisterBlockVariations[ block ] );
	} );
} );
