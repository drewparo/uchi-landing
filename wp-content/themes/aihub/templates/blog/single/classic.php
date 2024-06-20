<?php  do_action( 'liquid_before_single_article' ); ?>

<?php do_action( 'liquid_start_single_post_container' ); ?>

<article <?php liquid_helper()->attr( 'post', array( 'class' => 'lqd-post-content relative' ) ) ?>>

	<div class="entry-content lqd-single-post-content clearfix relative">
		<?php do_action( 'liquid_before_single_article_content' ); ?>

		<?php
			the_content( sprintf(
				esc_html__( 'Continue reading %s', 'aihub' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
				) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'aihub' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'aihub' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>

	</div>
	<?php do_action( 'liquid_after_single_article_content' ); ?>

	<?php do_action( 'liquid_before_single_article_footer' ); ?>

	<?php if ( !liquid_helper()->check_post_types() ): ?>
	<footer class="blog-post-footer entry-footer">
        <div class="lqd-container ms-auto me-auto">
            <?php if ( has_tag() || function_exists( 'liquid_portfolio_share' ) ): ?>

            <div class="flex justify-between">

            <?php the_tags( '<span class="tags-links flex flex-wrap items-center pr-md-2"><span>' . esc_html__( 'Tags:', 'aihub' ) . '</span>', esc_html_x( ' ', 'Used between list items, there is a space', 'aihub' ), '</span>' ); ?>

            <?php if( function_exists( 'liquid_portfolio_share' ) ) : ?>
                <?php liquid_portfolio_share( get_post_type(), array(
                    'class' => 'social-icon p-0 m-0 list-none flex items-center',
                    'before' => '<span class="share-links flex items-center"><span class="text-12 uppercase tracking-100">'. esc_html__( 'Share On', 'aihub' ) .'</span>',
                    'after' => '</span>'
                ) ); ?>
            <?php endif; ?>

            </div>

            <?php endif; ?>

            <?php get_template_part( 'templates/blog/single/part', 'author' ) ?>
            <?php liquid_render_post_nav() ?>

            <?php do_action( 'liquid_single_article_footer' ); ?>
        </div>
	</footer>
	<?php endif; ?>

	<?php do_action( 'liquid_after_single_article_footer' ); ?>


</article>

<?php liquid_render_related_posts( get_post_type() ) ?>
<?php

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

?>

<?php do_action( 'liquid_end_single_post_container' ); ?>

<?php do_action( 'liquid_single_post_sidebar' ); ?>

<?php do_action( 'liquid_after_single_article' ); ?>