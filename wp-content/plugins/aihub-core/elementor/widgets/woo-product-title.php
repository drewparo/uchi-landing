<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Title extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-title';
	}

	public function get_title() {
		return __( 'Liquid Product Title', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-title lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'title', 'product' ];
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
				'name' => 'wc_product_title_title_typography',
				'label' => esc_html__('Typography', 'aihub-core'),
				'selector' => '{{WRAPPER}} .product_title',
			]
		);

		$this->add_control(
			'wc_product_title_title_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product_title' => 'color: {{VALUE}}',
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

		?>

		<div class="product product-layout-component lqd-product-title">
			<?php 
				if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
					?><div class="woocommerce"><div class="product" style="padding:0"><h1 itemprop="name" class="product_title entry-title">Product Title</h1></div></div><?php
				} else {
					if ( empty( $product ) ) { return; }
					woocommerce_template_single_title();
				}
			?>
		</div>

		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Title() );