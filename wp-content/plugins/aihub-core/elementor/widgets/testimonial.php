<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Testimonial extends Widget_Base {

	public function get_name() {
		return 'lqd-testimonial';
	}

	public function get_title() {
		return __( 'Liquid Testimonial', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-testimonial lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'review' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'part',
			[
				'label' => esc_html__( 'Type', 'aihub-core' ),
				'type' =>Controls_Manager::SELECT,
				'label_block' => true,
				'options' => [
					'meta' => esc_html__( 'Meta', 'aihub-core' ),
					'quote'  => esc_html__( 'Quote', 'aihub-core' ),
					'rating' => esc_html__( 'Rating', 'aihub-core' ),
					'media' => esc_html__( 'Media (Image and icon)', 'aihub-core' ),
					'divider' => esc_html__( 'Divider', 'aihub-core' ),
				],
				'default' => 'meta'
			]
		);

		$repeater->add_control(
			'media_type',
			[
				'label' => esc_html__( 'Media type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'none' => [
						'title' => esc_html__( 'None', 'aihub-core' ),
						'icon' => 'eicon-minus-circle-o',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'aihub-core' ),
						'icon' => 'eicon-star-o',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'aihub-core' ),
						'icon' => 'eicon-image',
					],
				],
				'default' => 'none',
				'toggle' => false,
				'separator' => 'before',
				'condition' => [
					'part' => 'media'
				]
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'part' => 'media',
					'media_type' => 'icon'
				]
			]
		);

		$repeater->add_control(
			'selected_image',
			[
				'label' => esc_html__( 'Choose Image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'part' => 'media',
					'media_type' => 'image'
				]
			]
		);

		$repeater->add_responsive_control(
			'media_dimension',
			[
				'label' => esc_html__( 'Dimension', 'aihub-core' ),
				'type' => 'liquid-linked-dimensions',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{WIDTH}}{{UNIT}}; height: {{HEIGHT}}{{UNIT}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: 100%; height: 100%; object-fit: cover; object-position: center;',
				],
				'condition' => [
					'part' => 'media',
					'media_type!' => 'none'
				]
			]
		);

		$repeater->add_responsive_control(
			'selected_icon_size',
			[
				'label' => esc_html__( 'Size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'part' => 'media',
					'media_type' => 'icon'
				]
			]
		);

		$repeater->add_responsive_control(
			'selected_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'part' => 'media',
					'media_type' => 'icon'
				]
			]
		);

		$repeater->add_responsive_control(
			'media_roundness',
			[
				'label' => esc_html__( 'Roundess', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'part' => 'media',
					'media_type!' => 'none'
				]
			]
		);

		$repeater->add_control(
			'selected_icon_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
				'condition' => [
					'part' => 'media',
					'media_type' => 'icon'
				]
			]
		);

		$repeater->add_group_control(
			'liquid-background-css',
			[
				'name' => 'selected_icon_background',
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'part' => 'media',
					'media_type' => 'icon'
				]
			]
		);

		$repeater->add_control(
			'separate_part',
			[
				'label' => esc_html__( 'Separate this part?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => [
					'part' => 'media',
					'media_type!' => 'none'
				]
			]
		);

		$this->add_control(
			'content_parts',
			[
				'label' => esc_html__( 'Content parts', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'part' => 'meta' ],
					[ 'part' => 'quote' ],
				],
				'title_field' => '{{{ `${part.charAt(0).toUpperCase()}${part.substring(1)}` }}}',
				'separator' => 'before'
			]
		);

		$this->add_control(
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
				'separator' => 'before'
			]
		);

		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your title here', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Developer', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your title here', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'quote',
			[
				'label' => esc_html__( 'Quote', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'All in one Landing and Startup Solutions. Endless use-cases that make it highly flexible, adaptable, and scalable.', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'rating_heading',
			[
				'label' => esc_html__( 'Rating', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rating_scale',
			[
				'label' => __( 'Total', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 3,
				'max' => 10,
				'step' => 1,
				'default' => 5
			]
		);

		$this->add_control(
			'rating',
			[
				'label' => __( 'Rating', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 5
			]
		);

		$this->add_control(
			'rating_label',
			[
				'label' => esc_html__( 'Enable label?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'rating_scale!' => '',
					'rating!' => '',
				],
			]
		);

		$this->add_control(
			'rating_label_format',
			[
				'label' => esc_html__( 'Label format', 'aihub-core' ),
				'type' =>Controls_Manager::SELECT,
				'options' => [
					'devided' => esc_html__( 'Devided ( 3.45/5 )', 'aihub-core' ),
					'percentage' => esc_html__( 'Percentage ( 69% )', 'aihub-core' ),
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
				],
				'default' => 'devided',
				'condition' => [
					'rating_label' => 'yes',
					'rating_scale!' => '',
					'rating!' => '',
				],
			]
		);

		$this->add_control(
			'rating_custom_label',
			[
				'label' => esc_html__( 'Custom label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'rating_label' => 'yes',
					'rating_label_format' => 'custom',
					'rating_scale!' => '',
					'rating!' => '',
				],
			]
		);

		$this->add_control(
			'rating_label_position',
			[
				'label' => esc_html__( 'Label position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => '',
				'selectors_dictionary' => [
					'end' => '2'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-star-rating-label' => 'order: {{VALUE}};',
				],
				'condition' => [
					'rating_label' => 'yes',
					'rating_scale!' => '',
					'rating!' => '',
				],
			]
		);

		$this->add_control(
			'enable_bubble',
			[
				'label' => esc_html__( 'Bubble style?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'apply_bubble_on',
			[
				'label' => esc_html__( 'Apply bubble arrow on:', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'box' => [
						'title' => esc_html__( 'Entire box', 'aihub-core' ),
						'icon' => 'eicon-container',
					],
					'quote' => [
						'title' => esc_html__( 'Quote', 'aihub-core' ),
						'icon' => 'eicon-testimonial',
					],
				],
				'default' => 'box',
				'toggle' => false,
				'condition' => [
					'enable_bubble' => 'yes'
				]
			]
		);

		$this->add_control(
			'bubble_direction',
			[
				'label' => esc_html__( 'Direction', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-arrow-up',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-arrow-right',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-arrow-down',
					],
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-arrow-left',
					],
				],
				'default' => 'bottom',
				'toggle' => false,
				'condition' => [
					'enable_bubble' => 'yes',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'aihub-core' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'testimonial',
			[
				'wrap' => [
					'label' => 'General',
					'controls' => [
						[
							'type' => 'raw',
							'tab' => 'none',
							'raw_options' => [
								'wrap_justify_content',
								[
									'label' => esc_html_x( 'Justify content', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'flex-start' => [
											'title' => esc_html_x( 'Start', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-justify-start-v',
										],
										'center' => [
											'title' => esc_html_x( 'Center', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-justify-center-v',
										],
										'flex-end' => [
											'title' => esc_html_x( 'End', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-justify-end-v',
										],
										'space-between' => [
											'title' => esc_html_x( 'Space Between', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-justify-space-between-v',
										],
										'space-around' => [
											'title' => esc_html_x( 'Space Around', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-justify-space-around-v',
										],
										'space-evenly' => [
											'title' => esc_html_x( 'Space Evenly', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-justify-space-evenly-v',
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial-wrap' => 'justify-content: {{VALUE}};',
									],
								]
							]
						],
						[
							'type' => 'raw',
							'tab' => 'none',
							'raw_options' => [
								'wrap_align_items',
								[
									'label' => esc_html_x( 'Align items', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'flex-start' => [
											'title' => esc_html_x( 'Start', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-align-start-h',
										],
										'center' => [
											'title' => esc_html_x( 'Center', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-align-center-h',
										],
										'flex-end' => [
											'title' => esc_html_x( 'End', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-align-end-h',
										],
										'stretch' => [
											'title' => esc_html_x( 'Stretch', 'aihub-core' ),
											'icon' => 'eicon-flex eicon-align-stretch-h',
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial-wrap' => 'align-items: {{VALUE}};',
									],
								]
							]
						],
						[
							'type' => 'gap',
							'label' => 'Gap between parts',
						],
						[
							'type' => 'padding',
						],
						[
							'type' => 'liquid_color',
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-testimonial'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-testimonial'
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-testimonial'
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-testimonial'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'separated_content' => [
					'controls' => [
						[
							'type' => 'width',
							'default' => [
								'unit' => '%',
								'size' => 50
							]
						]
					]
				],
				'meta' => [
					'controls' => [
						[
							'type' => 'raw',
							'raw_options' => [
								'meta_info_inline',
								[
									'label' => esc_html__( 'Inline name and title', 'aihub-core' ),
									'type' => Controls_Manager::SWITCHER,
									'return_value' => 'row',
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial-meta-info' => 'flex-direction: {{VALUE}}; align-items: center'
									]
								]
							]
						],
						[
							'type' => 'gap',
							'default' => [
								'unit' => 'px',
								'size' => 20
							]
						],
						[
							'type' => 'gap',
							'name' => 'info_gap',
							'default' => [
								'unit' => 'px',
								'size' => 10
							],
							'selector' => '.lqd-testimonial-meta-info'
						],
						[
							'type' => 'raw',
							'responsive' => true,
							'raw_options' => [
								'meta_direction',
								[
									'label' => esc_html__( 'Direction', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'' => [
											'title' => esc_html__( 'Row - horizontal', 'aihub-core' ),
											'icon' => 'eicon-arrow-right',
										],
										'column' => [
											'title' => esc_html__( 'Column - vertical', 'aihub-core' ),
											'icon' => 'eicon-arrow-down',
										],
										'row-reverse' => [
											'title' => esc_html__( 'Row - reversed', 'aihub-core' ),
											'icon' => 'eicon-arrow-left',
										],
										'column-reverse' => [
											'title' => esc_html__( 'Column - reversed', 'aihub-core' ),
											'icon' => 'eicon-arrow-up',
										],
									],
									'default' => '',
									'toggle' => false,
									'selectors' => [
										'{{SELECTOR}} .lqd-testimonial-meta' => 'flex-direction: {{VALUE}};',
									],
								]
							]
						],
						[
							'type' => 'raw',
							'responsive' => true,
							'raw_options' => [
								'meta_alignment',
								[
									'label' => esc_html__( 'Alignment', 'aihub-core' ),
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
											'icon' => 'eicon-justify-space-between-h',
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial-meta' => 'justify-content: {{VALUE}};align-self: stretch',
									],
									'condition' => [
										'meta_direction' => [ '', 'row-reverse' ]
									]
								]
							]
						],
						[
							'type' => 'raw',
							'responsive' => true,
							'raw_options' => [
								'meta_alignment_v',
								[
									'label' => esc_html__( 'Vertical alignment', 'aihub-core' ),
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
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial-meta' => 'align-items: {{VALUE}}; text-align: {{VALUE}}; align-self: stretch',
									],
									'condition' => [
										'meta_direction' => [ 'column', 'column-reverse' ]
									]
								]
							]
						],
						[
							'type' => 'margin'
						],
						[
							'type' => 'padding'
						],
					],
					'plural_heading' => false
				],
				'meta_avatar' => [
					'controls' => [
						[
							'type' => 'liquid_linked_dimensions',
							'selectors' => [
								'{{WRAPPER}} .lqd-testimonial-meta-avatar' => 'width: {{WIDTH}}{{UNIT}}; height: {{HEIGHT}}{{UNIT}}; flex: 0 0 auto;',
								'{{WRAPPER}} .lqd-testimonial-meta-avatar img' => 'width: 100%; height: 100%;object-fit:cover; object-position:center;',
							],
							'condition' => [
								'avatar[url]!' => ''
							]
						],
						[
							'type' => 'border',
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'meta_name' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'opacity',
						],
						[
							'type' => 'liquid_color',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'meta_title' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'opacity',
						],
						[
							'type' => 'liquid_color',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'quote' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'raw',
							'tab' => 'none',
							'raw_options' => [
								'quote_text_align',
								[
									'label' => esc_html__( 'Text align', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'start' => [
											'title' => esc_html__( 'Start', 'aihub-core' ),
											'icon' => 'eicon-text-align-left',
										],
										'center' => [
											'title' => esc_html__( 'Center', 'aihub-core' ),
											'icon' => 'eicon-text-align-center',
										],
										'end' => [
											'title' => esc_html__( 'End', 'aihub-core' ),
											'icon' => 'eicon-text-align-right',
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial-quote' => 'text-align: {{VALUE}};',
									],
								]
							]
						],
						[
							'type' => 'margin',
						],
						[
							'type' => 'padding',
						],
						[
							'type' => 'liquid_color',
						],
						[
							'type' => 'liquid_background_css',
						],
						[
							'type' => 'border',
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'star_rating' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'raw',
							'tab' => 'none',
							'raw_options' => [
								'rating_align',
								[
									'label' => esc_html__( 'Alignment', 'aihub-core' ),
									'type' => Controls_Manager::CHOOSE,
									'options' => [
										'stretch' => [
											'title' => esc_html__( 'Stretch', 'aihub-core' ),
											'icon' => 'eicon-h-align-stretch',
										],
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
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial-star-rating' => 'align-self: {{VALUE}};',
									],
								]
							]
						],
						[
							'type' => 'gap',
							'default' => [
								'unit' => 'px',
								'size' => 10,
							],
							'selectors' => [
								'{{WRAPPER}} .lqd-testimonial-star-rating' => 'gap: {{SIZE}}{{UNIT}};',
							],
							'condition' => [
								'rating_label' => 'yes'
							]
						],
						[
							'type' => 'margin'
						],
						[
							'type' => 'padding'
						],
						[
							'type' => 'liquid_color',
							'name' => 'li',
							'label' => 'Color',
						],
						[
							'type' => 'liquid_color',
							'name' => 'label',
							'label' => 'Label color',
							'selector' => '.lqd-testimonial-star-rating-label',
							'condition' => [
								'rating_label' => 'yes'
							]
						],
						[
							'type' => 'liquid_color',
							'name' => 'active',
							'label' => 'Active stars color',
							'selectors' => [
								'{{WRAPPER}} .lqd-star-rating-active, {{WRAPPER}} .lqd-star-rating-half-active span' => 'color: {{VALUE}}',
							],
						],
						[
							'type' => 'liquid_background_css',
						],
						[
							'type' => 'border',
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'divider' => [
					'controls' => [
						[
							'type' => 'height',
							'default' => [
								'unit' => 'px',
								'size' => 2,
							],
						],
						[
							'type' => 'margin',
						],
						[
							'type' => 'liquid_background_css',
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'bubble' => [
					'controls' => [
						[
							'type' => 'raw',
							'tab' => 'none',
							'raw_options' => [
								'bubble_offset_v',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', 'em', '%', 'custom' ],
									'range' => [
										'px' => [
											'min' => 0,
											'max' => 500,
											'step' => 1,
										],
										'em' => [
											'min' => 0,
											'max' => 50,
											'step' => 1,
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial:after, {{WRAPPER}} .lqd-testimonial-quote:after' => 'top: {{SIZE}}{{UNIT}};',
									],
									'condition' => [
										'enable_bubble' => 'yes',
										'bubble_direction' => [ 'start', 'end' ]
									]
								]
							]
						],
						[
							'type' => 'raw',
							'tab' => 'none',
							'raw_options' => [
								'bubble_offset_h',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', 'em', '%', 'custom' ],
									'range' => [
										'px' => [
											'min' => 0,
											'max' => 500,
											'step' => 1,
										],
										'em' => [
											'min' => 0,
											'max' => 50,
											'step' => 1,
										],
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-testimonial:after, {{WRAPPER}} .lqd-testimonial-quote:after' => 'inset-inline-start: {{SIZE}}{{UNIT}};',
									],
									'condition' => [
										'enable_bubble' => 'yes',
										'bubble_direction' => [ 'bottom', 'top' ]
									]
								]
							]
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '{{WRAPPER}} .lqd-testimonial:after, {{WRAPPER}} .lqd-testimonial-quote:after'
						]
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ],
					'condition' => [
						'enable_bubble' => 'yes'
					]
				],
			],
		);

	}

	protected function render_part_rating() {
		$rating_scale = $this->get_settings_for_display( 'rating_scale' );
		$rating = $this->get_settings_for_display( 'rating' );
		$rating_label = $this->get_settings_for_display( 'rating_label' );

		$star_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 1em; height: 1em;" fill="currentColor"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';

		if ( (!isset( $rating_scale ) || empty( $rating_scale )) || (!isset( $rating ) || empty( $rating )) ) return;

		$floored_rating = floor( $rating );
		$half_active = '';

		$out = '<div class="lqd-testimonial-part lqd-star-rating lqd-testimonial-star-rating flex items-center">';

		if ( $rating_label === 'yes' ) {
			$label_format = $this->get_settings_for_display( 'rating_label_format' );
			$custom_label = $this->get_settings_for_display( 'rating_custom_label' );
			$label = '';

			if ( $label_format === 'devided' ) {
				$label = $rating . '/' . $rating_scale;
			} else if ( $label_format === 'percentage' ) {
				$label = round( $rating / $rating_scale * 100, 1 ) . '%';
			} else if ( $label_format === 'custom' && !empty( $custom_label ) ) {
				$label = $custom_label;
			}

			$out .= '<span class="lqd-star-rating-label lqd-testimonial-star-rating-label leading-none">' . $label . '</span>';
		}

		$out .= '<ul class="lqd-star-rating-ul lqd-testimonial-star-rating-ul flex items-center p-0 m-0 list-none text-percent-115">';

		for ( $i = 1; $i <= $rating_scale; $i++ ) {
			$active = $i <= $rating ? 'lqd-star-rating-active text-primary' : '';
			$li_classname = 'lqd-star-rating-li lqd-testimonial-star-rating-li relative';
			if ( !empty( $half_active ) ) {
				$li_classname .= ' ' . $half_active;
			} else if ( !empty( $active ) ) {
				$li_classname .= ' ' . $active;
			}
			$out .= '<li class="' . $li_classname . '">';
			$out .= $star_svg;
			if ( !empty( $half_active ) ) {
				$width = ($rating - $floored_rating) * 100;
				$out .= '<span style="width:' . $width . '%;" class="block w-full h-full absolute top-0 start-0 text-primary whitespace-nowrap overflow-hidden">' . $star_svg . '</span>';
			}
			$out .= '</li>';
			// saving for the next round
			$half_active = $floored_rating == $i ? 'lqd-star-rating-half-active' : '';
		}

		$out .= '</ul>';
		$out .= '</div>';

		echo $out;
	}

	protected function render_part_quote( $part ) {

		$quote = $this->get_settings_for_display( 'quote' );
		$enable_bubble = $this->get_settings_for_display( 'enable_bubble' );
		$apply_bubble_on = $this->get_settings_for_display( 'apply_bubble_on' );
		$classnames = [];

		if ( $enable_bubble === 'yes' && $apply_bubble_on === 'quote' ) {
			$classnames = array_merge( $classnames, $this->get_bubble_classnames() );
		}

		if ( !empty( $quote ) ) {
			printf( '<blockquote class="lqd-testimonial-part m-0 relative transition-colors %s lqd-testimonial-quote">%s</blockquote>', implode(' ', $classnames), $quote );
		}

	}

	protected function render_part_content( $part, $tag = 'span' ) {

		$option_name = is_array( $part ) ? $part['part'] : $part;
		$content = !empty( $content ) ? $content : $this->get_settings_for_display( $option_name );

		if ( !empty( $content ) ) {
			printf(
				'<%1$s class="m-0 leading-none lqd-testimonial-meta-%2$s">%3$s</%1$s>',
				Utils::validate_html_tag( $tag ),
				$option_name,
				$content
			);
		}

	}

	protected function render_part_avatar() {

		if ( empty( $this->get_settings_for_display('avatar')['id'] ) ) {
			return;
		}

		?><figure class="overflow-hidden lqd-testimonial-meta-avatar"><?php
		echo Group_Control_Image_Size::get_attachment_image_html( $this->get_settings_for_display(), 'thumbnail', 'avatar' );
		?></figure><?php

	}

	protected function render_part_meta( $part ) {
		?>
		<div class="lqd-testimonial-part lqd-testimonial-meta flex items-center">
			<?php $this->render_part_avatar(); ?>
			<div class="lqd-testimonial-meta-info flex flex-col">
				<?php
					$this->render_part_content( 'name' );
					$this->render_part_content( 'title' );
				?>
			</div>
		</div>
		<?php
	}

	protected function render_part_media( $part ){
		$media_type = $part[ 'media_type' ];

		if ( $media_type === 'none' ) return;

		?>
		<div class="lqd-testimonial-part lqd-testimonial-media <?php echo 'elementor-repeater-item-' . $part['_id'] ?> inline-flex items-center justify-center overflow-hidden"><?php
			if ( $media_type === 'icon' ) {
				\LQD_Elementor_Helper::render_icon( $part['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative object-cover object-center' ] );
			} else {
				echo Group_Control_Image_Size::get_attachment_image_html( $part, 'thumbnail', 'selected_image' );
			}
		?></div>
		<?php
	}

	protected function render_part_divider() {
		?><div class="lqd-testimonial-part lqd-testimonial-divider align-self-stretch bg-current transition-colors"></div><?php
	}

	protected function get_bubble_classnames() {

		$classnames = [];
		$bubble_direction = $this->get_settings_for_display( 'bubble_direction' );

		$classnames[] = 'lqd-bubble-arrow';

		if ( !empty( $bubble_direction ) ) {
			$classnames[] = 'lqd-bubble-arrow-' . $bubble_direction;
		}

		return $classnames;

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$content_parts = $settings['content_parts'];

		if ( empty( $content_parts ) ) return;

		$seperated_parts = array_filter( $content_parts, function( $part ) {
			return $part['separate_part'] === 'yes';
		} );
		$wrapper_classnames = [ 'lqd-testimonial', 'flex', 'transition-colors' ];

		if ( $settings['enable_bubble'] === 'yes' && $settings['apply_bubble_on'] === 'box' ) {
			$wrapper_classnames = array_merge( $wrapper_classnames, $this->get_bubble_classnames() );
		}

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => $wrapper_classnames,
			]
		);

		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>><?php

			if ( !empty( $seperated_parts ) ) {
				echo '<div class="lqd-testimonial-separated-content flex flex-wrap items-center grow-0 shrink-0 basis-auto">';
				foreach ( $seperated_parts as $part ) {
					$this->{'render_part_' . $part['part']}( $part );
				}
				echo '</div>';
			}

			echo '<div class="lqd-testimonial-wrap flex flex-col grow">';
			foreach ( $content_parts as $part ) {
				if ( $part['separate_part'] === 'yes' ) continue;
				$this->{'render_part_' . $part['part']}( $part );
			}
			echo '</div>';
		?></div>
		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Testimonial() );