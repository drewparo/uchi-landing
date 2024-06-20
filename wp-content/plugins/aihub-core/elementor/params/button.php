<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

defined( 'ABSPATH' ) || die();

function lqd_button_get_states_controls( $widget, $prefix, $part = '', $controls_state = '', $selector = '{{WRAPPER}} .lqd-btn' ) {

	$widget->add_control(
		$prefix . $part . 'color' . $controls_state,
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$selector => 'color: {{VALUE}}'
			]
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => $prefix . $part . 'background' . $controls_state,
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => '{{WRAPPER}} .lqd-btn'
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => $prefix . $part . 'border' . $controls_state,
			'selector' => $selector,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
					'{{SELECTOR}}' => '--lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brc: {{VALUE}};'
				],
				'width' => [
					'selectors' => [
						'{{SELECTOR}}' => '--lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brw: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; --lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brwt: {{TOP}}{{UNIT}}; --lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brwe: {{RIGHT}}{{UNIT}}; --lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brwb: {{BOTTOM}}{{UNIT}}; --lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brws: {{LEFT}}{{UNIT}};'
					],
				],
				'border' => [
					'selectors' => [
						'{{SELECTOR}}' => '--lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brs: {{VALUE}};'
					],
				],
			]
		]
	);

	$border_radius_var = '--lqd-btn-' . ($part === 'icon_' ? 'i-' : '') . 'brr';
	$border_radius_selector = $controls_state === '_normal' ? '{{WRAPPER}} .lqd-btn' : '{{WRAPPER}} .lqd-btn:hover';

	$widget->add_responsive_control(
		$prefix . $part . 'border_radius' . $controls_state,
		[
			'label' => esc_html__( 'Border radius', 'aihub-core' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors' => [
				$border_radius_selector => $border_radius_var . 't: {{TOP}}{{UNIT}}; ' . $border_radius_var . 'e: {{RIGHT}}{{UNIT}}; ' . $border_radius_var . 'b: {{BOTTOM}}{{UNIT}}; ' . $border_radius_var . 's: {{LEFT}}{{UNIT}};',
			],
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => $prefix . $part . 'box_shadow' . $controls_state,
			'selector' => $selector,
		]
	);

}

