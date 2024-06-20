<?php

if( is_singular( 'post' ) ) {
    return;
}

$classes = array(
	'lqd-titlebar',
);
$column_classname = '';

if( !class_exists( 'Liquid_Addons' ) ) {
	$classes[] = 'lqd-titlebar-default mb-60';
}

$titlebar_bg_woo = $titlebar_bg_woo_url = $style_inline = '';
if( class_exists( 'WooCommerce' ) && ( is_product_taxonomy() || is_product_category() ) ) {
	$titlebar_bg_woo    = get_term_meta( get_queried_object_id(), 'thumbnail_id', true );
	$titlebar_bg_woo_url = wp_get_attachment_url( $titlebar_bg_woo );
	if( !empty( $titlebar_bg_woo_url ) ) {
		$style_inline = 'style="background-image:url( ' . esc_url( $titlebar_bg_woo_url ) . ');"';
	}

}

// Heading and subheading
$heading = $subheading = '';
if( !class_exists( 'Liquid_Addons' ) && is_home() ) {
	$heading = esc_html__( 'Blog', 'aihub' );
	$subheading = '';
}
elseif( is_search() ) {
	$heading = sprintf( esc_html__( 'Search Results for: %s', 'aihub' ), '<span>' . get_search_query() . '</span>' );
	$subheading = '';
}
elseif( class_exists( 'WooCommerce' ) && ( is_product_taxonomy() || is_product_category() ) ) {
	$heading = single_cat_title( '', false );
	$category_description = category_description();
	$subheading = ! empty( $category_description ) ? $category_description : '';
}
elseif( is_category() ) {
	$heading = single_cat_title( '', false );
	$category_description = category_description();
	$subheading = ! empty( $category_description ) ? $category_description : '';
}
elseif( is_tag() ) {
	$heading = single_tag_title( '', false ) ;
	$tag_description = tag_description();
	$subheading = ! empty( $tag_description ) ? $tag_description : '';
}
elseif( is_author() ) {
	$heading = get_the_author();
	$subheading = '';
}
elseif( is_archive() ) {
	$heading = esc_html__( 'Archive', 'aihub' );
	$subheading = '';
}
$heading = $heading ? $heading : get_the_title();

if ( empty( $heading ) && empty( $subheading ) ) {
    return;
}

if ( class_exists('WooCommerce') ){
	$breadcrumb_args = array(
		'wrap_before' => '<div class="lqd-shop-topbar-breadcrumb"><nav class="woocommerce-breadcrumb mb-24 mobile-extra:mb-0"><ul class="breadcrumb flex flex-wrap items-center list-none p-0 m-0 comma-sep-li">',
		'wrap_after'  => '</ul></nav></div>'
	);
}

if ( isset( $align) ) {

	if ( $align === 'lqd-titlebar-split' ) {
		$column_classname = 'w-6/12';
	} else if ( $align === 'text-center' ) {
		$column_classname = 'mx-auto tablet:w-6/12 mobile-extra:w-8/12';
	} else {
		$column_classname = 'w-full';
	}

}

?>
<div class="<?php echo join( ' ', $classes ) ?>" <?php echo apply_filters( 'liquid_titlebar_style_inline', $style_inline ); ?>>

	<?php liquid_action( 'header_titlebar' ); ?>
	<div class="lqd-titlebar-inner">
		<div class="lqd-container lqd-titlebar-container ms-auto me-auto">
			<div class="flex flex-wrap items-center">

				<div class="lqd-titlebar-col mobile-extra:w-full <?php echo esc_attr($column_classname) ?>">

					<h1 class="m-0"><?php echo wp_kses( $heading, 'lqd_post' ); ?></h1>
					<?php echo wp_kses( $subheading, 'lqd_post' ); ?>

				</div>

			</div>
		</div>
	</div>
</div>