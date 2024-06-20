<div class="titlebar">

  <div class="titlebar-overlay absolute top-0 start-0"></div>

  <div class="titlebar-inner">

    <div class="container titlebar-container">

      <div class="row titlebar-container flex flex-wrap items-center">

        <div class="titlebar-col col-xs-12 col-md-6">

					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php bbp_breadcrumb(); ?>

        </div>

        <div class="titlebar-col col-xs-12 col-md-6 text-md-right">

	        	<?php if ( bbp_has_replies() && is_singular( 'topic' ) ) : ?>

					<?php bbp_get_template_part( 'pagination', 'replies'    ); ?>

				<?php elseif ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>

					<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

				<?php endif; ?>

        </div>

      </div>

    </div>

  </div>

</div>