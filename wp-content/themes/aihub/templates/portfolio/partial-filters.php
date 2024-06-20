<?php

extract( $atts );

if( function_exists( 'ld_helper' ) ) {
	$filter_cats = ld_helper()->terms_are_ids_or_slugs( $filter_cats, 'liquid-portfolio-category' );
}

$terms = get_terms( array(
	'taxonomy'   => 'liquid-portfolio-category',
	'hide_empty' => false,
	'include'    => $filter_cats
) );

if( empty( $terms ) ) {
	return;
}

$wrapper_align = $filter_align;
if( !empty( $show_button ) ) {
	$wrapper_align = 'justify-between';
}

$filter_wrapper = array(
	'liquid-filter-items',
	'items-center',
	$wrapper_align,
);

$filter_classnames = array(
	'lqd-filter-list',
	'list-none',
	'p-0',
	'm-0',
	'filter-list',
	'filter-list-inline',
	$filter_color,
	$filter_size,
	$filter_decoration === 'filters-underline' || $filter_decoration === 'filters-underline' ? 'filter-list-decorated' : '',
	$filter_decoration,
	$filter_transformation,
	$filter_weight,
	'flex',
	'flex-wrap',
	'items-center'
);

$filter_title_classnames = array(
	'liquid-filter-items-label',
	$tag_to_inherite,
	$filter_title_size,
	$filter_title_weight,
	$filter_title_transformation
);

?>
<div class="<?php echo join( ' ', $filter_wrapper ); ?>">
	<div class="lqd-filter liquid-filter-items-inner grow">

		<?php if( !empty( $filter_title ) ) { ?>
			<span class="<?php echo join( ' ', $filter_title_classnames ); ?>"><?php echo wp_kses_post( do_shortcode( $filter_title ) );  ?></span>
		<?php } ?>

		<ul class="<?php echo join( ' ', $filter_classnames ); ?> hidden-xs hidden-sm" id="<?php echo esc_attr( $filter_id ); ?>">
			<li class="lqd-filter-list-item me-16 active"><span class="lqd-filter-trigger lqd-reset-btn" data-lqd-filter-trigger="*"><?php echo esc_html( $filter_lbl_all ) ?></span></li>
			<?php foreach( $terms as $term ) {
				printf( '<li class="lqd-filter-list-item me-16"><span class="lqd-filter-trigger lqd-reset-btn" data-lqd-filter-trigger="%s">%s</span></li>', $term->slug, $term->name );
			} ?>
		</ul>

		<div class="lqd-filter-dropdown visible-xs visible-sm" data-form-options='{ "dropdownAppendTo": "self" }'>
			<select name="lqd-filter-dropdown-<?php echo esc_attr( $filter_id ); ?>" id="lqd-filter-dropdown-<?php echo esc_attr( $filter_id ); ?>">
				<option selected data-filter="*" value="*"><?php echo esc_html( $filter_lbl_all ) ?></option>
				<?php foreach( $terms as $term ) {
					printf( '<option data-lqd-filter-trigger=".%s" value=".%s">%s</option>', $term->slug, $term->slug, $term->name  );
				} ?>
			</select>
		</div>

		<?php $this->get_button()  ?>

	</div>
</div>