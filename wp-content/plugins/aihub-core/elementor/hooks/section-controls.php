<?php

use Elementor\Element_Base;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

defined('ABSPATH') || die();

class Hub_Elementor_Custom_Controls {

	public static $lqd_el_container_bg = array();

	public static function init() {

		add_action( 'elementor/element/column/section_advanced/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
        add_action( 'elementor/element/container/section_layout/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'before_section_render' ], 1 );

        // Additional Shape Colors
        add_action( 'elementor/element/section/section_shape_divider/before_section_end', [ __CLASS__, 'additional_shape_colors' ], 1 );
        add_action( 'elementor/element/container/section_shape_divider/before_section_end', [ __CLASS__, 'additional_shape_colors' ], 1 );

        // Liquid sticky layout
		add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

			if ( $element->get_name() === 'container' && 'section_layout_additional_options' === $section_id ) {

				$elementor_doc_selector = '.elementor';

				$element->start_controls_section(
					'lqd_sticky_container_layout_section',
					[
						'label' => __( 'Sticky <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">📌<span>', 'aihub-core' ),
						'tab' => Controls_Manager::TAB_LAYOUT,
					]
				);

				$element->add_control(
					'lqd_sticky_hide',
					[
						'label' => __( 'Hide on sticky elements or sticky header', 'aihub-core' ),
						'type' => Controls_Manager::SWITCHER,
						'condition' => [
							'lqd_sticky_show' => ''
						]
					]
				);

				$element->add_control(
					'lqd_sticky_show',
					[
						'label' => __( 'Show on sticky elements or sticky header', 'aihub-core' ),
						'type' => Controls_Manager::SWITCHER,
						'condition' => [
							'lqd_sticky_hide' => ''
						]
					]
				);

				$element->end_controls_section();
			}

		}, 10, 2 );

        // Liquid dark layout
		add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

			if ( $element->get_name() === 'container' && 'section_layout_additional_options' === $section_id ) {

				$elementor_doc_selector = '.elementor';

				$element->start_controls_section(
					'lqd_dark_container_layout_section',
					[
						'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
						'tab' => Controls_Manager::TAB_LAYOUT,
					]
				);

				if ( get_post_type( get_the_ID()) !== 'liquid-header' ) {

					$element->add_control(
						'lqd_section_color_scheme',
						[
							'label' => __( 'Dark scheme? 🌘', 'aihub-core' ),
							'description' => __( 'Make this container dark. So colors defined in site settings will be applied to all inner widgets. This option also make adaptive color widgets to react when they are over this container.', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'return_value' => 'dark',
							'render_type' => 'ui',
							'separator' => 'after'
						]
					);

				}

				$element->add_control(
					'lqd_dark_hide',
					[
						'label' => esc_html__( 'Hide on dark?', 'aihub-core' ),
						'type' => Controls_Manager::SWITCHER,
						'selectors' => [
							'{{WRAPPER}}' => 'display: var(--display)',
							'[data-lqd-page-color-scheme=dark] {{WRAPPER}}, {{WRAPPER}} [data-lqd-color-scheme=dark], ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}' => '--display: none'
						]
					]
				);

				$element->add_control(
					'lqd_dark_show',
					[
						'label' => esc_html__( 'Show only on dark?', 'aihub-core' ),
						'type' => Controls_Manager::SWITCHER,
						'selectors' => [
							'{{WRAPPER}}' => 'display: none',
							'[data-lqd-page-color-scheme=dark] {{WRAPPER}}, {{WRAPPER}} [data-lqd-color-scheme=dark], ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}' => 'display: var(--display, block)'
						]
					]
				);

				$element->end_controls_section();
			}

		}, 10, 2 );

        // Liquid Animations - for editor
		add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

