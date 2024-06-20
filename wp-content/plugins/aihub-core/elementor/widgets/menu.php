<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Menu extends Widget_Base {
	public function get_name() {
		return 'lqd-menu';
	}

	public function get_title() {
		return __('Liquid Menu', 'aihub-core');
	}

	public function get_icon() {
		return 'eicon-nav-menu lqd-element';
	}

	public function get_categories() {
		return ['liquid-core'];
	}

	public function get_keywords() {
		return ['header', 'menu', 'navigation'];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$el_id = $this->get_id();
		$behavior = [];

		$behavior[] = [
			'behaviorClass' => 'LiquidToggleBehavior',
			'options' => [
				'disableOnTouch' => 'true',
				'changePropPrefix' => "'lqdMenuSubmenu-$el_id'",
				'ui' => [
					'togglableTriggers' => "'.menu-item-has-children'",
					'togglableElements' => "'.lqd-menu-dropdown'",
				],
				'triggerElements' => [
					"'pointerenter @togglableTriggers'",
					"'pointerleave @togglableTriggers'"
				]
			]
		];
		$behavior[] = [
			'behaviorClass' => 'LiquidDropdownBehavior'
		];

		$behavior[] = [
			'behaviorClass' => 'LiquidToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdMenuMobileToggle-$el_id'",
				'ui' => [
					'togglableTriggers' => "'.lqd-dropdown-trigger'",
					'togglableElements' => "'.lqd-menu-dropdown'",
				],
				'triggerElements' => [
					"'click @togglableTriggers'",
				]
			]
		];
		$behavior[] = [
			'behaviorClass' => 'LiquidEffectsSlideToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdMenuMobileToggle-$el_id'",
				'keepHiddenClassname' => 'false',
			]
		];

		$computed_styles_opts = [
			'getRect' => 'true',
			'includeSelf' => 'true'
		];

		if ( $settings['lqd_adaptive_color'] === 'yes' ) {
			$computed_styles_opts['getStyles'] = ["'position'"];
		}

		$behavior[] = [
			'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
			'options' => $computed_styles_opts
		];

		if ( $settings['layout'] === 'dropdown' || $this->mobile_dropdown_is_active() ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidToggleBehavior',
				'options' => [
					'changePropPrefix' => "'lqdMenuToggle-$el_id'",
					'toggleOffOnEscPress' => 'true',
					'toggleOffOnOutsideClick' => 'true',
					'ui' => [
						'togglableTriggers' => "'.lqd-trigger'",
						'togglableElements' => "'.lqd-menu-wrap'",
					],
					'triggerElements' => [
						"'click @togglableTriggers'",
					]
				]
			];
			$behavior[] = [
				'behaviorClass' => 'LiquidEffectsSlideToggleBehavior',
				'options' => [
					'changePropPrefix' => "'lqdMenuToggle-$el_id'",
					'keepHiddenClassname' => 'false',
				]
			];
		}

		if ( $settings['magnetic_items'] === 'yes' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidMagneticMouseBehavior',
			];
		}

		if ( $settings['lqd_adaptive_color'] === 'yes' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidAdaptiveColorBehavior',
			];
		}

		if ( $settings['localscroll'] === 'yes' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidLocalScrollBehavior',
				'options' => [
					'offset' => ( !empty( $settings['localscroll_offset']['size'] ) ? $settings['localscroll_offset']['size'] : 'null' ),
					'ui' => [
						'links' => "'.lqd-menu-link-top'"
					]
				]
			];
		}

		return $behavior;
	}

	public function get_behavior_pageContent() {

		$settings = $this->get_settings_for_display();
		$adaptive_color = $settings['lqd_adaptive_color'];
		$behavior = [];

		if ( !$adaptive_color ){
			return $behavior;
		}

		$behavior[] = [
			'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
			'options' => [
				'includeChildren' => true,
				'includeSelf' => true,
				'getOnlyContainers' => true,
				'getStyles' => ["'backgroundColor'"],
				'getBrightnessOf' => ["'backgroundColor'"],
				'getRect' => true
			]
		];

		return $behavior;
	}

	protected function add_nav_items_controls_state( $part, $state, $selector, $add_controls_to, $condition = [] ) {

		$add_controls_to->add_control(
			$part . '_color' . $state,
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$selector => 'color: {{VALUE}}',
				],
				'condition' => $condition
			]
		);

		$add_controls_to->add_group_control(
			'liquid-background-css',
			[
				'name' => $part . '_background' . $state,
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
				'condition' => $condition
			]
		);

		$add_controls_to->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $part . '_border' . $state,
				'selector' => $selector,
				'condition' => $condition
			]
		);

		$add_controls_to->add_responsive_control(
			$part . '_border_radius' . $state,
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => $condition
			]
		);

		$add_controls_to->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $part . '_box_shadow' . $state,
				'selector' => $selector,
				'condition' => $condition
			]
		);

	}

	protected function add_nav_items_controls( $add_controls_to, $individual_selector = null ) {

		$selector = '{{WRAPPER}} .lqd-menu-li-top';
		$condition = [];
		$control_name_postfix = $individual_selector ? '_' . $individual_selector : '';

		if ( $individual_selector ) {
			$condition['individual_selector'] = $individual_selector;
			switch ($individual_selector) {
				case 'first':
					$selector .= ':first-child';
					break;
				case 'last':
					$selector .= ':last-child';
					break;
				default:
					$selector .= ':nth-child(' . $individual_selector . ')';
					break;
			}
		}

		$selector .= ' > a';

		$add_controls_to->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_items_typography' . $control_name_postfix,
				'label' => __( 'Typography', 'aihub-core' ),
				'selector' => $selector,
				'condition' => $condition
			]
		);

		$add_controls_to->add_responsive_control(
			'nav_items_margin' . $control_name_postfix,
			[
				'label' => esc_html__( 'Margin', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => $condition
			]
		);

		$add_controls_to->add_responsive_control(
			'nav_items_padding' . $control_name_postfix,
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => $condition
			]
		);

		$add_controls_to->start_controls_tabs(
			'nav_items_styles_tabs' . $control_name_postfix
		);

		foreach ( [ 'normal', 'hover', 'active' ] as $state ) {

			if ( $state === 'localscroll_active' ) {
				$condition['localscroll'] = 'yes';
			}

			if ( $state === 'hover' ) {
				$selector .= ':hover';
			} else if ( $state === 'active' ) {
				$selector = '{{WRAPPER}} .lqd-menu-li-top > .current-menu-item, {{WRAPPER}} .lqd-menu-li-top.lqd-is-active';
			} else if ( $state === 'localscroll_active' ) {
				$selector .= '.lqd-is-active';
			}

			$add_controls_to->start_controls_tab(
				'nav_items_styles_tab_' . $state . $control_name_postfix,
				[
					'label' => esc_html__( ucwords( str_replace( '_', ' ', $state ) ), 'aihub-core' ),
					'condition' => $condition
				]
			);

			$this->add_nav_items_controls_state( 'nav_items', $state . $control_name_postfix, $selector, $add_controls_to, $condition );

			$add_controls_to->end_controls_tab();

		}

		$add_controls_to->end_controls_tabs();

	}

	protected function register_controls() {
		$active_breakpoints = \Elementor\Plugin::instance()->breakpoints->get_active_breakpoints();
		$excluded_breakpoints = [
			'widescreen',
			'laptop',
		];
		$breakpoints = array_filter( $active_breakpoints, function( $br ) use ( $excluded_breakpoints ) {
			return !in_array( $br->get_name(), $excluded_breakpoints );
		} );

		// General Section
		$this->start_controls_section(
			'general_section',
			[
				'label' => __('Menu', 'aihub-core'),
			]
		);

		$this->add_control(
			'source',
			[
				'label' => esc_html__('Menu source', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'wp' => [
						'title' => esc_html__('WP Menus', 'aihub-core'),
						'icon' => 'eicon-nav-menu',
					],
					'custom' => [
						'title' => esc_html__('Custom', 'aihub-core'),
						'icon' => 'eicon-menu-toggle',
					],
				],
				'default' => 'wp',
				'toggle' => false,
			]
		);

		$menus = liquid_helper()->get_available_menus();

		if ( !empty( $menus ) ) {
			$this->add_control(
				'menu_slug',
				[
					'label' => __('Menu', 'aihub-core'),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys($menus)[0],
					'save_default' => true,
					'description' => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'aihub-core'), admin_url('nav-menus.php')),
					'condition' => [
						'source' => 'wp'
					]
				]
			);
		} else {
			$this->add_control(
				'empty_menu_warning',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'aihub-core'), admin_url('nav-menus.php?action=edit&menu=0')),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition' => [
						'source' => 'wp'
					]
				]
			);
		}

		$custom_menu_repeater = new Repeater();

		$custom_menu_repeater->add_control(
			'label', [
				'label' => __( 'Label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$custom_menu_repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'aihub-core' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$custom_menu_repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
			]
		);

		$custom_menu_repeater->add_control(
			'icon_alignment',
			[
				'label' => __( 'Icon alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => __( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'end',
				'toggle' => false,
			]
		);

		$this->add_control(
			'custom_menu',
			[
				'label' => __( 'Items', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $custom_menu_repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default' => [
					[
						'label' => __( 'Home', 'aihub-core' ),
						'link' => [ 'url' => '#home' ]
					],
					[
						'label' => __( 'About', 'aihub-core' ),
						'link' => [ 'url' => '#about' ]
					],
					[
						'label' => __( 'Services', 'aihub-core' ),
						'link' => [ 'url' => '#services' ]
					],
				],
				'condition' => [
					'source' => 'custom'
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__('Layout', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'default' => [
						'title' => esc_html__('Default', 'aihub-core'),
						'icon' => 'eicon-form-vertical',
					],
					'dropdown' => [
						'title' => esc_html__('Dropdown', 'aihub-core'),
						'icon' => 'eicon-menu-bar',
					],
				],
				'default' => 'default',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'items_orientation',
			[
				'label' => esc_html__('Orientation', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__('Horizontal', 'aihub-core'),
						'icon' => 'eicon-ellipsis-h',
					],
					'column' => [
						'title' => esc_html__('Vertical', 'aihub-core'),
						'icon' => 'eicon-ellipsis-v',
					],
				],
				'default' => 'row',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-ul' => 'flex-direction: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'items_orientation_li_width',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'yes',
				'condition' => [
					'items_orientation' => 'column',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-li-top' => 'width: 100%;'
				]
			]
		);

		$this->add_responsive_control(
			'items_align',
			[
				'label' => esc_html__('Align', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'aihub-core'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'aihub-core'),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__('End', 'aihub-core'),
						'icon' => 'eicon-h-align-right',
					],
					'space-between' => [
						'title' => esc_html__('Stretch', 'aihub-core'),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'default' => 'start',
				'toggle' => false,
				'condition' => [
					'items_orientation' => 'row',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-ul, {{WRAPPER}} > .elementor-widget-container' => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .lqd-menu-li-top, {{WRAPPER}} .lqd-menu-link-top' => 'justify-content: {{VALUE}}; text-align: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'items_h_align',
			[
				'label' => esc_html__('Align', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'aihub-core'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'aihub-core'),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__('End', 'aihub-core'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'items_orientation' => 'column',
				],
				'default' => 'start',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-ul' => 'align-items: {{VALUE}}',
					'{{WRAPPER}} .lqd-menu-li-top, {{WRAPPER}} .lqd-menu-link-top' => 'justify-content: {{VALUE}}; text-align: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'items_wrap',
			[
				'label' => esc_html__('Wrap', 'aihub-core'),
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
				'default' => 'nowrap',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-ul' => 'flex-wrap: {{VALUE}};'
				],
				'condition' => [
					'items_orientation' => 'row'
				],
			]
		);

		$this->add_control(
			'localscroll',
			[
				'label' => esc_html__('Enable Localscroll?', 'aihub-core'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'localscroll_offset',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0
				],
				'condition' => [
					'localscroll' => 'yes',
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'mobile_dropdown',
			[
				'label' => esc_html__( 'Enable mobile dropdown', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => [
					'layout!' => 'dropdown',
				],
			]
		);

		$this->start_controls_tabs(
			'mobile_dropdown_breakpoints_tabs',
		);

		foreach ( array_reverse( $breakpoints ) as $breakpoint_key => $breakpoint_instance ) {

			$breakpoint_value = $breakpoint_instance->get_value();
			$breakpoint_label = $breakpoint_instance->get_label();

			$switcher_condition = [
				'layout!' => 'dropdown',
				'mobile_dropdown' => 'yes'
			];
			$info_conditions = [
				'relation' => 'or',
				'terms' => [],
			];
			$other_breakpoints_to_check = array_filter( $breakpoints, function( $br ) use ( $breakpoint_key ) {
				return $br->get_name() !== $breakpoint_key;
			} );

			foreach ( $other_breakpoints_to_check as $br_key => $br_instance ) {
				$switcher_condition[ 'mobile_dropdown_breakpoint_' . $br_key ] = '';
				$info_conditions['terms'][] = [
					'name' => 'mobile_dropdown_breakpoint_' . $br_key,
					'operator' => '!==',
					'value' => ''
				];
			}

			$this->start_controls_tab(
				'mobile_dropdown_breakpoint_tab_' . $breakpoint_key,
				[
					'label'   => esc_html__( $breakpoint_label, 'aihub-core' ),
					'condition' => [
						'layout!' => 'dropdown',
						'mobile_dropdown' => 'yes'
					]
				]
			);

			$this->add_control(
				'mobile_dropdown_breakpoint_' . $breakpoint_key,
				[
					'label' => esc_html__( 'Enable on ' . $breakpoint_label, 'aihub-core' ),
					'type' => Controls_Manager::SWITCHER,
					'return_value' => $breakpoint_value . 'px',
					'condition' => [
						'layout!' => 'dropdown',
						'mobile_dropdown' => 'yes'
					],
					'render_type' => 'template',
					'selectors' => [
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-wrap' => 'display: none; position:absolute; top:100%; left:0; right:0; z-index:10',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-ul' => ' max-height: 72vh; overflow-y: auto; justify-content: start;',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-trigger' => 'display: flex;',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-dropdown-trigger' => 'display:inline-flex',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-dropdown-arrow' => 'display:none',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-dropdown' => 'display:none;min-width:0;position:relative;border-radius:0;top:auto!important;bottom:auto!important;left:auto!important;right:auto!important;opacity:1;visibility:visible;transform:none;text-align:inherit;pointer-events:auto!important;',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-dropdown:before' => 'content:none',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-dropdown-trigger:after' => 'content:none',
						'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-dropdown .lqd-menu-dropdown ' => 'top:auto!important;bottom:auto!important;left:auto!important;right:auto!important;transform:none;',
					],
					'condition' => $switcher_condition
				]
			);

			$this->add_control(
				'mobile_dropdown_info_' . $breakpoint_key,
				[
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-panel-alert',
					'raw' => esc_html__( 'Another breakpoint is active.', 'aihub-core' ),
					'conditions' => $info_conditions
				]
			);

			$this->end_controls_tab();
		}

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'submenu_section',
			[
				'label' => esc_html__( 'Submenu', 'aihub-core' ),
			]
		);

		$this->add_responsive_control(
			'submenu_items_orientation',
			[
				'label' => esc_html__('Items orientation', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__('Horizontal', 'aihub-core'),
						'icon' => 'eicon-ellipsis-h',
					],
					'column' => [
						'title' => esc_html__('Vertical', 'aihub-core'),
						'icon' => 'eicon-ellipsis-v',
					],
				],
				'default' => 'column',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-dropdown' => 'flex-direction: {{VALUE}};',
				]
			]
		);

		// to adjust inner dropdowns positions when dropdown items orientation set to row
		$this->add_responsive_control(
			'submenu_dropdown_pos',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'true',
				'value' => 'true',
				'condition' => [
					'submenu_items_orientation' => 'row'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-dropdown .lqd-menu-dropdown' => 'top: 100%; inset-inline-start:0;',
				]
			]
		);

		$this->add_responsive_control(
			'submenu_items_align',
			[
				'label' => esc_html__('Align', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'aihub-core'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'aihub-core'),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__('End', 'aihub-core'),
						'icon' => 'eicon-h-align-right',
					],
					'space-between' => [
						'title' => esc_html__('Stretch', 'aihub-core'),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-dropdown' => 'justify-content: {{VALUE}}'
				],
				'condition' => [
					'submenu_items_orientation' => 'row',
				],
			]
		);

		$this->add_responsive_control(
			'submenu_items_wrap',
			[
				'label' => esc_html__('Wrap', 'aihub-core'),
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
				'default' => 'nowrap',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-dropdown' => 'flex-wrap: {{VALUE}};'
				],
				'condition' => [
					'submenu_items_orientation' => 'row'
				],
			]
		);

		$this->add_responsive_control(
			'submenu_items_h_align',
			[
				'label' => esc_html__('Align', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'aihub-core'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'aihub-core'),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__('End', 'aihub-core'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'submenu_items_orientation' => 'column',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-dropdown' => 'align-items: {{VALUE}}',
					'{{WRAPPER}} .lqd-menu-dropdown-li, {{WRAPPER}} .lqd-menu-dropdown-link' => 'justify-content: {{VALUE}}; text-align: {{VALUE}}'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'menu_effects',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'magnetic_items',
			[
				'label' => esc_html__( 'Magnetic top level links?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lqd_adaptive_color',
			[
				'label' => esc_html__( 'Enable adaptive color?', 'aihub-core' ),
				'description' => esc_html__( 'Useful for elements with fixed css position or when inside sticky header. This option make the element chage color dynamically when it is over light or dark sections.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'menu',
			[
				'ul_top' => [
					'label' => 'Navigation',
					'controls' => [
						[
							'type' => 'gap',
							'label' => 'Gap between links',
							'css_var' => '--lqd-menu-ul-gap'
						],
						[
							'type' => 'width',
							'selectors' => [
								'{{WRAPPER}} .lqd-menu-wrap' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};'
							],
							'condition' => [
								'layout' => 'dropdown'
							]
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'ul_top_position_h',
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
										'layout' => 'dropdown',
									]
								]
							],
							'responsive' => true,
							'tab' => 'none'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'ul_top_offset_x',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vw' ],
									'default' => [
										'unit' => '%',
										'size' => '0'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-wrap' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
									],
									'condition' => [
										'layout' => 'dropdown',
										'ul_top_position_h' => 'start'
									]
								]
							],
							'responsive' => true,
							'tab' => 'none'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'ul_top_offset_x_end',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vw' ],
									'default' => [
										'unit' => '%',
										'size' => '0'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-wrap' => 'inset-inline-start: auto; inset-inline-end: {{SIZE}}{{UNIT}}',
									],
									'condition' => [
										'layout' => 'dropdown',
										'ul_top_position_h' => 'end'
									]
								]
							],
							'responsive' => true,
							'tab' => 'none'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'ul_top_position_v',
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
										'layout' => 'dropdown',
									]
								]
							],
							'responsive' => true,
							'tab' => 'none'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'ul_top_offset_y',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vh' ],
									'default' => [
										'unit' => '%',
										'size' => '100'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-wrap' => 'top: {{SIZE}}{{UNIT}}',
									],
									'condition' => [
										'layout' => 'dropdown',
										'ul_top_position_v' => 'top'
									]
								]
							],
							'responsive' => true,
							'tab' => 'none'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'ul_top_offset_y_bottom',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vh' ],
									'default' => [
										'unit' => '%',
										'size' => '100'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-wrap' => 'top: auto; bottom: {{SIZE}}{{UNIT}}',
									],
									'condition' => [
										'layout' => 'dropdown',
										'ul_top_position_v' => 'bottom'
									]
								]
							],
							'responsive' => true,
							'tab' => 'none'
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-menu-ul-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-menu-ul-p'
						],
						[
							'type' => 'css_backdrop_filter',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-menu-ul-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-menu-ul-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-menu-ul-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ]
				],
				'li_top' => [
					'label' => 'Menu item',
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-menu-link-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-menu-link-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-menu-link-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-menu-link-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-menu-link-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-menu-link-bs'
						],
						[
							'type' => 'opacity',
							'css_var' => '--lqd-menu-link-op'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors' => [ 'active' => ' :is(.lqd-menu-link-top.lqd-is-active, .lqd-menu-li-top.current-menu-item > a)' ]
				],
				'dropdown' => [
					'label' => 'Submenu',
					'controls' => [
						[
							'type' => 'gap',
							'label' => 'Gap between links'
						],
						[
							'type' => 'width',
							'selectors' => [
								'{{WRAPPER}} .lqd-menu-dropdown' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};'
							]
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-menu-dropdown-p'
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'dropdown_position_h',
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
										'start' => 'inset-inline-end: auto;',
										'end' => 'inset-inline-start: auto;',
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-li-top > .lqd-menu-dropdown' => '{{VALUE}}'
									]
								]
							],
							'responsive' => true
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'dropdown_offset_x',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vw' ],
									'default' => [
										'unit' => '%',
										'size' => '0'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-li-top > .lqd-menu-dropdown' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
									],
									'condition' => [
										'dropdown_position_h' => 'start'
									],
								]
							],
							'responsive' => true
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'dropdown_offset_x_end',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vw' ],
									'default' => [
										'unit' => '%',
										'size' => '0'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-li-top > .lqd-menu-dropdown' => 'inset-inline-start: auto; inset-inline-end: {{SIZE}}{{UNIT}}',
										'{{WRAPPER}} .lqd-menu-li-top .lqd-menu-dropdown .lqd-menu-dropdown' => 'inset-inline-start: auto; inset-inline-end: 100%',
									],
									'condition' => [
										'dropdown_position_h' => 'end'
									],
								]
							],
							'responsive' => true
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'dropdown_position_v',
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
										'top' => 'bottom: auto;',
										'bottom' => 'top: auto;',
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-li-top > .lqd-menu-dropdown' => '{{VALUE}}'
									]
								]
							],
							'responsive' => true
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'dropdown_offset_y',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vh' ],
									'default' => [
										'unit' => '%',
										'size' => '100'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-li-top > .lqd-menu-dropdown' => 'top: {{SIZE}}{{UNIT}}',
										'{{WRAPPER}} .lqd-menu-dropdown-trigger:after' => 'bottom: calc({{SIZE}}{{UNIT}} * -1)',
									],
									'condition' => [
										'dropdown_position_v' => 'top'
									],
								]
							],
							'responsive' => true
						],
						[
							'type' => 'raw',
							'raw_options' => [
								'dropdown_offset_y_bottom',
								[
									'label' => esc_html__( 'Offset', 'aihub-core' ),
									'type' => Controls_Manager::SLIDER,
									'size_units' => [ 'px', '%', 'vh' ],
									'default' => [
										'unit' => '%',
										'size' => '100'
									],
									'selectors' => [
										'{{WRAPPER}} .lqd-menu-li-top > .lqd-menu-dropdown' => 'top: auto; bottom: {{SIZE}}{{UNIT}}',
										'{{WRAPPER}} .lqd-menu-dropdown-trigger:after' => 'bottom: 100%; top: calc({{SIZE}}{{UNIT}} * -1)',
										'{{WRAPPER}} .lqd-menu-li-top .lqd-menu-dropdown .lqd-menu-dropdown' => 'top: auto; bottom: 0',
									],
									'condition' => [
										'dropdown_position_v' => 'bottom'
									],
								]
							],
							'responsive' => true
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-menu-dropdown-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-menu-dropdown-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-menu-dropdown-bs'
						],
					],
				],
				'dropdown_link' => [
					'label' => 'Submenu item',
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-menu-dropdown-link-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-menu-dropdown-link-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-menu-dropdown-link-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-menu-dropdown-link-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-menu-dropdown-link-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'icon' => [
					'controls' => [
						[
							'type' => 'liquid_linked_dimensions',
						],
						[
							'type' => 'font_size',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-menu-icon-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-menu-icon-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-menu-icon-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-menu-icon-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-menu-icon-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-menu-icon-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors_before' => [ 'hover' => '.lqd-menu-link', 'active' => '.lqd-menu-link' ]
				],
				'badge' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-menu-badge-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-menu-badge-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-menu-badge-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-menu-badge-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-menu-badge-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-menu-badge-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-menu-badge-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors_before' => [ 'hover' => '.lqd-menu-link', 'active' => '.lqd-menu-link' ]
				],
			],
		);

		$this->start_controls_section(
			'mobile_dropdown_styles_section',
			[
				'label' => esc_html__( 'Mobile dropdown', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'mobile_dropdown' => 'yes'
				]
			]
		);

		foreach ( $breakpoints as $breakpoint_key => $breakpoint_instance ) {

			$this->add_responsive_control(
				'mobile_dropdown_width_' . $breakpoint_key,
				[
					'label' => esc_html__( 'Width', 'aihub-core' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'vw', 'custom' ],
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
						'{{WRAPPER}} .lqd-menu-wrap' => 'width: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .lqd-menu-ul' => 'width: 100%',
					],
					'condition' => [
						'mobile_dropdown' => 'yes',
						'mobile_dropdown_breakpoint_' . $breakpoint_key . '!' => ''
					]
				]
			);

			$this->add_control(
				'mobile_dropdown_orientation_h_' . $breakpoint_key,
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
						'mobile_dropdown' => 'yes',
						'mobile_dropdown_breakpoint_' . $breakpoint_key . '!' => ''
					]
				]
			);

			$this->add_responsive_control(
				'mobile_dropdown_offset_x_' . $breakpoint_key,
				[
					'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'vw', 'custom' ],
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
						'{{WRAPPER}} .lqd-menu-wrap' => 'inset-inline-start: {{SIZE}}{{UNIT}};inset-inline-end:auto!important;',
					],
					'condition' => [
						'mobile_dropdown' => 'yes',
						'mobile_dropdown_breakpoint_' . $breakpoint_key . '!' => '',
						'mobile_dropdown_orientation_h_'. $breakpoint_key => 'start'
					]
				]
			);

			$this->add_responsive_control(
				'mobile_dropdown_offset_x_end_' . $breakpoint_key,
				[
					'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'vw', 'custom' ],
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
						'{{WRAPPER}} .lqd-menu-wrap' => 'inset-inline-end: {{SIZE}}{{UNIT}};inset-inline-start:auto!important;',
					],
					'condition' => [
						'mobile_dropdown' => 'yes',
						'mobile_dropdown_breakpoint_' . $breakpoint_key . '!' => '',
						'mobile_dropdown_orientation_h_' . $breakpoint_key => 'end'
					]
				]
			);

			$this->add_control(
				'mobile_dropdown_orientation_v_' . $breakpoint_key,
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
						'mobile_dropdown' => 'yes',
						'mobile_dropdown_breakpoint_' . $breakpoint_key . '!' => ''
					]
				]
			);

			$this->add_responsive_control(
				'mobile_dropdown_offset_y_' . $breakpoint_key,
				[
					'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'vh', 'custom' ],
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
						'{{WRAPPER}} .lqd-menu-wrap' => 'top: {{SIZE}}{{UNIT}};bottom:auto !important;',
					],
					'condition' => [
						'mobile_dropdown' => 'yes',
						'mobile_dropdown_breakpoint_' . $breakpoint_key . '!' => '',
						'mobile_dropdown_orientation_v_' . $breakpoint_key => 'top',
					]
				]
			);

			$this->add_responsive_control(
				'mobile_dropdown_offset_y_bottom' . $breakpoint_key,
				[
					'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'vh', 'custom' ],
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
						'{{WRAPPER}} .lqd-menu-wrap' => 'bottom: {{SIZE}}{{UNIT}};top:auto !important;',
					],
					'condition' => [
						'mobile_dropdown' => 'yes',
						'mobile_dropdown_breakpoint_' . $breakpoint_key . '!' => '',
						'mobile_dropdown_orientation_v_' . $breakpoint_key => 'bottom',
					]
				]
			);

		}

		$this->add_responsive_control(
			'mobile_dropdown_padding' . $breakpoint_key,
			[
				'label' => esc_html__( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-ul-top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'mobile_dropdown_background' . $breakpoint_key,
				'types' => [ 'color', 'particles', 'animated-gradient' ],
				'selector' => '(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-ul-top',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mobile_dropdown_border' . $breakpoint_key,
				'selector' => '{{WRAPPER}} .lqd-menu-ul-top',
				'fields_options' => [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ],
					],
				]
			]
		);

		$this->add_responsive_control(
			'mobile_dropdown_border_radius' . $breakpoint_key,
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-menu-ul-top' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mobile_dropdown_box_shadow' . $breakpoint_key,
				'selector' => '(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-ul-top',
			]
		);

		$this->start_controls_tabs(
			'mobile_dropdown_styles_tabs_' . $breakpoint_key,
		);

		$this->start_controls_tab(
			'mobile_dropdown_styles_tab_' . $breakpoint_key . '_normal',
			[
				'label'   => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_control(
			'mobile_dropdown_color' . $breakpoint_key,
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-ul-top' => '--lqd-menu-link-color: {{VALUE}}'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_dropdown_styles_tab_' . $breakpoint_key . '_hover',
			[
				'label'   => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_control(
			'mobile_dropdown_color' . $breakpoint_key . '_hover',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-li-top .lqd-menu-link-top:hover' => '--lqd-menu-link-color: {{VALUE}}'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_dropdown_styles_tab_' . $breakpoint_key . '_active',
			[
				'label'   => esc_html__( 'Active', 'aihub-core' ),
			]
		);

		$this->add_control(
			'mobile_dropdown_color' . $breakpoint_key . '_active',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'(' . $breakpoint_key . '){{WRAPPER}} .lqd-menu-li-top .lqd-menu-link-top.lqd-is-active, {{WRAPPER}} .lqd-menu-li-top.current-menu-item .lqd-menu-link-top' => '--lqd-menu-link-color: {{VALUE}}'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'individual_items_styles_section',
			[
				'label' => esc_html__( 'Individual items', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$individual_selectors = [
			'first' => __( 'First item', 'aihub-core' ),
			'last' => __( 'Last item', 'aihub-core' ),
			'odd' => __( 'Odd items', 'aihub-core' ),
			'even' => __( 'Even items', 'aihub-core' ),
		];

		$individual_item_styles = new Repeater();

		$individual_item_styles->add_control(
			'individual_selector', [
				'label' => __( 'Selector', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => $individual_selectors,
				'default' => 'first',
				'label_block' => true,
			]
		);

		foreach ($individual_selectors as $individual_selector => $label) {

			$this->add_nav_items_controls( $individual_item_styles, $individual_selector );

		}

		$this->add_control(
			'individual_item_styles',
			[
				'label' => __( 'Individual items styling', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $individual_item_styles->get_controls(),
				'title_field' => '{{{ individual_selector.replace( individual_selector.charAt(0), individual_selector.charAt(0).toUpperCase() ) }}}',
				'prevent_empty' => false,
			]
		);

		$this->end_controls_section();

		// @see : https://developers.elementor.com/docs/editor-controls/conditional-display/#more-operators
		$conditions = [
			'relation' => 'or',
			'terms' => [
				[
					'name' => 'layout',
					'operator' => '===',
					'value' => 'dropdown',
				],
				[
					'name' => 'mobile_dropdown',
					'operator' => '===',
					'value' => 'yes',
				],
			],
		];
		\LQD_Elementor_Trigger::register_controls( $this, '', $conditions );

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('_wrapper', [
			'class' => [ 'lqd-widget-container-flex', 'lqd-widget-container-items-center' ],
			'data-lqd-menu-dropdown-position-applied' => 'false'
		]);
	}

	public function before_render() {
		?>
		<nav <?php $this->print_render_attribute_string('_wrapper'); ?>>
		<?php
	}

	public function after_render() {
		?>
		</nav>
		<?php
	}

	protected function mobile_dropdown_is_active() {
		$settings = $this->get_settings_for_display();
		$mobile_dropdown_is_active = false;

		if ( $settings['layout'] !== 'dropdown' && $settings['mobile_dropdown'] === 'yes' ) {

			$active_breakpoints = \Elementor\Plugin::instance()->breakpoints->get_active_breakpoints();
			foreach ( $active_breakpoints as $breakpoint_key => $breakpoint_instance ) {

				$setting = $settings[ 'mobile_dropdown_breakpoint_' . $breakpoint_key ];
				if ( $setting && !empty( $setting ) ) {
					$mobile_dropdown_is_active = true;
					break;
				}

			}

		}

		return $mobile_dropdown_is_active;
	}

	protected function get_item_icon( $item ) {

		if ( !isset( $item['icon'] ) || ( isset( $item['icon']['value'] ) && empty( $item['icon']['value'] ) ) ) return;

		$icon_alignment = $item['icon_alignment'];

		$attrs_id = 'item-' . $item['_id'] . '-icon-attrs';
		$icon_classnames = [ 'lqd-menu-icon', 'lqd-menu-icon-' . $icon_alignment , 'inline-flex', 'shrink-0', 'transition-all' ];

		if ( $icon_alignment === 'start' ) {
			$icon_classnames[] = '-order-1';
		} else {
		}

		$this->add_render_attribute( $attrs_id, [
			'class' => $icon_classnames,
		] );

		?>

		<span <?php $this->print_render_attribute_string( $attrs_id ); ?>><?php
			\LQD_Elementor_Helper::render_icon( $item['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		?></span>

		<?php

	}

	protected function get_item_markup( $item ) {

		$item_label = $item['label'];

		if ( ! empty( $item['link']['url'] ) ) {
			$this->add_link_attributes( 'link_' . $item['_id'], $item['link'] );
		?>
			<a class="lqd-menu-link lqd-menu-link-top flex items-center transition-all" <?php $this->print_render_attribute_string( 'link_' . $item['_id'] ); ?>><?php
				echo $item_label; $this->get_item_icon( $item );
			?></a>
		<?php } else {
			echo $item_label; $this->get_item_icon( $item );
		}

	}

	protected function get_wrap_classnames( $settings ) {
		// added grow classname in case if the widget size is set to grow and make the alignment option work
		$classname = [ 'lqd-menu-wrap', '[&.lqd-is-active:flex]', 'grow' ];

		if ( $settings['layout'] === 'dropdown' ) {
			array_push(
				$classname,
				'hidden',
				'absolute',
				'top-full',
				'start-0',
				'z-10'
			);
		}

		return $classname;
	}

	protected function get_ul_classnames($settings) {
		$ul_classnames = ['lqd-menu-ul', 'lqd-menu-ul-top', 'flex', 'items-center', 'grow', 'list-none', 'transition-colors'];

		return $ul_classnames;
	}

	protected function render_wp_menu($settings) {
		$menu_slug = $settings['menu_slug'];
		$ul_classnames = $this->get_ul_classnames($settings);

		if ( empty($menu_slug) ) return;

		echo wp_nav_menu([
			'echo' => false,
			'menu' => $menu_slug,
			'menu_class' => implode(' ', $ul_classnames),
			'fallback_cb' => '__return_empty_string',
			'container' => '',
			'link_before' => '<svg class="max-w-1em max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use xlink:href="#lqd-icon-chevron-down" /></svg>',
			'add_a_class' => 'flex items-center',
			'walker' => class_exists('Liquid_Menu_Walker') ? new \Liquid_Menu_Walker() : '',
		]);

	}

	protected function render_custom_menu($settings) {

		$ul_classnames = $this->get_ul_classnames($settings);
		$menu_items = $settings['custom_menu'];

		if ( empty( $menu_items ) ) return;

		?><ul class="<?php echo esc_attr(implode(' ', $ul_classnames)); ?> "><?php
		foreach( $menu_items as $item ) {
			$attrs_id = 'item-' . $item['_id'] . '-attrs';
			$item_classnames = [
				'menu-item',
				'lqd-menu-li',
				'relative',
				'lqd-menu-li-top',
				'elementor-repeater-item-' . $item['_id']
			];

			$this->add_render_attribute( $attrs_id, [
				'id' => 'menu-item-' . esc_attr( $item['_id'] ),
				'class' => $item_classnames,
			] );
			?>

			<li <?php $this->print_render_attribute_string( $attrs_id ) ?>>
				<?php $this->get_item_markup( $item ); ?>
			</li>

			<?php

		}
		?></ul><?php

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$trigger_classnames = [];
		$wrap_classnames = $this->get_wrap_classnames( $settings );

		if ( $this->mobile_dropdown_is_active() ) {
			$trigger_classnames[] = 'hidden';
		}

		$this->add_render_attribute('menu-wrap', [
			'class' => $wrap_classnames
		]);

		\LQD_Elementor_Trigger::render( $this, '', [ 'class' => $trigger_classnames ] );
		?><div <?php $this->print_render_attribute_string( 'menu-wrap' ) ?>><?php
		if ( $settings['source'] === 'custom' ) {
			$this->render_custom_menu($settings);
		} else {
			$this->render_wp_menu($settings);
		}
		?></div><?php
	}
}
\Elementor\Plugin::instance()->widgets_manager->register(new LQD_Menu());