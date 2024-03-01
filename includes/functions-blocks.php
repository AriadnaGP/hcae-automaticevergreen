<?php
/**
 * Custom ACF Blocks Initialization
 *
 * This file contains functions to initialize custom ACF blocks and register them with WordPress.
 *
 * @package Frost Theme
 */

/**
 * Initialize custom ACF blocks.
 *
 * @param array $block The block settings and attributes.
 * @return void
 */
function my_acf_block_render_callback( $block ) {

		/** Convert name ("acf/testimonial") into path friendly slug ("testimonial") */
	$slug = str_replace( 'acf/', '', $block['name'] );

	/** Include a template part from within the "/blocks" folder */

	if ( file_exists( get_theme_file_path( "/blocks/content-{$slug}.php" ) ) ) {
		include get_theme_file_path( "/blocks/content-{$slug}.php" );
		if ( file_exists( get_theme_file_path( "/blocks/css/content-{$slug}.css" ) ) ) {
			wp_enqueue_style(
				"{$slug}",
				get_stylesheet_directory_uri() . "/blocks/css/content-{$slug}.css",
				array(),
				wp_get_theme( 'goodpeopledigital' )->get( 'Version' )
			);
		}
		if ( file_exists( get_theme_file_path( "/blocks/js/content-{$slug}.js" ) ) ) {
			wp_enqueue_script( "{$slug}", get_stylesheet_directory_uri() . "/blocks/js/content-{$slug}.js", array( 'jquery' ), '1.8.1', true );
		}
	}
}

add_action( 'acf/init', 'my_acf_blocks_init' );

/**
 * This function initializes custom ACF blocks and registers them with WordPress.
 */
function my_acf_blocks_init() {

	/** Check function exists. */
	if ( function_exists( 'acf_register_block' ) ) {

		/** Register a Slider Block block. */
		acf_register_block_type(
			array(
				'name'              => 'example',
				'title'             => __( 'Example Block' ),
				'description'       => __( 'Example Block' ),
				'render_callback' => 'my_acf_block_render_callback',
				'category'          => 'formatting',
				'has_inner_blocks' => true,
				'mode' => 'edit',
				'supports'      => array(
					'align'         => true,
					'anchor'        => true,
					'customClassName'   => true,
					'jsx'           => true,
				),
			)
		);

		/** Register a Custom Query block. */
		acf_register_block_type(
			array(
				'name'              => 'decorative-block',
				'title'             => __( 'Decorative Block' ),
				'description'       => __( 'Decorative Block' ),
				'render_callback' => 'my_acf_block_render_callback',
				'category'          => 'formatting',
				'has_inner_blocks' => true,
				'mode' => 'edit',
				'supports'      => array(
					'align'         => true,
					'anchor'        => true,
					'customClassName'   => true,
					'jsx'           => true,
					'innerBlocks'       => true,
				),
			)
		);

		/** Register a Custom Query block. */
		acf_register_block_type(
			array(
				'name'              => 'custom-query-tabs',
				'title'             => __( 'Custom Query Tabs Block' ),
				'description'       => __( 'Custom Query Tabs Block' ),
				'render_callback' => 'my_acf_block_render_callback',
				'category'          => 'formatting',
				'has_inner_blocks' => true,
				'mode' => 'edit',
				'supports'      => array(
					'align'         => true,
					'anchor'        => true,
					'customClassName'   => true,
					'jsx'           => true,
					'innerBlocks'       => true,
				),
			)
		);

		/** Register a Custom Hero Slider. */
		acf_register_block_type(
			array(
				'name'              => 'custom-hero-slider',
				'title'             => __( 'Custom Hero Slider Block' ),
				'description'       => __( 'Custom Hero Slider Block' ),
				'render_callback' => 'my_acf_block_render_callback',
				'category'          => 'formatting',
				'has_inner_blocks' => true,
				'mode' => 'edit',
				'supports'      => array(
					'align'         => true,
					'anchor'        => true,
					'customClassName'   => true,
					'jsx'           => true,
					'innerBlocks'       => true,
				),
			)
		);

	}
}
