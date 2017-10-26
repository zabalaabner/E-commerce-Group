<?php
/**
 * FotoGraphy functions and definitions
 *
 * @package FotoGraphy
 */

/**
 * Enqueue scripts Admin Section.
 */
if ( ! function_exists( 'fotography_admin_script' ) ) :
    function fotography_admin_script() {
        wp_enqueue_script('fotography-script', get_template_directory_uri() . '/inc/js/custom.js', array('jquery'),'20151217',true);
        wp_enqueue_style('fotography-custom-style', get_template_directory_uri() . '/inc/css/custom.css');
    }
    add_action('admin_enqueue_scripts', 'fotography_admin_script');
endif;


/**
 * Enqueue scripts Customize Controls Section.
**/
if ( ! function_exists( 'fotography_customize_controls_enqueue_scripts' ) ) :
    function fotography_customize_controls_enqueue_scripts() {
        wp_enqueue_script('fotography-customize-custom', get_template_directory_uri() . '/inc/js/customize_custom.js', array( 'jquery'),'20151217',true);
    }
add_action('customize_controls_enqueue_scripts', 'fotography_customize_controls_enqueue_scripts');
endif;


/* ---------------------Website layout--------------------------------- */

if ( ! function_exists( 'fotography_website_layout_class' ) ) :
function fotography_website_layout_class($classes) {
    $website_layout = get_theme_mod('fotography_webpage_layout','fullwidth');
    if ($website_layout == 'boxed') {

        $classes[] = 'boxed-layout';
    } else {
        $classes[] = 'fullwidth-layout';
    }
   // return $classes;
    $noslider = get_theme_mod('fotography_homepage_slider_setting_option');
    if($noslider == 'disable'){
        $classes[] = 'no-slider';
    }
    return $classes;
}
add_filter('body_class', 'fotography_website_layout_class');
endif;

/* ---------------------Bx Slider Settings Section--------------------------------- */
if ( ! function_exists( 'fotography_bxslider_setting' ) ) :
function fotography_bxslider_setting() {
    $fotography_controls = (get_theme_mod('fotography_homepage_slider_show_controls','yes')=='yes') ? 'true' : 'false';
    $fotography_caption = (get_theme_mod('fotography_homepage_slider_show_caption','yes')=='yes') ? 'true' : 'false';    
?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#slides').bxSlider({
                pager: <?php echo esc_attr($fotography_controls); ?>,
                captions: <?php echo esc_attr($fotography_caption); ?>,
                mode:'fade',
                auto:true,
                controls: false,
                adaptiveHeight : true
            });
        });
    </script>
    <?php
}
add_filter('wp_footer', 'fotography_bxslider_setting');
endif;

/* * *************************Word Count Limit****************************************** */
if ( ! function_exists( 'custom_excerpt_more' ) ) :
    function custom_excerpt_more( $more ) {
    	return '...';
    }
    add_filter( 'excerpt_more', 'custom_excerpt_more' );
endif;
if ( ! function_exists( 'fotography_word_count' ) ) :
    function fotography_word_count($string, $limit) {
        
        $striped_content = strip_tags($string);
        $striped_content = strip_shortcodes($striped_content);

        $words = explode(' ', $striped_content);
        return implode(' ', array_slice($words, 0, $limit));
    }
endif;

if ( ! function_exists( 'fotography_letter_count' ) ) :
    function fotography_letter_count($content, $limit) {
        $striped_content = strip_tags($content);
        $striped_content = strip_shortcodes($striped_content);
        $limit_content = mb_substr($striped_content, 0, $limit);
        if ($limit_content < $content) {
            $limit_content .= "...";
        }
        return $limit_content;
    }
endif;

/* -----------------------Add Grid In Post Class---------------------------------- */
if ( ! function_exists( 'fotography_grid_class' ) ) :
    function fotography_grid_class($classes) {
        $blog_grid = esc_attr(get_theme_mod('fotography_blog_grid_archive_section'));
        $blog_layout = esc_attr(get_theme_mod('fotography_blog_page_archive_section'));
        if ($blog_layout == 'gridview') {
            if ($blog_grid == '1') {
                $classes[] = 'one';
            } elseif ($blog_grid == '2') {
                $classes[] = 'two';
            } elseif ($blog_grid == '3') {
                $classes[] = 'three';
            } else {
                $classes[] = 'four';
            }
        }
        return $classes;
    }
