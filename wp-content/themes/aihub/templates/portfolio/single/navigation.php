<?php

$prev_post = get_adjacent_post( true, '', true, 'liquid-portfolio-category' );
$next_post = get_adjacent_post( true, '', false, 'liquid-portfolio-category' );

$style = liquid_helper()->get_page_option( 'portfolio_style' );
$style = $style ? $style : 'gallery-stacked';

$attributes = array(
	'class' => 'portfolio-nav ',
);

if( in_array( $style, array( 'gallery-stacked-4' ) ) ) {
	$attributes['class'] = 'portfolio-nav bordered mb-50';
}

if( in_array( $style, array( 'gallery-slider', 'gallery-stacked-4', 'gallery-stacked-5', 'gallery-stacked-6', 'featured-image' ) ) ) {
	$attributes['style'] = 'background-color: #fff;';
}
?>
<nav class="post-nav pf-nav flex flex-row justify-between items-center mt-32 mb-0 pb-8">


	<div class="nav-previous">
		<?php if( $prev_post ): ?>
		<a href="<?php echo get_permalink( $prev_post ) ?>" rel="prev">
			<span class="screen-reader-text"><?php esc_html_e( 'Previous Work', 'aihub' ) ?></span>
			<span aria-hidden="true" class="nav-subtitle capitalize tracking-0">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="none" stroke="#444" stroke-width="2" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve" width="24" height="24">
					<g>
						<line stroke-miterlimit="10" x1="22" y1="12" x2="2" y2="12" stroke-linejoin="miter" stroke-linecap="butt"></line>
						<polyline stroke-linecap="square" stroke-miterlimit="10" points="9,19 2,12 9,5 " stroke-linejoin="miter"></polyline>
					</g>
				</svg>
				<?php esc_html_e( 'Previous Work', 'aihub' ) ?>
			</span>
		</a>
		<?php endif; ?>
	</div>

	<div class="nav-next">
		<?php if( $next_post ): ?>
		<a href="<?php echo get_permalink( $next_post ) ?>" rel="next">
			<span class="screen-reader-text"><?php esc_html_e( 'Next Work', 'aihub' ); ?></span>
			<span aria-hidden="true" class="nav-subtitle capitalize tracking-0">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="none" stroke="#444" stroke-width="2" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve" width="24" height="24">
					<g transform="rotate(180 12,12) ">
						<line stroke-miterlimit="10" x1="22" y1="12" x2="2" y2="12" stroke-linejoin="miter" stroke-linecap="butt"></line>
						<polyline stroke-linecap="square" stroke-miterlimit="10" points="9,19 2,12 9,5 " stroke-linejoin="miter"></polyline>
					</g>
				</svg>
				<?php esc_html_e( 'Next Work', 'aihub' ); ?>
			</span>
		</a>
		<?php endif; ?>
	</div>

</nav>