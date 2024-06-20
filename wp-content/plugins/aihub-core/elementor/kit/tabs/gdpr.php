<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_GDPR extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-gdpr-kit';
	}

	public function get_title() {
		return __( 'GDPR Alert', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-lock-user';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_gdpr',
			[
				'label' => esc_html__( 'GDPR Alert', 'aihub-core' ),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_gdpr',
			[
				'label' => esc_html__( 'GDPR Alert', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'on', 'aihub-core' ),
				'label_off' => esc_html__( 'off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => ''
			]
		);

		$this->add_control(
			'liquid_gdpr_button',
			[
				'label' => esc_html__( 'Button Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Accept', 'aihub-core' ),
				'placeholder' => esc_html__( 'Accept', 'aihub-core' ),
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_gdpr_button_typo',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-gdpr-accept',
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->start_controls_tabs(
			'style_tabs'
		);

			$this->start_controls_tab(
				'style_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'aihub-core' ),
					'condition' => [
						'liquid_gdpr' => 'on',
					],
				]
			);

				$this->add_control(
					'liquid_gdpr_button_color',
					[
						'label' => esc_html__( 'Color', 'aihub-core' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .lqd-gdpr-accept' => 'color: {{VALUE}}',
						],
						'condition' => [
							'liquid_gdpr' => 'on',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'liquid_gdpr_button_bg',
						'label' => esc_html__( 'Box Background', 'aihub-core' ),
						'selector' => '{{WRAPPER}} .lqd-gdpr-accept',
						'types' => [ 'classic', 'gradient' ],
						'exclude' => [ 'image' ],
						'fields_options' => [
							'background' => [
								'default' => 'classic',
							],
						],
						'condition' => [
							'liquid_gdpr' => 'on',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'aihub-core' ),
					'condition' => [
						'liquid_gdpr' => 'on',
					],
				]
			);

				$this->add_control(
					'liquid_gdpr_button_hover_color',
					[
						'label' => esc_html__( 'Color', 'aihub-core' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .lqd-gdpr-accept:hover' => 'color: {{VALUE}}',
						],
						'condition' => [
							'liquid_gdpr' => 'on',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'liquid_gdpr_button_bg_hover',
						'label' => esc_html__( 'Box Background', 'aihub-core' ),
						'selector' => '{{WRAPPER}} .lqd-gdpr-accept:hover',
						'types' => [ 'classic', 'gradient' ],
						'exclude' => [ 'image' ],
						'fields_options' => [
							'background' => [
								'default' => 'classic',
							],
						],
						'condition' => [
							'liquid_gdpr' => 'on',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'liquid_gdpr_button_padding',
			[
				'label' => esc_html__( 'Button Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-gdpr-accept' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_gdpr_button_radius',
			[
				'label' => esc_html__( 'Button Border Radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-gdpr-accept' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_gdpr_hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_gdpr_content',
			[
				'label' => esc_html__( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This website uses cookies to improve your web experience.', 'aihub-core' ),
				'placeholder' => esc_html__( 'This website uses cookies to improve your web experience.', 'aihub-core' ),
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_gdpr_content_typo',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} #lqd-gdpr',
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_gdpr_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #lqd-gdpr' => 'color: {{VALUE}}',
				],
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Box Background', 'aihub-core' ),
				'selector' => '{{WRAPPER}} #lqd-gdpr',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_gdpr_box_padding',
			[
				'label' => esc_html__( 'GDPR Box Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #lqd-gdpr' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_gdpr_box_radius',
			[
				'label' => esc_html__( 'GDPR Box Border Radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #lqd-gdpr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'liquid_gdpr' => 'on',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'aihub-core' ),
				'selector' => '{{WRAPPER}} #lqd-gdpr',
				'condition' => [
					'liquid_gdpr' => 'on',
				],
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_GDPR( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-gdpr-kit', Liquid_Global_GDPR::class );
	}
);