add_filter('post_class', 'fotography_grid_class');
endif;

/* -----------------------Dynamic styles on header---------------------------------- */
if ( ! function_exists( 'fotography_header_sectin' ) ) :
    function fotography_header_sectin() {
        $favicon = get_theme_mod('fotography_favicon_setting_upload');
        if (!empty($favicon)):
            echo "<link type='image/png' rel='icon' href='" . esc_url($favicon) . "'/>\n";
        endif;
    }
    add_action('wp_head', 'fotography_header_sectin');
endif;
/**
 * Implement the custom metabox feature
 */
require get_template_directory() . '/inc/custom-metabox.php';

/**
 * Load Customizer Themes Options
 */
require get_template_directory() . '/inc/fotography-customizer.php';

/**
 * Load Widget Area
 */
require get_template_directory() . '/inc/fotography-widgets.php';

/* -------------------------Customizer Control for Category------------------------------ */

if (class_exists('WP_Customize_Control')) {
    class WP_Category_Checkboxes_Control extends WP_Customize_Control {
        public $type = 'category-checkboxes';
        public function render_content() {
            echo '<script src="' . get_template_directory_uri() . '/js/theme-customizer.js"></script>';
            echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
            foreach (get_categories() as $category) {
                echo '<label><input type="checkbox" name="category-' . $category->term_id . '" id="category-' . $category->term_id . '" class="cstmzr-category-checkbox"> ' . $category->cat_name . '</label><br>';
            }
            ?>
            <input type="hidden" id="<?php echo $this->id; ?>" class="cstmzr-hidden-categories" <?php $this->link(); ?> value="<?php echo sanitize_text_field($this->value()); ?>">
            <?php
        }
    }
}

