<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Rating extends Widget_Base {

	public function get_name() {
		return 'ld-woo-product-rating';
	}

	public function get_title() {
		return __( 'Liquid Product Rating', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-rating lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'rating', 'product' ];
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
			'wc_starts_colors',
			[
				'label' => esc_html__( 'Stars Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product .star-rating' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wc_starts_text_colors',
			[
				'label' => esc_html__( 'Text Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.product a' => 'color: {{VALUE}}',
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
						<div class="woocommerce-product-rating">
							<div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
								<span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
							</div>
							<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<span class="count">2</span> customer reviews)</a>
						</div>
					</div>
				</div>
			</div>
			<?php
		} else {
			if ( empty( $product ) ) { return; }
			?>
			<div class="product product-layout-component lqd-product-price">
				<?php woocommerce_template_single_rating(); ?>
			</div>
			<?php
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Rating() );