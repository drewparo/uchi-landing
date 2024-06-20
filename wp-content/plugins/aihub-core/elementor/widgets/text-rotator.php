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
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Text_Rotator extends Widget_Base {

	public function get_name() {
		return 'lqd-text-rotator';
	}

	public function get_title() {
		return __( 'Liquid Text Rotator', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-animation-text lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'text', 'rotator', 'slide' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();

		$behavior = [];

		$behavior[] = [
			'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
			'options' => [
				'getRect' => true,
				'includeSelf' => true,
				'elementsSelector' => "'.lqd-text-rotator-item'"
			]
		];

		$behavior[] = [
			'behaviorClass' => 'LiquidTextRotatorBehavior',
			'options' => [
				'stayDuration' => $settings[ 'stay_duration' ]['size'] !== '' && $settings[ 'stay_duration' ]['size'] >= 0 ? $settings[ 'stay_duration' ]['size'] : 3,
				'leaveDuration' => $settings[ 'leave_duration' ]['size'] !== '' && $settings[ 'leave_duration' ]['size'] >= 0 ? $settings[ 'leave_duration' ]['size'] : 0.65,
				'enterDuration' => $settings[ 'enter_duration' ]['size'] !== '' && $settings[ 'enter_duration' ]['size'] >= 0 ? $settings[ 'enter_duration' ]['size'] : 0.65,
			]
		];

		if ( !empty( $settings['lqd_text_split_type'] ) ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidSplitTextBehavior',
				'options' => [
					'splitDoneFromBackend' => true,
					'splitType' => "'" . $settings['lqd_text_split_type'] . "'"
				]
			];
		}

		return $behavior;

	}

	protected function register_controls() {

		$elementor_doc_selector = '.elementor';
		$dark_repeater_item_selectors = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} {{CURRENT_ITEM}}';
		$dark_repeater_item_selectors_hover = '[data-lqd-page-color-scheme=dark] {{WRAPPER}}:hover {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}}:hover {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}:hover {{CURRENT_ITEM}}';

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'rotator_item',
			[
				'label' => esc_html__( 'Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'generator', 'aihub-core' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true
				]
			]
		);

		$repeater->add_control(
			'text_individual_styles',
			[
				'label' => esc_html__( 'Individual styling?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$repeater->start_controls_tabs(
			'item_colors_tab',
		);

		$repeater->start_controls_tab(
			'item_color_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'aihub-core' ),
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'item_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'item_color_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'aihub-core' ),
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'item_color_hover',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}}:hover {{CURRENT_ITEM}}' => 'color: {{VALUE}}; transition: color var(--lqd-transition-duration) var(--lqd-transition-timing-function)',
				],
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$repeater->add_control(
			'enable_item_mask',
			[
				'label' => __( 'Mask & gradient', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
				'condition' => [
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->start_popover();

		$repeater->add_control(
			'item_mask_type',
			[
				'label' => esc_html__( 'Mask type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'color' => [
						'title' => esc_html__( 'Color', 'aihub-core' ),
						'icon' => 'eicon-paint-brush',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'aihub-core' ),
						'icon' => 'eicon-image-bold',
					],
				],
				'default' => 'color',
				'condition' => [
					'enable_item_mask' => 'yes',
					'text_individual_styles' => 'yes',
				]
			]
		);

		$repeater->add_control(
			'item_mask_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: {{VALUE}}; -webkit-background-clip: text !important; background-clip: text !important; -webkit-text-fill-color: transparent !important; text-fill-color: transparent !important;'
				],
				'condition' => [
					'enable_item_mask' => 'yes',
					'text_individual_styles' => 'yes',
					'item_mask_type' => 'color'
				]
			]
		);

		$repeater->add_control(
			'item_mask_gradient_parallax',
			[
				'label' => esc_html__( 'Parallax gradient?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'This option only works in desktop and gradient mask.', 'aihub-core' ),
				'selectors' => [
					'(desktop+){{WRAPPER}} {{CURRENT_ITEM}}' => 'background-attachment: fixed'
				],
				'condition' => [
					'enable_item_mask' => 'yes',
					'text_individual_styles' => 'yes',
					'item_mask_type' => 'color'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_mask_image',
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'fields_options' => [
					'background' => [
						'type' => Controls_Manager::HIDDEN,
						'default' => 'classic',
						'selectors' => [
							'{{SELECTOR}}' => '-webkit-background-clip: text !important; background-clip: text !important; -webkit-text-fill-color: transparent !important; text-fill-color: transparent !important;'
						]
					],
					'color' => [
						'type' => Controls_Manager::HIDDEN,
					],
				],
				'condition' => [
					'enable_item_mask' => 'yes',
					'text_individual_styles' => 'yes',
					'item_mask_type' => 'image'
				]
			]
		);

		$repeater->end_popover();

		$repeater->add_responsive_control(
			'position',
			[
				'label' => esc_html__( 'Position', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => ['top', 'left'],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'dark_repeater_text_heading',
			[
				'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->start_controls_tabs(
			'dark_item_colors_tab',
		);

		$repeater->start_controls_tab(
			'dark_item_color_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'aihub-core' ),
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'dark_item_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$dark_repeater_item_selectors => 'color: {{VALUE}}',
				],
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'dark_item_color_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'aihub-core' ),
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'dark_item_color_hover',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$dark_repeater_item_selectors_hover => 'color: {{VALUE}}; transition: color var(--lqd-transition-duration) var(--lqd-transition-timing-function)',
				],
				'condition' => [
					'enable_item_mask' => '',
					'text_individual_styles' => 'yes'
				]
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'text_tag',
			[
				'label' => esc_html__( 'HTML tag', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'p',
			]
		);

		$this->add_control(
			'rotator_items',
			[
				'label' => esc_html__( 'Items', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'rotator_item' => esc_html__( 'Generator', 'aihub-core' ), ],
					[ 'rotator_item' => esc_html__( 'ChatBot', 'aihub-core' ), ],
					[ 'rotator_item' => esc_html__( 'Assistant', 'aihub-core' ), ],
				],
				'title_field' => '{{{ rotator_item }}}',
			]
		);

		$this->add_control(
			'text_before',
			[
				'label' => esc_html__( 'Text before', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Ultimate AI ', 'aihub-core' ),
				'placeholder' => esc_html__( 'Any text to show before the text rotator', 'aihub-core' ),
			]
		);

		$this->add_control(
			'text_after',
			[
				'label' => esc_html__( 'Text after', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Any text to show after the text rotator', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_text_split_type',
			[
				'label' => __( 'Split type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'words' => [
						'title' => __( 'Words', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'block_level_rotator',
			[
				'label' => __( 'Block level rotator?', 'aihub-core' ),
				'description' => __( 'Move the rotator to a new line.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'rotator_whitespace',
			[
				'label' => __( 'Rotator whitespace', 'aihub-core' ),
				'description' => __( 'Useful when rotator items have different widths. Set to Nowrap to avoid breaking words when rotator is chaning.', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'normal'  => [
						'title' => __( 'Normal', 'aihub-core' ),
						'icon' => 'eicon-wrap'
					],
					'nowrap' => [
						'title' => __( 'Nowrap', 'aihub-core' ),
						'icon' => 'eicon-nowrap'
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-text-rotator-items' => 'white-space: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'stay_duration',
			[
				'label' => __( 'Stay duration', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.5,
					],
				],
				'default' => [
					'size' => 3,
				],
				'separator' => 'before',
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'enter_duration',
			[
				'label' => __( 'Enter duration', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.5,
					],
				],
				'default' => [
					'size' => 0.65,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-enter-duration: {{SIZE}}s'
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'leave_duration',
			[
				'label' => __( 'Leave duration', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.5,
					],
				],
				'default' => [
					'size' => 0.65,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-leave-duration: {{SIZE}}s'
				],
			]
		);

		$this->add_control(
			'effect',
			[
				'label'   => esc_html__( 'Effect', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'fade-blur-right'  => esc_html__( 'Fade in from right', 'aihub-core' ),
					'custom'  => esc_html__( 'Build my own effect', 'aihub-core' ),
				],
				'default' => 'fade-blur-right',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'lqd_text_rotator_effect_custom_enter',
			[
				'label' => __( 'Enter from', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'default' => 'yes',
				'condition' => [
					'effect' => 'custom'
				],
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'enter_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
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
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 30,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-enter-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
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
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-enter-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_z',
			[
				'label' => __( 'Translate Z', 'aihub-core' ),
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
					'{{WRAPPER}}' => '--lqd-tr-enter-z: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_scale',
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
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-enter-scale: {{SIZE}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_skewX',
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
					'{{WRAPPER}}' => '--lqd-tr-enter-skewX: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_skewY',
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
					'{{WRAPPER}}' => '--lqd-tr-enter-skewY: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_rotateX',
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
					'{{WRAPPER}}' => '--lqd-tr-enter-rotateX: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_rotateY',
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
					'{{WRAPPER}}' => '--lqd-tr-enter-rotateY: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_rotateZ',
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
					'{{WRAPPER}}' => '--lqd-tr-enter-rotateZ: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_opacity',
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
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-enter-opacity: {{SIZE}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_enter' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'enter_blur',
			[
				'label' => __( 'Blur', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-enter-blur: {{SIZE}}px'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->end_popover();

		$this->add_control(
			'lqd_text_rotator_effect_custom_leave',
			[
				'label' => __( 'Leave to', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'default' => 'yes',
				'condition' => [
					'effect' => 'custom'
				],
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'leave_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
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
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 30,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-leave-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
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
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-leave-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_z',
			[
				'label' => __( 'Translate Z', 'aihub-core' ),
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
					'{{WRAPPER}}' => '--lqd-tr-leave-z: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_scale',
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
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-leave-scale: {{SIZE}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_skewX',
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
					'{{WRAPPER}}' => '--lqd-tr-leave-skewX: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_skewY',
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
					'{{WRAPPER}}' => '--lqd-tr-leave-skewY: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_rotateX',
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
					'{{WRAPPER}}' => '--lqd-tr-leave-rotateX: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_rotateY',
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
					'{{WRAPPER}}' => '--lqd-tr-leave-rotateY: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_rotateZ',
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
					'{{WRAPPER}}' => '--lqd-tr-leave-rotateZ: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_opacity',
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
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-leave-opacity: {{SIZE}}'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'leave_blur',
			[
				'label' => __( 'Blur', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-tr-leave-blur: {{SIZE}}px'
				],
				'condition' => [
					'lqd_text_rotator_effect_custom_leave' => 'yes',
					'effect' => 'custom'
				]
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
			'perspective',
			[
				'label' => __( 'Perspective', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 2000,
						'step' => 10,
					],
				],
				'default' => [
					'size' => 800,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-text-rotator-items' => 'perspective: {{SIZE}}px'
				],
				'condition' => [
					'effect' => 'custom'
				],
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'text-rotator',
			[
				'el' => [
					'label' => 'General',
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'text_rotator_alignment',
								[
									'label' => __( 'Alignment', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'left' => [
											'title' => __( 'Start', 'aihub-core' ),
											'icon' => 'eicon-text-align-left',
										],
										'center' => [
											'title' => __( 'Center', 'aihub-core' ),
											'icon' => 'eicon-text-align-center',
										],
										'right' => [
											'title' => __( 'End', 'aihub-core' ),
											'icon' => 'eicon-text-align-right',
										],
										'justify' => [
											'title' => __( 'Justify', 'aihub-core' ),
											'icon' => 'eicon-text-align-justify',
										],
									],
									'selectors_dictionary' => [
										'left' => 'start',
										'center' => 'center',
										'right' => 'end',
									],
									'selectors' => [
										'{{WRAPPER}}' => 'text-align: {{VALUE}}',
									],
								]
							],
							'tab' => 'none',
							'responsive' => true
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'text_rotator_blend_mode',
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
								]
							],
							'tab' => 'none',
						],
						[
							'type' => 'opacity',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-tr-color'
						],
						[
							'type' => 'text_stroke',
						],
						[
							'type' => 'text_shadow',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ]
				],
				'items' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'opacity',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-tr-item-color'
						],
						[
							'type' => 'text_stroke',
						],
						[
							'type' => 'text_shadow',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
			],
		);

	}

	protected function get_split_content( $content ){

		if ( empty( $content ) ) return;

		$split_type = $this->get_settings_for_display('lqd_text_split_type'); // words - chars,words
		$splitted_text = '';

		if ( $split_type === 'words' ) {
			$words = explode(' ', $content);
			foreach ( $words as $key => $word ) {
				$space = $key > 0 ? '&nbsp;' : '';
				$splitted_text .= sprintf( '%2$s<span class="lqd-split-text-words inline-flex bg-inherit" data-lqd-inner-animatable-el>%1$s</span>', $word, $space );
			}
		} elseif ( $split_type === 'chars,words' ) {
			$words = explode(' ', $content);
			foreach ( $words as $key => $word ) {
				$space = $key > 0 ? '&nbsp;' : '';
				$split_char = str_split( $word );
				$splitted_text .= $space . '<span class="lqd-split-text-words inline-flex bg-inherit">';

				foreach ( $split_char as $char ){
					$splitted_text .= sprintf( '<span class="lqd-split-text-chars inline-flex bg-inherit" data-lqd-inner-animatable-el>%s</span>', $char );
				}

				$splitted_text .= '</span>';
			}
		}

		if ( empty( $splitted_text ) ){
			return $content;
		}

		return $splitted_text;

	}

	protected function get_rotator_items() {
		$settings = $this->get_settings_for_display();
		$items = $settings['rotator_items'];
		$split_type = $settings['lqd_text_split_type'];
		$is_text_rotator_block = $settings['block_level_rotator'] === 'yes';
		$text_rotator_items_attrs = [
			'data-lqd-inner-animatable-el' => 'true',
			'class' => [ 'lqd-text-rotator-items', 'inline-grid', 'transition-all' ],
		];

		if ( !empty( $split_type ) && $split_type === 'words' ) {
			$text_rotator_items_attrs['class'][] = 'lqd-split-text-words';
		}

		$this->add_render_attribute('text-rotator-items', $text_rotator_items_attrs);

		if ( empty( $items ) ) return;

		if ( $is_text_rotator_block ) : ?>
		<span class="block">
		<?php endif;
		?><span <?php $this->print_render_attribute_string( 'text-rotator-items' ) ?>><?php

		foreach( $items as $i => $item ) {
			$item_attrs_id = $this->get_repeater_setting_key( 'rotator_item', 'rotator_items', $i );

			$this->add_render_attribute( $item_attrs_id, [
				'class' => [ 'lqd-text-rotator-item', 'elementor-repeater-item-' . $item['_id'], 'flex', 'grid-area-1-1', 'w-fit', 'relative', $i === 0 ? 'lqd-is-active' : '' ]
			] );

			$item_html = sprintf(
				'<span %1$s>%2$s</span>',
				$this->get_render_attribute_string( $item_attrs_id ),
				$item['rotator_item'],
			);

			echo $item_html;
		}

		?></span><?php
		if ( $is_text_rotator_block ) : ?>
		</span>
		<?php endif;
	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings_for_display();
		$attrs = [
			'data-lqd-text-rotator-initiated' => 'false',
		];

		if ( !empty( $settings['lqd_text_split_type'] ) ) {
			$attrs['data-lqd-has-inner-animatables'] = 'true';
		}

		$this->add_render_attribute('_wrapper', $attrs );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$tag = Utils::validate_html_tag( $settings['text_tag'] );
		$text_before = $settings['text_before'];
		$text_after = $settings['text_after'];

		if ( !empty( $settings['lqd_text_split_type'] ) ) {
			$text_before = $this->get_split_content( $text_before );
			$text_after = $this->get_split_content( $text_after );
		}

		$this->add_render_attribute( 'el', [
			'class' => [ 'lqd-text-rotator-el', 'm-0', 'p-0', 'transition-all' ]
		] );

		?>
			<<?php echo $tag; ?> <?php echo $this->print_render_attribute_string( 'el' ) ?>><?php
				if ( !empty( $text_before ) ) {
					echo $text_before;
				}
				$this->get_rotator_items();
				if ( !empty( $text_after ) ) {
					echo $text_after;
				}
			?></<?php echo $tag ?>>
		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Text_Rotator() );