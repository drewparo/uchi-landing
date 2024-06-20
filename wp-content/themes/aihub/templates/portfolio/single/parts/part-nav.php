<?php

global $post;

$prev_post_obj   = get_adjacent_post( false, '', true, 'liquid-portfolio-category' );
$prev_post_ID    = isset( $prev_post_obj->ID ) ? $prev_post_obj->ID : '';
$prev_post_link  = get_permalink( $prev_post_ID );
$prev_post_title = get_the_title( $prev_post_ID );

$next_post_obj   = get_adjacent_post( false, '', false, 'liquid-portfolio-category' );
$next_post_ID    = isset( $next_post_obj->ID ) ? $next_post_obj->ID : '';
$next_post_link  = get_permalink( $next_post_ID );
$next_post_title = get_the_title( $next_post_ID );

?>

<div class="lqd-pf-meta-nav lqd-pf-meta-nav-classic flex items-center justify-between">

	<?php if( $prev_post_ID ): ?>
	<a href="<?php echo esc_url( $prev_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-prev flex items-center">
		<svg class="w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#lqd-icon-chevron-left" /></svg>
		<span class="ml-3 flex flex-col">
			<span class="lqd-pf-nav-link-subtitle"><?php esc_html_e( 'Previous', 'aihub' ); ?></span>
			<span class="lqd-pf-nav-link-title"><?php echo esc_html( $prev_post_title ); ?></span>
		</span>
	</a>
	<?php endif; ?>

	<?php if( function_exists( 'liquid_portfolio_archive_link' ) ) { ?>
		<?php echo liquid_portfolio_archive_link(); ?>
	<?php } ?>

	<?php if( $next_post_ID ): ?>
	<a href="<?php echo esc_url( $next_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-next flex flex-row-reverse items-center text-right text-sm-left">
		<svg class="w-auto max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#lqd-icon-chevron-right" /></svg>
		<span class="mr-3 flex flex-col">
			<span class="lqd-pf-nav-link-subtitle"><?php esc_html_e( 'Next', 'aihub' ); ?></span>
			<span class="lqd-pf-nav-link-title"><?php echo esc_html( $next_post_title ); ?></span>
		</span>
	</a>
	<?php endif; ?>

</div>