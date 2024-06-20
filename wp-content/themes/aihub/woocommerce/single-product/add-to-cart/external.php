<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
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

liquid_product_size_guide();
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" action="<?php echo esc_url( $product_url ); ?>" method="get">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<button type="submit" class="lqd-btn lqd-btn-icon-start inline-flex items-center justify-center pt-16 pb-16 ps-10 pe-10 <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" >
        <span class="lqd-btn-txt"><?php echo esc_html( $button_text ); ?></span>
        <span class="lqd-btn-icon -order-1"><svg class="w-auto" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 7h13.79a2 2 0 0 1 1.99 2.199l-.6 6A2 2 0 0 1 18.19 17H8.64a2 2 0 0 1-1.962-1.608L5 7z"/><path d="M5 7l-.81-3.243A1 1 0 0 0 3.22 3H2"/><path d="M8 21h2"/><path d="M16 21h2"/></svg></span>
    </button>

	<?php wc_query_string_form_fields( $product_url ); ?>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
