<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Typewriter extends Widget_Base {

	// public function __construct($data = [], $args = null) {
	// 	parent::__construct($data, $args);

	// 	wp_register_script( 'typewriter-effect',
	// 		get_template_directory_uri() . '/assets/vendors/typewriter-effect/typewriter-effect.js',
	// 		[ 'jquery' ],
	// 		LQD_CORE_VERSION,
	// 		true
	// 	);
	// }

	public function get_name() {
		return 'lqd-typewriter';
	}

	public function get_title() {
		return __( 'Liquid Typewriter', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-animation-text lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'typewriter', 'text', 'animated' ];
	}

	public function get_script_depends() {
		return [ 'typewriter-effect' ];
	}

	public function get_behavior() {
		$settings = $this->get_settings_for_display();
		$delay = $settings[ 'tw_delay' ];
		$deleteSpeed = $settings[ 'tw_deleteSpeed' ];
		$loop = $settings[ 'tw_loop' ];
		$contents = $settings[ 'tw_content' ];
		$behavior = [];
		$typewriter_options = [];

		if ( empty( $contents ) ) return $behavior;

		if ( $delay !== '' ) {
			$typewriter_options['delay'] = $delay;
		}
		if ( $deleteSpeed !== '' ) {
			$typewriter_options['deleteSpeed'] = $deleteSpeed;
		}
		if ( $loop !== '' ) {
			$typewriter_options['loop'] = 'true';
		}
		$typewriter_options['actions'] = [];

		foreach ($contents as $content_item) {
			$action = $content_item[ 'tw_item_action' ];
			$id = $content_item[ '_id' ];
			$value = '';

			switch ( $action ) {
				case 'pauseFor':
					$value = $content_item[ 'tw_item_pauseFor_number' ];
					break;
				case 'deleteChars':
					$value = $content_item[ 'tw_item_deleteChars_number' ];
					break;
				case 'changeDeleteSpeed':
					$value = $content_item[ 'tw_item_changeDeleteSpeed_number' ];
					break;
				case 'changeDelay':
					$value = $content_item[ 'tw_item_changeDelay_number' ];
					break;
				default:
					$text = esc_html( $content_item[ 'tw_item_text' ] );
					$value = "'" . "<span class=\"lqd-tw-item transition-all elementor-repeater-item-$id\">$text</span>" . "'";
					break;
			}

			$typewriter_options[ 'actions' ][] = [ "'" . $action . "'", $value ];
		}

		$behavior[] = [
			'behaviorClass' => 'LiquidTypewriterBehavior',
			'options' => $typewriter_options
		];

		return $behavior;
	}

	protected function register_controls() {

		$elementor_doc_selector = '.elementor';
		$dark_tw_selectors = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-tw-el, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-tw-el, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-tw-el';
		$dark_tw_selectors_hover = '[data-lqd-page-color-scheme=dark] {{WRAPPER}}:hover .lqd-tw-el, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}}:hover .lqd-tw-el, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}:hover .lqd-tw-el';
		$dark_tw_repeater_item_selectors = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} {{CURRENT_ITEM}}';
		$dark_tw_repeater_item_selectors_hover = '[data-lqd-page-color-scheme=dark] {{WRAPPER}}:hover {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}}:hover {{CURRENT_ITEM}}, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}:hover {{CURRENT_ITEM}}';

		// General Section
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $lqd_tw_repeater = new Repeater();

		$lqd_tw_repeater->add_control(
			'tw_item_action',
			[
				'label' => esc_html__( 'Action', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'typeString' => esc_html__( 'Type a string', 'aihub-core' ),
					'pasteString' => esc_html__( 'Paste out a string', 'aihub-core' ),
					'pauseFor' => esc_html__( 'Pause', 'aihub-core' ),
					'deleteChars' => esc_html__( 'Delete characters', 'aihub-core' ),
					'deleteAll' => esc_html__( 'Delete all', 'aihub-core' ),
					'changeDelay' => esc_html__( 'Change typing delay', 'aihub-core' ),
					'changeDeleteSpeed' => esc_html__( 'Change delete speed', 'aihub-core' ),
				],
				'default' => 'typeString',
			]
		);

		$lqd_tw_repeater->add_control(
			'tw_item_text',
			[
				'label' => esc_html__( 'Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( '' , 'aihub-core' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true
				],
				'condition' => [
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'tw_item_pauseFor_number',
			[
				'label' => esc_html__( 'Pause for milliseconds', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'tw_item_action' => 'pauseFor'
				]
			],
		);

		$lqd_tw_repeater->add_control(
			'tw_item_deleteChars_number',
			[
				'label' => esc_html__( 'Delete characters', 'aihub-core' ),
				'description' => esc_html__( 'Delete and amount of characters, starting at the end of the visible string.', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'tw_item_action' => 'deleteChars'
				]
			],
		);

		$lqd_tw_repeater->add_control(
			'tw_item_changeDeleteSpeed_number',
			[
				'label' => esc_html__( 'Delete speed', 'aihub-core' ),
				'description' => esc_html__( 'The speed at which to delete the characters, lower number is faster.', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'tw_item_action' => 'changeDeleteSpeed'
				]
			],
		);

		$lqd_tw_repeater->add_control(
			'tw_item_changeDelay_number',
			[
				'label' => esc_html__( 'Typing delay', 'aihub-core' ),
				'description' => esc_html__( 'Change the delay when typing out each character, lower number is faster.', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'tw_item_action' => 'changeDelay'
				]
			],
		);

		$lqd_tw_repeater->add_control(
			'tw_item_individual_styles',
			[
				'label' => esc_html__( 'Individual styling?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				],
				'separator' => 'before',
			]
		);

		$lqd_tw_repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tw_item_typography',
				'label' => __( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->add_responsive_control(
			'tw_item_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->start_controls_tabs(
			'tw_item_colors_tab'
		);

		$lqd_tw_repeater->start_controls_tab(
			'tw_item_color_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'aihub-core' ),
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'tw_item_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_group_control(
			'liquid-background-css',
			[
				'name' => 'tw_item_background',
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_responsive_control(
			'tw_item_opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->end_controls_tab();

		$lqd_tw_repeater->start_controls_tab(
			'tw_item_color_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'aihub-core' ),
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'tw_item_color_hover',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_group_control(
			'liquid-background-css',
			[
				'name' => 'tw_item_background_hover',
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_responsive_control(
			'tw_item_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->end_controls_tab();

		$lqd_tw_repeater->end_controls_tabs();

		// Start mask text
		$lqd_tw_repeater->add_control(
			'tw_item_mask',
			[
				'label' => __( 'Mask & gradient', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->start_popover();

		$lqd_tw_repeater->add_control(
			'tw_item_mask_type',
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
					'tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'tw_item_mask_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: {{VALUE}}; -webkit-background-clip: text !important; background-clip: text !important; -webkit-text-fill-color: transparent !important; text-fill-color: transparent !important;'
				],
				'condition' => [
					'tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask_type' => 'color'
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'tw_item_mask_gradient_parallax',
			[
				'label' => esc_html__( 'Parallax gradient?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'This option only works in desktop and gradient mask.', 'aihub-core' ),
				'selectors' => [
					'(desktop+){{WRAPPER}} {{CURRENT_ITEM}}' => 'background-attachment: fixed'
				],
				'condition' => [
					'tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask_type' => 'color'
				]
			]
		);

		$lqd_tw_repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tw_item_mask_image',
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
					'tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask_type' => 'image'
				]
			]
		);

		$lqd_tw_repeater->end_popover(); // Mask text

		// Starting individual dark styles
		$lqd_tw_repeater->add_control(
			'dark_tw_repeater_tw_heading',
			[
				'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->start_controls_tabs(
			'dark_tw_item_colors_tab'
		);

		$lqd_tw_repeater->start_controls_tab(
			'dark_tw_item_color_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'aihub-core' ),
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'dark_tw_item_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$dark_tw_repeater_item_selectors => 'color: {{VALUE}}',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => '',
					'dark_tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_tw_item_background',
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $dark_tw_repeater_item_selectors,
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => '',
					'dark_tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_responsive_control(
			'dark_tw_item_opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					$dark_tw_repeater_item_selectors => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->end_controls_tab();

		$lqd_tw_repeater->start_controls_tab(
			'dark_tw_item_color_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'aihub-core' ),
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'dark_tw_item_color_hover',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$dark_tw_repeater_item_selectors_hover => 'color: {{VALUE}}',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => '',
					'dark_tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_group_control(
			'liquid-background-css',
			[
				'name' => 'dark_tw_item_background_hover',
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $dark_tw_repeater_item_selectors_hover,
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'tw_item_mask' => '',
					'dark_tw_item_mask' => ''
				]
			]
		);

		$lqd_tw_repeater->add_responsive_control(
			'dark_tw_item_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					$dark_tw_repeater_item_selectors_hover => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->end_controls_tab();

		$lqd_tw_repeater->end_controls_tabs();

		// Start mask text
		$lqd_tw_repeater->add_control(
			'dark_tw_item_mask',
			[
				'label' => __( 'Mask & gradient', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
				'condition' => [
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ]
				]
			]
		);

		$lqd_tw_repeater->start_popover();

		$lqd_tw_repeater->add_control(
			'dark_tw_item_mask_type',
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
					'dark_tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'dark_tw_item_mask_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'selectors' => [
					$dark_tw_repeater_item_selectors => 'background: {{VALUE}}; -webkit-background-clip: text !important; background-clip: text !important; -webkit-text-fill-color: transparent !important; text-fill-color: transparent !important;'
				],
				'condition' => [
					'dark_tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'dark_tw_item_mask_type' => 'color'
				]
			]
		);

		$lqd_tw_repeater->add_control(
			'dark_tw_item_mask_gradient_parallax',
			[
				'label' => esc_html__( 'Parallax gradient?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'This option only works in desktop and gradient mask.', 'aihub-core' ),
				'selectors' => [
					'(desktop+)' . $dark_tw_repeater_item_selectors => 'background-attachment: fixed'
				],
				'condition' => [
					'dark_tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'dark_tw_item_mask_type' => 'color'
				]
			]
		);

		$lqd_tw_repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'dark_tw_item_mask_image',
				'types' => [ 'classic' ],
				'selector' => $dark_tw_repeater_item_selectors,
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
					'dark_tw_item_mask' => 'yes',
					'tw_item_individual_styles' => 'yes',
					'tw_item_action' => [ 'typeString', 'pasteString' ],
					'dark_tw_item_mask_type' => 'image'
				]
			]
		);

		$lqd_tw_repeater->end_popover(); // Mask text

		$this->add_control(
			'tw_content',
			[
				'label' => esc_html__( 'Actions', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $lqd_tw_repeater->get_controls(),
				'default' => [
					[
						'tw_item_action' => 'typeString',
						'tw_item_text' => __('Start adding stages')
					],
					[
						'tw_item_action' => 'pauseFor',
						'tw_item_pauseFor_number' => 300
					],
					[
						'tw_item_action' => 'deleteChars',
						'tw_item_deleteChars_number' => 6
					],
					[
						'tw_item_action' => 'typeString',
						'tw_item_text' => __('actions.')
					],
					[
						'tw_item_action' => 'pauseFor',
						'tw_item_pauseFor_number' => 1000
					],
				],
				'title_field' => '{{{ tw_item_action }}}',
				'button_text' => esc_html__( 'Add an action', 'aihub-core' )
			]
		);

		$this->add_control(
			'tw_delay',
			[
				'label' => esc_html__( 'Default typing delay', 'aihub-core' ),
				'description' => esc_html__( 'The delay between each key when typing. In miliseconds.', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'tw_deleteSpeed',
			[
				'label' => esc_html__( 'Default deleting speed', 'aihub-core' ),
				'description' => esc_html__( 'The delay between deleting each character. In miliseconds.', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'tw_loop',
			[
				'label' => esc_html__( 'Loop', 'aihub-core' ),
				'description' => esc_html__( 'Whether to keep looping or not.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'tw_preserve_space',
			[
				'label' => esc_html__( 'Preserve space', 'aihub-core' ),
				'description' => esc_html__( 'Enable if you want to prevent the content below this widget shift position while typing effect is running.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_responsive_control(
			'tw_whitespace',
			[
				'label' => __( 'Whitespace', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					''  => [
						'title' => __( 'Normal', 'aihub-core' ),
						'icon' => 'eicon-wrap'
					],
					'nowrap' => [
						'title' => __( 'Nowrap', 'aihub-core' ),
						'icon' => 'eicon-nowrap'
					],
				],
				'default' => '',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}}' => 'white-space: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'tw_tag',
			[
				'label' => esc_html__( 'Element Tag', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'p' => 'p',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'p',
				'separator' => 'before',
			]
		);

        $this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'tw',
			[
				'el' => [
					'label' => 'General',
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'raw',
							'tab' => 'none',
							'raw_options' => [
								'tw_alignment',
								[
									'label' => esc_html_x( 'Text align', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'start' => [
											'title' => __( 'Start', 'aihub-core' ),
											'icon' => 'eicon-text-align-left',
										],
										'center' => [
											'title' => __( 'Center', 'aihub-core' ),
											'icon' => 'eicon-text-align-center',
										],
										'end' => [
											'title' => __( 'End', 'aihub-core' ),
											'icon' => 'eicon-text-align-right',
										],
										'justify' => [
											'title' => __( 'Justify', 'aihub-core' ),
											'icon' => 'eicon-text-align-justify',
										],
									],
									'selectors' => [
										'{{WRAPPER}}' => 'text-align: {{VALUE}};',
									],
								]
							]
						],
						[
							'type' => 'liquid_color',
							'condition' => [
								'tw_mask' => ''
							]
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'cursor' => [
					'label' => 'Cursor',
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'liquid_color',
						],
						[
							'type' => 'margin',
						],
						[
							'type' => 'opacity',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
			],
		);

		/**
		 * Added mask and alignment options in section-controls.php
		 */

	}

	protected function print_preserver_text() {
		$settings = $this->get_settings_for_display();
		$content_array = $settings['tw_content'];
		$content_string = '<span class="lqd-tw-preserver invisible" tabindex="-1">';

		if ( empty( $content_array ) ) {
			return $content_string . '</span>';
		}

		$i = 0;
		foreach ( $content_array as $content_item ) {
			$i++;

			$action = $content_item['tw_item_action'];
			$text = $content_item['tw_item_text'];

			$item_id = $content_item['_id'];
			$attrs_id = 'item-' . $item_id . '-attrs';

			$this->add_render_attribute( $attrs_id, 'class', [
				'lqd-tw-item',
				'transition-all',
				'elementor-repeater-item-' . $item_id
			] );

			$content_string .= '<span ' . $this->get_render_attribute_string( $attrs_id ) . '>' . $text . '</span>';
		}

		return $content_string . '</span>';
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$preserver_space = $settings['tw_preserve_space'];
		$preserver_text = $preserver_space === 'yes' ? $this->print_preserver_text() : '';
		$tag = Utils::validate_html_tag( $settings['tw_tag'] );

		$this->add_render_attribute( 'title', 'class', 'lqd-tw-el mt-0 mb-0 relative' );
		$this->add_render_attribute( 'writer', 'class', 'lqd-tw-writer' );

		if ( $preserver_space === 'yes' ) {
			$this->add_render_attribute( 'writer', 'class', 'block w-full h-full absolute top-0 start-0' );
		}

		?>
			<<?php echo $tag; ?> <?php echo $this->get_render_attribute_string( 'title' ) ?>>
				<?php echo $preserver_text ?>
				<span <?php echo $this->get_render_attribute_string( 'writer' ) ?>></span>
			</<?php echo $tag ?>>
		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Typewriter() );