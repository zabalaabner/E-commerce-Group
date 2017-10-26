<?php
load_theme_textdomain( 'wpshop', get_template_directory().'/languages' );
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
$themename = 'wpshop';
$themetitle = 'WPShop';
function wpshop_page_title($title){
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Home', 'wpshop' ) . ' | ' . get_bloginfo( 'description' );
  }
  return $title;
}
add_filter( 'wp_title', 'wpshop_page_title' );
if (function_exists('add_theme_support')) {
	add_theme_support('menus');
	register_nav_menu('header-menu','Header Menu');
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
}
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 5;
	}
}
function wpshop_add_editor_styles() {
    add_editor_style( 'css/editor-style.css' );
}
add_action( 'admin_init', 'wpshop_add_editor_styles' );
function dess_get_excerpt($num_chars) {
    $temp_str = substr(strip_shortcodes(strip_tags(get_the_content())),0,$num_chars);
    $temp_parts = explode(" ",$temp_str);
    $temp_parts[(count($temp_parts) - 1)] = '';
    if(strlen(strip_tags(get_the_content())) > 125) {
      return implode(" ",$temp_parts) . '...';
    } else {
      return implode(" ",$temp_parts);
    }
}
add_action('wp_enqueue_scripts', 'dess_theme_imports');
function dess_theme_imports(){
	global $themename;
    global $themetitle;
    wp_enqueue_style( 'google-lato-font', 'http://fonts.googleapis.com/css?family=Lato:300,400,500,700,900' );
    wp_enqueue_style( $themename.'_slicknav_style', get_stylesheet_directory_uri().'/css/slicknav.min.css' );
    wp_enqueue_style( $themename.'_slitslider_style', get_stylesheet_directory_uri().'/css/slitslider.css' );
	wp_enqueue_style( $themename.'_style', get_stylesheet_uri(),999 );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( $themename.'_slicknav_script', get_stylesheet_directory_uri() . '/js/jquery.slicknav.min.js' );
	wp_enqueue_script( $themename.'_modernizr_script', get_stylesheet_directory_uri() . '/js/modernizr.custom.79639.js' );
	wp_enqueue_script( $themename.'_cond_script', get_stylesheet_directory_uri() . '/js/jquery.ba-cond.min.js' );
	wp_enqueue_script( $themename.'_slitslider_script', get_stylesheet_directory_uri() . '/js/jquery.slitslider.js' );
	wp_enqueue_script( $themename.'_script', get_stylesheet_directory_uri() . '/js/scripts.js' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('admin_enqueue_scripts', 'dess_admin_imports');
function dess_admin_imports(){
	global $themename;
    global $themetitle;
    wp_enqueue_media();
	wp_enqueue_style( $themename.'_style', get_stylesheet_directory_uri().'/css/admin-style.css' );
	wp_enqueue_script( $themename.'_script', get_stylesheet_directory_uri() . '/js/admin-scripts.js' );
}
function dess_widgets_init() {
	register_sidebar( array(
		'name' => 'Footer Col 1',
		'id' => 'footer-1',
		'before_widget' => '<div id="%1$s" class="widget_box footer_box %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="footer_title">',
		'after_title' => '</h3>'
		) );
	register_sidebar( array(
		'name' => 'Footer Col 2',
		'id' => 'footer-2',
		'before_widget' => '<div id="%1$s" class="widget_box footer_box %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="footer_title">',
		'after_title' => '</h3>'
	) );
	register_sidebar( array(
		'name' => 'Footer Col 3',
		'id' => 'footer-3',
		'before_widget' => '<div id="%1$s" class="widget_box footer_box %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="footer_title">',
		'after_title' => '</h3>'
	) );
	register_sidebar( array(
		'name' => 'Footer Col 4',
		'id' => 'footer-4',
		'before_widget' => '<div id="%1$s" class="widget_box footer_box %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="footer_title">',
		'after_title' => '</h3>'
	) );
	
}
add_action( 'widgets_init', 'dess_widgets_init' );
function dess_post_meta_box() {
	add_meta_box(
			'dess_post_settings',
			__('Post Settings','wpshop'),
			'dess_post_meta_box_callback',
			'post'
		);
}
add_action( 'add_meta_boxes', 'dess_post_meta_box' );
function dess_post_meta_box_callback( $post ) {
	wp_nonce_field( 'dess_post_save_meta_box_data', 'dess_post_meta_box_nonce' );
	// $show_in_homepage = get_post_meta( $post->ID, 'ex_show_in_homepage', true );
	$show_in_slider = get_post_meta( $post->ID, 'show_in_slider', true );
	$type = get_post_meta( $post->ID, 'page_featured_type', true );
	
	// echo '<p><label for="show_in_homepage">Show in Homepage: </label>';
	// echo '<input type="checkbox" id="show_in_homepage" name="ex_show_in_homepage" value="Yes" '.($show_in_homepage ==  'Yes' ? 'checked' : '' ).' /></p>';
	
	
	echo '<p><label for="video_type">'.__('Featured Type','wpshop').': </label><br/>';
	echo '<select id="video_type" name="dess_post[page_featured_type]"><option value="">Image</option><option value="youtube" '.($type == 'youtube' ? 'selected="selected"' : '').'>Youtube</option><option value="vimeo" '.($type == 'vimeo' ? 'selected="selected"' : '').'>Vimeo</option></select></p>';
	echo '<p><label for="video_id">'.__('Video ID','wpshop').': </label><br/>';
	echo '<input type="text" id="video_id" name="dess_post[page_video_id]" value="'.get_post_meta( $post->ID, 'page_video_id', true ).'" /></p>';
}
function dess_post_save_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['dess_post_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['dess_post_meta_box_nonce'], 'dess_post_save_meta_box_data' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	$show_in_homepage = sanitize_text_field( $_POST['show_in_homepage'] );
	$show_in_slider = sanitize_text_field( $_POST['show_in_slider'] );
	
	if ($_POST['show_in_homepage']) {
		update_post_meta( $post_id, 'show_in_homepage', $show_in_homepage );
	}
	if ($_POST['show_in_slider']) {
		update_post_meta( $post_id, 'show_in_slider', $show_in_slider );
	}
	$arr = array();
	if (isset($_POST['dess_post'])){
	$arr = $_POST['dess_post'];
	}
	foreach ($arr as $key => $value) {
		$val = sanitize_text_field($value);
		update_post_meta( $post_id, $key, $val );
	}
}
add_action( 'save_post', 'dess_post_save_meta_box_data' );
function dess_product_meta_box() {
	add_meta_box(
			'dess_product_settings',
			__('Product Settings','wpshop'),
			'dess_product_meta_box_callback',
			'product'
		);
}
add_action( 'add_meta_boxes', 'dess_product_meta_box' );
function dess_product_meta_box_callback( $post ) {
	wp_nonce_field( 'dess_post_save_meta_box_data', 'dess_post_meta_box_nonce' );
	
	$show_in_slider = get_post_meta( $post->ID, 'show_in_slider', true );
	
	echo '<p><label for="show_in_slider">'.__('Show in Slider','wpshop').': </label>';
	echo '<input type="checkbox" id="show_in_slider" name="show_in_slider" value="Yes" '.($show_in_slider ==  'Yes' ? 'checked' : '' ).' /></p>';
	
}
function dess_customize_register($wp_customize){
    $wp_customize->add_section(
	'header_section',
	array( 
		'title' => __('Logo','wpshop'), 
		'capability' => 'edit_theme_options', 
		'description' =>  __('Allows you to edit your theme\'s layout.','wpshop')
	)
	);
	$wp_customize->add_setting('dess_logo', array(
	    'default'           => get_stylesheet_directory_uri().'/images/logo.png',
	    'type'           => 'theme_mod',
	    'sanitize_callback' => 'sanitize_customizer_val',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo', array(
	    'label'    => __('Logo Image','wpshop'),
	    'section'  => 'header_section',
	    'settings' => 'dess_logo',
	)));
	$wp_customize->add_section(
	'sm_section', 
	array( 
		'title' =>  __('Social Media','wpshop'), 
		'capability' => 'edit_theme_options', 
		'description' =>  __('Allows you to set your social media URLs','wpshop')
	)
	);
	$socials = array('twitter','facebook','google-plus','instagram','pinterest','linkedin','vimeo','youtube');
	for($i=0;$i<count($socials);$i++) {
		$name = str_replace('-',' ',ucfirst($socials[$i]));
		$wp_customize->add_setting('dess_'.$socials[$i], array(
	    'capability' => 'edit_theme_options',
	    'type'       => 'theme_mod',
	    'sanitize_callback' => 'sanitize_customizer_val',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'dess_'.$socials[$i], array(
		    'settings' => 'dess_'.$socials[$i],
		    'label'    => $name.' URL',
		    'section'  => 'sm_section',
		    'type'     => 'text',
		)));
	}
	
}
add_action('customize_register', 'dess_customize_register');
function dess_setting($name, $default = false) {
	return get_theme_mod( $name, $default );
}
function sanitize_customizer_val($value){
	return esc_html($value);
}
/*
$custom_back_args = array(
	'default-color' => 'FFFFFF',
	);
add_theme_support( 'custom-background', $custom_back_args );
$custom_header_args = array(
		'default-image' => get_template_directory_uri().'/images/logo.png',
		);
add_theme_support( "custom-header", $custom_header_args );
*/
function dess_excerpt_more( $more ) {
	return ' <a class="read-more-ellipses" href="' . get_permalink( get_the_ID() ) . '">...</a>';
}
add_filter( 'excerpt_more', 'dess_excerpt_more' );
remove_filter('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_filter('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_filter('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 15;' ), 20 );
function wpshop_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 5;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'wpshop_related_products_args' );
  function wpshop_related_products_args( $args ) {
	$args['posts_per_page'] = 5; // 4 related products
	$args['columns'] = 5; // arranged in 2 columns
	return $args;
}
add_action( 'after_setup_theme', 'sold_wc_gallery' );

function sold_wc_gallery() {
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
}
