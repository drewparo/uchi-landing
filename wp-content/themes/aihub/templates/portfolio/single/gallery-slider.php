<div class="ld-pf-single ld-pf-single-2">

	<div class="container ld-container">
		<div class="row">
			<div class="w-full">

				<div class="pf-single-contents clearfix">

					<?php liquid_portfolio_media() ?>

					<div class="row d-mflex items-center">

						<div class="w-6/12 mobile-extra:w-full">

							<div class="pf-single-header pull-up bg-solid">
								<h2 class="pf-single-title mt-0 mb-24 font-bold"
									data-fittext="true"
									data-fittext-options='{ "maxFontSize": "currentFontSize", "compressor": 0.6 }'>
									<?php the_title() ?>
								</h2>

								<?php liquid_portfolio_the_content() ?>

								<div class="clearfix mb-16"></div>

								<div class="pf-info d-lg-flex justify-between">
									<?php liquid_portfolio_date() ?>
									<?php liquid_portfolio_atts() ?>
								</div>

							</div>

						</div>

						<div class="w-6/12 mb-32 text-right mobile-extra:w-full mobile-extra:mb-0 mobile-extra:text-start">
							<div class="d-mflex items-center justify-end mb-24">
							<?php if( function_exists( 'liquid_portfolio_share' ) ) : ?>
								<small class="text-12 uppercase tracking-100 mr-3"><?php esc_html_e( 'Share on', 'aihub' ); ?></small>
								<?php liquid_portfolio_share( get_post_type() ); ?>
							<?php endif; ?>
							</div>

							<?php liquid_render_post_nav( get_post_type() ) ?>

						</div>

					</div>

				</div>

			</div>
		</div>
	</div>

</div>