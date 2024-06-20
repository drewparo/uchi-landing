<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Image extends Widget_Base {

	public function get_name() {
		return 'lqd-image';
	}

	public function get_title() {
		return __( 'Liquid Image', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-image lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'image' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$behavior = [];

		if ( !empty( $settings['look_mouse'] ) ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidLookAtMouseBehavior',
			];
		}
		if ( isset( $settings['lqd_hover_3d_intensity']['size'] ) && $settings['lqd_hover_3d_intensity']['size'] > 0 ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidHover3dBehavior',
				'options' => [
					'intensity' => $settings['lqd_hover_3d_intensity']['size']
				]
			];
		}

		return $behavior;
	}

	public function get_utility_classnames() {
		return [];
	}

	protected function get_liquid_background( $option_name ) {

		$background = new \LQD_Elementor_Render_Background;
		$background->render( $this, $this->get_settings_for_display(), $option_name );

	}

	protected function register_controls() {

		// General Section
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
			]
		);

		$this->add_control(
			'caption_source',
			[
				'label' => esc_html__( 'Caption', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'aihub-core' ),
					'attachment' => esc_html__( 'Attachment Caption', 'aihub-core' ),
					'custom' => esc_html__( 'Custom Caption', 'aihub-core' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Custom caption', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your image caption', 'aihub-core' ),
				'condition' => [
					'caption_source' => 'custom',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'caption_pos',
			[
				'label' => esc_html__( 'Caption position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'' => [
						'title' => esc_html__( 'Outside', 'aihub-core' ),
						'icon' => 'eicon-sign-out',
					],
					'inside' => [
						'title' => esc_html__( 'Inside', 'aihub-core' ),
						'icon' => 'eicon-circle',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'position: absolute; bottom: 0; left: 0;',
				],
				'condition' => [
					'caption_source!' => 'none',
				],
				'toggle' => false
			]
		);

		$this->add_control(
			'caption_v_pos',
			[
				'label' => esc_html__( 'Caption vertical position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-arrow-up',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'top: auto; bottom: auto; {{VALUE}}: 0;',
				],
				'condition' => [
					'caption_pos' => 'inside',
				]
			]
		);

		$this->add_control(
			'caption_h_pos',
			[
				'label' => esc_html__( 'Caption horizontal position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-arrow-left',
					],
					'right' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-arrow-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'left: auto; right: auto; {{VALUE}}: 0;',
				],
				'condition' => [
					'caption_pos' => 'inside',
				],
			]
		);

		$this->add_control(
			'caption_vertical',
			[
				'label' => esc_html__( 'Vertical caption', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'writing-mode: tb; transform: rotate(180deg);'
				],
				'condition' => [
					'caption_source!' => 'none',
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => esc_html__( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'aihub-core' ),
					'file' => esc_html__( 'Media File', 'aihub-core' ),
					'custom' => esc_html__( 'Custom URL', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'aihub-core' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		/**
		 * TODO: Replace this with liquid lightbox
		 */
		$this->add_control(
			'open_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'default' => [
						'title' => esc_html__( 'Default', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-h',
					],
					'yes' => [
						'title' => esc_html__( 'Yes', 'aihub-core' ),
						'icon' => 'eicon-check',
					],
					'no' => [
						'title' => esc_html__( 'No', 'aihub-core' ),
						'icon' => 'eicon-close',
					],
				],
				'default' => 'default',
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->add_control(
			'lightbox_group_id',
			[
				'label' => esc_html__( 'Group ID', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add a group ID if you want to create a gallery lightbox.', 'aihub-core' ),
				'placeholder' => esc_html__( 'e.g: portraits-gallery', 'aihub-core' ),
				'condition' => [
					'caption_source' => 'custom',
					'open_lightbox' => 'yes'
				],
			]
		);

		$this->add_control(
			'lqd_hover_3d_intensity',
			[
				'label' => esc_html__( '3D hover intenisty', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.5
					]
				],
				'separator' => 'before',
				'condition' => [
					'look_mouse' => ''
				]
			]
		);

		$this->add_control(
			'lqd_overlay_lines_count',
			[
				'label' => esc_html__( 'Overlay lines', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1
					]
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'lqd_overlay_lines_dir',
			[
				'label' => esc_html__( 'Lines direction', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'vertical' => [
						'title' => esc_html__( 'Vertical', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-v',
					],
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'default' => 'vertical',
				'toggle' => false,
				'condition' => [
					'lqd_overlay_lines_count[size]!' => 0
				]
			]
		);

		$this->add_control(
			'lqd_overlay_lines_animated',
			[
				'label' => __( 'Animate lines?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'condition' => [
					'lqd_overlay_lines_count[size]!' => 0
				]
			]
		);

		$this->add_control(
			'look_mouse',
			[
				'label' => esc_html__( 'Look at cursor?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => [
					'lqd_hover_3d_intensity[size]' => 0
				]
			]
		);

		$this->add_group_control(
			'liquid-background',
			[
				'name' => 'image_overlay',
				'selector' => '{{WRAPPER}} .lqd-img-overlay-el',
				'fields_options' => [
					'liquid_background_items' => [
						'label' => esc_html__( 'Image overlay', 'aihub-core' ),
					],
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'overlay_blend_mode',
			[
				'label' => esc_html__( 'Blend mode', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'aihub-core' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'hard-light' => 'Hard light',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'difference' => 'Difference',
					'exclusion' => 'Exclusion',
					'hue' => 'Hue',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-img-overlay-el' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'overlay_backdrop_filters',
				'label' => esc_html__( 'Backdrop filter', 'aihub-core' ),
				'fields_options' => [
					'blur' => [
						'selectors' => [
							'{{WRAPPER}} .lqd-img-overlay-el' => '-webkit-backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg );backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg )',
						],
					]
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'image_dark_section',
			[
				'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'dark_image',
			[
				'label' => esc_html__( 'Image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'aihub-core' ),
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
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} figure' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} img' => 'width: 100%; max-width: none',
				],
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label' => esc_html__( 'Max width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} figure' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} img' => 'width: 100%; max-width: none',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object_fit',
			[
				'label' => esc_html__( 'Object fit', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'aihub-core' ),
					'fill' => esc_html__( 'Fill', 'aihub-core' ),
					'cover' => esc_html__( 'Cover', 'aihub-core' ),
					'contain' => esc_html__( 'Contain', 'aihub-core' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'object_position_x',
			[
				'label' => esc_html__( 'Focal point X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => -100,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => '%'
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'object-position: {{SIZE}}{{UNIT}} {{object_position_y.SIZE}}{{object_position_y.UNIT}};',
				],
				'condition' => [
					'object_fit' => [ 'cover', 'contain' ]
				]
			]
		);

		$this->add_responsive_control(
			'object_position_y',
			[
				'label' => esc_html__( 'Focal point Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => -100,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => '%'
				],
				'render_type' => 'ui',
				'condition' => [
					'object_fit' => [ 'cover', 'contain' ]
				]
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'image_background',
				'selector' => '{{WRAPPER}} figure',
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'image_background_hover',
				'selector' => '{{WRAPPER}}:hover figure',
			]
		);

		$this->add_control(
			'opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover img',
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition duration', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} figure',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} figure',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'backdrop_filters',
				'label' => esc_html__( 'Backdrop filter', 'aihub-core' ),
				'description' => esc_html__( 'Works if an opacity less than 1 is applied to the image.', 'aihub-core' ),
				'fields_options' => [
					'blur' => [
						'selectors' => [
							'{{WRAPPER}} figure' => '-webkit-backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg );backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg )',
						],
					]
				],
				'separator' => 'before'
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => esc_html__( 'Caption', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption_source!' => 'none',
				],
			]
		);

		$this->add_control(
			'caption_align',
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'aihub-core' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_height',
			[
				'label' => esc_html__( 'Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'display: flex; flex-wrap: wrap; align-items: center; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_control(
			'caption_background_color',
			[
				'label' => esc_html__( 'Background color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .lqd-image-caption',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'caption_text_shadow',
				'selector' => '{{WRAPPER}} .lqd-image-caption',
			]
		);

		$this->add_responsive_control(
			'caption_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-image-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_lines',
			[
				'label' => esc_html__( 'Lines', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'lqd_overlay_lines_count[size]!' => 0
				]
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'overlay_lines_bg',
				'selector' => '{{WRAPPER}} .lqd-overlay-line:before',
			]
		);

		$this->end_controls_section();

	}

	private function has_caption( $settings ) {

		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );

	}

	private function get_caption( $settings ) {

		$caption = '';

		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['image']['id'] );
					break;
				case 'custom':
					$caption = ! Utils::is_empty( $settings['caption'] ) ? $settings['caption'] : '';
			}
		}

		return $caption;

	}

	private function get_link_url( $settings ) {

		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}
			return $settings['link'];
		}

		return [
			'url' => $settings['image']['url'],
		];

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$has_caption = $this->has_caption( $settings );

		$link = $this->get_link_url( $settings );
		$lqd_overlay_lines_count = $settings['lqd_overlay_lines_count']['size'];
		$lqd_overlay_lines_dir = $settings['lqd_overlay_lines_dir'];
		$has_dark_image = !empty( $settings['dark_image']['url'] );

		if ( $link ) {
			$this->add_link_attributes( 'link', $link );

			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute( 'link', [
					'class' => 'elementor-clickable',
				] );
			}
			if ( 'custom' !== $settings['link_to'] ) {
				$this->add_lightbox_data_attributes( 'link', $settings['image']['id'], $settings['open_lightbox'] );
			}
		}

		$this->add_render_attribute( 'image', 'class', [ 'inline-block', 'align-middle' ] );

		?>

		<figure class="inline-block relative align-middle overflow-hidden lqd-transform-perspective transition-colors" data-lqd-look-at-mouse data-lqd-hover3d-el>

			<?php if ( $link ) : ?>
			<a <?php $this->print_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>

				<?php if ( $has_dark_image ) : ?>
				<span class="lqd-dark:hidden">
				<?php endif; // if $has_dark_image ?>

				<?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'image_size', 'image' ); ?>

				<?php if ( $has_dark_image ) : ?>
				</span>
				<span class="hidden lqd-dark:inline">
					<?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'image_size', 'dark_image' ); ?>
				</span>
				<?php endif; // if $has_dark_image ?>

				<?php if ( !empty( $settings['image_overlay_liquid_background_items'] ) ) : ?>
					<div class="lqd-img-overlay-el absolute top-0 start-0 w-full h-full rounded-inherit overflow-hidden">
						<?php $this->get_liquid_background( 'image_overlay' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( !empty( $lqd_overlay_lines_count ) && $lqd_overlay_lines_count >= 1 ) {
					$overlay_lines_wrapper_classnems = [ 'lqd-overlay-lines', 'absolute', 'top-0', 'start-0', 'w-full', 'h-full', 'flex' ];
					$overlay_line_classname = ['lqd-overlay-line', 'grow', 'relative', 'lqd-has-before', 'lqd-before:absolute', 'lqd-before:top-0', 'lqd-before:start-0', 'lqd-before:bg-current' ];
					$lines_dir_is_horizontal = $lqd_overlay_lines_dir === 'horizontal';

					if ( $lines_dir_is_horizontal ) {
						$overlay_lines_wrapper_classnems[] = 'flex-col';
						$overlay_line_classname[] = 'lqd-before:w-full';
						$overlay_line_classname[] = 'lqd-before:h-px';
					} else {
						$overlay_line_classname[] = 'lqd-before:w-px';
						$overlay_line_classname[] = 'lqd-before:h-full';
					}

					if ( $settings['lqd_overlay_lines_animated'] ) {
						$overlay_lines_wrapper_classnems[] = 'lqd-overlay-lines-animated';
						$overlay_line_classname[] = $lines_dir_is_horizontal ? 'lqd-overlay-line-x' : 'lqd-overlay-line-y';
					}

					$this->add_render_attribute( 'overlay_lines_wrapper_attrs', [
						'class' => $overlay_lines_wrapper_classnems
					]);
					$this->add_render_attribute( 'overlay_line_attrs', [
						'class' => $overlay_line_classname
					]);
				?>
					<div <?php $this->print_render_attribute_string( 'overlay_lines_wrapper_attrs' ) ?>>
						<div class="lqd-overlay-line grow"></div>
						<?php for ( $i = 0; $i < $lqd_overlay_lines_count; $i++ ) : ?>
							<div <?php $this->print_render_attribute_string( 'overlay_line_attrs' ); ?> style="--lqd-overlay-line-animate-delay: <?php echo number_format($i / 8, 2) ?>s;"></div>
						<?php endfor; ?>
					</div>
				<?php } ?>

			<?php if ( $link ) : ?>
			</a>
			<?php endif; ?>

			<?php if ( $has_caption ) : ?>
			<figcaption class="lqd-image-caption wp-caption-text"><?php
				echo wp_kses_post( $this->get_caption( $settings ) );
			?></figcaption>
			<?php endif; ?>

		</figure>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Image() );