<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\WYSIWYG;
use Elementor\Embed;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Steps extends Widget_Base {

	public function get_name() {
		return 'lqd-steps';
	}

	public function get_title() {
		return __( 'Liquid Steps', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-number-field lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'steps', 'numbers', 'process' ];
	}

	public function get_utility_classnames() {
		return [];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$steps_repeater = new Repeater();

		$steps_repeater->add_control(
			'step_title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sign up for free.', 'aihub-core' ),
				'label_block' => true,
			]
		);

		$steps_repeater->add_control(
			'step_description',
			[
				'label' => esc_html__( 'Descriptions', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'To be able to create an account, input your email address and password.', 'aihub-core' ),
			]
		);

		$steps_repeater->add_control(
			'step_indicator',
			[
				'label' => esc_html__( 'Indicator?', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'none' => [
						'title' => esc_html__( 'None', 'aihub-core' ),
						'icon' => 'eicon-ban',
					],
					'number' => [
						'title' => esc_html__( 'Number', 'aihub-core' ),
						'icon' => 'eicon-number-field',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'aihub-core' ),
						'icon' => 'eicon-star-o',
					],
					'custom_text' => [
						'title' => esc_html__( 'Custom text', 'aihub-core' ),
						'icon' => 'eicon-animation-text',
					],
				],
				'default' => 'number',
				'toggle' => false,
				'separator' => 'before'
			]
		);

		$steps_repeater->add_control(
			'step_indicator_icon',
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
					'step_indicator' => 'icon',
				]
			]
		);

		$steps_repeater->add_control(
			'step_indicator_custom_text',
			[
				'label' => esc_html__( 'Custom indicator text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'step_indicator' => 'custom_text',
				]
			]
		);

		$steps_repeater->add_control(
			'step_style_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$steps_repeater->add_control(
			'step_individual_styles',
			[
				'label' => esc_html__( 'Individual styling?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		\LQD_Elementor_Helper::add_style_controls(
			$steps_repeater,
			'steps',
			[
				'step' => [
					'controls' => [
						[
							'type' => 'margin',
							'css_var' => '--lqd-step-m',
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-step-p',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-color',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-step-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-step-br',
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-step-brr',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-step-bs',
						],
					],
					'plural_heading' => false,
					'selector' => '{{CURRENT_ITEM}}.lqd-steps-step',
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{CURRENT_ITEM}}.lqd-steps-step' ],
					'condition' => [
						'step_individual_styles' => 'yes'
					]
				],
				'indicator_wrap' => [
					'label' => 'Indicator',
					'controls' => [
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-ind-color',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-step-ind-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-step-ind-br',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-step-ind-bs',
						],
					],
					'selector' => '{{CURRENT_ITEM}}.lqd-steps-step',
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{CURRENT_ITEM}}.lqd-steps-step' ],
					'condition' => [
						'step_individual_styles' => 'yes'
					]
				],
				'title' => [
					'controls' => [
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-t-color',
							'apply_prop_to_el' => true
						],
					],
					'selector' => '{{CURRENT_ITEM}}.lqd-steps-step',
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{CURRENT_ITEM}}.lqd-steps-step' ],
					'condition' => [
						'step_individual_styles' => 'yes'
					]
				],
				'description' => [
					'controls' => [
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-d-color',
						],
					],
					'selector' => '{{CURRENT_ITEM}}.lqd-steps-step',
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{CURRENT_ITEM}}.lqd-steps-step' ],
					'condition' => [
						'step_individual_styles' => 'yes'
					]
				],
				'connector' => [
					'controls' => [
						[
							'type' => 'width',
							'css_var' => '--lqd-step-connector-w'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-step-connector-bg'
						],
					],
					'selector' => '{{CURRENT_ITEM}}.lqd-steps-step',
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{CURRENT_ITEM}}.lqd-steps-step' ],
					'condition' => [
						'step_individual_styles' => 'yes'
					]
				],
			],
			true
		);

		$this->add_control(
			'steps_list',
			[
				'label' => esc_html__( 'Steps list', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $steps_repeater->get_controls(),
				'default' => [
					[
						'step_title' => esc_html__( 'Sign up for free.', 'aihub-core' ),
						'step_description' => esc_html__( 'To be able to create an account, input your email address and password.', 'aihub-core' ),
					],
					[
						'step_title' => esc_html__( 'Select a Template', 'aihub-core' ),
						'step_description' => esc_html__( 'Our tools can help you produce everything from product descriptions and blog posts to email newsletters and social media updates.', 'aihub-core' ),
					],
					[
						'step_title' => esc_html__( 'Describe your Idea', 'aihub-core' ),
						'step_description' => esc_html__( 'Simply input some basic information about your brand or product, and let our AI algorithms do the rest.', 'aihub-core' ),
					],
				],
				'title_field' => '{{{ step_title }}}',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title element tag', 'aihub-core' ),
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
				'default' => 'h5',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'steps_layout',
			[
				'label' => esc_html__( 'Layout', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'vertical' => [
						'title' => esc_html__( 'Vertical', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-v'
					],
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-h'
					],
				],
				'default' => 'vertical',
				'toggle' => false,
				'prefix_class' => 'lqd-steps-layout-',
			]
		);

		$this->add_control(
			'enable_zigzag',
			[
				'label' => esc_html__( 'Zig zag layout?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'lqd-steps-layout-vertical-',
				'return_value' => 'zigzag',
				'condition' => [
					'steps_layout' => 'vertical'
				],
			]
		);

		$this->add_control(
			'steps_decorator',
			[
				'label' => esc_html__( 'Decorator', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => [
						'title' => esc_html__( 'none', 'aihub-core' ),
					],
					'blob' => [
						'title' => esc_html__( 'Blob', 'aihub-core' ),
					],
				],
				'default' => '',
				'prefix_class' => 'lqd-steps-decorator-',
				'condition' => [
					'steps_layout' => 'vertical',
					'enable_zigzag' => 'zigzag'
				]
			]
		);

		$this->add_control(
			'indicator_pos',
			[
				'label' => esc_html__( 'Indicators position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'top', 'aihub-core' ),
						'icon' => 'eicon-icon-box'
					],
					'inline' => [
						'title' => esc_html__( 'Inline with content', 'aihub-core' ),
						'icon' => 'eicon-email-field'
					],
				],
				'default' => 'inline',
				'prefix_class' => 'lqd-steps-indicator-pos-',
				'toggle' => false,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'steps_connector',
			[
				'label' => esc_html__( 'Connector', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'aihub-core' ),
					'line' => esc_html__( 'Line', 'aihub-core' ),
				],
				'default' => 'line',
				'prefix_class' => 'lqd-steps-connector-',
				'condition' => [
					'steps_layout' => 'vertical',
					'enable_zigzag' => '',
					'indicator_pos' => 'inline'
				]
			]
		);

		$this->add_responsive_control(
			'align_items',
			[
				'label' => esc_html_x( 'Align items', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'description' => esc_html_x( 'This option works when there are items with uneven heights.', 'aihub-core' ),
				'options' => [
					'flex-start' => [
						'title' => esc_html_x( 'Start', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-start-v',
					],
					'center' => [
						'title' => esc_html_x( 'Center', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-center-v',
					],
					'flex-end' => [
						'title' => esc_html_x( 'End', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-end-v',
					],
					'stretch' => [
						'title' => esc_html_x( 'Stretch', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-stretch-v',
					],
				],
				'default' => 'stretch',
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'steps_layout' => 'horizontal'
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Text align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-steps-step' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'indicator_pos' => 'top'
				],
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'steps',
			[
				'step' => [
					'controls' => [
						[
							'type' => 'typography'
						],
						[
							'type' => 'width',
							'css_var' => '--lqd-step-w',
							'default' => [
								'unit' => '%',
								'size' => 31.33
							],
							'condition' => [
								'steps_layout' => 'horizontal'
							],
						],
						[
							'type' => 'gap',
							'default' => [
								'unit' => '%',
								'size' => 3
							],
							'css_var' => '--lqd-steps-gap',
							'condition' => [
								'steps_decorator!' => 'blob'
							]
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-step-m',
							'condition' => [
								'steps_decorator!' => 'blob'
							]
						],
						[
							'type' => 'slider',
							'name' => 'blob_border_width',
							'label' => 'Blob border width',
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 1,
									'max' => 20
								]
							],
							'css_var' => '--lqd-step-brw',
							'condition' => [
								'enable_zigzag' => 'zigzag',
								'steps_decorator' => 'blob',
							]
						],
						[
							'type' => 'slider',
							'name' => 'blob_border_radius',
							'label' => 'Blob roundness',
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 1,
									'max' => 50
								]
							],
							'css_var' => '--lqd-step-brr',
							'condition' => [
								'enable_zigzag' => 'zigzag',
								'steps_decorator' => 'blob',
							]
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-step-p',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-color',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-step-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-step-br',
							'condition' => [
								'steps_decorator!' => 'blob'
							]
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-step-brr',
							'condition' => [
								'steps_decorator!' => 'blob'
							]
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-step-bs',
						],
					],
					'state_tabs' => [ 'normal', 'hover' ]
				],
				'indicator_wrap' => [
					'label' => 'Indicator',
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'liquid_linked_dimensions',
							'css_var' => '--lqd-step-ind'
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-step-ind-m',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-ind-color',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-step-ind-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-step-ind-br',
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-step-ind-brr',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-step-ind-bs',
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '.lqd-steps-step' ]
				],
				'title' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-step-t-m',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-t-color',
							'apply_prop_to_el' => true
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '.lqd-steps-step' ]
				],
				'description' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-step-d-m',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-step-d-color',
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '.lqd-steps-step' ]
				],
				'connector' => [
					'controls' => [
						[
							'type' => 'width',
							'css_var' => '--lqd-step-connector-w'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-step-connector-bg'
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '.lqd-steps-step' ]
				],
			],
		);

	}

	protected function render_step_indicator_number( $step, $index ) {

		?>

		<span class="lqd-step-indicator lqd-step-indicator-number transition-all"><?php
			echo esc_html( $index + 1 );
		?></span>

		<?php

	}

	protected function render_step_indicator_icon( $step, $index ) {

		?>

		<span class="lqd-step-indicator lqd-step-indicator-icon transition-all"><?php
			\LQD_Elementor_Helper::render_icon( $step['step_indicator_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		?></span>

		<?php

	}

	protected function render_step_indicator_custom_text( $step, $index ) {

		$text = $step['step_indicator_custom_text'];

		if ( empty( $text ) ) return;

		?>

		<span class="lqd-step-indicator lqd-step-indicator-custom-text transition-all"><?php
			echo esc_html( $text );
		?></span>

		<?php

	}

	protected function render_step_indicator( $step, $index ) {

		$indicator_type = $step['step_indicator'];

		if ( $indicator_type === 'none' ) return;

		?>

		<div class="lqd-steps-indicator-wrap inline-flex items-center justify-center shrink-0 grow-0 transition-all"><?php
			$this->{ 'render_step_indicator_' . $indicator_type }( $step, $index );
		?></div>

		<?php

	}

	protected function render_step_title_and_description( $step, $index ) {

		$title_tag = $this->get_settings_for_display('title_tag');
		$title = $step['step_title'];
		$description = $step['step_description'];

		$title_attrs_id = $this->get_repeater_setting_key( 'step_title', 'steps_list', $index );
		$description_attrs_id = $this->get_repeater_setting_key( 'step_description', 'steps_list', $index );

		$this->add_render_attribute( $title_attrs_id, [
			'class' => [ 'lqd-steps-title', 'transition-colors' ]
		] );
		$this->add_render_attribute( $description_attrs_id, [
			'class' => [ 'lqd-steps-description', 'transition-colors' ]
		] );

		if ( empty( $title ) && empty( $description ) ) return;

		?>

		<div class="lqd-steps-content"><?php

			if ( !empty( $title ) ) {
				echo sprintf(
					'<%1$s %2$s>%3$s</%1$s>',
					Utils::validate_html_tag( $title_tag ),
					$this->get_render_attribute_string( $title_attrs_id ),
					$title
				);
			}

			if ( !empty( $description ) ) {
				echo sprintf(
					'<div %1$s>%2$s</div>',
					$this->get_render_attribute_string( $description_attrs_id ),
					$description
				);
			}

		?></div>

		<?php

	}

	protected function render_step( $step, $index = 0 ) {

		$steps_layout = $this->get_settings_for_display('steps_layout');
		$indicator_pos = $this->get_settings_for_display('indicator_pos');
		$step_attrs_id = $this->get_repeater_setting_key( 'step', 'steps_list', $index );
		$step_classnames = [ 'lqd-steps-step', 'relative', 'elementor-repeater-item-' . $step['_id'] ];
		$decorator = $this->get_settings_for_display('steps_decorator');
		$is_blob_style = $steps_layout === 'vertical' && $decorator === 'blob';

		if ( $indicator_pos === 'inline' ) {
			if ( $is_blob_style ) {
				$step_classnames[] = 'inline-flex';
			} else {
				$step_classnames[] = 'flex';
			}
		}

		if ( $is_blob_style ) {
			$step_classnames[] = 'justify-center';
		}

		$this->add_render_attribute( $step_attrs_id, [
			'class' => $step_classnames
		] );

		?>

			<div <?php $this->print_render_attribute_string( $step_attrs_id ); ?>>
				<?php if ( $is_blob_style ) :?>
				<span class="lqd-step-blob-span lqd-step-blob-span-first w-full absolute z-0 pointer-events-none"></span>
				<?php endif; ?>
				<?php
					$this->render_step_indicator( $step, $index );
					$this->render_step_title_and_description( $step, $index );
				?>
				<?php if ( $is_blob_style ) :?>
				<span class="lqd-step-blob-span lqd-step-blob-span-last w-full absolute z-0 pointer-events-none"></span>
				<?php endif; ?>
			</div>

		<?php

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$steps_list = $settings['steps_list'];

		if ( empty( $steps_list ) ) return;

		$step_index = 0;
		foreach ( $steps_list as $step ) {
			$this->render_step( $step, $step_index );
			$step_index++;
		}

	}


}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Steps() );