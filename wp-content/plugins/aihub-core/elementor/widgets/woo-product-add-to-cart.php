<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Add_To_Cart extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-add-to-cart';
	}

	public function get_title() {
		return __( 'Liquid Product Add to Cart', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-add-to-cart lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'cart' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wc_atc_product_button_typo',
				'label' => __( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} div.product .btn',
			]
		);

		$this->start_controls_tabs(
			'wc_atc_product_button_colors_tab'
		);

		$this->start_controls_tab(
			'wc_atc_product_button_colors_normal',
			[
				'label' => __( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_control(
			'wc_atc_product_button_color',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product form.cart button.button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wc_atc_product_button_bg',
				'label' => __( 'Background', 'aihub-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} div.product form.cart button.button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wc_atc_product_button_border',
				'label' => __( 'Border', 'aihub-core' ),
				'selector' => '{{WRAPPER}} div.product form.cart button.button',
			]
		);

		$this->add_responsive_control(
			'wc_atc_product_button_border_radius',
			[
				'label' => __( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} div.product form.cart button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wc_atc_product_button_box_shadow',
				'label' => __( 'Box shadow', 'aihub-core' ),
				'selector' => '{{WRAPPER}} div.product form.cart button.button',
			]
		);

		$this->add_responsive_control(
			'wc_atc_product_button_padding',
			[
				'label' => __( 'Padding', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} div.product form.cart button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'wc_atc_product_button_colors_hover',
			[
				'label' => __( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_control(
			'wc_atc_product_button_color_hover',
			[
				'label' => __( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product form.cart button.button:hover, {{WRAPPER}} div.product form.cart button.button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wc_atc_product_button_bg_hover',
				'label' => __( 'Background', 'aihub-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} div.product form.cart button.button:hover, {{WRAPPER}} div.product form.cart button.button:focus',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wc_atc_product_button_border_hover',
				'label' => __( 'Border', 'aihub-core' ),
				'selector' => '{{WRAPPER}} div.product form.cart button.button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wc_atc_product_button_box_shadow_hover',
				'label' => __( 'Box shadow', 'aihub-core' ),
				'selector' => '{{WRAPPER}} div.product form.cart button.button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Quantity
		$this->add_control(
			'wc_atc_qty_heading',
			[
				'label' => esc_html__( 'Quantity', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wc_atc_qty_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product div.quantity .ui-spinner, {{WRAPPER}} div.quantity .ui-button-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

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

		// check
		if( !liquid_helper()->is_woocommerce_active() ) {
			return;
		}

		global $product;
		$product = wc_get_product();

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			?>
			<div class="woocommerce">
				<div class="product" style="padding:0">
					<div class="lqd-woo-single-layout-2">
						<div class="product product-layout-component lqd-product-add-to-cart">
							<form class="cart" action="#" method="post" enctype="multipart/form-data">
								<div class="quantity">
									<label class="screen-reader-text" for="quantity_60e450863fd46"><?php echo esc_html('Quantity', 'woocommerce'); ?></label>
									<span class="ui-spinner ui-corner-all ui-widget ui-widget-content" style="height: 85.4px;"><input type="number" id="quantity_60e450863fd46" class="input-text qty text spinner ui-spinner-input" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" aria-valuemin="1" aria-valuenow="1" autocomplete="off" role="spinbutton"><a tabindex="-1" aria-hidden="true" class="ui-button ui-widget ui-spinner-button ui-spinner-up ui-corner-tr ui-button-icon-only" role="button"><span class="ui-button-icon ui-icon ui-icon-triangle-1-n"></span><span class="ui-button-icon-space"> </span></a><a tabindex="-1" aria-hidden="true" class="ui-button ui-widget ui-spinner-button ui-spinner-down ui-corner-br ui-button-icon-only" role="button"><span class="ui-button-icon ui-icon ui-icon-triangle-1-s"></span><span class="ui-button-icon-space"> </span></a></span>
								</div>
								<button type="submit" name="add-to-cart" value="0" class="single_add_to_cart_button lqd-btn inline-flex items-center justify-center pt-20 pb-20 ps-10 pe-10">
									<span class="lqd-btn-txt"><?php echo esc_html('Add to cart', 'woocommerce');?></span>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php
		} else {
			if ( empty( $product ) ) { return; }
			?>
			<div class="lqd-woo-single-layout-2">
				<div class="product product-layout-component lqd-product-add-to-cart">
					<?php

					$add_to_cart_ajax_enable = liquid_helper()->get_kit_option( 'liquid_wc_add_to_cart_ajax_enable' );
					if( 'on' === $add_to_cart_ajax_enable ) {
						add_action('woocommerce_after_add_to_cart_button', function(){
							printf( '<input type="hidden" class="lqd-product-name" value="%s" />', get_the_title() );
						});
					}

					woocommerce_template_single_add_to_cart();

					?>
				</div>
			</div>
			<?php
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Add_To_Cart() );