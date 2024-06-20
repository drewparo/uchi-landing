<?php

$atts = explode("\n", str_replace("\r", "", liquid_helper()->get_page_option( 'portfolio_attributes' )));

if( isset( $atts ) && !is_array( $atts ) ) {
	return;
}

foreach ( $atts as $attr ) {

	if( !empty( $attr ) ) {
		$attr = explode( "|", $attr );
		$label = isset( $attr[0] ) ? $attr[0] : '';
		$value = isset( $attr[1] ) ? $attr[1] : $label;

		echo '<div class="lqd-pf-single-meta-part">';
		if( $label ) {
			echo '<p class="mt-0 mb-0">' . esc_html( $label ) . '</p>';
		}
		echo '<p class="mt-0 mb-0">'. do_shortcode( $value ) . '</p>';
		echo '</div>';
	}

}
