<div class="carousel-item col-lg-<?php $this->get_column_class() ?> col-md-6 col-xs-12 <?php $this->entry_term_classes() ?>">

	<div class="carousel-item-inner">
		<div class="carousel-item-content">

			<article<?php echo liquid_helper()->html_attributes( $attributes ) ?>>
				<div class="lqd-pf-item-inner">

					<div class="lqd-pf-img overflow-hidden rounded-6 relative mb-32">
						<figure>
							<?php $this->entry_thumbnail( 'liquid-style3-pf' ); ?>
						</figure>

						<span class="lqd-pf-overlay-bg absolute top-0 start-0 flex items-center justify-center">
							<i class="lqd-icn-ess icon-md-arrow-forward"></i>
						</span>

					</div>

					<div class="lqd-pf-details">
						<?php the_title( '<h2 class="mt-0 mb-4 h5">', '</h2>'  ) ?>
						<?php $this->entry_cats() ?>
					</div>

					<?php $this->get_overlay_button(); ?>

				</div>
			</article>

		</div>
	</div>

</div>