/**************************** Main Banner Slider ************************************** */
if ( ! function_exists( 'fotography_main_slider' ) ) :
function fotography_main_slider() {
    ?>
    <!-- Slider Section Start here -->
    <?php if (esc_attr(get_theme_mod('fotography_homepage_slider_setting_option','disable')) == 'enable') { ?>
        <div class="fg-banner-slider">
            <div id="slides">
                <?php 
                    $fotography_slider = get_theme_mod('fotography_homepage_advance_slider');
                    if(!empty($fotography_slider)){
                        $fotography_pro_sliders = json_decode($fotography_slider);
                        foreach ($fotography_pro_sliders as $slider) {

                        $website_layout = get_theme_mod('fotography_webpage_layout','fullwidth');
    
                ?>
                    <div class="single-slide">

                        <img src="<?php echo esc_url($slider->image_url); ?>"/>
                        <?php if (esc_attr(get_theme_mod('fotography_homepage_slider_show_caption','yes')) == 'yes') { ?>
                            <div class="caption">
                                <div class="title fadeInDown animated"><?php echo esc_attr($slider->title);?></div>
                                <div class="desc fadeInUp animated">
                                    <?php echo $slider->text; ?>
                                    <?php if(!empty($slider->link) && !empty($slider->subtitle)) { ?>
                                        <div class="caption-link">
                                        <a href="<?php echo esc_url($slider->link); ?>">
                                            <?php echo esc_attr($slider->subtitle); ?>
                                        </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } } ?>
            </div>
        </div>       
    <?php
    }
}
endif;
/**************************** Our Services Area Function *********************** */
if ( ! function_exists( 'fotography_our_services' ) ) :
function fotography_our_services() {
    $services_one = esc_attr(get_theme_mod('fotography_homepage_services_page_one'));
    $services_two = esc_attr(get_theme_mod('fotography_homepage_services_page_two'));
    $services_three = esc_attr(get_theme_mod('fotography_homepage_services_page_three'));
    $title = esc_attr(get_theme_mod('fotography_homepage_our_service_title','Our Services'));
    ?>

    <div class="section-title">
        <?php echo $title; ?>   
    </div>

    <div class="service-box-wrap clearfix">
    <?php
    $query = new WP_Query('page_id=' . $services_one);
    while ($query->have_posts()) : $query->the_post();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fotography-our-services', true);
        ?>
        <div class="service-box">
            <a href="<?php echo esc_url(the_permalink()); ?>" class="clearfix">
                <div class="service-image">
                    <img src="<?php echo esc_url($image[0]); ?>"/>
                </div>
                <div class="service-hover red">
                    <div class="post-title"><span class="table_cell"><?php the_title(); ?></span></div>
                </div>
            </a>
        </div>
        <?php
    endwhile;
    wp_reset_query();

    $query = new WP_Query('page_id=' . $services_two);
    while ($query->have_posts()) : $query->the_post();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fotography-our-services', true);
        ?>
        <div class="service-box">
            <a href="<?php echo esc_url(the_permalink()); ?>" class="clearfix">
                <div class="service-image">
                    <img src="<?php echo esc_url($image[0]); ?>"/>
                </div>
                <div class="service-hover blue">
                    <div class="post-title"><span class="table_cell"><?php the_title(); ?></span></div>            
                </div>
            </a>
        </div>
        <?php
    endwhile;
    wp_reset_query();

    $query = new WP_Query('page_id=' . $services_three);
    while ($query->have_posts()) : $query->the_post();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fotography-our-services', true);
        ?>
        <div class="service-box">
            <a href="<?php echo esc_url(the_permalink()); ?>" class="clearfix">
                <div class="service-image">
                    <img src="<?php echo esc_attr($image[0]); ?>"/>
                </div>
                <div class="service-hover green">
                    <div class="post-title">
                        <span class="table_cell"><?php the_title(); ?></span>
                    </div>
                </div>
            </a>

        </div>
        </div>
        <?php
    endwhile;
    wp_reset_query();
}
endif;

/**************************** Our Home Blogs Area Function *********************** */
if ( ! function_exists( 'fotography_homeblogs' ) ) :
    function fotography_homeblogs() {
        $category_slug = esc_attr(get_theme_mod('fotography_homepage_blog_cat','uncategorized'));
        $title = esc_attr(get_theme_mod('fotography_homepage_blogs_title','Blog Posts'));
    ?>      

            <div class="section-title">
                <?php echo $title; ?>   
            </div>
              
            <div class="fg-latest-post clearfix">
                <?php                         
                  $args = array( 
                    'posts_per_page' => 3,
                    'category_name' => $category_slug
                  );
                  $query = new WP_Query($args);
                  if ($query->have_posts()): while ($query->have_posts()) : $query->the_post();
                ?>
                  <div class="post-item">
                        <div class="fg-post-img-wrap">
                            <a href="<?php the_permalink(); ?>">                      
                                <?php
                                    if ( has_post_thumbnail() ) {
                                      $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fotography-homeblog', true);            
                                       echo '<img class="blog-image" src="' . $image[0]. '" />'; 
                                  }
                                ?>
                            </a>
                            <div class="fg-post-date-comment clearfix">
                                <div class="fg-post-date">
                                    <i class="fa fa-calendar-o"></i>
                                    <span><?php the_time('d') ?></span>
                                    <span><?php the_time('M'); ?></span>
                                </div>

                                <div class="fg-comment">
                                <i class="fa fa-comment-o"></i>
                                <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
                                </div>
                            </div>
                        </div>
                        

                        <div class="fg-post-content">
                            <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                            <div class="fg-item-excerpt">
                            <?php echo fotography_word_count(get_the_excerpt(), 25)."..."; ?>
                            </div>
                            

                            <a class="bttn" href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'fotography' ) ?></a>
                        </div>               
                  </div>
                <?php endwhile; endif;  wp_reset_query(); ?>
            </div>
    <?php
    }
endif;

/* * *************************** About Us Section ***************************************** */
if ( ! function_exists( 'fotography_aboutus' ) ) :
function fotography_aboutus() {
    $aboutus = get_option('theme_mods_fotography');
    $about_page = esc_attr(get_theme_mod('fotography_homepage_about_page'));
    $about_desc = intval(get_theme_mod('fotography_homepage_about_desc_limit',25));       
            query_posts('page_id=' . $about_page);
            while (have_posts()) : the_post();                
                if ( has_post_thumbnail() ) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fotography-about-section', true);
                ?>
                <div class="about-feature-img" style="background-image:url(<?php echo esc_url($image[0]); ?>)">
                </div>
                <?php } ?>
                <div class="about_desc clearfix">
                    <div class="section-title">
                        <?php
                        if (!empty($about_title)) : 
                            echo esc_attr($about_title);
                        endif;
                        ?>
                        <span><?php the_title(); ?></span>
                    </div>

                          
                    <div class="aboutus-subtitle">
                        <?php the_content(); ?>
                    </div>      
                </div>
        <?php 
    endwhile;
    wp_reset_query();
}
endif;


