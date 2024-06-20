<?php

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
use Elementor\Controls_Manager_Hidden;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Marquee extends Widget_Base {

	public function get_name() {
		return 'lqd-marquee';
	}

	public function get_title() {
		return __( 'Liquid Marquee', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-slider-3d lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'carousel', 'slider', 'marquee' ];
	}

	public function get_script_depends() {
		return [''];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$behavior = [];
		$options = [];
		$cell_has_look_mouse = false;

		if ( $settings['reverse'] === 'yes' ) {
			$options['reversed'] = true;
		}
		if ( $settings['interact_with_scroll'] !== 'yes' ) {
			$options['interactWithScroll'] = false;
		}
		if ( !empty( $settings['speed'] ) && $settings['speed'] !== 1 ) {
			$options['speed'] = $settings['speed'];
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

		$behavior[] = [
			'behaviorClass' => 'LiquidMarqueeBehavior',
			'options' => $options
		];

		return $behavior;

	}

	protected function add_render_attributes() {

		parent::add_render_attributes();

		$wrapper_classnames = [];

		if ( empty( $this->get_settings_for_display( '_element_width' ) ) ) {
			$wrapper_classnames[] = 'w-full';
		}

		$this->add_render_attribute( '_wrapper', [
			'class' => $wrapper_classnames
		] );

	}

	protected function add_cell_controls( $state = 'normal' ) {

		$selector = '{{WRAPPER}} .lqd-marquee-cell';

		if ( $state === 'hover' ) {
			$selector .= ':hover';
		}

		$repeater->add_control(
			'cells_content_color' . $state,
			[
				'label' => __( 'Text color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$selector => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => 'cell_background' . $state,
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cell_border' . $state,
				'selector' => $selector,
			]
		);

		$this->add_responsive_control(
			'cell_border_radius' . $state,
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'cell_box_shadow' . $state,
				'selector' => $selector,
			]
		);

	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			array(
				'label' => __( 'Marquee', 'aihub-core' ),
			)
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
				],
				'toggle' => true,
				'condition'=> [
					'cell_content_type' => 'tinymce'
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
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'white-space: {{VALUE}};'
				],
				'condition'=> [
					'cell_content_type' => 'tinymce'
				],
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
			'speed',
			[
				'label' => __( 'Speed', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'placeholder' => 2,
				'default' => 2,
				'step' => 0.5,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'reverse',
			[
				'label' => __( 'Reverse', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'interact_with_scroll',
			[
				'label' => __( 'Interact with scroll', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER
			]
		);

		$this->add_responsive_control(
			'align_items',
			[
				'label' => esc_html__( 'Align items', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'' => [
						'title' => esc_html__( 'Stretch', 'aihub-core' ),
						'icon' => 'eicon-v-align-stretch',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => '',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-marquee-slider' => 'align-items: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'marquee',
			[
				'cell' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'width',
							'css_var' => '--lqd-marquee-cell-w',
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
										'{{WRAPPER}} .lqd-marquee-cell' => 'text-align: {{VALUE}}',
									],
								]
							]
						],
						[
							'type' => 'margin',
							'css_var' => '--lqd-marquee-cell-m',
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
							'css_var' => '--lqd-marquee-cell-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-marquee-cell-color',
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-marquee-cell-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-marquee-cell-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-marquee-cell-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
				],
			],
		);

	}

	protected function get_cell_content_type_tinymce( $cell, $i ) {

		echo $cell['cell_content'];

	}

	protected function get_cell_content_type_image( $cell, $i ) {

		$fig_classnames = [ 'lqd-marquee-content-img', 'rounded-inherit', 'overflow-hidden' ];
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

		echo \Elementor\Plugin::instance()->frontend->get_builder_content( $cell[ 'cell_templates' ], $with_css = true );

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
		$cells_common_classnames = [ 'lqd-marquee-cell', 'shrink-0', 'grow-0', 'basis-auto', 'relative' ];

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

        ?>

        <div class="lqd-marquee-viewport relative overflow-hidden">
            <div class="lqd-marquee-slider flex relative"><?php
				$this->get_cells_contents( $settings );
            ?></div>
        </div>

        <?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Marquee() );