<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Button extends Widget_Base {

	public function get_name() {
		return 'lqd-button';
	}

	public function get_title() {
		return __( 'Liquid Button', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-button lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'button', 'btn', 'localscroll', 'link' ];
	}

	public function get_behavior() {
		$settings = $this->get_settings_for_display();
		$behavior = [];

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

		lqd_elementor_add_button_controls($this, ''); // load button

	}

	protected function render() {

		\LQD_Elementor_Render_Button::get_button( $this );

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Button() );