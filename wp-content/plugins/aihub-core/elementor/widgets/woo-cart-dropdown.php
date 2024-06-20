<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LD_Cart_Dropdown extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'lqd-woo-cart-dropdown';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Cart Dropdown', 'aihub-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-cart lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hub-header', 'hub-woo' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'woocommerce', 'cart', 'dropdown' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$el_id = $this->get_id();
		$behavior = [];

		$behavior[] = [
			'behaviorClass' => 'LiquidToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdCartToggle-$el_id'",
				'toggleAllTriggers' => 'true',
				'ignoreEnterOnFocus' => 'true',
				'toggleOffOnEscPress' => 'true',
				'toggleOffOnOutsideClick' => 'true',
				'triggerElements' => [
					"'click @togglableTriggers'",
				]
			]
		];
		$behavior[] = [
			'behaviorClass' => 'LiquidEffectsSlideToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdCartToggle-$el_id'",
			]
		];

		return $behavior;
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_counter',
			[
				'label' => esc_html__( 'Show counter?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'position_section',
			[
				'label' => __( 'Positioning & Alignment', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'dropdown_width',
			[
				'label' => esc_html__( 'Dropdown width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-cart-dropdown-dropdown' => 'width: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_orientation_h',
			[
				'label' => esc_html__( 'Dropdown vorizontal orientation', 'aihub-core' ),
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
				'selectors_dictionary' => [
					'start' => 'inset-inline-end: auto;',
					'end' => 'inset-inline-start: auto;',
				],
				'toggle' => false,
				'default' => 'end',
				'selectors' => [
					'{{WRAPPER}} .lqd-cart-dropdown-dropdown' => '{{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_offset_x',
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
					'{{WRAPPER}} .lqd-cart-dropdown-dropdown' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dropdown_orientation_h' => 'start'
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_offset_x_end',
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
					'{{WRAPPER}} .lqd-cart-dropdown-dropdown' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dropdown_orientation_h' => 'end'
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_orientation_v',
			[
				'label' => esc_html__( 'Dropdown vertical orientation', 'aihub-core' ),
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
				'selectors_dictionary' => [
					'top' => 'bottom: auto;',
					'bottom' => 'top: auto;',
				],
				'toggle' => false,
				'default' => 'top',
				'selectors' => [
					'{{WRAPPER}} .lqd-cart-dropdown-dropdown' => '{{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_offset_y',
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
					'{{WRAPPER}} .lqd-cart-dropdown-dropdown' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dropdown_orientation_v' => 'top',
				]
			]
		);

		$this->add_responsive_control(
			'dropdown_offset_y_bottom',
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
					'{{WRAPPER}} .lqd-cart-dropdown-dropdown' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dropdown_orientation_v' => 'bottom',
				]
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'cart-dropdown',
			[
				'dropdown' => [
					'controls' => [
						[
							'type' => 'padding',
							'selector' => '.lqd-cart-dropdown-inner'
						],
						[
							'type' => 'liquid_background_css',
							'selector' => '.lqd-cart-dropdown-inner'
						],
						[
							'type' => 'border',
							'selector' => '.lqd-cart-dropdown-inner'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
						],
					],
					'plural_heading' => false,
				],
				'counter' => [
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
							'type' => 'liquid_linked_dimensions',
						],
						[
							'type' => 'liquid_color',
							'types' => [ 'solid' ]
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
				],
				'product' => [
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
							'types' => [ 'solid' ]
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
				],
				'product_image' => [
					'controls' => [
						[
							'type' => 'margin',
						],
						[
							'type' => 'padding',
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
				],
				'product_price' => [
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
							'types' => [ 'solid' ]
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
				],
				'foot' => [
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
							'types' => [ 'solid' ]
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
				],
				'total' => [
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
							'types' => [ 'solid' ]
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
				],
				'total_label' => [
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
							'types' => [ 'solid' ]
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
				],
				'total_price' => [
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
							'types' => [ 'solid' ]
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
				],
				'btn_checkout' => [
					'label' => 'Checkout button',
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
							'types' => [ 'solid' ]
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
				],
				'btn_cart' => [
					'label' => 'Cart button',
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
							'types' => [ 'solid' ]
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
				],
			],
		);

		\LQD_Elementor_Trigger::register_controls( $this, 'ib_', '', 'Cart' );

	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$dropdown_classname = [ 'lqd-dropdown', 'lqd-cart-dropdown-dropdown', 'lqd-togglable-element', 'hidden', 'flex-col', 'overflow-hidden', 'absolute', 'top-full', 'end-0', 'z-99' ];

		$this->add_render_attribute( 'dropdown', [
			'class' => $dropdown_classname
		] );

		?>

		<div class="lqd-cart-dropdown-trigger-container flex items-center">
			<?php \LQD_Elementor_Trigger::render( $this, 'ib_' ); ?>
			<?php if ( $settings['show_counter'] === 'yes' ) : ?>
			<span class="lqd-cart-dropdown-counter inline-flex items-center justify-center ms-8 shrink-0"><?php echo $order_count = WC()->cart->get_cart_contents_count(); ?></span>
			<?php endif; // if show_counter ?>
		</div>
		<div <?php $this->print_render_attribute_string( 'dropdown' ) ?>>
			<div class="lqd-cart-dropdown-inner rounded-inherit overflow-y-auto">
				<?php liquid_woocommerce_header_cart() ?>
			</div>
		</div>
		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LD_Cart_Dropdown() );