function lqd_elementor_add_button_controls( $widget, $prefix, $condition = [], $separate_section = true, $part = 'all', $force_enable = false, $button_type = '' ){

	$elementor_doc_selector = '.elementor';

	$dark_selectors = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-btn, {{WRAPPER}}[data-lqd-color-scheme=dark] .lqd-btn, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-btn, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-btn';
	$dark_selectors_hover = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-btn:hover, {{WRAPPER}}[data-lqd-color-scheme=dark] .lqd-btn:hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-btn:hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-btn:hover';
	$dark_icon_selectors = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-btn-icon, {{WRAPPER}}[data-lqd-color-scheme=dark] .lqd-btn-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-btn-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-btn-icon';
	$dark_icon_selectors_hover = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-btn-icon, {{WRAPPER}}[data-lqd-color-scheme=dark] .lqd-btn-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-btn-icon, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-btn-icon';

	$sticky_selectors = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-btn';
	$sticky_selectors_hover = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-btn:hover';
	$sticky_icon_selectors = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-btn-icon';
	$sticky_icon_selectors_hover = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-btn:hover .lqd-btn-icon';

	if ( $part === 'all' || $part === 'general' ):

	if ( $separate_section ) {
		// Button Section
		$widget->start_controls_section(
			'button_section2',
			[
				'label' => __( 'Button', 'aihub-core' ),
				'condition' => $condition
			]
		);
	}

	if ( !$force_enable ) {
		$widget->add_control(
			'show_button',
			[
				'label' => __( 'Show button', 'aihub-core' ),
				'type' => (!empty( $prefix ) ? Controls_Manager::SWITCHER : Controls_Manager::HIDDEN),
				'default' => (!empty( $prefix ) ? '' : 'yes'),
				'separator' => $separate_section ? 'none' : 'before',
				'condition' => $condition
			]
		);
	} else {
		$widget->add_control(
			'show_button',
			[
				'label' => __( 'Show button', 'aihub-core' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'yes',
				'condition' => $condition
			]
		);
	}

	$condition = array_merge(
		[ 'show_button' => 'yes', ],
		$condition
	);

	$widget->add_control(
		$prefix . 'title',
		[
			'label' => __( 'Title', 'aihub-core' ),
			'type' => Controls_Manager::TEXT,
			'default' => __( 'Click here', 'aihub-core' ),
			'placeholder' => __( 'Enter Text', 'aihub-core' ),
			'label_block' => true,
			'dynamic' => [
				'active' => true
			],
			'condition' => $condition
		]
	);

	$align_prefix_class = '';
	$align_selectors = [];

	if ( empty( $prefix ) ){
		$align_prefix_class = 'elementor%s-align-';
	}

	$widget->add_responsive_control(
		$prefix . 'align',
		[
			'label' => __( 'Alignment', 'aihub-core' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'left'    => [
					'title' => __( 'Left', 'aihub-core' ),
					'icon' => 'eicon-text-align-left',
				],
				'center' => [
					'title' => __( 'Center', 'aihub-core' ),
					'icon' => 'eicon-text-align-center',
				],
				'right' => [
					'title' => __( 'Right', 'aihub-core' ),
					'icon' => 'eicon-text-align-right',
				],
				'justify' => [
					'title' => __( 'Justified', 'aihub-core' ),
					'icon' => 'eicon-text-align-justify',
				],
			],
			'prefix_class' => $align_prefix_class,
			'default' => '',
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => 'justify-content: {{VALUE}}'
			],
			'condition' => $condition
		]
	);

	$widget->add_control(
		$prefix . 'link_type',
		[
			'label' => __( 'Link type', 'aihub-core' ),
			'type' => in_array( $button_type, ['modal_', 'submit'] ) ? Controls_Manager::HIDDEN : Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				''  => __( 'Simple Click', 'aihub-core' ),
				'local_scroll' => __( 'Local scroll', 'aihub-core' ),
				'read_more' => __( 'Read more (post link)', 'aihub-core' ),
			],
			'condition' => $condition
		]
	);

	$widget->add_responsive_control(
		$prefix . 'local_scroll_offset',
		[
			'label' => __( 'Offset', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range' => [
				'px' => [
					'min' => -500,
					'max' => 500,
					'step' => 1,
				],
			],
			'condition' => array_merge(
				[
					$prefix . 'link_type' => 'local_scroll',
				],
				$condition
			)
		]
	);

	$widget->add_control(
		$prefix . 'button_link',
		[
			'label' => __( 'Link', 'aihub-core' ),
			'type' => in_array( $button_type, ['modal_', 'submit'] ) ? Controls_Manager::HIDDEN : Controls_Manager::URL,
			'placeholder' => __( 'https://your-link.com', 'aihub-core' ),
			'show_external' => true,
			'dynamic' => [
				'active' => true,
			],
			'default' => [
				'url' => '#',
			],
			'condition' => array_merge(
				[
					$prefix.'link_type!' => 'read_more',
				],
				$condition
			),
		]
	);

	$widget->add_control(
		$prefix . 'selected_icon',
		[
			'label' => esc_html__( 'Icon', 'aihub-core' ),
			'type' => Controls_Manager::ICONS,
			'separator' => 'before',
			'label_block' => false,
			'skin' => 'inline',
			'condition' => $condition
		]
	);

	$widget->add_control(
		$prefix . 'icon_placement',
		[
			'label' => esc_html__( 'Placement', 'aihub-core' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'top' => [
					'title' => esc_html__( 'Top', 'aihub-core' ),
					'icon' => 'eicon-arrow-up',
				],
				'end' => [
					'title' => esc_html__( 'End', 'aihub-core' ),
					'icon' => 'eicon-arrow-right',
				],
				'bottom' => [
					'title' => esc_html__( 'Bottom', 'aihub-core' ),
					'icon' => 'eicon-arrow-down',
				],
				'start' => [
					'title' => esc_html__( 'Start', 'aihub-core' ),
					'icon' => 'eicon-arrow-left',
				],
			],
			'render_type' => 'template',
			'default' => 'end',
			'toggle' => false,
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
				],
				$condition
			),
		]
	);

	endif;

	// Style Section
	if ( $part === 'all' || $part === 'style' ):

	if ( $part === 'all' ){
		$widget->end_controls_section();
	}

	$effects_label = __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' );

	if ( !empty( $prefix ) ) {
		$effects_label = __( 'Button effects', 'aihub-core' );
	}

	$widget->start_controls_section(
		$prefix . 'button_effects',
		[
			'label' => $effects_label,
			'condition' => $condition
		]
	);

	$widget->add_control(
		$prefix . 'button_hover_effect',
		[
			'label' => esc_html__( 'Hover effect', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => esc_html__( 'Default - From Site Settings', 'aihub-core' ),
				'none' => esc_html__( 'None', 'aihub-core' ),
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
			'condition' => $condition
		]
	);

	$widget->add_control(
		$prefix . 'button_hover_effect_custom',
		[
			'label' => __( 'Custom hover effect', 'aihub-core' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'default' => 'yes',
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom'
				],
				$condition
			),
		]
	);

	$widget->start_popover();

	$widget->add_responsive_control(
		$prefix . 'hover_custom_x',
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
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_y',
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
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_scale',
		[
			'label' => __( 'Scale', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-scale: {{SIZE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_skewX',
		[
			'label' => __( 'Skew X', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-skew-x: {{SIZE}}deg'
			],
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_skewY',
		[
			'label' => __( 'Skew Y', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_rotateX',
		[
			'label' => __( 'Rotate X', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_rotateY',
		[
			'label' => __( 'Rotate Y', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_rotateZ',
		[
			'label' => __( 'Rotate Z', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_custom_opacity',
		[
			'label' => __( 'Opacity', 'aihub-core' ),
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
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-hover-opacity: {{SIZE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'button_hover_effect' => 'custom',
					$prefix . 'button_hover_effect_custom' => 'yes'
				],
				$condition
			)
		]
	);

	$widget->end_popover();

	$widget->add_control(
		$prefix . 'button_icon_hover_effect',
		[
			'label' => esc_html__( 'Icon hover effect', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => esc_html__( 'Default - From Site Settings', 'aihub-core' ),
				'none' => esc_html__( 'None', 'aihub-core' ),
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
				],
				$condition
			),
		]
	);

	$widget->add_control(
		$prefix . 'button_icon_hover_effect_custom',
		[
			'label' => __( 'Custom hover effect', 'aihub-core' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'default' => 'yes',
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
				],
				$condition
			),
		]
	);

	$widget->start_popover();

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_x',
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_y',
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_scale',
		[
			'label' => __( 'Scale', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-scale: {{SIZE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_skewX',
		[
			'label' => __( 'Skew X', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_skewY',
		[
			'label' => __( 'Skew Y', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_rotateX',
		[
			'label' => __( 'Rotate X', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_rotateY',
		[
			'label' => __( 'Rotate Y', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_rotateZ',
		[
			'label' => __( 'Rotate Z', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
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
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->add_responsive_control(
		$prefix . 'hover_icon_custom_opacity',
		[
			'label' => __( 'Opacity', 'aihub-core' ),
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
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-icon-hover-opacity: {{SIZE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'selected_icon[value]!' => '',
					$prefix . 'button_icon_hover_effect' => 'custom',
					$prefix . 'button_icon_hover_effect_custom' => 'yes'
				],
				$condition
			),
		]
	);

	$widget->end_popover();

	$widget->add_control(
		$prefix . 'lqd_outline_glow_effect',
		[
			'label' => esc_html__( 'Glow effect style', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => esc_html__( 'None', 'aihub-core' ),
				'effect-1' => esc_html__( 'Effect 1', 'aihub-core' ),
				'effect-2' => esc_html__( 'Effect 2', 'aihub-core' ),
			],
			'default' => '',
			'condition' => $condition
		]
	);

	if ( empty( $prefix ) ){
		$widget->add_control(
			$prefix . 'lqd_adaptive_color',
			[
				'label' => esc_html__( 'Enable adaptive color?', 'aihub-core' ),
				'description' => esc_html__( 'Useful for elements with fixed css position or when inside sticky header. This option make the element chage color dynamically when it is over light or dark sections.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);
	}

	$widget->end_controls_section();

	$widget->start_controls_section(
		$prefix . 'button_style_section',
		[
			'label' => __( 'Button', 'aihub-core' ),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => $part === 'all' ? ['show_button' => 'yes',] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => $prefix . 'typography',
			'label' => __( 'Typography', 'aihub-core' ),
			'selector' => '{{WRAPPER}} .lqd-btn'
		]
	);

	$widget->add_responsive_control(
		$prefix . 'button_dimension',
		[
			'label' => esc_html__( 'Dimension', 'aihub-core' ),
			'type' => 'liquid-linked-dimensions',
			'size_units' => [ 'px', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-w: {{WIDTH}}{{UNIT}}; --lqd-btn-h: {{HEIGHT}}{{UNIT}}; --lqd-btn-justify-content: center;',
			],
		]
	);

	if ( !empty( $prefix ) ) {

		$widget->add_responsive_control(
			$prefix . 'margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-btn' => '--lqd-btn-mt: {{TOP}}{{UNIT}}; --lqd-btn-me: {{RIGHT}}{{UNIT}}; --lqd-btn-mb: {{BOTTOM}}{{UNIT}}; --lqd-btn-ms: {{LEFT}}{{UNIT}};',
				]
			]
		);

	}

	$widget->add_responsive_control(
		$prefix . 'padding',
		[
			'label' => esc_html__( 'Padding', 'aihub-core' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-pt: {{TOP}}{{UNIT}}; --lqd-btn-pe: {{RIGHT}}{{UNIT}}; --lqd-btn-pb: {{BOTTOM}}{{UNIT}}; --lqd-btn-ps: {{LEFT}}{{UNIT}};',
			],
		]
	);

	$widget->start_controls_tabs(
		$prefix . 'style_tabs'
	);

	foreach ( ['normal', 'hover'] as $state ) {

		$selector = '{{WRAPPER}} .lqd-btn';

		if ( $state === 'hover' ) {
			$selector .= ':hover';
		}

		$widget->start_controls_tab(
			$prefix . 'style_' . $state . '_tab',
			[
				'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
			]
		);

		lqd_button_get_states_controls( $widget, $prefix, '', '_' . $state, $selector );

		$widget->end_controls_tab();

	}

	$widget->end_controls_tabs();

	$widget->end_controls_section();

	$widget->start_controls_section(
		$prefix . 'button_icon_style_section',
		[
			'label' => __( 'Button icon', 'aihub-core' ),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_control(
		$prefix . 'button_icon_size',
		[
			'label' => esc_html__( 'Size', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]
	);

	$widget->add_responsive_control(
		$prefix . 'button_icon_dimension',
		[
			'label' => esc_html__( 'Dimension', 'aihub-core' ),
			'type' => 'liquid-linked-dimensions',
			'size_units' => [ 'px', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-i-w: {{WIDTH}}{{UNIT}}; --lqd-btn-i-h: {{HEIGHT}}{{UNIT}}; align-items: center; justify-content: center;',
			],
		]
	);

	$widget->add_responsive_control(
		$prefix . 'button_icon_margin',
		[
			'label' => esc_html__( 'Margin', 'aihub-core' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-i-mt: {{TOP}}{{UNIT}}; --lqd-btn-i-me: {{RIGHT}}{{UNIT}}; --lqd-btn-i-mb: {{BOTTOM}}{{UNIT}}; --lqd-btn-i-ms: {{LEFT}}{{UNIT}};',
			],
		]
	);

	$widget->add_responsive_control(
		$prefix . 'button_icon_padding',
		[
			'label' => esc_html__( 'Padding', 'aihub-core' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-btn-i-pt: {{TOP}}{{UNIT}}; --lqd-btn-i-pe: {{RIGHT}}{{UNIT}}; --lqd-btn-i-pb: {{BOTTOM}}{{UNIT}}; --lqd-btn-i-ps: {{LEFT}}{{UNIT}};',
			],
		]
	);

	$widget->start_controls_tabs(
		$prefix . 'button_icon_style_tabs'
	);

	foreach ( [ 'normal', 'hover' ] as $state ) {

		$selector = '{{WRAPPER}} .lqd-btn-icon';

		if ( $state === 'hover' ) {
			$selector = '{{WRAPPER}} .lqd-btn:hover .lqd-btn-icon';
		}

		$widget->start_controls_tab(
			$prefix . 'button_icon_style_tab_' . $state,
			[
				'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
			]
		);

		lqd_button_get_states_controls( $widget, $prefix, 'icon_', '_' . $state, $selector );

		$widget->end_controls_tab();

	}

	$widget->end_controls_tabs();

	$widget->end_controls_section();

	$widget->start_controls_section(
		$prefix . 'lqd_glow_styles',
		[
			'label' => __( 'Button outline glow styles', 'aihub-core' ),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		$prefix . 'lqd_glow_width',
		[
			'label' => esc_html__( 'Glow width', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-outline-glow-w: {{SIZE}}{{UNIT}};',
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		$prefix . 'lqd_glow_duration',
		[
			'label' => esc_html__( 'Glow duration', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-outline-glow-duration: {{SIZE}}s;',
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		$prefix . 'lqd_glow_color_primary',
		[
			'label' => esc_html__( 'Glow color primary', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-outline-glow-color: {{VALUE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		$prefix . 'lqd_glow_color_secondary',
		[
			'label' => esc_html__( 'Glow color secondary', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				'{{WRAPPER}} .lqd-btn' => '--lqd-outline-glow-color-secondary: {{VALUE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->end_controls_section();

	// Start sticky options
	$widget->start_controls_section(
		'lqd_sticky_' . $prefix . 'style_section',
		[
			'label' => __( 'Button sticky <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">📌<span>', 'aihub-core' ),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => $part === 'all' ? ['show_button' => 'yes',] : $condition
		]
	);

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'style_heading',
		[
			'label' => esc_html__( 'Button', 'aihub-core' ),
			'type' => Controls_Manager::HEADING,
		]
	);

	$widget->start_controls_tabs(
		'lqd_sticky_' . $prefix . 'style_tabs',
	);

	$widget->start_controls_tab(
	   'lqd_sticky_' . $prefix . 'style_tab_normal',
		[
			'label' => esc_html__( 'Normal', 'aihub-core' ),
		]
	);

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'color',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$sticky_selectors => 'color: {{VALUE}}'
			]
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'lqd_sticky_' . $prefix . 'background',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $sticky_selectors
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'border',
			'selector' => $sticky_selectors,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			]
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'box_shadow',
			'selector' => $sticky_selectors,
		]
	);

	$widget->end_controls_tab();

	$widget->start_controls_tab(
	   'lqd_sticky_' . $prefix . 'style_tab_hover',
		[
			'label' => esc_html__( 'Hover', 'aihub-core' ),
		]
	);

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'color_hover',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$sticky_selectors_hover => 'color: {{VALUE}}'
			]
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'lqd_sticky_' . $prefix . 'background_hover',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $sticky_selectors_hover
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'border_hover',
			'selector' => $sticky_selectors_hover,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			]
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'box_shadow_hover',
			'selector' => $sticky_selectors_hover,
		]
	);

	$widget->end_controls_tab();

	$widget->end_controls_tabs();

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'icon_style_heading',
		[
			'label' => esc_html__( 'Button icon', 'aihub-core' ),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->start_controls_tabs(
		'lqd_sticky_' . $prefix . 'icon_style_tabs',
	);

	$widget->start_controls_tab(
	   'lqd_sticky_' . $prefix . 'icon_style_tab_normal',
		[
			'label' => esc_html__( 'Normal', 'aihub-core' ),
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'icon_color',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$sticky_icon_selectors => 'color: {{VALUE}}'
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'lqd_sticky_' . $prefix . 'icon_background',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $sticky_icon_selectors,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'icon_border',
			'selector' => $sticky_icon_selectors,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'icon_box_shadow',
			'selector' => $sticky_icon_selectors,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->end_controls_tab();

	$widget->start_controls_tab(
	   'lqd_sticky_' . $prefix . 'icon_style_tab_hover',
		[
			'label' => esc_html__( 'Hover', 'aihub-core' ),
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'icon_color_hover',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$sticky_icon_selectors_hover => 'color: {{VALUE}}'
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'lqd_sticky_' . $prefix . 'icon_background_hover',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $sticky_icon_selectors_hover,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'icon_border_hover',
			'selector' => $sticky_icon_selectors_hover,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'lqd_sticky_' . $prefix . 'icon_box_shadow_hover',
			'selector' => $sticky_icon_selectors_hover,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->end_controls_tab();

	$widget->end_controls_tabs();

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'glow_style_heading',
		[
			'label' => esc_html__( 'Outline glow', 'aihub-core' ),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'lqd_glow_color_primary',
		[
			'label' => esc_html__( 'Glow color primary', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$sticky_selectors => '--lqd-outline-glow-color: {{VALUE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		'lqd_sticky_' . $prefix . 'lqd_glow_color_secondary',
		[
			'label' => esc_html__( 'Glow color secondary', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$sticky_selectors => '--lqd-outline-glow-color-secondary: {{VALUE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->end_controls_tab();

	$widget->end_controls_tabs();

	$widget->end_controls_section();
	// End sticky options

	// Start dark options
	$widget->start_controls_section(
		'dark_' . $prefix . 'style_section',
		[
			'label' => __( 'Button dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => $part === 'all' ? ['show_button' => 'yes',] : $condition
		]
	);

	$widget->add_control(
		'dark_' . $prefix . 'style_heading',
		[
			'label' => esc_html__( 'Button', 'aihub-core' ),
			'type' => Controls_Manager::HEADING,
		]
	);

	$widget->start_controls_tabs(
		'dark_' . $prefix . 'style_tabs',
	);

	$widget->start_controls_tab(
	   'dark_' . $prefix . 'style_tab_normal',
		[
			'label' => esc_html__( 'Normal', 'aihub-core' ),
		]
	);

	$widget->add_control(
		'dark_' . $prefix . 'color',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$dark_selectors => 'color: {{VALUE}}'
			]
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'dark_' . $prefix . 'background',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $dark_selectors
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'dark_' . $prefix . 'border',
			'selector' => $dark_selectors,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			]
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'dark_' . $prefix . 'box_shadow',
			'selector' => $dark_selectors,
		]
	);

	$widget->end_controls_tab();

	$widget->start_controls_tab(
	   'dark_' . $prefix . 'style_tab_hover',
		[
			'label' => esc_html__( 'Hover', 'aihub-core' ),
		]
	);

	$widget->add_control(
		'dark_' . $prefix . 'color_hover',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$dark_selectors_hover => 'color: {{VALUE}}'
			]
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'dark_' . $prefix . 'background_hover',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $dark_selectors_hover
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'dark_' . $prefix . 'border_hover',
			'selector' => $dark_selectors_hover,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			]
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'dark_' . $prefix . 'box_shadow_hover',
			'selector' => $dark_selectors_hover,
		]
	);

	$widget->end_controls_tab();

	$widget->end_controls_tabs();

	$widget->add_control(
		'dark_' . $prefix . 'icon_style_heading',
		[
			'label' => esc_html__( 'Button icon', 'aihub-core' ),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->start_controls_tabs(
		'dark_' . $prefix . 'icon_style_tabs',
	);

	$widget->start_controls_tab(
	   'dark_' . $prefix . 'icon_style_tab_normal',
		[
			'label' => esc_html__( 'Normal', 'aihub-core' ),
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_control(
		'dark_' . $prefix . 'icon_color',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$dark_icon_selectors => 'color: {{VALUE}}'
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'dark_' . $prefix . 'icon_background',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $dark_icon_selectors,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'dark_' . $prefix . 'icon_border',
			'selector' => $dark_icon_selectors,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'dark_' . $prefix . 'icon_box_shadow',
			'selector' => $dark_icon_selectors,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->end_controls_tab();

	$widget->start_controls_tab(
	   'dark_' . $prefix . 'icon_style_tab_hover',
		[
			'label' => esc_html__( 'Hover', 'aihub-core' ),
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_control(
		'dark_' . $prefix . 'icon_color_hover',
		[
			'label' => __( 'Color', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$dark_icon_selectors_hover => 'color: {{VALUE}}'
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		'liquid-background',
		[
			'name' => 'dark_' . $prefix . 'icon_background_hover',
			'types' => [ 'color', 'particles', 'animated-gradient' ],
			'selector' => $dark_icon_selectors_hover,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'dark_' . $prefix . 'icon_border_hover',
			'selector' => $dark_icon_selectors_hover,
			'fields_options' => [
				'color' => [
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
				],
			],
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'dark_' . $prefix . 'icon_box_shadow_hover',
			'selector' => $dark_icon_selectors_hover,
			'condition' => $part === 'all' ? [ 'show_button' => 'yes', $prefix . 'selected_icon[value]!' => ''] : $condition
		]
	);

	$widget->end_controls_tab();

	$widget->end_controls_tabs();

	$widget->add_control(
		'dark_' . $prefix . 'glow_style_heading',
		[
			'label' => esc_html__( 'Outline glow', 'aihub-core' ),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		'dark_' . $prefix . 'lqd_glow_color_primary',
		[
			'label' => esc_html__( 'Glow color primary', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$dark_selectors => '--lqd-outline-glow-color: {{VALUE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->add_control(
		'dark_' . $prefix . 'lqd_glow_color_secondary',
		[
			'label' => esc_html__( 'Glow color secondary', 'aihub-core' ),
			'type' => 'liquid-color',
			'types' => ['solid'],
			'selectors' => [
				$dark_selectors => '--lqd-outline-glow-color-secondary: {{VALUE}}'
			],
			'condition' => array_merge(
				[
					$prefix . 'lqd_outline_glow_effect!' => ''
				],
				$condition
			)
		]
	);

	$widget->end_controls_tab();

	$widget->end_controls_tabs();

	$widget->end_controls_section();
	// End dark options

	endif;

}

class LQD_Elementor_Render_Button {

	static function get_outline_glow_markup( $widget, $prefix, $settings ) {

		if( !isset( $settings[ $prefix . 'lqd_outline_glow_effect' ] ) ){
			return;
		}

		$glow_effect = $settings[ $prefix . 'lqd_outline_glow_effect' ];

		if ( empty( $glow_effect ) ) return;

		$glow_attrs = [
			'class' => [ 'lqd-outline-glow', 'lqd-outline-glow-' . $glow_effect, 'inline-block', 'rounded-inherit', 'absolute', 'pointer-events-none' ]
		];

		$widget->add_render_attribute( $prefix . 'outline_glow', $glow_attrs );

		?><span <?php $widget->print_render_attribute_string( $prefix . 'outline_glow' ); ?>>
			<span class="lqd-outline-glow-inner inline-block min-w-full min-h-full rounded-inherit aspect-square absolute top-1/2 start-1/2"></span>
		</span><?php

	}

	static function get_icon( $widget, $prefix, $settings ) {

		$icon = $settings[$prefix . 'selected_icon'];

		if ( empty( $icon['value'] ) ) return '';

		$icon_placement = $settings[ $prefix . 'icon_placement' ];
		$icon_classnames = [ 'lqd-btn-icon', 'inline-flex', 'items-center', 'justify-center', 'relative', 'z-1' ];
		$has_hover_bg = !empty( $settings[$prefix.'icon_background_hover_liquid_background_items'] );

		if ( $icon_placement === 'top' || $icon_placement === 'start' ) {
			$icon_classnames[] = '-order-1';
		}

		$icon_attrs = [
			'class' => $icon_classnames
		];

		$widget->add_render_attribute( $prefix . 'button_icon', $icon_attrs );

		?><span <?php $widget->print_render_attribute_string( $prefix . 'button_icon' ); ?>><?php
			if ( !empty( $settings[ $prefix . 'icon_background_normal_liquid_background_items'] ) ) {
				self::get_liquid_background( 'icon_background_normal', false, $widget );
			}
			if ( $has_hover_bg ) : ?>
				<span class="lqd-hover-bg-el lqd-el-visible-on-hover rounded-inherit transition-opacity opacity-0 lqd-group-btn-hover:opacity-100 hidden-if-empty"><?php
					self::get_liquid_background( 'icon_background_hover', false, $widget );
				?></span>
			<?php endif;
			if ( !empty( $settings['lqd_sticky_' . $prefix .  'icon_background_liquid_background_items'] ) || !empty( $settings['lqd_sticky_' . $prefix .  'icon_background_hover_liquid_background_items'] ) ) : ?>
			<span class="lqd-sticky-bg-wrap hidden rounded-inherit lqd-sticky:block hidden-if-empty"><?php
				if ( !empty( $settings['lqd_sticky_' . $prefix .  'icon_background_liquid_background_items'] ) ) {
					self::get_liquid_background( 'lqd_sticky_' . $prefix .  'icon_background', false, $widget );
				}
				if ( !empty( $settings['lqd_sticky_' . $prefix .  'icon_background_hover_liquid_background_items'] ) ) : ?>
				<span class="lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit overflow-hidden opacity-0 transition-opacity lqd-group-btn-hover:opacity-100 hidden-if-empty">
				<?php self::get_liquid_background( 'lqd_sticky_' . $prefix .  'icon_background_hover', false, $widget ); ?>
				</span>
				<?php endif;
			?></span><?php endif;  // end if $lqd_sticky_background
			if ( !empty( $settings['dark_' . $prefix .  'icon_background_liquid_background_items'] ) || !empty( $settings['dark_' . $prefix .  'icon_background_hover_liquid_background_items'] ) ) : ?>
			<span class="lqd-dark-bg-wrap hidden rounded-inherit lqd-dark:block hidden-if-empty"><?php
				if ( !empty( $settings['dark_' . $prefix .  'icon_background_liquid_background_items'] ) ) {
					self::get_liquid_background( 'dark_' . $prefix .  'icon_background', false, $widget );
				}
				if ( !empty( $settings['dark_' . $prefix .  'icon_background_hover_liquid_background_items'] ) ) : ?>
				<span class="lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit overflow-hidden opacity-0 transition-opacity lqd-group-btn-hover:opacity-100">
				<?php self::get_liquid_background( 'dark_' . $prefix .  'icon_background_hover', false, $widget ); ?>
				</span>
				<?php endif;
			?></span><?php endif;  // end if $dark_background
			\LQD_Elementor_Helper::render_icon( $icon, [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		?></span><?php

	}

	static function get_button( $widget, $prefix = '', $settings = '', $button_type = '' ) {

		$settings = !empty( $settings ) ? $settings : $widget->get_settings_for_display();

		if ( $settings['show_button'] !== 'yes' || ( empty( $settings[$prefix . 'title'] ) && empty( [$prefix . 'selected_icon'] ) ) ) return '';

		STATIC $link_attr_id_count = 1;
		$link_attr_id = $prefix . $link_attr_id_count . '_button';
		$icon_placement = $settings[$prefix . 'icon_placement'];
		$buttonTag = 'a';

		$has_bg = !empty( $settings[$prefix.'background_normal_liquid_background_items'] );
		$has_hover_bg = !empty( $settings[$prefix.'background_hover_liquid_background_items'] );

		// check prefix for Posts List Widget
		if ( $prefix == 'ib_' && !isset( $settings[$prefix.'background_normal_liquid_background_items'] ) ) {
			$has_bg = !empty( $widget->get_settings_for_display($prefix.'background_normal_liquid_background_items') );
			$has_hover_bg = !empty( $widget->get_settings_for_display($prefix.'background_hover_liquid_background_items') );
		}

		$button_classnames = [ 'lqd-btn', 'inline-flex', 'items-center', 'relative', 'lqd-group', 'lqd-group-btn' ];

		if ( $icon_placement === 'top' || $icon_placement === 'bottom' ) {
			$button_classnames[] = 'flex-col';
		}

		if ( $has_bg ) {
			$button_classnames[] = 'lqd-btn-has-bg';
		}
		if ( $has_hover_bg ) {
			$button_classnames[] = 'lqd-btn-has-hover-bg';
		}

		$button_attrs = [
			'role' => 'button',
			'class' => $button_classnames,
			'data-lqd-local-scroll-el' => ''
		];
		$title = $settings[$prefix . 'title'];

		if ( $button_type === 'submit' ) {
			$buttonTag = 'button';
			$button_attrs['type'] = 'submit';
		} elseif ( $button_type === 'modal_' ){
			$modal_id = isset($settings['modal']) ? '#modal-' . $settings['modal'] : '#modal-box';
			$button_attrs['data-lity'] = $modal_id;
			$button_attrs['href'] = $modal_id;
		} else {
			if ( $settings[$prefix . 'link_type'] === 'read_more' ){
				$button_attrs['href'] = get_permalink();
			} else {
				if ( !empty( $settings[$prefix . 'button_link']['url'] ) ) {
					$widget->add_link_attributes( $link_attr_id, $settings[$prefix . 'button_link'] );
				}
			}
		}

		$widget->add_render_attribute( $link_attr_id, $button_attrs );

		?>

		<<?php echo $buttonTag; ?> <?php $widget->print_render_attribute_string( $link_attr_id ); ?>><?php
			self::get_outline_glow_markup( $widget, $prefix, $settings );
			if ( $has_hover_bg ) : ?><span class="lqd-bg-el rounded-inherit transition-opacity lqd-group-btn-hover:opacity-0 hidden-if-empty"><?php endif;
			if ( $has_bg ) self::get_liquid_background( 'background_normal', false, $widget );
			if ( $has_hover_bg ) : ?></span><?php endif;
			if ( $has_hover_bg ) : ?><span class="lqd-hover-bg-el lqd-el-visible-on-hover rounded-inherit transition-opacity opacity-0 lqd-group-btn-hover:opacity-100 hidden-if-empty"><?php
				self::get_liquid_background( 'background_hover', false, $widget );
			?></span>
			<?php endif;
			if ( !empty( $settings['lqd_sticky_' . $prefix .  'background_liquid_background_items'] ) || !empty( $settings['lqd_sticky_' . $prefix .  'background_hover_liquid_background_items'] ) ) :
			?><span class="lqd-sticky-bg-wrap hidden rounded-inherit lqd-sticky:block hidden-if-empty"><?php
				if ( !empty( $settings['lqd_sticky_' . $prefix .  'background_liquid_background_items'] ) ) {
					self::get_liquid_background( 'lqd_sticky_' . $prefix .  'background', false, $widget );
				}
				if ( !empty( $settings['lqd_sticky_' . $prefix .  'background_hover_liquid_background_items'] ) ) : ?>
				<span class="lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit overflow-hidden opacity-0 transition-opacity lqd-group-btn-hover:opacity-100">
				<?php self::get_liquid_background( 'lqd_sticky_' . $prefix .  'background_hover', false, $widget ); ?>
				</span>
				<?php endif;
			?></span>
			<?php endif;  // end if $lqd_sticky_background
			if ( !empty( $settings['dark_' . $prefix .  'background_liquid_background_items'] ) || !empty( $settings['dark_' . $prefix .  'background_hover_liquid_background_items'] ) ) : ?>
			<span class="lqd-dark-bg-wrap hidden rounded-inherit lqd-dark:block hidden-if-empty"><?php
				if ( !empty( $settings['dark_' . $prefix .  'background_liquid_background_items'] ) ) {
					self::get_liquid_background( 'dark_' . $prefix .  'background', false, $widget );
				}
				if ( !empty( $settings['dark_' . $prefix .  'background_hover_liquid_background_items'] ) ) : ?>
				<span class="lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit overflow-hidden opacity-0 transition-opacity lqd-group-btn-hover:opacity-100">
				<?php self::get_liquid_background( 'dark_' . $prefix .  'background_hover', false, $widget ); ?>
				</span>
				<?php endif;
			?></span>
			<?php endif;  // end if $dark_background
			if ( !empty( $title ) ) : ?><span class="lqd-btn-txt relative z-1"><?php
				echo wp_kses_post( do_shortcode( $settings[$prefix . 'title'] ) );
			?></span><?php endif;
			self::get_icon( $widget, $prefix, $settings );
		?></<?php echo $buttonTag; ?>>

		<?php

		$link_attr_id_count++;

	}

	protected static function get_liquid_background( $option_name = '', $content_template = false, $prefix = null, $all_absolute = true ) {

		$background = new \LQD_Elementor_Render_Background;
		if ( $content_template ){
			$background->render_template();
		} else {
			$background->render( $prefix, $prefix->get_settings_for_display(), $option_name, $all_absolute );
		}

	}


}