<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Performance extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-performance-kit';
	}

	public function get_title() {
		return __( 'Performance', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-dashboard';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		/*
		 *
		 * General
		 *
		 */

		 $this->start_controls_section(
			'section_' . $this->get_id() . '_general',
			[
				'label' => esc_html__('General', 'logistics-hub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_script_print_method',
			[
				'label' => esc_html__( 'Script Print Method', 'logistics-hub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => [
					'internal' => esc_html__( 'Internal', 'logistics-hub-core' ),
					'external' => esc_html__( 'External', 'logistics-hub-core' ),
				],
				'default' => 'internal',
			]
		);

		$this->add_control(
			'liquid_script_print_method_description',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf(
					'<strong>%s: </strong>%s<br><br><strong>%s: </strong>%s',
					esc_html__( 'Internal', 'logistics-hub-core' ),
					esc_html__( 'Load theme scripts as embedded inline. Recommended for low spec servers and development environments.', 'logistics-hub-core' ),
					esc_html__( 'External', 'logistics-hub-core' ),
					esc_html__( 'Load theme scripts from an external file. Recommended for high spec servers and production environments.', 'logistics-hub-core' ),
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * CSS
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_css',
			[
				'label' => esc_html__('CSS', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_disable_css',
			[
				'label' => esc_html__( 'Disable styles', 'aihub-core' ),
				'description' => esc_html__( 'Selected styles will be removed from all pages.', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => [
					'wp-block-library' => esc_html__( 'Gutenberg Library', 'aihub-core' ),
					'wp-block-library-theme' => esc_html__( 'Gutenberg Library Theme', 'aihub-core' ),
					'wc-block-style' => esc_html__( 'Gutenberg Woocommerce', 'aihub-core' ),
					'wc-blocks-vendors-style' => esc_html__( 'Gutenberg Woocommerce Vendors', 'aihub-core' ),
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * JS
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_js',
			[
				'label' => esc_html__('JS', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_jquery_rearrange',
			[
				'label' => esc_html__( 'Load jQuery in Footer', 'aihub-core' ),
				'description' => esc_html__( 'Load all jQuery libraries in the footer. This can reduce the boot time of your site but may prevent some 3rd party plugins from working.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'off',
			]
		);

		$this->add_control(
			'liquid_disable_carousel_on_mobile',
			[
				'label' => esc_html__( 'Disable Carousel on Mobile', 'aihub-core' ),
				'description' => esc_html__( 'Disable JavaScript carousel functionality on mobile. But still carousels will be draggable.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'off',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_disable_animations_on_mobile',
			[
				'label' => esc_html__( 'Disable Liquid Animations on Mobile', 'aihub-core' ),
				'description' => esc_html__( 'Disable Custom Aimations for better performance and page scores for mobile.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'off',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * Fonts & Icon
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_fonts_and_icon',
			[
				'label' => esc_html__('Fonts & Icon', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_load_fonts_locally',
			[
				'label' => esc_html__( 'Load Google Fonts on Locally', 'aihub-core' ),
				'description' => esc_html__( 'This option allows Google Fonts to be loaded through your website, which can be useful for some GDPR situations.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
			]
		);

		$this->add_control(
			'liquid_google_font_display',
			[
				'label' => esc_html__( 'Google Fonts Load', 'aihub-core' ),
				'description' => esc_html__( 'Font-display property defines how font files are loaded and displayed by the browser. Set the way Google Fonts are being loaded by selecting the font-display property.', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'swap',
				'options' => [
					'auto' => esc_html__('Auto - Default', 'aihub-core'),
					'block' => esc_html__('Block', 'aihub-core'),
					'swap' => esc_html__('Swap', 'aihub-core'),
					'fallback' => esc_html__('Fallback', 'aihub-core'),
					'optional' => esc_html__('Optional', 'aihub-core'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_custom_fonts_display',
			[
				'label' => esc_html__( 'Custom Fonts Load', 'aihub-core' ),
				'description' => esc_html__( 'Font-display property defines how font files are loaded and displayed by the browser. Set the way Font Icons are being loaded by selecting the font-display property.', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'swap',
				'options' => [
					'auto' => esc_html__('Auto - Default', 'aihub-core'),
					'block' => esc_html__('Block', 'aihub-core'),
					'swap' => esc_html__('Swap', 'aihub-core'),
					'fallback' => esc_html__('Fallback', 'aihub-core'),
					'optional' => esc_html__('Optional', 'aihub-core'),
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * Lazy Load
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_lazyload',
			[
				'label' => esc_html__('Lazy Load', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_lazy_load',
			[
				'label' => esc_html__( 'Lazy Load', 'aihub-core' ),
				'description' => esc_html__( 'Lazy load enables images to load only when they are in the viewport. Therefore, lazy load boosts the performance.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'liquid_lazy_load_offset',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'description' => esc_html__( 'Lazy Load vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'condition' => [
					'liquid_lazy_load' => 'on',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_lazy_load_nth',
			[
				'label' => esc_html__( 'Lazy Load from nth image', 'aihub-core' ),
				'description' => esc_html__( 'Don\'t Lazy Load the first X image. When you set 1, the lazy load will apply all images', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'condition' => [
					'liquid_lazy_load' => 'on',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_lazy_load_exclude',
			[
				'label' => esc_html__( 'Exclude custom images', 'aihub-core' ),
				'description' => esc_html__( 'Enter the image url for each line you want to disable lazy load', 'aihub-core' ),
				'placeholder' => esc_html__( 'enter the image url for each', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'condition' => [
					'liquid_lazy_load' => 'on',
				],
				'separator' => 'before',
			]
		);


		$this->end_controls_section();

		/*
		 *
		 * Plugins
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_plugins',
			[
				'label' => esc_html__('Plugins', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_disable_wp_emojis',
			[
				'label' => esc_html__( 'WP Emojis', 'aihub-core' ),
				'description' => esc_html__( 'Just disable this. Who in this world uses Wordpress emojis? :-) Ugh', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'on' => [
						'title' => esc_html__( 'Load', 'aihub-core' ),
						'icon' => 'eicon-upload',
					],
					'off' => [
						'title' => esc_html__( 'Do not Load', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'on',
				'toggle' => false,
			]
		);

		$this->add_control(
			'liquid_disable_cf7_js',
			[
				'label' => esc_html__( 'Contact Form 7 JS', 'aihub-core' ),
				'description' => esc_html__( 'Disabling this can prevent AJAX form validation and AJAX form submits.', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'on' => [
						'title' => esc_html__( 'Load', 'aihub-core' ),
						'icon' => 'eicon-upload',
					],
					'off' => [
						'title' => esc_html__( 'Do not Load', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'on',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_disable_cf7_css',
			[
				'label' => esc_html__( 'Contact Form 7 CSS', 'aihub-core' ),
				'description' => esc_html__( 'Contact Form 7 default styles.', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'on' => [
						'title' => esc_html__( 'Load', 'aihub-core' ),
						'icon' => 'eicon-upload',
					],
					'off' => [
						'title' => esc_html__( 'Do not Load', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'on',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		if ( class_exists( 'WooCommerce' ) ){
			$this->add_control(
				'liquid_disable_wc_cart_fragments',
				[
					'label' => esc_html__( 'Woocommerce Cart Fragments JS', 'aihub-core' ),
					'description' => esc_html__( 'This controls updating cart usinig AJAX without refreshing page.', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'on' => [
							'title' => esc_html__( 'Load', 'aihub-core' ),
							'icon' => 'eicon-upload',
						],
						'off' => [
							'title' => esc_html__( 'Do not Load', 'aihub-core' ),
							'icon' => 'eicon-ban',
						],
					],
					'default' => 'on',
					'toggle' => false,
					'separator' => 'before',
				]
			);
		}

		$this->add_control(
			'liquid_elementor_animations_css',
			[
				'label' => esc_html__( 'Elementor animations CSS file', 'aihub-core' ),
				'description' => esc_html__( 'Disable this if you don\'t use Elementor  animations. This won\'t affect Liquid Custom Animations.', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'on' => [
						'title' => esc_html__( 'Load', 'aihub-core' ),
						'icon' => 'eicon-upload',
					],
					'off' => [
						'title' => esc_html__( 'Do not Load', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'on',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_elementor_icons_css',
			[
				'label' => esc_html__( 'Elementor icons CSS file', 'aihub-core' ),
				'description' => esc_html__( 'Control whether you want to load Elementor "eicons" or not.', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'on' => [
						'title' => esc_html__( 'Load', 'aihub-core' ),
						'icon' => 'eicon-upload',
					],
					'off' => [
						'title' => esc_html__( 'Do not Load', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'on',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_elementor_dialog_js',
			[
				'label' => esc_html__( 'Elementor dialog.js library', 'aihub-core' ),
				'description' => esc_html__( 'If you don\'t use Elementor popups, disable this JavaScript file.', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'on' => [
						'title' => esc_html__( 'Load', 'aihub-core' ),
						'icon' => 'eicon-upload',
					],
					'off' => [
						'title' => esc_html__( 'Do not Load', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'on',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_elementor_frontend_js',
			[
				'label' => esc_html__( 'Elementor frontend.js', 'aihub-core' ),
				'description' => esc_html__( 'This file controls some features like background slideshow, kenburns, elementor carousels, video background etc. Disabling this may break some Elementor featues.', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'on' => [
						'title' => esc_html__( 'Load', 'aihub-core' ),
						'icon' => 'eicon-upload',
					],
					'off' => [
						'title' => esc_html__( 'Do not Load', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'on',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_Performance( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-performance-kit', Liquid_Global_Performance::class );
	}
);
