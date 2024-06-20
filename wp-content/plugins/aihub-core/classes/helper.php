<?php
/**
 * The Helper
 * Contains all the helping functions
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Elementor_Helper {

	private static $_instance = null;

	private static $current_widget = null;
	private static $current_selector_prefix = 'widget';
	private static $current_section_options = [];

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }

	/**
	 * @param any $widget the context instance. $this, $repeater etc.
	 * @param array $sections
	 */
	static function add_style_controls( $widget, $selector_prefix = 'widget', $sections = [], $is_in_repeater = false ) {

		if ( empty( $sections ) ) return;

		self::$current_widget = $widget;
		self::$current_selector_prefix = $selector_prefix;

		$widget_dark_controls = [];
		$widget_sticky_controls = [];

		/*
			$opts looking something like this
			[
				'controls' => [
					[
						'type' => 'margin',
						'selector' => '.lqd-accordion-item,
						'css_var' => '--lqd-acc-i-m'
					],
					[
						'type' => 'border',
						'css_var' => '--lqd-acc-i-br'
					],
					etc...
				],
				'state_tabs' => [ 'normal', 'hover', 'active', 'css_active', 'focus', 'focus-within', 'current_menu_item' ],
				etc...
			]
		*/
		foreach ( $sections as $section_id => $opts ) {

			self::$current_section_options = $opts;

			$control_section_label = isset( $opts['label'] ) ? $opts['label'] : self::get_titlecase( $section_id );
			$section_label = $control_section_label . ( isset( $opts['plural_heading'] ) && !$opts['plural_heading'] ? '' : 's' );
			$controls = $opts['controls'];
			$state_tabs = isset( $opts['state_tabs'] ) ? $opts['state_tabs'] : '';
			$have_state_tabs = !empty( $state_tabs );
			$section_dark_controls = [];
			$section_sticky_controls = [];
			$section_options = [
				'label' => __( $section_label, 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			];
			$section_condition = [];
			$section_conditions = [];

			if ( isset( $sections[ $section_id ]['condition'] ) ) {
				$section_condition = $sections[ $section_id ]['condition'];
				$section_options['condition'] = $sections[ $section_id ]['condition'];
			}
			if ( isset( $sections[ $section_id ]['conditions'] ) ) {
				$section_conditions = $sections[ $section_id ]['conditions'];
				$section_options['conditions'] = $sections[ $section_id ]['conditions'];
			}

			// start controls section
			if ( !$is_in_repeater ) {
				$widget->start_controls_section(
					$section_id . 's_style_section',
					$section_options
				);
			} else {
				$heading_condition = [];
				if ( !empty( $section_condition ) ) {
					$heading_condition = $section_condition;
				} else if ( !empty( $section_conditions ) ) {
					$heading_condition = $section_condition;
				}
				$widget->add_control(
					'repeater_' . $section_id . '_heading',
					[
						'label' => __( $section_label, 'aihub-core' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
						'condition' => $heading_condition
					]
				);
			}

			foreach ( $controls as $control ) {

				if ( $have_state_tabs && self::control_is_tabbable( $control ) ) {
					continue;
				}

				if ( self::control_has_color( $control ) ) {
					$constrol = self::prepare_control( $section_id, $section_condition, $section_conditions, $control, '', $is_in_repeater );
					$section_dark_controls[] = $constrol;
					$section_sticky_controls[] = $constrol;
				}

				self::get_control( $section_id, $section_condition, $section_conditions, $control, '', $is_in_repeater );

			}

			// if have state tabs
			if ( $have_state_tabs ) {
				$widget->start_controls_tabs(
					$section_id. 's_style_tabs',
				);

				foreach ( $state_tabs as $tab ) {
					$tab_options = [
						'label' => esc_html__( self::get_titlecase( str_replace( [ '-within' ], [ '' ], $tab ) ), 'aihub-core' ),
					];

					if ( isset( self::$current_section_options['condition'] ) ) {
						$tab_options['condition'] = self::$current_section_options['condition'];
					}

					$widget->start_controls_tab(
						$section_id. 's_style_tab_' . $tab,
						$tab_options
					);

					foreach ( $controls as $control ) {

						if (
							( !self::control_is_tabbable( $control ) ) ||
							( isset( $control['tab'] ) && $control['tab'] !== $tab )
						) {
							continue;
						}

						if ( self::control_has_color( $control ) ) {
							$control = self::prepare_control( $section_id, $section_condition, $section_conditions, $control, $tab, $is_in_repeater );
							$section_dark_controls[] = $control;
							$section_sticky_controls[] = $control;
						}

						self::get_control( $section_id, $section_condition, $section_conditions, $control, $tab, $is_in_repeater );

					}

					$widget->end_controls_tab();
				}

				$widget->end_controls_tabs();
			}

			if ( !$is_in_repeater ) {
				$widget->end_controls_section();
			}

			if ( !empty( $section_dark_controls ) ) {
				if ( !isset( $widget_dark_controls[ $section_id ] ) ) {
					$widget_dark_controls[ $section_id ] = [];
				}
				$widget_dark_controls[ $section_id ][] = $section_dark_controls;
			}

			if ( !empty( $section_sticky_controls ) ) {
				if ( !isset( $widget_sticky_controls[ $section_id ] ) ) {
					$widget_sticky_controls[ $section_id ] = [];
				}
				$widget_sticky_controls[ $section_id ][] = $section_sticky_controls;
			}

		}

		if ( !empty( $widget_sticky_controls ) ) {

			$sticky_label = 'Sticky <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">📌<span>';
			$sticky_heading_condition = [];

			if ( !empty( $section_condition ) ) {
				$sticky_heading_condition = $section_condition;
			} else if ( !empty( $section_conditions ) ) {
				$sticky_heading_condition = $section_condition;
			}

			if ( ! $is_in_repeater ) {
				$widget->start_controls_section(
					'lqd_sticky_style_section',
					[
						'label' => __( $sticky_label, 'aihub-core' ),
						'tab' => Controls_Manager::TAB_STYLE,
						// probably have to use 'conditions' with 'or'
						// 'condition' => $sticky_heading_condition
					]
				);
			} else {
				$widget->add_control(
					'lqd_sticky_repeater_' . $section_id . '_heading',
					[
						'label' => __( $sticky_label, 'aihub-core' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
						'condition' => $sticky_heading_condition
					]
				);
			}

			$sticky_controls_i = 0;

			foreach ( $widget_sticky_controls as $section_id => $controls ) {

				$controls = $controls[0];
				$control_section_label = isset( $sections[$section_id]['label'] ) ? $sections[$section_id]['label'] : self::get_titlecase( $section_id );
				$section_label = $control_section_label . ( isset( $sections[$section_id]['plural_heading'] ) && !$sections[$section_id]['plural_heading'] ? '' : 's' );
				$state_tabs = isset( $sections[$section_id]['state_tabs'] ) ? $sections[$section_id]['state_tabs'] : '';
				$have_state_tabs = !empty( $state_tabs );
				$heading_options = [
					'label' => esc_html__( $section_label, 'aihub-core' ),
					'type' => Controls_Manager::HEADING,
				];
				$section_condition = [];
				$section_conditions = [];

				if ( $sticky_controls_i !== 0 ) {
					$heading_options['separator'] = 'before';
				}

				if ( isset( $sections[ $section_id ]['condition'] ) ) {
					$section_condition = $sections[ $section_id ]['condition'];
					$heading_options['condition'] = $section_condition;
				}
				if ( isset( $sections[ $section_id ]['conditions'] ) ) {
					$section_conditions = $sections[ $section_id ]['conditions'];
					$heading_options['conditions'] = $section_conditions;
				}

				$widget->add_control(
					'lqd_sticky_' . $section_id . '_heading',
					$heading_options
				);

				foreach ( $controls as $control ) {

					if ( $have_state_tabs && self::control_is_tabbable( $control ) ) {
						continue;
					}

					if ( !isset( $control['is_prepared_for_sticky'] ) ) {
						$control = self::prepare_control_for_sticky( $section_condition, $section_conditions, $control );
					}

					self::get_control( $section_id, $section_condition, $section_conditions, $control );

				}

				// if have state tabs
				if ( $have_state_tabs ) {
					$widget->start_controls_tabs(
						'lqd_sticky_' . $section_id . 's_style_tabs',
					);

					foreach ( $state_tabs as $tab ) {
						$tab_options = [
							'label' => esc_html__( self::get_titlecase( $tab ), 'aihub-core' ),
						];

						if ( isset( $sections[$section_id]['condition'] ) ) {
							$tab_options['condition'] = $sections[$section_id]['condition'];
						}

						$widget->start_controls_tab(
							'lqd_sticky_' . $section_id . 's_style_tab_' . $tab,
							$tab_options
						);

						foreach ( $controls as $control ) {

							if ( ! self::control_is_tabbable( $control ) || $control['options']['tab'] !== $tab ) {
								continue;
							}

							if ( !isset( $control['is_prepared_for_sticky'] ) ) {
								$control = self::prepare_control_for_sticky( $section_condition, $section_conditions, $control );
							}

							self::get_control( $section_id, $section_condition, $section_conditions, $control, $tab );

						}

						$widget->end_controls_tab();
					}

					$widget->end_controls_tabs();
				}

				$sticky_controls_i++;
			}

			if ( ! $is_in_repeater ) {
				$widget->end_controls_section();
			}

		}; // if !empty( $widget_sticky_controls )

		if ( !empty( $widget_dark_controls ) ) {

			$dark_label = 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>';
			$dark_heading_condition = [];

			if ( !empty( $section_condition ) ) {
				$dark_heading_condition = $section_condition;
			} else if ( !empty( $section_conditions ) ) {
				$dark_heading_condition = $section_condition;
			}

			if ( ! $is_in_repeater ) {
				$widget->start_controls_section(
					'dark_style_section',
					[
						'label' => __( $dark_label, 'aihub-core' ),
						'tab' => Controls_Manager::TAB_STYLE,
						// probably have to use 'conditions' with 'or'
						// 'condition' => $dark_heading_condition
					]
				);
			} else {
				$widget->add_control(
					'dark_repeater_' . $section_id . '_heading',
					[
						'label' => __( $dark_label, 'aihub-core' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
						'condition' => $dark_heading_condition
					]
				);
			}

			$dark_controls_i = 0;

			foreach ( $widget_dark_controls as $section_id => $controls ) {

				$controls = $controls[0];
				$control_section_label = isset( $sections[$section_id]['label'] ) ? $sections[$section_id]['label'] : self::get_titlecase( $section_id );
				$section_label = $control_section_label . ( isset( $sections[$section_id]['plural_heading'] ) && !$sections[$section_id]['plural_heading'] ? '' : 's' );
				$state_tabs = isset( $sections[$section_id]['state_tabs'] ) ? $sections[$section_id]['state_tabs'] : '';
				$have_state_tabs = !empty( $state_tabs );
				$heading_options = [
					'label' => esc_html__( $section_label, 'aihub-core' ),
					'type' => Controls_Manager::HEADING,
				];
				$section_condition = [];
				$section_conditions = [];

				if ( $dark_controls_i !== 0 ) {
					$heading_options['separator'] = 'before';
				}

				if ( isset( $sections[ $section_id ]['condition'] ) ) {
					$section_condition = $sections[ $section_id ]['condition'];
					$heading_options['condition'] = $section_condition;
				}
				if ( isset( $sections[ $section_id ]['conditions'] ) ) {
					$section_conditions = $sections[ $section_id ]['conditions'];
					$heading_options['conditions'] = $section_conditions;
				}

				$widget->add_control(
					'dark_' . $section_id . '_heading',
					$heading_options
				);

				foreach ( $controls as $control ) {

					if ( $have_state_tabs && self::control_is_tabbable( $control ) ) {
						continue;
					}

					if ( !isset( $control['is_prepared_for_dark'] ) ) {
						$control = self::prepare_control_for_dark( $section_condition, $section_conditions, $control );
					}

					self::get_control( $section_id, $section_condition, $section_conditions, $control );

				}

				// if have state tabs
				if ( $have_state_tabs ) {
					$widget->start_controls_tabs(
						'dark_' . $section_id . 's_style_tabs',
					);

					foreach ( $state_tabs as $tab ) {
						$tab_options = [
							'label' => esc_html__( self::get_titlecase( $tab ), 'aihub-core' ),
						];

						if ( isset( $sections[$section_id]['condition'] ) ) {
							$tab_options['condition'] = $sections[$section_id]['condition'];
						}

						$widget->start_controls_tab(
							'dark_' . $section_id . 's_style_tab_' . $tab,
							$tab_options
						);

						foreach ( $controls as $control ) {

							if ( ! self::control_is_tabbable( $control ) || $control['options']['tab'] !== $tab ) {
								continue;
							}

							if ( !isset( $control['is_prepared_for_dark'] ) ) {
								$control = self::prepare_control_for_dark( $section_condition, $section_conditions, $control );
							}

							self::get_control( $section_id, $section_condition, $section_conditions, $control, $tab );

						}

						$widget->end_controls_tab();
					}

					$widget->end_controls_tabs();
				}

				$dark_controls_i++;
			}

			if ( ! $is_in_repeater ) {
				$widget->end_controls_section();
			}

		}; // if !empty( $widget_dark_controls )

	}

	protected static function get_control( $section_id, $section_condition, $section_conditions, $control = [], $tab = '', $is_in_repeater = false ) {
		if ( empty( $control ) ) return;

		$type = self::get_control_type( $control );

		if ( !isset( $control['is_prepared'] ) ) {
			$control = self::prepare_control( $section_id, $section_condition, $section_conditions, $control, $tab, $is_in_repeater );
		}

		self::{'get_elementor_' . $type . '_control'}( $section_id, $control, $tab );
	}

	protected static function prepare_control( $section_id, $section_condition, $section_conditions, $control, $tab, $is_in_repeater ) {
		$type = self::get_control_type( $control );

		$control_opts = self::get_control_options( $section_id, $section_condition, $section_conditions, $control, $type, $tab, $is_in_repeater );

		$control['options'] = $control_opts['options'];
		$control['control_options'] = $control_opts['control_options'];

		$control['is_prepared'] = true;

		return $control;
	}

	protected static function prepare_control_for_sticky( $section_condition, $section_conditions, $control ) {
		$sticky_section_selector = '[data-lqd-container-is-sticky=true]';
		$control['control_options']['name'] = 'lqd_sticky_' . $control['control_options']['name'];
		$uniq_selector = '.elementor-element.elementor-element-{{ID}}';

		if ( isset( $control['control_options']['selectors'] ) ) {
			foreach ( $control['control_options']['selectors'] as $css_selector => $css_val ) {
				$control['control_options']['selectors'][
					str_replace(
						[ '{{WRAPPER}}' ],
						[ '.elementor ' . $sticky_section_selector . ' ' . $uniq_selector ],
						$css_selector
					)
				] = $css_val;
				unset( $control['control_options']['selectors'][$css_selector] );
			}
		}
		if ( isset( $control['control_options']['selector'] ) ) {
			$control['control_options']['selector'] =
				str_replace(
					[ '{{WRAPPER}}' ],
					[ '.elementor ' . $sticky_section_selector . ' ' . $uniq_selector ],
					$control['control_options']['selector']
				);
		}
		if ( isset( $control['control_options']['apply_other_bg_props_to'] ) ) {
			$control['control_options']['apply_other_bg_props_to'] =
				str_replace(
					[ '{{WRAPPER}}' ],
					[ '.elementor ' . $sticky_section_selector . ' ' . $uniq_selector ],
					$control['control_options']['apply_other_bg_props_to']
				);
		}

		if ( !empty( $section_condition ) ) {
			if ( isset( $control['control_options']['condition'] ) ) {
				$control['control_options']['condition'] = array_merge(
					$section_condition,
					$control['control_options']['condition']
				);
			} else {
				$control['control_options']['condition'] = $section_condition;
			}
		}
		if ( !empty( $section_conditions ) ) {
			if ( isset( $control['control_options']['conditions'] ) ) {
				$control['control_options']['conditions'] = array_merge(
					$section_conditions,
					$control['control_options']['conditions']
				);
			} else {
				$control['control_options']['conditions'] = $section_conditions;
			}
		}

		$control['is_prepared_for_sticky'] = true;

		return $control;
	}

	protected static function prepare_control_for_dark( $section_condition, $section_conditions, $control ) {
		$dark_element_selector = '[data-lqd-color-scheme=dark]';
		$dark_page_selector = '[data-lqd-page-color-scheme=dark]';
		$control['control_options']['name'] = 'dark_' . $control['control_options']['name'];
		$uniq_selector = '.elementor-element.elementor-element-{{ID}}';

		if ( isset( $control['control_options']['selectors'] ) ) {
			foreach ( $control['control_options']['selectors'] as $css_selector => $css_val ) {
				$_css_selector = $css_selector;
				$selector = strpos( $_css_selector, '{{WRAPPER}}' ) ?
					str_replace(
						[ '{{WRAPPER}}' ],
						[ '{{WRAPPER}}' . $dark_element_selector . ', ' . $dark_element_selector . ' ' . $uniq_selector ],
						$_css_selector
					) :
					$dark_element_selector . $uniq_selector . ', ' . $dark_element_selector . ' ' . $uniq_selector;
				$control['control_options']['selectors'][$dark_page_selector . ' ' . $_css_selector] = $css_val;
				$control['control_options']['selectors'][$selector] = $css_val;
				unset( $control['control_options']['selectors'][$_css_selector] );
			}
		}
		if ( isset( $control['control_options']['selector'] ) ) {
			$_selector = $control['control_options']['selector'];
			$selector = strpos( $_selector, '{{WRAPPER}}' ) ?
				str_replace(
					[ '{{WRAPPER}}' ],
					[ '{{WRAPPER}}' . $dark_element_selector . ', ' . $dark_element_selector . ' ' . $uniq_selector ],
					$_selector
				) :
				$dark_element_selector . $uniq_selector . ', ' . $dark_element_selector . ' ' . $uniq_selector;
			$control['control_options']['selector'] = $dark_page_selector . ' ' . $_selector . ', ' . $selector;
		}
		if ( isset( $control['control_options']['apply_other_bg_props_to'] ) ) {
			$_selector = $control['control_options']['apply_other_bg_props_to'];
			$selector = $selector = strpos( $_selector, '{{WRAPPER}}' ) ?
				str_replace(
					[ '{{WRAPPER}}' ],
					[ '{{WRAPPER}}' . $dark_element_selector . ', ' . $dark_element_selector . ' ' . $uniq_selector ],
					$control['control_options']['selector']
				) :
				$dark_element_selector . $uniq_selector . ', ' . $dark_element_selector . ' ' . $uniq_selector;
			$control['control_options']['apply_other_bg_props_to'] = $dark_page_selector . ' ' . $_selector . ', ' . $selector;
		}

		if ( !empty( $section_condition ) ) {
			if ( isset( $control['control_options']['condition'] ) ) {
				$control['control_options']['condition'] = array_merge(
					$section_condition,
					$control['control_options']['condition']
				);
			} else {
				$control['control_options']['condition'] = $section_condition;
			}
		}
		if ( !empty( $section_conditions ) ) {
			if ( isset( $control['control_options']['conditions'] ) ) {
				$control['control_options']['conditions'] = array_merge(
					$section_conditions,
					$control['control_options']['conditions']
				);
			} else {
				$control['control_options']['conditions'] = $section_conditions;
			}
		}

		$control['is_prepared_for_dark'] = true;

		return $control;
	}

	protected static function get_control_options( $section_id, $section_condition, $section_conditions, $control, $type, $tab, $is_in_repeater ) {

		if ( !$control ) return;

		$css_var = isset( $control['css_var'] ) ? $control['css_var'] : '';
		$has_css_var = !empty( $css_var );
		$css_prop = isset( $control['css_prop'] ) ? $control['css_prop'] : str_replace( ['liquid_', 'bacground_css', '_'], ['', 'background', '-'], $control['type'] ); // background, border, padding, margin, color etc.
		$is_in_tab = $tab && $tab !== 'normal';
		$control_tab = $is_in_tab ? '_' . $tab : '';
		$state_selector = '';
		$name = isset( $control['name'] ) ? $control['name'] : str_replace( ['liquid_', 'background_css', 'linked_dimensions'], ['', 'background', 'dimensions'], $control['type'] );
		$label = isset( $control['label'] ) ? $control['label'] : self::get_titlecase( $name );
		$is_group_control = self::control_is_groupped( $control );
		$options = [
			'selector' => '{{WRAPPER}}'
		];
		$control_options = [
			'name' => $section_id . '_' . $name . $control_tab,
			'label' => __( $label, 'aihub-core' ),
			'selectors' => [],
			'condition' => [],
			'conditions' => []
		];
		$initial_css_var = $css_var;
		$initial_css_prop = $css_prop;

		switch ($tab) {
			case 'hover':
				$state_selector = ':hover';
				break;
			case 'active':
				$state_selector = '.lqd-is-active';
				break;
			case 'css_active':
				$state_selector = ':active';
				break;
			case 'focus':
				$state_selector = ':focus';
				break;
			case 'focus-within':
				$state_selector = ':focus-within';
				break;
			case 'current_menu_item':
				$state_selector = '.current-menu-item';
				break;
		}

		if ( isset( $control['condition'] ) ) {
			$control_options['condition'] = $control['condition'];
		} else if ( isset( $control['conditions'] ) ) {
			$control_options['conditions'] = $control['conditions'];
		}

		if ( isset( $control_options['condition'] ) && !empty( $section_condition ) ) {
			$control_options['condition'] = array_merge(
				$section_condition,
				$control_options['condition']
			);
		} else if ( isset( $control_options['conditions'] ) && !empty( $section_conditions ) ) {
			$control_options['conditions'] = array_merge(
				$section_conditions,
				$control_options['conditions']
			);
		}

		if ( isset( $control['include_wrapper_selector'] ) && $control['include_wrapper_selector'] == false ) {
			$options['selector'] = '';
		}

		if ( isset( self::$current_section_options['selector'] ) && !empty( self::$current_section_options['selector'] ) ) {
			if ( self::$current_section_options['selector'] !== $options['selector'] ) {
				$options['selector'] .= ' ' .  self::$current_section_options['selector'];
			}
		} else if ( isset( $control['selector'] ) && !empty( $control['selector'] ) && $control['selector'] !== $options['selector'] ) {
			$options['selector'] .= ' ' . $control['selector'];
		} else {
			$options['selector'] .= ' .lqd-' . self::$current_selector_prefix . '-' . str_replace( [ '_' ], [ '-' ], $section_id );
		}

		if ( isset( $control['default'] ) ) {
			$control_options['default'] = $control['default'];
		}

		$initial_selector = $options['selector'];

		if ( $has_css_var ) {
			$css_prop = $css_var;
			if ( !$is_in_tab && !$is_in_repeater ) {
				$options['selector'] = '{{WRAPPER}}';
			}
		}

		if ( !empty( $tab ) ) {
			$control['options']['tab'] = $tab;
		}

		if ( $is_in_tab ) {

			$state_selectors = '';
			if ( isset( self::$current_section_options['state_selectors'] ) ) {
				$state_selectors = self::$current_section_options['state_selectors'];
			} else if ( isset( $control['state_selectors'] ) ) {
				$state_selectors = $control['state_selectors'];
			}
			if ( !empty( $state_selectors ) ) {
				if ( isset( $state_selectors['hover'] ) && $tab === 'hover' ) {
					$state_selector = $state_selectors['hover'];
				}
				if ( isset( $state_selectors['active'] ) && $tab === 'active' ) {
					$state_selector = $state_selectors['active'];
				}
				if ( isset( $state_selectors['css_active'] ) && $tab === 'css_active' ) {
					$state_selector = $state_selectors['css_active'];
				}
				if ( isset( $state_selectors['focus'] ) && $tab === 'focus' ) {
					$state_selector = $state_selectors['focus'];
				}
				if ( isset( $state_selectors['focus-within'] ) && $tab === 'focus-within' ) {
					$state_selector = $state_selectors['focus-within'];
				}
				if ( isset( $state_selectors['current_menu_item'] ) && $tab === 'current_menu_item' ) {
					$state_selector = $state_selectors['current_menu_item'];
				}
			}

			$has_before_selector = false;
			if ( isset( self::$current_section_options['state_selectors_before'] ) ) {
				$selectors_before = self::$current_section_options['state_selectors_before'];
				$selector_array = explode( ',', $options['selector']);
				$final_selector_array = [];
				/**
				 * TODO: REFACTOR THIS SHIT
				 */
				foreach ($selector_array as $string) {
					$string_exploded = explode( ' ', trim( $string ) );
					if ( isset( $selectors_before[ $tab ] ) ) {
						$has_before_selector = true;
						$current_item_string_index = array_search( $selectors_before[ $tab ], $string_exploded );
						if ( $current_item_string_index ) {
							$string_exploded[$current_item_string_index] .= $state_selector;
						} else {
							$index = -1;
							$delete_count = 0;
							if ( $selectors_before[ $tab ] === '{{WRAPPER}}' ) {
								$index = 0;
								$delete_count = 1;
							}
							array_splice( $string_exploded, $index, $delete_count, $selectors_before[ $tab ] . $state_selector );
						}
					}
					$final_selector_array[] = implode( ' ', $string_exploded );
				}
				$options['selector'] = implode( ',', $final_selector_array );
			}
			if ( !$has_before_selector ) {
				$options['selector'] .= $state_selector;
			}
		}

		if ( $is_group_control ) {
			$control_options['selector'] = $options['selector'];

			if ( isset( $control['fields_options'] ) ) {
				$control_options['fields_options'] = [];
			}

			if ( $type === 'border' ) {
				$control_options['fields_options'] = [
					'color' => [
						'type' => 'liquid-color',
						'types' => [ 'solid' ],
					],
				];

				if ( $has_css_var ) {
					$control_options['fields_options']['border'] = array_merge(
						isset( $control_options['fields_options']['border'] ) ? $control_options['fields_options']['border'] : [],
						[
							'selectors' => [
								'{{SELECTOR}}' => $css_var . 's: {{VALUE}};',
							],
						]
					);
					$control_options['fields_options']['width'] = array_merge(
						isset( $control_options['fields_options']['width'] ) ? $control_options['fields_options']['width'] : [],
						[
							'selectors' => [
								'{{SELECTOR}}' => $css_var . 'w: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' . $css_var . 'wt: {{TOP}}{{UNIT}};' . $css_var . 'we: {{RIGHT}}{{UNIT}};' . $css_var . 'wb: {{BOTTOM}}{{UNIT}};' . $css_var . 'ws: {{LEFT}}{{UNIT}};',
							],
						]
					);
					$control_options['fields_options']['color'] = array_merge(
						isset( $control_options['fields_options']['color'] ) ? $control_options['fields_options']['color'] : [],
						[
							'selectors' => [
								'{{SELECTOR}}' => $css_var . 'c: {{VALUE}};',
							],
						]
					);
				}
			} else if ( $type === 'box_shadow' ) {
				$control_options['fields_options'] = [
					'box_shadow' => [
						'selectors' => [
							'{{SELECTOR}}' => $css_prop . ': {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} {{box_shadow_position.VALUE}};',
						],
					]
				];
			} else if ( $type === 'liquid_background' ) {
				$types = isset( $control['types'] ) ? $control['types'] : [ 'color', 'animated-gradient' ];

				$control_options['types'] = $types;
			} else if ( $type === 'liquid_background_css' ) {
				if ( isset( $control['fields_options'] ) ) {
					$control_options['fields_options'] = $control['fields_options'];
				}
				$apply_other_bg_props_to = isset( $control['apply_other_bg_props_to'] ) ? $control['apply_other_bg_props_to'] : '';

				if ( $has_css_var ) {
					$control_options['css_attr'] = $css_prop;
					$control_options['apply_other_bg_props_to'] = $options['selector'] . ' ' . '.lqd-' . self::$current_selector_prefix . '-' . $section_id;
				}
				if ( !empty( $apply_other_bg_props_to ) ) {
					$control_options['apply_other_bg_props_to'] = $control_options['selector'] . ' ' . $apply_other_bg_props_to;

					if ( $is_in_tab ) {
						if ( !empty( $apply_other_bg_props_to ) ) {
							if ( $tab === 'hover' ) {
								$control_options['apply_other_bg_props_to'] = $control_options['apply_other_bg_props_to'] . ':hover';
							}
							if ( $tab === 'active' ) {
								$control_options['apply_other_bg_props_to'] = $control_options['apply_other_bg_props_to'] . '.lqd-is-active';
							}
							if ( $tab === 'css_active' ) {
								$control_options['apply_other_bg_props_to'] = $control_options['apply_other_bg_props_to'] . ':active';
							}
							if ( $tab === 'focus' ) {
								$control_options['apply_other_bg_props_to'] = $control_options['apply_other_bg_props_to'] . ':focus';
							}
							if ( $tab === 'focus-within' ) {
								$control_options['apply_other_bg_props_to'] = $control_options['apply_other_bg_props_to'] . ':focus-within';
							}
							if ( $tab === 'current_menu_item' ) {
								$control_options['apply_other_bg_props_to'] = $control_options['apply_other_bg_props_to'] . '.current-menu-item';
							}
						}
					}
				}
			} else if ( $type === 'css_backdrop_filter' ) {
				$control_options['fields_options'] = [
					'blur' => [
						'selectors' => [
							'{{SELECTOR}}' => '-webkit-backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg );backdrop-filter: brightness( {{brightness.SIZE}}% ) contrast( {{contrast.SIZE}}% ) saturate( {{saturate.SIZE}}% ) blur( {{blur.SIZE}}px ) hue-rotate( {{hue.SIZE}}deg )',
						],
					]
				];
			}

			if ( isset( $control['fields_options'] ) ) {
				$control_options['fields_options'] = array_merge(
					$control_options['fields_options'],
					$control['fields_options']
				);
			}

			unset( $control_options['selectors'] );
		} else {
			$css_val = '{{VALUE}}';

			if ( $type === 'dimensions' ) {
				$css_val = '{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';

				if ( $has_css_var ) {
					$css_val = '' . $css_var . 't: {{TOP}}{{UNIT}}; ' . $css_var . 'e: {{RIGHT}}{{UNIT}}; ' . $css_var . 'b: {{BOTTOM}}{{UNIT}}; ' . $css_var . 's: {{LEFT}}{{UNIT}};';
				}
			} else if ( $type === 'liquid_color' ) {
				$types = isset( $control['types'] ) ? $control['types'] : [ 'solid' ];

				$control_options['type'] = 'liquid-color';
				$control_options['types'] = $types;

				if ( $has_css_var ) {
					$css_val = $css_prop . ':{{VALUE}};';
				}
			} else if ( $type === 'liquid_linked_dimensions' ) {
				$control_options['type'] = 'liquid-linked-dimensions';
				$css_prop = '';
				$css_val = 'width: {{WIDTH}}{{UNIT}}; height: {{HEIGHT}}{{UNIT}};';
				if ( $has_css_var ) {
					$css_val = ''. $css_var .'-w: {{WIDTH}}{{UNIT}}; '. $css_var .'-h: {{HEIGHT}}{{UNIT}};';
				}
			} else if ( $type === 'slider' ) {
				$is_opacity = $control['type'] === 'opacity';
				$unit = isset( $control['unit'] ) ? $control['unit'] : '{{UNIT}}';
				$css_val = '{{SIZE}}' . $unit;
				if ( $is_opacity ) {
					$control_options['size_units'] = [ 'px' ];
					$control_options['range'] = [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.1,
						]
					];
					$css_val = '{{SIZE}}';
				} else {
					$control_options['range'] = isset( $control['range'] ) ? $control['range'] : [
						'%' => [
							'min' => 1,
							'max' => 100,
						],
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
						'em' => [
							'min' => 1,
							'max' => 10,
						],
						'vh' => [
							'min' => 1,
							'max' => 100,
						],
						'vw' => [
							'min' => 1,
							'max' => 100,
						],
					];
				}
				if ( isset( $control['size_units'] ) ) {
					$control_options['size_units'] = $control['size_units'];
				}
				if ( $has_css_var ) {
					if ( $is_opacity ) {
						$css_val = $css_prop . ':{{SIZE}};';
					} else {
						$css_val = $css_prop . ':{{SIZE}}' . (isset( $control['unit'] ) ? $control['unit'] : '{{UNIT}}');
					}
				}
			}

			if ( $has_css_var ) {
				$control_options['selectors'][$options['selector']] = $css_val;
				if (
					( isset( self::$current_section_options['apply_prop_to_el'] ) && !!self::$current_section_options['apply_prop_to_el'] ) ||
					( isset( $control['apply_prop_to_el'] ) && !!$control['apply_prop_to_el'] )
				) {
					if ( !$is_in_tab ) {
						$control_options['selectors'][$initial_selector] = $initial_css_prop . ':var(' . $initial_css_var . ')';
					}
				}
				if (
					( isset( self::$current_section_options['apply_css_var_to_el'] ) && !!self::$current_section_options['apply_css_var_to_el'] ) ||
					( isset( $control['apply_css_var_to_el'] ) && !!$control['apply_css_var_to_el'] )
				) {
					if ( !$is_in_tab ) {
						$control_options['selectors'][$initial_selector] = $css_val;
					}
				}
			} else {
				if ( isset( $control['selectors'] ) ) {
					$control_options['selectors'] = $control['selectors'];
					if ( $is_in_tab ) {
						/**
						 * TODO: REFACTOR THIS SHIT
						 */
						foreach ( $control_options['selectors'] as $selector => $css_val ) {
							$selectors_array = explode( ',', $selector );
							$final_selectors_array = [];
							foreach ( $selectors_array as $string ) {
								$has_before_selector = false;
								if ( isset( self::$current_section_options['state_selectors_before'] ) ) {
									$selectors_before = self::$current_section_options['state_selectors_before'];
									$string_exploded = explode( ' ', trim( $string ) );
									if ( isset( $selectors_before[ $tab ] ) ) {
										$has_before_selector = true;
										$current_item_string_index = array_search( $selectors_before[ $tab ], $string_exploded );
										if ( $current_item_string_index ) {
											$string_exploded[$current_item_string_index] .= $state_selector;
										} else {
											array_splice( $string_exploded, -1, 0, $selectors_before[ $tab ] . $state_selector );
										}
										$string = implode( ' ', $string_exploded );
									}
								}
								if ( !$has_before_selector ) {
									$string .= $state_selector;
								}
								$final_selectors_array[] = $string;
							}
							$final_selector = implode( ',', $final_selectors_array );
							array_shift( $control_options['selectors'] );
							$control_options['selectors'][$final_selector] = $css_val;
						}
					}
				} else {
					$control_options['selectors'][$options['selector']] = ( !empty( $css_prop ) ? $css_prop . ':' : '' ) . $css_val;
				}
			}
		}

		// merge $options and $control_options coming from $control
		if ( isset( $control['options'] ) ) {
			$options = array_merge(
				$options,
				$control['options'],
			);
		};
		if ( isset( $control['control_options'] ) ) {
			$control_options = array_merge(
				$options,
				$control['control_options'],
			);
		};

		return [
			'options' => $options,
			'control_options' => $control_options
		];

	}

	protected static function get_elementor_border_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			Group_Control_Border::get_type(),
			$control['control_options']
		);

	}

	protected static function get_elementor_box_shadow_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			$control['control_options']
		);

	}

	protected static function get_elementor_text_shadow_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			$control['control_options']
		);

	}

	protected static function get_elementor_text_stroke_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			$control['control_options']
		);

	}

	protected static function get_elementor_css_filter_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			Group_Control_Css_Filter::get_type(),
			$control['control_options']
		);

	}

	protected static function get_elementor_css_backdrop_filter_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			Group_Control_Css_Filter::get_type(),
			$control['control_options'],
		);

	}

	protected static function get_elementor_dimensions_control( $section_id, $control ) {

		$control_options = array_merge(
			[
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
			],
			$control['control_options'],
		);

		self::$current_widget->add_responsive_control(
			$control_options['name'],
			$control_options
		);

	}

	protected static function get_elementor_liquid_background_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			'liquid-background',
			$control['control_options']
		);

	}

	protected static function get_elementor_liquid_background_css_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			'liquid-background-css',
			$control['control_options']
		);

	}

	protected static function get_elementor_liquid_color_control( $section_id, $control ) {

		self::$current_widget->add_control(
			$control['control_options']['name'],
			$control['control_options']
		);

	}

	protected static function get_elementor_liquid_linked_dimensions_control( $section_id, $control ) {

		$control_options = array_merge(
			[
				'size_units' => [ 'px', '%', 'em', 'custom' ],
			],
			$control['control_options'],
		);

		self::$current_widget->add_responsive_control(
			$control_options['name'],
			$control_options
		);

	}

	protected static function get_elementor_raw_control( $section_id, $control ) {

		$add_method = isset( $control['responsive'] ) && $control['responsive'] ? 'add_responsive_control' : 'add_control';

		self::$current_widget->{ $add_method }(
			...$control['raw_options']
		);

	}

	protected static function get_elementor_slider_control( $section_id, $control ) {

		$control_options = array_merge(
			[
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
			],
			$control['control_options'],
		);

		self::$current_widget->add_responsive_control(
			$control_options['name'],
			$control_options
		);
	}

	protected static function get_elementor_typography_control( $section_id, $control ) {

		self::$current_widget->add_group_control(
			Group_Control_Typography::get_type(),
			$control['control_options']
		);

	}

	protected static function get_titlecase( $word ) {
		return ucfirst( str_replace( ['_'], [' '], $word ) );
	}

	protected static function get_control_type( $control ) {
		$type = $control['type'];

		switch ( $type ) {
			case 'border_radius':
			case 'margin':
			case 'padding':
				$type = 'dimensions';
				break;
			case 'font_size':
			case 'gap':
			case 'height':
			case 'opacity':
			case 'width':
				$type = 'slider';
				break;
		}

		return $type;
	}

	protected static function control_is_tabbable( $control ) {
		$control_type = $control['type'];

		if ( isset( $control['tab'] ) && $control['tab'] === 'none' ) {
			return false;
		}

		return (
			$control_type !== 'gap' &&
			$control_type !== 'font_size' &&
			$control_type !== 'height' &&
			$control_type !== 'liquid_linked_dimensions' &&
			$control_type !== 'margin' &&
			$control_type !== 'padding' &&
			$control_type !== 'slider' &&
			$control_type !== 'typography' &&
			$control_type !== 'width'
		);
	}

	protected static function control_is_groupped( $control ) {
		$control_type = $control['type'];

		return (
			$control_type === 'background' ||
			$control_type === 'border' ||
			$control_type === 'css_filter' ||
			$control_type === 'css_backdrop_filter' ||
			$control_type === 'box_shadow' ||
			$control_type === 'liquid_background' ||
			$control_type === 'liquid_background_css' ||
			$control_type === 'text_shadow' ||
			$control_type === 'text_stroke' ||
			$control_type === 'typography'
		);
	}

	protected static function control_has_color( $control ) {
		$control_type = $control['type'];

		return (
			$control_type === 'background' ||
			$control_type === 'border' ||
			$control_type === 'color' ||
			$control_type === 'css_filter' ||
			$control_type === 'css_backdrop_filter' ||
			$control_type === 'box_shadow' ||
			$control_type === 'liquid_background' ||
			$control_type === 'liquid_background_css' ||
			$control_type === 'liquid_color' ||
			$control_type === 'text_shadow' ||
			$control_type === 'text_stroke'
		);
	}

	/**
	 * Render Icon
	 */
	public static function render_icon( $icon, $attributes = [], $tag = 'i' ) {

		if ( empty( $icon['library'] ) ) {
			return '';
		}

		if ( Plugin::$instance->experiments->is_feature_active( 'e_font_icon_svg' ) && $icon['library'] === 'akar-icons' && class_exists('Liquid_Menu_Icons_Render_SVG') ) {

			if ( ! empty( $icon['value'] ) ) {
				$icon['value'] = str_replace( 'akar-icons ', '', $icon['value'] );
				$rendered_icon = Liquid_Menu_Icons_Render_SVG::build_svg( $icon['library'], $icon['value'], isset( $icon['meta'] ) ? $icon['meta'] : '' );
				echo wp_kses( $rendered_icon, 'svg' );
			}

		} else {
			Icons_Manager::render_icon( $icon, $attributes, $tag );
		}


		return true;
	}

}