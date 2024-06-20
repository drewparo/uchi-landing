<!--<div class="lqd-pf-column col-md-<?php $this->get_column_class() ?> col-sm-6 col-xs-12 masonry-item <?php $this->entry_term_classes() ?>">-->

	<article <?php echo liquid_helper()->html_attributes( $attributes ); ?>>
		<div class="lqd-pf-item" style="height: 285px; background: #eee; border: 1px solid; overflow: hidden;" >

			<div class="lqd-pf-img">
				<figure>
					<?php $this->entry_thumbnail(); ?>
				</figure>
			</div>

			<div class="lqd-pf-details flex flex-wrap relative rounded-4">
				<span class="lqd-pf-overlay-bg absolute top-0 start-0"></span>
				<div class="lqd-pf-info flex flex-wrap items-center justify-between w-full pt-24 pe-24 pb-24 ps-24">
					<?php the_title( '<h2 class="mt-0 mb-0 h5">', '</h2>'  ) ?>
					<?php $this->entry_cats() ?>
				</div>
			</div>

			<?php $this->get_overlay_button(); ?>

		</div>
	</article>

<!--</div>-->