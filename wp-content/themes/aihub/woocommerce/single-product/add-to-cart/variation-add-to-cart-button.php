<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<?php liquid_product_size_guide(); ?>
<div class="woocommerce-variation-add-to-cart variations_button">

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

	<button type="submit" class="add_to_cart_button ajax_add_to_cart single_add_to_cart_button lqd-btn lqd-btn-icon-start inline-flex items-center justify-center grow pt-16 pb-16 ps-10 pe-10 transition-all <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" product_id="<?php echo $product->get_id() ?>" data-product_sku="<?php echo $product->get_sku() ?>">
        <span class="lqd-btn-txt inline-flex items-center">
            <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
            <svg class="lqd-loading-spinner ms-10 w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#lqd-loading-spinner" /></svg>
                <svg class="lqd-job-done hidden ms-10 w-auto max-h-1em text-percent-115" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12l6 6L20 6"/><use xlink:href="#lqd-icon-check" /></svg>
        </span>
        <span class="lqd-btn-icon -order-1"><svg class="w-auto" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 7h13.79a2 2 0 0 1 1.99 2.199l-.6 6A2 2 0 0 1 18.19 17H8.64a2 2 0 0 1-1.962-1.608L5 7z"/><path d="M5 7l-.81-3.243A1 1 0 0 0 3.22 3H2"/><path d="M8 21h2"/><path d="M16 21h2"/></svg></span>
    </button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
