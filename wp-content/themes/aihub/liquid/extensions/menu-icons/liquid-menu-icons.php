<?php

/**
 * Menu Icons
 *
 * @package Liquid_Menu_Icons
 * @version 0.10.2
 *
 * Plugin URI:  https://github.com/Codeinwp/wp-menu-icons
 *
 */

defined( 'ABSPATH' ) || die();

class Liquid_Menu_Icons {

	const VERSION = '0.13.5';

	/**
	 * Holds plugin data
	 *
	 * @access protected
	 * @since  0.1.0
	 * @var    array
	 */
	protected static $data;

	function __construct() {

		$this->include_files();
		$this->_load();

	}

	/**
	 * Get plugin data
	 *
	 * @since  0.1.0
	 * @since  0.9.0  Return NULL if $name is not set in $data.
	 * @param  string $name
	 *
	 * @return mixed
	 */
	public static function get( $name = null ) {
		if ( is_null( $name ) ) {
			return self::$data;
		}

		if ( isset( self::$data[ $name ] ) ) {
			return self::$data[ $name ];
		}

		return null;
	}


	/**
	 * Load plugin
	 *
	 * 1. Load translation
	 * 2. Set plugin data (directory and URL paths)
	 * 3. Attach plugin initialization at icon_picker_init hook
	 *
	 * @since   0.1.0
	 * @wp_hook action plugins_loaded
	 * @link    http://codex.wordpress.org/Plugin_API/Action_Reference/plugins_loaded
	 */
	public static function _load() {

		self::$data = array(
			'dir'   => get_template_directory() . '/liquid/extensions/menu-icons/',
			'url'   => get_template_directory_uri() . '/liquid/extensions/menu-icons/',
			'types' => array(),
		);

		Icon_Picker::instance();

		require_once self::$data['dir'] . 'includes/library/compat.php';
		require_once self::$data['dir'] . 'includes/library/functions.php';
		require_once self::$data['dir'] . 'includes/meta.php';

		Liquid_Menu_Icons_Meta::init();

		// Font awesome backward compatible functionalities.
		require_once self::$data['dir'] . 'includes/library/font-awesome/backward-compatible-icons.php';
		require_once self::$data['dir'] . 'includes/library/font-awesome/font-awesome.php';
		Liquid_Menu_Icons_Font_Awesome::init();

		add_action( 'icon_picker_init', array( __CLASS__, '_init' ), 9 );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, '_admin_enqueue_scripts' ) );

		add_filter(
			'menu_icons_load_promotions',
			function() {
				return array( 'otter' );
			}
		);
	}

	public function include_files() {
		$vendor_file = dirname(__FILE__) . '/vendor/autoload.php';

		if ( is_readable( $vendor_file ) ) {
			require_once $vendor_file;
		}

	}


	/**
	 * Initialize
	 *
	 * 1. Get registered types from Icon Picker
	 * 2. Load settings
	 * 3. Load front-end functionalities
	 *
	 * @since   0.1.0
	 * @since   0.9.0  Hook into `icon_picker_init`.
	 * @wp_hook action icon_picker_init
	 * @link    http://codex.wordpress.org/Plugin_API/Action_Reference
	 */
	public static function _init() {
		/**
		 * Allow themes/plugins to add/remove icon types
		 *
		 * @since 0.1.0
		 * @param array $types Icon types
		 */
		self::$data['types'] = apply_filters(
			'menu_icons_types',
			Icon_Picker_Types_Registry::instance()->types
		);

		// Nothing to do if there are no icon types registered.
		if ( empty( self::$data['types'] ) ) {
			if ( WP_DEBUG ) {
				trigger_error( esc_html__( 'Menu Icons: No registered icon types found.', 'aihub' ) );
			}

			return;
		}

		// Load settings.
		require_once self::$data['dir'] . 'includes/settings.php';
		Liquid_Menu_Icons_Settings::init();

		// Load front-end functionalities.
		if ( ! is_admin() ) {
			require_once self::$data['dir'] . '/includes/render-svg.php';
			require_once self::$data['dir'] . '/includes/front.php';
			Liquid_Menu_Icons_Front_End::init();
		}

		do_action( 'menu_icons_loaded' );
	}


	/**
	 * Display notice about missing Icon Picker
	 *
	 * @since   0.9.1
	 * @wp_hook action admin_notice
	 */
	public static function _notice_missing_icon_picker() {
		?>
		<div class="error">
			<p><?php esc_html_e( 'Looks like Menu Icons was installed via Composer. Please activate Icon Picker first.', 'aihub' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Register assets.
	 */
	public static function _admin_enqueue_scripts() {
		$url    = self::get( 'url' );
		$suffix = kucrut_get_script_suffix();

		wp_register_style(
			'menu-icons-dashboard',
			"{$url}css/dashboard-notice{$suffix}.css",
			false,
			self::VERSION
		);
	}

}

new Liquid_Menu_Icons;