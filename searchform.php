<?php
/**
 * The template for displaying search form page as rendered by the core/search block.
 */

$block_registry = \WP_Block_Type_Registry::get_instance();
$block_type     = $block_registry->get_registered( 'core/search' );

// Front-end styles.
foreach ( $block_type->style_handles as $style_handle ) {
	wp_enqueue_style( $style_handle );
}

// Front-end scripts.
foreach ( $block_type->script_handles as $script_handle ) {
	wp_enqueue_script( $script_handle );
}

$attributes = array(
	'showLabel'   => false,
	'buttonText'  => __( 'Search', 'tangent' ),
	'placeholder' => __( 'Search', 'tangent' ),
);

$rendered_search_block = $block_type->render( $attributes );

echo $rendered_search_block;
