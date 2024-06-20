<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Meta extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-meta';
	}

	public function get_title() {
		return __( 'Liquid Product Meta', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-meta lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'meta', 'product' ];
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
				'name' => 'wc_meta_typography',
				'label' => esc_html__('Typography', 'aihub-core'),
				'selector' => '{{WRAPPER}} .product_meta',
			]
		);

		$this->add_control(
			'wc_meta_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .product_meta' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_meta_link_color',
			[
				'label' => esc_html__( 'Link Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product_meta a, {{WRAPPER}} div.product .product_meta > span span' => 'color: {{VALUE}}',
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
					<div class="product product-layout-component lqd-product-meta">
						<div class="product_meta product-meta">
							<span class="sku_wrapper">SKU: <span class="sku" itemprop="sku">PID1234</span></span>
						</div>
					</div>
				</div>
			</div>
			<?php
		} else {
			if ( empty( $product ) ) { return; }
			?>
			<div class="product product-layout-component lqd-product-meta">
				<?php woocommerce_template_single_meta(); ?>
			</div>
			<?php
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Meta() );