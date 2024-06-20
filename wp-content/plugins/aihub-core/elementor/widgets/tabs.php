<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Tabs extends Widget_Base {

	public function get_name() {
		return 'lqd-tabs';
	}

	public function get_title() {
		return __( 'Liquid Tabs', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-tabs lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'tab', 'tabs' ];
	}

	public function get_style_depends() {
		return [ 'liquid-sc-tabs' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$behavior = [];
		$el_id = $this->get_id();
		$toggleBehaviorOptions = [
			'openedItem' => '0',
			'toggleOffActiveItem' => 'true',
			'keepOneItemActive' => 'true',
			'changePropPrefix' => "'lqdTabsToggle-$el_id'",
			'ui' => [
				'togglableTriggers' => "'.lqd-tabs-trigger'",
				'togglableElements' => "'.lqd-tabs-content'",
			]
		];

		if ( $settings['tab_trigger'] === 'hover' ) {
			$toggleBehaviorOptions['triggerElements'] = [
				"'pointerenter @togglableTriggers'",
			];
		}

		$behavior[] = [
			'behaviorClass' => 'LiquidToggleBehavior',
			'options' => $toggleBehaviorOptions
		];
		$behavior[] = [
			'behaviorClass' => 'LiquidEffectsDisplayToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdTabsToggle-$el_id'",
			]
		];
		$behavior[] = [
			'behaviorClass' => 'LiquidEffectsFadeToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdTabsToggle-$el_id'",
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

		$repeater = new Repeater();

		$repeater->add_control(
			'item_title', [
				'label' => __( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_title_badge', [
				'label' => __( 'Title badge', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_subtitle', [
				'label' => __( 'Subtitle', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content_type',
			[
				'label' => __( 'Content Type', 'aihub-core' ),
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
					'content_type' => 'image'
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'default' => 'full',
				'condition' => [
					'content_type' => 'image'
				],
			]
		);

		$repeater->add_control(
			'content_templates', [
				'label' => __( 'Select Template', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => liquid_helper()->get_elementor_templates(),
				'description' => liquid_helper()->get_elementor_templates_edit(),
				'default' => '0',
				'condition' => [
					'content_type' => 'el_template'
				],
			]
		);

		$repeater->add_control(
			'item_content', [
				'label' => __( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'condition' => [
					'content_type' => 'tinymce'
				],
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label' => __( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
			]
		);

		$repeater->add_control(
			'item_custom_id', [
				'label' => __( 'Custom ID', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => 'automated-system',
				'description' => __( 'Set a custom ID without the "#". Leave blank if you want it to be defined automatically. Each tab must have a different ID.' , 'aihub-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_responsive_control(
			'image_margin',
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-content-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_type' => 'image'
				],
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-content-img',
				'condition' => [
					'content_type' => 'image'
				],
			]
		);

		$repeater->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-content-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_type' => 'image'
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-content-img',
				'condition' => [
					'content_type' => 'image'
				],
			]
		);

		$repeater->add_control(
			'title_badge_heading',
			[
				'label' => esc_html__( 'Badge styles', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'item_title_badge!' => ''
				],
			]
		);

		$repeater->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'asdasdafse_agagaer',
			  'label'   => esc_html__( 'Section Label', 'aihub-core' ),
			  'types'    => [ 'classic', 'gradient' ],
			  'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-trigger-badge',
			  'condition' => [
					'item_title_badge!' => ''
				]
		   ]
		 );

		\LQD_Elementor_Helper::add_style_controls(
			$repeater,
			'tabs',
			[
				'trigger_badge' => [
					'controls' => [
						[
							'type' => 'typography',
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
					'selector' => '{{CURRENT_ITEM}} .lqd-tabs-trigger-badge',
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors_before' => [ 'hover' => '{{CURRENT_ITEM}}', 'active' => '{{CURRENT_ITEM}}' ],
					'condition' => [
						'item_title_badge!' => ''
					]
				]
			],
			true
		);

		// LQD_Elementor_Helper::nav_items_controls(
		// 	'title_badge',
		// 	'',
		// 	'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-trigger-badge',
		// 	$repeater,
		// 	[ 'item_title_badge!' => '' ]
		// );

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_title' => __( 'Automated System', 'aihub-core' ),
						'item_subtitle' => __( 'All in one landing and startup solutions.', 'aihub-core' ),
						'item_content' => __( 'Bring your ideas to life with an intuitive visuals editor. Create, edit, and customize your website visually and see the changes instantly. Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, necessitatibus.', 'aihub-core' ),
						'item_icon' => [
							'value' => 'fas fa-cogs',
							'library' => 'fa-solid'
						],
					],
					[
						'item_title' => __( 'Digital Marketing', 'aihub-core' ),
						'item_subtitle' => __( 'All in one landing and startup solutions.', 'aihub-core' ),
						'item_content' => __( 'Bring your ideas to life with an intuitive visuals editor. Create, edit, and customize your website visually and see the changes instantly. Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, necessitatibus.', 'aihub-core' ),
						'item_icon' => [
							'value' => 'fas fa-chart-area',
							'library' => 'fa-solid'
						],
					],
					[
						'item_title' => __( 'Social Media', 'aihub-core' ),
						'item_subtitle' => __( 'All in one landing and startup solutions.', 'aihub-core' ),
						'item_content' => __( 'Bring your ideas to life with an intuitive visuals editor. Create, edit, and customize your website visually and see the changes instantly. Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, necessitatibus.', 'aihub-core' ),
						'item_icon' => [
							'value' => 'fas fa-share-alt',
							'library' => 'fa-solid'
						],
					],
				],
				'title_field' => '{{{ item_title }}}',
				'separator' => 'after'
			]
		);

		$this->add_responsive_control(
			'nav_placement',
			[
				'label' => esc_html__( 'Navigation placement', 'aihub-core' ),
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
						'title' => esc_html__( 'start', 'aihub-core' ),
						'icon' => 'eicon-arrow-left',
					],
				],
				'render_type' => 'template',
				'prefix_class' => 'lqd-tabs-nav-placement-',
				'default' => 'top',
				'toggle' => false,
				'selectors_dictionary' => [
					'top' => 'column',
					'bottom' => 'column-reverse',
					'end' => 'row-reverse',
					'start' => '',
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'flex-direction: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'nav_alignment_v',
			[
				'label' => esc_html__( 'Navigation alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'' => [
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
				'render_type' => 'template',
				'prefix_class' => 'lqd-tabs-nav-align-v-',
				'default' => 'stretch',
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-nav' => 'align-self: {{VALUE}};'
				],
				'condition' => [
					'nav_placement' => [ 'top', 'bottom' ]
				]
			]
		);

		$this->add_responsive_control(
			'nav_items_alignment_v',
			[
				'label' => esc_html__( 'Navigation items alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'' => [
						'title' => esc_html__( 'Stretch', 'aihub-core' ),
						'icon' => 'eicon-h-align-stretch',
					],
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
				'render_type' => 'template',
				'prefix_class' => 'lqd-tabs-nav-items-align-v-',
				'default' => '',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-nav' => 'justify-content: {{VALUE}};'
				],
				'condition' => [
					'nav_placement' => [ 'start', 'end' ]
				]
			]
		);

		$this->add_responsive_control(
			'nav_items_alignment_h',
			[
				'label' => esc_html__( 'Navigation items alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'space-between' => [
						'title' => esc_html__( 'Space between', 'aihub-core' ),
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
				'render_type' => 'template',
				'prefix_class' => 'lqd-tabs-nav-items-align-h-',
				'default' => 'space-between',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-nav' => 'justify-content: {{VALUE}};'
				],
				'condition' => [
					'nav_placement' => [ 'top', 'bottom' ]
				]
			]
		);

		$this->add_responsive_control(
			'nav_items_wrap',
			[
				'label' => esc_html__('Items wrap', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'nowrap' => [
						'title' => esc_html__('No wrap', 'aihub-core'),
						'icon' => 'eicon-nowrap',
					],
					'wrap' => [
						'title' => esc_html__('Wrap', 'aihub-core'),
						'icon' => 'eicon-wrap',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-nav' => 'flex-wrap: {{VALUE}};'
				],
				'condition' => [
					'nav_placement' => [ 'top', 'bottom' ]
				]
			]
		);

		$this->add_responsive_control(
			'nav_text_align',
			[
				'label' => esc_html__( 'Navigation text align', 'aihub-core' ),
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
					'{{WRAPPER}} .lqd-tabs-nav' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_trigger',
			[
				'label' => __( 'Trigger', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'click' => [
						'title' => __( 'Click', 'aihub-core' ),
						'icon' => 'eicon-click'
					],
					'hover' => [
						'title' => __( 'Hover', 'aihub-core' ),
						'icon' => 'eicon-drag-n-drop'
					],
				],
				'default' => 'click',
				'toggle' => false,
				'separator' => 'before'
			]
		);

		/**
		 * TODO: implement this
		 */
		// $this->add_control(
		// 	'enable_deeplinks',
		// 	[
		// 		'label' => __( 'Deeplinks', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 	]
		// );

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'tabs',
			[
				'nav' => [
					'controls' => [
						[
							'type' => 'width',
							'css_var' => '--lqd-tabs-n-width'
						],
						[
							'type' => 'gap',
							'label' => 'Gap between triggers',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-tabs-n-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-tabs-n-p'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-tabs-n-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-tabs-n-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-tabs-n-bs'
						],
					],
					'plural_heading' => false
				],
				'trigger' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'width',
							'css_var' => '--lqd-tabs-t-width'
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-tabs-t-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-tabs-t-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-tabs-t-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-tabs-t-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-tabs-t-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-tabs-t-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-tabs-t-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
				],
				'trigger_icon' => [
					'controls' => [
						[
							'type' => 'font_size',
						],
						[
							'type' => 'liquid_linked_dimensions',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-tabs-ti-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-tabs-ti-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-tabs-ti-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-tabs-ti-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-tabs-ti-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-tabs-ti-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-tabs-ti-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors_before' => [ 'hover' => '.lqd-tabs-trigger', 'active' => '.lqd-tabs-trigger' ]
				],
				'trigger_title' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-tabs-tt-m'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-tabs-tt-color'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors_before' => [ 'hover' => '.lqd-tabs-trigger', 'active' => '.lqd-tabs-trigger' ]
				],
				'trigger_subtitle' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-tabs-tst-m'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-tabs-tst-color'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors_before' => [ 'hover' => '.lqd-tabs-trigger', 'active' => '.lqd-tabs-trigger' ]
				],
				'content' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-tabs-c-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-tabs-c-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-tabs-c-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-tabs-c-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-tabs-c-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-tabs-c-bs'
						],
					],
				],
			],
		);

		lqd_elementor_add_button_controls( $this, 'ib_' );

	}

	protected function get_button_content( $item, $active ) {

		$title = $item['item_title'];
		$subtitle = $item['item_subtitle'];
		$title_badge = $item['item_title_badge'];

		?>

		<?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
			<span class="lqd-tabs-trigger-icon inline-flex grow-0 shrink-0 pointer-events-none <?php echo $active ? esc_attr( 'lqd-is-active' ) : '' ?>"><?php
				\LQD_Elementor_Helper::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em align-middle fill-current relative' ] );
			?></span>
		<?php
		endif;
		if ( ! empty( $title ) || ! empty( $subtitle ) ) : ?>
			<span class="block grow pointer-events-none"><?php
				if ( ! empty( $title ) ) : ?>
					<span class="lqd-tabs-trigger-title block"><?php
						echo $title;
						if ( !empty( $title_badge ) ) : ?>
						<span class="lqd-tabs-trigger-badge inline-flex leading-none"><?php echo $title_badge; ?></span>
						<?php endif;
					?></span>
				<?php
				endif;
				if ( ! empty( $subtitle ) ) : ?>
					<span class="lqd-tabs-trigger-subtitle block text-percent-75"><?php echo $subtitle ?></span>
				<?php endif;
			?></span>
		<?php endif;

	}

	/**
	 * TODO: add accessibility attrs
	 */
	protected function get_nav_items( $settings ) {

		$items = $settings['items'];

		if ( empty( $items ) ) return '';

		$trigger_common_classnames = [ 'lqd-tabs-trigger', 'lqd-togglable-trigger', 'lqd-widget-trigger', 'flex', 'basis-0', 'shrink', 'bg-transparent', 'transition-colors', 'cursor-pointer' ];
		$has_custom_trigger_width = !empty( $settings['trigger_width']['size'] );

		if (
			(
				(
					(
						$settings['nav_placement'] === 'top' ||
						$settings['nav_placement'] === 'bottom'
					) &&
					empty($settings['nav_items_alignment_h'])
				) ||
				(
					(
						$settings['nav_placement'] === 'start' ||
						$settings['nav_placement'] === 'end'
					) &&
					empty($settings['nav_items_alignment_v'])
				)
			) &&
			!$has_custom_trigger_width
		) {
			$trigger_common_classnames[] = 'grow';
		}

		foreach ( $items as $i => $item ) {

			$trigger_attrs_id = $this->get_repeater_setting_key( 'trigger', 'items', $i );
			$trigger_classnames = $trigger_common_classnames;
			$title = $item['item_title'];
			$subtitle = $item['item_subtitle'];
			$active = $i === 0;
			$item_custom_id = $item['item_custom_id'];
			$target_id = !empty( $item_custom_id ) ?
				$item_custom_id :
				'lqd-tabs-content-' . $item['_id'] . '-' . sanitize_title( !empty($item_title) ? $item_title : $item['_id'] );

			if ( empty( $title ) || empty( $subtitle ) ) {
				$trigger_classnames[] = 'items-center';
			}

			if ( $active ) {
				$trigger_classnames[] = 'lqd-is-active';
			}

			$trigger_classnames[] = 'elementor-repeater-item-' . $item['_id'];

			$this->add_render_attribute( $trigger_attrs_id, [
				'class' => $trigger_classnames,
				'href' => '#' . $target_id
			] );

		?>

			<a <?php $this->print_render_attribute_string( $trigger_attrs_id ) ?>><?php
				$this->get_button_content( $item, $active );
			?></a>

		<?php }

	}

	protected function get_content_type_tinymce( $item ) {

		echo $item['item_content'];

	}

	protected function get_content_type_image( $item ) {

		?>
		<figure class="lqd-tabs-content-img overflow-hidden"><?php
			Group_Control_Image_Size::print_attachment_image_html( $item );
		?></figure>
		<?php

	}

	protected function get_content_type_el_template( $item ) {

		echo \Elementor\Plugin::instance()->frontend->get_builder_content( $item[ 'content_templates' ], $with_css = true );

	}

	protected function get_content( $item ) {

		/**
		 * @type {string} tinymce | image | el_template
		 */
		$content_type = $item['content_type'];

		$this->{'get_content_type_' . $content_type}( $item );

	}

	protected function get_contents( $settings ) {

		$items = $settings['items'];
		$content_common_classnames = [ 'lqd-tabs-content', 'lqd-togglable-element' ];

		foreach ( $items as $i => $item ) {

			$content_attrs_id = $this->get_repeater_setting_key( 'content', 'items', $i );
			$content_classnames = $content_common_classnames;
			$item_title = $item['item_title'];
			$item_custom_id = $item['item_custom_id'];
			$item_id = !empty( $item_custom_id ) ?
				$item_custom_id :
				'lqd-tabs-content-' . $item['_id'] . '-' . sanitize_title( !empty($item_title) ? $item_title : $item['_id'] );

			$content_classnames[] = 'elementor-repeater-item-' . esc_attr( $item['_id'] ) . '';

			if ( $i === 0 ) {
				$content_classnames[] = 'lqd-is-active';
			} else {
				$content_classnames[] = 'hidden';
			}

			$this->add_render_attribute( $content_attrs_id, [
				'class' => $content_classnames,
				'id' => $item_id
			] );

		?>

		<div <?php $this->print_render_attribute_string( $content_attrs_id ) ?>><?php
			$this->get_content( $item );
		?></div>

		<?php }

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();
		$classnames = [ 'lqd-widget-container-flex' ];

		if ( empty( $this->get_settings_for_display( '_element_width' ) ) ) {
			$classnames[] = 'w-full';
		}

		$this->add_render_attribute( '_wrapper', [
			'class' => $classnames
		] );
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$nav_placement = $settings['nav_placement'];
		$nav_classnames = [ 'lqd-tabs-nav', 'flex' ];
		$content_wrapper_classnames = [ 'lqd-tabs-content-wrapper' ];

		if ( $nav_placement === 'start' || $nav_placement === 'end' ) {
			$nav_classnames[] = 'flex-col';
		}

		$this->add_render_attribute( 'nav', [
			'class' => $nav_classnames,
		]);
		$this->add_render_attribute( 'content', [
			'class' => $content_wrapper_classnames,
		]);

		?>
		<nav <?php $this->print_render_attribute_string( 'nav' ); ?>>
			<?php $this->get_nav_items( $settings ); ?>
		</nav>
		<?php $this->get_contents( $settings ); ?>
	<?php

	}

}

\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Tabs() );