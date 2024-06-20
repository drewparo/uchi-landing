<?php

$style = liquid_helper()->get_page_option( 'post_style' );
$style = $style ? $style : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_post_style' );
$alt_image_src = isset(liquid_helper()->get_page_option( 'liquid_post_cover_style_image' )['id']) ? liquid_helper()->get_page_option( 'liquid_post_cover_style_image' )['id'] : '';
$enable_parallax = liquid_helper()->get_page_option( 'post_parallax_enable' );

global $post;

$style = !empty( $style ) ? $style : 'classic';
$cat_before_title = $header_post_excerpt = false;
$meta_in_header = true;

if( 'minimal' == $style ) {
	$cat_before_title = true;
	$header_post_excerpt = true;
	$meta_in_header = false;
}
elseif( 'classic' == $style || 'wide' == $style ) {
	$cat_before_title = true;
}

$figure_atts = $header_atts = array();

?>
<div class="lqd-post-cover overflow-hidden">

	<?php if ( get_post_format() === "video" ): ?>
		<?php liquid_portfolio_media(); ?>
	<?php else: ?>

	<?php if( has_post_thumbnail( $post->ID ) || isset( $alt_image_src ) && !empty( $alt_image_src ) ) { ?>
		<figure class="lqd-post-media relative" <?php echo implode( ' ', $figure_atts ); ?>>
		<?php
			if( isset( $alt_image_src ) && !empty( $alt_image_src ) ){
				echo wp_get_attachment_image( $alt_image_src, 'full' );
			}
			else {
				if( 'minimal' == $style ) {
					the_post_thumbnail( 'liquid-style3-sp', array( 'itemprop' => 'url' ) );
				}
				else {
					the_post_thumbnail( 'full', array( 'itemprop' => 'url' ) );
				}

			}
		?>
            <span class="inline-block w-full h-full absolute top-0 start-0 lqd-post-cover-overlay z-2"></span>
		</figure>
	<?php } ?>

	<?php endif; ?>

	<header class="lqd-post-header entry-header" <?php echo implode( ' ', $header_atts ); ?>>

		<?php if ( $cat_before_title ) : ?>
		<div class="entry-meta">
			<div class="cat-links">
				<span><?php esc_html_e( 'Published in:', 'aihub' ); ?></span>
				<?php liquid_get_category(); ?>
			</div>
		</div>
		<?php endif ?>

		<?php the_title( '<h1 class="entry-title mt-0 mb-0">', '</h1>' ) ?>

		<?php if ( $header_post_excerpt && has_excerpt() ) : ?>
			<p class="entry-excerpt"><?php echo get_the_excerpt(); ?></p>
		<?php endif; ?>

		<?php if ( $meta_in_header )
			get_template_part( 'templates/blog/single/part', 'meta' );
		?>
	</header>

	<?php if ( !$meta_in_header )
		get_template_part( 'templates/blog/single/part', 'meta' );
	?>
</div>