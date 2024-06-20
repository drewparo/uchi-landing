<?php
/**
 * The template for displaying Author bios
 */


$style = liquid_helper()->get_page_option( 'post_style' );
$style = $style ? $style : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_post_style' );
$post_author_box_enable = liquid_helper()->get_page_option( 'post_author_box_enable' );
$post_author_box_enable = $post_author_box_enable ? $post_author_box_enable : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_author_box_enable' );
$post_author_role_enable = liquid_helper()->get_page_option( 'post_author_role_enable' );
$post_author_role_enable = $post_author_role_enable ? $post_author_role_enable : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_author_role_enable' );

if( 'on' !==  $post_author_box_enable ) {
	return;
}

// Initialize needed variables
global $authordata;
$author_id = is_object( $authordata ) ? $authordata->ID : -1;

$author_view = 'classic';

if( 'minimal' == $style ) {
	$author_view = 'img-overlay';
}

?>

<div class="post-author post-author-<?php echo sanitize_html_class( $author_view ); ?>">

	<figure>
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
	</figure>

	<?php if ( $author_view === 'img-overlay' ) : ?>

		<h6><?php esc_html_e( 'About the Author', 'aihub' ) ?></h6>
		<h3><?php liquid_author_link( array( 'before' => '', ) ); ?></h3>

	<?php endif; ?>

	<div class="post-author-info">

		<?php if ( $author_view === 'classic' ) : ?>
		<div class="flex items-center justify-between post-author-info-head">
			<div>
				<h3><?php liquid_author_link( array( 'before' => '', ) ); ?></h3>
				<?php if( 'on' === $post_author_role_enable ) { ?>
					<h6><?php echo liquid_author_role() ?></h6>
				<?php } ?>
			</div>
			<div>
				<a class="author-all-posts" href="<?php echo esc_url( get_author_posts_url( $authordata->ID ) ); ?>"><?php esc_html_e( 'See author’s other posts', 'aihub' ); ?> <i class="lqd-icn-ess icon-md-arrow-forward"></i></a>
			</div>
		</div>
		<?php endif; ?>

		<p><?php the_author_meta( 'description' ); ?></p>

	</div>
</div>