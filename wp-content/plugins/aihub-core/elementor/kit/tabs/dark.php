<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Dark_Colors extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-dark-kit';
	}

	public function get_title() {
		return __( 'Dark colors 🌘', 'aihub-core' );
	}

	public function get_group() {
		return 'global';
	}

	public function get_icon() {
		return 'eicon-circle';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$elementor_doc_selector = '.elementor-' . get_the_ID();
		$dark_selectors = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-btn, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-btn, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-btn';

		$this->start_controls_section(
			'section_' . $this->get_id() . '_general',
			[
				'label' => esc_html__('Dark colors 🌘', 'aihub-core'),
				'tab' => $this->get_id()
			]
		);

		$this->add_control(
			'lqd_dark_body_color_heading',
			[
				'label' => esc_html__( 'Body', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'lqd_dark_body_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark]' => '--lqd-body-text-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_body_background',
				'label' => esc_html__( 'Default dark background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'selector' => '[data-lqd-page-color-scheme=dark], {{WRAPPER}}[data-lqd-page-color-scheme=dark]'
			]
		);

		$this->add_control(
			'lqd_dark_container_color_heading',
			[
				'label' => esc_html__( 'Containers', 'aihub-core' ),
				'separator' => 'before',
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'lqd_dark_container_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} [data-lqd-color-scheme=dark].e-con' => '--lqd-container-text-color: {{VALUE}}; color: var(--lqd-container-text-color)',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_container_background',
				'label' => esc_html__( 'Default dark background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'selector' => '{{WRAPPER}} [data-lqd-color-scheme=dark].e-con'
			]
		);

		$this->add_control(
			'lqd_dark_link_color_heading',
			[
				'label' => esc_html__( 'Links', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'lqd_dark_link_color_tabs',
		);

		$this->start_controls_tab(
			'lqd_dark_link_color_normal_tab',
			[
				'label'   => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_link_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] a, {{WRAPPER}} [data-lqd-color-scheme=dark] a' => '--lqd-link-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_link_opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
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
					'[data-lqd-page-color-scheme=dark] a, {{WRAPPER}} [data-lqd-color-scheme=dark] a' => '--lqd-link-op: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lqd_dark_link_color_hover_tab',
			[
				'label'   => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_link_color_hover',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] a:hover, {{WRAPPER}} [data-lqd-color-scheme=dark] a:hover' => '--lqd-link-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_link_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
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
					'[data-lqd-page-color-scheme=dark] a:hover, {{WRAPPER}} [data-lqd-color-scheme=dark] a:hover' => '--lqd-link-op: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lqd_dark_link_color_active_tab',
			[
				'label'   => esc_html__( 'Active', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_link_color_active',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] a.lqd-is-active, [data-lqd-page-color-scheme=dark] a.current-menu-item, [data-lqd-page-color-scheme=dark] a.current-menu-parent, {{WRAPPER}} [data-lqd-color-scheme=dark] a.lqd-is-active, {{WRAPPER}} [data-lqd-color-scheme=dark] a.current-menu-item, {{WRAPPER}} [data-lqd-color-scheme=dark] a.current-menu-parent' => '--lqd-link-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'lqd_dark_button_color_heading',
			[
				'label' => esc_html__( 'Buttons', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'lqd_dark_button_color_tabs',
		);

		$this->start_controls_tab(
			'lqd_dark_button_color_normal_tab',
			[
				'label'   => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_button_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] .lqd-btn, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-btn' => '--lqd-btn-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_button_background',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'css_attr' => '--lqd-btn-bg',
				'selector' => '[data-lqd-page-color-scheme=dark] .lqd-btn, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-btn'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lqd_dark_button_color_hover_tab',
			[
				'label'   => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_button_color_hover',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] .lqd-btn:hover, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-btn:hover' => '--lqd-btn-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_button_background_hover',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'css_attr' => '--lqd-btn-bg',
				'selector' => '[data-lqd-page-color-scheme=dark] .lqd-btn:hover, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-btn:hover'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lqd_dark_button_color_active_tab',
			[
				'label'   => esc_html__( 'Active', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_button_color_active',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] .lqd-btn.lqd-is-active, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-btn.lqd-is-active' => '--lqd-btn-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_button_background_active',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'css_attr' => '--lqd-btn-bg',
				'selector' => '[data-lqd-page-color-scheme=dark] .lqd-btn.lqd-is-active, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-btn.lqd-is-active'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'lqd_dark_widget_trigger_color_heading',
			[
				'label' => esc_html__( 'Widget triggers', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'lqd_dark_widget_trigger_color_tabs',
		);

		$this->start_controls_tab(
			'lqd_dark_widget_trigger_color_normal_tab',
			[
				'label'   => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_widget_trigger_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] .lqd-widget-trigger, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-widget-trigger' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_widget_trigger_background',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'selector' => '[data-lqd-page-color-scheme=dark] .lqd-widget-trigger, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-widget-trigger'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lqd_dark_widget_trigger_color_hover_tab',
			[
				'label'   => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_widget_trigger_color_hover',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] .lqd-widget-trigger:hover, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-widget-trigger:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_widget_trigger_background_hover',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'selector' => '[data-lqd-page-color-scheme=dark] .lqd-widget-trigger:hover, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-widget-trigger:hover'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lqd_dark_widget_trigger_color_active_tab',
			[
				'label'   => esc_html__( 'Active', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_dark_widget_trigger_color_active',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark] .lqd-widget-trigger.lqd-is-active, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-widget-trigger.lqd-is-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'lqd_dark_widget_trigger_background_active',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'type' => 'liquid-background-css',
				'selector' => '[data-lqd-page-color-scheme=dark] .lqd-widget-trigger.lqd-is-active, {{WRAPPER}} [data-lqd-color-scheme=dark] .lqd-widget-trigger.lqd-is-active'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'lqd_dark_heading_color_heading',
			[
				'label' => esc_html__( 'Headings common color', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_dark_heading_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark], {{WRAPPER}} [data-lqd-color-scheme=dark]' => '--lqd-heading-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_h1_color_heading',
			[
				'label' => esc_html__( 'H1', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_dark_h1_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark], {{WRAPPER}} [data-lqd-color-scheme=dark]' => '--lqd-h1-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_h2_color_heading',
			[
				'label' => esc_html__( 'H2', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_dark_h2_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark], {{WRAPPER}} [data-lqd-color-scheme=dark]' => '--lqd-h2-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_h3_color_heading',
			[
				'label' => esc_html__( 'H3', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_dark_h3_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark], {{WRAPPER}} [data-lqd-color-scheme=dark]' => '--lqd-h3-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_h4_color_heading',
			[
				'label' => esc_html__( 'H4', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_dark_h4_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark], {{WRAPPER}} [data-lqd-color-scheme=dark]' => '--lqd-h4-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_h5_color_heading',
			[
				'label' => esc_html__( 'H5', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_dark_h5_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark], {{WRAPPER}} [data-lqd-color-scheme=dark]' => '--lqd-h5-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lqd_dark_h6_color_heading',
			[
				'label' => esc_html__( 'H6', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_dark_h6_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'[data-lqd-page-color-scheme=dark], {{WRAPPER}} [data-lqd-color-scheme=dark]' => '--lqd-h6-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Dark_Colors( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-dark-kit', Liquid_Dark_Colors::class );
	}
);