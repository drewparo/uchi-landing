<?php
/**
* Liquid Themes Theme Framework
* The Liquid_Admin initiate the theme admin
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Liquid_Admin extends Liquid_Base {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		// Envato Market
		get_template_part( 'liquid/libs/importer/liquid', 'importer' );

		$this->add_action( 'init', 'init', 7 );
		$this->add_action( 'admin_init', 'save_plugins' );
		$this->add_action( 'admin_enqueue_scripts', 'enqueue', 99 );
		$this->add_action( 'admin_menu', 'fix_parent_menu', 999 );
		$this->add_action( 'admin_footer', 'site_settings_url', 999 );
		
		add_filter( 'big_image_size_threshold', '__return_false' );

		// Disable WooCommerce Setup Wizard
		add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

		// Hide WooCommerce outdated templates notice
		if ( class_exists( 'WooCommerce' ) ) {
			WC_Admin_Notices::remove_notice( 'template_files' );
		}

		// Disable Elementor Onboarding 
		if ( false === get_option( 'elementor_onboarded' ) ){
			update_option( 'elementor_onboarded', true );
		}

		// Add liquid-template menu
		add_action( 'admin_menu', function() {
			add_menu_page( 'Liquid Templates', 'Liquid Templates', 'manage_options', 'liquid-templates-library', function(){}, 'dashicons-category', 3 );
		} );
		add_filter( 'admin_notices', [ $this, 'admin_print_tabs' ] );

		// Page Optimize Checker
		add_action( 'admin_init', [ $this, 'check_page_optimizer' ] );

		// Purge cache manually
		add_action( 'admin_init', [ $this, 'purge_liquid_cache' ] );

	}

	/**
	 * [init description]
	 * @method init
	 * @return [type] [description]
	 */
	public function init() {

		liquid()->load_theme_part( 'liquid-register-plugins' );

		include_once get_template_directory() . '/liquid/admin/liquid-admin-page.php';
		include_once get_template_directory() . '/liquid/admin/liquid-admin-about.php';
		include_once get_template_directory() . '/liquid/admin/liquid-admin-dashboard.php';
		include_once get_template_directory() . '/liquid/admin/liquid-admin-elementor.php';
		include_once get_template_directory() . '/liquid/admin/liquid-admin-reset.php';

		// Merlin
		require_once get_template_directory() . '/liquid/libs/merlin/vendor/autoload.php';
		require_once get_template_directory() . '/liquid/libs/merlin/class-merlin.php';
		require_once get_template_directory() . '/liquid/libs/merlin/merlin-config.php';
		require_once get_template_directory() . '/liquid/libs/merlin/merlin-filters.php';
		
		// OpenAI
		include_once get_template_directory() . '/liquid/libs/open-ai/src/Url.php';
		include_once get_template_directory() . '/liquid/libs/open-ai/src/OpenAi.php';

	}

	/**
	 * [enqueue description]
	 * @method enqueue
	 * @return [type] [description]
	 */
    public function enqueue() {
	    
	    global $pagenow;

		//imagepicker
		wp_enqueue_style( 'jquery-confirm-css', liquid()->load_assets( 'css/jquery-confirm.min.css' ) );

		if( 'nav-menus.php' == $pagenow || 'widgets.php' == $pagenow ) {
			wp_enqueue_media();
		}

		if (isset($_GET['page']) && ($_GET['page'] == 'liquid-about' || $_GET['page'] == 'liquid-reset')) {
			wp_enqueue_style( 'merlin', get_template_directory_uri() . '/liquid/libs/merlin/assets/css/merlin.css' );
		}

		// Menu color picker
		if ( $pagenow == 'nav-menus.php' && defined( 'LQD_CORE_PLUGIN_URL' ) ) {
			wp_enqueue_style( 'easylogic-colorpicker', LQD_CORE_PLUGIN_URL . 'elementor/controls/color/EasyLogicColorPicker.css' );
			wp_enqueue_style( 'easylogic-colorpicker-style', LQD_CORE_PLUGIN_URL . 'elementor/controls/color/color-wp-menus.css' );
			wp_enqueue_script( 'easylogic-colorpicker', LQD_CORE_PLUGIN_URL . 'elementor/controls/color/EasyLogicColorPicker.js', [], false, true );
			wp_enqueue_script( 'easylogic-colorpicker-init', LQD_CORE_PLUGIN_URL . 'elementor/controls/color/color-wp-menus.js', ['easylogic-colorpicker'], false, true );
		}
	
		wp_enqueue_style( 'lqd-dashboard', liquid()->load_assets( 'css/liquid-dashboard.min.css' ) );

		wp_enqueue_script( 'jquery-confirm', liquid()->load_assets( 'js/jquery-confirm.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'liquid-admin', liquid()->load_assets( 'js/liquid-admin.min.js' ), array( 'jquery', 'underscore' ), false, true );
		wp_localize_script( 'liquid-admin', 'liquid_admin_messages', array(
			'reset_title'     => wp_kses( __( '<span class="dashicons dashicons-info"></span> Reset', 'aihub' ), 'span' ),
			'reset_message'   => esc_html__( 'Remove posts, pages, media and any other content on your current site, We strongly recommend to reset before importing ( even if this is a fresh site ) to avoid any overlap or conflict with your current content.<br/><strong>Note:</strong> Don\'t use the reset option if you are trying to import some parts only ( For example if you are going to import theme options only then you may continue without reset )', 'aihub' ),
			'reset_confirm'   => esc_html__( 'Reset Then Import', 'aihub' ),
			'reset_continue'  => esc_html__( 'Keep Importing Without Resetting', 'aihub' ),
			'reset_final_confirm' => esc_html__( 'I understand', 'aihub' ),
			'reset_final_title'   => wp_kses( __( '<span class="dashicons dashicons-warning"></span> Warning', 'aihub' ), 'span' ),
			'reset_final_message' => esc_html__( 'Since you selected to reset before importing please be aware this action cannot be reversed ( Any removed content cannot be restored )', 'aihub' )
		) );

		// Icons
		$uri = get_template_directory_uri() . '/assets/vendors/' ;

    }
	
	public function admin_redirects() {

		global $pagenow;

		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			wp_redirect( admin_url( 'admin.php?page=liquid' ) );
			exit;
		}
	} 
    
	// Register Helpers ----------------------------------------------------------
    public function script( $handle, $src, $deps = null, $in_footer = true, $ver = null ) {
        wp_register_script( $handle, $src, $deps, $ver, $in_footer);
    }
    
    public function style( $handle, $src, $deps = null, $ver = null, $media = 'all' ) {
        wp_register_style( $handle, $src, $deps, $ver, $media );
    }
    
    // Uri Helpers ---------------------------------------------------------------

    public function get_theme_uri($file = '') {
        return get_template_directory_uri() . '/' . $file;
    }

    public function get_child_uri($file = '') {
        return get_stylesheet_directory_uri() . '/' . $file;
    }

    public function get_css_uri($file = '') {
        return $this->get_theme_uri('assets/css/'.$file.'.css');
    }

    public function get_widgets_uri( $file = '' ) {
		return $this->get_theme_uri( 'assets/css/widgets/' . $file . '.css' );
    }
		
    public function get_js_uri($file = '') {
        return $this->get_theme_uri('assets/js/'.$file.'.js');
    }

    public function get_vendor_uri($file = '') {
        return $this->get_theme_uri('assets/vendors/'.$file);
    }

	/**
	 * [fix_parent_menu description]
	 * @method fix_parent_menu
	 * @return [type]          [description]
	 */
	public function fix_parent_menu() {

        if ( !current_user_can( 'edit_theme_options' ) ) {
            return;
        }
		
		global $submenu;

		$submenu['liquid'][0][0] = esc_html__( 'Activation', 'aihub' );

		remove_submenu_page( 'themes.php', 'tgmpa-install-plugins' );
		
	}

	/**
	 * [site_settings_url description]
	 * @method site_settings_url
	 * @return [type]          [description]
	 */

	 public function site_settings_url() {

		if ( !defined( 'ELEMENTOR_VERSION' ) && !is_callable( 'Elementor\Plugin::instance' ) ){
			return;
		}
		$url = '#';
		if ( $set_home = get_option('page_on_front') ){
			if ( \Elementor\Plugin::$instance->documents->get( $set_home )->is_built_with_elementor() ) {
				$url = \Elementor\Plugin::$instance->documents->get( $set_home )->get_edit_url() . '&active-document=' . get_option('elementor_active_kit');
			} else {
				if ( $kit_id = get_option('elementor_active_kit') ){
					$url = \Elementor\Plugin::$instance->documents->get( $kit_id )->get_edit_url();
				} else {
					//printf( '<p>Cannot found Elementor Kit. Please create or import kit.</p>' );
				}
			}
		} else {
			if ( $kit_id = get_option('elementor_active_kit') ){
				$url = \Elementor\Plugin::$instance->documents->get( $kit_id )->get_edit_url();
			} else {
				//printf( '<p>Cannot found Elementor Kit. Please create or import kit.</p>' );
			}
		}
		?>
		<script>
			jQuery(document).ready(function($) {
				$('#toplevel_page_liquid a').on('click', function(e) {
					var hrefValue = $(this).attr("href");
					if ( hrefValue === 'admin.php?page=liquid-elementor' ){
						e.preventDefault();
						window.location.href = '<?php echo $url ?>';
					}
				});
			});
		</script>
		<?php

	}

	/**
	 * [save_plugins description]
	 * @method save_plugins
	 * @return [type]       [description]
	 */
	public function save_plugins() {

        if ( !current_user_can( 'edit_theme_options' ) ) {
            return;
        }

		// Deactivate Plugin
        if ( isset( $_GET['liquid-deactivate'] ) && 'deactivate-plugin' == $_GET['liquid-deactivate'] ) {

			check_admin_referer( 'liquid-deactivate', 'liquid-deactivate-nonce' );

			$plugins = TGM_Plugin_Activation::$instance->plugins;

			foreach( $plugins as $plugin ) {
				if ( $plugin['slug'] == $_GET['plugin'] ) {

					deactivate_plugins( $plugin['file_path'] );

                    wp_redirect( admin_url( 'admin.php?page=' . $_GET['page'] ) );
					exit;
				}
			}
		}

		// Activate plugin
		if ( isset( $_GET['liquid-activate'] ) && 'activate-plugin' == $_GET['liquid-activate'] ) {

			check_admin_referer( 'liquid-activate', 'liquid-activate-nonce' );

			$plugins = TGM_Plugin_Activation::$instance->plugins;

			foreach( $plugins as $plugin ) {
				if ( $plugin['slug'] == $_GET['plugin'] ) {

					activate_plugin( $plugin['file_path'] );

					wp_redirect( admin_url( 'admin.php?page=' . $_GET['page'] ) );
					exit;
				}
			}
		}
    }

	public function admin_print_tabs()
	{
		global $current_screen;

		if ( isset( $current_screen ) && $current_screen->parent_base === 'liquid-templates-library' ){

			$cpts = [
				'liquid-header' => esc_html( 'Header', 'aihub' ),
				'liquid-footer' => esc_html( 'Footer', 'aihub' ),
				'liquid-mega-menu' => esc_html( 'Mega Menu', 'aihub' ),
				'liquid-title-wrapper' => esc_html( 'Title Wrapper', 'aihub' ),
				'ld-product-layout' => esc_html( 'Product Layout', 'aihub' ),
				'ld-product-sizeguide' => esc_html( 'Product Size Guide', 'aihub' ),
				'liquid-sticky-atc' => esc_html( 'Product Sticky Add to Cart', 'aihub' ),
				'liquid-archives' => esc_html( 'Archives', 'aihub' ),
			];

			if ( !class_exists( 'WooCommerce' ) ) {
				unset($cpts['ld-product-layout']);
				unset($cpts['ld-product-sizeguide']);
				unset($cpts['liquid-sticky-atc']);
			}

			?>
			<div class="nav-tab-wrapper" style="margin: 1.5em 0 1em">
				<?php
				foreach( $cpts as $cpt_slug => $cpt ) {
					printf( 
						'<a class="nav-tab %s" href="%s">%s</a>',
						$current_screen->post_type === $cpt_slug ? ' nav-tab-active' : '',
						add_query_arg( [ 'post_type' => $cpt_slug ], admin_url( 'edit.php' ) ),
						$cpt
					);
				}
				?>
			</div>
			<?php
			
		}

	}

	/**
	 * We're checking the optimization plugins, because our script is dynamic and module base.
	 */
	public function check_page_optimizer()
	{

		// Check the Page Optimize plugin (by Automattic)
		if ( defined( 'PAGE_OPTIMIZE_CACHE_DIR' ) ) {

				$exclude_list = get_option( 'page_optimize-js-exclude' );
				if ( false === $exclude_list || '' === $exclude_list ) {
					// Use the default since the option is not set
					update_option( 'page_optimize-js-exclude', 'liquid-theme-frontend' );
				} else {
					$exclude_list = explode( ',', $exclude_list );
					if( ! in_array('liquid-theme-frontend', $exclude_list ) ) {
						$exclude_list[] = 'liquid-theme-frontend';
						$exclude_list = implode( ',', $exclude_list );
						update_option( 'page_optimize-js-exclude', $exclude_list );
					}
				}

		}
		
	}

	public function purge_liquid_cache() {
		if ( isset( $_GET ) && isset( $_GET['purge-liquid-cache'] ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				liquid_helper()->purge_all_cache();
			}
		}
	}

}
new Liquid_Admin;
