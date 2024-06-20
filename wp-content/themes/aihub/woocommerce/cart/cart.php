<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>


<div class="lqd-woo-steps">
	<div class="lqd-woo-steps-inner">
		<div class="lqd-woo-steps-item is-active">
			<span class="lqd-woo-steps-number me-10"><?php esc_html_e( '1', 'aihub' ); ?></span>
			<span><?php esc_html_e( 'Shopping Cart', 'aihub' ); ?></span>
			<svg width="9" height="56" xmlns="http://www.w3.org/2000/svg" stroke="#e5e5e5" fill="none">
				<polyline points="0.5888671875,0.02734375 0.5888671875,20.145751923322678 7.5888671875,27.7603759765625 0.5888671875,35.53466796875 0.5888671875,55.9697265625 " />
			</svg>
		</div>

		<div class="lqd-woo-steps-item">
			<span class="lqd-woo-steps-number me-10"><?php esc_html_e( '2', 'aihub' ); ?></span>
			<span><?php esc_html_e( 'Payment and Delivery Options', 'aihub' ) ?></span>
			<svg width="9" height="56" xmlns="http://www.w3.org/2000/svg" stroke="#e5e5e5" fill="none">
				<polyline points="0.5888671875,0.02734375 0.5888671875,20.145751923322678 7.5888671875,27.7603759765625 0.5888671875,35.53466796875 0.5888671875,55.9697265625 " />
			</svg>
	</div>

	<div class="lqd-woo-steps-item">
		<span class="lqd-woo-steps-number me-10"><?php esc_html_e( '3', 'aihub' ); ?></span>
		<span><?php esc_html_e( 'Order Received', 'aihub' ); ?></span>
	</div>
	</div>
</div>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'aihub' ); ?> <?php echo '('.count(WC()->cart->get_cart()).')'; ?></th>
			<th class="product-price"><?php esc_html_e( 'Price', 'aihub' ); ?></th>
			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'aihub' ); ?></th>
			<th class="product-subtotal"><?php esc_html_e( 'Total', 'aihub' ); ?></th>
			<th class="product-remove"><?php esc_html_e( 'Remove', 'aihub' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'aihub' ); ?>">
						<span class="product-info flex items-center">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							} else {
								printf( '<a class="image" href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
						?>
						<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
							} else {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
							}

							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

							// Meta data
							echo wc_get_formatted_cart_item_data( $cart_item );

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'aihub' ) . '</p>' ) );
							}
						?>
						</span>
					</td>

					<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'aihub' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'aihub' ); ?>">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'     => $_product->get_max_purchase_quantity(),
									'min_value'   => '0',
									'product_name'  => $_product->get_name(),
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'aihub' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
					<td class="product-remove" data-title="<?php esc_attr_e( 'Remove', 'aihub' ); ?>">
						<?php
							// @codingStandardsIgnoreLine
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove remove_from_cart_button transition-all" title="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg class="w-auto max-h-1em text-percent-50" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20L4 4m16 0L4 20"/></svg></i></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_html__( 'Remove this item', 'aihub' ),
								esc_attr( $product_id ),
                                esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="3" class="cart-coupon">

				<span class="cart-coupon-inner">
					<?php if ( wc_coupons_enabled() ) { ?>
					<form class="checkout_coupon" method="post">
						<svg class="w-auto max-h-1em opacity-7s0 text-percent-125" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M8.707 3.293c-.39.39-.369 1.021-.138 1.523a2.83 2.83 0 0 1-3.753 3.753c-.502-.23-1.133-.252-1.523.138l-.586.586a1 1 0 0 0 0 1.414l10.586 10.586a1 1 0 0 0 1.414 0l.586-.586c.39-.39.369-1.021.138-1.523a2.83 2.83 0 0 1 3.753-3.753c.502.23 1.133.252 1.523-.138l.586-.586a1 1 0 0 0 0-1.414L10.707 2.707a1 1 0 0 0-1.414 0l-.586.586z"/></svg>
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'aihub' ); ?>" />
						<button type="submit" class="wc-forward apply_coupon lqd-btn pt-16 pb-16 ps-16 pe-16 flex items-center bg-primary justify-center text-center text-white text-16 font-semibold" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'aihub' ); ?>">
							<svg class="w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#lqd-icon-chevron-right" /></svg>
						</button>
					</form>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
					<?php } ?>
				</span>

			</td>
			<td colspan="5" class="actions">

				<div class="woo-actions-inner">

					<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="lqd-btn button continue_shopping transition-all">
						<span><?php esc_html_e( 'Continue Shopping', 'aihub' ); ?></span>
					</a>
					<button type="submit" class="lqd-btn button update_cart transition-all <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'aihub' ); ?>">
						<span><?php esc_html_e( 'Update cart', 'aihub' ); ?></span>
					</button>

				</div>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>

	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
