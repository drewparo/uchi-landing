<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Modal_Box extends Widget_Base {

	public function get_name() {
		return 'lqd-modal';
	}

	public function get_title() {
		return __( 'Liquid Modal', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-header lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'modal', 'lightbox' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$modal_type = $settings['modal_type'];
		$behavior = [];
		$el_id = $this->get_id();

		$behavior[] = [
			'behaviorClass' => 'LiquidToggleBehavior',
			'options' => [
				'ui' => [
					'togglableElements' => "'.lqd-modal-" . "$el_id'"
				],
				'changePropPrefix' => "'lqdModalToggle-$el_id'",
				'toggleAllTriggers' => 'true',
				'toggleOffOnOutsideClick' => $modal_type === 'box' ? 'true' : 'false',
				'toggleOffOnEscPress' => 'true',
				'changeTargetClassname' => ["'opacity-0'", "'invisible'", "'pointer-events-none'"],
			]
		];

		if ( $modal_type !== 'box') {
			$move_options = [
				'elementsToMove' => "'.lqd-modal'",
				'moveElementsTo' => "'.elementor'",
				'matchFirstParent' => 'true'
			];

			if ( $modal_type === 'in-container' ) {
				$move_options['moveElementsTo'] = "'parent'";
			}

			$behavior[] = [
				'behaviorClass' => 'LiquidMoveElementBehavior',
				'options' => $move_options
			];
		}

		return $behavior;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'modal_type',
			[
				'label' => __( 'Modal Type', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'aihub-core' ),
					'fullscreen' => __( 'Fullscreen', 'aihub-core' ),
					'box' => __( 'Box', 'aihub-core' ),
					'in-container' => __( 'In container', 'aihub-core' ),
				],
				'prefix_class' => 'lqd-modal-type-',
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'content_type',
			[
				'label' => __( 'Content type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'el_template',
				'options' => [
					'el_template' => [
						'title' => __( 'Elementor Template', 'aihub-core' ),
						'icon' => 'eicon-site-identity'
					],
					'tinymce' => [
						'title' => __( 'TinyMCE', 'aihub-core' ),
						'icon' => 'eicon-text-align-left'
					],
				],
				'toggle' => false,
			]
		);

		$this->add_control(
			'modal',
			[
				'label' => __( 'Select Modal', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => liquid_helper()->get_elementor_templates(),
				'description' => liquid_helper()->get_elementor_templates_edit(),
				'condition' => [
					'content_type' => 'el_template'
				]
			]
		);

		$this->add_control(
			'content_tinymce', [
				'label' => __( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( '<p>Item content. Click the edit button to change this text.</p>' , 'aihub-core' ),
				'show_label' => false,
				'condition'=> [
					'content_type' => 'tinymce'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'modal_positioning_section',
			[
				'label' => esc_html__( 'Positioning', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'modal_positioning_heading',
			[
				'label' => esc_html__( 'Modal position', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'modal_type' => 'box',
				]
			]
		);

		$this->add_responsive_control(
			'modal_orientation_h',
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
				'render_type' => 'ui',
				'default' => 'start',
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto',
					'end' => 'inset-inline-start: auto',
				],
				'selectors' => [
					'.lqd-modal-{{ID}}' => '{{VALUE}}',
				],
				'condition' => [
					'modal_type' => 'box',
				]
			]
		);

		$this->add_responsive_control(
			'modal_offset_x',
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
					'.lqd-modal-{{ID}}' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'modal_type' => 'box',
					'modal_orientation_h' => 'start'
				]
			]
		);

		$this->add_responsive_control(
			'modal_offset_x_end',
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
					'.lqd-modal-{{ID}}' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'modal_type' => 'box',
					'modal_orientation_h' => 'end'
				]
			]
		);

		$this->add_responsive_control(
			'modal_orientation_v',
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
				'render_type' => 'ui',
				'default' => 'bottom',
				'selectors_dictionary' => [
					'top' => 'bottom: auto',
					'bottom' => 'top: auto',
				],
				'selectors' => [
					'.lqd-modal-{{ID}}' => '{{VALUE}}',
				],
				'condition' => [
					'modal_type' => 'box',
				]
			]
		);

		$this->add_responsive_control(
			'modal_offset_y',
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
					'.lqd-modal-{{ID}}' => 'top: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'after',
				'condition' => [
					'modal_type' => 'box',
					'modal_orientation_v' => 'top',
				]
			]
		);

		$this->add_responsive_control(
			'modal_offset_y_bottom',
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
					'.lqd-modal-{{ID}}' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'after',
				'condition' => [
					'modal_type' => 'box',
					'modal_orientation_v' => 'bottom',
				]
			]
		);

		$this->add_control(
			'modal_positioning_close_btn_heading',
			[
				'label' => esc_html__( 'Close button position', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'modal_type!' => 'box',
				]
			]
		);

		$this->add_responsive_control(
			'modal_close_btn_orientation_h',
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
				'render_type' => 'ui',
				'default' => 'end',
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto',
					'end' => 'inset-inline-start: auto',
				],
				'selectors' => [
					'.lqd-modal-{{ID}} .elementor-element.elementor-element-{{ID}}' => '{{VALUE}}',
				],
				'condition' => [
					'modal_type!' => 'box',
				]
			]
		);

		$this->add_responsive_control(
			'modal_close_btn_offset_x',
			[
				'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => '45'
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
					'.lqd-modal-{{ID}} .elementor-element.elementor-element-{{ID}}' => 'position: absolute; inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'modal_type!' => 'box',
					'modal_close_btn_orientation_h' => 'start'
				]
			]
		);

		$this->add_responsive_control(
			'modal_close_btn_offset_x_end',
			[
				'label' => esc_html__( 'Horizontal offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => '45'
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
					'.lqd-modal-{{ID}} .elementor-element.elementor-element-{{ID}}' => 'position: absolute; inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'modal_type!' => 'box',
					'modal_close_btn_orientation_h' => 'end'
				]
			]
		);

		$this->add_responsive_control(
			'modal_close_btn_orientation_v',
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
				'render_type' => 'ui',
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'bottom: auto',
					'bottom' => 'top: auto',
				],
				'selectors' => [
					'.lqd-modal-{{ID}} .elementor-element.elementor-element-{{ID}}' => '{{VALUE}}',
				],
				'condition' => [
					'modal_type!' => 'box',
				]
			]
		);

		$this->add_responsive_control(
			'modal_close_btn_offset_y',
			[
				'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => '30'
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
					'.lqd-modal-{{ID}} .elementor-element.elementor-element-{{ID}}' => 'position: absolute; top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'modal_type!' => 'box',
					'modal_close_btn_orientation_v' => 'top',
				]
			]
		);

		$this->add_responsive_control(
			'modal_close_btn_offset_y_bottom',
			[
				'label' => esc_html__( 'Vertical offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => '30'
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
					'.lqd-modal-{{ID}} .elementor-element.elementor-element-{{ID}}' => 'position: absolute; bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'modal_type!' => 'box',
					'modal_close_btn_orientation_v' => 'bottom',
				]
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'modal',
			[
				'modal_inner' => [
					'label' => 'Modal',
					'controls' => [
						[
							'type' => 'liquid_linked_dimensions',
							'label' => 'Dimensions',
							'selectors' => [
								'.lqd-modal-{{ID}} .lqd-modal-inner' => 'width: {{WIDTH}}{{UNIT}}; height: {{HEIGHT}}{{UNIT}}'
							],
							'condition' => [
								'modal_type!' => 'fullscreen'
							]
						],
						[
							'type' => 'width',
							'selectors' => [
								'.lqd-modal-{{ID}} .lqd-modal-inner' => 'width: {{SIZE}}{{UNIT}};'
							],
							'condition' => [
								'modal_type!' => 'fullscreen'
							]
						],
						[
							'type' => 'margin',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							'include_wrapper_selector' => false,
							'condition' => [
								'modal_type' => 'box'
							]
						],
						[
							'type' => 'padding',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							'include_wrapper_selector' => false
						],
						[
							'type' => 'typography',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							'include_wrapper_selector' => false
						],
						[
							'type' => 'liquid_color',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							'include_wrapper_selector' => false
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							// do not remove this :)
							'apply_other_bg_props_to' => ' ',
							'include_wrapper_selector' => false
						],
						[
							'type' => 'border',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							'include_wrapper_selector' => false
						],
						[
							'type' => 'border_radius',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							'include_wrapper_selector' => false
						],
						[
							'type' => 'box_shadow',
							'selector' => '.lqd-modal-{{ID}} .lqd-modal-inner',
							'include_wrapper_selector' => false
						],
					],
					'plural_heading' => false,
				],
			]
		);

		\LQD_Elementor_Trigger::register_controls( $this, '', '', 'Open modal' );

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();
		$settings = $this->get_settings_for_display();
		$classnames = [];

		if ( $settings['modal_type'] === 'in-container' ) {
			$classnames[] = 'z-1';
		}

		$this->add_render_attribute( '_wrapper', [
			'class' => $classnames
		] );
	}

	protected function get_content_type_el_template() {
		$settings = $this->get_settings_for_display();

		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $settings[ 'modal' ], true );
	}

	protected function get_content_type_tinymce() {
		$settings = $this->get_settings_for_display();

		echo $settings['content_tinymce'];
	}

	protected function get_content() {
		$content_type = $this->get_settings_for_display( 'content_type' );
		$this->{'get_content_type_' . $content_type}();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$modal_type = $settings['modal_type'];
		$modal_classnames = [ 'lqd-modal', 'lqd-modal-' . $this->get_id(), 'top-0', 'start-0', 'opacity-0', 'invisible', 'pointer-events-none', 'transition-opacity' ];
		$modal_inner_classnames = [ 'lqd-modal-inner' ];
		$is_fixed = $modal_type !== 'in-container' && $modal_type !== 'box';

		if ( $is_fixed ) {
			$modal_classnames[] = 'z-99';
		} else {
			$modal_classnames[] = 'z-10';
		}

		if ( $is_fixed ) {
			$modal_classnames[] = 'fixed';
		} else {
			$modal_classnames[] = 'absolute';
		}

		if ( $modal_type !== 'box' ) {
			$modal_classnames[] = 'w-full';
			$modal_classnames[] = 'h-full';
		}

		if ( $modal_type === 'in-container' ) {
			$modal_inner_classnames[] = 'h-full overflow-x-hidden overflow-y-auto';
		}

		if ( $modal_type === 'fullscreen' ) {
			$modal_inner_classnames[] = 'grid h-full';
		} else {
			$modal_classnames[] = 'flex items-center-justify-center';
		}

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => $modal_classnames,
				'data-modal-type' => $settings['modal_type'],
			]
		);

		$this->add_render_attribute(
			'inner',
			[
				'class' => $modal_inner_classnames,
			]
		);

		\LQD_Elementor_Trigger::render( $this );

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'inner' ); ?>>
				<?php if ( $modal_type !== 'box' ) : ?>
				<div class="lqd-modal-close-btn elementor-widget elementor-element elementor-element-<?php echo esc_attr( $this->get_id() ); ?> z-10">
					<?php \LQD_Elementor_Trigger::render( $this, '', [], true, true ); ?>
				</div>
				<?php endif; ?>
				<div class="lqd-modal-content w-full">
					<?php $this->get_content(); ?>
				</div>
			</div>
		</div>
		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Modal_Box() );