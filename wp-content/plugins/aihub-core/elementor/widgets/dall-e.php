<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_DALL_E extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

        wp_register_script( 'lqd-dall-e',
        	get_template_directory_uri() . '/liquid/assets/vendors/ai/widget-dall-e.js',
        	[ 'jquery' ],
            null
        );

        wp_register_style( 'lqd-dall-e',
        	get_template_directory_uri() . '/liquid/assets/vendors/ai/widget-dall-e.css',
        	[],
            null
        );
	}

	public function get_name() {
		return 'lqd-dall-e';
	}

	public function get_title() {
		return __( 'Liquid Image Generator', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-ai lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'image', 'ai', 'generator', 'dall', 'open', 'dall-e', 'stable diffusion' ];
	}

	public function get_script_depends() {
		return [ 'lqd-dall-e' ];
	}

	public function get_style_depends() {
		return [ 'lqd-dall-e' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'data_section',
			[
				'label' => __( 'Data', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		if (
			empty( liquid_helper()->get_kit_option('liquid_ai') ) ||
			empty( liquid_helper()->get_kit_option('liquid_ai_api_key') )
		) {
			$this->add_control(
				'api_key_info',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( 'Go to the <strong><u>Elementor Site Settings > Liquid AI</u></strong> to add your API Key.', 'aihub-core' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'n',
			[
				'label' => esc_html__( 'Image variations', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 3,
			]
		);

		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Image size', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '256x256',
				'options' => [
					'256x256' => esc_html__( '256x256', 'aihub-core' ),
					'512x512' => esc_html__( '512x512', 'aihub-core' ),
					'1024x1024' => esc_html__( '1024x1024', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'limit_options',
			[
				'label' => esc_html__( 'Limitation', 'aihub-core' ),
				//'description' => esc_html__( 'You can set a request limit. For example, allow 2 prompt requests by hours or days', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'is_user_logged_in',
			[
				'label' => esc_html__( 'Enable Login required?', 'aihub-core' ),
				'description' => esc_html__( 'Disable usage for non-login users.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'request_by',
			[
				'label' => esc_html__( 'Request by', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'HOUR_IN_SECONDS',
				'options' => [
					'HOUR_IN_SECONDS' => esc_html__( 'Hour', 'aihub-core' ),
					'DAY_IN_SECONDS' => esc_html__( 'Day', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'request_limit',
			[
				'label' => esc_html__( 'Limit', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 2,
			]
		);

		$this->add_control(
			'enable_tags',
			[
				'label' => esc_html__( 'Enable tags', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tag_text',
			[
				'label' => esc_html__( 'Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Most popular:', 'aihub-core' ),
				'placeholder' => esc_html__( 'Popular tags:', 'aihub-core' ),
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'enable_tags' => 'yes'
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tag',
			[
				'label' => esc_html__( 'Tag', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'prompt',
			[
				'label' => esc_html__( 'Prompt', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'tags',
			[
				'label' => esc_html__( 'Repeater List', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tag' => __( 'Paint', 'aihub-core' ),
						'prompt' => __( 'A cat like van gogh', 'aihub-core' )
					],[
						'tag' => __( 'Robot', 'aihub-core' ),
						'prompt' => __( 'Red Robot meeting People', 'aihub-core' )
					],[
						'tag' => __( 'Cartoon', 'aihub-core' ),
						'prompt' => __( 'A dog like cartoon character', 'aihub-core' )
					],
				],
				'title_field' => '{{{ tag }}}',
				'condition' => [
					'enable_tags' => 'yes'
				]
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'selected_icon_order',
			[
				'label' => esc_html__( 'Icon order', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -2,
				'max' => 2,
				'step' => 1,
				'default' => 0,
				'selectors' => [
					'{{WRAPPER}} .lqd-dall-e--icon' => 'order: {{VALUE}}',
				],
				'condition' => [
					'selected_icon[value]!' => ''
				]
			]
		);

		$this->add_control(
			'enable_sd',
			[
				'label' => esc_html__( 'Enable Stable Diffusion?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'force_enable_sd',
			[
				'label' => esc_html__( 'Only one Stable Diffusion?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_sd' => 'yes'
				]
			]
		);

		$this->add_control(
			'dall_e_text',
			[
				'label' => esc_html__( 'DALL-E Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'DALL-E', 'aihub-core' ),
				'placeholder' => esc_html__( 'DALL-E', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_sd' => 'yes'
				]
			]
		);

		$this->add_control(
			'sd_text',
			[
				'label' => esc_html__( 'Stable Diffusion Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Stable Diffusion', 'aihub-core' ),
				'placeholder' => esc_html__( 'Stable Diffusion', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_sd' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_image2image',
			[
				'label' => esc_html__( 'Enable Image to Image?', 'aihub-core' ),
				'description' => esc_html__( 'Users images will be uploading to "wp-content/uploads/liquid-ai-images" folder.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'image2image_text',
			[
				'label' => esc_html__( 'Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Choose File', 'aihub-core' ),
				'placeholder' => esc_html__( 'Choose File', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_image2image' => 'yes'
				]
			]
		);

		$this->add_control(
			'image2image_abs',
			[
				'label' => esc_html__( 'Custom Positioning?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-dall-e--file' => 'position: absolute;',
				],
				'condition' => [
					'enable_image2image' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'image2image_pos_h',
			[
				'label' => esc_html__( 'Position', 'aihub-core' ),
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
				'default' => 'right',
				'toggle' => false,
				'condition' => [
					'image2image_abs' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'image2image_pos_h_c',
			[
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-dall-e--file' => '{{image2image_pos_h.VALUE}}: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image2image_abs' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'image2image_pos_v_w',
			[
				'label' => esc_html__( 'Position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Left', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Right', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'right',
				'toggle' => false,
				'condition' => [
					'image2image_abs' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'image2image_pos_v_c',
			[
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-dall-e--file' => '{{image2image_pos_v_w.VALUE}}: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image2image_abs' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'form_direction',
			[
				'label' => esc_html__( 'Form Direction', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Inline', 'aihub-core' ),
						'icon' => ' eicon-navigation-horizontal',
					],
					'column' => [
						'title' => esc_html__( 'Stack', 'aihub-core' ),
						'icon' => 'eicon-navigation-vertical',
					],
				],
				'default' => 'row',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-dall-e--form' => 'flex-direction: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'label_section',
			[
				'label' => __( 'Labels', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'label_input',
			[
				'label' => esc_html__( 'Input placeholder', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Start with a detailed description', 'aihub-core' ),
				'label_block' => true,
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'label_login',
			[
				'label' => esc_html__( 'Login alert', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'You should login first!', 'aihub-core' ),
				'label_block' => true,
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'label_limit',
			[
				'label' => esc_html__( 'Reached limit', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'You have reached your request limit. Please try again 1 hour later.', 'aihub-core' ),
				'label_block' => true,
				'ai' => [
					'active' => false
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'effects_section',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'lqd_outline_glow_effect_form',
			[
				'label' => esc_html__( 'Form glow effect style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'effect-1' => esc_html__( 'Effect 1', 'aihub-core' ),
					'effect-2' => esc_html__( 'Effect 2', 'aihub-core' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'lqd_outline_glow_effect_input',
			[
				'label' => esc_html__( 'Input glow effect style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'effect-1' => esc_html__( 'Effect 1', 'aihub-core' ),
					'effect-2' => esc_html__( 'Effect 2', 'aihub-core' ),
				],
				'default' => '',
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'dall_e',
			[
				'search_bar' => [
					'label' => 'Form',
					'controls' => [
						[
							'type' => 'margin',
							'selector' => '.lqd-dall-e--form'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-dall-e--form'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-dall-e--form'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-dall-e--form'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-dall-e--form'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-dall-e--form'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'input' => [
					'controls' => [
						[
							'type' => 'typography',
							'selector' => '.lqd-dall-e--input-wrap'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-dall-e--input-wrap'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-dall-e--input-wrap'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-dall-e--input-wrap'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-dall-e--input-wrap'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-dall-e--input-wrap'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-dall-e--input-wrap'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'focus-within' ],
				],
				'icon' => [
					'controls' => [
						[
							'type' => 'font_size',
							'name' => 'icon_size',
							'selector' => '.lqd-dall-e--icon'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'selector' => '.lqd-dall-e--icon'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-dall-e--icon'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-dall-e--icon'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-dall-e--icon'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-dall-e--icon'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-dall-e--icon'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-dall-e--icon'
						],
					],
					'condition' => [
						'selected_icon[value]!' => ''
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'tags' => [
					'controls' => [
						[
							'type' => 'typography',
							'selector' => '.lqd-dall-e--tags'
						],
						[
							'type' => 'gap',
							'label' => 'Gap between tags',
							'default' => [
								'size' => 1,
								'unit' => 'em'
							],
							'selector' => '.lqd-dall-e--tags'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-dall-e--tag'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-dall-e--tag'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-dall-e--tag'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-dall-e--tag'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-dall-e--tag'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-dall-e--tag'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'loader' => [
					'controls' => [
						[
							'type' => 'liquid_color',
							'selectors' => [
								'{{WRAPPER}} .lqd-dall-e--loader .lds-ripple div' => 'border-color: {{VALUE}}'
							]
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'image' => [
					'controls' => [
						[
							'type' => 'width',
							'default' => [
								'size' => 30,
								'unit' => '%'
							],
							'selectors' => [
								'{{WRAPPER}} .lqd-dall-e--results-images a' => 'width: {{SIZE}}{{UNIT}}'
							]
						],
						[
							'type' => 'gap',
							'label' => 'Gap between tags',
							'default' => [
								'size' => 5,
								'unit' => '%'
							],
							'selector' => '.lqd-dall-e--results-images'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-dall-e--results-images'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-dall-e--results-images',
							'default' => [
								'unit' => 'px',
								'top' => '30',
								'right' => '0',
								'bottom' => '0',
								'left' => '0',
								'isLinked' => false
							],
						],
					],
				],
				'alert' => [
					'controls' => [
						[
							'type' => 'padding',
							'selector' => '.lqd-dall-e--alert'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-dall-e--alert',
						],
						[
							'type' => 'typography',
							'selector' => '.lqd-dall-e--alert'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-dall-e--alert'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-dall-e--alert'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-dall-e--alert'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-dall-e--alert'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-dall-e--alert'
						],
					],
				],
				'switcher' => [
					'label' => 'Switcher',
					'controls' => [
						[
							'type' => 'gap',
							'label' => 'Gap between items',
							'selector' => '.lqd-dall-e--types'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-dall-e--types label'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-dall-e--types label'
						],
						[
							'type' => 'typography',
							'selector' => '.lqd-dall-e--types label'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-dall-e--types label'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-dall-e--types label'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-dall-e--types label'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-dall-e--types label'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-dall-e--types label'
						],
					],
					'condition' => [
						'enable_sd' => 'yes'
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors' => [ 'active' => '.selected' ]
				],
				'file_input' => [
					'label' => 'Image upload',
					'controls' => [
						[
							'type' => 'padding',
							'selector' => '.lqd-dall-e--file'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-dall-e--file'
						],
						[
							'type' => 'typography',
							'selector' => '.lqd-dall-e--file'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-dall-e--file'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-dall-e--file'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-dall-e--file'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-dall-e--file'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-dall-e--file'
						],
					],
					'condition' => [
						'enable_sd' => 'yes'
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors' => [ 'active' => '.selected' ]
				],
				'glow_form' => [
					'label' => 'Form glow',
					'controls' => [
						[
							'type' => 'width',
							'css_var' => '--lqd-outline-glow-w',
						],
						[
							'type' => 'slider',
							'name' => 'duration',
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 1,
									'max' => 10,
								]
							],
							'unit' => 's',
							'css_var' => '--lqd-outline-glow-duration',
						],
						[
							'type' => 'liquid_color',
							'name' => 'color',
							'types' => [ 'solid' ],
							'css_var' => '--lqd-outline-glow-color',
						],
						[
							'type' => 'liquid_color',
							'name' => 'color_secondary',
							'types' => [ 'solid' ],
							'css_var' => '--lqd-outline-glow-color-secondary',
						],
					],
					'plural_heading' => false,
					'apply_css_var_to_el' => true,
					'selector' => '.lqd-dall-e--form',
					'condition' => [
						'lqd_outline_glow_effect_form!' => ''
					],
				],
				'glow_input' => [
					'label' => 'Input glow',
					'controls' => [
						[
							'type' => 'width',
							'css_var' => '--lqd-outline-glow-w',
						],
						[
							'type' => 'slider',
							'name' => 'duration',
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 1,
									'max' => 10,
								]
							],
							'unit' => 's',
							'css_var' => '--lqd-outline-glow-duration',
						],
						[
							'type' => 'liquid_color',
							'name' => 'color',
							'types' => [ 'solid' ],
							'css_var' => '--lqd-outline-glow-color',
						],
						[
							'type' => 'liquid_color',
							'name' => 'color_secondary',
							'types' => [ 'solid' ],
							'css_var' => '--lqd-outline-glow-color-secondary',
						],
					],
					'plural_heading' => false,
					'apply_css_var_to_el' => true,
					'selector' => '.lqd-dall-e--input-wrap',
					'condition' => [
						'lqd_outline_glow_effect_input!' => ''
					],
				],
			],
		);

		lqd_elementor_add_button_controls( $this, 'ib_', [], true, 'all', true, 'submit' );

	}

	protected function request_limit() {

		$request_by = $this->get_settings_for_display( 'request_by' ); // HOUR_IN_SECONDS, DAY_IN_SECONDS
		$request_limit = $this->get_settings_for_display( 'request_limit' );
		$expiration = constant($request_by);

		$IP = $_SERVER['REMOTE_ADDR'];
		$cache = get_transient( 'liquid_dall_e__' . $IP );

		if ( false === $cache ) {
			$cache = [ 'limit' => $request_limit, 'expiration' => $request_by ];
			set_transient( 'liquid_dall_e__' . $IP, $cache, $expiration );
		}

	}

	protected function get_outline_glow_markup( $part ) {

		if ( !$part ) return;

		$settings = $this->get_settings_for_display();
		$glow_effect = $settings[ 'lqd_outline_glow_effect_' . $part ];

		if ( empty( $glow_effect ) ) return;

		$glow_attrs = [
			'class' => [ 'lqd-outline-glow', 'lqd-outline-glow-' . $part, 'lqd-outline-glow-' . $glow_effect, 'inline-block', 'rounded-inherit', 'absolute', 'pointer-events-none' ]
		];

		$this->add_render_attribute( 'outline_glow_' . $part, $glow_attrs );

		?>
			<span <?php $this->print_render_attribute_string( 'outline_glow_' . $part ); ?>>
				<span class="lqd-outline-glow-inner inline-block min-w-full min-h-full rounded-inherit aspect-square absolute top-1/2 start-1/2"></span>
			</span>
		<?php

	}

	protected function get_generator_type() {

		if ( $this->get_settings_for_display('force_enable_sd') === 'yes' ) {
			?>
			<input name="type" class="hidden" type="radio" value="sd" id="sd" checked>
			<?php
			return;
		}

		$sd = $this->get_settings_for_display('enable_sd');

		if ( ! $sd ) return;

		?>
			<div class="lqd-dall-e--types flex">
				<input name="type" class="hidden" type="radio" value="dall-e" id="dall-e" checked>
				<label for="dall-e" class="selected cursor-pointer"><?php echo $this->get_settings_for_display('dall_e_text') ?? __('DALL-E', 'aihub-core'); ?></label>
				<input name="type" class="hidden" type="radio" value="sd" id="sd">
				<label for="sd" class="cursor-pointer"><?php echo $this->get_settings_for_display('sd_text') ?? __('Stable Diffusion', 'aihub-core'); ?></label>
			</div>
		<?php

	}

	protected function get_file_upload() {
		$image  = $this->get_settings_for_display('enable_image2image');

		if ( ! $image ) return;
		?>
			<div class="lqd-dall-e--file">
				<input type="file" name="image" id="image" class="hidden">
				<label for="image"><?php echo $this->get_settings_for_display('image2image_text'); ?></label>
			</div>
		<?php
	}

	protected function render() {

		$this->request_limit();

		$settings = $this->get_settings_for_display();
		$options = [
			'n' => intval( $settings['n'] ),
			'size' => $settings['size'],
			'l' => $settings['is_user_logged_in'] ? $settings['is_user_logged_in'] : '',

		];

		$this->add_render_attribute(
			'lqd_dall_e_form',
			[
				'class' => [ 'lqd-dall-e--form', 'flex', 'items-center', 'relative' ],
				'action' => 'lqd-dall-e',
				'medhod' => 'post',
				'data-options' => wp_json_encode( $options )
			]
		);

		?>
		<div class="lqd-dall-e">
			<?php $this->get_generator_type(); ?>
			<form <?php $this->print_render_attribute_string( 'lqd_dall_e_form' ); ?>>
				<?php $this->get_outline_glow_markup( 'form' ); ?>
				<div class="lqd-dall-e--input-wrap flex w-full relative">
					<?php $this->get_outline_glow_markup( 'input' ); ?>
					<input class="lqd-dall-e--input w-full relative" type="text" id="prompt" name="prompt" maxlength="1000" placeholder="<?php echo esc_attr( $settings['label_input'] ); ?>" required>
				</div>
				<?php wp_nonce_field( 'lqd-dall-e', 'security' ); ?>
				<?php \LQD_Elementor_Render_Button::get_button( $this, 'ib_', '', 'submit' ); ?>
				<?php if ( ! empty( $settings['selected_icon']['value'] ) ) { ?>
					<div class="lqd-dall-e--icon flex items-center justify-center">
						<?php \LQD_Elementor_Helper::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
					</div>
				<?php } ?>
				<div class="lqd-dall-e--loader rounded-inherit relative">
					<div class="lds-ripple"><div></div><div></div></div>
				</div>
				<?php $this->get_file_upload(); ?>
			</form>

			<?php if ( $settings['enable_tags'] === 'yes' && $settings['tags'] ) : ?>
				<div class="lqd-dall-e--tags flex justify-center">
					<?php
						if ( $settings['tag_text'] ) {
							printf( '<span>%s</span>', esc_html( $settings['tag_text'] ) );
						}
					?>
					<?php
						foreach ( $settings['tags'] as $tag ) {
							printf( '<span class="lqd-dall-e--tag %s" data-prompt="%s">%s</span>', esc_attr( 'elementor-repeater-item-' . $tag['_id'] ), esc_attr( $tag['prompt'] ), esc_html( $tag['tag'] ) );
						}
					?>
				</div>
			<?php endif;?>

			<div class="lqd-dall-e--results flex justify-center">
				<div class="lqd-dall-e--results-images w-full flex flex-wrap"></div>
				<div class="lqd-dall-e--alert lqd-dall-e--results-error_login"><?php echo esc_html( $settings['label_login'] ); ?></div>
				<div class="lqd-dall-e--alert lqd-dall-e--results-error_limit"><?php echo esc_html( $settings['label_limit'] ); ?></div>
			</div>

		</div>

		<?php


	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_DALL_E() );