<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Liquid_Swap extends Widget_Base {

	// public function __construct($data = [], $args = null) {
	// 	parent::__construct($data, $args);

	// 	wp_register_script( 'threejs',
	// 		get_template_directory_uri() . '/assets/vendors/threejs/three.min.js',
	// 		[ 'jquery' ],
	// 		LQD_CORE_VERSION,
	// 		true
	// 	);

	// }

	public function get_name() {
		return 'lqd-liquid-swap';
	}

	public function get_title() {
		return __( 'Liquid Swap', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-dual-button lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'liquid', 'swap', 'image', 'video', 'threejs', 'webgl' ];
	}

	public function get_script_depends() {
		return [ 'threejs' ];
	}

	public function get_behavior() {
		$settings = $this->get_settings_for_display();
		$image_1_src = '';
		$image_2_src = '';
		$media_type = $settings['media_type'];
		$intensity = $settings['liquid_swap_intensity']['size'];
		$behavior = [];

		if ( $media_type === 'image' ) {
			$image_1_src = !empty( $settings['liquid_swap_image_1']['id'] ) ? wp_get_attachment_image_url( $settings['liquid_swap_image_1']['id'], 'full', false ) : '';
			$image_2_src = !empty( $settings['liquid_swap_image_2']['id'] ) ? wp_get_attachment_image_url( $settings['liquid_swap_image_2']['id'], 'full', false ) : '';
		} else {
			$image_1_src = !empty( $settings['liquid_swap_video_1']['url'] ) ? $settings['liquid_swap_video_1']['url'] : '';
			$image_2_src = !empty( $settings['liquid_swap_video_2']['url'] ) ? $settings['liquid_swap_video_2']['url'] : '';
		}

		if ( empty( $image_1_src ) && empty( $image_2_src ) ) {
			return $behavior;
		};

		$behavior[] = [
			'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
			'options' => [
				'includeSelf' => 'true',
				'getRect' => 'true'
			]
		];

		$behavior[] = [
			'behaviorClass' => 'LiquidLiquidSwapBehavior',
			'options' => [
				'image1' => "'" . $image_1_src . "'",
				'image2' => "'" . $image_2_src . "'",
				'dispImage' => "'" . get_template_directory_uri() . '/assets/img/displacements/'. $settings['liquid_swap_displacement'] . "'",
				'speedIn' => 1.25,
				'speedOut' => 1.25,
				'intensity1' => ! empty( $intensity ) ? $intensity : 0.15,
				'intensity2' => ! empty( $intensity ) ? $intensity : 0.15,
				'angle1' => 10,
				'angle2' => 10,
				'video' => $media_type === 'video'
			]
		];

		return $behavior;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Images', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'media_type',
			[
				'label' => esc_html__( 'Media type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'image'   => [
						'title' => esc_html__( 'Image', 'Text-domain' ),
						'icon'  => 'eicon-image-bold',
					],
					'video'   => [
						'title' => esc_html__( 'Video', 'Text-domain' ),
						'icon'  => 'eicon-video-camera',
					],
				],
				'default' => 'image',
			]
		);

		$this->add_control(
			'liquid_swap_video_1',
			[
				'label' => esc_html__( 'Video 1', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::MEDIA_CATEGORY,
					],
				],
				'media_type' => 'video',
				'condition' => [
					'media_type' => 'video',
				],
				'ai' => [
					'active' => false,
				],
			]
		);

		$this->add_control(
			'liquid_swap_video_2',
			[
				'label' => esc_html__( 'Video 2', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::MEDIA_CATEGORY,
					],
				],
				'media_type' => 'video',
				'condition' => [
					'media_type' => 'video',
				],
				'ai' => [
					'active' => false,
				],
			]
		);

		$this->add_control(
			'liquid_swap_image_1',
			[
				'label' => __( 'Image 1', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_type' => 'image',
				],
			]
		);

		$this->add_control(
			'liquid_swap_image_2',
			[
				'label' => __( 'Image 2', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_type' => 'image',
				],
			]
		);

		$this->add_control(
			'liquid_swap_displacement',
			[
				'label' => __( 'Displacement map', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'disp1.jpg',
				'options' => [
					'disp1.jpg' => __( 'Displacement 1', 'aihub-core' ),
					'disp2.jpg' => __( 'Displacement 2', 'aihub-core' ),
					'disp3.jpg' => __( 'Displacement 3', 'aihub-core' ),
					'disp4.jpg' => __( 'Displacement 4', 'aihub-core' ),
					'disp5.jpg' => __( 'Displacement 5', 'aihub-core' ),
					'disp6.jpg' => __( 'Displacement 6', 'aihub-core' ),
					'disp7.jpg' => __( 'Displacement 7', 'aihub-core' ),
					'disp8.jpg' => __( 'Displacement 8', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_swap_intensity',
			[
				'label' => esc_html__( 'Intensity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.15,
				],
			]
		);

		$this->end_controls_section();

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings();

		$classnames = ['w-full'];

		$this->add_render_attribute( '_wrapper', 'class', $classnames );
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$media_type = $settings['media_type'];
		$image_1 = '';
		$image_2 = '';
		$image_1_src = '';
		$image_2_src = '';
		$image_1_width = '';
		$image_1_height = '';
		$image_2_width = '';
		$image_2_height = '';

		if ( $media_type === 'image' ) {
			$image_1 = $settings['liquid_swap_image_1'];
			$image_2 = $settings['liquid_swap_image_2'];
			$image_1_src = !empty( $image_1['id'] ) ? wp_get_attachment_image_url( $image_1['id'], 'full', false ) : '';
			$image_2_src = !empty( $image_2['id'] ) ? wp_get_attachment_image_url( $image_2['id'], 'full', false ) : '';
		} else {
			$image_1 = $settings['liquid_swap_video_1'];
			$image_2 = $settings['liquid_swap_video_2'];
			$image_1_src = !empty( $image_1['url'] ) ? $image_1['url'] : '';
			$image_2_src = !empty( $image_2['url'] ) ? $image_2['url'] : '';
		}

		if ( empty( $image_1_src ) && empty( $image_2_src ) ) return;

		if ( !empty( $image_1_src ) && empty( $image_2_src ) ) {
			$image_2_src = $image_1_src;
		}

		$image_1_meta = wp_get_attachment_metadata( $image_1['id'] );
		$image_2_meta = wp_get_attachment_metadata( $image_2['id'] );

		if ( $image_1_meta ) {
			if ( !empty( $image_1_meta['width'] ) ) {
				$image_1_width = $image_1_meta['width'];
			}
			if ( !empty( $image_1_meta['height'] ) ) {
				$image_1_height = $image_1_meta['height'];
			}
		}
		if ( $image_2_meta ) {
			if ( !empty( $image_2_meta['width'] ) ) {
				$image_2_width = $image_2_meta['width'];
			}
			if ( !empty( $image_2_meta['height'] ) ) {
				$image_2_height = $image_2_meta['height'];
			}
		}

		if ( $media_type === 'image' ) {
			echo wp_get_attachment_image( $settings['liquid_swap_image_1']['id'], 'full', false, [ 'class' => 'w-full h-auto invisible' ] );
		} else {
			?>
			<video width="<?php echo $image_1_width ? $image_1_width : '' ?>" height="<?php echo $image_1_height ? $image_1_height : '' ?>" class="invisible" src="<?php echo $image_1_src ?>" playsinline muted loop autoplay></video>
			<?php
		}
		?><canvas width="<?php echo $image_1_width ? $image_1_width : '' ?>" height="<?php echo $image_1_height ? $image_1_height : '' ?>" class="w-full h-full max-w-full absolute top-0 start-0"></canvas><?php
		if ( $media_type === 'image' ) {
			echo wp_get_attachment_image( $settings['liquid_swap_image_2']['id'], 'full', false, [ 'class' => 'w-full h-full absolute top-0 start-0 invisible' ] );
		} else {
			?>
			<video width="<?php echo $image_2_width ? $image_2_width : '' ?>" height="<?php echo $image_2_height ? $image_2_height : '' ?>" class="w-full h-full absolute top-0 start-0 invisible" src="<?php echo $image_2_src ?>" playsinline muted loop autoplay></video>
			<?php
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Liquid_Swap() );