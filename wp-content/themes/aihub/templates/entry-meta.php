<div class="lqd-lp-meta lqd-lp-meta-dot-between flex flex-wrap items-center uppercase tracking-100 font-bold">
	<?php liquid_post_terms( array( 'taxonomy' => 'category', 'text' => esc_html__( '%s', 'aihub' ), 'solid' => true ) ); ?>
	<?php liquid_post_terms( array( 'taxonomy' => 'post_tag', 'text' => esc_html__( '%s', 'aihub' ), 'solid' => true ) ); ?>
	<a href="<?php the_permalink() ?>"><time class="lqd-lp-date" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date( get_option( 'date_time' ) ); ?></time></a>
</div>