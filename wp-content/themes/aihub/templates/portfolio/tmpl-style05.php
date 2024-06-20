<div class="carousel-item col-xs-12 col-sm-6 col-md-4 <?php $this->entry_term_classes() ?>">

	<div class="carousel-item-inner">
		<div class="carousel-item-content">

			<article<?php echo liquid_helper()->html_attributes( $attributes ) ?>>
				<div class="lqd-pf-item-inner absolute top-0 start-0">

					<div class="lqd-pf-img h-full w-full relative overflow-hidden">
						<?php $this->entry_thumbnail(); ?>
						<span class="lqd-pf-overlay-bg absolute top-0 start-0">
						</span>
					</div>

					<div class="lqd-pf-details absolute top-0 start-0 flex justify-end ps-24 pe-24">
						<div class="text-vertical ps-16">
							<?php the_title( '<h2 class="mt-0 mb-0 h5">', '</h2>'  ); ?>
							<?php $this->entry_cats() ?>
						</div>
					</div>

					<?php $this->get_overlay_button(); ?>

				</div>
			</article>

		</div>
	</div>

</div>