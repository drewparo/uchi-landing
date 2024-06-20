<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Sizes extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-sizes-kit';
	}

	public function get_title() {
		return __( 'Global Sizes', 'aihub-core' );
	}

	public function get_group() {
		return 'global';
	}

	public function get_icon() {
		return 'eicon-shape';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_general',
			[
				'label' => esc_html__('Global Sizes', 'aihub-core'),
				'tab' => $this->get_id()
			]
		);

		$this->add_responsive_control(
			'liquid_global_heading_size_xs',
			[
				'label' => esc_html__( 'Extra small heading size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-global-size-heading-xs: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_global_heading_size_sm',
			[
				'label' => esc_html__( 'Small heading size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-global-size-heading-sm: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_global_heading_size_lg',
			[
				'label' => esc_html__( 'Large heading size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-global-size-heading-lg: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_global_heading_size_xl',
			[
				'label' => esc_html__( 'Extra large heading size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-global-size-heading-xl: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'liquid_global_heading_size_2xl',
			[
				'label' => esc_html__( '2 Extra large heading size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-global-size-heading-2xl: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

	}

}

// new Liquid_Global_Sizes( Kit::class );

// add_action(
// 	'elementor/kit/register_tabs',
// 	function( $kit ) {
// 		$kit->register_tab( 'liquid-sizes-kit', Liquid_Global_Sizes::class );
// 	}
// );
