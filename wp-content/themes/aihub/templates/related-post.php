<?php

$col = '3';
if( '2' === $number_of_posts ) {
	$col = '6';
}
elseif( '3' === $number_of_posts ) {
	$col = '4';
}

if( empty( $related_posts_view ) ) {
	$related_posts_view = 'style-1';
}

?>
<div class="related-posts">

	<div class="lqd-container ms-auto me-auto">

		<?php if( !empty( $heading ) ) { ?>
			<h3 class="related-posts-title mt-0 text-26 font-bold text-center"><?php echo esc_html( $heading ) ?></h3>
		<?php } ?>

            <?php 
            if (
                liquid_helper()->get_kit_frontend_option('liquid_blog_single_related_enable') == 'on' &&
                !empty(liquid_helper()->get_kit_frontend_option('liquid_blog_single_related_template'))
            ) {
                echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( liquid_helper()->get_kit_option('liquid_blog_single_related_template') );
            } else { ?>
            <div class="lqd-post-row flex flex-wrap">

                <?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>

                    <div class="lqd-post-col w-<?php echo esc_attr( $col ) ?>/12 mobile-extra:w-6/12 mobile:w-full">

                    <?php if ( $related_posts_view === 'style-1' ) { ?>
                    <article class="lqd-post relative rounded-24 transition-all overflow-hidden">

                        <?php if( '' !== get_the_post_thumbnail() ) : ?>
                            <div class="lqd-post-media relative z-0">
                                <figure class="lqd-post-media-fig rounded-inherit">
                                    <a href="<?php the_permalink() ?>">
                                        <?php liquid_the_post_thumbnail( 'liquid-related-post', array( 'class' => 'w-full rounded-inherit object-cover object-center' ), false ); ?>
                                    </a>
                                </figure>
                            </div>
                        <?php endif; ?>

                        <div class="lqd-post-content pt-32 pb-20 ps-20 pe-20">
                            <div class="lqd-post-meta flex flex-wrap items-center gap-20 relative z-1 mb-10 text-14 transition-colors text-current">
                                <span class="lqd-post-meta-part inline-flex flex-wrap items-center transition-colors" data-lqd-post-meta-part="time">
                                    <?php echo liquid_helper()->liquid_post_date(); ?>
                                </span>
                                <span class="lqd-post-meta-separator inline-flex items-center grow">
                                    <span class="inline-block w-full h-px bg-current opacity-5"></span>
                                </span>
                                <span class="lqd-post-meta-part inline-flex flex-wrap items-center transition-colors" data-lqd-post-meta-part="categories">
                                    <?php echo liquid_get_category(); ?>
                                </span>
                            </div>

                            <h4 class="lqd-post-title m-0 p-0 relative z-1 text-22 leading-120 weight-medium mb-64">
                                <a class="transition-colors" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                            </h4>

                            <div class="lqd-post-btn m-0 p-0 z-1 text-14">
                                <a href="<?php the_permalink() ?>" role="button" class="lqd-btn inline-flex items-center relative lqd-group lqd-group-btn lqd-btn-has-bg lqd-btn-has-hover-bg transition-all">
                                    <span class="lqd-bg-el rounded-inherit transition-opacity lqd-group-btn-hover:opacity-0">
                                        <span class="lqd-bg-layer lqd-color-wrap lqd-bg-color-wrap block w-full h-full rounded-inherit overflow-hidden elementor-repeater-item-d1abf56-1be5959 absolute top-0 start-0 z-0"></span>
                                    </span>
                                    <span class="lqd-hover-bg-el lqd-el-visible-on-hover rounded-inherit transition-opacity opacity-0 lqd-group-btn-hover:opacity-100">
                                        <span class="lqd-bg-layer lqd-color-wrap lqd-bg-color-wrap block w-full h-full rounded-inherit overflow-hidden elementor-repeater-item-81a0631-1be5959 absolute top-0 start-0 z-0"></span>
                                    </span>
                                    <span class="lqd-btn-txt relative"><?php esc_html_e( 'Read More', 'aihub' ); ?></span>
                                    <span class="lqd-btn-icon inline-flex items-center justify-center relative text-percent-80">
                                        <svg class="lqd-akar-icon w-1em h-auto lqd-menu-icon" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 4l8 8-8 8"></path></svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                    </article>

                    <?php } ?>

                </div>

                <?php endwhile; ?>

            </div>
            <?php }?>
	</div>

</div>
<?php wp_reset_postdata();