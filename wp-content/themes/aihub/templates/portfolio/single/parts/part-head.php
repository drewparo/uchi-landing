<div class="lqd-pf-single-cover relative">

	<figure class="lqd-pf-single-cover-img flex">
		<?php the_post_thumbnail( 'full', array( 'itemprop' => 'url' ) ); ?>
	</figure>

	<div class="absolute top-0 start-0 items-center justify-center text-center pt-64 pe-64 pb-64 ps-64 mobile-extra:pt-16 mobile-extra:pe-16 mobile-extra:pb-16 mobile-extra:ps-16">

		<?php the_title( '<h1 class="entry-title lqd-pf-single-title mt-0 mb-0">', '</h1>' ) ?>

	</div>

	<div class="absolute bottom-0 start-0 end-0 text-center pb-40">
		<a class="pf-scroll-down-link" href="#" data-localscroll="true" data-localscroll-options='{"scrollBelowSection": true}'>
			<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
		</a>
	</div>

</div>