function fotography_counter(){
    $counter_one = esc_attr(get_theme_mod('fotography_homepage_about_counter_one'));
    $title_one = esc_attr(get_theme_mod('fotography_homepage_about_title_one'));
    $icon_one = esc_attr(get_theme_mod('fotography_homepage_about_icon_one'));

    $counter_two = esc_attr(get_theme_mod('fotography_homepage_about_counter_two'));
    $title_two = esc_attr(get_theme_mod('fotography_homepage_about_title_two'));
    $icon_two = esc_attr(get_theme_mod('fotography_homepage_about_icon_two'));

    $counter_three = esc_attr(get_theme_mod('fotography_homepage_about_counter_three'));
    $title_three = esc_attr(get_theme_mod('fotography_homepage_about_title_three'));
    $icon_three = esc_attr(get_theme_mod('fotography_homepage_about_icon_three'));

    $counter_four = esc_attr(get_theme_mod('fotography_homepage_about_counter_four'));
    $title_four = esc_attr(get_theme_mod('fotography_homepage_about_title_four'));
    $icon_four = esc_attr(get_theme_mod('fotography_homepage_about_icon_four'));

    $counter_five = esc_attr(get_theme_mod('fotography_homepage_about_counter_five'));
    $title_five = esc_attr(get_theme_mod('fotography_homepage_about_title_five'));
    $icon_five = esc_attr(get_theme_mod('fotography_homepage_about_icon_five'));       
    ?>
    <div class="about-counter-wrap clearfix">
        <div class="about-counter">
            <div class="counter counter-one">
             <?php
                if (!empty($counter_one)) : echo $counter_one;
                endif;
             ?>
            </div>
            <h6 class="counter-title title-one"><?php
                if (!empty($title_one)) : echo $title_one;
                endif;
                ?>
            </h6>
            <span class="counter-icon icon-one">                                    
                <i class="fa <?php if (!empty($icon_one)){ echo $icon_one; } ?> fa-2x"></i>
            </span>
        </div>

        <div class="about-counter">
            <div class="counter counter-two">
            <?php
                if (!empty($counter_two)) : echo $counter_two;
                endif;
                ?>
            </div>
            
            <h6 class="counter-title title-two">
            <?php
                if (!empty($title_two)) : echo $title_two;
                endif;
                ?>
            </h6>

            <span class="counter-icon icon-two">
            <i class="fa <?php
                if (!empty($icon_two)) : echo $icon_two;
                endif
                ?> fa-2x"></i>
            </span>
        </div>

        <div class="about-counter">

            <div class="counter counter-three"><?php
                if (!empty($counter_three)) : echo $counter_three;
                endif;
                ?>
            </div>

            <h6 class="counter-title title-three"><?php
                if (!empty($title_three)) : echo $title_three;
                endif;
                ?>
            </h6>

            <span class="counter-icon icon-three">
            <i class="fa <?php
                if (!empty($icon_three)) : echo $icon_three;
                endif
                ?> fa-2x"></i>
            </span>
        </div>

        <div class="about-counter">
            <div class="counter counter-four"><?php
                if (!empty($counter_four)) : echo $counter_four;
                endif;
                ?>
            </div>

            <h6 class="counter-title title-four"><?php
                if (!empty($title_four)) : echo $title_four;
                endif;
                ?>
            </h6>

            <span class="counter-icon icon-four"><i class="fa <?php
                if (!empty($icon_four)) : echo $icon_four;
                endif
                ?> fa-2x"></i>
            </span>
        </div>                             
    </div>
<?php
}

