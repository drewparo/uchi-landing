<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Particles extends Widget_Base {

	public function get_name() {
		return 'lqd-particles';
	}

	public function get_title() {
		return __( 'Liquid Particles', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-shape lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'particle', 'animation', 'background' ];
	}

	public function get_script_depends() {
		return [ 'tsparticles' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label' => esc_html__( 'Source', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'json' => [
						'title' => esc_html__( 'JSON', 'aihub-core' ),
						'icon' => 'eicon-editor-code',
					],
					'options' => [
						'title' => esc_html__( 'Options', 'aihub-core' ),
						'icon' => 'eicon-cogs',
					],
				],
				'default' => 'json',
				'toggle' => false,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .your-class' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'em', 'rem', 'custom' ],
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
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'em', 'rem', 'custom' ],
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
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}}, {{WRAPPER}} > .elementor-widget-container, {{WRAPPER}} .lqd-particles-container, {{WRAPPER}} canvas' => 'height: {{SIZE}}{{UNIT}}; min-height: inherit;',
					'{{WRAPPER}} canvas' => 'height: {{SIZE}}{{UNIT}}!important;',
				],
			]
		);

		$this->add_control(
			'config', [
				'label' => _x( 'Particles config', 'Background Control', 'aihub-core' ),
				'description' => __( 'You can get the config from <a target="_blank" href="https://particles.js.org">https://particles.js.org</a>', 'aihub-core' ),
				'type' => Controls_Manager::CODE,
				'language' => 'json',
				'condition' => [
					'source' => 'json'
				]
			]
		);

		$this->end_controls_section();


		// Particles Section
		$this->start_controls_section(
			'Particles_section',
			[
				'label' => __( 'Particles Options', 'aihub-core' ),
				'condition' => [
					'source' => 'options'
				]
			]
		);

		$this->add_control(
			'shape_type',
			[
				'label' => __( 'Shape type', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'circle'  => __( 'Circle', 'aihub-core' ),
					'edge'  => __( 'Edge', 'aihub-core' ),
					'triangle'  => __( 'Triangle', 'aihub-core' ),
					'polygon'  => __( 'Polygon', 'aihub-core' ),
					'star'  => __( 'Star', 'aihub-core' ),
					'image'  => __( 'Image', 'aihub-core' ),
				],
				'default' => [ 'circle' ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'number',
			[
				'label' => __( 'Number', 'aihub-core' ),
				'placeholder' => __( 'Number of the particles', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 10,
			]
		);

		$this->add_control(
			'enable_density',
			[
				'label' => __( 'Enable Density?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'density',
			[
				'label' => __( 'Density', 'aihub-core' ),
				'placeholder' => __( 'Number of the particles', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'condition' => [
					'enable_density' => 'yes'
				],
			]
		);

		$this->add_control(
			'color_h',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'color_type',
			[
				'label' => __( 'Color Variations', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'single_color',
				'options' => [
					'single_color' => __( 'Single Color', 'aihub-core' ),
					'multi_color' => __( 'Multi Color', 'aihub-core' ),
					'random_color' => __( 'Random Color', 'aihub-core' ),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'scolor',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'multi_color_values',
			[
				'label' => __( 'Multi Colors', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ scolor }}}',
				'condition' => [
					'color_type' => 'multi_color'
				]
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'condition' => [
					'color_type' => 'single_color',
				]
			]
		);

		$this->add_control(
			'nb_sides',
			[
				'label' => __( 'Polygon Number Sides', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add polygons number sides', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'shape_type' => 'shape_type',
				]
			]
		);

		$this->add_control(
			'image_h',
			[
				'label' => esc_html__( 'Image', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'shape_type' => 'image',
				]
			]
		);

		$image_repeater = new Repeater();

		$image_repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$image_repeater->add_control(
			'image_width',
			[
				'label' => __( 'Image Width', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add Image Width', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
			]
		);

		$image_repeater->add_control(
			'image_height',
			[
				'label' => __( 'Image Height', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add Image Height', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
			]
		);

		$this->add_control(
			'images',
			[
				'label' => __( 'Images', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $image_repeater->get_controls(),
				'condition' => array(
					'shape_type' => 'image',
				)
			]
		);

		$this->add_control(
			'opacity_h',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => __( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'condition' => [
					'enable_random_opacity' => ''
				]
			]
		);

		$this->add_control(
			'enable_random_opacity',
			[
				'label' => __( 'Enable Random Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_anim_opacity',
			[
				'label' => __( 'Enable Animation Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'anim_opacity_speed',
			[
				'label' => __( 'Animation Speed', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 3', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_anim_opacity' => 'yes',
				]
			]
		);

		$this->add_control(
			'anim_opacity_min',
			[
				'label' => __( 'Min opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'condition' => [
					'enable_anim_opacity' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_anim_sync',
			[
				'label' => __( 'Enable Animation Sync', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_anim_opacity' => 'yes'
				]
			]
		);

		$this->add_control(
			'size_h',
			[
				'label' => esc_html__( 'Sizes', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 20', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
			]
		);

		$this->add_control(
			'enable_random_size',
			[
				'label' => __( 'Enable Random size', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_anim_size',
			[
				'label' => __( 'Enable Animation size', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'anim_size_speed',
			[
				'label' => __( 'Speed', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 80', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_anim_size' => 'yes'
				]
			]
		);

		$this->add_control(
			'anim_size_min',
			[
				'label' => __( 'Min size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'condition' => [
					'enable_anim_size' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_anim_size_sync',
			[
				'label' => __( 'Enable Animation Sync', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_anim_size' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_line_linked',
			[
				'label' => __( 'Enable Linked Line', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'line_distance',
			[
				'label' => __( 'Distance', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 300', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_line_linked' => 'yes'
				]
			]
		);

		$this->add_control(
			'line_color',
			[
				'label' => __( 'Line color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'enable_line_linked' => 'yes'
				]
			]
		);

		$this->add_control(
			'line_opacity',
			[
				'label' => __( 'Min opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'condition' => [
					'enable_line_linked' => 'yes'
				]
			]
		);

		$this->add_control(
			'line_width',
			[
				'label' => __( 'Line Width', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 2', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_line_linked' => 'yes'
				]
			]
		);

		$this->add_control(
			'stroke_h',
			[
				'label' => esc_html__( 'Stroke', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'stroke_width',
			[
				'label' => __( 'Stroke Width', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 2', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
			]
		);

		$this->add_control(
			'stroke_color',
			[
				'label' => __( 'Stroke color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'enable_move_h',
			[
				'label' => esc_html__( 'Move', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'enable_move',
			[
				'label' => __( 'Enable Move', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'move_speed',
			[
				'label' => __( 'Move Speed', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 12', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'move_direction',
			[
				'label' => __( 'Move Direction', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'aihub-core' ),
					'top' => __( 'Top', 'aihub-core' ),
					'top-right' => __( 'Top Right', 'aihub-core' ),
					'right' => __( 'Right', 'aihub-core' ),
					'bottom-right' => __( 'Bottom Right', 'aihub-core' ),
					'bottom' => __( 'Bottom', 'aihub-core' ),
					'bottom-left' => __( 'Bottom Left', 'aihub-core' ),
					'left' => __( 'Left', 'aihub-core' ),
					'top-left' => __( 'Top Left', 'aihub-core' ),
				],
				'condition' => [
					'enable_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_random_move',
			[
				'label' => __( 'Enable Random Move', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_straight_move',
			[
				'label' => __( 'Enable Straight Move', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'move_out_mode',
			[
				'label' => __( 'Out Mode', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'out',
				'options' => [
					'out' => __( 'Out', 'aihub-core' ),
					'bounce' => __( 'Bounce', 'aihub-core' ),
				],
				'condition' => [
					'enable_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_bounce_move',
			[
				'label' => __( 'Enable Bounce', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_attract_move',
			[
				'label' => __( 'Enable Attract', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'move_attract_rotatex',
			[
				'label' => __( 'Attract Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 3000', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_attract_move' => 'yes'
				]
			]
		);

		$this->add_control(
			'move_attract_rotatey',
			[
				'label' => __( 'Attract Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 1500', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'condition' => [
					'enable_attract_move' => 'yes'
				]
			]
		);
		$this->end_controls_section();

		// Section Interactivity
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Interactivity', 'aihub-core' ),
				'condition' => [
					'source' => 'options'
				]
			]
		);

		$this->add_control(
			'detect_on',
			[
				'label' => __( 'Detect on', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'aihub-core' ),
					'canvas' => __( 'Canvas', 'aihub-core' ),
					'window' => __( 'Window', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'enable_onhover',
			[
				'label' => __( 'Enable onhover events', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'onhover_mode',
			[
				'label' => __( 'Onhover mode', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grab',
				'options' => [
					'grab' => __( 'Grab', 'aihub-core' ),
					'bubble' => __( 'Bubble', 'aihub-core' ),
					'repulse' => __( 'Repulse', 'aihub-core' ),
				],
				'condition' => [
					'enable_onhover' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_onclick',
			[
				'label' => __( 'Enable onclick event', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'onclick_mode',
			[
				'label' => __( 'Onclick mode', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'push',
				'options' => [
					'push' => __( 'Push', 'aihub-core' ),
					'remove' => __( 'Remove', 'aihub-core' ),
					'bubble' => __( 'Bubble', 'aihub-core' ),
					'repulse' => __( 'Repulse', 'aihub-core' ),
				],
				'condition' => [
					'enable_onclick' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_inter_resize',
			[
				'label' => __( 'Enable resize', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'modes_grab_distance',
			[
				'label' => __( 'Grab Distance', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 100', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'modes_grab_opacity',
			[
				'label' => __( 'Grab Line Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
			]
		);

		$this->add_control(
			'modes_bubble_distance',
			[
				'label' => __( 'Bubble Distance', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 100', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'modes_bubble_size',
			[
				'label' => __( 'Bubble Size', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 40', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'modes_bubble_duration',
			[
				'label' => __( 'Bubble Duration', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'second (ex 0.4)', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'modes_repulse_distance',
			[
				'label' => __( 'Repulse Distance', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 200', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'modes_repulse_duration',
			[
				'label' => __( 'Repulse Duration', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'second (ex 1.2)', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'modes_push_particles_nb',
			[
				'label' => __( 'Push particles number', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 4', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'modes_remove_particles_nb',
			[
				'label' => __( 'Remove particles number', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'for ex 4', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);
		$this->end_controls_section();

		// Retina Section
		$this->start_controls_section(
			'background_section',
			[
				'label' => __( 'Background Options', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'source' => 'options'
				]
			]
		);

		$this->add_control(
			'retina_detect',
			[
				'label' => __( 'Retina Detect', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'fullscreen',
			[
				'label' => __( 'Fullscreen', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

	}

	protected function get_particles_config() {

		extract( $this->get_settings_for_display() );

		$data = '';
		$options = $particle_opts = $interactivity_opts = $number_opts = $shape_opts = $stroke_opts = $image_opts = $opacity_opts = $opacity_anim_opts = $size_opts = $size_anim_opts = $line_linked_opts = $move_opts = $move_attract_opts = $onohver_opts = $events_opts = $onclick_opts = $modes_opts = $bubble_opts = $repulse_opts = $density_opts = array();

		if ( !empty( $number ) ) {
			$number_opts['value'] = (int)$number;
		}
		if ( $enable_density ) {
			$density_opts['enable'] = true;
		}
		if ( !empty( $density ) ) {
			$density_opts['value_area'] = $density;
		}
		if ( !empty( $density_opts ) ) {
			$number_opts['density'] = (int)$density_opts;
		}
		//Number of elements
		if ( !empty( $number_opts ) ) {
			$particle_opts['number'] = $number_opts;
		}
		//Background Color
		if ( 'single_color' === $color_type ) {
			if ( !empty( $color ) ) {
				$particle_opts['color'] = array( 'value' => $color );
			}
		} elseif ( 'multi_color' === $color_type ) {
			$colors = array();
			$color_arr = $multi_color_values ;
			foreach ( $color_arr as $color ) {
				$colors[] = $color['scolor'];
			}
			$particle_opts['color'] = array( 'value' => $colors );
		} else {
			$particle_opts['color'] = array( 'value' => 'random' );
		}

		//Shape options
		if ( !empty( $shape_type ) ) {
			$shape_arr = $shape_type;
			$shape_opts['type'] = $shape_arr;
		}
		if ( !empty( $stroke_width ) ) {
			$stroke_opts['width'] = (int)$stroke_width;
		}
		if ( !empty( $stroke_color ) ) {
			$stroke_opts['color'] = $stroke_color;
		}
		if ( !empty( $stroke_opts ) ) {
			$shape_opts['stroke'] = $stroke_opts;
		}
		if ( !empty( $nb_sides ) ) {
			$shape_opts['polygon'] = array( 'nb_sides' => (int)$nb_sides );
		}
		if ( !empty( $images ) ){

			$_image_opts = array();
			foreach( $images as $image ) {
				if ( !empty( $image ) ) {
					$_image_opts[] = [
						'src' => esc_url( $image['image']['url'] ),
						'width' => !empty( $image['image_width'] ) ? (int)$image['image_width'] : '',
						'height' => !empty( $image['image_height'] ) ? (int)$image['image_height'] : '',
					];
				}

				$image_opts = $_image_opts;
			}

			if ( !empty( $image_opts ) ) {
				$shape_opts['images'] = $image_opts;
			}

		}
		if ( !empty( $shape_opts ) ) {
			$particle_opts['shape'] = $shape_opts;
		}

		//Opacity values
		if ( '1' !== $opacity ) {
			$opacity_opts['value'] = (float)$opacity;
		}
		if ( $enable_random_opacity ) {
			$opacity_opts['random'] = true;
		}
		if ( $enable_anim_opacity ) {
			$opacity_anim_opts['enable'] = true;
			$opacity_anim_opts['opacity_min'] = (float)$anim_opacity_min;
		}
		if ( !empty( $anim_opacity_speed ) ) {
			$opacity_anim_opts['speed'] = (int)$anim_opacity_speed;
		}
		if ( $enable_anim_opacity ) {
			$opacity_anim_opts['sync'] = true;
		}
		if ( !empty( $opacity_anim_opts ) ) {
			$opacity_opts['anim'] = $opacity_anim_opts;
		}
		if ( !empty( $opacity_opts ) ) {
			$particle_opts['opacity'] = $opacity_opts;
		}

		//Size values
		if ( !empty( $size ) ) {
			$size_opts['value'] = (int)$size;
		}
		if ( $enable_random_size ) {
			$size_opts['random'] = true;
		}
		if ( $enable_anim_size ) {
			$size_anim_opts['enable'] = true;
			$size_anim_opts['size_min'] = (float)$anim_size_min;
		}
		if ( !empty( $anim_size_speed ) ) {
			$size_anim_opts['speed'] = (int)$anim_size_speed;
		}
		if ( $enable_anim_size_sync ) {
			$size_anim_opts['sync'] = true;
		}
		if ( !empty( $size_anim_opts ) ) {
			$size_opts['anim'] = $size_anim_opts;
		}
		if ( !empty( $size_opts ) ) {
			$particle_opts['size'] = $size_opts;
		}

		//Linked line
		if ( $enable_line_linked ) {
			$line_linked_opts['enable'] = true;
			$line_linked_opts['opacity'] = (float)$line_opacity;
		}
		if ( !empty( $line_distance ) ) {
			$line_linked_opts['distance'] = (int)$line_distance;
		}
		if ( !empty( $line_color ) ) {
			$line_linked_opts['color'] = $line_color;
		}
		if ( !empty( $line_width ) ) {
			$line_linked_opts['width'] = (int)$line_width;
		}

		if ( !empty( $line_linked_opts ) ) {
			$particle_opts['line_linked'] = $line_linked_opts;
		}

		//Move values
		if ( $enable_move ) {
			$move_opts['enable'] = true;
			$move_opts['direction'] = $move_direction;
		}
		if ( !empty( $move_speed ) ) {
			$move_opts['speed'] = (float)$move_speed;
		}
		if ( $enable_random_move ) {
			$move_opts['random'] = true;
		}
		if ( $enable_straight_move ) {
			$move_opts['straight'] = true;
		}
		if ( isset( $move_out_mode ) ) {
			$move_opts['out_mode'] = $move_out_mode;
		}
		if ( $enable_bounce_move ) {
			$move_opts['bounce'] = true;
		}
		if ( $enable_attract_move ) {
			$move_attract_opts['enable'] = true;
		}
		if ( !empty( $move_attract_rotatex ) ) {
			$move_attract_opts['rotateX'] = (int)$move_attract_rotatex;
		}
		if ( !empty( $move_attract_rotatey ) ) {
			$move_attract_opts['rotateY'] = (int)$move_attract_rotatey;
		}
		if ( !empty( $move_attract_opts ) ) {
			$move_opts['attract'] = $move_attract_opts;
		}
		if ( !empty( $move_opts ) ) {
			$particle_opts['move'] = $move_opts;
		}

		$options['particles'] = $particle_opts;
		if ( !empty( $detect_on ) ) {
			$interactivity_opts['detect_on'] = $detect_on;
		}
		if ( $enable_onhover ) {
			$onhover_arr = explode( ',', $onhover_mode );
			$events_opts['onhover'] = array( 'enable' => true, 'mode' => $onhover_arr );
		}
		if ( $enable_onclick ) {
			$onclick_arr = explode( ',', $onclick_mode );
			$events_opts['onclick'] = array( 'enable' => true, 'mode' => $onclick_arr );
		}
		if ( $enable_inter_resize ) {
			$events_opts['resize'] = true;
		}
		if ( !empty( $events_opts ) ) {
			$interactivity_opts['events'] = $events_opts;
		}
		if ( !empty( $modes_grab_distance ) ) {
			$modes_opts['grab'] = array( 'distance' => (int)$modes_grab_distance, 'line_linked' => array( 'opacity' => $modes_grab_opacity ) );
		}
		if ( !empty( $modes_bubble_distance ) ) {
			$bubble_opts['distance'] = (int)$modes_bubble_distance;
		}
		if ( !empty( $modes_bubble_size ) ) {
			$bubble_opts['size'] = (int)$modes_bubble_size;
		}
		if ( !empty( $modes_bubble_duration ) ) {
			$bubble_opts['duration'] = (float)$modes_bubble_duration;
		}
		if ( !empty( $bubble_opts ) ) {
			$modes_opts['bubble'] = $bubble_opts;
		}

		if ( !empty( $modes_repulse_distance ) ) {
			$repulse_opts['distance'] = (int)$modes_repulse_distance;
		}
		if ( !empty( $modes_repulse_duration ) ) {
			$repulse_opts['duration'] = (float)$modes_repulse_duration;
		}
		if ( !empty( $repulse_opts ) ) {
			$modes_opts['repulse'] = $repulse_opts;
		}

		if ( !empty( $modes_push_particles_nb ) ) {
			$modes_opts['push'] = array( 'particles_nb' => (int)$modes_push_particles_nb );
		}
		if ( !empty( $modes_remove_particles_nb ) ) {
			$modes_opts['remove'] = array( 'particles_nb' => (int)$modes_remove_particles_nb );
		}
		if ( !empty( $modes_opts ) ) {
			$interactivity_opts['modes'] = $modes_opts;
		}

		$options['interactivity'] = $interactivity_opts;

		// Background options
		if ( $retina_detect ) {
			$options['retina_detect'] = true;
		}
		$options['fullScreen'] = $fullscreen ? true : false;

		$data = wp_json_encode( $options );

		return $data;

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$wrapper_id = 'lqd-particles-' . $this->get_id();
		$element_id = $this->get_id();

		if ( $settings['source'] === 'json' ) {
			$config = $settings['config'];
		} else {
			$config = $this->get_particles_config();
		}

		?>

		<div class="lqd-particles-container" id="<?php echo esc_attr( $wrapper_id ); ?>"></div>

		<?php if ( !empty( $config ) ) { ?>
			<script>
				(() => {
					async function run() {
						const el = document.querySelector('.elementor-element-<?php echo $element_id ?>');
						const particles = await tsParticles.load('<?php echo $wrapper_id; ?>', <?php echo $config; ?>);
						particles.pause();
						new IntersectionObserver(([entry]) => {
							if ( entry.isIntersecting ) {
								particles.play();
							} else {
								particles.pause();
							}
						}).observe(el);
					}
					if ( typeof tsParticles === 'object' ) {
						run();
					} else {
						document.addEventListener('DOMContentLoaded', function () {
							run();
						}, false);
					}
				})();
			</script>
		<?php }
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Particles() );