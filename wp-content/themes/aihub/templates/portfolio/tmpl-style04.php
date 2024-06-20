<div class="carousel-item col-sm-12 <?php $this->entry_term_classes() ?>">

	<div class="carousel-item-inner">
		<div class="carousel-item-content">

			<article<?php echo liquid_helper()->html_attributes( $attributes ) ?>>
				<div class="lqd-pf-item-inner">

					<div class="lqd-pf-img overflow-hidden relative">
						<figure>
							<?php $this->entry_thumbnail( 'liquid-style4-pf' ); ?>
						</figure>
						<span class="lqd-pf-overlay-bg absolute top-0 start-0"></span>
					</div>

					<div class="lqd-pf-details flex justify-end absolute top-0 start-0">
						<div class="text-vertical pt-24 pe-24 pb-24 ps-24">
							<?php the_title( '<h2 class="mt-0 mb-0 h5">', '</h2>'  ); ?>
							<?php $this->entry_content(); ?>
						</div>
					</div>

					<?php $this->get_overlay_button(); ?>

				</div>
			</article>

		</div>
	</div>

</div>