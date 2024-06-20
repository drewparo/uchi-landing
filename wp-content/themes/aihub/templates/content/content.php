<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */

global $post;

$article_class = 'lqd-post lqd-post-default flex flex-wrap relative rounded-24 transition-all overflow-hidden shadow';

if ( is_singular() ) {
	$article_class = 'lqd-post-single';
}

?>

<article <?php liquid_helper()->attr('post', array('class' => $article_class)) ?>>

    <?php if (is_singular()) : ?>

        <?php if ('' !== get_the_post_thumbnail()) : ?>
            <figure class="post-image hmedia lqd-lp-img overflow-hidden rounded-4 mb-32 inline-flex w-auto">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            </figure>
        <?php endif; ?>

        <header class="entry-header">

            <?php the_title('<h1 ' . liquid_helper()->get_attr('entry-title') . '>', '</h1>'); ?>

            <?php get_template_part('templates/entry', 'meta') ?>

        </header>

        <div <?php liquid_helper()->attr('entry-content') ?>>
            <?php
            the_content(sprintf(
                esc_html__('Continue reading %s', 'aihub'),
                the_title('<span class="screen-reader-text">', '</span>', false)
            ));

            wp_link_pages(array(
                'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'aihub') . '</span>',
                'after' => '</div>',
                'link_before' => '<span>',
                'link_after' => '</span>',
                'pagelink' => '<span class="screen-reader-text">' . esc_html__('Page', 'aihub') . ' </span>%',
                'separator' => '<span class="screen-reader-text">, </span>',
            ));
            ?>
        </div>

        <footer class="entry-footer lqd-lp-footer flex flex-wrap">
            <?php liquid_post_terms(array('taxonomy' => 'category', 'text' => esc_html__('Posted in: %s', 'aihub'), 'solid' => true)); ?>
            <?php liquid_post_terms(array('taxonomy' => 'post_tag', 'text' => esc_html__('Tagged: %s', 'aihub'), 'before' => ' | ', 'solid' => true)); ?>
        </footer>

    <?php else: ?>

		<?php if ('' !== get_the_post_thumbnail()) : ?>
			<div class="lqd-post-media w-full relative z-0">
				<figure class="lqd-post-media-fig rounded-inherit">
					<a href="<?php the_permalink(); ?>">
						<?php liquid_the_post_thumbnail( 'liquid-related-post', array( 'class' => 'w-full rounded-inherit object-cover object-center' ), false ); ?>
					</a>
				</figure>
			</div>
		<?php endif; ?>

        <div class="lqd-post-content flex flex-col w-full pt-32 pb-20 ps-20 pe-20">

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

			<div class="lqd-post-btn m-0 p-0 z-1 text-14 mt-auto">
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

    <?php endif; ?>

    <?php
    // Author bio.
    if (is_single() && get_the_author_meta('description')) :
        get_template_part('templates/author', 'bio');
    endif;
    ?>

</article>