<?php
/**
 * Plugin Name: Storefront Extension - Align Menu Right
 * Version: 1.0.0
 * Author: PootlePress
 *
 * Text Domain: sfx-align-menu-right
 * Domain Path: /languages/
 *
 * @package SFX_Align_Menu_Right
 * @category Core
 * @author Alan
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of SFX_Align_Menu_Right to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object SFX_Align_Menu_Right
 */
function SFX_Align_Menu_Right() {
	return SFX_Align_Menu_Right::instance();
} // End SFX_Align_Menu_Right()

SFX_Align_Menu_Right();

/**
 * Main SFX_Align_Menu_Right Class
 *
 * @class SFX_Align_Menu_Right
 * @version	1.0.0
 * @since 1.0.0
 * @package	SFX_Align_Menu_Right
 * @author Alan
 */
final class SFX_Align_Menu_Right {
	/**
	 * SFX_Align_Menu_Right The single instance of SFX_Align_Menu_Right.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * The plugin directory URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_url;

	/**
	 * The plugin directory path.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_path;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * The settings object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings;
	// Admin - End

	// Post Types - Start
	/**
	 * The post types we're registering.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $post_types = array();
	// Post Types - End


	private $enableAlignMenuRight;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct () {
		$this->token 			= 'sfx-align-menu-right';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		// Admin - Start
//		require_once( 'classes/class-sfx-align-menu-right-settings.php' );
//			$this->settings = SFX_Align_Menu_Right_Settings::instance();
//
//		if ( is_admin() ) {
//			require_once( 'classes/class-sfx-align-menu-right-admin.php' );
//			$this->admin = SFX_Align_Menu_Right_Admin::instance();
//		}
		// Admin - End

		// Post Types - End
		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action('init', array( $this, 'load_plugin_textdomain' ));

		// needs to be hooked to 'wp_loaded', since this is the action that when executed, will filter get_option from customizer
		add_action('wp_loaded', array($this, 'get_options'), 100);

		add_action('wp_loaded', array($this, 'align_menu_right'), 120);

		add_action('wp_head', array($this, 'option_css'));

		add_action('customize_register', array($this, 'customize_register'));

	} // End __construct()

	public function get_options() {
		$this->enableAlignMenuRight = get_option('sfx-align-menu-right', '0') == true;
	}

	public function align_menu_right() {

		if ($this->enableAlignMenuRight) {
			remove_action('storefront_header', 'storefront_secondary_navigation', 30);
			remove_action('storefront_header', 'storefront_primary_navigation', 50);
			add_action('storefront_header', 'storefront_primary_navigation', 30);

			if (function_exists('storefront_header_cart')) {
				remove_action('storefront_header', 'storefront_header_cart', 60);

				if (function_exists('Storefront_WooCommerce_Customiser')) {
					$header_cart = get_theme_mod('swc_header_cart');
					if (false == $header_cart) {
						// don't add back the cart
					} else {
						add_action('storefront_header', 'storefront_header_cart', 35);
					}
				} else {
					add_action('storefront_header', 'storefront_header_cart', 35);
				}
			}

			remove_action('storefront_header', 'storefront_product_search', 40);
//			* @hooked storefront_primary_navigation - 50
//			* @hooked storefront_header_cart - 60
		}
	}

	public function customize_register(WP_Customize_Manager $customizeManager) {
		$customizeManager->add_setting('sfx-align-menu-right', array(
			'default' => false,
			'type' => 'option'
		));

		$customizeManager->add_control(new WP_Customize_Control($customizeManager, 'sfx-align-menu-right', array(
			'type' => 'checkbox',
			'label' => 'Align menu right of logo',
			'description' => 'Moves the primary menu to the right of the logo and removes secondary menu',
			'settings' => 'sfx-align-menu-right',
			'default' => false,
			'section' => 'header_image',
			'priority' => 100
		)));
	}

	public function option_css() {


		if ($this->enableAlignMenuRight) {
			$css = '';

			$css .= "@media screen and (min-width: 768px) {\n";

			$css .= ".menu-main-container, #menu-main { display: inline-block; }\n";

			$css .= "#site-navigation {\n";
			$css .= "\t" . "float: none; width: auto; display: inline-block; margin-right: 0;\n";
			$css .= "}\n";

			$css .= ".main-navigation ul.menu > li > a, .main-navigation ul.nav-menu > li > a {\n";
			$css .= "\t" . "padding-bottom: 0;\n";
			$css .= "}\n";


			$css .= ".site-header-cart .cart-contents {\n";
			$css .= "\t" . "padding-bottom: 0;\n";
			$css .= "}\n";

			// for Storefront WooCommerce Extension
			$css .= ".woocommerce-active .site-header .site-header-cart {\n";
			$css .= "\t" . "float: none; display: inline-block;\n";
			$css .= "}\n";

			// if cart link has no text, only a cart icon, as in demo
			// the link is 0 height, causing the cart link to be lower than nav, fix it
			$css .= ".woocommerce-active .site-header .site-header-cart .cart-contents {\n";
			$css .= "\t" . "height: 1em;\n";
			$css .= "}\n";

			// if Jetpack site logo is used, add space under the logo,
			// the same space under the nav when not aligned right
			$css .= "#masthead > .col-full > .site-logo-link { padding-bottom: 2.224em; }\n";

			$css .= "}\n";

			echo "<style>\n";
			echo $css;
			echo "</style>\n";
		}
	}

	/**
	 * Main SFX_Align_Menu_Right Instance
	 *
	 * Ensures only one instance of SFX_Align_Menu_Right is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see SFX_Align_Menu_Right()
	 * @return Main SFX_Align_Menu_Right instance
	 */
	public static function instance () {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'sfx-align-menu-right', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	} // End load_plugin_textdomain()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __wakeup()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	} // End _log_version_number()
} // End Class
?>
