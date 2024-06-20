<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Counter extends Widget_Base {

	public function get_name() {
		return 'lqd-counter';
	}

	public function get_title() {
		return __( 'Liquid Counter', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-counter lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'counter', 'numbers' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$use_locale_string = $settings['use_locale_string'];

		if ( $settings['dynamic_counter'] === 'yes' ) {
			$range = [];
			$dynamic_counter_list = $settings['dynamic_counter_list'];

			if ( !empty( $dynamic_counter_list ) ) {
				foreach ( $dynamic_counter_list as $count_item ) {
					$counter_label = $count_item['counter_label'];
					$counter_value = $count_item['counter_value'];
					if ( empty( $counter_label ) || empty( $counter_value ) ) {
						continue;
					}
					$range["'" . $counter_label . "'"] = "'" . $counter_value . "'";
				}
			}

			$behavior[] = [
				'behaviorClass' => 'LiquidDynamicRangeBehavior',
				'options' => [
					'range' => $range,
					'el' => "'.lqd-counter-el:not(.lqd-counter-placeholder)'",
					'placeholderEl' => "'.lqd-counter-placeholder'",
					'hideElsIfNan' => "'.lqd-counter-prefix, .lqd-counter-suffix'",
					'useLocaleString' => $use_locale_string === 'yes' ? 1 : 0
				]
			];
		} else {
			$counter_options = [];

			if ( !empty( $settings['count_from'] ) ) {
				$counter_options['countFrom'] = $settings['count_from'];
			} else {
				$counter_options['countFrom'] = 0;
			}
			if ( !empty( $settings['count_to'] ) ) {
				$counter_options['countTo'] = $settings['count_to'];
			}
			if ( empty( $settings['use_locale_string'] ) ) {
				$counter_options['useLocaleString'] = false;
			}
			if ( !empty( $settings['count_duration'] ) ) {
				$counter_options['duration'] = $settings['count_duration'];
			}
			if ( !empty( $settings['count_delay'] ) ) {
				$counter_options['delay'] = $settings['count_delay'];
			}

			if ( $settings['dynamic_counter'] === 'yes' ) {
				$first_dynamic_counter_item = $settings['dynamic_counter_list'][0];
				if (
					isset( $first_dynamic_counter_item['counter_value'] ) &&
					!empty( $first_dynamic_counter_item['counter_value'] )
				) {
					$counter_options['countTo'] = $first_dynamic_counter_item['counter_value'];
				}
			}

			$behavior[] = [
				'behaviorClass' => 'LiquidCounterBehavior',
				'options' => $counter_options
			];
		}


		return $behavior;

	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'count_from',
			[
				'label' => __( 'Start from', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0
			]
		);

		$this->add_control(
			'count_to',
			[
				'label' => __( 'Counter', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1069,
				'condition' => [
					'dynamic_counter' => ''
				]
			]
		);

		$this->add_control(
			'dynamic_counter',
			[
				'label' => esc_html__( 'Enable dynamic counter', 'aihub-core' ),
				'description' => esc_html__( 'Controling values with Liquid Dynamic Range widget.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$dynamic_counter_repeater = new Repeater();

		$dynamic_counter_repeater->add_control(
			'counter_label',
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

		$dynamic_counter_repeater->add_control(
			'counter_value',
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

		$this->add_control(
			'dynamic_counter_list',
			[
				'label' => esc_html__( 'Dynamic counters', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $dynamic_counter_repeater->get_controls(),
				'default' => [
					[
						'counter_label' => esc_html__( '50k', 'aihub-core' ),
						'counter_value' => esc_html__( '6.90', 'aihub-core' ),
					],
					[
						'counter_label' => esc_html__( '100k', 'aihub-core' ),
						'counter_value' => esc_html__( '9.90', 'aihub-core' ),
					],
					[
						'counter_label' => esc_html__( '150k', 'aihub-core' ),
						'counter_value' => esc_html__( '12.90', 'aihub-core' ),
					],
					[
						'counter_label' => esc_html__( '200k', 'aihub-core' ),
						'counter_value' => esc_html__( '15.90', 'aihub-core' ),
					],
					[
						'counter_label' => esc_html__( '500k', 'aihub-core' ),
						'counter_value' => esc_html__( '19.90', 'aihub-core' ),
					],
				],
				'title_field' => 'Label: {{{ counter_label }}}. Value: {{{ counter_value }}}',
				'condition' => [
					'dynamic_counter' => 'yes'
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'use_locale_string',
			[
				'label' => esc_html__( 'Use locale string?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'count_duration',
			[
				'label' => __( 'Counting animation duration', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'placeholder' => 2.5,
			]
		);

		$this->add_control(
			'count_delay',
			[
				'label' => __( 'Counting animation delay', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'placeholder' => 0,
			]
		);

		$this->add_control(
			'counter_prefix',
			[
				'label' => __( 'Counter prefix', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Prefix shows before the counter number', 'aihub-core' ),
			]
		);

		$this->add_control(
			'counter_suffix',
			[
				'label' => __( 'Counter suffix', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Suffix shows after the counter number', 'aihub-core' ),
			]
		);

		$this->add_responsive_control(
			'text_align',
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
				],
				'default' => 'center',
				'selectors_dictionary' => [
					'left' => 'start',
					'right' => 'end',
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} > .elementor-widget-container' => 'justify-content: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'lqd_counter_tag',
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
				'default' => 'div',
				'render_type' => 'template',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'counter',
			[
				'counter' => [
					'controls' => [
						[
							'type' => 'typography'
						],
						[
							'type' => 'gap',
							'css_var' => '--lqd-counter-gap',
						],
						[
							'type' => 'liquid_color',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'selector' => '.lqd-counter-wrap'
				],
				'prefix' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-counter-prefix-color',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'suffix' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-counter-suffix-color',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
			],
		);

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$count_from = $settings['count_from'] || 0;
		$count_to = $settings['count_to'];
		$use_locale_string = $settings['use_locale_string'];
		$counter_classnames = [ 'lqd-counter-el', 'flex' ];
		$tag = Utils::validate_html_tag( $settings['lqd_counter_tag'] );

		if ( $settings['dynamic_counter'] === 'yes' ) {
			$first_dynamic_counter_item = $settings['dynamic_counter_list'][0];
			if (
				isset( $first_dynamic_counter_item['counter_value'] ) &&
				!empty( $first_dynamic_counter_item['counter_value'] )
			) {
				$count_to = $first_dynamic_counter_item['counter_value'];
			}
		}

		if ( $use_locale_string === 'yes' ) {
			$locale = locale_accept_from_http( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] );
			$fmt = numfmt_create( $locale, NumberFormatter::DECIMAL );
			$count_to = numfmt_format($fmt, $count_to);
			$count_from = numfmt_format($fmt, $count_from);
		} else {
			$count_to = esc_html( $count_to );
			$count_from = esc_html( $count_from );
		}

		$this->add_render_attribute( 'counter_placeholder', [
			'class' => array_merge( $counter_classnames, [ 'lqd-counter-placeholder', 'invisible' ] ),
		]);
		$this->add_render_attribute( 'counter', [
			'class' => array_merge( $counter_classnames, [ 'absolute', 'top-0', 'left-0', 'w-full', 'h-full', 'whitespace-nowrap' ] ),
			'data-lqd-counter-el' => 'true'
		]);

		?><<?php echo $tag ?> class="lqd-counter-wrap flex m-0"><?php
			if ( !empty( $settings['counter_prefix'] ) ) {
				printf(
					'<span class="lqd-counter-prefix">%1$s</span>',
					esc_html($settings['counter_prefix'])
				);
			}
			?><span class="lqd-counter-count block relative"><?php
				printf(
					'<span %1$s>%2$s</span>',
					$this->get_render_attribute_string( 'counter_placeholder' ),
					$count_to
				);
				printf(
					'<span %1$s>%2$s</span>',
					$this->get_render_attribute_string( 'counter' ),
					$count_from
				);
			?></span><?php
			if ( !empty( $settings['counter_suffix'] ) ) {
				printf(
					'<span class="lqd-counter-suffix">%1$s</span>',
					esc_html($settings['counter_suffix'])
				);
			}
		?></<?php echo $tag ?>><?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Counter() );