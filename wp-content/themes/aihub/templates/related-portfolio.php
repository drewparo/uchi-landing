<div class="pf-related-posts pb-32">

	<div class="container pb-32">

		<div class="row">

			<?php if( 'style2' === $style ) {  ?>


				<?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>
				<?php $thumb_url = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ); ?>
					<div class="w-4/12 mobile-extra:w-full">

						<article class="pf-related pf-related-alt" data-custom-animations="true" data-ca-options='{ "triggerHandler": "mouseenter", "triggerTarget": "this", "offTriggerHandler": "mouseleave", "direction": "forward", "animationTarget": ".pf-related-cat li, .split-inner", "duration": 650, "direction": "backward", "delay": 50, "initValues": { "y": "0", "opacity": 1 }, "animations": { "y": -20, "opacity": 0 } }'>

							<figure style="background-image: url(<?php echo esc_url( $thumb_url ); ?>);" data-parallax="true" data-parallax-options='{ "parallaxBG": true, "scaleBG": false }' data-parallax-from='{ "y": 0, "scale": 1 }' data-parallax-to='{ "y": 0, "scale": 1.3 }'>
								<?php liquid_the_post_thumbnail( 'liquid-portfolio-related', null, false ); ?>
							</figure>

							<header>
								<?php
									$terms = get_the_terms( get_the_ID(), $taxonomy );
									$term = $terms[0];
									if( isset( $term ) ) {
										echo '<ul class="pf-related-cat uppercase tracking-100 list-none p-0 m-0 comma-sep-li mb-8"><li><a href="' . get_term_link( $term->slug, $taxonomy ) . '">' . esc_html( $term->name ) . '</a></li></ul>';
									}
								?>
								<h2 class="pf-related-title h3 mt-0 font-bold">
									<a href="<?php the_permalink() ?>" data-split-text="true" data-split-options='{ "type": "lines" }'><?php the_title() ?></a>
								</h2>
							</header>

							<a href="<?php the_permalink() ?>" class="liquid-overlay-link"></a>
						</article>

					</div>
				<?php endwhile; ?>


			<?php } else {  ?>

				<?php if( !empty( $heading ) ) { ?>
				<div class="w-4/12 tablet:w-3/12 mobile:w-full">
					<h6 class="mb-32"><?php echo esc_html( $heading ) ?></h6>
				</div>
				<?php } ?>

				<div class="<?php echo ( empty( $heading ) ? 'w-full' : 'w-8/12 mobile-extra:w-9/12 mobile:w-full' ) ?>">
					<div class="row flex flex-row flex-wrap">

						<?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>

							<div class="w-4/12 tablet:w-full">

								<article class="pf-related tablet:pe-24">

									<header>
										<h2 class="pf-related-title h3 mt-0 font-bold">
											<a href="<?php the_permalink() ?>" data-split-text="true" data-split-options='{ "type": "lines" }' data-custom-animations="true" data-ca-options='{ "triggerHandler": "mouseenter", "triggerTarget": ".pf-related", "triggerRelation": "closest", "offTriggerHandler": "mouseleave", "animationTarget": ".split-inner", "duration": 850, "delay": 70, "startDelay": 130, "initValues": { "opacity": 1 }, "animations": { "opacity": 0 } }'><?php the_title() ?></a>
											<a href="<?php the_permalink() ?>" rel="bookmark" class="title-shad" data-split-text="true" data-split-options='{ "type": "lines" }' data-custom-animations="true" data-ca-options='{ "triggerHandler": "mouseenter", "triggerTarget": ".pf-related", "triggerRelation": "closest", "offTriggerHandler": "mouseleave", "animationTarget": ".split-inner", "duration": 650, "delay": 70, "initValues": { "width": 0 }, "animations": { "width": "100%" } }'><?php the_title() ?></a>
										</h2>
										<?php
											$terms = get_the_terms( get_the_ID(), $taxonomy );
											$term = $terms[0];
											if( isset( $term ) ) {
												echo '<ul class="pf-related-cat uppercase tracking-100 list-none p-0 m-0 comma-sep-li"><li><a href="' . get_term_link( $term->slug, $taxonomy ) . '">' . esc_html( $term->name ) . '</a></li></ul>';
											}
										?>
									</header>

									<a href="<?php the_permalink() ?>" class="liquid-overlay-link"></a>

								</article>

							</div>

						<?php endwhile; ?>

					</div>

				</div>

			<?php } ?>


		</div>

	</div>

</div>

<?php wp_reset_postdata();