<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$loading_spinner = '<svg class="lqd-loading-spinner ms-10 w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#lqd-loading-spinner" /></svg>';
$check_icon = '<svg class="lqd-job-done hidden ms-10 w-auto max-h-1em text-percent-115" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12l6 6L20 6"/><use xlink:href="#lqd-icon-check" /></svg>';

$cart_text = '<span class="lqd-btn-txt inline-flex items-center">' . esc_html( $product->add_to_cart_text() ) . $loading_spinner . $check_icon . '</span>';
$cart_icon = '<span class="lqd-btn-icon -order-1"><svg class="w-auto" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 7h13.79a2 2 0 0 1 1.99 2.199l-.6 6A2 2 0 0 1 18.19 17H8.64a2 2 0 0 1-1.962-1.608L5 7z"/><path d="M5 7l-.81-3.243A1 1 0 0 0 3.22 3H2"/><path d="M8 21h2"/><path d="M16 21h2"/></svg></span>';
$button_classname = 'lqd-add-to-cart-btn lqd-btn lqd-btn-icon-start inline-flex items-center justify-center grow pt-16 pb-16 ps-10 pe-10 transition-all';

// excluding 'button' classname to avoid styling mess coming from woo
if ( isset( $args['class'] ) ) {
    $class = implode(
        ' ',
        array_filter(
            explode( ' ', $args['class'] ),
            function($cls) {
                return $cls !== 'button';
            }
        )
    );
    $button_classname .= ' ' . $class;
}

echo apply_filters( 'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf( '<a href="%1$s" data-quantity="%2$s" class="%3$s" %4$s>%5$s%6$s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( $button_classname ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		$cart_text,
        $cart_icon
	),
$product, $args );