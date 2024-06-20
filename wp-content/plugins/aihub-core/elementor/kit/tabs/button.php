<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Button extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-button-kit';
	}

	public function get_title() {
		return __( 'Liquid button', 'aihub-core' );
	}

	public function get_group() {
		return 'theme-style';
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$border_fileds_options = [
			'border' => [
				'selectors' => [
					'{{SELECTOR}}'  => '--lqd-btn-brs: {{VALUE}};',
				],
			],
			'width' => [
				'selectors' => [
					'{{SELECTOR}}' => '--lqd-btn-brw: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; --lqd-btn-brwt: {{TOP}}{{UNIT}}; --lqd-btn-brwe: {{RIGHT}}{{UNIT}}; --lqd-btn-brwb: {{BOTTOM}}{{UNIT}}; --lqd-btn-brws: {{LEFT}}{{UNIT}};'
				],
			],
			'color' => [
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{SELECTOR}}'  => '--lqd-btn-brc: {{VALUE}};',
				],
			],
		];
		$box_shadow_fields_options = [
			'box_shadow' => [
				'selectors' => [
					'{{SELECTOR}}' => '--lqd-btn-bs: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} {{box_shadow_position.VALUE}};',
				],
			]
		];

		$this->start_controls_section(
			'section_' . $this->get_id() . '_general',
			[
				'label' => esc_html__('Liquid Button', 'aihub-core'),
				'tab' => $this->get_id()
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_button_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-btn',
			]
		);

		$this->add_control(
			'liquid_button_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}}'  => '--lqd-btn-pt: {{TOP}}{{UNIT}}; --lqd-btn-pe: {{RIGHT}}{{UNIT}}; --lqd-btn-pb: {{BOTTOM}}{{UNIT}}; --lqd-btn-ps: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'liquid_button_styles_tabs',
		);

		$this->start_controls_tab(
			'liquid_button_style_tab_normal',
			[
				'label'   => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_button_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-btn-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		   'liquid-background-css',
			[
				'name' => 'liquid_button_bg',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'css_attr' => '--lqd-btn-bg',
				'selector' => '{{WRAPPER}}',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'liquid_button_border',
				'label' => esc_html__( 'Border', 'aihub-core' ),
				'fields_options' => $border_fileds_options,
				'selector' => '{{WRAPPER}}',
			]
		);

		$this->add_control(
			'liquid_button_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}}'  => '--lqd-btn-brrt: {{TOP}}{{UNIT}}; --lqd-btn-brre: {{RIGHT}}{{UNIT}}; --lqd-btn-brrb: {{BOTTOM}}{{UNIT}}; --lqd-btn-brrs: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_button_box_shadow',
				'fields_options' => $box_shadow_fields_options,
				'selector' => '{{WRAPPER}}',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'liquid_button_style_tab_hover',
			[
				'label'   => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_button_color_hover',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn:hover' => '--lqd-btn-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		   'liquid-background-css',
			[
				'name' => 'liquid_button_bg_hover',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'css_attr' => '--lqd-btn-bg',
				'selector' => '{{WRAPPER}} .lqd-btn:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'liquid_button_border_hover',
				'label' => esc_html__( 'Border', 'aihub-core' ),
				'fields_options' => $border_fileds_options,
				'selector' => '{{WRAPPER}} .lqd-btn:hover',
			]
		);

		$this->add_control(
			'liquid_button_border_radius_hover',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn:hover'  => '--lqd-btn-brrt: {{TOP}}{{UNIT}}; --lqd-btn-brre: {{RIGHT}}{{UNIT}}; --lqd-btn-brrb: {{BOTTOM}}{{UNIT}}; --lqd-btn-brrs: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_button_box_shadow_hover',
				'fields_options' => $box_shadow_fields_options,
				'selector' => '{{WRAPPER}} .lqd-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'liquid_button_style_tab_active',
			[
				'label'   => esc_html__( 'Active', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_button_color_active',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn:active, {{WRAPPER}} .lqd-btn.lqd-is-active' => '--lqd-btn-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		   'liquid-background-css',
			[
				'name' => 'liquid_button_bg_active',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'css_attr' => '--lqd-btn-bg',
				'selector' => '{{WRAPPER}} .lqd-btn:active, {{WRAPPER}} .lqd-btn.lqd-is-active',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'liquid_button_border_active',
				'label' => esc_html__( 'Border', 'aihub-core' ),
				'fields_options' => $border_fileds_options,
				'selector' => '{{WRAPPER}} .lqd-btn:active, {{WRAPPER}} .lqd-btn.lqd-is-active',
			]
		);

		$this->add_control(
			'liquid_button_border_radius_active',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn:active, {{WRAPPER}} .lqd-btn.lqd-is-active'  => '--lqd-btn-brr: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'liquid_button_box_shadow_active',
				'fields_options' => $box_shadow_fields_options,
				'selector' => '{{WRAPPER}} .lqd-btn:active, {{WRAPPER}} .lqd-btn.lqd-is-active',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'liquid_button_effects',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
				'tab' => $this->get_id()
			]
		);

		$this->add_control(
			'liquid_button_hover_effect',
			[
				'label' => esc_html__( 'Hover effect', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'rise' => esc_html__( 'Rise', 'aihub-core' ),
					'scale-up' => esc_html__( 'Scale up', 'aihub-core' ),
					'scale-down' => esc_html__( 'Scale down', 'aihub-core' ),
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
				],
				'default' => '',
				'selectors_dictionary' => [
					'rise' => 'translateY(-0.25em)',
					'scale-up' => 'scale(1.1)',
					'scale-down' => 'scale(0.9)',
					'custom' => 'translate(var(--lqd-btn-hover-translate-x, 0),var(--lqd-btn-hover-translate-y, 0)) rotateX(var(--lqd-btn-hover-rotate-x, 0)) rotateY(var(--lqd-btn-hover-rotate-y, 0))  rotateZ(var(--lqd-btn-hover-rotate-z, 0)) skewX(var(--lqd-btn-hover-skew-x, 0)) skewY(var(--lqd-btn-hover-skew-y, 0)) scale(var(--lqd-btn-hover-scale, 1)); opacity: var(--lqd-btn-hover-opacity)',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn:hover' => 'transform: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-translate-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-translate-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_scale',
			[
				'label' => __( 'Scale', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-scale: {{SIZE}}'
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_skewX',
			[
				'label' => __( 'Skew X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-skew-x: {{SIZE}}deg'
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_skewY',
			[
				'label' => __( 'Skew Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-skew-y: {{SIZE}}deg'
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_rotateX',
			[
				'label' => __( 'Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 900px',
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-rotate-x: {{SIZE}}deg',
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_rotateY',
			[
				'label' => __( 'Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 900px',
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-rotate-y: {{SIZE}}deg',
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_rotateZ',
			[
				'label' => __( 'Rotate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-rotate-z: {{SIZE}}deg'
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_custom_opacity',
			[
				'label' => __( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-opacity: {{SIZE}}'
				],
				'condition' => [
					'liquid_button_hover_effect' => 'custom',
				]
			]
		);

		$this->add_control(
			'liquid_button_icon_hover_effect',
			[
				'label' => esc_html__( 'Icon hover effect', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'rise' => esc_html__( 'Rise', 'aihub-core' ),
					'move-right' => esc_html__( 'Move right', 'aihub-core' ),
					'move-left' => esc_html__( 'Move left', 'aihub-core' ),
					'scale-up' => esc_html__( 'Scale up', 'aihub-core' ),
					'scale-down' => esc_html__( 'Scale down', 'aihub-core' ),
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
				],
				'default' => '',
				'selectors_dictionary' => [
					'rise' => 'translateY(-0.25em)',
					'move-right' => 'translateX(0.25em)',
					'move-left' => 'translateX(-0.25em)',
					'scale-up' => 'scale(1.1)',
					'scale-down' => 'scale(0.9)',
					'custom' => 'translate(var(--lqd-btn-icon-hover-translate-x, 0),var(--lqd-btn-icon-hover-translate-y, 0)) rotateX(var(--lqd-btn-icon-hover-rotate-x, 0)) rotateY(var(--lqd-btn-icon-hover-rotate-y, 0))  rotateZ(var(--lqd-btn-icon-hover-rotate-z, 0)) skewX(var(--lqd-btn-icon-hover-skew-x, 0)) skewY(var(--lqd-btn-icon-hover-skew-y, 0)) scale(var(--lqd-btn-icon-hover-scale, 1)); opacity: var(--lqd-btn-icon-hover-opacity)',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn:hover .lqd-btn-icon' => 'transform: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-translate-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-translate-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_scale',
			[
				'label' => __( 'Scale', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-scale: {{SIZE}}'
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_skewX',
			[
				'label' => __( 'Skew X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-skew-x: {{SIZE}}deg'
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_skewY',
			[
				'label' => __( 'Skew Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-skew-y: {{SIZE}}deg'
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_rotateX',
			[
				'label' => __( 'Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 900px',
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-rotate-x: {{SIZE}}deg',
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_rotateY',
			[
				'label' => __( 'Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 900px',
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-rotate-y: {{SIZE}}deg',
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_rotateZ',
			[
				'label' => __( 'Rotate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-rotate-z: {{SIZE}}deg'
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_button_hover_icon_custom_opacity',
			[
				'label' => __( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-opacity: {{SIZE}}'
				],
				'condition' => [
					'liquid_button_icon_hover_effect' => 'custom',
				],
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Button( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-button-kit', Liquid_Button::class );
	}
);