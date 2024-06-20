<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
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

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart grouped_form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'  data-product_id="<?php echo $product->get_id() ?>" data-product_sku="<?php echo $product->get_sku() ?>">
	<table cellspacing="0" class="woocommerce-grouped-product-list group_table">
		<tbody>
			<?php
			$quantites_required      = false;
			$previous_post           = $post;
			$grouped_product_columns = apply_filters(
				'woocommerce_grouped_product_columns',
				array(
					'quantity',
					'label',
					'price',
				),
				$product
			);
			$show_add_to_cart_button = false;

			do_action( 'woocommerce_grouped_product_list_before', $grouped_product_columns, $quantites_required, $product );

			foreach ( $grouped_products as $grouped_product_child ) {
				$post_object        = get_post( $grouped_product_child->get_id() );
				$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
				$post               = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $post );

				if ( $grouped_product_child->is_in_stock() ) {
					$show_add_to_cart_button = true;
				}

				echo '<tr id="product-' . esc_attr( $grouped_product_child->get_id() ) . '" class="woocommerce-grouped-product-list-item ' . esc_attr( implode( ' ', wc_get_product_class( '', $grouped_product_child ) ) ) . '">';

				// Output columns for each product.
				foreach ( $grouped_product_columns as $column_id ) {
					do_action( 'woocommerce_grouped_product_list_before_' . $column_id, $grouped_product_child );

					switch ( $column_id ) {
						case 'quantity':
							ob_start();

							if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
								woocommerce_template_loop_add_to_cart();
							} elseif ( $grouped_product_child->is_sold_individually() ) {
								echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" />';
							} else {
								do_action( 'woocommerce_before_add_to_cart_quantity' );

								woocommerce_quantity_input(
									array(
										'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
										'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Missing
										'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
										'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
										'placeholder' => '0',
									)
								);

								do_action( 'woocommerce_after_add_to_cart_quantity' );
							}

							$value = ob_get_clean();
							break;
						case 'label':
							$value  = '<label for="product-' . esc_attr( $grouped_product_child->get_id() ) . '">';
							$value .= $grouped_product_child->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', $grouped_product_child->get_permalink(), $grouped_product_child->get_id() ) ) . '">' . $grouped_product_child->get_name() . '</a>' : $grouped_product_child->get_name();
							$value .= '</label>';
							break;
						case 'price':
							$value = $grouped_product_child->get_price_html() . wc_get_stock_html( $grouped_product_child );
							break;
						default:
							$value = '';
							break;
					}

					echo '<td class="woocommerce-grouped-product-list-item__' . esc_attr( $column_id ) . '">' . apply_filters( 'woocommerce_grouped_product_list_column_' . $column_id, $value, $grouped_product_child ) . '</td>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

					do_action( 'woocommerce_grouped_product_list_after_' . $column_id, $grouped_product_child );
				}

				echo '</tr>';
			}
			$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );

			do_action( 'woocommerce_grouped_product_list_after', $grouped_product_columns, $quantites_required, $product );
			?>
		</tbody>
	</table>

	<?php liquid_product_size_guide(); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

	<?php if ( $quantites_required && $show_add_to_cart_button ) : ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<button type="submit" class="add_to_cart_button ajax_add_to_cart single_add_to_cart_button lqd-btn lqd-btn-icon-start inline-flex items-center justify-center grow pt-16 pb-16 ps-10 pe-10 transition-all <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
            <span class="lqd-btn-txt inline-flex items-center">
                <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                <svg class="lqd-loading-spinner ms-10 w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#lqd-loading-spinner" /></svg>
                <svg class="lqd-job-done hidden ms-10 w-auto max-h-1em text-percent-115" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12l6 6L20 6"/><use xlink:href="#lqd-icon-check" /></svg>
            </span>
            <span class="lqd-btn-icon -order-1"><svg class="w-auto" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 7h13.79a2 2 0 0 1 1.99 2.199l-.6 6A2 2 0 0 1 18.19 17H8.64a2 2 0 0 1-1.962-1.608L5 7z"/><path d="M5 7l-.81-3.243A1 1 0 0 0 3.22 3H2"/><path d="M8 21h2"/><path d="M16 21h2"/></svg></span>
        </button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>