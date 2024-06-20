<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Related extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-related';
	}

	public function get_title() {
		return __( 'Liquid Related Products', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-related lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'related', 'product' ];
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

	protected function get_woo_item() {
		$posts = get_posts(  array(
			'numberposts' => 1,
			'post_type'   => 'product'
		  ));
		  $postid;
		  foreach ( $posts as $post ) {
			$postid = $post->ID;
		  }
		  return $postid;
	}

	protected function render() {
		
		// check
		if( !liquid_helper()->is_woocommerce_active() ) {
			return;
		}

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
		global $product;
		$product = new \WC_Product( $this->get_woo_item() );
			?>
			<div class="woocommerce">
				<div class="product" style="padding:0">
					<div class="product product-layout-component lqd-product-related">
						<?php woocommerce_output_related_products(); ?>
					</div>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="product product-layout-component lqd-product-related">
				<?php woocommerce_output_related_products(); ?>
			</div>
			<?php
		}
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Related() );