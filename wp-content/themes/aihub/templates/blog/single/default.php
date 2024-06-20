<article <?php liquid_helper()->attr( 'post', array( 'class' => 'blog-single' ) ) ?>>

	<div class="lqd-container ms-auto me-auto">

        <?php do_action( 'liquid_start_single_post_container' ); ?>

        <?php get_template_part( 'templates/blog/single/part', 'media' ) ?>

            <div class="blog-single-details">

                <header class="entry-header blog-single-header">

                    <?php the_title( '<h1 class="blog-single-title entry-title h2">', '</h1>' ) ?>

                    <?php get_template_part( 'templates/blog/single/part', 'meta' ) ?>

                    <?php get_template_part( 'templates/blog/single/part', 'extra' ) ?>

                </header>

            </div>

            <div class="entry-content lqd-single-post-content clearfix relative">
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

            <footer class="blog-single-footer entry-footer">
            <?php the_tags( '<span class="tags-links">', esc_html_x( ' ', 'Used between list items, there is a space', 'aihub' ), '</span>' ); ?>
            <?php if( function_exists( 'liquid_portfolio_share' ) ) : ?>
                <?php liquid_portfolio_share( get_post_type(), array(
                    'class' => 'social-icon social-icon-shaped social-icon-circle branded social-icon-sm',
                    'before' => '<span class="share-links"><span class="text-12 uppercase tracking-100">'. esc_html__( 'Share On', 'aihub' ) .'</span>',
                    'after' => '</span>'
                ) ); ?>
            <?php endif; ?>
            </footer>

            <?php get_template_part( 'templates/blog/single/part', 'author' ) ?>
            <?php liquid_render_post_nav() ?>

        <?php do_action( 'liquid_end_single_post_container' ); ?>

        <?php do_action( 'liquid_single_post_sidebar' ); ?>
	</div>

	<?php liquid_render_related_posts( get_post_type() ) ?>
	<?php

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	?>

</article>