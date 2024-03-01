<?php
/**
 * This file is for custom PHP
 *
 * @package Frost Theme
 */

/**
 * Allow SVG file uploads.
 *
 * @param array $mimes Array of allowed MIME types.
 *
 * @return array
 */
function custom_mime_types( $mimes ) {
	/** Add SVG to the list of allowed file types */
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';

	return $mimes;
}
/** Add filter for allow SVG file uploads */
add_filter( 'upload_mimes', 'custom_mime_types' );

/**
 * Enable SVG thumbnail preview.
 *
 * This function modifies the array of image sizes to include 'SVG Image'.
 *
 * @param array $sizes The array of image sizes.
 *
 * @return array The modified array of image sizes.
 */
function custom_svg_thumb_size( $sizes ) {
	$sizes['svg'] = __( 'SVG Image' );

	return $sizes;
}
add_filter( 'image_size_names_choose', 'custom_svg_thumb_size' );

/**
 * Enable SVG thumbnail preview.
 *
 * This function modifies the array of image sizes to include 'SVG Image'.
 *
 * @param array $upload_mimes The array of allowed MIME types.
 *
 * @return array The modified array of allowed MIME types.
 */
function enable_svg_upload( $upload_mimes ) {
	$upload_mimes['svg'] = 'image/svg+xml';
	$upload_mimes['svgz'] = 'image/svg+xml';
	return $upload_mimes;
}
add_filter( 'upload_mimes', 'enable_svg_upload', 10, 1 );

if ( ! function_exists( 'fa_custom_setup_cdn_webfont' ) ) {
	/**
	 * Font Awesome CDN Setup Webfont
	 *
	 * This will load Font Awesome from the Font Awesome Free or Pro CDN.
	 *
	 * @param string $cdn_url    The URL of the Font Awesome CDN stylesheet.
	 * @param string $integrity  The integrity hash for script integrity verification (optional).
	 * @return void
	 */
	function fa_custom_setup_cdn_webfont( $cdn_url = '', $integrity = null ) {
		$matches = array();
		$match_result = preg_match( '|/([^/]+?)\.css$|', $cdn_url, $matches );
		$resource_handle_uniqueness = ( 1 === $match_result ) ? $matches[1] : md5( $cdn_url );
		$resource_handle = "font-awesome-cdn-webfont-$resource_handle_uniqueness";

		foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
			add_action(
				$action,
				function () use ( $cdn_url, $resource_handle ) {
					wp_enqueue_style( $resource_handle, $cdn_url, array(), null );
				}
			);
		}

		if ( $integrity ) {
			add_filter(
				'style_loader_tag',
				function ( $html, $handle ) use ( $resource_handle, $integrity ) {
					if ( in_array( $handle, array( $resource_handle ), true ) ) {
						return preg_replace(
							'/\/>$/',
							'integrity="' . $integrity .
							'" crossorigin="anonymous" />',
							$html,
							1
						);
					} else {
						return $html;
					}
				},
				10,
				2
			);
		}
	}
}
/**
 * Enqueue Font Awesome CDN Webfont.
 *
 * This line enqueues the Font Awesome CDN Webfont with a specific stylesheet URL.
 *
 * Note: The bellow url shoud be updated with your project url generated in https://fontawesome.com/kits
 */

fa_custom_setup_cdn_webfont(
	'https://kit.fontawesome.com/b19a1fe8b3.css',
	''
);
