<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;

function lqd_elementor_add_additional_animation_controls( $widget ){

	// Additional animation controls (short_name: aa)
	$widget->add_control(
		'lqd_aa_hr',
		[
			'type' => Controls_Manager::DIVIDER,
		]
	);

	$widget->add_control(
		'lqd_aa_heading',
		[
			'label' => esc_html__( 'Additional Options', 'aihub-core' ),
			'type' => Controls_Manager::HEADING,
		]
	);

	$widget->add_control(
		'lqd_aa_opacity',
		[
			'label' => esc_html__( 'Opacity', 'aihub-core' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => esc_html__( 'Default', 'aihub-core' ),
			'label_on' => esc_html__( 'Custom', 'aihub-core' ),
			'return_value' => 'yes',
		]
	);

	$widget->start_popover();

	$widget->add_responsive_control(
		'lqd_aa_opacity_normal',
		[
			'label' => esc_html__( 'Normal', 'aihub-core' ),
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
				'{{WRAPPER}}.e-con, {{WRAPPER}} > .elementor-widget-container' => 'opacity: {{SIZE}};',
			],
			'condition' => [
				'lqd_aa_opacity' => 'yes'
			]
		]
	);

	$widget->add_responsive_control(
		'lqd_aa_opacity_hover',
		[
			'label' => esc_html__( 'Hover', 'aihub-core' ),
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
				'{{WRAPPER}}.e-con:hover, {{WRAPPER}}:hover > .elementor-widget-container' => 'opacity: {{SIZE}};',
			],
			'condition' => [
				'lqd_aa_opacity' => 'yes'
			]
		]
	);

	$widget->add_control(
		'lqd_aa_opacity_transition',
		[
			'label' => esc_html__( 'Transition (s)', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 3,
					'step' => 0.1,
				],
			],
			'selectors' => [
				'{{WRAPPER}}.e-con, {{WRAPPER}} > .elementor-widget-container' => 'transition:opacity {{SIZE}}s;',
			],
			'condition' => [
				'lqd_aa_opacity' => 'yes'
			]
		]
	);

	$widget->end_popover();

	$widget->add_group_control(
		Group_Control_Css_Filter::get_type(),
		[
			'name' => 'lqd_aa_css_filters',
			'selector' => '{{WRAPPER}}',
		]
	);

	$widget->add_group_control(
		Group_Control_Css_Filter::get_type(),
		[
			'name' => 'lqd_aa_css_backdrop_filters',
			'selector' => '{{WRAPPER}}.e-con, {{WRAPPER}} > .elementor-widget-container',
			'label' => esc_html__( 'CSS Backdrop Filters', 'aihub-core' ),
			'fields_options' => [
				'blur' => [
					'selectors' => [
						'{{SELECTOR}}' => '-webkit-backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg );backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg )',
					],
				]
			],
		]
	);

	$widget->add_control(
		'lqd_aa_gradient_mask',
		[
			'label' => esc_html__( 'Gradient mask', 'aihub-core' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
		]
	);

	$widget->start_popover();

	$widget->add_control(
		'lqd_aa_gradient_mask_color',
		[
			'label' => esc_html__( 'Mask', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => [ 'linear-gradient', 'repeating-linear-gradient', 'radial-gradient', 'repeating-radial-gradient', 'conic-gradient', 'repeating-conic-gradient' ],
			'default' => 'linear-gradient(0deg, #000000 0%, rgba(0,0,0,0) 100%)',
			'selectors' => [
				'{{WRAPPER}}' => '-webkit-mask-image: {{VALUE}}; mask-image: {{VALUE}}'
			],
			'condition' => [
				'lqd_aa_gradient_mask' => 'yes',
			]
		]
	);

	$widget->add_control(
		'lqd_aa_gradient_mask_color_info',
		[
			'type' => Controls_Manager::RAW_HTML,
			'content_classes' => 'elementor-panel-alert',
			'raw' => esc_html__( 'Use black color for opaque parts and transparent for transparent parts.', 'aihub-core' ),
			'condition' => [
				'lqd_aa_gradient_mask' => 'yes',
			]
		]
	);

	$widget->add_control(
		'lqd_aa_gradient_mask_color_alert',
		[
			'type' => Controls_Manager::RAW_HTML,
			'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			'raw' => esc_html__( 'This option will make the elements overflow hidden.', 'aihub-core' ),
			'condition' => [
				'lqd_aa_gradient_mask' => 'yes',
			]
		]
	);

	$widget->end_popover();

	$widget->add_control(
		'blend_mode',
		[
			'label' => esc_html__( 'Blend mode', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => esc_html__( 'Normal', 'aihub-core' ),
				'multiply' => 'Multiply',
				'screen' => 'Screen',
				'overlay' => 'Overlay',
				'darken' => 'Darken',
				'lighten' => 'Lighten',
				'color-dodge' => 'Color Dodge',
				'hard-light' => 'Hard light',
				'saturation' => 'Saturation',
				'color' => 'Color',
				'difference' => 'Difference',
				'exclusion' => 'Exclusion',
				'hue' => 'Hue',
				'luminosity' => 'Luminosity',
			],
			'selectors' => [
				'{{WRAPPER}}' => 'mix-blend-mode: {{VALUE}}',
			],
			'separator' => 'before'
		]
	);

	$widget->add_responsive_control(
		'lqd_aa_perspective',
		[
			'label' => esc_html__( 'Perspective', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 2000,
					'step' => 10,
				],
			],
			'selectors' => [
				'{{WRAPPER}}, {{WRAPPER}} > .e-con-inner' => 'perspective: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'before'
		]
	);

}