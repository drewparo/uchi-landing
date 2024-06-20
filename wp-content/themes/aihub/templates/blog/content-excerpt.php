<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */
?>

<article <?php liquid_helper()->attr( 'post', array('class' => 'lqd-lp lqd-lp-style-22 lqd-lp-title-34 relative') ) ?>>

    <header class="entry-header lqd-lp-header mb-16">

        <div class="lqd-lp-meta uppercase tracking-100 font-bold">
            <?php liquid_post_terms(array('taxonomy' => 'post_tag', 'text' => esc_html__('%s', 'aihub'), 'solid' => true)); ?>
        </div>

        <?php the_title(sprintf('<h2 class="lqd-lp-title mt-8 mb-16 h5"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

        <div class="lqd-lp-meta lqd-lp-meta-dot-between flex flex-wrap items-center font-bold uppercase tracking-100">
            <?php liquid_post_terms(array('taxonomy' => 'category', 'text' => esc_html__('%s', 'aihub'), 'solid' => false)); ?>
            <div class="lqd-lp-author relative z-2">
                <div class="lqd-lp-author-info">
                    <h3 class="mt-0 mb-0"><?php the_author_posts_link(); ?></h3>
                </div>
            </div>
            <span class="lqd-lp-date relative z-2">
                <a href="<?php the_permalink() ?>"><?php echo get_the_date(get_option('date_time')); ?></a>
            </span>
        </div>

    </header>

    <?php if ('' !== get_the_post_thumbnail()) : ?>
        <div class="lqd-lp-img overflow-hidden rounded-4 mt-24 mb-32">
            <figure>
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'post-thumbnail', ['class' => 'w-full']); ?></a>
            </figure>
        </div>
    <?php endif; ?>

    <div <?php liquid_helper()->attr( 'entry-summary' ) ?>>
        <?php the_excerpt() ?>
    </div>

</article>