/* * ******************************** Call To Action Section  ************************************** */
if ( ! function_exists( 'fotography_call_to_action' ) ) :
function fotography_call_to_action() {
        $fg_bg_image = get_theme_mod('fotography_homepage_call_action_image');
        $fg_call_title = get_theme_mod('fotography_homepage_call_action_title','Need A Photographer ?');
        $fg_call_sub_title = get_theme_mod('fotography_homepage_call_action_sub_title');
        $fg_call_button_link = get_theme_mod('fotography_homepage_call_action_button_link');
        $fg_call_button_text = get_theme_mod('fotography_homepage_call_action_button_name','Hire Me');
    ?>
        <div class="call-to-action" <?php if(!empty($fg_bg_image)){ ?> style="background-image:url(<?php echo esc_url( $fg_bg_image ); ?>); background-size: cover; <?php } ?>">   
            <div class="foto-container">
                <div class="section-title"><?php echo esc_attr( $fg_call_title ); ?></div>
                <div class="call-to-action-subtitle"><?php echo esc_attr( $fg_call_sub_title ); ?></div>
                <?php if( !empty($fg_call_button_text) ){ ?>
                    <div class="call-to-action-button">
                        <a class="bttn" href="<?php echo esc_url( $fg_call_button_link ); ?>"><?php echo esc_attr( $fg_call_button_text ); ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php
}
endif;


/* * ******************************** Quick Contact Info ************************************** */
if ( ! function_exists( 'fotography_quick_contact' ) ) :
function fotography_quick_contact() {
    $email_icon = get_theme_mod('fotography_homepage_quick_email_icon');
    $email = esc_attr(get_theme_mod('fotography_homepage_quick_email'));
    $twitter_icon = esc_attr(get_theme_mod('fotography_homepage_quick_twitter_icon'));
    $twitter = esc_attr(get_theme_mod('fotography_homepage_quick_twitter'));
    $phone_icon = esc_attr(get_theme_mod('fotography_homepage_quick_phone_icon'));
    $phone = esc_attr(get_theme_mod('fotography_homepage_quick_phone'));
    ?>
    <div class="fg-email">
        <a href="mailto:<?php echo $email; ?>">
            <div class="email-icon">
                <i class="fa <?php echo $email_icon; ?>"></i>
            </div>
            <div class="email-address">
                <?php echo $email; ?>
            </div>
        </a>
    </div>

    <div class="fg-twitter">
        <a href="https://twitter.com/<?php echo $twitter; ?>" target="_blank">
            <div class="twitter-icon">
                <i class="fa <?php echo $twitter_icon; ?>"></i>
            </div>
            <div class="twitter-address">
                <?php if(!empty($twitter)) : ?>
                    @<?php echo $twitter; ?>
                <?php endif; ?>
            </div>
        </a>
    </div>

    <div class="fg-phone">
        <a href="callto:<?php echo $phone; ?>">
            <div class="phone-icon">
                <i class="fa <?php echo $phone_icon; ?> fa-2x"></i>
            </div>
            <div class="phone-number">
                <?php echo $phone; ?>
            </div>
        </a>
    </div>
    <?php
}
endif;

if(class_exists( 'WP_Customize_control')){
    /**
     * Pro customizer section.
     *
     * @since  1.0.0
     * @access public
     */
    class Fotography_Customize_Section_Pro extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'fotography-pro';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';
        public $pro_text1 = '';
        public $title1 = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';
        public $pro_url1 = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();
            $json['pro_text'] = $this->pro_text;
            $json['title1'] = $this->title1;
            $json['pro_text1'] = $this->pro_text1;
            $json['pro_url']  = esc_url( $this->pro_url );
            $json['pro_url1']  = $this->pro_url1;
            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title }}
                    <# if ( data.pro_text && data.pro_url ) { #>
                        <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
                <h3 class="accordion-section-title">
                    {{ data.title1 }}
                    <# if ( data.pro_text1 && data.pro_url1 ) { #>
                        <a href="{{ data.pro_url1 }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text1 }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }
    }
}

/**
 * Registers an editor stylesheet for the theme.
 */
function fotography_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'admin_init', 'fotography_add_editor_styles' );