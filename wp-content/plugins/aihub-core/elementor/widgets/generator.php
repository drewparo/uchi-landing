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

class LQD_GENERATOR extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

        wp_register_script( 'lqd-generator',
        	get_template_directory_uri() . '/liquid/assets/vendors/ai/widget-generator.js',
        	[ 'jquery' ],
            null
        );

        wp_register_style( 'lqd-generator',
        	get_template_directory_uri() . '/liquid/assets/vendors/ai/widget-generator.css',
        	[],
            null
        );
	}

	public function get_name() {
		return 'lqd-generator';
	}

	public function get_title() {
		return __( 'Liquid Generator', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-ai lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'image', 'ai', 'generator', 'dall', 'open' ];
	}

	public function get_script_depends() {
		return [ 'lqd-generator' ];
	}

	public function get_style_depends() {
		return [ 'lqd-generator' ];
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
				'label' => esc_html__( 'Generate limit', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
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
					'{{WRAPPER}} .lqd-generator--icon' => 'order: {{VALUE}}',
				],
				'condition' => [
					'selected_icon[value]!' => ''
				]
			]
		);

		$this->add_control(
			'container_height',
			[
				'label' => esc_html__( 'Container Max Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-generator--results-messages' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'ai' => [
					'active' => false
				]
			]
		);

		$repeater->add_control(
			'prompt',
			[
				'label' => esc_html__( 'Prompt', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'You can use [prompt] anywhere in the text. [prompt] is the input value from the user.' , 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$repeater->add_control(
			'edit_prompt',
			[
				'label' => esc_html__( 'Edit Prompt', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'It is only work when enabled the "edit option". You can use [prompt] anywhere in the text. [prompt] is the input value from the user.' , 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'prompts',
			[
				'label' => esc_html__( 'Prompts', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => 'Blog Post',
						'prompt' => 'Generate blog post about [prompt]',
						'edit_prompt' => 'Rewrite blog post. My post: [prompt]'
					],
					[
						'title' => 'Blog Post Title',
						'prompt' => 'Generate one uniuqe blog post title about [prompt]',
						'edit_prompt' => 'Edit my post title with more professional: [prompt]'
					],
					[
						'title' => 'Tags',
						'prompt' => 'Generate post tags about [prompt]',
						'edit_prompt' => 'Edit tags for better seo: [prompt]'
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'selected_icon_dropdown',
			[
				'label' => esc_html__( 'Dropdown Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'enable_edit_mode',
			[
				'label' => esc_html__( 'Enable edit option?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'generate_text',
			[
				'label' => esc_html__( 'Generate Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Generate', 'aihub-core' ),
				'placeholder' => esc_html__( 'Generate', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_edit_mode' => 'yes'
				]
			]
		);

		$this->add_control(
			'edit_text',
			[
				'label' => esc_html__( 'Edit Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Edit', 'aihub-core' ),
				'placeholder' => esc_html__( 'Edit', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_edit_mode' => 'yes'
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
					'{{WRAPPER}} .lqd-generator--form' => 'flex-direction: {{VALUE}};',
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

		$this->add_control(
			'label_typing',
			[
				'label' => esc_html__( 'Typing', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Typing...', 'aihub-core' ),
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
			'generator',
			[
				'search_bar' => [
					'label' => 'Form',
					'controls' => [
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--form'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-generator--form'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--form'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--form'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--form'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--form'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'input' => [
					'controls' => [
						[
							'type' => 'typography',
							'selector' => '.lqd-generator--input-wrap'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-generator--input-wrap'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-generator--input-wrap'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--input-wrap'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--input-wrap'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--input-wrap'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--input-wrap'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'focus-within' ],
				],
				'dropdown' => [
					'controls' => [
						[
							'type' => 'width',
							'selectors' => [
								'{{WRAPPER}} .lqd-generator--prompts' => 'width: {{SIZE}}{{UNIT}}'
							]
						],
						[
							'type' => 'typography',
							'selector' => '.lqd-generator--prompts-wrapper'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--prompts-wrapper'
						],
						[
							'type' => 'padding',
							'selectors' => [
								'{{WRAPPER}} .lqd-generator--prompts' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
								'{{WRAPPER}} .lqd-generator--icon-dropdown' => 'inset-inline-end: {{RIGHT}}{{UNIT}}',
							]
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-generator--prompts-wrapper'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--prompts-wrapper'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--prompts-wrapper'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--prompts-wrapper'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--prompts-wrapper'
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
							'selector' => '.lqd-generator--icon'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'selector' => '.lqd-generator--icon'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--icon'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-generator--icon'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--icon'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--icon'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--icon'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--icon'
						],
					],
					'condition' => [
						'selected_icon[value]!' => ''
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'icon_dropdown' => [
					'controls' => [
						[
							'type' => 'font_size',
							'name' => 'icon_size',
							'selector' => '.lqd-generator--icon-dropdown'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'selector' => '.lqd-generator--icon-dropdown'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--icon-dropdown'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-generator--icon-dropdown'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--icon-dropdown'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--icon-dropdown'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--icon-dropdown'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--icon-dropdown'
						],
					],
					'condition' => [
						'selected_icon_dropdown[value]!' => ''
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'loader' => [
					'controls' => [
						[
							'type' => 'liquid_color',
							'selectors' => [
								'{{WRAPPER}} .lqd-generator--loader .lds-ripple div' => 'border-color: {{VALUE}}',
								'{{WRAPPER}} .lqd-generator--loader .text' => 'color: {{VALUE}}'
							],
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--loader'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--loader'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-generator--loader'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--loader'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--loader'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--loader'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'output' => [
					'controls' => [
						[
							'type' => 'width',
							'default' => [
								'size' => 100,
								'unit' => '%'
							],
							'selectors' => [
								'{{WRAPPER}} .lqd-generator--results-message' => 'width: {{SIZE}}{{UNIT}}'
							]
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-generator--results-message'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--results-message',
							'default' => [
								'unit' => 'px',
								'top' => '30',
								'right' => '0',
								'bottom' => '0',
								'left' => '0',
								'isLinked' => false
							],
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-generator--results-message'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--results-message'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--results-message'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--results-message'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--results-message'
						],
					],
				],
				'alert' => [
					'controls' => [
						[
							'type' => 'padding',
							'selector' => '.lqd-generator--alert'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--alert',
						],
						[
							'type' => 'typography',
							'selector' => '.lqd-generator--alert'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-generator--alert'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--alert'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--alert'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--alert'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--alert'
						],
					],
				],
				'switcher' => [
					'label' => 'Switcher',
					'controls' => [
						[
							'type' => 'gap',
							'label' => 'Gap between items',
							'selector' => '.lqd-generator--types'
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-generator--types label'
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-generator--types label'
						],
						[
							'type' => 'typography',
							'selector' => '.lqd-generator--types label'
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-generator--types label'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-generator--types label'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-generator--types label'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-generator--types label'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-generator--types label'
						],
					],
					'condition' => [
						'enable_edit_mode' => 'yes'
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
					'selector' => '.lqd-generator--form',
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
					'selector' => '.lqd-generator--input-wrap',
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
		$cache = get_transient( 'liquid_generator__' . $IP );

		if ( false === $cache ) {
			$cache = [ 'limit' => $request_limit, 'expiration' => $request_by ];
			set_transient( 'liquid_generator__' . $IP, $cache, $expiration );
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

	protected function get_prompts() {
		$prompts = $this->get_settings_for_display('prompts');

		if ( ! $prompts ) return;

		?>
		<div class="lqd-generator--prompts-wrapper flex relative">
			<select id="prompts" class="lqd-generator--prompts">
				<?php
					foreach( $prompts as $prompt ) {
						printf( '<option value="%s" data-prompt="%s">%s</option>', esc_attr($prompt['prompt']), esc_attr($prompt['edit_prompt']), $prompt['title'] );
					}
				?>
			</select>
			<?php if ( ! empty( $this->get_settings_for_display('selected_icon_dropdown')['value'] ) ) { ?>
				<div class="lqd-generator--icon-dropdown flex items-center justify-center absolute top-1/2 end-0 lqd-transform -translate-y-1/2 pointer-events-none">
					<?php \LQD_Elementor_Helper::render_icon( $this->get_settings_for_display('selected_icon_dropdown'), [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	protected function get_prompts_type() {
		$edit = $this->get_settings_for_display('enable_edit_mode');

		if ( ! $edit ) return;

		?>
		<div class="lqd-generator--types flex">
			<input name="type" class="hidden" type="radio" value="generate" id="generate" checked>
			<label for="generate" class="selected"><?php echo $this->get_settings_for_display('generate_text') ?? __('Generate', 'aihub-core'); ?></label>
			<input name="type" class="hidden" type="radio" value="edit" id="edit">
			<label for="edit"><?php echo $this->get_settings_for_display('edit_text') ?? __('Edit', 'aihub-core'); ?></label>
		</div>

		<?php

	}

	protected function render() {

		$this->request_limit();

		$settings = $this->get_settings_for_display();
		$options = [
			'l' => $settings['is_user_logged_in'] ? $settings['is_user_logged_in'] : '',
			'label_typing' => $settings['label_typing'] ? $settings['label_typing'] : __( 'Typing', 'aihub-core' ),
		];

		$this->add_render_attribute(
			'lqd_generator_form',
			[
				'class' => [ 'lqd-generator--form', 'flex', 'items-center', 'relative' ],
				'action' => 'lqd-generator',
				'medhod' => 'post',
				'data-options' => wp_json_encode( $options )
			]
		);

		?>
		<div class="lqd-generator">
			<?php $this->get_prompts_type(); ?>
			<form <?php $this->print_render_attribute_string( 'lqd_generator_form' ); ?>>
				<?php $this->get_outline_glow_markup( 'form' ); ?>
				<div class="lqd-generator--input-wrap flex w-full relative">
					<?php $this->get_outline_glow_markup( 'input' ); ?>
					<input class="lqd-generator--input w-full relative" type="text" id="prompt" name="prompt" maxlength="1000" autocomplete="off" placeholder="<?php echo esc_attr( $settings['label_input'] ); ?>" required>
				</div>
				<?php $this->get_prompts(); ?>
				<?php wp_nonce_field( 'lqd-generator', 'security' ); ?>
				<?php \LQD_Elementor_Render_Button::get_button( $this, 'ib_', '', 'submit' ); ?>
				<?php if ( ! empty( $settings['selected_icon']['value'] ) ) { ?>
					<div class="lqd-generator--icon flex items-center justify-center">
						<?php \LQD_Elementor_Helper::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
					</div>
				<?php } ?>
			</form>

			<div class="lqd-generator--results flex flex-col justify-center">
				<div class="lqd-generator--results-messages w-full flex flex-col relative overflow-auto"></div>
				<div class="lqd-generator--alert lqd-generator--results-error_login"><?php echo esc_html( $settings['label_login'] ); ?></div>
				<div class="lqd-generator--alert lqd-generator--results-error_limit"><?php echo esc_html( $settings['label_limit'] ); ?></div>
			</div>

		</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_GENERATOR() );