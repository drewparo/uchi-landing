<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Dark_Switch extends Widget_Base {

	public function get_name() {
		return 'lqd-dark-switch';
	}

	public function get_title() {
		return __( 'Liquid Dark Mode Switch', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-favorite lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'dark', 'dark mode', 'light', 'light mode', 'switch' ];
	}

	public function get_behavior() {
		$settings = $this->get_settings_for_display();
		$behavior = [];

		$behavior[] = [
			'behaviorClass' => 'LiquidSwitchBehavior',
			'options' => [
				'useLocalStorage' => 'true',
				'attrs' => [[
					[
						'key' => "'lqd-page-color-scheme'",
						'attr' => "'data-lqd-page-color-scheme'",
						'val' => [ 'on' => "'dark'", 'off' => "'light'" ],
						'el' => "'body'"
					]
				]]
			]
		];

		if ( $settings['lqd_adaptive_color'] === 'yes' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
				'options' => [
					'includeSelf' => 'true',
					'getRect' => 'true',
					'getStyles' => ["'position'"],
				]
			];
			$behavior[] = [
				'behaviorClass' => 'LiquidAdaptiveColorBehavior',
			];
		}

		return $behavior;
	}

	public function get_behavior_pageContent() {

		$settings = $this->get_settings_for_display();
		$adaptive_color = $settings['lqd_adaptive_color'];
		$behavior = [];

		if ( !$adaptive_color ){
			return $behavior;
		}

		$behavior[] = [
			'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
			'options' => [
				'includeChildren' => true,
				'includeSelf' => true,
				'getOnlyContainers' => true,
				'getStyles' => ["'backgroundColor'"],
				'getBrightnessOf' => ["'backgroundColor'"],
				'getRect' => true
			]
		];

		return $behavior;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'lqd_adaptive_color',
			[
				'label' => esc_html__( 'Enable adaptive color?', 'aihub-core' ),
				'description' => esc_html__( 'Useful for elements with fixed css position or when inside sticky header. This option make the element chage color dynamically when it is over light or dark sections.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'dark-switch',
			[
				'switch' => [
					'controls' => [
						[
							'type' => 'font_size',
							'css_var' => '--lqd-ds-fz'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'css_var' => '--lqd-ds'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-ds-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-ds-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-ds-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-ds-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-ds-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
				],
			],
		);

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$checkbox_id = 'lqd-switch-' . $this->get_id();
		$checkbox_attrs = $this->add_render_attribute( 'checkbox', [
			'id' => $checkbox_id,
			'class' => [ 'lqd-switch-checkbox' ],
			'type' => 'checkbox',
			'name' => $checkbox_id,
		] );

		?>

		<div class="lqd-dark-switch-switch relative overflow-hidden cursor-pointer transition-colors user-select-none">
			<input class="absolute w-0 h-0 invisible" <?php $this->print_render_attribute_string( 'checkbox' ); ?>>
			<label class="cursor-pointer grid w-full h-full place-content-center" for="<?php echo esc_attr( $checkbox_id ); ?>">
				<svg class="lqd-dark-switch-icon grid-area-1-1 transition-transform w-1em h-auto" data-dark-switch-icon="dark" fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 96 960 960" width="20" fill="currentColor"><path d="M480 936q-150 0-255-105T120 576q0-150 105-255t255-105q8 0 17 .5t23 1.5q-36 32-56 79t-20 99q0 90 63 153t153 63q52 0 99-18.5t79-51.5q1 12 1.5 19.5t.5 14.5q0 150-105 255T480 936Zm0-60q109 0 190-67.5T771 650q-25 11-53.667 16.5Q688.667 672 660 672q-114.689 0-195.345-80.655Q384 510.689 384 396q0-24 5-51.5t18-62.5q-98 27-162.5 109.5T180 576q0 125 87.5 212.5T480 876Zm-4-297Z"/></svg>
				<svg class="lqd-dark-switch-icon grid-area-1-1 transition-transform w-1em h-auto" data-dark-switch-icon="light" fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 96 960 960" width="20"><path d="M479.765 716Q538 716 579 675.235q41-40.764 41-99Q620 518 579.235 477q-40.764-41-99-41Q422 436 381 476.765q-41 40.764-41 99Q340 634 380.765 675q40.764 41 99 41Zm.235 60q-83 0-141.5-58.5T280 576q0-83 58.5-141.5T480 376q83 0 141.5 58.5T680 576q0 83-58.5 141.5T480 776ZM70 606q-12.75 0-21.375-8.675Q40 588.649 40 575.825 40 563 48.625 554.5T70 546h100q12.75 0 21.375 8.675 8.625 8.676 8.625 21.5 0 12.825-8.625 21.325T170 606H70Zm720 0q-12.75 0-21.375-8.675-8.625-8.676-8.625-21.5 0-12.825 8.625-21.325T790 546h100q12.75 0 21.375 8.675 8.625 8.676 8.625 21.5 0 12.825-8.625 21.325T890 606H790ZM479.825 296Q467 296 458.5 287.375T450 266V166q0-12.75 8.675-21.375 8.676-8.625 21.5-8.625 12.825 0 21.325 8.625T510 166v100q0 12.75-8.675 21.375-8.676 8.625-21.5 8.625Zm0 720q-12.825 0-21.325-8.62-8.5-8.63-8.5-21.38V886q0-12.75 8.675-21.375 8.676-8.625 21.5-8.625 12.825 0 21.325 8.625T510 886v100q0 12.75-8.675 21.38-8.676 8.62-21.5 8.62ZM240 378l-57-56q-9-9-8.629-21.603.37-12.604 8.526-21.5 8.896-8.897 21.5-8.897Q217 270 226 279l56 57q8 9 8 21t-8 20.5q-8 8.5-20.5 8.5t-21.5-8Zm494 495-56-57q-8-9-8-21.375T678.5 774q8.5-9 20.5-9t21 9l57 56q9 9 8.629 21.603-.37 12.604-8.526 21.5-8.896 8.897-21.5 8.897Q743 882 734 873Zm-56-495q-9-9-9-21t9-21l56-57q9-9 21.603-8.629 12.604.37 21.5 8.526 8.897 8.896 8.897 21.5Q786 313 777 322l-57 56q-8 8-20.364 8-12.363 0-21.636-8ZM182.897 873.103q-8.897-8.896-8.897-21.5Q174 839 183 830l57-56q8.8-9 20.9-9 12.1 0 20.709 9Q291 783 291 795t-9 21l-56 57q-9 9-21.603 8.629-12.604-.37-21.5-8.526ZM480 576Z"/></svg>
			</label>
		</div>

		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Dark_Switch() );