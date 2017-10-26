<?php
/**
 * Init Storefront for page builder
 * @author shramee
 * @package storefront_for_page_builder
 */

/**
 * Enqueue storefront stylesheet
 * @action wp_enqueue_scripts
 */
function storefront_for_page_builder_enqueue() {
	wp_enqueue_style( 'sf-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'storefront_for_page_builder_enqueue' );

/**
 * Adds pb page styles to pb html
 * @param string $html page builder HTML
 * @return string pb html with pb page styles
 * @filter pootlepb_render
 */
function storefront_for_page_builder_pb_styles( $html ) {
	$html .= '
    <style>
		.no-wc-breadcrumb .site-header {
			margin-bottom: 0;
		}
		.hentry .entry-header, .woocommerce-breadcrumb{
			display: none;
		}
		#secondary {
			margin-top: 4.236em;
		}
    </style>
    ';

	return $html;
}
add_filter( 'pootlepb_render', 'storefront_for_page_builder_pb_styles' );