			if (
				$section_id === 'section_layout'  ||
				$section_id === 'section_advanced' ||
				$section_id === '_section_style'
			) {

				$element->start_controls_section(
					'lqd_animations_section',
					[
						'label' => __( 'Animations & Additional options', 'aihub-core' ),
						'tab' => Controls_Manager::TAB_ADVANCED,
					]
				);

				lqd_elementor_add_parallax_controls( $element ); // call parallax options
				lqd_elementor_add_animation_controls( $element ); // call content animation options
				lqd_elementor_add_additional_animation_controls( $element ); // call additional animation options

				$element->end_controls_section();

				if ( $element->get_name() !== 'container' ) {

					$elementor_doc_selector = '.elementor';

					$dark_wrapper_selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} > .elementor-widget-container';
					$dark_wrapper_selector_hover = '[data-lqd-page-color-scheme=dark] {{WRAPPER}}:hover > .elementor-widget-container';
					$dark_uniq_selector = $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} > .elementor-widget-container, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} > .elementor-widget-container';
					$dark_uniq_selector_hover = $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}}:hover > .elementor-widget-container, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}:hover > .elementor-widget-container';

					// Start sticky section
					$element->start_controls_section(
						'lqd_sticky_colors__section',
						[
							'label' => __( 'Sticky <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">📌<span>', 'aihub-core' ),
							'tab' => Controls_Manager::TAB_ADVANCED,
						]
					);

					$element->add_control(
						'lqd_sticky_hide',
						[
							'label' => __( 'Hide on sticky elements or sticky header', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'condition' => [
								'lqd_sticky_show' => ''
							]
						]
					);

					$element->add_control(
						'lqd_sticky_show',
						[
							'label' => __( 'Show on sticky elements or sticky header', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'condition' => [
								'lqd_sticky_hide' => ''
							],
							'separator' => 'after'
						]
					);

					$element->add_responsive_control(
						'lqd_sticky__margin',
						[
							'label' => __( 'Margin', 'aihub-core' ),
							'type' => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
							'selectors' => [
								$elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} > .elementor-widget-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							]
						]
					);

					$element->add_responsive_control(
						'lqd_sticky__padding',
						[
							'label' => __( 'Padding', 'aihub-core' ),
							'type' => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
							'selectors' => [
								$elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} > .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							]
						]
					);

					$element->start_controls_tabs(
						'lqd_sticky_colors__style_tabs'
					);

					// Normal Tab
					$element->start_controls_tab(
						'lqd_sticky_colors_section__style_normal_tab',
						[
							'label' => esc_html__( 'Normal', 'aihub-core' ),
						]
					);

					$element->add_group_control(
						'liquid-background-css',
						[
							'name' => 'lqd_sticky__background',
							'types' => [ 'classic', 'gradient' ],
							'selector' => $elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} > .elementor-widget-container',
						]
					);

					$element->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name' => 'lqd_sticky__border',
							'selector' => $elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} > .elementor-widget-container',
						]
					);

					$element->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'lqd_sticky__box_shadow',
							'selector' => $elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}} > .elementor-widget-container',
						]
					);

					$element->end_controls_tab();

					// Hover Tab
					$element->start_controls_tab(
						'lqd_sticky_colors_section__style_hover_tab',
						[
							'label' => esc_html__( 'Hover', 'aihub-core' ),
						]
					);

					$element->add_group_control(
						'liquid-background-css',
						[
							'name' => 'lqd_sticky__background_hover',
							'selector' => $elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}:hover > .elementor-widget-container',
						]
					);

					$element->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name' => 'lqd_sticky__border_hover',
							'selector' => $elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}:hover > .elementor-widget-container',
						]
					);

					$element->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'lqd_sticky__box_shadow_hover',
							'selector' => $elementor_doc_selector . ' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}:hover > .elementor-widget-container',
						]
					);

					$element->end_controls_tab();

					$element->end_controls_tabs();

					$element->end_controls_section();
					// End sticky section

					$element->start_controls_section(
						'lqd_dark_colors__section',
						[
							'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
							'tab' => Controls_Manager::TAB_ADVANCED,
						]
					);

					$element->add_control(
						'lqd_dark_hide',
						[
							'label' => esc_html__( 'Hide on dark?', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'selectors' => [
								'[data-lqd-page-color-scheme=dark] {{WRAPPER}}, {{WRAPPER}} [data-lqd-color-scheme=dark], {{WRAPPER}}[data-lqd-color-scheme=dark], ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}, ' . $elementor_doc_selector . ' .elementor-element.elementor-element-{{ID}}[data-lqd-color-scheme=dark]' => 'display: none'
							]
						]
					);

					$element->add_control(
						'lqd_dark_show',
						[
							'label' => esc_html__( 'Show only on dark?', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'selectors' => [
								'{{WRAPPER}}' => 'display: none',
								'[data-lqd-page-color-scheme=dark] {{WRAPPER}}, {{WRAPPER}} [data-lqd-color-scheme=dark], {{WRAPPER}}[data-lqd-color-scheme=dark], ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}}, ' . $elementor_doc_selector . ' .elementor-element.elementor-element-{{ID}}[data-lqd-color-scheme=dark]' => 'display: block'
							],
							'separator' => 'after'
						]
					);

					$element->start_controls_tabs(
						'lqd_dark_colors__style_tabs'
					);

					// Normal Tab
					$element->start_controls_tab(
						'lqd_dark_colors_section__style_normal_tab',
						[
							'label' => esc_html__( 'Normal', 'aihub-core' ),
						]
					);

					$element->add_group_control(
						'liquid-background-css',
						[
							'name' => 'lqd_dark__background',
							'types' => [ 'classic', 'gradient' ],
							'selector' => $dark_wrapper_selector . ', ' . $dark_uniq_selector,
						]
					);

					$element->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name' => 'lqd_dark__border',
							'selector' => $dark_wrapper_selector . ', ' . $dark_uniq_selector,
						]
					);

					$element->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'lqd_dark__box_shadow',
							'selector' => $dark_wrapper_selector . ', ' . $dark_uniq_selector,
						]
					);

					$element->end_controls_tab();

					// Hover Tab
					$element->start_controls_tab(
						'lqd_dark_colors_section__style_hover_tab',
						[
							'label' => esc_html__( 'Hover', 'aihub-core' ),
						]
					);

					$element->add_group_control(
						'liquid-background-css',
						[
							'name' => 'lqd_dark__background_hover',
							'selector' => $dark_wrapper_selector_hover .', ' . $dark_uniq_selector_hover,
						]
					);

					$element->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name' => 'lqd_dark__border_hover',
							'selector' => $dark_wrapper_selector_hover . ', ' . $dark_uniq_selector_hover,
						]
					);

					$element->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'lqd_dark__box_shadow_hover',
							'selector' => $dark_wrapper_selector_hover .', ' . $dark_uniq_selector_hover
						]
					);

					$element->end_controls_tab();

					$element->end_controls_tabs();

					$element->end_controls_section();

				}

            }

		}, 10, 2 );

		// Liquid container sticky styles options
		add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

			if ( $element->get_name() === 'container' && 'section_shape_divider' === $section_id ) {

				$elementor_id = '.elementor';

				$element->start_controls_section(
					'lqd_sticky_styles_section',
					[
						'label' => __( 'Sticky <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">📌<span>', 'aihub-core' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);

				$element->start_controls_tabs(
					'lqd_sticky_container_styles_tabs',
				 );

				 // Start tab normal
				$element->start_controls_tab(
					'lqd_sticky_container_style_normal',
					[
						'label' => esc_html__( 'Normal', 'aihub-core' ),
					]
				);

				$element->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'lqd_sticky_container_bg',
						'label' => __( 'Background', 'aihub-core' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}}[data-lqd-container-is-sticky=true], '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}',
					]
				);

				$element->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'lqd_sticky_container_border',
						'selector' => '{{WRAPPER}}[data-lqd-container-is-sticky=true], '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}',
					]
				);

				$element->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'lqd_sticky_container_box_shadow',
						'label' => __( 'Box shadow', 'aihub-core' ),
						'selector' => '{{WRAPPER}}[data-lqd-container-is-sticky=true], '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}',
					]
				);

				$element->end_controls_tab();
				// End tab normal


				// Start tab hover
				$element->start_controls_tab(
					'lqd_sticky_container_style_hover',
					[
						'label' => esc_html__( 'Hover', 'aihub-core' ),
					]
				);

				$element->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'lqd_sticky_container_bg_hover',
						'label' => __( 'Background', 'aihub-core' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}}[data-lqd-container-is-sticky=true]:hover, '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}:hover',
					]
				);

				$element->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'lqd_sticky_container_border_hover',
						'selector' => '{{WRAPPER}}[data-lqd-container-is-sticky=true]:hover, '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}:hover',
					]
				);

				$element->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'lqd_sticky_container_box_shadow_hover',
						'label' => __( 'Box shadow', 'aihub-core' ),
						'selector' => '{{WRAPPER}}[data-lqd-container-is-sticky=true]:hover, '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}:hover',
					]
				);

				$element->end_controls_tab();
				// End tab hover

				$element->end_controls_tabs();

				$element->end_controls_section();

            }

		}, 10, 2 );

		// Liquid container dark styles options
		add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

			if ( $element->get_name() === 'container' && 'section_shape_divider' === $section_id ) {

				$element->start_controls_section(
					'lqd_dark_container_styles_section',
					[
						'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);

				$dark_wrapper_selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}}, {{WRAPPER}}[data-lqd-color-scheme=dark]';
				$dark_wrapper_selector_hover = '[data-lqd-page-color-scheme=dark] {{WRAPPER}}:hover, {{WRAPPER}}[data-lqd-color-scheme=dark]';

				$element->start_controls_tabs(
					'lqd_dark_container_styles_tabs',
				 );

				// Start tab normal
				$element->start_controls_tab(
					'lqd_dark_container_style_normal',
					[
						'label' => esc_html__( 'Normal', 'aihub-core' ),
					]
				);

				$element->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'lqd_dark_container_bg',
						'label' => __( 'Background', 'aihub-core' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => $dark_wrapper_selector,
					]
				);

				$element->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'lqd_dark_container_border',
						'selector' => $dark_wrapper_selector,
					]
				);

				$element->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'lqd_dark_container_box_shadow',
						'label' => __( 'Box shadow', 'aihub-core' ),
						'selector' => $dark_wrapper_selector,
					]
				);

				$element->end_controls_tab();
				// End tab normal

				// Start tab hover
				$element->start_controls_tab(
					'lqd_dark_container_style_hover',
					[
						'label' => esc_html__( 'Hover', 'aihub-core' ),
					]
				);

				$element->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'lqd_dark_container_bg_hover',
						'label' => __( 'Background', 'aihub-core' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => $dark_wrapper_selector_hover,
					]
				);

				$element->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'lqd_dark_container_border_hover',
						'selector' => $dark_wrapper_selector_hover,
					]
				);

				$element->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'lqd_dark_container_box_shadow_hover',
						'label' => __( 'Box shadow', 'aihub-core' ),
						'selector' => $dark_wrapper_selector_hover,
					]
				);

				$element->end_controls_tab();
				// End tab hover

				$element->end_controls_tabs();

				$element->end_controls_section();

            }

		}, 10, 3 );

		// Liquid container sticky advanced options
		add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

			if (
				$element->get_name() === 'container' &&
				(
					$section_id === 'section_layout'  ||
					$section_id === 'section_advanced' ||
					$section_id === '_section_style'
				)
			) {

				$elementor_id = '.elementor';

				$element->start_controls_section(
					'lqd_sticky_container_advanced_styles_section',
					[
						'label' => __( 'Sticky <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">📌<span>', 'aihub-core' ),
						'tab' => Controls_Manager::TAB_ADVANCED,
					]
				);

				$element->add_responsive_control(
					'lqd_sticky_section_margin',
					[
						'label' => __( 'Margin', 'aihub-core' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
						'selectors' => [
							'{{WRAPPER}}[data-lqd-container-is-sticky=true], '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						]
					]
				);

				$element->add_responsive_control(
					'lqd_sticky_section_padding',
					[
						'label' => __( 'Padding', 'aihub-core' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
						'selectors' => [
							'{{WRAPPER}}[data-lqd-container-is-sticky=true], '. $elementor_id .' [data-lqd-container-is-sticky=true] .elementor-element.elementor-element-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						]
					]
				);

				$element->end_controls_section();

            }

		}, 10, 2 );

		// Typewriter options
		add_action( 'elementor/element/lqd-typewriter/els_style_section/before_section_end', function( $element, $section_id ) {

			// Start mask text
			$element->add_control(
				'tw_mask',
				[
					'label' => __( 'Mask & gradient', 'aihub-core' ),
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'separator' => 'before'
				]
			);

			$element->start_popover();

			$element->add_control(
				'tw_mask_type',
				[
					'label' => esc_html__( 'Mask type', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'color' => [
							'title' => esc_html__( 'Color', 'aihub-core' ),
							'icon' => 'eicon-paint-brush',
						],
						'image' => [
							'title' => esc_html__( 'Image', 'aihub-core' ),
							'icon' => 'eicon-image-bold',
						],
					],
					'default' => 'color',
					'condition' => [
						'tw_mask' => 'yes',
					]
				]
			);

			$element->add_control(
				'tw_mask_color',
				[
					'label' => __( 'Color', 'aihub-core' ),
					'type' => 'liquid-color',
					'selectors' => [
						'{{WRAPPER}} .lqd-tw-writer' => 'background: {{VALUE}}; -webkit-background-clip: text !important; background-clip: text !important; -webkit-text-fill-color: transparent !important; text-fill-color: transparent !important;'
					],
					'condition' => [
						'tw_mask' => 'yes',
						'tw_mask_type' => 'color'
					]
				]
			);

			$element->add_control(
				'tw_mask_gradient_parallax',
				[
					'label' => esc_html__( 'Parallax gradient?', 'aihub-core' ),
					'type' => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'This option only works in desktop and gradient mask.', 'aihub-core' ),
					'selectors' => [
						'(desktop+){{WRAPPER}} .lqd-tw-writer' => 'background-attachment: fixed'
					],
					'condition' => [
						'tw_mask' => 'yes',
						'tw_mask_type' => 'color'
					]
				]
			);

			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'tw_mask_image',
					'types' => [ 'classic' ],
					'selector' => '{{WRAPPER}} .lqd-tw-writer',
					'fields_options' => [
						'background' => [
							'type' => Controls_Manager::HIDDEN,
							'default' => 'classic',
							'selectors' => [
								'{{SELECTOR}}' => '-webkit-background-clip: text !important; background-clip: text !important; -webkit-text-fill-color: transparent !important; text-fill-color: transparent !important;'
							]
						],
						'color' => [
							'type' => Controls_Manager::HIDDEN,
						],
					],
					'condition' => [
						'tw_mask' => 'yes',
						'tw_mask_type' => 'image'
					]
				]
			);

			$element->end_popover(); // Mask text

		}, 10, 2 );

		// Divider dark options
		add_action( 'elementor/element/divider/section_divider_style/after_section_end', function( $element, $section_id ) {

			$elementor_doc_selector = '.elementor';

			$element->start_controls_section(
				'lqd_dark_styles_section',
				[
					'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$element->add_control(
				'dark_divider_color',
				[
					'label' => __( 'Color', 'aihub-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'[data-lqd-page-color-scheme=dark] {{WRAPPER}}, {{WRAPPER}} [data-lqd-color-scheme=dark], {{WRAPPER}}[data-lqd-color-scheme=dark]' => '--divider-color: {{VALUE}}'
					],
				]
			);

			$element->end_controls_section();

		}, 10, 2 );


        // Custom CSS
        add_action( 'elementor/element/parse_css', function( $post_css, $element ){

            if ( $post_css instanceof Dynamic_CSS ) {
                return;
            }

            $element_settings = $element->get_settings();

            if ( empty( $element_settings['lqd_custom_css'] ) ) {
                return;
            }

            $css = trim( $element_settings['lqd_custom_css'] );

            if ( empty( $css ) ) {
                return;
            }

            $css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

            $post_css->get_stylesheet()->add_raw_css( $css );

        }, 10, 2 );

		// Liquid Container Background
		add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

			if (
				'container' === $element->get_name() &&
				(
					$section_id === 'section_layout'  ||
					$section_id === 'section_advanced' ||
					$section_id === '_section_style'
				)
			) {

				$element->start_controls_section(
					'lqd_el_container_bg',
					[
						'label' => __( 'Liquid Background', 'aihub-core' ),
						'tab' => Controls_Manager::TAB_ADVANCED,
					]
				);

				$element->add_group_control(
					'liquid-background',
					[
						'name' => 'lqd_el_container_bg',
						'label' => esc_html__( 'Custom Control', 'aihub-core' ),
						'types' => [ 'color', 'image', 'video', 'slideshow', 'particles', 'animated-gradient' ],
					]
				);

				$element->end_controls_section();

			}
		}, 10, 2 );

        add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

            if (
				$section_id === 'section_layout'  ||
				$section_id === 'section_advanced' ||
				$section_id === '_section_style'
			) {

                $element->start_controls_section(
                    'lqd_custom_css_section',
                    [
                        'label' => __( 'Liquid Custom CSS', 'aihub-core' ),
                        'tab' => Controls_Manager::TAB_ADVANCED,
                    ]
                );

                $element->add_control(
                    'lqd_custom_css',
                    [
                        'type' => Controls_Manager::CODE,
                        'language' => 'css',
                        'render_type' => 'ui',
                    ]
                );

                $element->add_control(
                    'lqd_custom_css_desc',
                    [
                        'raw' => sprintf(
                            esc_html__( 'Use "selector" to target wrapper element.%1$sselector {your css code}', 'aihub-core' ),
                            '<br><br>'
                        ),
                        'type' => Controls_Manager::RAW_HTML,
                        'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    ]
                );

                $element->end_controls_section();
            }
        }, 10, 2 );

		// Liquid Container Background Template
		add_filter( 'elementor/container/print_template', function( $template, $element ) {

			if ( $element->get_name() !== 'section' && $element->get_name() !== 'container' ) {
				return $template;
			}

			$old_template = $template;
			ob_start();

			if ( 'container' === $element->get_name() ) {
				$background = new \LQD_Elementor_Render_Background;

				?> <# <?php $background->render_template(); ?>#>

				{{{get_liquid_background('lqd_el_container_bg')}}} <?php
			}

			$new_template = ob_get_contents();

			ob_end_clean();

			$template = $new_template . $old_template;
			return $template;

		}, 10, 2 );

		/**
		 * Liquid elementor container bg
		 * 1. Catch element data
		 * 2. Append element data
		 */

		// #1 - Liquid Container Background Catch Element IDs and BG HTML
		add_action( 'elementor/frontend/container/before_render', function ( $element ) {

			if ( $element->get_settings( 'lqd_el_container_bg_liquid_background_items' ) ) :

				$cache = get_option( 'lqd_el_container_bg', array() );

				if ( ! wp_script_is( 'tsparticles' ) ) {
					wp_enqueue_script( 'tsparticles' );
				}

				ob_start();

				$background = new \LQD_Elementor_Render_Background;
				$background->render( $element, $element->get_settings(), 'lqd_el_container_bg' );

				$html = ob_get_contents();
				ob_end_clean();

				$cache[$element->get_id()] = $html;
				update_option( 'lqd_el_container_bg', $cache );
				self::$lqd_el_container_bg[$element->get_id()] = $html;

			endif;

		} );

		// #2 - Liquid Container Background Append BG HTML
		add_action( 'the_content', function ( $content ) {

			$ids = self::$lqd_el_container_bg;

			if ( ! $ids ) {
				return $content; // Return if there is no bg
			}

			return liquid_helper()->lqd_el_container_bg( $content, $ids );

		} );

	}

    public static function additional_shape_colors( $control_stack ) {

        // Bottom
        $control_stack->start_injection([
            'at' => 'before',
            'of' => 'shape_divider_bottom_width'
        ]);

        $control_stack->add_control(
            'lqd_custom_shape_bottom_color2',
            [
                'label' => __( 'Color 2', 'aihub-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-bottom .elementor-shape-fill:nth-child(2)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_bottom!' => '',
                ],
            ]
        );

        $control_stack->add_control(
            'lqd_custom_shape_bottom_color3',
            [
                'label' => __( 'Color 3', 'aihub-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-bottom .elementor-shape-fill:nth-child(3)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_bottom!' => '',
                ],
            ]
        );

        $control_stack->add_control(
            'lqd_custom_shape_bottom_color4',
            [
                'label' => __( 'Color 4', 'aihub-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-bottom .elementor-shape-fill:nth-child(4)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_bottom!' => '',
                ],
            ]
        );

        $control_stack->end_injection();

        // Top
        $control_stack->start_injection([
            'at' => 'before',
            'of' => 'shape_divider_top_width'
        ]);

        $control_stack->add_control(
            'lqd_custom_shape_top_color2',
            [
                'label' => __( 'Color 2', 'aihub-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-top .elementor-shape-fill:nth-child(2)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_top!' => '',
                ],
            ]
        );

        $control_stack->add_control(
            'lqd_custom_shape_top_color3',
            [
                'label' => __( 'Color 3', 'aihub-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-top .elementor-shape-fill:nth-child(3)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_top!' => '',
                ],
            ]
        );

        $control_stack->add_control(
            'lqd_custom_shape_top_color4',
            [
                'label' => __( 'Color 4', 'aihub-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-top .elementor-shape-fill:nth-child(4)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_top!' => '',
                ],
            ]
        );

        $control_stack->end_injection();

        // Bottom shape animation
        $control_stack->start_injection([
            'at' => 'after',
            'of' => 'shape_divider_bottom_above_content'
        ]);

        $control_stack->end_injection();

        // Top shape animation
        $control_stack->start_injection([
            'at' => 'after',
            'of' => 'shape_divider_top_above_content'
        ]);

        $control_stack->end_injection();

    }

	public static function add_controls_section( Element_Base $element) {

        if ( 'container' === $element->get_name() ) {

            $element->start_controls_section(
                'lqd_effects_container',
                [
                    'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
                    'tab' => Controls_Manager::TAB_LAYOUT,
                ]
            );

			$element->add_control(
				'lqd_adaptive_color',
				[
					'label' => esc_html__( 'Enable adaptive color?', 'aihub-core' ),
					'description' => esc_html__( 'Useful for elements with fixed css position or when inside sticky header. This option make the element chage color dynamically when it is over light or dark sections.', 'aihub-core' ),
					'type' => Controls_Manager::SWITCHER
				]
			);

			$element->end_controls_section();
        }

	}

	public static function before_section_render( Element_Base $element ) {

		if ( $element->get_settings( 'lqd_section_color_scheme' ) && $element->get_settings( 'lqd_section_color_scheme' ) !== '' ) {
			$element->add_render_attribute( '_wrapper', [
                'data-lqd-color-scheme' => $element->get_settings( 'lqd_section_color_scheme' ),
            ] );
        }
		if ( $element->get_settings( 'lqd_sticky_show' ) && $element->get_settings( 'lqd_sticky_show' ) === 'yes' ) {
			$element->add_render_attribute( '_wrapper', [
				'data-lqd-show-on-sticky' => 'true',
			] );
			if ( $element->get_name() !== 'container' ) {
				$element->add_render_attribute( '_wrapper', 'class', 'hidden lqd-sticky:block');
			}
        }
		if ( $element->get_settings( 'lqd_sticky_hide' ) && $element->get_settings( 'lqd_sticky_hide' ) === 'yes' ) {
			$element->add_render_attribute( '_wrapper', [
                'data-lqd-hide-on-sticky' => 'true',
            ] );
			if ( $element->get_name() !== 'container' ) {
				$element->add_render_attribute( '_wrapper', 'class', 'lqd-sticky:hidden');
			}
        }

	}
}

Hub_Elementor_Custom_Controls::init();
