<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Draw_Shape extends Widget_Base {

	public function get_name() {
		return 'lqd-draw-shape';
	}

	public function get_title() {
		return __( 'Draw Shape', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-lottie lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'draw', 'shape', 'animate', 'icon' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();

		$behavior = [];
		$behavior[] = [
			'behaviorClass' => 'LiquidDrawShapeBehavior',
			'options' => [
				'drawSVG' => !empty($settings['draw_from']) ? "'" . $settings['draw_from'] . "'" : "'0% 0%'",
				'stagger' => $settings['stagger']['size'] ? (float)$settings['stagger']['size'] : 0,
				'start' => !empty($settings['start']) ? "'" . $settings['start'] . "'" : "'top bottom'",
				'end' => !empty($settings['end']) ? "'" . $settings['end'] . "'" : "'center center'",
				'scrub' =>  $settings['scrub'] ? (float)$settings['scrub'] : true,
				'ease' =>  "'" . $settings['ease'] . "'" ,
			]
		];

		return $behavior;

	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'svg_file',
			[
				'label' => __( 'Upload SVG File', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'svg',
			]
		);

		$this->add_control(
			'shape_width',
			[
				'label' => __( 'Shape width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
				]
			]
		);

		$this->add_control(
			'shape_height',
			[
				'label' => __( 'Shape height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} svg' => 'height: {{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_control(
			'draw_from',
			[
				'label' => __( 'Draw from', 'aihub-core' ),
				'description' => __( 'Enter values you want to draw shape from', 'aihub-core' ),
				'default' => '0% 0%',
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'stagger',
			[
				'label' => __( 'Stagger', 'aihub-core' ),
				'description' => __( 'Delay between each animated object inside svg', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '0'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'start',
			[
				'label' => __( 'Start', 'aihub-core' ),
				'description' => __( 'Define when you want to start the animation. "top bottom" means when the "top" of the element hits the "bottom" of the viewport. You can also use percentage values. For example "0% 100%".', 'aihub-core' ),
				'default' => 'top bottom',
				'placeholder' => __( 'Default: top bottom', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'end',
			[
				'label' => __( 'End', 'aihub-core' ),
				'description' => __( 'Define when you want to end the animation. "center center" means when the "center" of the element hits the "center" of the viewport. You can also use percentage values. For example "50% 50%".', 'aihub-core' ),
				'default' => 'center center',
				'placeholder' => __( 'Default: center center', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'scrub',
			[
				'label' => __( 'scrub', 'aihub-core' ),
				'description' => __( 'Define the time the animation catches the scroll position.', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'ease',
			[
				'label' => __( 'Easing', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'linear',
				'options' => [
					'linear' => 'Linear',
					'power1.in' => 'Power1 In',
					'power1.out' => 'Power1 Out',
					'power1.inOut' => 'Power1 In Out',
					'power2.in' => 'Power2 In',
					'power2.out' => 'Power2 Out',
					'power2.inOut' => 'Power2 In Out',
					'power3.in' => 'Power3 In',
					'power3.out' => 'Power3 Out',
					'power3.inOut' => 'Power3 In Out',
					'power4.in' => 'Power4 In',
					'power4.out' => 'Power4 Out',
					'power4.inOut' => 'Power4 In Out',
					'back.in' => 'Back In',
					'back.out' => 'Back Out',
					'back.inOut' => 'Back In Out',
					'bounce.in' => 'Bounce In',
					'bounce.out' => 'Bounce Out',
					'bounce.inOut' => 'Bounce In Out',
					'circ.in' => 'Circ In',
					'circ.out' => 'Circ Out',
					'circ.inOut' => 'Circ In Out',
					'elastic.in(1,0.2)' => 'Elastic In',
					'elastic.out(1,0.2)' => 'Elastic Out',
					'elastic.inOut(1,0.2)' => 'Elastic In Out',
					'expo.in' => 'Expo In',
					'expo.out' => 'Expo Out',
					'expo.inOut' => 'Expo In Out',
					'sine.in' => 'Sine In',
					'sine.out' => 'Sine Out',
					'sine.inOut' => 'Sine In Out',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

	}

	protected function get_draw_data_options() {

		$settings = $this->get_settings_for_display();

		$opts = array(
			'drawSVG' => !empty($settings['draw_from']) ? $settings['draw_from'] : '0% 0%',
			'stagger' => $settings['stagger']['size'] ? (float)$settings['stagger']['size'] : 0,
			'start' => !empty($settings['start']) ? $settings['start'] : 'top bottom',
			'end' => !empty($settings['end']) ? $settings['end'] : 'center center',
			'scrub' =>  $settings['scrub'] ? (float)$settings['scrub'] : true,
			'ease' =>  $settings['ease'],
		);

		return wp_json_encode( $opts );

	}

	protected function get_svg_options() {

		$svg = $this->get_settings_for_display( 'svg_file' );

		if ( !isset( $svg['url'] ) ){
			return;
		}

		$val = [
			'value' => [
				'url' => $svg['url'],
				'id' => $svg['id']
			],
			'library' => 'svg',
			'url' => $svg['url'],
			'id' => $svg['id'],
			'alt' => '',
			'source' => 'library'
		];

		return $val;

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [ 'lqd-draw-shape', ],
			]
		);

		?>

		<figure <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
				\LQD_Elementor_Helper::render_icon( $this->get_svg_options(), [ 'aria-hidden' => 'true' ] );
			?>
		</figure>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Draw_Shape() );