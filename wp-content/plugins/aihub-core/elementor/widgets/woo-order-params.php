<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Woo_Order_Params extends Widget_Base {

	public function get_name() {
		return 'lqd-woo-order-params';
	}

	public function get_title() {
		return __( 'Liquid Woo Order Params', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-purchase-summary lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-woo' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'cart', 'order', 'summary', 'purchase' ];
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
			'note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'This widget is working with "Custom Thank You Page" only. Manage your custom page from: WooCommerce > Settings > Advanced > Custom thank you page', 'aihub-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'param',
			[
				'label' => esc_html__( 'Select Param', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'number',
				'options' => [
					'number'  => esc_html__( 'Order Number', 'aihub-core' ),
					'date' => esc_html__( 'Order Date', 'aihub-core' ),
					'total' => esc_html__( 'Order Total', 'aihub-core' ),
					'email' => esc_html__( 'Billing Email', 'aihub-core' ),
					'payment' => esc_html__( 'Payment Method', 'aihub-core' ),
					'thankyou' => esc_html__( 'Thank You Message', 'aihub-core' ),
					'detail_table' => esc_html__( 'Detail Table', 'aihub-core' ),
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$order = isset( $_GET['key'] ) ? new \WC_Order( wc_get_order_id_by_order_key( $_GET['key'] ) ) : '';


		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() || ( class_exists( 'WooCommerce' ) && ! is_checkout() ) ){

			$content = '<div class="woocommerce-order-received"><div class="woocommerce"><div class="woocommerce-order">';

			switch( $this->get_settings_for_display( 'param' ) ){
				
				case 'number':
					$content .= '123';
					break;
				case 'date':
					$content .= date(get_option('date_format'));
					break;
				case 'email':
					$content .= get_option('admin_email');
					break;
				case 'total':
					$content .= '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>18.00</span>';
					break;
				case 'payment':
					$content .= 'Pay with cash upon delivery.';
					break;
				case 'thankyou':
					$content .= apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'hub' ), null );
					break;
				case 'detail_table':
					$content .= '<section class="woocommerce-order-details"><h2 class="woocommerce-order-details__title">Order details</h2><table class="woocommerce-table woocommerce-table--order-details shop_table order_details"><thead><tr><th class="woocommerce-table__product-name product-name">Product</th><th class="woocommerce-table__product-table product-total">Total</th></tr></thead><tbody><tr class="woocommerce-table__line-item order_item"><td class="woocommerce-table__product-name product-name"><a href="#">T-Shirt with Logo</a><strong class="product-quantity">×&nbsp;1</strong></td><td class="woocommerce-table__product-total product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></td></tr></tbody><tfoot><tr><th scope="row">Subtotal:</th><td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>18.00</span></td></tr><tr><th scope="row">Payment method:</th><td>Cash on delivery</td></tr><tr><th scope="row">Total:</th><td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>18.00</span></td></tr></tfoot></table></section><section class="woocommerce-customer-details"><h2 class="woocommerce-column__title">Billing address</h2><address>John Doe<br>tow, CA 12312-3123<p class="woocommerce-customer-details--phone">11111111111</p><p class="woocommerce-customer-details--email">' . get_option('admin_email') . '</p></address></section>';
					break;
			}

			echo $content . '</div></div></div>';

		} else {

			if ( $order ){

				switch( $this->get_settings_for_display( 'param' ) ){
					
					case 'number':
						$content = $order->get_order_number();
						break;
					case 'date':
						$content = wc_format_datetime( $order->get_date_created() );
						break;
					case 'email':
						$content = $order->get_billing_email();
						break;
					case 'total':
						$content = $order->get_formatted_order_total();
						break;
					case 'payment':
						$content = $order->get_payment_method_title();
						break;
					case 'thankyou':
						$content = apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'hub' ), null );
						break;
					case 'detail_table':
						$content = woocommerce_order_details_table( $order->get_id() );
						break;
				}

				echo $content;

			}
			
		}
	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Woo_Order_Params() );