<?php
/**
 * The template for displaying all single posts.
 *
 * @package Hub
 */

$sp_style = liquid_helper()->get_page_option( 'post_style' );
$sp_style = $sp_style ? $sp_style : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_post_style' );
$style = $sp_style ? $sp_style : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_post_style' );

if( 'classic' == $sp_style || empty( $sp_style ) ) {
	add_action( 'liquid_before_single_article_content', 'liquid_get_single_media', 5 );
}
elseif( 'classic' !== $sp_style && !empty( $sp_style ) ) {
	add_action( 'liquid_before_single_article', 'liquid_get_single_media', 5 );
}

get_header();

	while ( have_posts() ) : the_post();

		//if empty style get default
		if( !$style ) {
			$style = 'minimal';
		}

		$format = get_post_format();
		if( 'video' === $format && defined( 'LQD_CORE_VERSION' ) ){
			$style = 'classic';
		}
		elseif( 'audio' === $format && defined( 'LQD_CORE_VERSION' ) ){
			$style = 'minimal';
		}
		get_template_part( 'templates/blog/single/classic' );

	endwhile;

get_footer();