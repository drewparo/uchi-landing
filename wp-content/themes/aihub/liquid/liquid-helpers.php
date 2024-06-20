<?php
/**
 * The Helper
 * Contains all the helping functions
 *
 *
 * Table of Content
 *
 * 1. WordPress Helpers
 * 2. Markup Helpers
 * 3. Theme Options/Meta Helpers
 * 4. Array opperations
 */

/**
 * Main helper functions.
 *
 * @class Liquid_Helper
*/
class Liquid_Helper {

	/**
	 * Hold an instance of Liquid_Helper class.
	 * @var Liquid_Helper
	 */
	protected static $instance = null;

	/**
	 * Main Liquid_Helper instance.
	 *
	 * @return Liquid_Helper - Main instance.
	 */
	public static function instance() {

		if(null == self::$instance) {
			self::$instance = new Liquid_Helper();
		}

		return self::$instance;
	}

	// 1. WordPress Helpers -----------------------------------------------

	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	public function get_sidebars( $data = array() ) {
		global $wp_registered_sidebars;

        foreach ( $wp_registered_sidebars as $key => $value ) {
            $data[ $key ] = $value['name'];
        }

		return $data;
	}

	public function get_available_menus( $data = array() ) {
		$menus = wp_get_nav_menus();

		foreach ( $menus as $menu ) {
			$data[ $menu->slug ] = $menu->name;
		}
		return $data;
	}

	public function get_available_custom_post( $type ) {
		$posts = get_posts( array(
            'post_type' => $type,
            'posts_per_page' => -1,
        ) );

        $options = [];

        foreach ( $posts as $post ) {
        $options[ $post->ID ] = $post->post_title;
        }

        return $options;
	}

	public function get_available_custom_taxonomies( $type ) {
		$taxonomies = get_categories(
			array(
				'taxonomy'     => $type,
				'orderby'      => 'name',
			)
		);

		$options = array();

		foreach ( $taxonomies as $taxonomy ) {
		  $options[ $taxonomy->cat_ID ] = $taxonomy->name;
		}

		return $options;
	}

	public function get_elementor_templates() {
		$posts = get_posts( array(
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
			'meta_query'  => array(
                array(
                    'key' => '_elementor_template_type',
                    'value' => 'kit',
                    'compare' => '!=',
                ),
            ),
		) );

		$options = [ '0' => 'Select Template' ];

		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}

