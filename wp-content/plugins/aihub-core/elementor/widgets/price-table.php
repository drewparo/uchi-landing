<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Price_Table extends Widget_Base {

	public function get_name() {
		return 'lqd-price-table';
	}

	public function get_title() {
		return __( 'Liquid Price Table', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-price-table lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'price', 'table' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$period = $settings['period'];

		$behavior = [];

		if ( $settings['dynamic_price'] === 'yes' ) {
			$dynamic_price_list = $settings['dynamic_price_list'];
			$range = [];
			$change_extra = [];

			if ( !empty( $dynamic_price_list ) ) {
				foreach ( $dynamic_price_list as $price_item ) {
					$price_label = $price_item['price_label'];
					$price_value = $price_item['price_value'];
					$price_period = $price_item['price_period'];

					if ( !empty( $price_label ) ) {
						if ( !empty( $price_value ) ) {
							$range["'" . $price_label . "'"] = "'" . $price_value . "'";
						}
						$change_extra[] = [
							'el' => "'.lqd-price-table-period'",
							'key' => "'" . $price_label . "'",
							'value' => !empty( $price_period ) ? "'" . $price_period . "'" : "'" . $period . "'"
						];
					}
				}
			}

			$behavior[] = [
				'behaviorClass' => 'LiquidDynamicRangeBehavior',
				'options' => [
					'range' => $range,
					'el' => "'.lqd-price-table-price-value'",
					'separator' => "'" . $settings['currency_format'] . "'",
					'appendSeparatedTo' => "'.lqd-price-table-price-sup'",
					'hideElsIfNan' => "'.lqd-price-table-currency, .lqd-price-table-price-sup, .lqd-price-table-period'",
					'useLocaleString' =>  $settings['currency_format'] === '.' ? 'true' : 'false',
					'changeExtra' => [ $change_extra ]
				]
			];
		}

		return $behavior;

	}

	protected function register_controls() {

		$elementor_doc_selector = '.elementor';

		$this->start_controls_section(
			'header_section',
			[
				'label' => __( 'Header', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Standard Plan', 'aihub-core' ),
				'placeholder' => esc_html__( 'Plan name', 'aihub-core' ),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact us For Custom Plans tailored to your business.', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your description here', 'aihub-core' ),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title HTML tag', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'use_image_or_icon',
			[
				'label' => esc_html__( 'Use image or icon?', 'aihub-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'none' => [
						'title' => esc_html__( 'None', 'aihub-core' ),
						'icon' => 'eicon-minus-circle-o',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'aihub-core' ),
						'icon' => 'eicon-star-o',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'aihub-core' ),
						'icon' => 'eicon-image',
					],
				],
				'default' => 'none',
				'toggle' => false,
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'use_image_or_icon' => 'icon'
				]
			]
		);

		$this->add_control(
			'selected_icon_size',
			[
				'label' => esc_html__( 'Size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'use_image_or_icon' => 'icon'
				]
			]
		);

		$this->add_control(
			'selected_image',
			[
				'label' => esc_html__( 'Choose Image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'use_image_or_icon' => 'image'
				]
			]
		);

		$this->add_control(
			'selected_image_width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header-icon img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'use_image_or_icon' => 'image'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'price_section',
			[
				'label' => __( 'Pricing', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'price',
			[
				'label' => esc_html__( 'Price', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '29.99', 'aihub-core' ),
				'placeholder' => esc_html__( '29.99', 'aihub-core' ),
				'dynamic' => [
					'active' => true
				],
				'condition' => [
					'dynamic_price' => ''
				]
			]
		);

		$this->add_control(
			'dynamic_price',
			[
				'label' => esc_html__( 'Enable dynamic prices', 'aihub-core' ),
				'description' => esc_html__( 'Controling values with Liquid Dynamic Range widget.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$dynamic_price_repeater = new Repeater();

		$dynamic_price_repeater->add_control(
			'price_label',
			[
				'label' => esc_html__( 'Label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '50k', 'aihub-core' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true
				]
			]
		);

		$dynamic_price_repeater->add_control(
			'price_value',
			[
				'label' => esc_html__( 'Value', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '6.90', 'aihub-core' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true
				]
			]
		);

		$dynamic_price_repeater->add_control(
			'price_period',
			[
				'label' => esc_html__( 'Period', 'aihub-core' ),
				'description' => esc_html__( 'Leave it empty if you want to use the default period option.', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true
				]
			]
		);

		$this->add_control(
			'dynamic_price_list',
			[
				'label' => esc_html__( 'Dynamic prices', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $dynamic_price_repeater->get_controls(),
				'default' => [
					[
						'price_label' => esc_html__( '50k', 'aihub-core' ),
						'price_value' => esc_html__( '6.90', 'aihub-core' ),
					],
					[
						'price_label' => esc_html__( '100k', 'aihub-core' ),
						'price_value' => esc_html__( '9.90', 'aihub-core' ),
					],
					[
						'price_label' => esc_html__( '150k', 'aihub-core' ),
						'price_value' => esc_html__( '12.90', 'aihub-core' ),
					],
					[
						'price_label' => esc_html__( '200k', 'aihub-core' ),
						'price_value' => esc_html__( '15.90', 'aihub-core' ),
					],
					[
						'price_label' => esc_html__( '500k', 'aihub-core' ),
						'price_value' => esc_html__( '19.90', 'aihub-core' ),
					],
				],
				'title_field' => 'Label: {{{ price_label }}}. Value: {{{ price_value }}}',
				'condition' => [
					'dynamic_price' => 'yes'
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'currency',
			[
				'label' => esc_html__( 'Currency Symbol', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'dollar' => '&#36; ' . _x( 'Dollar', 'Currency', 'aihub-core' ),
					'euro' => '&#128; ' . _x( 'Euro', 'Currency', 'aihub-core' ),
					'baht' => '&#3647; ' . _x( 'Baht', 'Currency', 'aihub-core' ),
					'franc' => '&#8355; ' . _x( 'Franc', 'Currency', 'aihub-core' ),
					'guilder' => '&fnof; ' . _x( 'Guilder', 'Currency', 'aihub-core' ),
					'krona' => 'kr ' . _x( 'Krona', 'Currency', 'aihub-core' ),
					'lira' => '&#8356; ' . _x( 'Lira', 'Currency', 'aihub-core' ),
					'peseta' => '&#8359 ' . _x( 'Peseta', 'Currency', 'aihub-core' ),
					'peso' => '&#8369; ' . _x( 'Peso', 'Currency', 'aihub-core' ),
					'pound' => '&#163; ' . _x( 'Pound Sterling', 'Currency', 'aihub-core' ),
					'real' => 'R$ ' . _x( 'Real', 'Currency', 'aihub-core' ),
					'ruble' => '&#8381; ' . _x( 'Ruble', 'Currency', 'aihub-core' ),
					'rupee' => '&#8360; ' . _x( 'Rupee', 'Currency', 'aihub-core' ),
					'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency', 'aihub-core' ),
					'shekel' => '&#8362; ' . _x( 'Shekel', 'Currency', 'aihub-core' ),
					'yen' => '&#165; ' . _x( 'Yen/Yuan', 'Currency', 'aihub-core' ),
					'won' => '&#8361; ' . _x( 'Won', 'Currency', 'aihub-core' ),
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
				],
				'default' => 'dollar',
			]
		);

		$this->add_control(
			'currency_custom',
			[
				'label' => esc_html__( 'Custom Symbol', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'currency' => 'custom',
				],
			]
		);

		$this->add_control(
			'currency_format',
			[
				'label' => esc_html__( 'Currency Format', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '.',
				'options' => [
					'.' => '1,234.56 (Comma)',
					',' => '1.234,56 (Dot)',
				],
			]
		);

		$this->add_control(
			'period',
			[
				'label' => esc_html__( 'Period', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Monthly', 'aihub-core' ),
				'placeholder' => esc_html__( 'Monthly', 'aihub-core' ),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'List item', 'aihub-core' ),
				'default' => esc_html__( 'List item', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'default' => [
					'value' => 'fas fa-check-circle',
					'library' => 'fa-solid',
				]
			]
		);

		$repeater->add_control(
			'opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => esc_html__( 'Icon list', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
				'default' => [
					[
						'text' => esc_html__( 'List item #1', 'aihub-core' ),
						'selected_icon' => [
							'value' => 'fas fa-check-circle',
							'library' => 'fa-solid',
						],
					],
					[
						'text' => esc_html__( 'List item #2', 'aihub-core' ),
						'selected_icon' => [
							'value' => 'fas fa-check-circle',
							'library' => 'fa-solid',
						],
					],
				],
			]
		);

		$this->add_control(
			'content_enable',
			[
				'label' => esc_html__( 'Add additional text?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Type your text here', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your text here', 'aihub-core' ),
				'condition' => [
					'content_enable' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'general_style_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'general_items_gap',
			[
				'label' => esc_html__( 'Gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table' => 'gap: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'general_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'general_style_tabs'
		);

		$this->start_controls_tab(
			'general_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'general_background',
				'selector' => '{{WRAPPER}} .lqd-price-table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'general_border',
				'selector' => '{{WRAPPER}} .lqd-price-table',
			]
		);

		$this->add_responsive_control(
			'general_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'general_box_shadow',
				'selector' => '{{WRAPPER}} .lqd-price-table',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'general_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'general_background_hover',
				'selector' => '{{WRAPPER}} .lqd-price-table:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'general_border_hover',
				'selector' => '{{WRAPPER}} .lqd-price-table:hover',
			]
		);

		$this->add_responsive_control(
			'general_border_radius_hover',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'general_box_shadow_hover',
				'selector' => '{{WRAPPER}} .lqd-price-table:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'add_divider',
			[
				'label' => esc_html__( 'Add divider?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'off', 'aihub-core' ),
				'return_value' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'divider_parts',
			[
				'label' => esc_html__( 'Add divider before parts', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'header'  => esc_html__( 'Header', 'aihub-core' ),
					'price' => esc_html__( 'Price', 'aihub-core' ),
					'content' => esc_html__( 'Content', 'aihub-core' ),
					'footer' => esc_html__( 'Footer', 'aihub-core' ),
				],
				'default' => [ 'price' ],
				'condition' => [
					'add_divider' => 'yes'
				]
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label' => esc_html__( 'Style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid' => esc_html__('Solid', 'aihub-core'),
					'dashed' => esc_html__('Dashed', 'aihub-core'),
					'dotted' => esc_html__('Dotted', 'aihub-core'),
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-divider' => 'border-style: {{VALUE}}; border-color: #eee',
				],
				'condition' => [
					'add_divider' => 'yes'
				]
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 15,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-divider' => 'border-width: {{SIZE}}{{UNIT}} 0 0;',
				],
				'condition' => [
					'add_divider' => 'yes'
				]
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-divider' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'add_divider' => 'yes'
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'header_style_section',
			[
				'label' => __( 'Header', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'header_alignment',
			[
				'label' => esc_html__( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'aihub-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'aihub-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_direction',
			[
				'label' => esc_html__( 'Direction', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Row - horizontal', 'aihub-core' ),
						'icon' => 'eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column - vertical', 'aihub-core' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'column',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header' => 'display: flex; flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_align_items',
			[
				'label' => esc_html__( 'Align items', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-align-start-v',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-align-center-v',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-align-end-v',
					],
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'aihub-core' ),
						'icon' => 'eicon-align-stretch-v',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'header_direction' => 'row'
				],
			]
		);

		$this->add_responsive_control(
			'header_items_gap',
			[
				'label' => esc_html__( 'Gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header' => 'gap: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'header_margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'header_background',
				'types' => [ 'color', 'particles', 'animated-gradient' ],
				'selector' => '{{WRAPPER}} .lqd-price-table-header',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'header_border',
				'selector' => '{{WRAPPER}} .lqd-price-table-header',
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		$this->add_responsive_control(
			'header_roundness',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'header_box_shadow',
				'selector' => '{{WRAPPER}} .lqd-price-table-header',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-title',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' => esc_html__( 'Description Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-description',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Description color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'price_style_section',
			[
				'label' => __( 'Pricing', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'price_background',
				'types' => [ 'color', 'particles', 'animated-gradient' ],
				'selector' => '{{WRAPPER}} .lqd-price-table-price',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'price_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_alignment',
			[
				'label' => esc_html__( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-align-start-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-align-center-h',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-align-end-h',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-price' => 'display: flex; justify-content: {{VALUE}}; align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_direction',
			[
				'label' => esc_html__( 'Direction', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Row - horizontal', 'aihub-core' ),
						'icon' => 'eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column - vertical', 'aihub-core' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'column',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-price' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-values',
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'currency_heading',
			[
				'label' => esc_html__( 'Currency', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'currency!' => ''
				]
			]
		);

		$this->add_control(
			'currency_placement',
			[
				'label' => esc_html__( 'Placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
				'condition' => [
					'currency!' => ''
				]
			]
		);

		$this->add_control(
			'currency_alignment',
			[
				'label' => esc_html__( 'Vertical align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'start',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-currency' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'currency!' => ''
				]
			]
		);

		$this->add_control(
			'currency_opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-currency' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'currency_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-currency',
			]
		);

		$this->add_control(
			'penny_heading',
			[
				'label' => esc_html__( 'Penny', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'penny_alignment',
			[
				'label' => esc_html__( 'Penny vertical align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'start',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-value' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'penny_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-price-sup',
			]
		);

		$this->add_control(
			'penny_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-price-sup' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'penny_opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-price-sup' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->add_control(
			'preiod_heading',
			[
				'label' => esc_html__( 'Period', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'period_alignment',
			[
				'label' => esc_html__( 'Period vertical align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'end',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-period' => 'align-self: {{VALUE}};',
				],
				'condition' => [
					'price_direction' => 'row'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'period_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-period',
			]
		);

		$this->add_control(
			'period_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-period' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'period_opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-period' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'content_background',
				'types' => [ 'color', 'particles', 'animated-gradient' ],
				'selector' => '{{WRAPPER}} .lqd-price-table-content',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label' => esc_html__( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'aihub-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'aihub-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_position',
			[
				'label' => esc_html__( 'Additional text position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-arrow-up',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'bottom',
				'toggle' => false,
				'condition' => [
					'content_enable' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'content_items_gap',
			[
				'label' => esc_html__( 'Gap for text', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-content' => 'gap: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'content_enable' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'iconlist_heading',
			[
				'label' => esc_html__( 'Icon List', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'iconlist_gap',
			[
				'label' => esc_html__( 'List items gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-list li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_items_margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_items_padding',
			[
				'label' => esc_html__( 'Items padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'iconlist_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-iconlist',
			]
		);

		$this->add_control(
			'iconlist_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconlist' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'iconlist_divider',
			[
				'label' => esc_html__( 'Add divider?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-list li:after' => 'content: ""; display:block; width: 100%; height:2px; position:absolute;top:100%;left:0; background: #eee;'
				],
			]
		);

		$this->add_control(
			'iconlist_divider_height',
			[
				'label' => esc_html__( 'Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-list li:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'iconlist_divider' => 'yes'
				]
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'iconlist_divider_background',
				'types' => [ 'color' ],
				'selector' => '{{WRAPPER}} .lqd-price-table-list li:after',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
				'condition' => [
					'iconlist_divider' => 'yes'
				]
			]
		);

		$this->add_control(
			'iconlist_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'iconlist_icon_size',
			[
				'label' => esc_html__( 'Size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconlist-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_padding',
			[
				'label' => esc_html__( 'Dimensions', 'aihub-core' ),
				'type' => 'liquid-linked-dimensions',
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconlist-icon' => 'width: {{WIDTH}}{{UNIT}}; height: {{HEIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'iconlist_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconlist-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'iconlist_icon_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconlist-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'iconlist_icon_background',
				'types' => [ 'color' ],
				'selector' => '{{WRAPPER}} .lqd-iconlist-icon',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'iconlist_icon_border',
				'selector' => '{{WRAPPER}} .lqd-iconlist-icon',
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_roundness',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconlist-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'footer_style_section',
			[
				'label' => __( 'Footer', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'footer_background',
				'types' => [ 'color', 'particles', 'animated-gradient' ],
				'selector' => '{{WRAPPER}} .lqd-price-table-footer',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'footer_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'footer_items_gap',
			[
				'label' => esc_html__( 'Gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-footer' => 'gap: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'footer_alignment',
			[
				'label' => esc_html__( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'aihub-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'aihub-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-footer' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'footer_content_position',
			[
				'label' => esc_html__( 'Footer text position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-arrow-up',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'bottom',
				'toggle' => false,
				'condition' => [
					'footer_content!' => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'footer_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-footer > :not(.lqd-btn)',
			]
		);

		$this->add_control(
			'footer_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-footer > :not(.lqd-btn)' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'footer_section',
			[
				'label' => __( 'Footer', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'footer_content',
			[
				'label' => esc_html__( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Type your text here', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your text here', 'aihub-core' ),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'badge_section',
			[
				'label' => __( 'Badge', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'add_badge',
			[
				'label' => esc_html__( 'Add badge?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label' => esc_html__( 'Badge', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Popular Plan', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your text here', 'aihub-core' ),
				'dynamic' => [
					'active' => true
				],
				'condition' => [
					'add_badge' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_position',
			[
				'label' => esc_html__( 'Button position', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'footer',
				'options' => [
					'footer' => esc_html__( 'Footer', 'aihub-core' ),
					'content' => esc_html__( 'Content', 'aihub-core' ),
					'header' => esc_html__( 'Header', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'button_order',
			[
				'label' => esc_html__( 'Button order', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'default' => 0,
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => 'order: {{VALUE}}; justify-content: center;',
				]
			]
		);

		lqd_elementor_add_button_controls( $this, 'ib_', [], false );


		$this->start_controls_section(
			'badge_style_section',
			[
				'label' => __( 'Badge', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'add_badge' => 'yes'
				]
			]
		);

		$this->add_control(
			'badge_custom_position',
			[
				'label' => esc_html__( 'Custom positioning?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => 'position:absolute;',
				],
			]
		);

		$this->add_control(
			'badge_position_offset_orientation_h',
			[
				'label' => esc_html__( 'Horizontal Orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => 'position:absolute;',
				],
				'condition' => [
					'badge_custom_position' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_offset_x',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '0',
				],
				'size_units' => [ 'px', '%', 'vw', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => '{{badge_position_offset_orientation_h.VALUE}}: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'badge_custom_position' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_position_offset_orientation_v',
			[
				'label' => esc_html__( 'Vertical Orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'top',
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'badge_custom_position' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_offset_y',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%', 'vh', 'vw', 'custom' ],
				'default' => [
					'size' => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => '{{badge_position_offset_orientation_v.VALUE}}: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'badge_custom_position' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'badge_alignment',
			[
				'label' => esc_html__( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-align-start-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-align-center-h',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-align-end-h',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => 'align-self: {{VALUE}};',
				],
				'condition' => [
					'badge_custom_position!' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-price-table-badge',
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'badge_background',
				'types' => [ 'color', 'particles', 'animated-gradient' ],
				'selector' => '{{WRAPPER}} .lqd-price-table-badge',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'badge_border',
				'selector' => '{{WRAPPER}} .lqd-price-table-badge',
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-price-table-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'dark_style_section',
			[
				'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dark_general_style_heading',
			[
				'label' => esc_html__( 'General', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_general_background',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dark_general_border',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table',
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		$this->add_control(
			'dark_divider_style_heading',
			[
				'label' => esc_html__( 'Divider', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'add_divider' => 'yes'
				]
			]
		);

		$this->add_control(
			'dark_divider_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-divider, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-divider, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-divider' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'add_divider' => 'yes'
				]
			]
		);

		$this->add_control(
			'dark_header_style_heading',
			[
				'label' => esc_html__( 'Header', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_header_background',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-header, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-header, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-header',
			]
		);

		$this->add_control(
			'dark_title_color',
			[
				'label' => esc_html__( 'Title color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-title, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-title, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dark_description_color',
			[
				'label' => esc_html__( 'Description color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-description, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-description, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dark_pricing_style_heading',
			[
				'label' => esc_html__( 'Pricing', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_price_background',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-price, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-price, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-price',
			]
		);

		$this->add_control(
			'dark_price_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-price, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-price, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dark_penny_heading',
			[
				'label' => esc_html__( 'Penny', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dark_penny_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-price-sup, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-price-sup, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-price-sup' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dark_preiod_heading',
			[
				'label' => esc_html__( 'Period', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dark_period_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-period, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-period, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-period' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dark_content_style_heading',
			[
				'label' => esc_html__( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_content_background',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-content, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-content, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-content',
			]
		);

		$this->add_control(
			'dark_content_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-content, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-content, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'dark_iconlist_heading',
			[
				'label' => esc_html__( 'Icon List', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'iconlist_divider' => 'yes'
				]
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_iconlist_divider_background',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-list li:after, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-list li:after, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-list li:after',
				'condition' => [
					'iconlist_divider' => 'yes'
				]
			]
		);

		$this->add_control(
			'dark_iconlist_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dark_iconlist_icon_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-iconlist-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-iconlist-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-iconlist-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_iconlist_icon_background',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-iconlist-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-iconlist-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-iconlist-icon',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dark_iconlist_icon_border',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-iconlist-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-iconlist-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-iconlist-icon',
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		$this->add_control(
			'dark_badge_heading',
			[
				'label' => esc_html__( 'Badge', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dark_badge_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-badge, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-badge, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-badge' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_badge_background',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-badge, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-badge, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-badge',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dark_badge_border',
				'selector' => '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-price-table-badge, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-price-table-badge, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-price-table-badge',
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		$this->end_controls_section();

	}

	protected function render_header( $settings ) {

		if ( empty( $settings['title'] ) && empty( $settings['description'] ) ) return;

		?><div class="lqd-price-table-header"><?php

		$this->get_badge();

		if ( $settings['button_position'] === 'header' ) {
			$this->render_button();
		}

		if ( $settings['use_image_or_icon'] !== 'none' )  {

			?><div class="lqd-price-table-header-icon"><?php
			if ( $settings['use_image_or_icon'] === 'icon' ) {
				\LQD_Elementor_Helper::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
			} else {
				echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'selected_image' );
			}
			?></div><?php
		}

		$this->get_divider( 'header' );

		if ( !empty( $settings['title'] ) ) {
			printf(
				'<%1$s class="lqd-price-table-title mt-0 mb-0">%2$s</%1$s>',
				Utils::validate_html_tag( $settings['title_tag'] ),
				esc_html( $settings['title'] )
			);
		}

		if ( !empty( $settings['description'] ) ) {
			printf(
				'<span class="lqd-price-table-description">%1$s</span>',
				esc_html( $settings['description'] )
			);
		}

		?></div><?php

	}

	protected function render_price( $settings ) {

		$dynamic_price_enabled = $settings['dynamic_price'] === 'yes';
		$price = $settings['price'];
		$period = $settings['period'];
		$this->get_divider( 'price' );

		if ( $dynamic_price_enabled ) {
			$first_dynamic_price_item = $settings['dynamic_price_list'][0];
			if ( !empty( $first_dynamic_price_item['price_value'] ) ) {
				$price = $first_dynamic_price_item['price_value'];
			}
			if ( !empty( $first_dynamic_price_item['price_period'] ) ) {
				$period = $first_dynamic_price_item['price_period'];
			}
		}

		?>
		<div class="lqd-price-table-price">
		<div class="lqd-price-table-values text-percent-300 leading-none flex ">
		<?php


		if ( $settings['currency_placement'] === 'left' ){
			$this->get_currency( $settings );
		}

		if ( !empty( $price ) || $price === '0' ) {
			printf(
				'<div class="lqd-price-table-value flex">%s</div>',
				$this->get_price( $price, $settings['currency_format'] )
			);
		}

		if ( $settings['currency_placement'] === 'right' ){
			$this->get_currency( $settings );
		}

		?></div><?php

		if ( !empty( $period ) ) {
			printf(
				'<div class="lqd-price-table-period">%s</div>',
				$period
			);
		}

		?></div><?php

	}

	protected function get_price( $price, $currency_format ) {

		$price = explode( $currency_format, $price);
		$output = '<span class="lqd-price-table-price-value">' . $price[0] . '</span>';

		if ( count( $price ) > 1 ){
			$output .= '<sup class="lqd-price-table-price-sup top-0 text-percent-30">' . $price[1] . '</sup>';
		}

		return $output;

	}

	protected function get_currency( $settings ) {

		if ( !empty( $settings['currency'] ) ) {
			printf(
				'<div class="lqd-price-table-currency flex">%s</div>',
				$settings['currency'] === 'custom' ? $settings['currency_custom'] : $this->get_currency_symbol( $settings['currency'] )
			);
		}

	}

	protected function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar' => '&#36;',
			'euro' => '&#128;',
			'franc' => '&#8355;',
			'pound' => '&#163;',
			'ruble' => '&#8381;',
			'shekel' => '&#8362;',
			'baht' => '&#3647;',
			'yen' => '&#165;',
			'won' => '&#8361;',
			'guilder' => '&fnof;',
			'peso' => '&#8369;',
			'peseta' => '&#8359',
			'lira' => '&#8356;',
			'rupee' => '&#8360;',
			'indian_rupee' => '&#8377;',
			'real' => 'R$',
			'krona' => 'kr',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	protected function render_content_list( $settings ) {

		if ( $settings['icon_list'] ) {
			?><ul class="lqd-price-table-list lqd-iconlist m-0 p-0 relative list-none"><?php
			foreach ( $settings['icon_list'] as $item ) {
				printf( '<li class="lqd-iconlist-item flex items-center relative elementor-repeater-item-%s">', esc_attr( $item['_id'] ) );
				if ( $item['selected_icon'] ){
					?><span class="lqd-iconlist-icon inline-flex items-center justify-center"><?php
					\LQD_Elementor_Helper::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
					?></span><?php
				}
				printf( '<span>%s</span></li>', $item['text'] );
			}
			?></ul><?php
		}

	}

	protected function render_content_text( $settings ) {

		if ( $settings['content_enable'] === 'yes' ) {
			?>
			<div class="lqd-price-table-content-text">
				<?php echo $settings['content']; ?>
			</div>
			<?php
		}

	}

	protected function render_contents( $settings ) {

		if ( !$settings['icon_list'] && !$settings['content_enable'] ) {
			return;
		}

		$this->get_divider( 'content' );

		?><div class="lqd-price-table-content flex flex-col"><?php
			if ( $settings['button_position'] === 'content' ) {
				$this->render_button();
			}
			if ( $settings['content_position'] === 'top' ) {
				$this->render_content_text( $settings );
			}
			$this->render_content_list( $settings );
			if ( $settings['content_position'] === 'bottom' ) {
				$this->render_content_text( $settings );
			}
		?></div><?php

	}

	protected function render_footer( $settings ) {

		if ( empty( $settings['footer_content'] ) && $settings['button_position'] !== 'footer' ){
			return;
		}

		$this->get_divider( 'footer' );

		?><div class="lqd-price-table-footer flex flex-col"><?php

		if ( $settings['footer_content_position'] === 'top' ) {
			printf( '<div class="lqd-price-table-footer-text">%s</div>', $settings['footer_content'] );
		}

		if ( $settings['button_position'] === 'footer' ) {
			$this->render_button();
		}

		if ( $settings['footer_content_position'] === 'bottom' ) {
			printf( '<div class="lqd-price-table-footer-text">%s</div>', $settings['footer_content'] );
		}
		?></div><?php

	}

	protected function get_badge() {

		if ( $this->get_settings_for_display( 'add_badge' ) === 'yes' &&  !empty( $text = $this->get_settings_for_display( 'badge_text' ) )) {
			printf( '<div class="lqd-price-table-badge">%s</div>', $text );
		}

	}

	protected function get_divider( $part ) {
		if ( $this->get_settings_for_display( 'add_divider' ) === 'yes' && !empty( $divider = $this->get_settings_for_display( 'divider_parts' ) ) ) {
			$divider = array_flip($divider);
			if ( isset($divider[$part] ) ) {
				?><div class="lqd-price-table-divider"></div><?php
			}
		}
	}

	protected function render_button() {
		if ( $this->get_settings_for_display('show_button') === 'yes' ) {
			\LQD_Elementor_Render_Button::get_button( $this, 'ib_' );
		}
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>

		<div class="lqd-price-table flex flex-col">
			<?php $this->render_header( $settings ); ?>
			<?php $this->render_price( $settings ); ?>
			<?php $this->render_contents( $settings ); ?>
			<?php $this->render_footer( $settings ); ?>
		</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Price_Table() );