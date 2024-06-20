<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Carousel extends Widget_Base {

	// public function __construct($data = [], $args = null) {
	// 	parent::__construct($data, $args);

	// 	wp_register_script( 'fastdom', get_template_directory_uri() . '/assets/vendors/fastdom/fastdom.min.js', [ 'jquery' ], null, true );
	// 	wp_register_script( 'fastdom-promised', get_template_directory_uri() . '/assets/vendors/fastdom/fastdom-promised.js', [ 'jquery' ], null, true );
	// }

	public function get_name() {
		return 'lqd-carousel';
	}

	public function get_title() {
		return __( 'Liquid Carousel', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-slider-3d lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'carousel', 'slider' ];
	}

	public function get_script_depends() {
		return [ 'fastdom', 'fastdom-promised' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$carousel_options = [];
		$cell_has_look_mouse = false;

		if ( $settings['adaptive_height'] === 'yes' ) {
			$carousel_options['adaptiveHeight'] = true;
		}
		if ( $settings['equal_height'] === 'yes' ) {
			$carousel_options['equalHeight'] = true;
		}
		if ( !empty( $settings['cells_align'] ) && $settings['cells_align'] !== 'start' ) {
			$carousel_options['itemAlign'] = "'" . $settings['cells_align'] . "'";
		}
		if ( !empty( $settings['friction']['size'] ) && $settings['friction']['size'] !== 0.28 ) {
			$carousel_options['friction'] = $settings['friction']['size'];
		}
		if ( !empty( $settings['selected_attraction']['size'] ) && $settings['selected_attraction']['size'] !== 0.28 ) {
			$carousel_options['selectedAttraction'] = $settings['selected_attraction']['size'];
		}
		if ( $settings['wrap_around'] === 'yes' ) {
			$carousel_options['wrapAround'] = true;
		}
		if ( $settings['group_cells'] === 'yes' ) {
			$carousel_options['groupItems'] = true;
		}
		if ( !empty( $settings['connected_carousels'] ) ) {
			$carousel_options['connectedCarousels'] = "'" . $settings['connected_carousels'] . "'";
		}

		$behavior = [
			[
				'behaviorClass' => 'LiquidCarouselBehavior',
				'options' => $carousel_options
			]
		];

		if ( $settings['draggable'] === 'yes' ) {
			$draggable_options = [];

			if ( $settings['free_scroll'] === 'yes' ) {
				$draggable_options['freeScroll'] = true;
			}
			if ( !empty( $settings['free_scroll_friction']['size'] ) && $settings['free_scroll_friction']['size'] != 0.075 ) {
				$draggable_options['freeScrollFriction'] = $settings['free_scroll_friction']['size'];
			}

			$behavior[] = [
				'behaviorClass' => 'LiquidCarouselDragBehavior',
				'options' => $draggable_options
			];
		}
		if ( $settings['nav_buttons'] === 'yes' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidCarouselNavBehavior',
			];
		}
		if ( $settings['pagination_dots'] === 'yes' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidCarouselDotsBehavior',
			];
		}
		if ( $settings['autoplay_time'] > 0 ) {
			$autoplay_options = [
				'autoplayTimeout' => $settings['autoplay_time']
			];

			if ( $settings['pause_autoplay_onhover'] === 'yes' ) {
				$autoplay_options['pauseAutoPlayOnHover'] = true;
			}

			$behavior[] = [
				'behaviorClass' => 'LiquidCarouselAutoplayBehavior',
				'options' => $autoplay_options
			];
		}
		if ( $settings['slides_indicator'] === 'yes' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidCarouselSlidesIndicatorBehavior',
				'options' => [
					'leadingZero' => $settings['slides_indicator_numbers_leading_zero'] === 'yes'
				]
			];
		}

		foreach ( $settings['cells'] as $i => $cell ) {
			if ( $cell['cell_look_mouse'] === 'yes' ) {
				$cell_has_look_mouse = true;
				break;
			}
		}

		if ( $cell_has_look_mouse ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidLookAtMouseBehavior',
			];
		}

		return $behavior;

	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Carousel', 'aihub-core' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'cell_content_type',
			[
				'label' => __( 'Content type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'tinymce',
				'options' => [
					'tinymce' => [
						'title' => __( 'TinyMCE', 'aihub-core' ),
						'icon' => 'eicon-text-align-left'
					],
					'image' => [
						'title' => __( 'Image', 'aihub-core' ),
						'icon' => 'eicon-image-bold'
					],
					'el_template' => [
						'title' => __( 'Elementor Template', 'aihub-core' ),
						'icon' => 'eicon-site-identity'
					],
				],
				'toggle' => false,
			]
		);

		$repeater->add_control(
			'cell_templates',
			[
				'label' => __( 'Templates', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => liquid_helper()->get_elementor_templates(),
				'description' => liquid_helper()->get_elementor_templates_edit(),
				'default' => '0',
				'condition' => [
					'cell_content_type' => 'el_template',
				]
			]
		);

		$repeater->add_control(
			'edit_testimonial',
			[
				'label' => esc_html__( 'Override Testimonial Template?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'cell_content_type' => 'el_template',
				]
			]
		);

		$repeater->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your title here', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'cell_content_type' => 'el_template',
					'edit_testimonial' => 'yes',
				]
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Developer', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your title here', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'cell_content_type' => 'el_template',
					'edit_testimonial' => 'yes',
				]
			]
		);

		$repeater->add_control(
			'content',
			[
				'label' => esc_html__( 'Description', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'All in one Landing and Startup Solutions. Endless use-cases that make it highly flexible, adaptable, and scalable.', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your description here', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'cell_content_type' => 'el_template',
					'edit_testimonial' => 'yes',
				]
			]
		);

		$repeater->add_control(
			'avatar',
			[
				'label' => esc_html__( 'Avatar', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'cell_content_type' => 'el_template',
					'edit_testimonial' => 'yes',
				]
			]
		);

		$repeater->add_control(
			'cell_content', [
				'label' => __( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( '<p>Item content. Click the edit button to change this text.</p>' , 'aihub-core' ),
				'show_label' => false,
				'condition'=> [
					'cell_content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'cell_content_type' => 'image'
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'default' => 'full',
				'condition' => [
					'cell_content_type' => 'image'
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cell_content_typography',
				'label' => __( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition'=> [
					'cell_content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_responsive_control(
			'cell_text_align',
			[
				'label' => __( 'Text align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'aihub-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'aihub-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __( 'End', 'aihub-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'display: inline-block',
				],
				'toggle' => true,
				'condition'=> [
					'cell_content_type' => [ 'tinymce', 'image' ]
				],
			]
		);

		$repeater->add_responsive_control(
			'cell_whitespace',
			[
				'label' => __( 'Whitespace', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					''  => [
						'title' => __( 'Normal', 'aihub-core' ),
						'icon' => 'eicon-wrap'
					],
					'nowrap' => [
						'title' => __( 'Nowrap', 'aihub-core' ),
						'icon' => 'eicon-nowrap'
					],
				],
				'default' => '',
				'condition'=> [
					'cell_content_type!' => 'image'
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'white-space: {{VALUE}};'
				]
			]
		);

		$repeater->add_control(
			'cell_content_color',
			[
				'label' => __( 'Text color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
				'condition'=> [
					'cell_content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_responsive_control(
			'cell_width',
			[
				'label' => __( 'Cell width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
				'separator' => 'before'
			]
		);

		$repeater->add_group_control(
			'liquid-background-css',
			[
				'name' => 'cell_background',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
			]
		);

		$repeater->add_control(
			'cell_look_mouse',
			[
				'label' => esc_html__( 'Look at cursor?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition'=> [
					'cell_content_type' => 'image'
				],
			]
		);

		$this->add_control(
			'cells',
			[
				'label' => __( 'Cells', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'cell_content' => __( '<p>Item content. Click the edit button to change this text.</p>', 'aihub-core' ),
					],
					[
						'cell_content' => __( '<p>Item content. Click the edit button to change this text.</p>', 'aihub-core' ),
					],
					[
						'cell_content' => __( '<p>Item content. Click the edit button to change this text.</p>', 'aihub-core' ),
					],
					[
						'cell_content' => __( '<p>Item content. Click the edit button to change this text.</p>', 'aihub-core' ),
					],
				],
			]
		);

		$this->add_control(
			'cells_align',
			[
				'label' => __( 'Cells align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'start',
				'toggle' => false
			]
		);

		$this->add_control(
			'friction',
			[
				'label' => esc_html__( 'Friction', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Default is 0.28', 'aihub-core' ),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 0.28
				],
				'range' => [
					'px' => [
						'min' => 0.01,
						'max' => 2,
						'step' => 0.01
					]
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'selected_attraction',
			[
				'label' => esc_html__( 'Selected attraction', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Default is 0.025', 'aihub-core' ),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 0.025
				],
				'range' => [
					'px' => [
						'min' => 0.01,
						'max' => 2,
						'step' => 0.001
					]
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'wrap_around',
			[
				'label' => __( 'Loop', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER
			]
		);

		$this->add_control(
			'group_cells',
			[
				'label' => __( 'Group cells', 'aihub-core' ),
				'description' => __( 'Enable this option if you want the navigation being mapped to grouped cells, not individual cells.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'adaptive_height',
			[
				'label' => __( 'Adaptive height', 'aihub-core' ),
				'description' => __( 'Height of the carousel will change based on active slide.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'equal_height' => ''
				]
			]
		);

		$this->add_control(
			'equal_height',
			[
				'label' => __( 'Equal height cells', 'aihub-core' ),
				'description' => __( 'Height of all carousel cells will be the same.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'adaptive_height' => ''
				]
			]
		);

		$this->add_control(
			'draggable',
			[
				'label' => __( 'Draggable', 'aihub-core' ),
				'description' => __( 'Enable/Disable draggableity of the carousel.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'free_scroll',
			[
				'label' => __( 'Free scroll', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'draggable' => 'yes'
				]
			]
		);

		$this->add_control(
			'free_scroll_friction',
			[
				'label' => esc_html__( 'Free scroll friction', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Default is 0.075', 'aihub-core' ),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 0.075
				],
				'range' => [
					'px' => [
						'min' => 0.001,
						'max' => 2,
						'step' => 0.01
					]
				],
				'render_type' => 'template',
				'condition' => [
					'draggable' => 'yes',
					'free_scroll' => 'yes'
				]
			]
		);

		$this->add_control(
			'autoplay_time',
			[
				'label' => __( 'Autoplay delay', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'description' => __( 'Set a number if you want to enable autoplay. Number should be in <strong>milliseconds</strong>.', 'aihub-core' ),
				'placeholder' => '0',
				'step' => 1000,
			]
		);

		$this->add_control(
			'pause_autoplay_onhover',
			[
				'label' => __( 'Pause autoplay on hover', 'aihub-core' ),
				'description' => __( 'Pause the autoplay each time user hovers over the carousel.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'autoplay_time!' => '',
				]
			]
		);

		$this->add_control(
			'connected_carousels',
			[
				'label' => __( 'Connected carousels', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'A ids of carousels that change slides with this carousel. Separate by comma. Without the hash (#)', 'aihub-core' ),
				'placeholder' => 'image-carousel, text-carousel',
				'label_block' => true,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'nav_buttons',
			[
				'label' => __( 'Navigation buttons', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'pagination_dots',
			[
				'label' => __( 'Pagination dots', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'slides_indicator',
			[
				'label' => __( 'Slides indicator', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		// Navigation Section
		$this->start_controls_section(
		'navigation_section',
			[
				'label' => __( 'Navigation', 'aihub-core' ),
				'condition' => [
					'nav_buttons' => 'yes'
				]
			]
		);

		$this->add_control(
			'nav_arrows_style',
			[
				'label' => __( 'Style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => __( 'Style 1', 'aihub-core' ),
					'custom' => __( 'Custom', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'nav_prev_icon',
			[
				'label' => esc_html__( 'Previous icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'default' => [
					'value' => 'fas fa-arrow-left',
					'library' => 'fa-solid',
				],
				'condition' => [
					'nav_arrows_style' => 'custom'
				]
			]
		);

		$this->add_control(
			'nav_next_icon',
			[
				'label' => esc_html__( 'Next icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'nav_arrows_style' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'nav_placement',
			[
				'label' => __( 'Placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'outside' => [
						'title' => esc_html__( 'Outside', 'aihub-core' ),
						'icon' => 'eicon-sign-out',
					],
					'inside' => [
						'title' => esc_html__( 'Inside', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'default' => 'outside',
				'toggle' => false,
				'selectors_dictionary' => [
					'outside' => 'relative',
					'inside' => 'absolute'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => 'position: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'nav_align',
			[
				'label' => __( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Space between', 'aihub-core' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => 'justify-content: {{VALUE}};'
				],
				'condition' => [
					'nav_separate_buttons_offset' => ''
				],
			]
		);

		$this->add_responsive_control(
			'nav_orientation_h',
			[
				'label' => esc_html__( 'Horizontal orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'start',
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto',
					'end' => 'inset-inline-start: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'nav_offset_x',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 0
				],
				'condition' => [
					'nav_orientation_h' => 'start'
				],
			]
		);

		$this->add_responsive_control(
			'nav_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'nav_orientation_h' => 'end'
				],
			]
		);

		$this->add_responsive_control(
			'nav_orientation_v',
			[
				'label' => esc_html__( 'Vertical orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'bottom: auto',
					'bottom' => 'top: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'nav_offset_y',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => 'top: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 50
				],
				'condition' => [
					'nav_orientation_v' => 'top'
				],
			]
		);

		$this->add_responsive_control(
			'nav_offset_y_bottom',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'nav_orientation_v' => 'bottom'
				],
			]
		);

		$this->add_control(
			'nav_separate_buttons_offset',
			[
				'label' => __( 'Offset buttons separately', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
				]
			]
		);

		$this->add_responsive_control(
			'prev_button_orientation_h',
			[
				'label' => esc_html__( 'Prev button Horizontal orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'start',
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto',
					'end' => 'inset-inline-start: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-prev' => '{{VALUE}}',
				],
				'condition' => [
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'prev_button_offset_x',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-prev' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 0
				],
				'condition' => [
					'prev_button_orientation_h' => 'start',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'prev_button_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-prev' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'prev_button_orientation_h' => 'end',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'prev_button_orientation_v',
			[
				'label' => esc_html__( 'Prev button vertical orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'bottom: auto',
					'bottom' => 'top: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-prev' => '{{VALUE}}',
				],
				'condition' => [
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'prev_button_offset_y',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-prev' => 'top: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 50
				],
				'condition' => [
					'prev_button_orientation_v' => 'top',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'prev_button_offset_y_bottom',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-prev' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'prev_button_orientation_v' => 'bottom',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'next_button_orientation_h',
			[
				'label' => esc_html__( 'Next button horizontal orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'end',
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto',
					'end' => 'inset-inline-start: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-next' => '{{VALUE}}',
				],
				'condition' => [
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'next_button_offset_x',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-next' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 0
				],
				'condition' => [
					'next_button_orientation_h' => 'start',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'next_button_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-next' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 0
				],
				'condition' => [
					'next_button_orientation_h' => 'end',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'next_button_orientation_v',
			[
				'label' => esc_html__( 'Next button vertical orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'bottom: auto',
					'bottom' => 'top: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-next' => '{{VALUE}}',
				],
				'condition' => [
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'next_button_offset_y',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-next' => 'top: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 50
				],
				'condition' => [
					'next_button_orientation_v' => 'top',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'next_button_offset_y_bottom',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-nav-next' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'unit' => '%',
					'size' => 50
				],
				'condition' => [
					'next_button_orientation_v' => 'bottom',
					'nav_separate_buttons_offset' => 'yes'
				],
			]
		);

		$this->add_control(
			'nav_appear_onhover',
			[
				'label' => __( 'Appear on hover', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'nav_placement' => 'inside'
				]
			]
		);

		$this->end_controls_section();

		// Pagination Dots
		$this->start_controls_section(
			'pagination_dots_section',
			[
				'label' => __( 'Pagination dots', 'aihub-core' ),
				'condition' => [
					'pagination_dots' => 'yes'
				]
			]
		);

		$this->add_control(
			'dots_style',
			[
				'label' => __( 'Style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => __( 'Style 1', 'aihub-core' ),
				],
				'default' => '1'
			]
		);

		$this->add_responsive_control(
			'dots_placement',
			[
				'label' => __( 'Placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'outside' => [
						'title' => esc_html__( 'Outside', 'aihub-core' ),
						'icon' => 'eicon-sign-out',
					],
					'inside' => [
						'title' => esc_html__( 'Inside', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'default' => 'outside',
				'toggle' => false,
				'selectors_dictionary' => [
					'outside' => 'relative',
					'inside' => 'absolute',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => 'position: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'dots_align',
			[
				'label' => __( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Space between', 'aihub-core' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => 'justify-content: {{VALUE}};'
				],
				'condition' => [
					'dots_placement' => 'outside'
				]
			]
		);

		$this->add_responsive_control(
			'dots_placement_h',
			[
				'label' => esc_html__( 'Horizontal placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'start',
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto',
					'end' => 'inset-inline-start: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'dots_offset_x',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dots_placement_h' => 'start'
				],
			]
		);

		$this->add_responsive_control(
			'dots_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dots_placement_h' => 'end'
				],
			]
		);

		$this->add_responsive_control(
			'dots_placement_v',
			[
				'label' => esc_html__( 'Vertical placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'bottom: auto',
					'bottom' => 'top: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'dots_offset_y',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dots_placement_v' => 'top'
				],
			]
		);

		$this->add_responsive_control(
			'dots_offset_y_bottom',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-dots' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dots_placement_v' => 'bottom'
				],
			]
		);

		$this->end_controls_section();

		// Slides Indicator Section
		$this->start_controls_section(
			'slides_indicator_section',
			[
				'label' => __( 'Slides indicator', 'aihub-core' ),
				'condition' => [
					'slides_indicator' => 'yes'
				]
			]
		);

		$this->add_control(
			'slides_indicator_numbers',
			[
				'label' => __( 'Show current & total numbers?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'slides_indicator' => 'yes'
				]
			]
		);

		$this->add_control(
			'slides_indicator_numbers_leading_zero',
			[
				'label' => __( 'Numbers leading zero?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_numbers' => 'yes',
				]
			]
		);

		$this->add_control(
			'slides_indicator_tail',
			[
				'label' => __( 'Process tail?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'slides_indicator' => 'yes'
				]
			]
		);

		$this->add_control(
			'slides_indicator_inline_w_nav',
			[
				'label' => __( 'Inline with navigation?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'slides_indicator' => 'yes',
					'nav_buttons' => 'yes',
					'slides_indicator_inline_w_dots' => '',
				]
			]
		);

		$this->add_responsive_control(
			'slides_indicator_inline_w_nav_placement',
			[
				'label' => __( 'Placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'condition' => [
					'slides_indicator' => 'yes',
					'nav_buttons' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => 'yes',
				]
			]
		);

		$this->add_control(
			'slides_indicator_inline_w_dots',
			[
				'label' => __( 'Inline with dots?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'slides_indicator' => 'yes',
					'pagination_dots' => 'yes',
					'slides_indicator_inline_w_nav' => '',
				]
			]
		);

		$this->add_responsive_control(
			'slides_indicator_inline_w_dots_placement',
			[
				'label' => __( 'Placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => 'yes',
					'slides_indicator_inline_w_nav' => '',
				]
			]
		);

		$this->add_control(
			'slides_indicator_placement',
			[
				'label' => __( 'Placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'outside' => [
						'title' => esc_html__( 'Outside', 'aihub-core' ),
						'icon' => 'eicon-sign-out',
					],
					'inside' => [
						'title' => esc_html__( 'Inside', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'default' => 'outside',
				'toggle' => false,
				'condition' => [
					'slides_indicator' => 'yes',
					'pagination_dots' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
				]
			]
		);

		$this->add_responsive_control(
			'slides_indicator_align',
			[
				'label' => __( 'Alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Space between', 'aihub-core' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-slides-ind' => 'justify-content: {{VALUE}};'
				],
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
					'slides_indicator_placement' => 'outside'
				]
			]
		);

		$this->add_control(
			'slides_indicator_placement_h',
			[
				'label' => esc_html__( 'Horizontal placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'start',
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
					'slides_indicator_placement' => 'inside',
				],
			]
		);

		$this->add_responsive_control(
			'slides_indicator_offset_x',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-slides-ind' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
					'slides_indicator_placement' => 'inside',
					'slides_indicator_placement_h' => 'start'
				],
			]
		);

		$this->add_responsive_control(
			'slides_indicator_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-slides-ind' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
					'slides_indicator_placement' => 'inside',
					'slides_indicator_placement_h' => 'end'
				],
			]
		);

		$this->add_control(
			'slides_indicator_placement_v',
			[
				'label' => esc_html__( 'Vertical placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
					'slides_indicator_placement' => 'inside',
				],
			]
		);

		$this->add_responsive_control(
			'slides_indicator_offset_y',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-slides-ind' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
					'slides_indicator_placement' => 'inside',
					'slides_indicator_placement_v' => 'top'
				],
			]
		);

		$this->add_responsive_control(
			'slides_indicator_offset_y_bottom',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-slides-ind' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'slides_indicator' => 'yes',
					'slides_indicator_inline_w_dots' => '',
					'slides_indicator_inline_w_nav' => '',
					'slides_indicator_placement' => 'inside',
					'slides_indicator_placement_v' => 'bottom'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_effects_section',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_carousel_effect_cell_inactive',
			[
				'label' => __( 'Inactive cells effect', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 30,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_z',
			[
				'label' => __( 'Translate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-z: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_scale',
			[
				'label' => __( 'Scale', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-scale: {{SIZE}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_skewX',
			[
				'label' => __( 'Skew X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-skewX: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_skewY',
			[
				'label' => __( 'Skew Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-skewY: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_rotateX',
			[
				'label' => __( 'Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-rotateX: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_rotateY',
			[
				'label' => __( 'Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-rotateY: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_rotateZ',
			[
				'label' => __( 'Rotate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-rotateZ: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_opacity',
			[
				'label' => __( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-opacity: {{SIZE}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_inactive_blur',
			[
				'label' => __( 'Blur', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-carousel-cell-effect-blur: {{SIZE}}px'
				],
				'condition' => [
					'lqd_carousel_effect_cell_inactive' => 'yes',
				]
			]
		);

		$this->end_popover();

		$this->add_control(
			'lqd_carousel_effect_cell_active',
			[
				'label' => __( 'Active cells effect', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_z',
			[
				'label' => __( 'Translate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-z: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_scale',
			[
				'label' => __( 'Scale', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-scale: {{SIZE}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_skewX',
			[
				'label' => __( 'Skew X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-skewX: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_skewY',
			[
				'label' => __( 'Skew Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-skewY: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_rotateX',
			[
				'label' => __( 'Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-rotateX: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_rotateY',
			[
				'label' => __( 'Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-rotateY: {{SIZE}}deg',
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_rotateZ',
			[
				'label' => __( 'Rotate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-rotateZ: {{SIZE}}deg'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_opacity',
			[
				'label' => __( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-opacity: {{SIZE}}'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'lqd_carousel_effect_cells_active_blur',
			[
				'label' => __( 'Blur', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-carousel-cell.lqd-carousel-cell-active' => '--lqd-carousel-cell-effect-blur: {{SIZE}}px'
				],
				'condition' => [
					'lqd_carousel_effect_cell_active' => 'yes',
				]
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'carousel',
			[
				'cell' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'raw',
							'responsive' => true,
							'tab' => 'none',
							'raw_options' => [
								'cell_text_align',
								[
									'label' => __( 'Text align', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'start' => [
											'title' => __( 'Start', 'aihub-core' ),
											'icon' => 'eicon-text-align-left',
										],
										'center' => [
											'title' => __( 'Center', 'aihub-core' ),
											'icon' => 'eicon-text-align-center',
										],
										'end' => [
											'title' => __( 'End', 'aihub-core' ),
											'icon' => 'eicon-text-align-right',
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-carousel-cell' => 'text-align: {{VALUE}}',
										'{{WRAPPER}} img' => 'display: inline-block',
									],
								]
							]
						],
						[
							'type' => 'width',
							'css_var' => '--lqd-carousel-cell-w',
							'default' => [
								'unit' => '%',
								'size' => '33.33'
							]
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-carousel-cell-m',
							'default' => [
								'top' => '0',
								'right' => '30',
								'bottom' => '0',
								'left' => '0',
								'unit' => 'px',
								'isLinked' => false
							]
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-carousel-cell-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-carousel-cell-color',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-carousel-cell-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-carousel-cell-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-carousel-cell-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors' => [ 'active' => '.lqd-carousel-cell-active' ]
				],
				'nav' => [
					'label' => 'Navigation button',
					'controls' => [
						[
							'type' => 'font_size',
							'label' => 'Icon size',
							'css_var' => '--lqd-carousel-nav-icon-size'
						],
						[
							'type' => 'gap',
							'label' => 'Gap between buttons',
							'css_var' => '--lqd-carousel-nav-gap'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'css_var' => '--lqd-carousel-nav-btn'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-carousel-nav-btn-color',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-carousel-nav-btn-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-carousel-nav-btn-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-carousel-nav-btn-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-carousel-nav-btn-bs'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'nav_rotate',
								[
									'label' => esc_html__( 'Rotation', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'range' => [
										'px' => [
											'min' => -360,
											'max' => 360,
											'step' => 1,
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-carousel-nav' => 'transform: rotate({{SIZE}}deg)',
									],
								]
							],
							'tab' => 'none',
							'responsive' => true
						],
					],
					'condition' => [
						'nav_buttons' => 'yes'
					],
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors' => [ 'hover' => ' .lqd-carousel-nav-btn:not([disabled]):hover' ]
				],
				'dots' => [
					'label' => 'Pagination dot',
					'controls' => [
						[
							'type' => 'gap',
							'label' => 'Gap between dots',
							'css_var' => '--lqd-carousel-dots-gap'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'css_var' => '--lqd-carousel-dots'
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-carousel-dots-m'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-carousel-dots-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-carousel-dots-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-carousel-dots-brr',
							'selector' => '.lqd-carousel-dots .lqd-carousel-dot'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-carousel-dots-bs'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'dots_rotate',
								[
									'label' => esc_html__( 'Rotation', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'range' => [
										'px' => [
											'min' => -360,
											'max' => 360,
											'step' => 1,
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-carousel-dots' => 'transform: rotate({{SIZE}}deg)',
									],
								]
							],
							'tab' => 'none',
							'responsive' => true
						],
					],
					'condition' => [
						'pagination_dots' => 'yes'
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors' => [ 'hover' => ' .lqd-carousel-dot:hover', 'active' => ' .lqd-carousel-dot-active' ]
				],
				'slides_indicator' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'gap',
						],
						[
							'type' => 'width',
							'label' => 'Indicator width',
							'css_var' => '--lqd-carousel-slide-progress-w'
						],
						[
							'type' => 'height',
							'label' => 'Indicator height',
							'css_var' => '--lqd-carousel-slide-progress-h'
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'slides_indicator_bar_wrap_bg',
							'label' => 'Indicator background',
							'css_var' => '--lqd-carousel-slide-bar-wrap-bg',
							'fields_options' => [
								'background' => [
									'label' => esc_html__( 'Bar background', 'aihub-core' ),
								],
							],
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'slides_indicator_bar_bg',
							'label' => 'Indicator bar background',
							'css_var' => '--lqd-carousel-slide-bar-bg',
							'fields_options' => [
								'background' => [
									'label' => esc_html__( 'Filled bar background', 'aihub-core' ),
								],
							],
						],
						[
							'type' => 'liquid_color',
							'name' => 'slides_indicator_color',
							'label' => 'Numbers color'
						],

						[
							'type' => 'raw',
							'raw_options' => [
								'slides_indicator_rotate',
								[
									'label' => esc_html__( 'Rotation', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'range' => [
										'px' => [
											'min' => -360,
											'max' => 360,
											'step' => 1,
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-carousel-slides-ind' => 'transform: rotate({{SIZE}}deg)',
									],
								]
							],
							'tab' => 'none',
							'responsive' => true
						],
					],
					'selector' => '.lqd-carousel-slides-ind',
					'condition' => [
						'slides_indicator' => 'yes'
					]
				]
			],
		);
	}

	protected function add_render_attributes() {

		parent::add_render_attributes();

		$wrapper_classnames[] = 'lqd-group-carousel';

		if ( empty( $this->get_settings_for_display( '_element_width' ) ) ) {
			$wrapper_classnames[] = 'w-full';
		}

		$this->add_render_attribute( '_wrapper', [
			'class' => $wrapper_classnames
		] );

	}

	protected function get_nav_icons_style_custom( $settings ) {
		$arrows = [
			'prev' => '',
			'next' => ''
		];

		if ( !empty( $settings['nav_prev_icon']['value'] ) ) {
			$arrows['prev'] = Icons_Manager::try_get_icon_html( $settings['nav_prev_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		}
		if ( !empty( $settings['nav_next_icon']['value'] ) ) {
			$arrows['next'] = Icons_Manager::try_get_icon_html( $settings['nav_next_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		}

		return $arrows;
	}

	protected function get_nav_icons_style_1( $settings ) {
		return [
			'prev' => '<svg width="16" height="13" viewBox="0 0 16 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M6.029 -9.53674e-07L6.972 0.942999L2.522 5.393L15.688 5.393V6.706L2.522 6.706L6.972 11.156L6.029 12.099L0.451004 6.525L3.8147e-06 6.053L0.451004 5.581L6.029 -9.53674e-07Z"/></svg>',
			'next' => '<svg width="16" height="13" viewBox="0 0 16 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M9.659 0L8.716 0.943L13.166 5.393H0V6.706H13.166L8.716 11.156L9.659 12.099L15.237 6.525L15.688 6.053L15.237 5.581L9.659 0Z"/></svg>'
		];
	}

	protected function get_nav( $settings ) {

		if ( empty( $settings['nav_buttons'] ) ) return '';

		$nav_classnames = [ 'lqd-carousel-nav', 'flex', 'items-center', 'w-full', 'pointer-events-none' ];
		$buttons_common_classnames = [ 'lqd-carousel-nav-btn', 'inline-flex', 'items-center', 'justify-center', 'pointer-events-auto', 'transition-all', 'cursor-pointer' ];
		$nav_style = $settings['nav_arrows_style'];
		$slides_indicator = $settings['slides_indicator'];
		$slides_indicator_is_inline = $settings['slides_indicator_inline_w_nav'];
		$slides_indicator_placement = $settings['slides_indicator_inline_w_nav_placement'];
		$should_get_slides_indicator = $slides_indicator === 'yes' && $slides_indicator_is_inline === 'yes';

		if ( $settings['nav_separate_buttons_offset'] === 'yes' ) {
			$buttons_common_classnames[] = 'absolute';
		}
		if ( $settings['nav_appear_onhover'] === 'yes' ) {
			$buttons_common_classnames[] = 'opacity-0';
			$buttons_common_classnames[] = 'lqd-group-carousel-hover:opacity-100';
		}

		$this->add_render_attribute( 'carousel_nav_prev_btn', [
			'class' => array_merge(
				['lqd-carousel-nav-prev'],
				$buttons_common_classnames
			),
			'type' => 'button',
			'aria-label' => esc_attr__('Previous', 'aihub-core'),
			'disabled' => true
		] );
		$this->add_render_attribute( 'carousel_nav_next_btn', [
			'class' => array_merge(
				['lqd-carousel-nav-next'],
				$buttons_common_classnames
			),
			'type' => 'button',
			'aria-label' => esc_attr__('Next', 'aihub-core'),
			'disabled' => true
		] );
		$this->add_render_attribute( 'carousel_nav', [
			'class' => $nav_classnames
		] );

		$nav_icons = $this->{'get_nav_icons_style_' . $nav_style}( $settings );

		?><div <?php $this->print_render_attribute_string( 'carousel_nav' ) ?>>
			<?php if ( $should_get_slides_indicator && $slides_indicator_placement === 'start' ) {
				$this->get_slides_indicator( $settings );
			} ?>
			<button <?php $this->print_render_attribute_string('carousel_nav_prev_btn'); ?>><?php
				echo $nav_icons['prev'];
			?></button>
			<?php if ( $should_get_slides_indicator && $slides_indicator_placement === 'center' ) {
				$this->get_slides_indicator( $settings );
			} ?>
			<button <?php $this->print_render_attribute_string('carousel_nav_next_btn'); ?>><?php
				echo $nav_icons['next'];
			?></button>
			<?php if ( $should_get_slides_indicator && $slides_indicator_placement === 'end' ) {
				$this->get_slides_indicator( $settings );
			} ?>
		</div><?php

	}

	protected function get_dots( $settings ) {

		if ( empty( $settings['pagination_dots'] ) ) return '';

		$slides_indicator = $settings['slides_indicator'];
		$slides_indicator_is_inline = $settings['slides_indicator_inline_w_dots'];
		$slides_indicator_placement = $settings['slides_indicator_inline_w_dots_placement'];
		$should_get_slides_indicator = $slides_indicator === 'yes' && $slides_indicator_is_inline === 'yes';

		if ( $should_get_slides_indicator && $slides_indicator_placement === 'start' ) {
			$this->get_slides_indicator( $settings );
		} ?>
		<div class="lqd-carousel-dots lqd-carousel-dots-empty flex"></div>
		<?php if ( $should_get_slides_indicator && $slides_indicator_placement === 'end' ) {
			$this->get_slides_indicator( $settings );
		}

	}

	protected function get_slides_indicator( $settings ) {

		if ( empty( $settings['slides_indicator'] ) ) return '';

		$this->add_render_attribute( 'slides-indicator-wrapper', 'class', 'lqd-carousel-slides-ind lqd-carousel-slides-ind-<?php echo esc_attr( $this->get_id() ) ?> flex items-center gap-20 text-14');

		if ( $settings['slides_indicator_tail'] === '' ) {
			$this->add_render_attribute( 'slides-indicator-wrapper', 'class', 'lqd-carousel-slides-ind-no-tail');
		}

		?><div <?php $this->print_render_attribute_string( 'slides-indicator-wrapper') ; ?>>
			<span class="lqd-carousel-slides-ind-current shrink-0"></span>
			<span class="lqd-carousel-slides-ind-progress-wrap flex items-center relative">
				<span class="lqd-carousel-slides-ind-progress-bar inline-block w-full h-full absolute top-0 start-0 lqd-transform origin-left transition-all"></span>
			</span>
			<span class="lqd-carousel-slides-ind-total shrink-0"></span>
		</div><?php

	}

	protected function get_cell_content_type_tinymce( $cell, $i ) {

		$this->print_text_editor( $cell['cell_content'] );

	}

	protected function get_cell_content_type_image( $cell, $i ) {

		$fig_classnames = [ 'lqd-carousel-content-img', 'overflow-hidden' ];
		$fig_attrs = [
			'class' => $fig_classnames
		];
		$fig_attrs_id = $this->get_repeater_setting_key( 'cell_content', 'cells', $i );

		if ( $cell['cell_look_mouse'] === 'yes' ) {
			$fig_attrs['data-lqd-look-at-mouse'] = true;
		};

		$this->add_render_attribute( $fig_attrs_id, $fig_attrs );

		?>
		<figure <?php $this->print_render_attribute_string( $fig_attrs_id ) ?>><?php
			Group_Control_Image_Size::print_attachment_image_html( $cell );
		?></figure>
		<?php

	}

	protected function get_cell_content_type_el_template( $cell, $i ) {

		$content = \Elementor\Plugin::instance()->frontend->get_builder_content( $cell[ 'cell_templates' ], $with_css = true );

		if ( $cell['edit_testimonial'] === 'yes' ) {

			$replaces = [
				$cell['name'] => [
					'lqd-testimonial-meta-name">',
					'/lqd-testimonial-meta-name">(.*?)<\//',
					'</'
				],
				$cell['title'] => [
					'lqd-testimonial-meta-title">',
					'/lqd-testimonial-meta-title">(.*?)<\//',
					'</'
				],
				$cell['content'] => [
					'lqd-testimonial-quote">',
					'/lqd-testimonial-quote">(.*?)<\//',
					'</'
				],
				$cell['avatar']['id'] => [
					'lqd-testimonial-meta-avatar">',
					'/lqd-testimonial-meta-avatar">(.*?)<\//',
					'</'
				],
			];

			foreach( $replaces as $replace => $regex ) {
				$replace = is_int( $replace ) ? wp_get_attachment_image( $replace, 'full' ) : $replace;

				if ( !empty( $replace ) ) {
					$content = preg_replace($regex[1],  $regex[0] . $replace . $regex[2], $content);
				}
			}

		}

		echo $content;

	}

	protected function get_cell_content( $cell, $i ) {

		/**
		 * @type {string} tinymce | image | el_template
		 */
		$content_type = $cell['cell_content_type'];

		$this->{'get_cell_content_type_' . $content_type}( $cell, $i );

	}

	protected function get_cells_contents( $settings ) {

		$cells = $settings['cells'];
		$cells_common_classnames = [ 'lqd-carousel-cell', 'lqd-filter-item', 'shrink-0', 'grow-0', 'basis-auto', 'relative', 'transition-effects' ];

		foreach ( $cells as $i => $cell ) {

			$cell_attrs_id = $this->get_repeater_setting_key( 'cell', 'cells', $i );
			$cell_classnames = array_merge( $cells_common_classnames, [ 'elementor-repeater-item-' . esc_attr( $cell['_id'] ) . '' ] );

			$this->add_render_attribute( $cell_attrs_id, [
				'class' => $cell_classnames
			] );

		?>

		<div <?php $this->print_render_attribute_string( $cell_attrs_id ) ?>><?php
			$this->get_cell_content( $cell, $i )
		?></div>

		<?php }

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$slides_indicator = $settings['slides_indicator'];
		$slides_indicator_is_inline = ( $settings['nav_buttons'] === 'yes' && $settings['slides_indicator_inline_w_nav'] === 'yes' ) ||
			($settings['pagination_dots'] === 'yes' && $settings['slides_indicator_inline_w_dots'] === 'yes');

		?>

		<div class="lqd-carousel-viewport relative overflow-hidden">
			<div class="lqd-carousel-slider flex relative"><?php
				$this->get_cells_contents( $settings );
			?></div>
		</div>
		<?php
			$this->get_nav( $settings );
			$this->get_dots( $settings );
			if ( !$slides_indicator_is_inline ) {
				$this->get_slides_indicator( $settings );
			}
		?>
		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Carousel() );