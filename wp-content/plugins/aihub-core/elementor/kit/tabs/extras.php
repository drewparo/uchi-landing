<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Extras extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-extras-kit';
	}

	public function get_title() {
		return __( 'Extras', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_custom_cursor',
			[
				'label' => esc_html__( 'Custom Cursor', 'aihub-core' ),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_cc',
			[
				'label' => esc_html__( 'Custom cursor', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'off',
			]
		);

		$this->add_control(
			'liquid_cc_inner_heading',
			[
				'label' => esc_html__( 'Inner Circle Options', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_inner_size',
			[
				'label' => esc_html__( 'Custom Cursor Inner size', 'aihub-core' ),
				'description' => esc_html__( 'Define the size of the inner custom cursor, For instance, 120px', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '7px',
				'placeholder' => '7px',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-size-inner: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_inner_circle_bg',
			[
				'label' => esc_html__( 'Inner Circle Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-bg: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_active_circle_color_bg',
			[
				'label' => esc_html__( 'Inner Circle Active Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-active-bg: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_outer_heading',
			[
				'label' => esc_html__( 'Outer Circle Options', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_hide_outer',
			[
				'label' => esc_html__( 'Hide Outer circle cursor', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => '',
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_outer_size',
			[
				'label' => esc_html__( 'Custom Cursor Outer size', 'aihub-core' ),
				'description' => esc_html__( 'Define the size of the outer custom cursor, For instance, 120px', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '35px',
				'placeholder' => '35px',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-size-outer: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
					'liquid_cc_hide_outer' => '',
				],
			]
		);

		$this->add_control(
			'liquid_cc_outer_active_border_width',
			[
				'label' => esc_html__( 'Outer Circle Active Border Width', 'aihub-core' ),
				'description' => esc_html__( 'Define the border width of outer circle when hovering over links, for instance, 3px', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '1px',
				'placeholder' => '1px',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-active-bw: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
					'liquid_cc_hide_outer' => '',
				],
			]
		);

		$this->add_control(
			'liquid_cc_outer_circle_bg',
			[
				'label' => esc_html__( 'Outer Circle Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-bc: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
					'liquid_cc_hide_outer' => '',
				],
			]
		);

		$this->add_control(
			'liquid_cc_active_circle_color_bc',
			[
				'label' => esc_html__( 'Outer Circle Active Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-active-bc: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
					'liquid_cc_hide_outer' => '',
				],
			]
		);

		$this->add_control(
			'liquid_cc_label_heading',
			[
				'label' => esc_html__( 'Labels', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_label_explore',
			[
				'label' => esc_html__( 'Images Custom Cursor Label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Explore', 'aihub-core' ),
				'placeholder' => esc_html__( 'Explore', 'aihub-core' ),
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_label_drag',
			[
				'label' => esc_html__( 'Carousels Custom Cursor Label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Drag', 'aihub-core' ),
				'placeholder' => esc_html__( 'Drag', 'aihub-core' ),
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_colors_heading',
			[
				'label' => esc_html__( 'Colors', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => esc_html__( 'Normal', 'aihub-core' ),
					'multiply' => esc_html__( 'Multiply', 'aihub-core' ),
					'screen' => esc_html__( 'Screen', 'aihub-core' ),
					'overlay' => esc_html__( 'Overlay', 'aihub-core' ),
					'darken' => esc_html__( 'Darken', 'aihub-core' ),
					'lighten' => esc_html__( 'Lighten', 'aihub-core' ),
					'color-dodge' => esc_html__( 'Color Dodge', 'aihub-core' ),
					'color-burn' => esc_html__( 'Color Burn', 'aihub-core' ),
					'hard-light' => esc_html__( 'Hard Light', 'aihub-core' ),
					'soft-light' => esc_html__( 'Soft Light', 'aihub-core' ),
					'difference' => esc_html__( 'Difference', 'aihub-core' ),
					'exclusion' => esc_html__( 'Exclusion', 'aihub-core' ),
					'hue' => esc_html__( 'Hue', 'aihub-core' ),
					'saturation' => esc_html__( 'Saturation', 'aihub-core' ),
					'color' => esc_html__( 'Color', 'aihub-core' ),
					'luminosity' => esc_html__( 'Luminosity', 'aihub-core' ),
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-blend-mode: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_active_circle_solid_color_txt',
			[
				'label' => esc_html__( 'Active Circle Text Color', 'aihub-core' ),
				'description' => esc_html__( 'Choose a color for the active circle of the custom cursor. The big circle when hovering over elements like carousel or portfolio.', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-active-circle-txt: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_active_circle_solid_color_bg',
			[
				'label' => esc_html__( 'Active Circle Background Color', 'aihub-core' ),
				'description' => esc_html__( 'Choose a background for the active circle of the custom cursor. The big circle when hovering over elements like carousel or portfolio.', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-active-circle-color: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_cc_active_arrow_color',
			[
				'label' => esc_html__( 'Active Arrow Color', 'aihub-core' ),
				'description' => esc_html__( 'Choose a color for the active arrow of the custom cursor.', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-cc-active-arrow-color: {{VALUE}}',
				],
				'condition' => [
					'liquid_cc' => 'on',
				],
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * Preloader
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_preloader',
			[
				'label' => esc_html__( 'Preloader', 'aihub-core' ),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_preloader',
			[
				'label' => esc_html__( 'Preloader', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'off',
			]
		);

		$this->add_control(
			'liquid_preloader_style',
			[
				'label' => esc_html__( 'Style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'curtain',
				'options' => [
					'curtain'  => esc_html__( 'Curtain', 'aihub-core' ),
					'fade'  => esc_html__( 'Fade', 'aihub-core' ),
					'sliding'  => esc_html__( 'Sliding', 'aihub-core' ),
					'spinner'  => esc_html__( 'Spinner', 'aihub-core' ),
					'spinner-classical'  => esc_html__( 'Spinner Classic', 'aihub-core' ),
					'dissolve'  => esc_html__( 'Dissolve', 'aihub-core' ),
				],
				'condition' => [
					'liquid_preloader' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_preloader_color',
			[
				'label' => esc_html__( 'Preloader Background Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
					{{WRAPPER}} .lqd-preloader-curtain-front,
					{{WRAPPER}} .lqd-preloader-sliding-el,
					{{WRAPPER}} .lqd-preloader-dissolve-el,
					{{WRAPPER}} .lqd-preloader-wrap
					' => 'background: {{VALUE}}',
				],
				'condition' => [
					'liquid_preloader' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_preloader_color2',
			[
				'label' => esc_html__( 'Preloader Background Color 2', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-preloader-curtain-back' => 'background: {{VALUE}}',
				],
				'condition' => [
					'liquid_preloader' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_elements_color',
			[
				'label' => esc_html__( 'Preloader Elements Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-preloader-dots-dot, {{WRAPPER}} .lqd-preloader-signal-circle' => 'background: {{VALUE}}',
				],
				'condition' => [
					'liquid_preloader' => 'on',
					'liquid_preloader_style' => [
						'dots',
						'signal',
					],
				],
			]
		);

		$this->add_control(
			'liquid_elements_color2',
			[
				'label' => esc_html__( 'Preloader Elements Color 2', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-spinner-circular circle' => 'stroke: {{VALUE}}',
				],
				'condition' => [
					'liquid_preloader' => 'on',
					'liquid_preloader_style' => 'spinner',
				],
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * Local Scroll
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_local_scroll',
			[
				'label' => esc_html__( 'Local Scroll', 'aihub-core' ),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_pagescroll_speed',
			[
				'label' => esc_html__( 'Local scroll speed (second)', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'liquid_pagescroll_offset',
			[
				'label' => esc_html__( 'Local scroll offset (px)', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * Back to Top
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_back_to_top',
			[
				'label' => esc_html__( 'Back to Top', 'aihub-core' ),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_back_to_top',
			[
				'label' => esc_html__( 'Back to Top', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'off',
			]
		);

		$this->add_control(
			'liquid_back_to_top_scroll_ind',
			[
				'label' => esc_html__( 'Back to Top Scroll Indicator', 'aihub-core' ),
				'description' => esc_html__( 'Add a scroll indicator inside the back to top button.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'off',
				'condition' => [
					'liquid_back_to_top' => 'on',
				],
			]
		);

		$this->end_controls_section();

		/*
		 *
		 * 404
		 *
		 */

		$this->start_controls_section(
			'section_' . $this->get_id() . '_404',
			[
				'label' => esc_html__( '404 page', 'aihub-core' ),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_error_404_title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '404', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your title here', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_error_404_subtitle',
			[
				'label' => esc_html__( 'Heading', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Looks like you are lost', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your subtitle here', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_error_404_content',
			[
				'label' => esc_html__( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'We can’t seem to find the page you’re looking for.', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your content here', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_error_404_enable_btn',
			[
				'label' => esc_html__( 'Button', 'aihub-core' ),
				'description' => esc_html__( 'Switch on to display the "back to home" button.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_error_404_btn_title',
			[
				'label' => esc_html__( 'Button Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Back to home', 'aihub-core' ),
				'condition' => [
					'liquid_error_404_enable_btn' => 'on',
				],
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_Extras( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-extras-kit', Liquid_Global_Extras::class );
	}
);
