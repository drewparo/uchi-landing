<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Image extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-image';
	}

	public function get_title() {
		return __( 'Liquid Product Image', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-images lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'image', 'product' ];
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
			'heading',
			[
				'label' => __( 'You don\'t need to make any settings ', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
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
		<div class="product product-layout-component lqd-product-image">
			<?php 
			if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
				printf('<img src="%s" >', Utils::get_placeholder_image_src());
			} else {
				if ( empty( $product ) ) { return; }
				woocommerce_show_product_images();
			}
			?>
		</div>
		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Image() );