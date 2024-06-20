<?php
/*
Plugin Name: AIHub Core
Plugin URI: https://archub.liquid-themes.com/
Description: Intelligent and Powerful Elements Plugin, exclusively for AIHub WordPress Theme.
Version: 1.3.2
Author: Liquid Themes
Author URI: https://themeforest.net/user/liquidthemes
Text Domain: aihub-core
Requires PHP: 7.4
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LQD_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'LQD_CORE_URL', get_template_directory_uri() . '/' );
define( 'LQD_CORE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LQD_CORE_VERSION', get_file_data( __FILE__, array('Version' => 'Version'), false)['Version']);
define( 'ENVATO_HOSTED_SITE', true );

if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
	include_once LQD_CORE_PATH . 'elementor/kit/kit.php';
	include_once LQD_CORE_PATH . 'elementor/template-library/template-library.php';
	include_once LQD_CORE_PATH . 'elementor/hooks/global-controls.php';
}

include_once LQD_CORE_PATH . 'includes/liquid-base.php';

class Liquid_Addons extends Liquid_Base {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.3.2';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';


	/**
	 * Hold an instance of Liquid_Addons class.
	 * @var Liquid_Addons
	 */
	protected static $instance = null;

	/**
	 * [$params description]
	 * @var array
	 */
	public $params = array();

	/**
	 * Main Liquid_Addons instance.
	 *
	 * @return Liquid_Addons - Main instance.
	 */
	public static function instance() {

		if ( null == self::$instance ) {
			self::$instance = new Liquid_Addons();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'aihub-core' );

	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

	}

	public function include_files() {

		include_once LQD_CORE_PATH . 'includes/liquid-helpers.php';
		include_once LQD_CORE_PATH . 'extensions/extensions.init.php';
		include_once LQD_CORE_PATH . 'libs/updater/plugin-update-checker.php';
		include_once LQD_CORE_PATH . 'extras/mailchimp/mailchimp.php';
		include_once LQD_CORE_PATH . 'extras/liquid-extras.php';
		include_once LQD_CORE_PATH . 'includes/liquid-category-color.php';

        if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
			include_once LQD_CORE_PATH . 'elementor/liquid-elementor.php';
            include_once LQD_CORE_PATH . 'elementor/shortcodes/misc/liquid-misc.php';
            include_once LQD_CORE_PATH . 'elementor/params/blog.php';
            include_once LQD_CORE_PATH . 'elementor/params/portfolio.php';
            include_once LQD_CORE_PATH . 'elementor/params/liquid-background.php';
            include_once LQD_CORE_PATH . 'extensions/theme-scripts/theme-scripts.php';
        }

    }

	public function register_elementor_categories( $elements_manager ) {

		$categories = [];
		$categories['liquid-header'] = [
			'title' => sprintf( __( '%s - Header', 'aihub-core' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];
		$categories['liquid-core'] = [
			'title' => sprintf( __( '%s - General', 'aihub-core' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];
		$categories['liquid-woo'] = [
			'title' => sprintf( __( '%s - Woocommerce', 'aihub-core' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];
		$categories['liquid-portfolio'] = [
			'title' => sprintf( __( '%s - Portfolio', 'aihub-core' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];

		if ( !version_compare( PHP_VERSION, '7.0.0', '<' ) ) {
			$old_categories = $elements_manager->get_categories();
			$categories = array_merge($categories, $old_categories);

			$set_categories = function ( $categories ) {
				$this->categories = $categories;
			};

			$set_categories->call( $elements_manager, $categories );
		} else {
			foreach ($categories as $key => $category){
				$elements_manager->add_category( $key, $category );
			}
		}

    }

	function ld_el_defaults() {
		update_option( 'elementor_css_print_method', 'internal' );
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
		update_option( 'elementor_font_display', 'swap' );
		update_option( 'elementor_experiment-e_dom_optimization', 'active' );

		//if exists, assign to $cpt_support var
		$cpt_support = get_option( 'elementor_cpt_support' );

		//check if option DOESN'T exist in db
		if( ! $cpt_support ) {
			$cpt_support = [ 'page', 'post', 'liquid-header', 'liquid-footer', 'liquid-portfolio', 'liquid-title-wrapper', 'liquid-mega-menu']; //create array of our default supported post types
			update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
		}
	}

	/**
	 * [Auto load libraries]
	 * @method auto_load
	 *
	 * @param $class
	 *
	 * @return type
	 * @since    1.0.0
	 */
	public function auto_load( $class ) {
		if ( strpos( $class, 'Liquid' ) !== false ) {
			$class_dir  = LQD_CORE_PATH . 'libs' . DIRECTORY_SEPARATOR . 'core-importer' . DIRECTORY_SEPARATOR;
			$class_dir_ = LQD_CORE_PATH . 'libs' . DIRECTORY_SEPARATOR . 'liquid-api' . DIRECTORY_SEPARATOR;
			$class_name = str_replace( '_', DIRECTORY_SEPARATOR, $class ) . '.php';
			if ( file_exists( $class_dir . $class_name ) ) {
				require_once $class_dir . $class_name;
			}
			if ( file_exists( $class_dir_ . $class_name ) ) {
				require_once $class_dir_ . $class_name;
			}
		}
	}

	public function multiple_post_thumbnail() {
		//Add Multi Featured Image
		include_once LQD_CORE_PATH . 'extensions/multiple-post-thumbnails/multiple-post-thumbnails.php';
	}

	public function liquid_update_theme() {

		if ( defined( 'ENVATO_HOSTED_SITE' ) ) {
			return;
		}
		Puc_v4_Factory::buildUpdateChecker( 'http://api.liquidthemes.com/products/One/update.php', get_template_directory(), get_template() );

	}

	public function activate_theme_notice() {

		if ( did_action( 'liquid_init' ) > 0 ) {
			return;
		}
		?>
        <div class="updated not-h2">
            <p>
                <strong><?php esc_html_e( 'Please activate the ArcHub WordPress Theme to use ArcHub Core plugin.', 'archub-core' ); ?></strong>
            </p>
			<?php
			$screen = get_current_screen();
			if ( $screen->base != 'themes' ):
				?>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'Activate theme', 'archub-core' ); ?></a>
                </p>
			<?php endif; ?>
        </div>
		<?php
	}

	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function is_compatible() {

		// add_action( 'admin_head', function() {
		// 	wp_enqueue_style(
		// 		'liquid-elementor-admin',
		// 		LQD_CORE_URL . 'assets/css/liquid-elementor-admin.css',
		// 		[],
		// 		LQD_CORE_VERSION
		// 	);
		// });

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check if Hub Core installed and activated
		if ( ! class_exists( 'Liquid_Addons' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_hub_core' ] );
			return false;
		}


		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		// Check for theme activated
		if ( 'AIHub' !== wp_get_theme()->get( 'Name' ) && 'AIHub Child' !== wp_get_theme()->get( 'Name' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_hub_theme' ] );
			return false;

		}

		return true;

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		$this->i18n();
		$this->include_files();
		spl_autoload_register( array( $this, 'auto_load' ) );

		$this->add_action( 'plugins_loaded', 'load_plugin_textdomain' );
		$this->add_action( 'admin_init', 'libs_init', 10, 1 );
		$this->add_action( 'admin_init', 'liquid_update_theme' );
		$this->add_action( 'admin_init', 'multiple_post_thumbnail' );
		$this->add_action( 'liquid_init', 'init_hooks' );
		$this->add_action( 'admin_notices', 'activate_theme_notice' );
		$this->add_filter( 'wp_kses_allowed_html', 'wp_kses_allowed_html', 10, 2 );
		$this->add_filter( 'tuc_request_update_query_args-One', 'autoupdate_verify' );

		$this->add_action( 'admin_print_scripts-widgets.php', 'enqueue_widgets', 99 );

		$this->add_action( 'init', 'load_post_types', 1 );
		$this->add_action( 'widgets_init', 'load_widgets', 25 );

		// Elementor files
		$this->add_action( 'elementor/elements/categories_registered', 'register_elementor_categories', 5 );
		$this->add_action( 'after_switch_theme', 'ld_el_defaults' );

	}

	/**
	 * [Load plugin libraries]
	 * @method libs_init
	 *
	 * @return type
	 * @since    1.0.0
	 */
	public function libs_init() {
		global $LiquidCore;//to do rename the libs core class
		$LiquidCore                            = new LiquidCore();
		$LiquidCore['path']                    = LQD_CORE_PATH;
		$LiquidCore['url']                     = LQD_CORE_URL;
		$LiquidCore['version']                 = '1.0';
		$LiquidCore['LiquidRedirect']          = new LiquidRedirect();
		$LiquidCore['LiquidEnvato']            = new LiquidEnvato();
		$LiquidCore['LiquidCheck']             = new LiquidCheck();
		$LiquidCore['LiquidNotices']           = new LiquidNotices();
		$LiquidCore['LiquidLog']               = new LiquidLog();
		$LiquidCore['LiquidDownload']          = new LiquidDownload( $LiquidCore );
		$LiquidCore['LiquidReset']             = new LiquidReset( $LiquidCore );
		$LiquidCore['LiquidThemeDemoImporter'] = new LiquidThemeDemoImporter( $LiquidCore );
		apply_filters( 'liquid/config', $LiquidCore );

		return $LiquidCore->run();
	}

	/**
	 * [Accsess the libs core class]
	 * @method liquid_libs_core
	 *
	 * @return object|null
	 * @since    1.0.0
	 */
	public function liquid_libs_core( $class = '' ) {
		global $LiquidCore;
		if ( isset( $class ) ) {
			return $LiquidCore;
		} else {
			if ( is_object( $LiquidCore[ $class ] ) ) {
				return $LiquidCore[ $class ];
			}
		}
	}

	/**
	 * [Show login notice for users]
	 * @method liquid_login_notice
	 *
	 * @return object|null
	 * @since    1.0.0
	 */
	public function liquid_login_notice() {
		$LiquidCore = $this->liquid_libs_core();
		if ( $LiquidCore['LiquidCheck']->logged_in_mail() === null && ! isset( $_GET['refresh'] ) && $LiquidCore['LiquidNotices']->get_cookie_timer() != 1 ) {
			$message = sprintf( wp_kses_post( __( '<a href="%s">Log in</a> with your Envato account to take full advantage of <strong>One theme</strong>', 'archub-core' ) ), $LiquidCore['LiquidEnvato']->login_url() );
			$LiquidCore['LiquidNotices']->admin_notice( $message, array(
				'type'        => 'info',
				'classes'     => 'liquid-login-notice',
				'dismissTime' => 'liquid_dissmiss_timer'
			) );
		} elseif ( ! $LiquidCore['LiquidCheck']->is_vaild() && ! isset( $_GET['refresh'] ) ) {
			$message = sprintf( wp_kses_post( __( 'We couldn\'t find <strong>One theme</strong> with the logged in account <a href="%s">Log in with different account</a>', 'archub-core' ) ), $LiquidCore['LiquidEnvato']->login_url() );
			$LiquidCore['LiquidNotices']->admin_notice( $message, array(
				'type'        => 'error',
				'classes'     => 'liquid-login-notice liquid-not-vaild',
				'dismissTime' => 'liquid_dissmiss_timer'
			) );
		}
	}

	public function autoupdate_verify( $query_args ) {
		$LiquidCore   = $this->liquid_libs_core();
		$liquid_token = $LiquidCore['LiquidCheck']->get_token();
		if ( isset( $liquid_token ) && $liquid_token != '' ) {
			$query_args['token'] = $liquid_token;
		} else {
			$query_args['token'] = '';
		}

		return $query_args;
	}

	/**
	 * [load_post_types description]
	 * @method load_post_types
	 *
	 * @return [type]          [description]
	 */
	public function load_post_types() {
		require_if_theme_supports( 'liquid-header', LQD_CORE_PATH . 'post-types/liquid-header.php' );
		require_if_theme_supports( 'liquid-footer', LQD_CORE_PATH . 'post-types/liquid-footer.php' );
		require_if_theme_supports( 'liquid-mega-menu', LQD_CORE_PATH . 'post-types/liquid-mega-menu.php' );
		require_if_theme_supports( 'liquid-title-wrapper', LQD_CORE_PATH . 'post-types/liquid-title-wrapper.php' );
		require_if_theme_supports( 'liquid-portfolio', LQD_CORE_PATH . 'post-types/liquid-portfolio.php' );
		require_if_theme_supports( 'liquid-product-layout', LQD_CORE_PATH . 'post-types/liquid-product-layout.php' );
		require_if_theme_supports( 'liquid-product-sizeguide', LQD_CORE_PATH . 'post-types/liquid-product-size-guide.php' );
		require_if_theme_supports( 'liquid-sticky-atc', LQD_CORE_PATH . 'post-types/liquid-product-sticky-atc.php' );
		require_if_theme_supports( 'liquid-archives', LQD_CORE_PATH . 'post-types/liquid-archives.php' );
	}

	/**
	 * [load_widgets description]
	 * @method load_widgets
	 *
	 * @return [type]       [description]
	 */
	public function load_widgets() {

		//List of widgets in APLHABETICAL ORDER!!!!
		$widgets = array(
			'Liquid_Newsletter_Widget',
			'Liquid_Trending_Posts_Widget',
			'Liquid_Latest_Posts_Widget',
			'Liquid_Social_Followers_Widget',
			'Liquid_Next_Post_Widget',
		);

		if ( class_exists( 'Woocommerce' ) ) {
			array_push( $widgets, 'Liquid_Woo_Products_Widget' );
		};

		foreach ( $widgets as $widget ) {
			if ( file_exists( LQD_CORE_PATH . "widgets/{$widget}.class.php" ) ) {
				require_once( LQD_CORE_PATH . "widgets/{$widget}.class.php" );
				register_widget( $widget );
			}
		}
	}

	/**
	 * Load widget scripts
	 */
	public function enqueue_widgets() {
		wp_enqueue_media();
	}

	/**
	 * Plugin activation
	 */
	public static function activate() {
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	public function wp_kses_allowed_html( $tags, $context ) {

		if ( 'post' !== $context ) {
			return $tags;
		}

		$tags['style'] = array( 'types' => array() );

		return $tags;
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'aihub-core' ),
			'<strong>' . esc_html__( 'AIHub Core', 'aihub-core' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'aihub-core' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'aihub-core' ),
			'<strong>' . esc_html__( 'AIHub Core', 'aihub-core' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'aihub-core' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'aihub-core' ),
			'<strong>' . esc_html__( 'AIHub Core', 'aihub-core' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'aihub-core' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_hub_core() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'aihub-core' ),
			'<strong>' . esc_html__( 'AIHub Core', 'aihub-core' ) . '</strong>',
			'<strong>' . esc_html__( 'Hub Core', 'aihub-core' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_hub_theme() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" theme to be installed and activated.', 'aihub-core' ),
			'<strong>' . esc_html__( 'AIHub Core', 'aihub-core' ) . '</strong>',
			'<strong>' . esc_html__( 'AIHub or AIHub Child', 'aihub-core' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

/**
 * Main instance of Liquid_Theme.
 *
 * Returns the main instance of Liquid_Theme to prevent the need to use globals.
 *
 * @return Liquid_Theme
 */
function liquid_addons() {
	return Liquid_Addons::instance();
}

liquid_addons(); // init i

register_activation_hook( __FILE__, array( 'Liquid_Addons', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Liquid_Addons', 'deactivate' ) );