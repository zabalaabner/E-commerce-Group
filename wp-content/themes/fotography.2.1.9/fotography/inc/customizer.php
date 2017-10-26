<?php
/**
 * FotoGraphy Theme Customizer
 *
 * @package FotoGraphy
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotography_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/*------------------------------------------------------------------------------------*/
	/**
	 * Upgrade to Uncode Pro
	*/
	// Register custom section types.
	$wp_customize->register_section_type( 'Fotography_Customize_Section_Pro' );

	// Register sections.
	$wp_customize->add_section(
	    new Fotography_Customize_Section_Pro(
	        $wp_customize,
	        'fotography-pro',
	        array(
	            'title'    => esc_html__( 'Upgrade To Pro', 'fotography' ),
	            'title1'    => esc_html__( 'Free Vs Pro', 'fotography' ),
	            'pro_text' => esc_html__( 'Buy Now','fotography' ),
	            'pro_text1' => esc_html__( 'Compare','fotography' ),
	            'pro_url'  => 'https://accesspressthemes.com/wordpress-themes/fotography-pro/',
	            'pro_url1'  => admin_url( 'themes.php?page=fotography-welcome&section=free_vs_pro'),
	            'priority' => 1,
	        )
	    )
	);
	$wp_customize->add_setting(
		'fotography_pro_upbuton',
		array(
			'section' => 'fotography-pro',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		'fotography_pro_upbuton',
		array(
			'section' => 'fotography-pro'
		)
	);
}
add_action( 'customize_register', 'fotography_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fotography_customize_preview_js() {
	wp_enqueue_script( 'fotography_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'fotography_customize_preview_js' );