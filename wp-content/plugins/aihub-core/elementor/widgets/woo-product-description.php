<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Product_Description extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-product-description';
	}

	public function get_title() {
		return __( 'Liquid Product Description', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-product-description lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'description', 'product' ];
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
			'wc_desc_short_description_heading',
			[
				'label' => esc_html__( 'Short Description', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wc_desc_short_description_typography',
				'label' => esc_html__('Typography', 'aihub-core'),
				'selector' => '{{WRAPPER}} p',
			]
		);

		$this->add_control(
			'wc_desc_short_description_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p' => 'color: {{VALUE}}',
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
		<div class="product product-layout-component lqd-product-description">
			<?php 
			if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
				?><p>This is a simple product.</p><?php
			} else {
				if ( empty( $product ) ) { return; }
				woocommerce_template_single_excerpt(); 
			}
			?>
		</div>

		<?php
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Product_Description() );