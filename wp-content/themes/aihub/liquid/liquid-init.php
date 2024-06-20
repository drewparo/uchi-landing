<?php
/**
 * Liquid Themes Theme Framework
 * The Liquid_Theme initiate the theme engine
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// Include base class
include_once( get_template_directory() . '/liquid/liquid-base.php' );

// For developers to hook.
liquid_action( 'before_init' );

/**
 * Liquid Theme
 */
#[AllowDynamicProperties]
class Liquid_Theme extends Liquid_Base {

	private $version = '1.0.0';

	protected $theme_options_values = array();

	protected static $instance = null;

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new Liquid_Theme();
		}

		return self::$instance;
	}

	private function __construct() {

		$this->init_hooks();
	}

	private function init_hooks() {

		$this->add_action( 'after_setup_theme', 'includes', 2 );
		$this->add_action( 'after_setup_theme', 'setup_theme', 7 );
		$this->add_action( 'after_setup_theme', 'admin', 7 );
		$this->add_action( 'after_setup_theme', 'extensions', 25 );
		$this->add_action( 'admin_head', 'admin_update_redirect' );

		// For developers to hook.
		liquid_action( 'loaded' );
	}

	public function includes() {

		// Load Core
		include_once( get_template_directory() . '/liquid/liquid-helpers.php' );
		include_once( get_template_directory() . '/liquid/liquid-template-tags.php' );
		include_once( get_template_directory() . '/liquid/liquid-media.php' );
		include_once( get_template_directory() . '/liquid/liquid-meta-boxes-init.php' );

		// Load Structure
		include_once( get_template_directory() . '/liquid/structure/markup.php' );
		include_once( get_template_directory() . '/liquid/structure/header.php' );
		include_once( get_template_directory() . '/liquid/structure/footer.php' );
		include_once( get_template_directory() . '/liquid/structure/posts.php' );
		include_once( get_template_directory() . '/liquid/structure/comments.php' );

		// Load Woocommerce stuff
		if ( class_exists( 'WooCommerce' ) ) {
			include_once( get_template_directory() . '/liquid/vendors/woocommerce/liquid-woocommerce-init.php' );
		}

		// Load Aqua Resizer
		include_once( get_template_directory() . '/liquid/extensions/aq_resizer/aq_resizer.php' );

		// Load Register and updater classes
		include_once( get_template_directory() . '/liquid/admin/updater/liquid-register-admin.php' );

		// Load Google Fonts Locally
		include_once( get_template_directory() . '/liquid/extensions/local-fonts/local-fonts.php' );

		// Front-end
		if ( ! is_admin() ) {
			$this->layout = include_once( get_template_directory() . '/liquid/liquid-theme-layout.php' );
		}

	}

	public function setup_theme() {

		// Set Content Width
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 780;
		}

		// Localization
		load_theme_textdomain( 'aihub', trailingslashit( WP_LANG_DIR ) . 'themes/' ); // From Wp-Content
		load_theme_textdomain( 'aihub', get_stylesheet_directory() . '/languages' ); // From Child Theme
		load_theme_textdomain( 'aihub', get_template_directory() . '/languages' ); // From Parent Theme

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Enable support for WooCommerce
		add_theme_support( 'woocommerce' );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'liquid-assets',
			'script',
			'style'
		) );

		// Allow shortcodes in widgets.
		add_filter( 'widget_text', 'do_shortcode' );

		// Theme Specific Setup
		$this->load_theme_part( 'liquid-setup' );
		$this->load_theme_part( 'liquid-scripts' );
		$this->load_theme_part( 'liquid-hooks' );
		$this->load_theme_part( 'liquid-template-tags' );
		$this->load_theme_part( 'liquid-walkers' );

		// Load elementor first
		$this_plugin = 'elementor/elementor.php';
		$active_plugins = get_option('active_plugins');
		$this_plugin_key = array_search($this_plugin, $active_plugins);
		if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
			array_splice($active_plugins, $this_plugin_key, 1);
			array_unshift($active_plugins, $this_plugin);
			update_option('active_plugins', $active_plugins);
		}

	}

	public function admin() {

		if ( is_admin() ) {
			include_once( get_template_directory() . '/liquid/admin/liquid-admin-init.php' );
		}

	}

	public function extensions() {

		// check
		$extensions = get_theme_support( 'liquid-extension' );
		if ( empty( $extensions ) || empty( $extensions[0] ) ) {
			return;
		}

		// Load
		$extensions = $extensions[0];
		foreach ( $extensions as $extension ) {
			$this->load_extension( $extension );
		}
	}

	public function set_option_name( $name = '' ) {

		if ( $name ) {
			$this->theme_options_name = $name;
		}
	}

	public function get_option_name( $name = '' ) {
		return $this->theme_options_name;
	}

	// Helper ----------------------------------------

	public function get_version() {
		return $this->version;
	}

	public function load_theme_part( $slug, $args = null ) {
		liquid_helper()->get_template_part( 'theme/' . $slug, $args );
	}

	public function load_library( $slug, $args = null ) {
		liquid_helper()->get_template_part( 'liquid/libs/' . $slug, $args );
	}

	public function load_assets( $slug ) {
		return get_template_directory_uri() . '/liquid/assets/' . $slug;
	}

	public function admin_update_redirect() {

		global $wp;
		$url = add_query_arg( $_GET, $wp->request );

		if ( defined('LQD_CORE_VERSION') && version_compare( LQD_CORE_VERSION, '1.3.2', '<' ) ){
			if ( $url != '?page=liquid-about' )  {
				if ( false === get_transient('lqd_about_update_escape') ) {
					wp_redirect(admin_url( 'admin.php?page=liquid-about' ));
				}
			}
		}

	}

}

/**
 * Main instance of Liquid_Theme.
 *
 * Returns the main instance of Liquid_Theme to prevent the need to use globals.
 *
 * @return Liquid_Theme
 */
function liquid() {
	return Liquid_Theme::instance();
}

liquid(); // init it

// For developers to hook.
liquid_action( 'init' );