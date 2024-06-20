<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
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

wc_print_notices();

/**
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
		<a class="lqd-btn lqd-btn-icon-start pt-16 pb-16 ps-20 pe-20 inline-flex items-center bg-primary justify-center text-center text-white text-16 font-semibold continue_shopping transition-all <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
            <?php
                /**
                 * Filter "Return To Shop" text.
                 *
                 * @since 4.6.0
                 * @param string $default_text Default text.
                 */
                echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'aihub' ) ) );
            ?>
            <span class="lqd-btn-icon -order-1">
                <svg class="w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5l-7 7 7 7"/><path d="M4 12h16"/></svg>
            </span>
		</a>
	</p>
<?php endif; ?>