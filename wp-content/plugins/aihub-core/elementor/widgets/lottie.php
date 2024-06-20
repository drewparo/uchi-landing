<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Lottie extends Widget_Base {

    public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);

		wp_enqueue_script( 'lottie',
			get_template_directory_uri() . '/assets/vendors/lottie/lottie.min.js',
			[ 'jquery' ],
			'5.9.6',
			true
		);

	}

	public function get_script_depends() {
		return [ 'lottie' ];
	}

	public function get_name() {
		return 'lqd-lottie';
	}

	public function get_title() {
		return __( 'Liquid Lottie', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-lottie lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'lottie', 'animation' ];
	}

	public function get_behavior() {

		$behavior = [];
		$settings = $this->get_settings_for_display();
		extract( $settings );

		if ( $json_source === 'internal' ){
            $animation_src = isset( $settings['json_file']['url'] ) ? esc_url( $settings['json_file']['url'] ) : '';
        } else {
        	$animation_src = isset( $settings['json_url']['url'] ) ? esc_url( $settings['json_url']['url'] ) : '';
        }

		if ( !empty( $animation_src ) ) {

			$element_id = 'lqd-lottie-' . $this->get_id();

			$behavior[] = [
				'behaviorClass' => 'LiquidLottieBehavior',
				'options' => [
					'animType' => "'$render_type'",
					'name' => "'$element_id'",
					'autoplay' => $autoplay ? true : false,
					'loop' => $loop ? true : false,
					'path' => "'$animation_src'",
					'className' => "'lqd-lottie'",
					'direction' => "'$direction'",
					'speed' => $animation_speed['size'],
				]
			];
		}

		return $behavior;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
			]
		);

        $this->add_control(
			'json_source',
			[
				'label' => esc_html__( 'Source', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'internal',
				'options' => [
					'internal'  => esc_html__( 'Media Library', 'aihub-core' ),
					'external' => esc_html__( 'External URL', 'aihub-core' ),
				],
			]
		);

        $this->add_control(
			'json_url',
			[
				'label' => esc_html__( 'External JSON URL', 'aihub-core' ),
                'placeholder' => esc_html__( 'Enter the JSON URL', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
                'condition' => [
					'json_source' => 'external',
				],
			]
		);

		$this->add_control(
			'json_file',
			[
				'label' => esc_html__( 'Upload JSON File', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'application/json',
				'condition' => [
					'json_source' => 'internal',
				],
			]
		);

        $this->add_control( 'hr2', [
            'type' => Controls_Manager::DIVIDER,
        ] );

        $this->add_control(
			'render_type',
			[
				'label' => esc_html__( 'Render Type', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'canvas',
				'options' => [
					'canvas' => esc_html__( 'Canvas', 'aihub-core' ),
					'svg'  => esc_html__( 'SVG', 'aihub-core' ),
				],
			]
		);

        $this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1'  => esc_html__( 'Forward', 'aihub-core' ),
					'-1' => esc_html__( 'Backward', 'aihub-core' ),
				],
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'player_bg',
				'label' => esc_html__( 'Background', 'aihub-core' ),
				'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-lottie',
			]
		);

        $this->add_control( 'hr', [
            'type' => Controls_Manager::DIVIDER,
        ] );

        $this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lqd-lottie, {{WRAPPER}} > .elementor-widget-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lqd-lottie, {{WRAPPER}} > .elementor-widget-container' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'animation_speed',
			[
				'label' => esc_html__( 'Animation Speed (1x)', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 5,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
                'render_type' => 'template',
			]
		);

        $this->add_control( 'hr3', [
            'type' => Controls_Manager::DIVIDER,
        ] );

        $this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'aihub-core' ),
				'description' => esc_html__( 'Play animation on load.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'autoplay',
                'default' => 'autoplay',
			]
		);

        $this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop', 'aihub-core' ),
				'description' => esc_html__( 'Set to repeat animation.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'loop',
                'default' => 'loop',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        extract( $settings );

		if ( $json_source === 'internal' ){
            $animation_src = isset( $settings['json_file']['url'] ) ? esc_url( $settings['json_file']['url'] ) : '';
        } else {
        	$animation_src = isset( $settings['json_url']['url'] ) ? esc_url( $settings['json_url']['url'] ) : '';
        }

        if ( empty( $animation_src ) ){
            return;
        }

        ?><div id="<?php esc_attr_e( 'lqd-lottie-' . $this->get_id() ); ?>" class="lqd-lottie"></div><?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Lottie() );