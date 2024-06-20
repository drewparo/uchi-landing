<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\WYSIWYG;
use Elementor\Embed;
use Elementor\Repeater;
use Elementor\Icons_Manager;
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

class LQD_Box extends Widget_Base {

	public function get_name() {
		return 'lqd-box';
	}

	public function get_title() {
		return __( 'Liquid Box', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-info-box lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'box', 'content', 'overlay text', 'icon box', 'text and image' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$behavior = [];

		if ( isset( $settings['lqd_hover_3d_intensity']['size'] ) && $settings['lqd_hover_3d_intensity']['size'] > 0 ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidHover3dBehavior',
				'options' => [
					'intensity' => $settings['lqd_hover_3d_intensity']['size'],
					'ui' => [
						'items' => "'.elementor-widget-container'"
					]
				]
			];
		}

		return $behavior;
	}

	public function get_utility_classnames() {
		return [];
	}

	protected function get_liquid_background( $option_name = '', $content_template = false, $layers_class = '' ) {

		$background = new \LQD_Elementor_Render_Background;
		if ( $content_template ){
			$background->render_template( $layers_class );
		} else {
			$background->render( $this, $this->get_settings_for_display(), $option_name, false, $layers_class );
		}

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();
		$classnames = [ 'lqd-widget-container-flex', 'lqd-group-box' ];

		$this->add_render_attribute( '_wrapper', [
			'class' => $classnames
		] );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			'liquid-background',
			[
				'name' => 'image',
				'types' => [ 'color', 'image', 'video', 'slideshow', 'particles', 'animated-gradient' ],
				'selector' => '{{WRAPPER}} .lqd-box-image',
				'fields_options' => [
					'liquid_background_items' => [
						'label' => esc_html__( 'Image', 'aihub-core' ),
					],
				],
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Unlimited possibilities' , 'aihub-core' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true
				],
				'separator' => 'before'
			]
    	);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'aihub-core' ),
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
				'default' => 'h3',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Ultra flexible' , 'aihub-core' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true
				],
				'separator' => 'before'
			]
    	);

		$this->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__( 'Subtitle HTML Tag', 'aihub-core' ),
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
				'default' => 'h6',
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( '<p>All in one Landing and Startup Solutions. flexible, adaptable, and scalable.</p>', 'aihub-core' ),
				'selectors' => [
					'{{WRAPPER}} .lqd-box-description > :last-child' => 'margin-bottom: 0;'
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'box_label',
			[
				'label' => esc_html__( 'Label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Pro', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
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
				'separator' => 'before'
			]
		);

		$this->add_control(
			'enable_icon_list',
			[
				'label' => esc_html__( 'Add icon list?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'separator' => 'before',
			]
		);

		/**
		 * TODO: Add an iconlist
		 */
		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'London, UK', 'aihub-core' ),
				'default' => esc_html__( 'London, UK', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
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
					'value' => 'fas fa-map-pin',
					'library' => 'fa-solid',
				]
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'aihub-core' ),
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => esc_html__( 'Icon list', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
				'default' => [
					[
						'text' => esc_html__( 'London, UK', 'aihub-core' ),
						'selected_icon' => [
							'value' => 'fas fa-map-pin',
							'library' => 'fa-solid',
						],
					],
				],
				'condition' => [
					'enable_icon_list' => 'yes'
				],
			]
		);

		$this->add_control(
			'description_after_icon_list',
			[
				'label' => esc_html__( 'Description after icon list', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'condition' => [
					'enable_icon_list' => 'yes'
				],
			]
		);

		lqd_elementor_add_button_controls( $this, 'ib_', [], false );

		$this->start_controls_section(
			'positioning_alignment_section',
			[
				'label' => __( 'Positioning & Alignments', 'aihub-core' ),
			]
		);

		$this->add_control(
			'title_inline',
			[
				'label' => esc_html__( 'Inline title', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-box-t-display: inline-flex'
				]
			]
		);

		$this->add_control(
			'subtitle_inline',
			[
				'label' => esc_html__( 'Inline subtitle', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-box-st-display: inline-flex'
				]
			]
		);

		$this->add_responsive_control(
			'text_align',
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
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .lqd-iconlist-item, {{WRAPPER}} .lqd-box-title, {{WRAPPER}} .lqd-box-subtitle' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_placement',
			[
				'label' => esc_html__( 'Image placement', 'aihub-core' ),
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
					'behind_content' => [
						'title' => esc_html__( 'Behind content', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'render_type' => 'template',
				'prefix_class' => 'lqd-box-image-',
				'default' => 'top',
				'toggle' => false
			]
		);

		$this->add_responsive_control(
			'image_align_v',
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
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'image_placement' => [ 'top', 'bottom' ]
				],
			]
		);

		$this->add_responsive_control(
			'image_align_h',
			[
				'label' => esc_html__( 'Horizontal alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'image_placement' => [ 'start', 'end' ]
				],
			]
		);

		$this->add_control(
			'icon_inline',
			[
				'label' => esc_html__( 'Inline icon with heading?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'condition' => [
					'selected_icon[value]!' => ''
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-box-t-display: flex'
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_inline_title_inline',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'yes',
				'render_type' => 'template',
				'condition' => [
					'selected_icon[value]!' => '',
					'title_inline' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-box-t-display: inline-flex'
				],
			]
		);

		$this->add_control(
			'icon_inline_placement',
			[
				'label' => esc_html__( 'Icon placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-arrow-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-arrow-right',
					],
				],
				'render_type' => 'template',
				'default' => 'start',
				'toggle' => false,
				'condition' => [
					'icon_inline' => 'yes',
				],
			]
		);

		$this->add_control(
			'box_label_placement',
			[
				'label' => esc_html__( 'label placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'before_title' => [
						'title' => esc_html__( 'Before title', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'after_title' => [
						'title' => esc_html__( 'After title', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
					'floating' => [
						'title' => esc_html__( 'Floating', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'prefix_class' => 'lqd-box-label-',
				'default' => 'after_title',
				'toggle' => false,
				'render_type' => 'template',
				'separator' => 'before',
				'condition' => [
					'box_label!' => ''
				]
			]
		);

		$this->add_control(
			'box_label_inline',
			[
				'label' => esc_html__( 'Inline label with title?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'condition' => [
					'box_label!' => '',
					'box_label_placement!' => 'floating'
				],
			]
		);

		$this->add_responsive_control(
			'box_label_floating_offset_x',
			[
				'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '2'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-label' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'box_label!' => '',
					'box_label_placement' => 'floating'
				]
			]
		);

		$this->add_responsive_control(
			'box_label_floating_offset_y',
			[
				'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '6'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-label' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'box_label!' => '',
					'box_label_placement' => 'floating'
				]
			]
		);

		$this->add_control(
			'button_pos',
			[
				'label' => esc_html__( 'Button position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'default' => [
						'title' => esc_html__( 'Default', 'aihub-core' ),
						'icon' => 'eicon-sign-out',
					],
					'on_image' => [
						'title' => esc_html__( 'On top of the image', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'render_type' => 'template',
				'default' => 'default',
				'toggle' => false,
				'separator' => 'before',
				'condition' => [
					'show_button' => 'yes'
				]
			]
		);

		$this->add_control(
			'on_image_button_orientation_h',
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
				'condition' => [
					'show_button' => 'yes',
					'button_pos' => 'on_image',
				]
			]
		);

		$this->add_responsive_control(
			'on_image_button_offset_x',
			[
				'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '50'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-btn' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_button' => 'yes',
					'button_pos' => 'on_image',
					'on_image_button_orientation_h' => 'start'
				]
			]
		);

		$this->add_responsive_control(
			'on_image_button_offset_x_end',
			[
				'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '50'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-btn' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_button' => 'yes',
					'button_pos' => 'on_image',
					'on_image_button_orientation_h' => 'end'
				]
			]
		);

		$this->add_control(
			'on_image_button_orientation_v',
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
				'condition' => [
					'show_button' => 'yes',
					'button_pos' => 'on_image',
				]
			]
		);

		$this->add_responsive_control(
			'on_image_button_offset_y',
			[
				'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '50'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-btn' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_button' => 'yes',
					'button_pos' => 'on_image',
					'on_image_button_orientation_v' => 'top',
				]
			]
		);

		$this->add_responsive_control(
			'on_image_button_offset_y_bottom',
			[
				'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '50'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-btn' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_button' => 'yes',
					'button_pos' => 'on_image',
					'on_image_button_orientation_v' => 'bottom',
				]
			]
		);

		$this->add_control(
			'separate_content',
			[
				'label' => esc_html__( 'Separate content?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'separate_content_parts',
			[
				'label' => esc_html__( 'Separated parts', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'options' => [
					'title'  => esc_html__( 'Title', 'aihub-core' ),
					'subtitle'  => esc_html__( 'Subtitle', 'aihub-core' ),
					'description' => esc_html__( 'Description', 'aihub-core' ),
					'icon' => esc_html__( 'Icon', 'aihub-core' ),
					'button' => esc_html__( 'Button', 'aihub-core' ),
				],
				'multiple' => true,
				'select2options' => [
					'closeOnSelect' => false
				],
				'condition' => [
					'separate_content' => 'yes',
				],
			]
		);

		$this->add_control(
			'separate_content_placement',
			[
				'label' => esc_html__( 'Placement', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-arrow-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-arrow-right',
					],
					'floating' => [
						'title' => esc_html__( 'Floating', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'render_type' => 'template',
				'prefix_class' => 'lqd-box-separate-content-placement-',
				'default' => 'end',
				'toggle' => false,
				'condition' => [
					'separate_content' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'justify_content',
			[
				'label' => esc_html__( 'Justify Content', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'default' => '',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-start-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => esc_html__( 'Space Around', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly' => [
						'title' => esc_html__( 'Space Evenly', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content' => 'justify-content: {{VALUE}}; width: 100%;',
				],
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => [ 'start', 'end' ],
				],
			]
		);

		$this->add_responsive_control(
			'align_items',
			[
				'label' => esc_html__( 'Align Items', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-start-v',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-center-v',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-end-v',
					],
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'aihub-core' ),
						'icon' => 'eicon-flex eicon-align-stretch-v',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => [ 'start', 'end' ],
				],
			]
		);

		$this->add_control(
			'content_floating_visible_onhover',
			[
				'label' => esc_html__( 'Visible on hover?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => '-onhover',
				'prefix_class' => 'lqd-box-content-floating-visible',
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating',
				],
			]
		);

		$this->add_responsive_control(
			'content_floating_orientation_h',
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
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating'
				],
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto;',
					'end' => 'inset-inline-start: auto;',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content-floating' => '{{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'content_floating_offset_x',
			[
				'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '0'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content-floating' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating',
					'content_floating_orientation_h' => 'start'
				]
			]
		);

		$this->add_responsive_control(
			'content_floating_offset_x_end',
			[
				'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '0'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content-floating' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating',
					'content_floating_orientation_h' => 'end'
				]
			]
		);

		$this->add_responsive_control(
			'content_floating_orientation_v',
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
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating'
				],
				'selectors_dictionary' => [
					'top' => 'bottom: auto;',
					'bottom' => 'top: auto;',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content-floating' => '{{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'content_floating_offset_y',
			[
				'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '100'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content-floating' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating',
					'content_floating_orientation_v' => 'top',
				]
			]
		);

		$this->add_responsive_control(
			'content_floating_offset_y_bottom',
			[
				'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => '100'
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content-floating' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating',
					'content_floating_orientation_v' => 'bottom',
				]
			]
		);

		$this->add_control(
			'content_floating_bubble',
			[
				'label' => esc_html__( 'Bubble style?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating',
				],
			]
		);

		$this->add_control(
			'content_floating_bubble_direction',
			[
				'label' => esc_html__( 'Bubble direction', 'aihub-core' ),
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
				'default' => 'top',
				'toggle' => false,
				'condition' => [
					'separate_content' => 'yes',
					'separate_content_placement' => 'floating',
					'content_floating_bubble' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'effects_section',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
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
					'{{WRAPPER}} .lqd-overlay-bg-el' => 'mix-blend-mode: {{VALUE}}',
				],
				'condition' => [
					'overlay_bg_background!' => ''
				]
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
							'{{WRAPPER}} .lqd-overlay-bg-el' => '-webkit-backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg );backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg )',
						],
					]
				],
				'condition' => [
					'overlay_bg_background!' => ''
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'icon_effect_hover',
			[
				'label' => esc_html__( 'Icon hover effect', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'rise' => esc_html__( 'Rise', 'aihub-core' ),
					'move-right' => esc_html__( 'Move right', 'aihub-core' ),
					'move-left' => esc_html__( 'Move left', 'aihub-core' ),
					'scale-up' => esc_html__( 'Scale up', 'aihub-core' ),
					'scale-down' => esc_html__( 'Scale down', 'aihub-core' ),
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
				],
				'default' => '',
				'separator' => 'after',
				'selectors_dictionary' => [
					'rise' => '--lqd-box-icon-hover-translate-y: -0.25em',
					'move-right' => '--lqd-box-icon-hover-translate-x: 0.25em',
					'move-left' => '--lqd-box-icon-hover-translate-x: -0.25em',
					'scale-up' => '--lqd-box-icon-hover-scale: 1.1',
					'scale-down' => '--lqd-box-icon-hover-scale: 0.9',
				],
				'selectors' => [
					'{{WRAPPER}}:hover .lqd-box-icon' => '{{VALUE}}',
				],
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_effect_hover_custom',
			[
				'label' => __( 'Custom hover effect', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'default' => 'yes',
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
				],
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'icon_hover_custom_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
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
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-translate-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
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
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-translate-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_scale',
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
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-scale: {{SIZE}}'
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_skewX',
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
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-skew-x: {{SIZE}}deg'
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_skewY',
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
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-skew-y: {{SIZE}}deg'
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_rotateX',
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
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 1200px',
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-rotate-x: {{SIZE}}deg',
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_rotateY',
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
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 1200px',
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-rotate-y: {{SIZE}}deg',
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_rotateZ',
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
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-rotate-z: {{SIZE}}deg'
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'icon_hover_custom_opacity',
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
					'{{WRAPPER}} .lqd-box-icon' => '--lqd-box-icon-hover-opacity: {{SIZE}}'
				],
				'condition' => [
					'selected_icon[value]!' => '',
					'icon_effect_hover' => 'custom',
					'icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'iconlist_icon_effect_hover',
			[
				'label' => esc_html__( 'Iconlist icon hover effect', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'rise' => esc_html__( 'Rise', 'aihub-core' ),
					'move-right' => esc_html__( 'Move right', 'aihub-core' ),
					'move-left' => esc_html__( 'Move left', 'aihub-core' ),
					'scale-up' => esc_html__( 'Scale up', 'aihub-core' ),
					'scale-down' => esc_html__( 'Scale down', 'aihub-core' ),
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
				],
				'default' => '',
				'selectors_dictionary' => [
					'rise' => '--lqd-box-iconlist-hover-translate-y: -0.25em',
					'move-right' => '--lqd-box-iconlist-hover-translate-x: 0.25em',
					'move-left' => '--lqd-box-iconlist-hover-translate-x: -0.25em',
					'scale-up' => '--lqd-box-iconlist-hover-scale: 1.2',
					'scale-down' => '--lqd-box-iconlist-hover-scale: 0.8',
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .lqd-box-iconlist-item:hover' => '{{VALUE}}',
				],
				'condition' => [
					'enable_icon_list' => 'yes',
				],
			]
		);

		$this->add_control(
			'iconlist_icon_effect_hover_custom',
			[
				'label' => __( 'Custom hover effect', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'default' => 'yes',
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
				],
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
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
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-translate-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
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
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-translate-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_scale',
			[
				'label' => __( 'Scale', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
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
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-scale: {{SIZE}}'
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_skewX',
			[
				'label' => __( 'Skew X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
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
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-skew-x: {{SIZE}}deg'
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_skewY',
			[
				'label' => __( 'Skew Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
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
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-skew-y: {{SIZE}}deg'
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_rotateX',
			[
				'label' => __( 'Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
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
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 1200px',
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-rotate-x: {{SIZE}}deg',
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_rotateY',
			[
				'label' => __( 'Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
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
					'{{WRAPPER}} > .elementor-widget-container' => 'perspective: 1200px',
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-rotate-y: {{SIZE}}deg',
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_rotateZ',
			[
				'label' => __( 'Rotate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
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
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-rotate-z: {{SIZE}}deg'
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'iconlist_icon_hover_custom_opacity',
			[
				'label' => __( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-box-iconlist' => '--lqd-box-iconlist-hover-opacity: {{SIZE}}'
				],
				'condition' => [
					'enable_icon_list' => 'yes',
					'iconlist_icon_effect_hover' => 'custom',
					'iconlist_icon_effect_hover_custom' => 'yes'
				],
			]
		);

		$this->end_popover();

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
				'separator' => 'before'
			]
		);

		$this->add_control(
			'lqd_hover_3d_content_pop',
			[
				'label' => esc_html__( 'Content pop', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 269,
						'step' => 1
					]
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container, {{WRAPPER}} .lqd-box-image' => 'transform-style: preserve-3d;transform:perspective(1200px)',
					'{{WRAPPER}} .lqd-box-content, {{WRAPPER}} .lqd-box-image, {{WRAPPER}} .lqd-box-btn-floating' => '--lqd-translate-z: {{SIZE}}{{UNIT}};'
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'lqd_hover_3d_intensity[size]',
							'operator' => '!==',
							'value' => 0
						],
						[
							'name' => 'lqd_hover_3d_intensity[size]',
							'operator' => '!==',
							'value' => ''
						],
					]
				]
			]
		);

		$this->add_control(
			'lqd_hover_3d_content_pop_compensate_scale',
			[
				'label' => esc_html__( 'Compensate scale?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .lqd-box-content, {{WRAPPER}} .lqd-box-image' => '--lqd-scale-x: calc((1200 - {{lqd_hover_3d_content_pop.SIZE}}) / (1200 / {{lqd_hover_3d_content_pop.SIZE}}) / {{lqd_hover_3d_content_pop.SIZE}}); --lqd-scale-y: var(--lqd-scale-x)'
				],
				'render_type' => 'template',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'lqd_hover_3d_intensity[size]',
							'operator' => '!==',
							'value' => 0
						],
						[
							'name' => 'lqd_hover_3d_intensity[size]',
							'operator' => '!==',
							'value' => ''
						],
						[
							'name' => 'lqd_hover_3d_content_pop[size]',
							'operator' => '!==',
							'value' => 0
						],
					]
				]
			]
		);

		$this->add_control(
			'lqd_overlay_lines_count',
			[
				'label' => esc_html__( 'Image overlay lines', 'aihub-core' ),
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
				'separator' => 'before',
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
						'icon' => 'eicon-ellipsis-h',
					],
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-v',
					],
				],
				'default' => 'vertical',
				'toggle' => false,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'lqd_overlay_lines_count[size]',
							'operator' => '!==',
							'value' => 0
						],
						[
							'name' => 'lqd_overlay_lines_count[size]',
							'operator' => '!==',
							'value' => ''
						],
					]
				]
			]
		);

		$this->add_control(
			'lqd_overlay_lines_animated',
			[
				'label' => __( 'Animate lines?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'lqd_overlay_lines_count[size]',
							'operator' => '!==',
							'value' => 0
						],
						[
							'name' => 'lqd_overlay_lines_count[size]',
							'operator' => '!==',
							'value' => ''
						],
					]
				]
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'box',
			[
				'content' => [
					'controls' => [
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-c-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-box-c-p'
						],
						[
							'type' => 'liquid_background',
							'fields_options' => [
								'liquid_background_items' => [
									'label' => esc_html__( 'Overlay', 'aihub-core' ),
								],
							],
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-box-c-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-box-c-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-box-c-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'content_floating' => [
					'controls' => [
						[
							'type' => 'width',
							'selectors' => [
								'{{WRAPPER}} .lqd-box-content-floating' => 'width: {{SIZE}}{{UNIT}}; white-space: inherit;',
							]
						],
						[
							'type' => 'height',
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-box-cf-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-box-cf-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-box-cf-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-box-cf-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-box-cf-bs'
						],
					],
					'condition' => [
						'separate_content' => 'yes',
						'separate_content_placement' => 'floating'
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'image' => [
					'controls' => [
						[
							'type' => 'width',
							'css_var' => '--img-w',
							'default' => [
								'size' => '50',
								'unit' => '%',
							],
							'condition' => [
								'image_placement' => [ 'start', 'end' ]
							]
						],
						[
							'type' => 'width',
							'name' => 'width_block',
							'label' => 'Width',
							'default' => [
								'size' => '100',
								'unit' => '%',
							],
							'condition' => [
								'image_placement' => [ 'top', 'bottom' ]
							]
						],
						[
							'type' => 'height',
							'selectors' => [
								'{{WRAPPER}} .lqd-box-image' => 'height: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .lqd-box-image .lqd-bg-image-wrap' => 'height: {{SIZE}}{{UNIT}}; padding-top: 0 !important;',
							],
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-img-m'
						],
						[
							'type' => 'liquid_background',
							'name' => 'overlay',
							'selector' => '.lqd-image-overlay-el',
							'tab' => 'hover',
							'fields_options' => [
								'liquid_background_items' => [
									'label' => esc_html__( 'Overlay', 'aihub-core' ),
								],
							]
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-box-img-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-box-img-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-box-img-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'icon' => [
					'controls' => [
						[
							'type' => 'font_size',
						],
						[
							'type' => 'liquid_linked_dimensions',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-i-m'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-box-i-color'
						],
						[
							'type' => 'liquid_background',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-box-i-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-box-i-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-box-i-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'title' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'liquid_linked_dimensions',
							'selectors' => [
								'{{WRAPPER}}' => '--lqd-box-t-w: {{WIDTH}}{{UNIT}}; --lqd-box-t-h: {{HEIGHT}}{{UNIT}}; --lqd-box-t-display: inline-flex; --lqd-box-t-justify-content: center;',
							]
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-t-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-box-t-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-box-t-color',
							'apply_prop_to_el' => true
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-box-t-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-box-t-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-box-t-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'subtitle' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'liquid_linked_dimensions',
							'selectors' => [
								'{{WRAPPER}}' => '--lqd-box-st-w: {{WIDTH}}{{UNIT}}; --lqd-box-st-h: {{HEIGHT}}{{UNIT}}; --lqd-box-st-display: inline-flex; --lqd-box-st-justify-content: center;',
							]
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-st-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-box-st-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-box-st-color',
							'apply_prop_to_el' => true
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-box-st-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-box-st-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-box-st-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'label' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-l-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-box-l-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-box-l-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-box-l-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-box-l-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-box-l-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'condition' => [
						'box_label!' => ''
					],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'description' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-d-m'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-box-d-color'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'iconlist' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-box-il-m'
						],
						[
							'type' => 'padding',
							'name' => 'icon_padding',
							'selector' => '.lqd-iconlist-icon'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'name' => 'icon_dimensions',
							'css_var' => '--lqd-box-ili'
						],
						[
							'type' => 'padding',
							'name' => 'item_padding',
							'selector' => '.lqd-iconlist-item'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-box-il-color'
						],
						[
							'type' => 'font_size',
							'name' => 'icon_size',
							'selector' => '.lqd-iconlist-icon'
						],
						[
							'type' => 'slider',
							'label' => 'Gap between items',
							'selectors' => [
								'{{WRAPPER}} .lqd-iconlist-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}'
							]
						],
						[
							'type' => 'gap',
							'label' => 'Gap between icon and text',
							'default' => [
								'size' => 0.5,
								'unit' => 'em'
							],
							'selector' => '.lqd-iconlist-item'
						],
						[
							'type' => 'liquid_color',
							'name' => 'icon_color',
							'css_var' => '--lqd-box-ili-color'
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'icon_bg',
							'css_var' => '--lqd-box-ili-bg'
						],
						[
							'type' => 'border',
							'name' => 'icon_border',
							'selector' => '.lqd-iconlist-icon'
						],
						[
							'type' => 'border_radius',
							'name' => 'icon_border_radius',
							'selector' => '.lqd-iconlist-icon'
						],
						[
							'type' => 'border',
							'name' => 'iconlist_item_border',
							'selector' => '.lqd-iconlist-item'
						],
						[
							'type' => 'border_radius',
							'name' => 'iconlist_item_border_radius',
							'selector' => '.lqd-iconlist-item'
						],
					],
					'condition' => [
						'enable_icon_list' => 'yes'
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors' => [ 'hover' => ' .lqd-box-iconlist-item:hover' ]
				],
				'lines' => [
					'controls' => [
						[
							'type' => 'liquid_background_css',
						],
					],
					'selector' => '.lqd-overlay-line:before',
					'conditions' => [
						'relation' => 'and',
						'terms' => [
							[
								'name' => 'lqd_overlay_lines_count[size]',
								'operator' => '!==',
								'value' => 0
							],
							[
								'name' => 'lqd_overlay_lines_count[size]',
								'operator' => '!==',
								'value' => ''
							],
						]
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				]
			],
		);

	}

	private function get_fig_attrs( $settings ) {

		$image_placement = $settings['image_placement'];
		/**
		 * don't add overflow-hidden because it'll prevent the 3d effect when
		 * button_pos is set to on_image and hover 3d enabled
		 */
		$fig_classnames = [ 'lqd-box-image', 'shrink-0', 'basis-auto', 'transition-all' ];
		$fig_attrs = [];

		if ( $settings['image_placement'] === 'behind_content' ) {
			array_push( $fig_classnames, 'absolute', 'w-full', 'h-full', 'top-0', 'start-0', 'z-0' );
		} else {
			$fig_classnames[] = 'relative';
		}

		if ( $image_placement === 'top' || $image_placement === 'bottom' ) {
			$fig_classnames[] = 'w-full';
		} else {
			$fig_classnames[] = 'grow';
		}

		if ( $image_placement === 'end' || $image_placement === 'bottom' ) {
			$fig_classnames[] = 'order-1';
		}

		if ( $settings['lqd_hover_3d_intensity']['size'] > 0 && $settings['lqd_hover_3d_content_pop']['size'] > 0 ) {
			$fig_classnames[] = 'lqd-transform-3d';
		}

		$fig_attrs['class'] = $fig_classnames;

		return $fig_attrs;

	}

	private function render_overlay_lines( $settings ) {

		$lqd_overlay_lines_count = $settings['lqd_overlay_lines_count']['size'];
		$lqd_overlay_lines_dir = $settings['lqd_overlay_lines_dir'];

		if ( empty( $lqd_overlay_lines_count ) || $lqd_overlay_lines_count == 0 ) return;

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

		<?php

	}

	private function render_media( $settings ) {

		if ( empty( $settings['image_liquid_background_items'] ) ) return;

		$this->add_render_attribute('image_figure', $this->get_fig_attrs( $settings ) );

		/**
		 * Adding <img> just for SEO
		 */
		?>

		<figure <?php $this->print_render_attribute_string( 'image_figure' ); ?>><?php
			$this->get_liquid_background( 'image', false, 'box-image' . ( $settings['image_placement'] === 'behind_content' ? ' pt-0' : '' ) );
			if ( !empty( $settings['image_overlay_hover_liquid_background_items'] ) ) { ?>
			<div class="overflow-hidden transition-opacity opacity-0 lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit lqd-group-box-hover:opacity-100">
				<?php $this->get_liquid_background( 'image_overlay_hover', false, 'box-image' ); ?>
			</div>
			<?php }
			if ( !empty( $settings['dark_image_overlay_hover_liquid_background_items'] ) ) { ?>
			<div class="hidden lqd-dark-bg-wrap lqd-dark:block rounded-inherit">
				<div class="overflow-hidden transition-opacity opacity-0 lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit lqd-group-box-hover:opacity-100">
					<?php $this->get_liquid_background( 'dark_image_overlay_hover', false, 'box-image' ); ?>
				</div>
			</div>
			<?php }
			$this->render_overlay_lines( $settings );
			if ( $settings['button_pos'] === 'on_image' ) {
				$this->render_button( $settings );
			}
		?></figure>

		<?php

	}

	private function check_if_is_not_in_separate_content( $settings, $is_in_separate_content, $part ) {

		return (
			(
				!$is_in_separate_content &&
				!empty( $settings['separate_content_parts'] ) &&
				$settings['separate_content'] === 'yes' &&
				in_array( $part, $settings['separate_content_parts'] )
			) ||
			(
				$is_in_separate_content &&
				!empty( $settings['separate_content_parts'] ) &&
				$settings['separate_content'] === 'yes' &&
				!in_array( $part, $settings['separate_content_parts'] )
			)
		);

	}

	private function render_title( $settings, $is_in_separate_content = false ) {

		if (
			empty( $settings['title'] ) ||
			$this->check_if_is_not_in_separate_content( $settings, $is_in_separate_content, 'title' )
		) return;

		$title_classnames = [ 'lqd-box-title', 'items-center', 'relative', 'mb-0', 'transition-colors' ];
		$label_is_set = !empty( $settings['box_label'] );
		$label_is_inline = $settings['box_label_inline'] === 'yes';
		$label_placement = $settings['box_label_placement'];
		$icon_is_inline = $settings['icon_inline'] === 'yes';

		$this->add_render_attribute( 'title', [
			'class' => $title_classnames
		]);

		if (  $label_is_set && !$label_is_inline && $label_placement === 'before_title' ) {
			$this->render_box_label( $settings );
		}

		echo sprintf(
			'<%1$s %2$s>',
			Utils::validate_html_tag( $settings['title_tag'] ),
			$this->get_render_attribute_string('title')
		);

		$icon_is_inline && $settings['icon_inline_placement'] === 'start' ? $this->render_icon( $settings ) : '';
		if (  $label_is_set && $label_is_inline && $label_placement === 'before_title' ) {
			$this->render_box_label( $settings );
		}
		echo $settings['title'];
		if (  $label_is_set && $label_is_inline && $label_placement === 'after_title' ) {
			$this->render_box_label( $settings );
		}
		$icon_is_inline && $settings['icon_inline_placement'] === 'end' ? $this->render_icon( $settings ) : '';

		echo sprintf('</%1$s>',
			Utils::validate_html_tag( $settings['title_tag'] ),
		);

		if (  $label_is_set && !$label_is_inline && $label_placement === 'after_title' ) {
			$this->render_box_label( $settings );
		}

	}

	private function render_subtitle( $settings, $is_in_separate_content = false ) {

		if (
			empty( $settings['subtitle'] ) ||
			$this->check_if_is_not_in_separate_content( $settings, $is_in_separate_content, 'subtitle' )
		) return;

		$subtitle_classnames = [ 'lqd-box-subtitle', 'items-center', 'relative', 'mt-0', 'mb-0', 'transition-colors' ];

		$this->add_render_attribute( 'subtitle', [
			'class' => $subtitle_classnames
		]);

		echo sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			Utils::validate_html_tag( $settings['subtitle_tag'] ),
			$this->get_render_attribute_string('subtitle'),
			$settings['subtitle'],
		);

	}

	private function render_description( $settings, $is_in_separate_content = false ) {

		if (
			empty( $settings['description'] ) && empty( $settings['icon_list'] ) ||
			$this->check_if_is_not_in_separate_content( $settings, $is_in_separate_content, 'description' )
		) return;

		?>

		<div class="relative transition-colors lqd-box-description"><?php
			echo $this->parse_text_editor( $settings['description'] );
			$this->render_icon_list( $settings );
			if ( !empty( $settings['description_after_icon_list'] ) ) {
				echo $this->parse_text_editor( $settings['description_after_icon_list'] );
			}
		?></div>

		<?php

	}

	private function render_box_label( $settings ) {

		$label_classnames = [ 'lqd-box-label', 'inline-block', 'align-middle', 'transition-colors' ];
		$label_placement = $settings['box_label_placement'];

		if ( $label_placement === 'floating' ) {
			$label_classnames[] = 'absolute';
			$label_classnames[] = 'z-1';
 		} else {
			$label_classnames[] = 'relative';
		}

		if ( !empty( $settings['selected_icon']['value'] ) && $label_placement === 'before_title' ) : ?>
		<br />
		<?php endif;

		$this->add_render_attribute( 'box_label', [
			'class' => $label_classnames
		] );

		?>

		<span <?php $this->print_render_attribute_string('box_label'); ?>><?php
			echo esc_html( $settings['box_label'] );
		?></span>

		<?php

	}

	private function render_icon( $settings, $is_in_separate_content = false ) {

		if (
			empty( $settings['selected_icon']['value'] ) ||
			$this->check_if_is_not_in_separate_content( $settings, $is_in_separate_content, 'icon' )
		) return;

		$icon_classnames = [ 'lqd-box-icon', 'inline-flex', 'shrink-0', 'grow-0', 'basis-auto', 'items-center', 'justify-center', 'relative', 'transition-all' ];

		$this->add_render_attribute('icon', [
			'class' => $icon_classnames
		]);

		?>

		<span <?php $this->print_render_attribute_string( 'icon' ); ?>><?php
			$this->get_liquid_background( 'icon_background', false, 'box-icon' );
			if ( !empty( $settings['icon_background_hover_liquid_background_items'] ) ): ?>
			<span class="overflow-hidden transition-opacity opacity-0 lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit lqd-group-box-hover:opacity-100">
				<?php $this->get_liquid_background( 'icon_background_hover', false, 'box-icon' ); ?>
			</span>
			<?php endif;
			if ( !empty( $settings['dark_icon_background_liquid_background_items'] ) ) : ?>
			<span class="hidden lqd-dark-bg-wrap lqd-dark:block rounded-inherit">
				<?php $this->get_liquid_background( 'dark_icon_background', false, 'box-icon' ); ?>
				<?php if ( !empty( $settings['dark_icon_background_hover_liquid_background_items'] ) ) : ?>
				<span class="overflow-hidden transition-opacity opacity-0 lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit lqd-group-box-hover:opacity-100">
					<?php $this->get_liquid_background( 'dark_icon_background_hover', false, 'box-icon' ); ?>
				</span>
				<?php endif; ?>
			</span>
			<?php endif;
			\LQD_Elementor_Helper::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		?></span>

		<?php

	}

	private function render_button( $settings, $is_in_separate_content = false ) {

		if (
			$settings['show_button'] !== 'yes' ||
			$this->check_if_is_not_in_separate_content( $settings, $is_in_separate_content, 'button' )
		) return;

		$wrapper_classnames = ['lqd-box-btn'];

		if ( $settings['button_pos'] === 'on_image' ) {
			$wrapper_classnames[] = 'lqd-box-btn-floating absolute z-1 lqd-transform-3d';
		} else {
			$wrapper_classnames[] = 'relative';
		}

		$this->add_render_attribute( 'button_wrapper', [
			'class' => $wrapper_classnames
		] );

		?>

		<div <?php $this->print_render_attribute_string( 'button_wrapper' ) ?>>
			<?php \LQD_Elementor_Render_Button::get_button( $this, 'ib_' ); ?>
		</div>

		<?php

	}

	private function render_icon_list( $settings ) {

		if ( empty( $settings['icon_list'] ) ) return;

		$this->add_render_attribute( 'icon_list', 'class', 'lqd-iconlist lqd-box-iconlist m-0 p-0 relative list-none transition-colors' );
		$this->add_render_attribute( 'list_item', 'class', 'lqd-iconlist-item lqd-box-iconlist-item flex items-center' );

		?>

		<ul <?php $this->print_render_attribute_string( 'icon_list' ); ?>>
			<?php foreach ( $settings['icon_list'] as $index => $item ) :
				$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );

				$this->add_render_attribute( $repeater_setting_key, 'class', 'lqd-iconlist-text' );

				$this->add_inline_editing_attributes( $repeater_setting_key );
			?>
			<li <?php $this->print_render_attribute_string( 'list_item' ); ?>>
				<?php if ( ! empty( $item['link']['url'] ) ) {
					$link_key = 'link_' . $index;
					$this->add_link_attributes( $link_key, $item['link'] );
				?>
				<a <?php $this->print_render_attribute_string( $link_key ); ?>>
				<?php }

				if ( !empty( $item['selected_icon']['value'] ) ) : ?>
					<span class="lqd-iconlist-icon lqd-box-iconlist-icon inline-flex items-center justify-center transition-all">
						<?php \LQD_Elementor_Helper::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current' ] ); ?>
					</span>
				<?php endif; ?>
				<span <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>><?php $this->print_unescaped_setting( 'text', 'icon_list', $index ); ?></span>
				<?php if ( ! empty( $item['link']['url'] ) ) : ?>
					</a>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>

		<?php

	}

	protected function render_separated_content( $settings ) {

		$separate_content_classnames = [ 'lqd-box-content-separate', 'transition-all' ];
		$separate_content_is_floating = $settings['separate_content_placement'] === 'floating';

		if ( $separate_content_is_floating ) {
			$separate_content_classnames[] = 'lqd-box-content-floating';
			$separate_content_classnames[] = 'absolute';
			$separate_content_classnames[] = 'z-10';
			$separate_content_classnames[] = 'whitespace-nowrap';
		} else {
			$separate_content_classnames[] = 'relative';
		}

		if ( $settings['content_floating_bubble'] === 'yes' ) {
			$separate_content_classnames[] = 'lqd-bubble-arrow';
			$separate_content_classnames[] = 'lqd-bubble-arrow-' . $settings['content_floating_bubble_direction'];
		}

		$this->add_render_attribute( 'last_content_separate', [
			'class' => $separate_content_classnames
		] );

		?>
		<div <?php $this->print_render_attribute_string( 'last_content_separate' ); ?>>
		<?php foreach ( $settings['separate_content_parts'] as $part ) {
			if ( $part === 'button' && $settings['button_pos'] === 'on_image' ) continue;
			$this->{'render_'.$part}( $settings, true );
		} ?>
		</div>
		<?php

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$content_classnames = [ 'lqd-box-content', 'relative', 'z-1', 'transition-all' ];
		$separate_content_enabled =
			$settings['separate_content'] === 'yes' &&
			!empty( $settings['separate_content_parts'] );
		$separate_content_classnames = [ 'lqd-box-content-separate', 'relative' ];
		$separate_content_is_floating = $settings['separate_content_placement'] === 'floating';
		$link = $settings['link'];

		if ( $link ) {
			$this->add_link_attributes( 'link', $link );
			$this->add_render_attribute( 'link', 'class', 'inline-block w-full h-full absolute top-0 start-0 z-2' );

			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute( 'link', [
					'class' => 'elementor-clickable',
				] );
			}
		}

		if ( $separate_content_enabled ) {
			$content_classnames[] = 'flex';
			if ( $settings['separate_content_placement']  === 'start' ) {
				$content_classnames[] = 'flex-row-reverse';
			}
		}

		if (
			( !$separate_content_enabled && empty( $settings['image_liquid_background_items'] ) ) ||
			( !$separate_content_enabled && $settings['image_placement'] === 'behind_content' )
		) {
			$content_classnames[] = 'grow';
		}

		if ( $settings['lqd_hover_3d_intensity']['size'] > 0 && $settings['lqd_hover_3d_content_pop']['size'] > 0 ) {
			$content_classnames[] = 'lqd-transform-3d';
		}

		$this->add_render_attribute( 'content', [
			'class' => $content_classnames
		] );
		$this->add_render_attribute( 'content_separate', [
			'class' => $separate_content_classnames
		] );

		$this->render_media( $settings );

		?>

		<div <?php $this->print_render_attribute_string( 'content' ); ?>>

			<?php
				if ( !empty( $settings['box_label'] ) && $settings['box_label_placement'] === 'floating' ) {
					$this->render_box_label( $settings );
				};
			?>

			<?php
				$this->get_liquid_background( 'content_background', false, 'box-content' );
				if ( !empty( $settings['content_background_hover_liquid_background_items'] ) ):
			?><div class="overflow-hidden transition-opacity opacity-0 lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit lqd-group-box-hover:opacity-100">
				<?php $this->get_liquid_background( 'content_background_hover', false, 'box-content' ); ?>
			</div><?php endif; // end if $content_background_hover
			if ( !empty( $settings['dark_content_background_liquid_background_items'] ) ) : ?>
			<div class="hidden lqd-dark-bg-wrap lqd-dark:block rounded-inherit"><?php
				$this->get_liquid_background( 'dark_content_background', false, 'box-content' );
				if ( !empty( $settings['dark_content_background_hover_liquid_background_items'] ) ) : ?>
				<div class="overflow-hidden transition-opacity opacity-0 lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit lqd-group-box-hover:opacity-100">
				<?php $this->get_liquid_background( 'dark_content_background_hover', false, 'box-content' ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endif;  // end if $dark_content_background
			if ( $separate_content_enabled ) :
			?><div <?php $this->print_render_attribute_string( 'content_separate' ); ?>>
			<?php endif; // end if $separate_content_enabled

			if ( $settings['icon_inline'] !== 'yes' ) {
				$this->render_icon( $settings );
			}

			$this->render_title( $settings );
			$this->render_subtitle( $settings );
			$this->render_description( $settings );

			if ( $settings['button_pos'] === 'default' ) {
				$this->render_button( $settings );
			}

			if ( $separate_content_enabled ) : ?>
			</div>
			<?php endif; // end if $separate_content_enabled

			if ( $separate_content_enabled && !$separate_content_is_floating ) {
				$this->render_separated_content( $settings );
			}
			?>

		</div>

		<?php

		if ( $separate_content_enabled && $separate_content_is_floating ) {
			$this->render_separated_content( $settings );
		}

		if ( $link && !empty( $link['url'] ) ) : ?>
			<a <?php $this->print_render_attribute_string( 'link' ); ?>></a>
		<?php endif;

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Box() );