<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Sharing extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-sharing';
	}

	public function get_title() {
		return __( 'Liquid Product Sharing', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-share lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'share', 'product' ];
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
			'wc_social_share_color',
			[
				'label' => esc_html__( 'Icon Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product.lqd-product-sharing a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_social_share_color_hover',
			[
				'label' => esc_html__( 'Icon Hover Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product.lqd-product-sharing a:hover' => 'color: {{VALUE}}',
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

		?>

		<div class="product product-layout-component lqd-product-sharing">
			<?php woocommerce_template_single_sharing(); ?>
		</div>

		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Sharing() );