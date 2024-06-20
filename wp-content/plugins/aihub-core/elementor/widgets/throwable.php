<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Throwable extends Widget_Base {

	// public function __construct($data = [], $args = null) {
	// 	parent::__construct($data, $args);

	// 	wp_register_script( 'matter',
	// 		get_template_directory_uri() . '/assets/vendors/matter/matter.min.js',
	// 		[ 'jquery' ],
	// 		LQD_CORE_VERSION,
	// 		true
	// 	);

	// }

	public function get_name() {
		return 'lqd-throwable';
	}

	public function get_title() {
		return __( 'Liquid Throwable', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-form-vertical lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'throwable', 'animation' ];
	}

	public function get_script_depends() {
		return [ 'matter' ];
	}

	public function get_behavior() {
		$behavior = [
			[
				'behaviorClass' => 'LiquidThrowableBehavior',
			]
		];

		return $behavior;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Throwable', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'vh',
					'size' => 80,
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tag',
			[
				'label' => esc_html__( 'HTML Tag', 'elementor-pro' ),
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
				'default' => 'p',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'roundness',
			[
				'label' => esc_html__( 'Roundness', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '7em',
				'options' => [
					'0'  => esc_html__( 'Sharp', 'aihub-core' ),
					'7em' => esc_html__( 'Circle', 'aihub-core' ),
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lqd-throwable-element-rot' => 'border-radius: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0.25',
					'right' => '1.5',
					'bottom' => '0.25',
					'left' => '1.5',
					'unit' => 'em',
					'isLinked' => false
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lqd-throwable-element-rot' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'items_typography',
				'selector' => '{{WRAPPER}} .lqd-throwable-element-rot',
			]
		);

		$this->add_control(
			'items_text_color',
			[
				'label' => esc_html__( 'Text Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-throwable-element-rot' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'items_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'selectors' => [
					'{{WRAPPER}} .lqd-throwable-element-rot' => 'background: {{VALUE}}',
				],
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'label', [
				'label' => esc_html__( 'Label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Label' , 'aihub-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tag',
			[
				'label' => esc_html__( 'HTML Tag', 'elementor-pro' ),
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
					'default' => 'Default'
				],
				'default' => 'default',
			]
		);

		$repeater->add_control(
			'textColor',
			[
				'label' => esc_html__( 'Text Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-throwable-element-rot' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'itembgColor',
			[
				'label' => esc_html__( 'Background Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-throwable-element-rot' => 'background: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-throwable-element-rot' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'label' => 'Awesome',
						'itembgColor' => '#a7ff9f',
						'textColor' => '#000',
					],
					[
						'label' => 'Accelerate',
						'itembgColor' => '#ffe3d3',
						'textColor' => '#000',
					],
					[
						'label' => 'Amazing',
						'itembgColor' => '#dbefe8',
						'textColor' => '#000',
					],
					[
						'label' => 'Quickly',
						'itembgColor' => '#d8c0ff',
						'textColor' => '#000',
					],
					[
						'label' => 'Increase response',
						'itembgColor' => '#8330c2',
						'textColor' => '#fff',
					],
					[
						'label' => 'Easily integrate',
						'itembgColor' => '#eaeaea',
						'textColor' => '#000',
					],
					[
						'label' => 'Personalized',
						'itembgColor' => '#ffc29f',
						'textColor' => '#000',
					],
					[
						'label' => 'Fantastic',
						'itembgColor' => '#c3f2d1',
						'textColor' => '#000',
					],

				],
				'title_field' => '{{{ label }}}',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings();

		$classnames = ['w-full'];

		if ( ! \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			array_push($classnames, 'pointer-events-none');
		}

		$this->add_render_attribute( '_wrapper', 'class', $classnames );
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$throwable_opts = [ 'roundness' => $settings['roundness'] ];

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [ 'lqd-throwable-scene', 'relative', 'pointer-events-none', 'overflow-hidden' ],
				'data-lqd-throwable-scene' => 'true',
				'data-throwable-options' => wp_json_encode( $throwable_opts ),
			]
		);

		if ( $settings['items'] ){
		?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<?php
					foreach( $settings['items'] as $item ) {
						$tag = $settings['tag'];
						$tag = $item['tag'] !== 'default' ? $item['tag'] : $tag;
						printf( '<%1$s class="lqd-throwable-element inline-block absolute top-0 start-0 whitespace-nowrap m-0 pointer-events-auto user-select-none cursor-pointer opacity-0 elementor-repeater-item-%3$s" data-lqd-throwable-el>
						<span class="lqd-throwable-element-rot inline-block">%2$s</span>
						</%1$s>', Utils::validate_html_tag( $tag ), $item['label'], esc_attr( $item['_id'] ) );
					}
				?>
			</div>
		<?php
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Throwable() );