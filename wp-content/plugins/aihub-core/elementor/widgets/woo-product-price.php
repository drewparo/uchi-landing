<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Price extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-price';
	}

	public function get_title() {
		return __( 'Liquid Product Price', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-price lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'price', 'product' ];
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
				'name' => 'wc_price_typography',
				'label' => esc_html__('Typography', 'aihub-core'),
				'selector' => '{{WRAPPER}} div.product p.price',
			]
		);

		$this->add_control(
			'wc_price_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product p.price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

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
					<div class="product product-layout-component lqd-product-price">
						<p class="price m-0"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>8.99</bdi></span></p>
					</div>
				</div>
			</div>
			<?php
		} else {
			if ( empty( $product ) ) { return; }
			?>
			<div class="product product-layout-component lqd-product-price">
				<?php woocommerce_template_single_price(); ?>
			</div>
			<?php
		}
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Price() );