<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

defined( 'ABSPATH' ) || die();

class LQD_Elementor_Trigger{

	protected static function add_trigger_text_controls( $widget, $prefix, $state ) {

		$selector = '{{WRAPPER}} .lqd-trigger-txt';

		if ( $state === 'hover' ) {
			$selector = '{{WRAPPER}} .lqd-trigger:hover .lqd-trigger-txt';
		} else if ( $state === 'active' ) {
			$selector = '{{WRAPPER}} .lqd-trigger.lqd-is-active .lqd-trigger-txt';
		}

		$this->add_control(
			$prefix . 'trigger_text_color' . ( $state === 'normal' ? '' : '_' . $state ),
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$selector => 'color: {{VALUE}}',
				],
			]
		);

	}

	protected static function add_trigger_controls( $widget, $prefix, $state, $is_dark_or_sticky = false ) {

		$selector = '{{WRAPPER}} .lqd-trigger';
		$control_name_prefix = '';

		if ( $state === 'hover' ) {
			$selector .= ':hover';
		} else if ( $state === 'active' ) {
			$selector .= '.lqd-is-active';
		}

		if ( $is_dark_or_sticky === 'dark' ) {
			$control_name_prefix = 'dark_';
			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger:hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger:hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger:hover';
			} else if ( $state === 'active' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger.lqd-is-active, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active';
			}
		} else if ( $is_dark_or_sticky === 'sticky' ) {
			$control_name_prefix = 'lqd_sticky_';
			$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger:hover';
			} else if ( $state === 'active' ) {
				$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active';
			}
		}

		$widget->add_control(
			$control_name_prefix . $prefix . 'trigger_color' . ( $state === 'normal' ? '' : '_' . $state ),
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$selector => 'color: {{VALUE}}',
				],
			]
		);

		$widget->add_group_control(
			'liquid-background-css',
			[
				'name' => $control_name_prefix . $prefix . 'trigger_background' . ( $state === 'normal' ? '' : '_' . $state ),
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $control_name_prefix . $prefix . 'trigger_border' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		if ( !$is_dark_or_sticky ) {
			$widget->add_responsive_control(
				$prefix . 'trigger_border_radius' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( 'Border radius', 'aihub-core' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		}

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $control_name_prefix . $prefix . 'trigger_box_shadow' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
			]
		);

	}

	protected static function add_bars_controls( $widget, $prefix, $state, $is_dark_or_sticky = false ) {

		$selector = '{{WRAPPER}} .lqd-trigger-bar';
		$control_name_prefix = '';
		$defaults = [];

		if ( $state === 'hover' ) {
			$selector = '{{WRAPPER}} .lqd-trigger:hover .lqd-trigger-bar';
		} else if ( $state === 'active' ) {
			$selector = '{{WRAPPER}} .lqd-trigger.lqd-is-active .lqd-trigger-bar';
		}

		if ( $is_dark_or_sticky === 'dark' ) {
			$control_name_prefix = 'dark_';
			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger-bar, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger-bar, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger-bar';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger:hover .lqd-trigger-bar, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger:hover .lqd-trigger-bar, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger:hover .lqd-trigger-bar';
			} else if ( $state === 'active' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger.lqd-is-active .lqd-trigger-bar, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active .lqd-trigger-bar, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active .lqd-trigger-bar';
			}
		} else if ( $is_dark_or_sticky === 'sticky' ) {
			$control_name_prefix = 'lqd_sticky_';
			$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger-bar';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger:hover .lqd-trigger-bar';
			} else if ( $state === 'active' ) {
				$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active .lqd-trigger-bar';
			}
		}

		$widget->add_group_control(
			'liquid-background-css',
			[
				'name' => $control_name_prefix . $prefix . 'bars_background' . ( $state === 'normal' ? '' : '_' . $state ),
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
				'fields_options' => $is_dark_or_sticky === 'dark' ? [] : $defaults
			]
		);

	}

	protected static function add_bars_shape_controls( $widget, $prefix, $state, $is_dark_or_sticky = false ) {

		$selector = '{{WRAPPER}} .lqd-trigger-bars-shape';
		$control_name_prefix = '';

		if ( $state === 'hover' ) {
			$selector = '{{WRAPPER}} .lqd-trigger:hover .lqd-trigger-bars-shape';
		} else if ( $state === 'active' ) {
			$selector = '{{WRAPPER}} .lqd-trigger.lqd-is-active .lqd-trigger-bars-shape';
		}

		if ( $is_dark_or_sticky === 'dark' ) {
			$control_name_prefix = 'dark_';
			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger-bars-shape, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger-bars-shape, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger-bars-shape';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger:hover .lqd-trigger-bars-shape, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger:hover .lqd-trigger-bars-shape, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger:hover .lqd-trigger-bars-shape';
			} else if ( $state === 'active' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-trigger.lqd-is-active .lqd-trigger-bars-shape, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active .lqd-trigger-bars-shape, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active .lqd-trigger-bars-shape';
			}
		} else if ( $is_dark_or_sticky === 'sticky' ) {
			$control_name_prefix = 'lqd_sticky_';
			$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger-bars-shape';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger:hover .lqd-trigger-bars-shape';
			} else if ( $state === 'active' ) {
				$selector = '[data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} .lqd-trigger.lqd-is-active .lqd-trigger-bars-shape';
			}
		}

		$widget->add_group_control(
			'liquid-background-css',
			[
				'name' => $control_name_prefix . $prefix . 'bars_shape_background' . ( $state === 'normal' ? '' : '_' . $state ),
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $control_name_prefix . $prefix . 'bars_shape_border' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ]
					]
				]
			]
		);

		if ( !$is_dark_or_sticky ) {
			$widget->add_responsive_control(
				$prefix . 'bars_shape_border_radius' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( 'Border radius', 'aihub-core' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		}

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $control_name_prefix . $prefix . 'bars_shape_box_shadow' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
			]
		);

	}

	public static function register_controls( $widget, $prefix = '', $conditions = '', $default_text = 'Menu' ) {

		// General Section
		$widget->start_controls_section(
			$prefix . 'trigger_general_section',
			[
				'label' => __( 'Trigger Button', 'aihub-core' ),
				'conditions' => $conditions
			]
		);

		$widget->add_control(
			$prefix . 'trigger_enable',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'yes',
				'conditions' => $conditions
			]
		);

		$widget->add_control(
			$prefix . 'trigger_type',
			[
				'label' => __( 'Type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'none' => [
						'title' => __( 'None', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
					'bars' => [
						'title' => __( 'Bars', 'aihub-core' ),
						'icon' => 'eicon-menu-bar',
					],
					'icon' => [
						'title' => __( 'Icon', 'aihub-core' ),
						'icon' => 'eicon-favorite',
					],
				],
				'default' => 'bars',
				'toggle' => false,
			]
		);

		$widget->add_control(
			$prefix . 'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'condition' => [
					$prefix . 'trigger_type' => 'icon'
				]
			]
		);

		$widget->add_control(
			$prefix . 'bars_count',
			[
				'label' => esc_html__( 'Bars count', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 3,
					],
				],
				'default' => [
					'size' => 2,
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-trigger-bars-count: {{SIZE}}'
				],
				'condition' => [
					$prefix . 'trigger_type' => 'bars'
				]
			]
		);

		$widget->add_control(
			$prefix . 'trigger_text',
			[
				'label' => __( 'Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( $default_text, 'aihub-core' ),
				'placeholder' => __( $default_text, 'aihub-core' ),
				'separator' => 'before'
			]
		);

		$widget->add_control(
			$prefix . 'trigger_text_placement',
			[
				'label' => __( 'Text placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => __( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'end',
				'toggle' => false,
				'condition' => [
					$prefix . 'trigger_text!' => ''
				]
			]
		);

		$widget->add_control(
			$prefix . 'trigger_hide_text',
			[
				'label' => esc_html__( 'Hide text when active?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template'
			]
		);

		$widget->end_controls_section();

		$effects_label = __( 'Trigger effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' );

		$widget->start_controls_section(
			$prefix . 'trigger_effects',
			[
				'label' => $effects_label,
			]
		);

		$widget->add_control(
			$prefix . 'trigger_hover_effect',
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
					'custom' => 'translate(var(--lqd-trigger-hover-translate-x, 0),var(--lqd-trigger-hover-translate-y, 0)) rotateX(var(--lqd-trigger-hover-rotate-x, 0)) rotateY(var(--lqd-trigger-hover-rotate-y, 0))  rotateZ(var(--lqd-trigger-hover-rotate-z, 0)) skewX(var(--lqd-trigger-hover-skew-x, 0)) skewY(var(--lqd-trigger-hover-skew-y, 0)) scale(var(--lqd-trigger-hover-scale, 1)); opacity: var(--lqd-trigger-hover-opacity)',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger:hover' => 'transform: {{VALUE}}',
				],
			]
		);

		$widget->add_control(
			$prefix . 'trigger_hover_effect_custom',
			[
				'label' => __( 'Custom hover effect', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'default' => 'yes',
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-translate-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-translate-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-scale: {{SIZE}}'
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-skew-x: {{SIZE}}deg'
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-skew-y: {{SIZE}}deg'
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-rotate-x: {{SIZE}}deg',
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-rotate-y: {{SIZE}}deg',
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-rotate-z: {{SIZE}}deg'
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
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
					'{{WRAPPER}} .lqd-trigger' => '--lqd-trigger-hover-opacity: {{SIZE}}'
				],
				'condition' => array_merge(
					[
						$prefix . 'trigger_hover_effect' => 'custom',
						$prefix . 'trigger_hover_effect_custom' => 'yes'
					]
				)
			]
		);

		$widget->end_popover();

		$widget->end_controls_section();

		$widget->start_controls_section(
			$prefix . 'trigger_style_section',
			[
				'label' => __( 'Trigger', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => $conditions
			]
		);

		$widget->add_responsive_control(
			$prefix . 'trigger_width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger' => 'width: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'trigger_justify_content',
			[
				'label' => esc_html__( 'Justify content', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'default' => '',
				'options' => [
					'flex-start' => [
						'title' => esc_html_x( 'Start', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-start-h',
					],
					'center' => [
						'title' => esc_html_x( 'Center', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end' => [
						'title' => esc_html_x( 'End', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html_x( 'Space Between', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => esc_html_x( 'Space Around', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly' => [
						'title' => esc_html_x( 'Space Evenly', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					$prefix . 'trigger_width[size]!' => ''
				]
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $prefix . 'trigger_typography',
				'label' => __( 'Typography', 'aihub-core' ),
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_size' => [
						'default' => [
							'size' => '16',
							'unit' => 'px',
						]
					],
				],
				'selector' => '{{WRAPPER}} .lqd-trigger'
			]
		);

		$widget->add_responsive_control(
			$prefix . 'trigger_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->start_controls_tabs(
			$prefix . 'trigger_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				$prefix . 'trigger_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_trigger_controls( $widget, $prefix, $state );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->end_controls_section();

		$bars_conditions = $conditions;

		if ( empty( $bars_conditions ) ) {
			$bars_conditions = [
				'relation' => 'and',
				'terms' => [
					[
						'name' => $prefix . 'trigger_type',
						'operator' => '===',
						'value' => 'bars'
					]
				]
			];
		} else {
			$bars_conditions = array_merge(
				[
					'relation' => 'and',
					'terms' => [
						'name' => $prefix . 'trigger_type',
						'operator' => '===',
						'value' => 'bars'
					]
				],
				$conditions,
			);
		}

		$widget->start_controls_section(
			$prefix . 'bars_style_section',
			[
				'label' => __( 'Trigger bars', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => $bars_conditions
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_height',
			[
				'label' => esc_html__( 'Bars height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-trigger-bar-height: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$widget->add_control(
			$prefix . 'bars_separate_widths',
			[
				'label' => __( 'Separate widths of each bar', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_width',
			[
				'label' => esc_html__( 'Bars width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-trigger-bar-width: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					$prefix . 'bars_separate_widths' => ''
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_width_first',
			[
				'label' => esc_html__( 'First bar width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger-bar-1' => '--lqd-trigger-bar-width: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					$prefix . 'bars_separate_widths' => 'yes'
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_align_first',
			[
				'label' => __( 'First bar align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'Center' => [
						'title' => __( 'center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => __( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'condition' => [
					$prefix . 'bars_separate_widths' => 'yes'
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_width_second',
			[
				'label' => esc_html__( 'Second bar width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger-bar-2' => '--lqd-trigger-bar-width: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					$prefix . 'bars_separate_widths' => 'yes'
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_align_second',
			[
				'label' => __( 'Second bar align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'Center' => [
						'title' => __( 'center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => __( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'condition' => [
					$prefix . 'bars_separate_widths' => 'yes'
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_width_third',
			[
				'label' => esc_html__( 'Third bar width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger-bar-3' => '--lqd-trigger-bar-width: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					$prefix . 'bars_separate_widths' => 'yes',
					$prefix . 'bars_count[size]' => 3
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_align_third',
			[
				'label' => __( 'Third bar align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'Center' => [
						'title' => __( 'center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => __( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'condition' => [
					$prefix . 'bars_separate_widths' => 'yes',
					$prefix . 'bars_count[size]' => 3
				]
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_margin',
			[
				'label' => esc_html__( 'Space beneath each bar', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-trigger-bars-spacing: {{SIZE}}{{UNIT}}'
				],
			]
		);

		$widget->start_controls_tabs(
			$prefix . 'bars_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				$prefix . 'bars_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_bars_controls( $widget, $prefix, $state );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->end_controls_section();

		$icon_conditions = $conditions;

		if ( empty( $icon_conditions ) ) {
			$icon_conditions = [
				'relation' => 'and',
				'terms' => [
					[
						'name' => $prefix . 'trigger_type',
						'operator' => '===',
						'value' => 'icon'
					]
				]
			];
		} else {
			$icon_conditions = array_merge(
				[
					'relation' => 'and',
					'terms' => [
						'name' => $prefix . 'trigger_type',
						'operator' => '===',
						'value' => 'icon'
					]
				],
				$conditions,
			);
		}

		$widget->start_controls_section(
			$prefix . 'icon_style_section',
			[
				'label' => __( 'Trigger icon', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => $icon_conditions
			]
		);

		$widget->add_control(
			$prefix . 'trigger_icon_size',
			[
				'label' => esc_html__( 'Icon size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}}'
				],
			]
		);

		$widget->start_controls_tabs(
			$prefix . 'trigger_icon_styles_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$selector = '{{WRAPPER}} .lqd-trigger-icon';
			$selectors = [];

			if ( $state === 'hover' ) {
				$selector = '{{WRAPPER}} .lqd-trigger:hover .lqd-trigger-icon';
			} else if ( $state === 'active' ) {
				$selector = '{{WRAPPER}} .lqd-trigger.lqd-is-active .lqd-trigger-icon';
			}

			$selectors[$selector] = 'color: {{VALUE}}';

			$widget->start_controls_tab(
				$prefix . 'trigger_icon_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			$widget->add_control(
				$prefix . 'trigger_icon_color' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( 'Color', 'aihub-core' ),
					'type' => 'liquid-color',
					'types' => [ 'solid' ],
					'selectors' => $selectors,
				]
			);

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->end_controls_section();

		$widget->start_controls_section(
			$prefix . 'bars_shape_style_section',
			[
				'label' => __( 'Trigger bars/icon shape', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				$conditions
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_shape_dimension',
			[
				'label' => esc_html__( 'Dimensions', 'aihub-core' ),
				'type' => 'liquid-linked-dimensions',
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'width' => '55',
					'height' => '55',
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger-bars-shape' => 'width: {{WIDTH}}{{UNIT}}; height: {{HEIGHT}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			$prefix . 'bars_shape_margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-trigger-bars-shape' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->start_controls_tabs(
			$prefix . 'bars_shape_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				$prefix . 'bars_shape_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_bars_shape_controls( $widget, $prefix, $state );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->end_controls_section();

		// Start sticky options
		$widget->start_controls_section(
			'lqd_sticky_' . $prefix . 'trigger_section',
			[
				'label' => __( 'Trigger button sticky <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">📌<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => $conditions
			]
		);

		$widget->add_control(
			'lqd_sticky_' . $prefix . 'trigger_heading',
			[
				'label' => esc_html__( 'Trigger', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$widget->start_controls_tabs(
			'lqd_sticky_' . $prefix . 'trigger_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				'lqd_sticky_' . $prefix . 'trigger_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_trigger_controls( $widget, $prefix, $state, 'sticky' );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->add_control(
			'lqd_sticky_' . $prefix . 'trigger_bars_heading',
			[
				'label' => esc_html__( 'Bars', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->start_controls_tabs(
			'lqd_sticky_' . $prefix . 'bars_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				'lqd_sticky_' . $prefix . 'bars_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_bars_controls( $widget, $prefix, $state, 'sticky' );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->add_control(
			'lqd_sticky_' . $prefix . 'trigger_bars_shape_heading',
			[
				'label' => esc_html__( 'Bars shape', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->start_controls_tabs(
			'lqd_sticky_' . $prefix . 'bars_shape_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				'lqd_sticky_' . $prefix . 'bars_shape_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_bars_shape_controls( $widget, $prefix, $state, 'sticky' );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->end_controls_section();
		// End sticky options

		// Start dark options
		$widget->start_controls_section(
			'dark_' . $prefix . 'trigger_section',
			[
				'label' => __( 'Trigger button dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => $conditions
			]
		);

		$widget->add_control(
			'dark_' . $prefix . 'trigger_heading',
			[
				'label' => esc_html__( 'Trigger', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$widget->start_controls_tabs(
			'dark_' . $prefix . 'trigger_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				'dark_' . $prefix . 'trigger_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_trigger_controls( $widget, $prefix, $state, 'dark' );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->add_control(
			'dark_' . $prefix . 'trigger_bars_heading',
			[
				'label' => esc_html__( 'Bars', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->start_controls_tabs(
			'dark_' . $prefix . 'bars_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				'dark_' . $prefix . 'bars_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_bars_controls( $widget, $prefix, $state, 'dark' );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->add_control(
			'dark_' . $prefix . 'trigger_bars_shape_heading',
			[
				'label' => esc_html__( 'Bars shape', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->start_controls_tabs(
			'dark_' . $prefix . 'bars_shape_style_tabs'
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			$widget->start_controls_tab(
				'dark_' . $prefix . 'bars_shape_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
				]
			);

			self::add_bars_shape_controls( $widget, $prefix, $state, 'dark' );

			$widget->end_controls_tab();

		}

		$widget->end_controls_tabs();

		$widget->end_controls_section();
		// End dark options

	}

	protected static function get_icon( $settings, $prefix ) {

		$icon = $settings[ $prefix . 'selected_icon' ];

		if ( empty( $icon['value'] ) ) return '';

		?>
		<span class="lqd-trigger-bars-shape flex items-center justify-center relative pointer-events-none transition-all">
			<span class="flex flex-col relative">
				<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-1 absolute top-1/2 start-1/2 bg-current transition-transform"></span>
				<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-2 absolute top-1/2 start-1/2 bg-current transition-transform"></span>
				<span class="lqd-trigger-bar lqd-trigger-bar-open transition-transform origin-right invisible"></span>
				<span class="lqd-trigger-icon inline-flex items-center justify-center w-full h-full absolute top-0 start-0 transition-all">
					<?php \LQD_Elementor_Helper::render_icon( $icon, [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
				</span>
			</span>
		</span>
		<?php

	}

	protected static function get_bars( $settings, $prefix ) {

		$bars_count = isset($settings[$prefix . 'bars_count']['size']) ? $settings[$prefix . 'bars_count']['size'] : 2;

		?>

		<span class="lqd-trigger-bars-shape flex items-center justify-center relative pointer-events-none transition-all">
			<span class="flex flex-col relative">
				<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-1 absolute top-1/2 start-1/2 bg-current transition-transform"></span>
				<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-2 absolute top-1/2 start-1/2 bg-current transition-transform"></span>
				<?php for ( $i = 1; $i <= $bars_count; $i++ ) : ?>
				<span class="lqd-trigger-bar <?php echo esc_attr__( 'lqd-trigger-bar-' . $i ) ?> lqd-trigger-bar-open bg-current transition-transform origin-right"></span>
				<?php endfor; ?>
			</span>
		</span>

		<?php

	}

	public static function render( $widget, $prefix = '', $attrs = [], $is_active_by_default = false, $is_close_button = false ){

		$settings = $widget->get_settings_for_display();

		if ( !isset($settings[$prefix . 'trigger_enable']) ) return; // if condition not matched, return null.

		if ( !isset( $attrs['class'] ) ) {
			$attrs['class'] = [];
		}
		if ( !isset( $attrs['id'] ) ) {
			$attrs['id'] = '';
		}

		$attrs_id = 'trigger-param-attrs' . $prefix;
		$trigger_classnames = [ 'lqd-trigger', 'lqd-togglable-trigger', 'items-center', 'bg-transparent', 'border-none', 'p-0', 'transition-all' ];
		$hidden_exists_in_class = in_array( 'hidden', $attrs['class'] );
		$trigger_type = $settings[ $prefix . 'trigger_type' ];

		if ( !$hidden_exists_in_class ) {
			$trigger_classnames[] = 'flex';
		}

		if ( $is_active_by_default ) {
			$trigger_classnames[] = 'lqd-is-active';
		}

		if ( $settings[$prefix . 'trigger_hide_text'] === 'yes' ) {
			$trigger_classnames[] = 'lqd-trigger-hide-text-on-active';
		}

		$trigger_classnames = array_merge( $trigger_classnames, $attrs['class'] );

		$render_attributes = [
			'class' => $trigger_classnames,
		];

		if ( isset( $attrs['id'] ) && !empty( $attrs['id'] ) ) {
			$render_attributes['id'] = $attrs['id'];
		}

		$widget->add_render_attribute( $attrs_id, $render_attributes );

		$trigger_text = $settings[$prefix . 'trigger_text'];

		?>

		<button <?php $widget->print_render_attribute_string( $attrs_id ) ?>>
			<?php if ( $is_close_button ) : ?>
				<?php self::get_bars( $settings, $prefix ); ?>
			<?php else : ?>
				<?php if ( !empty($trigger_text) && $settings[$prefix . 'trigger_text_placement'] === 'start' ) { ?>
					<span class="lqd-trigger-text inline-flex overflow-hidden whitespace-nowrap pointer-events-none transition-all"><?php
						echo $trigger_text
					?></span>
				<?php } ?>
				<?php
					if ( $trigger_type === 'bars' ) {
						self::get_bars( $settings, $prefix );
					} else if ( $trigger_type === 'icon' ) {
						self::get_icon( $settings, $prefix );
					};
				?>
				<?php if ( !empty($trigger_text) && $settings[$prefix . 'trigger_text_placement'] === 'end' ) { ?>
					<span class="lqd-trigger-text inline-flex overflow-hidden whitespace-nowrap pointer-events-none transition-all"><?php
						echo $trigger_text
					?></span>
				<?php } ?>
				<?php endif; ?>
		</button>

		<?php
	}

}