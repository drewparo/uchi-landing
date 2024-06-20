<?php
/**
 * Liquid Themes Theme Hooks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Filters
add_filter( 'body_class', 'liquid_add_body_classes' );
add_filter( 'admin_body_class', 'liquid_add_admin_body_classes' );
add_filter( 'liquid_attr_body', 'liquid_mobile_nav_body_attributes', 10 );
add_filter( 'liquid_attr_body', 'liquid_add_custom_cursor', 10 );
add_filter( 'comment_form_fields', 'liquid_move_comment_field_to_bottom' );
add_filter( 'wp_kses_allowed_html', 'liquid_kses_allowed_html', 10, 2);

// Actions
add_action( 'after_setup_theme', 'liquid_custom_sidebars', 9 );
add_action( 'init', 'liquid_enable_lazy_load' );
add_action( 'comment_form_top', 'liquid_before_comment_form', 9 );
add_action( 'comment_form', 'liquid_after_comment_form', 9 );
add_action( 'template_include', 'liquid_page_ajaxify', 1 );
add_action( 'wp_head', 'liquid_print_custom_product_layout_css', 1001 );
add_action( 'wp_head', 'liquid_print_woo_cats_page_css', 1002 );
add_action( 'wp_footer', 'liquid_get_custom_cursor', 54 );
add_action( 'wp_footer', 'liquid_get_snickers_bar_template', 55 );
add_action( 'wp_footer', 'liquid_get_modal_template', 57 );

// Actions - Liquid
add_action( 'liquid_before', 'liquid_get_preloader' );
add_action( 'liquid_header', 'liquid_get_header_view' );
add_action( 'liquid_header_titlebar', 'liquid_get_header_titlebar_view' );
add_action( 'liquid_before_single_article_content', 'liquid_single_post_start_container', 1 );
add_action( 'liquid_after_single_article_content', 'liquid_single_post_end_container', 99 );
add_action( 'liquid_before_footer', 'liquid_get_back_to_top_link' );
add_action( 'liquid_after_footer', 'liquid_get_gdpr' );
add_action( 'liquid_after_header', 'liquid_get_titlebar_view' );
add_action( 'liquid_footer', 'liquid_get_footer_view' );

// Actions - WooCommerce
add_action( 'woocommerce_shortcode_before_products_loop', 'liquid_before_products_shortcode_loop', 1, 10 );
add_action( 'woocommerce_shortcode_after_products_loop', 'liquid_after_products_shortcode_loop', 0, 10 );
add_action( 'woocommerce_shortcode_before_product_loop', 'liquid_before_products_shortcode_loop', 1, 10 );
add_action( 'woocommerce_shortcode_after_product_loop', 'liquid_after_products_shortcode_loop', 0, 10 );
add_action( 'woocommerce_shortcode_before_product_category_loop', 'liquid_before_products_shortcode_loop', 1, 10 );
add_action( 'woocommerce_shortcode_after_product_category_loop', 'liquid_after_products_shortcode_loop', 0, 10 );

$woo_breadcrumb_enable = liquid_helper()->get_kit_option( 'liquid_wc_archive_breadcrumb' );
if( 'on' === $woo_breadcrumb_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'woocommerce_breadcrumb', 11 );
} else {
	remove_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 20 );
}

$grid_list_enable = liquid_helper()->get_kit_option( 'liquid_wc_archive_grid_list' );
if( 'on' === $grid_list_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_woocommere_top_bar_grid_list_selector', 12 );
}

$product_categories_trigger_enable = liquid_helper()->get_kit_option( 'liquid_wc_archive_show_product_cats' );
if( 'on' === $product_categories_trigger_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_woo_top_bar_product_categories_trigger', 13 );
}

$product_show_limit_enable = liquid_helper()->get_kit_option( 'liquid_wc_archive_show_number' );
if( 'on' === $product_show_limit_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_woo_top_bar_show_products', 12 );
}

$sorterby_enable = liquid_helper()->get_kit_option( 'liquid_wc_archive_sorter_enable' );
if( 'off' === $sorterby_enable ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
}

$result_count_enable = liquid_helper()->get_kit_option( 'liquid_wc_archive_result_count' );
if( 'off' === $result_count_enable ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
}

if( 'on' == $sorterby_enable || 'on' == $result_count_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_start_sorter_counter_container', 19 );
	add_action( 'woocommerce_before_shop_loop', 'liquid_end_sorter_counter_container', 99 );
}

$view_type = liquid_woocommerce_get_products_list_view_type();

if( 'list' == $view_type ) {
	if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
		remove_action( 'init', array( YITH_WCQV_Frontend(), 'add_button' ) );
	}
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
	add_filter( 'woocommerce_product_loop_start', 'liquid_woocommerce_product_loop_start_div', 99 );
	add_filter( 'woocommerce_product_loop_end', 'liquid_woocommerce_product_loop_end_div', 99 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 75 );
	add_action( 'woocommerce_extra_buttons_item', 'liquid_add_wishlist_button', 15 );
	add_action( 'woocommerce_extra_buttons_item', 'liquid_add_quickview_button', 10 );
	add_action( 'woocommerce_extra_buttons_item', 'liquid_get_compare_button', 20 );
	add_action( 'liquid_loop_product_summary_foot', 'woocommerce_template_loop_add_to_cart', 10 );
}

$add_to_cart_ajax_enable = liquid_helper()->get_kit_option( 'liquid_wc_add_to_cart_ajax_enable' );
if( 'on' === $add_to_cart_ajax_enable ) {
	add_filter( 'liquid_ajax_add_to_cart_single_product', '__return_true', 99 );
}

$enable_woo_image_gallery = liquid_helper()->get_kit_option( 'liquid_wc_archive_image_gallery' );
if( 'on' !== $enable_woo_image_gallery ) {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'liquid_woocommerce_template_loop_product_gallery', 12 );
}

// Functions

function liquid_add_body_classes( $classes ) {

	if ( get_post_type() === 'post' || get_post_type() === 'page' || get_post_type() === 'liquid-portfolio' ){
		$enable_frame = liquid_helper()->get_page_option( 'page_enable_frame' );
		$enabled_stack = liquid_helper()->get_page_option( 'page_enable_stack' );
		$enabled_nav_stack = liquid_helper()->get_page_option( 'page_stack_nav' );
		$enabled_nums_stuck = liquid_helper()->get_page_option( 'page_stack_numbers' );
		$nums_stack_style = liquid_helper()->get_page_option( 'page_stack_numbers_style' );
		$buttons_style = liquid_helper()->get_page_option( 'page_stack_buttons_style' );
		$nav_stack_style = liquid_helper()->get_page_option( 'page_stack_nav_style' );

		// Single Post Options
		$single_post_style = liquid_helper()->get_page_option( 'post_style' );
		$single_post_style = $single_post_style ? $single_post_style : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_post_style' );

		// Portfolio Options
		$portfolio_single_post_style = liquid_helper()->get_page_option( 'portfolio_style' );
		$portfolio_single_post_style = $portfolio_single_post_style ? $portfolio_single_post_style : liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_archive_style' );

		//Add for single post body classnames
		if( is_singular( 'post' ) ) {

			$classes[] = 'lqd-blog-post';

			if( empty( $single_post_style ) ) {
				$single_post_style = 'classic';
			}

			switch( $single_post_style ) {

				case 'modern':
					$classes[] = 'lqd-blog-post-style-1';
				break;

				case 'modern-full-screen':
					$classes[] = 'lqd-blog-post-style-2';
				break;

				case 'minimal':
					$classes[] = 'lqd-blog-post-style-3';
				break;

				case 'overlay':
					$classes[] = 'lqd-blog-post-style-4';
				break;

				case 'dark':
					$classes[] = 'lqd-blog-post-style-5';
				break;

				case 'classic':
				default:
					$classes[] = 'lqd-blog-post-style-6';
				break;

				case 'wide':
					$classes[] = 'lqd-blog-post-style-7';
				break;

				case 'cover':
					$classes[] = 'lqd-blog-post-style-8';
				break;
			}


			if( has_post_thumbnail() ) {
				$classes[] = 'has-thumbnail';
			}
			else {
				$classes[] = 'has-no-thumbnail';
			}
			if( '' === get_post()->post_content ) {
				$classes[] = 'post-has-no-content';
			}

		}

		// Portfolio
		if( ('custom' !== $portfolio_single_post_style) && get_post_type() === 'liquid-portfolio' ) {
			$classes[] = 'lqd-pf-single lqd-pf-single-style-1';
		}

		// Page frame
		if( 'on' === $enable_frame ) {
			$classes[] = 'page-has-frame';
		}

		// Page stack
		if( 'on' === $enabled_stack ) {

			$classes[] = !empty( $buttons_style ) ? $buttons_style : 'lqd-stack-buttons-style-1';
			if( 'on' == $enabled_nav_stack ) {
				$classes[] = !empty( $nav_stack_style ) ? $nav_stack_style : 'lqd-stack-nav-style-1';
			}

			if( 'on' == $enabled_nums_stuck ) {
				$classes[] = !empty( $nums_stack_style ) ? $nums_stack_style : 'lqd-stack-nums-style-1';
			}

			$classes[] = 'lqd-stack-enabled';

		}

		// Header body class
		$layout = liquid_helper()->get_page_option( 'header_layout', liquid_get_custom_header_id() );

		if( $layout ) {
			if( 'fullscreen' === $layout ) {
				$classes[] = 'header-style-fullscreen';
			}
			elseif( in_array( $layout, array( 'side', 'side-2', 'side-3' ) ) ) {
				$classes[] = 'header-style-side';
			}
		}

	}

	// WooCommerce
	if( class_exists( 'WooCommerce' ) && is_product() ) {

		$sp_custom_layout_enable = get_post_meta( get_the_ID(), 'liquid_product_layout_enable', true );

		if ( $sp_custom_layout_enable === 'on' ) {
			$sp_custom_layout = get_post_meta( get_the_ID(), 'liquid_product_layout', true );
		} elseif ( $sp_custom_layout_enable === '0' || empty( $sp_custom_layout_enable ) ) {
			$sp_custom_layout_enable = liquid_helper()->get_kit_option( 'liquid_wc_custom_layout_enable' );
			$sp_custom_layout = liquid_helper()->get_kit_option( 'liquid_wc_custom_layout' );
		}

		if( 'on' !== $sp_custom_layout_enable ) {
			$single_product_style = get_post_meta( get_the_ID(), 'liquid_product_page_style', true );
			if ( $single_product_style === '0'){
				$single_product_style = liquid_helper()->get_kit_option( 'liquid_wc_product_page_style' );
			}
			if( '1' === $single_product_style ) {
				$classes[] = 'lqd-woo-single-layout-1 lqd-woo-single-images-grid';
			}
			elseif( '2' === $single_product_style ) {
				$classes[] = 'lqd-woo-single-layout-2 lqd-woo-single-images-sticky-stack';
			}
			else {
				$classes[] = 'lqd-woo-single-layout-3 lqd-woo-single-images-woo-default';
			}
		}
	}

	$enable_preloader = liquid_helper()->get_kit_option( 'liquid_preloader' );
	if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		$enable_preloader = "off";
	}
	if( 'on' === $enable_preloader ) {
		$preloader_style  = liquid_helper()->get_kit_option( 'liquid_preloader_style' );
		$classes[] = 'lqd-preloader-activated';
		$classes[] = 'lqd-page-not-loaded';
		$classes[] = !empty( $preloader_style ) ? 'lqd-preloader-style-' . $preloader_style : 'lqd-preloader-style-spinner';
	}


	$sidebar_style = liquid_helper()->get_kit_option( 'liquid_sidebar_widgets_style' );
	if( !empty( $sidebar_style ) ) {
		$classes[] = $sidebar_style;
	}

	//Progressively load classnames
	if( 'on' === liquid_helper()->get_kit_option( 'liquid_lazy_load' ) && !is_admin() ) {
		$classes[] = 'lazyload-enabled';
	}

	return $classes;

}

function liquid_add_admin_body_classes( $classes ) {

	$enabled_stack = liquid_helper()->get_page_option( 'page_enable_stack' );
	if( 'on' === $enabled_stack ) {
		$classes .= 'lqd-stack-enabled';
		return $classes;
	}

}

function liquid_mobile_nav_body_attributes( $attributes ) {

	//Default Values
	$attributes['data-mobile-nav-style']             = 'modern';
	$attributes['data-mobile-nav-scheme']            = 'dark';
	$attributes['data-mobile-nav-trigger-alignment'] = 'right';
	$attributes['data-mobile-header-scheme']         = 'gray';
	$attributes['data-mobile-logo-alignment']        = 'default';

	return $attributes;

}

function liquid_add_custom_cursor( $attributes ) {

	$bgs = array();
	$enable = liquid_helper()->get_kit_option( 'liquid_cc' );
	$hide_outer = liquid_helper()->get_kit_option( 'liquid_cc_hide_outer' );


	if( 'on' !== $enable ) {
		return $attributes;
	}
	if( 'on' == $hide_outer ) {
		$bgs['outerCursorHide'] = true;
	}

	$attributes['data-lqd-cc'] = 'true';

	if( !empty( $bgs ) ) {
		$attributes['data-cc-options'] = wp_json_encode( $bgs );
	}

	return $attributes;

}

function liquid_get_custom_cursor() {

	$enable  = liquid_helper()->get_kit_option( 'liquid_cc' );
	$explore = liquid_helper()->get_kit_option( 'liquid_cc_label_explore' );
	if( empty( $explore ) ) {
		$explore = esc_html__( 'Explore', 'aihub' );
	}
	$drag    = liquid_helper()->get_kit_option( 'liquid_cc_label_drag' );
	if( empty( $drag ) ) {
		$drag = esc_html__( 'Drag', 'aihub' );
	}

	// Check if preloader is enabled
	if( 'on' !== $enable ) {
		return;
	}

	echo '<div class="lqd-cc lqd-cc--inner fixed pointer-events-none"></div>

	<div class="lqd-cc--el lqd-cc-solid lqd-cc-explore flex items-center justify-center rounded-full circle fixed pointer-events-none">
		<div class="lqd-cc-solid-bg flex absolute absolute top-0 start-0"></div>
		<div class="lqd-cc-solid-txt flex justify-center text-center relative">
			<div class="lqd-cc-solid-txt-inner">' . wp_kses( $explore, array( 'i' => array( 'class' => array(), 'style' => array(), 'aria-hidden' => array(),) ) ) . '</div>
		</div>
	</div>

	<div class="lqd-cc--el lqd-cc-solid lqd-cc-drag flex items-center justify-center rounded-full circle fixed pointer-events-none">
		<div class="lqd-cc-solid-bg flex absolute absolute top-0 start-0"></div>
		<div class="lqd-cc-solid-ext lqd-cc-solid-ext-left d-inline-flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M19.943 6.07L9.837 14.73a1.486 1.486 0 0 0 0 2.25l10.106 8.661c.96.826 2.457.145 2.447-1.125V7.195c0-1.27-1.487-1.951-2.447-1.125z"></path></svg>
		</div>
		<div class="lqd-cc-solid-txt flex justify-center text-center relative">
			<div class="lqd-cc-solid-txt-inner">' . wp_kses( $drag, array( 'i' => array( 'class' => array(), 'style' => array(), 'aria-hidden' => array(),) ) ) . '</div>
		</div>
		<div class="lqd-cc-solid-ext lqd-cc-solid-ext-right d-inline-flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M11.768 25.641l10.106-8.66a1.486 1.486 0 0 0 0-2.25L11.768 6.07c-.96-.826-2.457-.145-2.447 1.125v17.321c0 1.27 1.487 1.951 2.447 1.125z"></path></svg>
		</div>
	</div>

	<div class="lqd-cc--el lqd-cc-arrow d-inline-flex items-center fixed pos-tl pointer-events-none">
		<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M60.4993 0V4.77005H8.87285L80 75.9207L75.7886 79.1419L4.98796 8.35478V60.4993H0V0H60.4993Z"/>
		</svg>
	</div>

	<div class="lqd-cc--el lqd-cc-custom-icon rounded-full circle fixed pointer-events-none">
		<div class="lqd-cc-ci d-inline-flex items-center justify-center rounded-full circle relative">
			<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M16.03 6a1 1 0 0 1 1 1v8.02h8.02a1 1 0 1 1 0 2.01h-8.02v8.02a1 1 0 1 1-2.01 0v-8.02h-8.02a1 1 0 1 1 0-2.01h8.02v-8.01a1 1 0 0 1 1.01-1.01z"></path></svg>
		</div>
	</div>

	<div class="lqd-cc lqd-cc--outer fixed pos-tl pointer-events-none"></div>';

}

function liquid_get_preloader() {

	if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		return;
	}

	$enable = liquid_helper()->get_kit_option( 'liquid_preloader' );
	$preloader_style  = liquid_helper()->get_kit_option( 'liquid_preloader_style' );
	// Check if preloader is enabled
	if( 'on' !== $enable ) {
		return;
	}

	if( !empty( $preloader_style ) ) {

		get_template_part( 'templates/preloader/' . $preloader_style );
		return;
	}

	get_template_part( 'templates/preloader/spinner' );

}

function liquid_get_header_view() {

	error_reporting(0);

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() && 'liquid-header' === get_post_type() ) {
			liquid_action( 'after_header_tag' );
			return;
		}

		$enable = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'liquid_header_condition_enable' );
		if ( $enable !== 'on' ) {
			return;
		}

	}

	if ( liquid_helper()->check_post_types() ) {
		return;
	}

	// TODO: Clean up this code block for the next releases.
	// Disabled this code block: This code block coming from Hub and disabling header when Header Overlay + Titlewrapper enabled.
	// $header_id = liquid_get_custom_header_id();
	// $titlewrapper_id = liquid_get_custom_titlewrapper_id();

	// $header_overlay = liquid_helper()->get_page_option( 'header_overlay', $header_id );
	// if ( 'yes' === $header_overlay && ( 'off' !== $titlewrapper_id && !empty( $titlewrapper_id ) ) ){
	// 	return;
	// }

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		$id = liquid_get_custom_header_id();
		if ($id){
			get_template_part( 'templates/header/custom' );
			return;
		}
	}


	get_template_part( 'templates/header/default' );

}

function liquid_get_header_titlebar_view() {

	if ( !class_exists( 'Liquid_Addons' ) || !defined( 'ELEMENTOR_VERSION' ) ){
		return;
	}

	if ( liquid_helper()->check_post_types() ) {
		return;
	}

	$header_id = liquid_get_custom_header_id();
	$enable = liquid_helper()->get_kit_frontend_option( 'liquid_titlewrapper_condition' );
	$header_overlay = liquid_helper()->get_page_option( 'header_overlay', $header_id );

	// Check if titlebar is disabled
	if( 'on' !== $enable ) {
		return;
	}

	// Check if header overlay is disabled
	if( empty( $header_overlay ) ){
		return;
	}

	if ( $header_id ){
		get_template_part( 'templates/header/custom' );
		return;
	}

	get_template_part( 'templates/header/default' );

}

function liquid_get_back_to_top_link() {

	if ( defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		return;
	}

	$enable = liquid_helper()->get_kit_option( 'liquid_back_to_top' );
	if( 'on' !== $enable ) {
		return;
	}

	$scroll_indicator = liquid_helper()->get_kit_option( 'liquid_back_to_top_scroll_ind' );
	$scroll_ind_markup = '';

	if ( 'on' === $scroll_indicator ) {
		$scroll_ind_markup = '<span class="lqd-back-to-top-scrl-ind absolute top-0 start-0 d-block" data-lqd-scroll-indicator="true" data-scrl-indc-options=\'{"scale": true, "end": "bottom bottom", "origin": "bottom"}\'>
			<span class="lqd-scrl-indc-inner d-block absolute top-0 start-0">
					<span class="lqd-scrl-indc-line d-block absolute top-0 start-0">
						<span class="lqd-scrl-indc-el d-block absolute top-0 start-0"></span>
					</span>
			</span>
		</span>';
	}

	echo '<div class="lqd-back-to-top fixed" data-back-to-top="true">
			<a href="#wrap" class="d-inline-flex items-center justify-center rounded-full circle relative overflow-hidden" data-localscroll="true">
			' . $scroll_ind_markup . '
				<svg class="d-inline-block" xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; heigth: 1em;"><path fill="white" d="M10.5 13.625l-7.938 7.938c-.562.562-1.562.562-2.124 0C.124 21.25 0 20.875 0 20.5s.125-.75.438-1.063L9.5 10.376c.563-.563 1.5-.5 2.063.063l9 9c.562.562.562 1.562 0 2.125s-1.563.562-2.125 0z"></path></svg>
			</a>
		</div>';

}

function liquid_get_gdpr() {

	if ( liquid_helper()->get_kit_option( 'liquid_gdpr' ) === 'on' ){

		if ( empty( $content = liquid_helper()->get_kit_option( 'liquid_gdpr_content' ) ) ){
			$content = esc_html__( 'This website uses cookies to improve your web experience.', 'aihub' );
		}
		if ( empty( $button = liquid_helper()->get_kit_option( 'liquid_gdpr_button' ) ) ){
			$button = esc_html__( 'Accept', 'aihub' );
		}

		printf('
			<div id="lqd-gdpr" class="lqd-gdpr">
				<div class="lqd-gdpr-inner">
					<div class="lqd-gdpr-left">%s</div>
					<div class="lqd-gdpr-right"><button class="lqd-gdpr-accept">%s</button></div>
				</div>
			</div>
		',$content, $button );

	}

}

function liquid_get_titlebar_view() {

	error_reporting(0);

	$id = liquid_get_custom_titlewrapper_id();

	if ( liquid_helper()->check_post_types() || $id === 'off' ) {
		return;
	}

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		if ( $id ){
			echo '<div class="titlebar">' . Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id ) . '</div>';
			return;
		}
	}

	if ( ! defined('LQD_CORE_VERSION') ){
		get_template_part( 'templates/header/header-title', 'bar' );
	}

}

function liquid_get_footer_view() {

	error_reporting(0);

	if ( liquid_helper()->check_post_types() ) {
		return;
	}

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		$id = liquid_get_custom_footer_id();

		$enable = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'liquid_footer_condition_enable' );

		if ( $enable !== 'on' ){
			return;
		}

		if($id) {
			get_template_part( 'templates/footer/custom' );
			return;
		}
	}

	get_template_part( 'templates/footer/default' );

}

function liquid_custom_sidebars() {

	//adding custom sidebars defined in theme options
	$custom_sidebars = liquid_helper()->get_kit_option( 'liquid_custom_sidebars' );

	if ( !empty( $custom_sidebars ) ) {

		foreach ( $custom_sidebars as $sidebar ) {

				register_sidebar ( array (
					'name'          => $sidebar['title'],
					'id'            => sanitize_title( $sidebar['title'] ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );

		}
	}

}

function liquid_before_comment_form() {
	echo '<div class="row">';
}

function liquid_after_comment_form( $post_id ) {
	echo '</div>';
}

function liquid_move_comment_field_to_bottom( $fields ) {

	$comment_field = $fields['comment'];

	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

function liquid_enable_lazy_load() {

	if( 'on' === liquid_helper()->get_kit_option( 'liquid_lazy_load' ) && !is_admin() ) {
		add_filter( 'wp_get_attachment_image_attributes', 'liquid_filter_gallery_img_atts', 10, 2 );
		add_filter( 'wp_lazy_loading_enabled', '__return_false' ); // romove loading attr
	}

}

function liquid_filter_gallery_img_atts( $atts, $attachment ) {

	$img_data = $atts['src'];
    $aspect_ratio = '';

	// check image exists
	if ( empty($img_data) ){
		return array();
	}

	// check lazy load nth
	$lazy_load_nth = (int)liquid_helper()->get_kit_option( 'liquid_lazy_load_nth' )['size'];

	if ( $lazy_load_nth != 1 ){
		STATIC $lazy_load_counter = 1;

		if ( ( $lazy_load_nth - 1 ) >= $lazy_load_counter ){
			$lazy_load_counter++;
			// check loading attribute
			if ( isset( $atts['loading'] ) ){
				$atts['loading'] ='eager';
			}
			return $atts;
		}

		$lazy_load_counter++;
	}

	// check lazy load excludes
	if ( $lazy_load_exclude = liquid_helper()->get_kit_option( 'liquid_lazy_load_exclude' ) ){
		$excludes = explode( "\n", str_replace("\r", "", $lazy_load_exclude ) );
		if( is_array( $excludes ) ) {
			foreach ( $excludes as $exclude ) {
				if ( false !== strpos( $img_data, $exclude ) ) {
					// check loading attribute
					if ( isset( $atts['loading'] ) ){
						$atts['loading'] ='eager';
					}
					return $atts;
				}
			}
		}
	}

    $filetype = wp_check_filetype( $img_data );

    @list( $width, $height ) = getimagesize( $img_data );
    if( isset( $width ) && isset( $height ) ) {
        $aspect_ratio = $width / $height;
    }

	if( 'svg' === $filetype['ext'] ) {
        return $atts;
    }

    $atts['src'] = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {$width} {$height}'%3E%3C/svg%3E";
    $atts['class'] .= ' ld-lazyload';
    $atts['data-src'] = $img_data;
    if ( isset($atts['srcset']) ) {
        $atts['data-srcset'] = $atts['srcset'];
        unset($atts['srcset']);
    }
    if ( isset($atts['sizes']) ) {
        $atts['data-sizes'] = $atts['sizes'];
        unset($atts['sizes']);
    }
    $atts['data-aspect'] = $aspect_ratio;

    return $atts;

}

function liquid_page_ajaxify( $template ) {

	if( isset( $_GET['ajaxify'] ) && $_GET['ajaxify'] ) {

		if( ! is_archive() ) {
			$located = locate_template( 'ajaxify.php' );
		}

		if( '' != $located ) {
			return $located;
		}
	}

	return $template;

}

function liquid_get_snickers_bar_template() {
	echo '<template id="lqd-temp-snickersbar">
			<div class="lqd-snickersbar flex flex-wrap lqd-snickersbar-in" data-item-id>
				<div class="lqd-snickersbar-inner flex flex-wrap items-center">
					<div class="lqd-snickersbar-detail">
						<p style="display: none;" class="lqd-snickersbar-addding-temp mt-0 mb-0">' . esc_html__( 'Adding {{itemName}} to cart', 'aihub' ) . '</p>
						<p style="display: none;" class="lqd-snickersbar-added-temp mt-0 mb-0">'.  esc_html__( 'Added {{itemName}} to cart', 'aihub' ) . '</p>
						<p class="lqd-snickersbar-msg flex items-center mt-0 mb-0"></p>
						<p class="lqd-snickersbar-msg-done flex items-center mt-0 mb-0"></p>
					</div>
					<div class="lqd-snickersbar-ext ms-24"></div>
				</div>
			</div>
		</template>';
}

function liquid_get_modal_template() {
	echo '<div class="lity" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1" data-modal-type="default" style="display: none;">
		<div class="lity-backdrop"></div>
		<div class="lity-wrap" data-lity-close role="document">
			<div class="lity-loader" aria-hidden="true">Loading...</div>
			<div class="lity-container">
				<div class="lity-content"></div>
			</div>
			<button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>&times;</button>
		</div>
	</div>';
}

function liquid_woocommerce_get_products_list_view_type() {

	// Get current products list view type
	if ( isset( $_GET['view'] ) && in_array( $_GET['view'], array( 'list', 'grid' ) ) ) {
		return $_GET['view'];
	}

}

function liquid_get_product_list_classnames( $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_merge( $classes, $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }

    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'liquid_product_lists_classnames', $classes, $class );
    $classes = array_unique( $classes );

	echo join( ' ', $classes );

}

function liquid_get_product_list_ids( $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_merge( $classes, $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }

    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'liquid_product_lists_ids', $classes, $class );
    $classes = array_unique( $classes );

	if ( ! empty( $classes ) ) {
		echo 'id="' . end($classes ) . '"';
	}

}

function liquid_woo_price_start_container() {
	echo '<p class="lqd-sp-price relative">';
}

function liquid_woo_price_end_container() {
	echo '</p>';
}

function liquid_woo_buttons_start_container() {
	echo '<div class="lqd-sp-btns flex flex-col absolute z-2">';
}

function liquid_woo_buttons_end_container() {
	echo '</div>';
}

if ( ! function_exists( 'liquid_woocommerce_product_styles' ) ) {
	// Add custom classnames to product content
	function liquid_woocommerce_product_styles( $style = '' ) {

		if( empty( $style ) ) {
			$style = liquid_helper()->get_kit_option( 'liquid_wc_archive_product_style' );
		}

		if ( class_exists( 'YITH_WCWL_Frontend' ) ) {
			remove_action( 'woocommerce_before_shop_loop_item', array( 'YITH_WCWL_Frontend', 'print_button' ), 5 );
			remove_action( 'woocommerce_after_shop_loop_item', array( 'YITH_WCWL_Frontend', 'print_button' ), 7 );
			remove_action( 'woocommerce_after_shop_loop_item', array( 'YITH_WCWL_Frontend', 'print_button' ), 15 );
		}

		$view_type = liquid_woocommerce_get_products_list_view_type();
		if( 'list' ==  $view_type ) {
			return;
		}

		if( 'classic' == $style || 'classic-alt' == $style ) {

			if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
				remove_action( 'init', array( YITH_WCQV_Frontend(), 'add_button' ) );
				add_action( 'woocommerce_extra_buttons_item', 'liquid_add_quickview_button', 10 );
			}

			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_extra_buttons_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_extra_buttons_item', 'liquid_get_compare_button', 20 );

			add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 2 );
			add_action( 'woocommerce_shop_loop_item_title', 'liquid_get_product_category', 5 );

 			//add_action( 'woocommerce_shop_loop_item_title', 'liquid_woo_price_start_container', 5 );
 			//add_action( 'woocommerce_shop_loop_item_title', 'liquid_woo_price_end_container', 15 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 99 );

		}
		elseif( 'minimal' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_start_container', 1 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_end_container', 99 );

			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );

		}
		elseif( 'minimal-2' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );

		}
		elseif( 'minimal-hover-shadow' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_start_container', 1 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_end_container', 99 );

			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );

		}
		elseif( 'minimal-hover-shadow-2' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_start_container', 1 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_end_container', 99 );

			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );

		}
		else {
			if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
				remove_action( 'init', array( YITH_WCQV_Frontend(), 'add_button' ) );
				add_action( 'woocommerce_extra_buttons_item', 'liquid_add_quickview_button', 10 );
			}
			add_action( 'woocommerce_extra_buttons_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_extra_buttons_item', 'liquid_get_compare_button', 20 );
		}

	}
}
liquid_woocommerce_product_styles();

function liquid_before_products_shortcode_loop( $atts ) {

	$style = liquid_helper()->get_kit_option( 'liquid_wc_archive_product_style' );

    $GLOBALS[ 'liquid_woocommerce_loop_template' ] = ( isset( $atts[ 'style' ] ) ? $atts[ 'style' ] : $style );
}

function liquid_after_products_shortcode_loop( $atts ) {
    $GLOBALS[ 'liquid_woocommerce_loop_template' ] = '';
}

function liquid_woocommerce_product_loop_start_div( $ob_get_clean ) {
	return '<div class="products row">';
}

function liquid_woocommerce_product_loop_end_div( $ob_get_clean ) {
	return '</div>';
}

function liquid_print_custom_product_layout_css() {

	global $post;

	$sp_custom_layout_enable = get_post_meta( get_the_ID(), 'liquid_product_layout_enable', true );

	if ( $sp_custom_layout_enable === 'on' ) {
		$sp_custom_layout = get_post_meta( get_the_ID(), 'liquid_product_layout', true );
	} elseif ( $sp_custom_layout_enable === '0' || empty( $sp_custom_layout_enable ) ) {
		$sp_custom_layout_enable = liquid_helper()->get_kit_option( 'liquid_wc_custom_layout_enable' );
		$sp_custom_layout = liquid_helper()->get_kit_option( 'liquid_wc_custom_layout' );
	}

}

function liquid_print_woo_cats_page_css() {

	if( class_exists( 'WooCommerce' ) && is_product_category() || class_exists( 'WooCommerce' ) && is_product_taxonomy() ) {
		$term_id = get_queried_object_id();
		$content_id = get_term_meta( $term_id, 'liquid_page_id_content_to_cat' , true );
	}
}

function liquid_get_single_media() {
	if ( !liquid_helper()->check_post_types() ) {
		return get_template_part( 'templates/blog/single/part', 'head' );
	}
}

function liquid_single_post_start_container() {
	$content = get_the_content();
	echo '<div class="lqd-container ms-auto me-auto">';
}

function liquid_single_post_end_container() {
	$content = get_the_content();
	echo '</div>';
}

function liquid_kses_allowed_html( $tags, $context ) {
	switch( $context ) {
		case 'svg':
			$tags = array(
				'svg' => array(
					'class' => true,
					'xmlns' => true,
					'xmlns:xlink' => true,
					'version' => true,
					'width' => true,
					'height' => true,
					'viewbox' => true,
					'aria-hidden' => true,
					'role' => true,
					'focusable' => true,
					'style' => true,
					'fill' => true,
					'stroke' => true,
					'stroke-width' => true,
					'stroke-linecap' => true,
					'stroke-linejoin' => true,
					'stroke-miterlimit' => true,
					'clip-rule' => true,
					'fill-rule' => true,
					'preserveaspectratio' => true,
				),
				'g' => array(
					'clip-path' => true,
				),
				'path' => array(
					'd' => true,
					'fill' => true,
					'stroke' => true,
					'stroke-width' => true,
					'stroke-linecap' => true,
					'stroke-linejoin' => true,
					'stroke-miterlimit' => true,
					'clip-rule' => true,
					'fill-rule' => true,
				),
				'circle' => array(
					'cx' => true,
					'cy' => true,
					'r' => true,
					'fill' => true,
					'stroke' => true,
					'stroke-width' => true,
					'stroke-linecap' => true,
					'stroke-linejoin' => true,
					'stroke-miterlimit' => true,
					'clip-rule' => true,
					'fill-rule' => true,
					'transform' => true,
				),
				'ellipse' => array(
					'cx' => true,
					'cy' => true,
					'rx' => true,
					'ry' => true,
					'transform' => true,
				),
				'rect' => array(
					'cx' => true,
					'cy' => true,
					'rx' => true,
					'ry' => true,
					'x' => true,
					'y' => true,
					'width' => true,
					'height' => true,
				),
				'defs' => array(),
				'clippath' => array(
					'id' => true,
				),
			);
		return $tags;
		case 'span':
			$tags = array(
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'role'        => true,
					'style'       => true,
				),
			);
		return $tags;
		case 'a':
			$tags = array(
				'a' => array(
					'class'       => true,
					'href'        => true,
					'target'      => true,
					'style'       => true,
				),
			);
		return $tags;
		case 'lqd_post':
			$tags = array(
				'a' => array(
					'class' => array(),
					'href'  => array(),
					'rel'   => array(),
					'title' => array(),
					'target' => array(),
				),
				'abbr' => array(
					'title' => array(),
				),
				'b' => array(),
				'br' => array(),
				'blockquote' => array(
					'cite'  => array(),
				),
				'cite' => array(
					'title' => array(),
				),
				'code' => array(),
				'del' => array(
					'datetime' => array(),
					'title' => array(),
				),
				'dd' => array(),
				'div' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'dl' => array(),
				'dt' => array(),
				'em' => array(),
				'h1' => array(
					'class' => array(),
				),
				'h2' => array(
					'class' => array(),
				),
				'h3' => array(
					'class' => array(),
				),
				'h4' => array(
					'class' => array(),
				),
				'h5' => array(
					'class' => array(),
				),
				'h6' => array(
					'class' => array(),
				),
				'i' => array(
					'class' => array(),
					'aria-hidden' => array(),
				),
				'img' => array(
					'alt'    => array(),
					'class'  => array(),
					'height' => array(),
					'src'    => array(),
					'width'  => array(),
				),
				'li' => array(
					'class' => array(),
				),
				'ol' => array(
					'class' => array(),
				),
				'p' => array(
					'class' => array(),
					'style' => array(),
				),
				'q' => array(
					'cite' => array(),
					'title' => array(),
				),
				'span' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'strike' => array(),
				'strong' => array(),
				'ul' => array(
					'class' => array(),
				),
			);
		return $tags;
		case 'lqd_breadcrumb':
			$tags = array(
				'nav' => array(
					'class' => array(),
					'role'  => array(),
					'aria-label' => array(),
					'item-prop' => array(),
				),
				'div' => array(
					'class' => array(),
				),
				'ol' => array(
					'class' => array(),
				),
				'ul' => array(
					'class' => array(),
				),
				'li' => array(
					'class' => array(),
				),
				'a' => array(
					'class' => array(),
					'href'  => array(),
					'rel'   => array(),
					'title' => array(),
					'target' => array(),
				),
			);
		return $tags;
		default:
		return $tags;
	}
}
