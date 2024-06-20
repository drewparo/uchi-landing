<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Dynamic_Range extends Widget_Base {

	public function get_name() {
		return 'lqd-dynamic-range';
	}

	public function get_title() {
		return __( 'Liquid Dynamic Range', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-slides lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'range', 'slider', 'dynamic' ];
	}

	public function get_utility_classnames() {
		return [];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$opts = [];

		if ( !empty( $settings['initial_value'] ) ) {
			$opts['set'] = ["'" . $settings['initial_value'] . "'"];
		}

		if ( !empty( $settings['dynamic_widgets_ids'] ) ) {
			$opts['getValuesFrom'] = "'" . $settings['dynamic_widgets_ids'] . "'";
		}

		$behavior = [];
		$behavior[] = [
			'behaviorClass' => 'LiquidRangeBehavior',
			'options' => $opts
		];

		return $behavior;

	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'initial_value',
			[
				'label' => esc_html__( 'Initial value', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'dynamic_widgets_ids',
			[
				'label' => esc_html__( 'IDs of widgets with dynamic numbers', 'aihub-core' ),
				'description' => esc_html__( 'By default, all widgets with dynamic numbers within the same container are automatically discovered. Otherwise you can put the ids of elements you want to interact with here. IDs must be without the #.', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => esc_html__( 'price-table-1, dynamic-counter', 'aihub-core' ),
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'range',
			[
				'range' => [
					'controls' => [
						[
							'type' => 'typography',
							'name' => 'labels_typography',
							'label' => 'Labels typography',
							'selector' => '.lqd-range-container',
						],
						[
							'type' => 'width',
							'css_var' => '--lqd-range-w',
						],
						[
							'type' => 'liquid_linked_dimensions',
							'name' => 'handle_dimensions',
							'css_var' => '--lqd-range-handle',
						],
						[
							'type' => 'border_radius',
							'name' => 'handle_border_radius',
							'label' => 'Handle border radius',
							'css_var' => '--lqd-range-handle-brr'
						],
						[
							'type' => 'height',
							'name' => 'track_height',
							'label' => 'Track height',
							'css_var' => '--lqd-range-track-h',
						],
						[
							'type' => 'border_radius',
							'name' => 'track_border_radius',
							'label' => 'Track border radius',
							'css_var' => '--lqd-range-track-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-range-track-bs'
						],
						[
							'type' => 'liquid_color',
							'name' => 'labels_color',
							'label' => 'Labels color',
							'css_var' => '--lqd-range-labels-color',
							'separator' => 'before'
						],
						[
							'type' => 'liquid_color',
							'name' => 'handle_color',
							'label' => 'Handle arrow color',
							'css_var' => '--lqd-range-handle-color',
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'handle_background',
							'css_var' => '--lqd-range-handle-bg',
							'apply_other_bg_props_to' => '.lqd-range-handle',
							'fields_options' => [
								'background' => [
									'label' => __( 'Handle background', 'aihub-core' ),
								]
							]
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'track_background',
							'css_var' => '--lqd-range-track-bg',
							'apply_other_bg_props_to' => '.lqd-range-track',
							'fields_options' => [
								'background' => [
									'label' => __( 'Track background', 'aihub-core' ),
								]
							]
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'track_fill_background',
							'css_var' => '--lqd-range-track-active-bg',
							'apply_other_bg_props_to' => '.lqd-range-selected',
							'fields_options' => [
								'background' => [
									'label' => __( 'Track filled background', 'aihub-core' ),
								]
							]
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'track_span_background',
							'css_var' => '--lqd-range-scale-span-bg',
							'apply_other_bg_props_to' => '.lqd-range-scale-span',
							'fields_options' => [
								'background' => [
									'label' => __( 'Track spans background', 'aihub-core' ),
								]
							]
						],
					],
					'plural_heading' => false
				],
			],
		);

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>

		<input type="text" class="lqd-range-input hidden">
		<div class="lqd-range-container flex items-center relative cursor-pointer">
			<div class="lqd-range-bg lqd-range-track grow">
				<div class="lqd-range-selected w-0 h-full absolute top-0 start-0 rounded-inherit transition-all"></div>
			</div>
			<div class="lqd-range-scale flex items-end w-full h-full absolute start-0 z-1 whitespace-nowrap"></div>
			<div class="lqd-range-handle flex items-center justify-center absolute top-1/2 z-1 lqd-transform -translate-y-1/2 transition-all" data-dir="start">
				<span class="lqd-range-tooltip absolute start-1/2 lqd-transform -translate-x-1/2 -translate-y-1/2 text-center transition-all" data-dir="start"></span>
			</div>
		</div>

		<?php

	}


}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Dynamic_Range() );