		return $options;
	}

	public function get_elementor_templates_edit() {

		$out = '
		<div class="lqd-tmpl-edit-editor-buttons">
			<button
				class="elementor-button"
				type="button"
				onClick="lqd_edit_tmpl(event)"
			><i class="eicon-edit"></i>
			</button>

			<button
				class="elementor-button"
				type="button"
				onClick="lqd_add_tmpl(event)"
			><i class="eicon-plus"></i> Add template
			</button>
		</div>
		';

		return $out;

	}

	public function get_elementor_edit_cpt( $post_id, $post_type = '' ) {

		if ( defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->preview->is_preview_mode() && !empty( $post_id ) ){
			$out = '
				<style>
				.lqd-site-header:not(.absolute), .lqd-site-footer{
					position: relative;
				}
				.lqd-tmpl-edit-cpt{
                    width: 100%;
                    height:100%;
					position:absolute;
					z-index:2;
                    top: 0;
                    left: 0;
					display:flex;
					justify-content:end;
                    align-items:start;
					transition: opacity 300ms;
                    pointer-events: none;
                    opacity: 0;
                    border:1px solid var(--e-a-btn-bg-primary);
				}
				.lqd-tmpl-edit-cpt--btn{
                    display:flex;
					align-items:center;
                    gap: 8px;
                    padding: 2px 8px;
					font-size: 14px;
					background: var(--e-a-btn-bg-primary)!important;
					color: #000 !important;
					border-radius: 0 0 0 4px;
					cursor: pointer;
                    pointer-events: auto;
                    white-space: nowrap;
				}
				.lqd-tmpl-edit-cpt--btn i {
                    font-size: 12px;
                }
                .lqd-site-header:hover .lqd-tmpl-edit-cpt,
                .lqd-site-footer:hover .lqd-tmpl-edit-cpt{
                    opacity:1;
                }
                .elementor-editor-preview .lqd-tmpl-edit-cpt {
                    display: none;
                }
				</style>


				<div class="lqd-tmpl-edit-cpt">
				<button
					class="lqd-tmpl-edit-cpt--btn"
					type="button"
					data-post-id="'.$post_id.'"
				>Edit ' . esc_html__( $post_type, 'aihub' ) . ' <i class="eicon-edit"></i>
				</button>
				</div>
			';

			echo $out;
		}

	}

	/**
	 * Instantiates the WordPress filesystem for use with Hub.
	 *
	 * @static
	 * @access public
	 * @return object
	 */
	public function init_filesystem() {

		if ( ! defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' );
		}

		// The WordPress filesystem.
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		return $wp_filesystem;
	}

	public function get_template_part( $template, $args = null ) {

		if ( $args && is_array( $args ) ) {
			extract( $args );
		}

		$located = locate_template( $template . '.php' );

		if ( ! file_exists( $located ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( wp_kses_post( __( '<code>%s</code> does not exist.', 'aihub' ) ), $located ), null );
			return;
		}

		include $located;
	}

	public function get_current_theme() {
		$current_theme = wp_get_theme();
		if( $current_theme->parent_theme ) {
			$template_dir  = basename( get_template_directory() );
			$current_theme = wp_get_theme( $template_dir );
		}

		return $current_theme;
	}

	public function sanitize_html_classes( $class, $fallback = null ) {

		// Explode it, if it's a string
		if ( is_string( $class ) ) {
			$class = explode( ' ', $class );
		}

		if ( is_array( $class ) && !empty( $class ) ) {
			$class = array_map( 'sanitize_html_class', $class );
			return join( ' ', $class );
		}
		else {
			return sanitize_html_class( $class, $fallback );
		}

	}

	/**
	 * Adds all variables from $_GET array to given URL and returns this URL
	 * @param type $url url
	 * @param type $skip array of variables to skip
	 * @return type
	 */
	public function add_to_url_from_get( $url, $skip = array() ) {

		if ( isset( $_GET ) && is_array( $_GET ) ) {
			foreach ( $_GET as $key => $val ) {
				if ( in_array( $key, $skip ) ) {
					continue;
				}
				$url = add_query_arg( $key . '=' . $val, '', $url );
			}
		}
		return $url;
	}

	public function has_seo_plugins() {

		$plugins = array(
			'yoast' => defined( 'WPSEO_VERSION' ),
			'ainseop' => defined( 'AIOSEOP_VERSION' )
		);

		foreach( $plugins as $item ) {
			if( $item ) {
				return true;
			}
		}

		return false;
	}

	public function get_menu_location_name( $location ) {

		$locations = get_registered_nav_menus();

		return isset( $locations[ $location ] ) ? $locations[ $location ] : '';
	}

	public function get_attachment_types( $post_id = 0 ) {

		$post_id   = empty( $post_id ) ? get_the_ID() : $post_id;
		$mime_type = get_post_mime_type( $post_id );

		list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

		return (object) array( 'type' => $type, 'subtype' => $subtype );
	}

	public function get_attachment_type( $post_id = 0 ) {
		return $this->get_attachment_types( $post_id )->type;
	}

	public function get_attachment_subtype( $post_id = 0 ) {
		return $this->get_attachment_types( $post_id )->subtype;
	}

	public function is_attachment_audio( $post_id = 0 ) {
		return 'audio' === $this->get_attachment_type( $post_id );
	}

	public function is_attachment_video( $post_id = 0 ) {
		return 'video' === $this->get_attachment_type( $post_id );
	}

	/**
	 * Function for figuring out if we're viewing a "plural" page.  In WP, these pages after_header
	 * archives, search results, and the home/blog posts index.
	 * @method is_plural
	 * @return boolean          [description]
	 */
	public function is_plural() {
		return ( is_home() || is_archive() || is_search() );
	}

	// 2. Markup Helpers -----------------------------------------------

	/**
	 * Check if the string contains the given value.
	 *
	 * @param  string	$needle   The sub-string to search for
	 * @param  string	$haystack The string to search
	 *
	 * @return bool
	 */
    public function str_contains( $needle, $haystack ) {
        return strpos( $haystack, $needle ) !== false;
    }

	public function html_attributes( $attributes = array(), $prefix = '' ) {

		// If empty return false
		if ( empty( $attributes ) ) {
			return false;
		}

		$options = false;
		if( isset( $attributes['data-options'] ) ) {
			$options = $attributes['data-options'];
			unset( $attributes['data-options'] );
		}

		$out = '';
		foreach ( $attributes as $key => $value ) {

			if( ! $value ) {
				continue;
			}

			$key = $prefix . $key;
			if( true === $value ) {
				$value = 'true';
			}

			if( false === $value ) {
				$value = 'false';
			}

			if( is_array( $value ) ) {
				$out .= sprintf( ' %s=\'%s\'', esc_html( $key ), json_encode( $value ) );
			}
			else {
				$out .= sprintf( ' %s="%s"', esc_html( $key ), esc_attr( $value ) );
			}
		}

		if( $options ) {
			$out .= sprintf( ' data-options=\'%s\'', $options );
		}

		return $out;
	}

	public function attr( $context, $attributes = array() ) {
		$atts = $this->get_attr( $context, $attributes );
		echo apply_filters( 'liquid_attributes', $atts );
	}

	public function get_attr( $context, $attributes = array() ) {

		$defaults = array(
			'class' => sanitize_html_class( $context )
		);

		$attributes = wp_parse_args( $attributes, $defaults );
		$attributes = apply_filters( "liquid_attr_{$context}", $attributes, $context );

		$output = $this->html_attributes( $attributes );
	    $output = apply_filters( "liquid_attr_{$context}_output", $output, $attributes, $context );

	    return trim( $output );
	}

	// 3. Option Helpers -----------------------------------------------

	public function get_kit_option( $option ){

		// set pre default values because elementor return empty for default values
		$defaults = [
			// option name => default value
			'liquid_sidebar_widgets_style' => 'sidebar-widgets-outline',

			// WooCommerce
			'liquid_wc_archive_product_style' => 'default',
			'liquid_wc_ajax_filter' => 'off',
			'liquid_wc_ajax_pagination' => 'off',
			'liquid_wc_ajax_pagination_type' => 'classic',
			'liquid_wc_ajax_pagination_button_text' => 'Load more products',
			'liquid_wc_archive_breadcrumb' => 'off',
			'liquid_wc_archive_grid_list' => 'off',
			'liquid_wc_archive_sorter_enable' => 'off',
			'liquid_wc_archive_image_gallery' => 'off',
			'liquid_wc_archive_show_number' => 'off',
			'liquid_wc_archive_show_product_cats' => 'off',
			'liquid_wc_widget_side_drawer_label' => 'Fiter Products',
			'liquid_wc_widget_side_drawer_sidebar_id' => 'main',
			'liquid_wc_widget_side_drawer_mobile' => 'no',
			'liquid_wc_archive_result_count' => 'off',
			'liquid_wc_products_per_page' => '9',
			'liquid_wc_columns' => '3',
			'liquid_wc_product_page_style' => '0',
			'liquid_wc_custom_layout_enable' => 'off',
			'liquid_wc_custom_layout' => '',
			'liquid_wc_add_to_cart_ajax_enable' => 'off',
			'liquid_wc_share_enable' => 'on',
			'liquid_wc_related_columns' => '4',
			'liquid_wc_cross_sell_columns' => '2',
			'liquid_wc_up_sell_columns' => '4',

			// Performance
			'liquid_script_print_method' => 'internal',
			'liquid_load_fonts_locally' => 'off',
			'liquid_google_font_display' => 'swap',
			'liquid_custom_fonts_display' => 'swap',
			'liquid_lazy_load' => '',
			'liquid_lazy_load_offset' => ['size' => 500],
			'liquid_lazy_load_nth' => ['size' => 2],

			// Extras
			'liquid_cc' => 'off',
			'liquid_cc_label_explore' => 'Explore',
			'liquid_cc_label_drag' => 'Drag',
			'liquid_cc_hide_outer' => 'off',
			'liquid_cc_inner_size' => '7px',
			'liquid_cc_outer_size' => '35px',
			'liquid_cc_outer_active_border_width' => '1px',
			'liquid_cc_blend_mode' => 'normal',
			'liquid_preloader' => 'off',
			'liquid_pagescroll_speed' => ['size' => ''],
			'liquid_pagescroll_offset' => ['size' => 500],
			'liquid_back_to_top' => 'off',
			'liquid_back_to_top_scroll_ind' => 'off',
			'liquid_error_404_title' => '404',
			'liquid_error_404_subtitle' => 'Looks like you are lost',
			'liquid_error_404_content' => 'We can’t seem to find the page you’re looking for.',
			'liquid_error_404_enable_btn' => 'on',
			'liquid_error_404_btn_title' => 'Back to home',

			// Gdpr
			'liquid_gdpr_button' => 'Accept',
			'liquid_gdpr_content' => 'This website uses cookies to improve your web experience.',

			// Blog
			'liquid_blog_date_format' => 'ago',

			// API
			'liquid_mailchimp_text__missing_api' => 'Please, input the MailChimp Api Key in Theme Options Panel',
			'liquid_mailchimp_text__missing_list' => 'Wrong List ID, please select a real one',
			'liquid_mailchimp_text__thanks' => 'Thank you, you have been added to our mailing list.',
			'liquid_mailchimp_text__member_exists' => '[email] is already a list member. Use PUT to insert or update list members',

			// AI
			'liquid_ai' => '',
			'liquid_ai_api_key' => '',
			'liquid_ai_api_key_unsplash' => '',
			'liquid_ai_model' => 'text-davinci-003',
			'liquid_ai_max_tokens' => 2048,

			// Cache
			'liquid_header_cache' => 'on',
			'liquid_footer_cache' => 'on',

		];

		$val = get_post_meta( get_option('elementor_active_kit'), '_elementor_page_settings' );

		if ( ! empty( $val ) ) {
			$val = $val[0];
			if ( isset( $val[$option] ) ) {
				return $val[$option];
			} else {
				if ( isset( $defaults[$option] ) ) {
					return $defaults[$option];
				}
			}
		} else {
			if ( isset( $defaults[$option] ) ) {
				return $defaults[$option];
			}
		}

	}

	public function get_kit_frontend_option( $option ){

		// set pre default values because elementor return empty for default values
		$defaults = [
			// option name => default value

			// Blog
			'liquid_blog_single_post_style' => 'classic',
			'liquid_blog_single_post_date' => 'on',
			'liquid_blog_single_post_author' => 'on',
			'liquid_blog_single_social_box_enable' => 'on',
			'liquid_blog_single_author_box_enable' => 'on',
			'liquid_blog_single_author_role_enable' => '',
			'liquid_blog_single_floating_box_enable' => '',
			'liquid_blog_single_floating_box_social_style' => 'default',
			'liquid_blog_single_floating_box_author_enable' => '',
			'liquid_blog_single_navigation_enable' => 'on',
			'liquid_blog_single_archive_link' => '',
			'liquid_blog_single_related_enable' => 'on',
			'liquid_blog_single_related_style' => 'style-1',
			'liquid_blog_single_related_title' => 'You may also like',
			'liquid_blog_single_related_number' => '2',

			// Portfolio
			'liquid_portfolio_archive_style' => 'style01',
			'liquid_portfolio_horizontal_alignment' => '',
			'liquid_portfolio_vertical_alignment' => '',
			'liquid_portfolio_grid_columns' => '2',
			'liquid_portfolio_columns_gap' => ['size' => '15'],
			'liquid_portfolio_bottom_gap' => ['size' => '30'],

			// Elementor
			'viewport_tablet' => '1199',

			// Site Settings
			'favicon' => [ 'url' => '' ],
			'iphone_icon' => [ 'url' => '' ],
			'iphone_icon_retina' => [ 'url' => '' ],
			'ipad_icon' => [ 'url' => '' ],
			'ipad_icon_retina' => [ 'url' => '' ],

			// Header
			'liquid_header_condition_enable' => 'on',

			// Footer
			'liquid_footer_condition_enable' => 'on',

			// Title Wrapper
			'liquid_titlewrapper_condition' => 'on',

		];

		if ( !defined( 'ELEMENTOR_VERSION' ) && !is_callable( 'Elementor\Plugin::instance' ) || !class_exists( 'Liquid_Addons' ) ) {
			if ( isset( $defaults[$option] ) ) {
				return $defaults[$option];
			}
			return;
		}

		$rules = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( $option );

		return $rules;

	}

	public function get_page_option( $option, $post_id = '' ){

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {

			$post_id = !empty( $post_id ) ? $post_id : get_the_ID();
 			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
			$page_settings_model = $page_settings_manager->get_model( $post_id );

			return $page_settings_model->get_settings( $option );
		}
	}

	public function get_post_meta( $id, $post_id = null ) {

		if ( is_null( $post_id ) ) {
			$post_id = $this->get_current_page_id();
		}

		if ( ! $post_id ) {
			return;
		}

		$value = get_post_meta( $post_id, $id, true );
		if( is_array( $value ) ) {
			$value = array_filter($value);

			if( empty( $value ) ) {
				return '';
			}
		}
		return $value ? $value : '';
	}

	public function get_current_page_id() {

		global $post;
		$page_id = false;
		$object_id = is_null($post) ? get_queried_object_id() : $post->ID;

		// If we're on search page, set to false
		if( is_search() ) {
			$page_id = false;
		}
		// If we're not on a singular post, set to false
		if( ! is_singular() ) {
			$page_id = false;
		}
		// Use the $object_id if available
		if( ! is_home() && ! is_front_page() && ! is_archive() && isset( $object_id ) ) {
			$page_id = $object_id;
		}
		// if we're on front-page
		if( ! is_home() && is_front_page() && isset( $object_id ) ) {
			$page_id = $object_id;
		}
		// if we're on posts-page
		if( is_home() && ! is_front_page() ) {
			$page_id = get_option( 'page_for_posts' );
		}
		// The woocommerce shop page
		if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
			if( $shop_page = wc_get_page_id( 'shop' ) ) {
				$page_id = $shop_page;
			}
		}
		// if in the loop
		if( in_the_loop() ) {
			$page_id = get_the_ID();
		}

		return $page_id;
	}

	public function is_woocommerce_active() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}

	public function dashboard_page_url() {

		if( isset( $_GET['page'] ) && 'liquid' === $_GET['page'] ) {
			return '';
		}
		return admin_url( 'admin.php?page=liquid' );
	}

	public function plugin_page_url() {
		return admin_url( 'admin.php?page=liquid-plugins' );
	}

	public function import_demos_page_url() {
		return admin_url( 'admin.php?page=liquid-import-demos' );
	}

	public function active_tab( $page ) {

		if( isset( $_GET['page'] ) && $page === $_GET['page'] ) {
			echo 'is-active';
		}

	}

	public function check_post_types( $force = true ) {

		$post_types = apply_filters(
			'liquid_check_post_types',
			[
				'liquid-header',
				'liquid-footer',
				'liquid-mega-menu',
				'liquid-sticky-atc',
				'liquid-archives',
				'liquid-title-wrapper',
				'ld-product-layout',
				'ld-product-sizeguide',
				'elementor_library'
			]
		);

		if ( $force ) {
			if ( in_array( get_post_type(), $post_types ) ) {
				return true;
			}
		}

		return false;

	}

	public function liquid_post_date() {

		if ( liquid_helper()->get_kit_option( 'liquid_blog_date_format' ) === 'ago' ) {
			return sprintf( esc_html__( '%s ago', 'aihub' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
		} else{
			return get_the_date();
		}

	}

	public function get_page_id_by_url() {

		global $wp;

		$url = add_query_arg( $wp->request, home_url() );
		if ( !empty( site_url( '', 'relative' ) ) ) {
			$url_parts = parse_url( home_url() );
			$url = $url_parts['scheme'] . "://" . $url_parts['host'] . add_query_arg( NULL, NULL );
		}
		if ( '/?' == substr( $url, 0, 2) ) {
			$url = home_url();
		}
		$post_id = url_to_postid( $url );

		return $post_id;

	}

	public function get_script_id() {

		$post_id = liquid_helper()->get_page_id_by_url();
		$cpt_id = liquid_get_custom_header_id().'-'.liquid_get_custom_footer_id();

		if (
			$post_id == 0 ||
			($post_id > 0 && !liquid_helper()->is_built_with_elementor())
		) {
			return $cpt_id;
		}

		return $post_id;
	}

	public function is_page_elementor( $is_script = false ) {

		global $wp;

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ){

			// check archive and woocommerce pages
			if ( is_archive() || is_search() || is_404() || get_post_type( $this->get_page_id_by_url() ) == 'product' ||
			class_exists('WooCommerce') && is_product() || class_exists('WooCommerce') && is_shop() ){
				return false;
			}

			// check preview mode
			// $parse_args = wp_parse_args( add_query_arg( $_GET, $wp->request ) );
			// if ( isset( $parse_args['preview'] ) == 'true' ){
			// 	return false;
			// }

			// check blog posts page
			if ( get_option('page_for_posts') == $this->get_page_id_by_url() || $this->get_page_id_by_url() == 0 ){
				return false;
			}

			// check elementor
			$document = \Elementor\Plugin::$instance->documents->get( $this->get_page_id_by_url() );

			if ( ! $document ) {
				return false;
			}

			if ( $document->is_built_with_elementor() ) {

				// if ( ! $this->get_scripts_cache( $this->get_page_id_by_url() ) ) {
				// 	return false;
				// }

				return true;
			}

		}


		return false;
	}

	public function is_built_with_elementor() {

		if ( ! class_exists( 'Elementor\Plugin' ) ) {
			return false;
		}

		$type = get_post_type();

		// if ( 'page' !== $type && 'post' !== $type ) {
		// 	return false;
		// }

		$current_id = liquid_helper()->get_page_id_by_url();

		if ( ! $current_id || $current_id < 0 ) {
			return false;
		}

		return \Elementor\Plugin::$instance->documents->get( $current_id )->is_built_with_elementor();
	}

	public function get_scripts_cache( $post_id ) {

		$get_cache = get_option( 'liquid_scripts_cache' );

		if ( $post_id == 0 ) {
			$post_id = liquid_get_custom_header_id() . '-' . liquid_get_custom_footer_id();
		}

		if ( is_array( $get_cache ) ){
			if ( in_array( $post_id, $get_cache ) ){

				if ( !file_exists( $file = wp_upload_dir()['basedir'] . '/liquid-scripts/liquid-frontend-script-' . $post_id . '.js' ) ){
					return false;
				}
				return true;
			}
		}

		return false;

	}

	public function purge_scripts_cache( $post_id ) {
		if ( $post_id === true ){ // if post_id is true, purge all cache
			update_option( 'liquid_scripts_cache', array() );
			if ( is_array( scandir( wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'liquid-scripts' ) ) ){
				foreach ( array_diff(scandir( wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'liquid-scripts' ), array('.', '..')) as $file ){ // find all files in uploads/liquid-scripts
					wp_delete_file( wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'liquid-scripts' . DIRECTORY_SEPARATOR . $file ); // delete all files
				}
			}
		} else { // purge cache by post_id
			$get_cache = get_option( 'liquid_scripts_cache' );
			if ( is_array( $get_cache ) ){
				if (($key = array_search($post_id, $get_cache)) !== false) {
					unset($get_cache[$key]);
					update_option( 'liquid_scripts_cache', $get_cache, 'yes' );
					//wp_delete_file( wp_upload_dir()['basedir'] . '/liquid-scripts/liquid-frontend-animation-' . $post_id . '.css' ); // delete css file
					wp_delete_file( wp_upload_dir()['basedir'] . '/liquid-scripts/liquid-frontend-script-' . $post_id . '.js' ); // delete js file
				}
			}
		}

	}

	public function lqd_el_container_bg( $content, $ids ){

		if ( empty( $content ) || count( $ids ) == 0 ) {
			return $content;
		}

		libxml_use_internal_errors( true ); // Hide errors for HTML5
		$doc = new DOMDocument();
		$fix_chartset = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
		@$doc->loadHTML($fix_chartset);

		$xpath = new DOMXPath( $doc ); // Create a new xpath object

		// Loop through each ID and HTML to be added
		foreach( $ids as $id => $html ) {
			$element = $xpath->query('//div[@data-id="' . $id . '"]')->item(0);
			if ($element) {
				// Find the inner div element to append to
				// TODO: Check .e-con-inner reason.
				$innerElement = $xpath->query('.//div[@class="e-con-inner--disabled"]', $element)->item(0);
				if (!$innerElement) {
					// If there is no inner div with class "e-con-inner", use the outer div
					$innerElement = $element;
				}
				// Create a new document fragment for the HTML to be added
				$newElement = $doc->createDocumentFragment();
				$newElement->appendXML($html);
				// Insert the new element before the first child of the inner div element
				$innerElement->insertBefore($newElement, $innerElement->firstChild);
			}
		}

		$content = $doc->saveHTML();
		return $content;

	}

	function purge_all_cache() {

		if ( liquid_helper()->get_kit_option('liquid_script_print_method') == 'external' ) {
			global $wpdb;
	
			$wpdb->delete($wpdb->postmeta, ['meta_key' => '_liquid_post_content']);
			$wpdb->delete($wpdb->postmeta, ['meta_key' => '_liquid_post_content_has_bg']);
	
			if ( defined('ELEMENTOR_VERSION') ){
				\Elementor\Plugin::instance()->files_manager->clear_cache();
			}
	
			update_option( 'lqd_el_container_bg', array() );
			update_option( 'liquid_utils_css', '' );
			update_option( 'liquid_typekit_css', '' );
			update_option( 'liquid_widget_asset_css', array() );
			liquid_helper()->purge_scripts_cache( true );
	
			add_action( 'admin_notices', function(){
				$class = 'notice notice-success is-dismissible';
				$message = __( 'Liquid Cache purged.', 'aihub' );
	
				printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
			} );
		} else {
			liquid_helper()->purge_scripts_cache( true );
		}

	}

	function system_requirements( $only_status = false ) {

		$status = true;
		$memory_limit = $max_input_time = -1;
		$memory_limit_requried = 256;
		$max_input_time_requried = 300;
		
		if ( function_exists( 'ini_get' ) ) {
			$memory_limit = (int) ini_get( 'memory_limit' );
			if ( $memory_limit != -1 && ( $memory_limit < $memory_limit_requried ) ) {
				$status = false;
			}

			$max_input_time = (int) ini_get( 'max_input_time' );
			if ( $max_input_time != -1 && ( $max_input_time < $max_input_time_requried ) ) {
				$status = false;
			}
		}

		if ( $only_status ){
			return $status;
		}

		return [
			'status' => $status,
			'vars' => [
				'memory_limit' => [
					'value' => $memory_limit,
					'required' => $memory_limit_requried,
					'type' => 'M'
				],
				'max_input_time' => [
					'value' => $max_input_time,
					'required' => $max_input_time_requried,
				]
			]
		];

	}

	function system_requirements_table() {
		$system_requirements = $this->system_requirements();
		$status = $system_requirements['status'];
		$vars = $system_requirements['vars'];

		?>

			<table class="widefat striped health-check-table" role="presentation" style="border-radius:12px">
				<thead>
					<tr>
						<td><?php _e( 'System Requirements', 'aihub' ); ?></td>
						<td> <?php echo $status ? '<span class="dashicons dashicons-yes-alt"></span> Passed' : '<span style="color:darkred"><span class="dashicons dashicons-warning"></span> Action Required!</span>'; ?></td>
					</tr>
				</thead>
				<tbody style="text-align:left">
					<?php
						foreach( $vars as $key => $var ) {
							printf( 
								'<tr><td>%1$s</td><td>%2$s</td></tr>',
								$key,
								$var['value'] != -1 && ($var['value'] < $var['required']) ? sprintf( '<span style="color:darkred"><span class="dashicons dashicons-warning"></span> %1$s%3$s (Required: %2$s%3$s)</span>',$var['value'], $var['required'], $var['type'] ?? '' ) : sprintf( '<span class="dashicons dashicons-yes-alt"></span> %s', $var['value'] ),
							);
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><a href="https://docs.liquid-themes.com/article/584-ai-hub-minimum-php-requirements" target="_blank"><span class="dashicons dashicons-editor-help"></span> Documentation</a></td>
					</tr>
				</tfoot>
			</table>


		<?php
	}

	function get_breakpoints_value($device){

		$breakpoints = [
			'mobile' => 767,
			'mobile_extra' => 880,
			'tablet' => 1024,
			'tablet_extra' => 1200,
			'laptop' => 1366,
			'widescreen' => 2400,
		];

		$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

		if ( isset($active_breakpoints[ $device ]) ){
			return $active_breakpoints[ $device ]->get_value();
		} else {
			return $breakpoints[ $device ];
		}
	}

	function generate_styles($rules, $indent = 0) {

		$css = '';

		foreach( $rules as $device_key => $device ){

			if ( $device_key !== 'all' ){
				$css .= "@media (max-width: {$this->get_breakpoints_value($device_key)}px){\n";
			}

			foreach( $device as $selector => $value ){

				$css .= "$selector {\n";
					foreach( $value as $prop => $v ){
						$css .= "   $prop: $v;\n";
					}
				$css .= "}\n";
			}

			if ( $device_key !== 'all' ){
				$css .= "}\n";
			}

		}

		return $css;


	}

	function updateBehaviorNames( $behaviors ) {
		if ( !empty ( $behaviors ) ) {
			$new_behaviors = str_replace(
				array( 'behaviorClass', 'Liquid', 'Behavior' ),
				array( 'behaviorName', 'liquid', '' ),
				$behaviors
			);
	
			// $new_behaviors = preg_replace('/\bbehaviorName:([^,]+),/', 'behaviorName:"$1",', $new_behaviors);
			$new_behaviors = preg_replace('/\bbehaviorName:([^,}]+)(,|})/', "behaviorName:'$1'$2", $new_behaviors);
	
			return $new_behaviors;
		}
    }

}

/**
 * Main instance of Liquid_Helper.
 *
 * Returns the main instance of Liquid_Helper to prevent the need to use globals.
 *
 * @return Liquid_Helper
 */
function liquid_helper() {
	return Liquid_Helper::instance();
}
