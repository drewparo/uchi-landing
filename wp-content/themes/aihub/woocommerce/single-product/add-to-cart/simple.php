<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

if ( $product->is_in_stock() ) : ?>

	<?php liquid_product_size_guide(); ?>
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		) );

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="add_to_cart_button ajax_add_to_cart single_add_to_cart_button lqd-btn lqd-btn-icon-start inline-flex items-center justify-center grow pt-16 pb-16 ps-10 pe-10 transition-all <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" data-product_id="<?php echo $product->get_id() ?>" data-product_sku="<?php echo $product->get_sku() ?>">
            <span class="lqd-btn-txt inline-flex items-center">
                <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                <svg class="lqd-loading-spinner ms-10 w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#lqd-loading-spinner" /></svg>
                <svg class="lqd-job-done hidden ms-10 w-auto max-h-1em text-percent-115" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12l6 6L20 6"/><use xlink:href="#lqd-icon-check" /></svg>
            </span>
            <span class="lqd-btn-icon -order-1"><svg class="w-auto" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 7h13.79a2 2 0 0 1 1.99 2.199l-.6 6A2 2 0 0 1 18.19 17H8.64a2 2 0 0 1-1.962-1.608L5 7z"/><path d="M5 7l-.81-3.243A1 1 0 0 0 3.22 3H2"/><path d="M8 21h2"/><path d="M16 21h2"/></svg></span>
        </button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
