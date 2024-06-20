
<?php get_template_part( 'templates/portfolio/single/parts/part', 'head' ); ?>

<div class="pf-single-contents container clearfix">
	<div class="row flex flex-wrap">
		<div class="w-5/12 mx-auto mobile-extra:w-full">
			<?php the_content() ?>
		</div>
		<div class="w-5/12 mx-auto mobile-extra:w-full">
			<?php get_template_part( 'templates/portfolio/single/parts/part', 'meta' ); ?>
		</div>
	</div>

    <div class="w-full">
        <?php get_template_part( 'templates/portfolio/single/parts/part', 'nav' ); ?>
    </div>

</div>