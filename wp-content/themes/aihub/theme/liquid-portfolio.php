<?php
/**
 * Liquid_ThemePortfolio class for portfolio posts page and portfolio archives
 */

class Liquid_ThemePortfolio extends LQD_Portfolio_Listing {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		$this->atts = array(

			'style'                => liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_archive_style' ),
			'horizontal_alignment' => liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_horizontal_alignment' ),
			'vertical_alignment'   => liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_vertical_alignment' ),
			'grid_columns'         => liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_grid_columns' ),
			'columns_gap'          => liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_columns_gap' )['size'],
			'bottom_gap'           => liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_bottom_gap' )['size'],
			'enable_parallax'      => liquid_helper()->get_kit_frontend_option( 'liquid_portfolio_enable_parallax' ) ? '' : 'no',
			'pagination'           => 'pagination',
			'css_animation'        => 'none',
			'disable_postformat'   => 'yes',

		);

		$this->render( $this->atts );

	}

	/**
	 * [render description]
	 * @method render
	 * @return [type] [description]
	 */
	public function render( $atts, $content = '' ) {

		$posts = get_posts( array(
			'post_type' => 'liquid-archives',
			'posts_per_page' => -1,
		) );

		if ( $posts ) {
			foreach ( $posts as $post ) {

				$condition = liquid_helper()->get_page_option( 'lqd_archives_rule', $post->ID );

				if (  in_array( get_post_type(), $condition ) === true ){
					echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post->ID );
					return;
				} 

			}
		}

		extract( $atts );

		// Locate the template and check if exists.
		$located = locate_template( array(
			"templates/portfolio/tmpl-$style.php"
		) );
		if ( ! $located ) {
			return;
		}

		$this->grid_id = $grid_id = uniqid( 'grid-');

		//Container
		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ){
			echo '<div class="liquid-portfolio-list">';
		} else {
			echo '<div class="liquid-portfolio-list ' . $this->get_id() . '">';
		}

		$before = $after = '';

		if( 'masonry-creative' === $style ) {
			printf( '<div id="%1$s" class="row liquid-portfolio-list-row %1$s" data-columns="%2$s" data-liquid-masonry="true" data-masonry-options=\'{ "layoutMode": "masonry", "alignMid": true }\'>', $this->grid_id, $grid_columns );
			echo '<div class="col-md-4 col-sm-6 col-xs-12 grid-stamp creative-masonry-grid-stamp"></div>';
		}
		else if ( $style === 'style05'){

			echo '<div class="lqd-pf-carousel carousel-container carousel-nav-floated carousel-nav-center carousel-nav-middle carousel-nav-circle carousel-nav-solid carousel-nav-lg carousel-nav-shadowed carousel-dots-mobile-inside" data-filterable-carousel="true">';
			echo '<div class="carousel-items relative ms-0 me-0" data-lqd-flickity=\'{ "filters": "#' . $filter_id . '"' . $opt_counter .', "wrapAround": true, "groupCells": false, "prevNextButtons": true, "navOffsets": { "prev": 15, "next": 15 }, "prevNextButtonsOnlyOnMobile": true, "buttonsAppendTo": "self" }\'>';
			echo '<div class="flickity-viewport relative w-full overflow-hidden">';
			echo '<div class="flickity-slider flex w-full h-full" style="left: 0; transform: translateX(0%);">';

		}
		else {
			printf( '<div id="%1$s" class="row liquid-portfolio-list-row %1$s" data-liquid-masonry="true">', $this->grid_id );
		}

		$this->add_excerpt_hooks();

		while( have_posts() ): the_post();

			$post_classes = array( 'lqd-pf-item', $this->get_item_classes() );
			if ( $style === "style05" ){
				$post_classes[] = "lqd-pf-item-style-5 lqd-pf-light relative h-vh-100";
			}
			$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );

			$attributes = array(
				'id'    => 'post-' . get_the_ID(),
				'class' => $post_classes
			);

			echo apply_filters( 'liquid_portfolio_before_post', $before );

				include $located;

			echo apply_filters( 'liquid_portfolio_after_post', $after );

		endwhile;

		$this->remove_excerpt_hooks();

		if ( $style === 'style05'){
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}

		echo '</div>';


		// Pagination
		if( 'pagination' === $atts['pagination'] ) {

			// Set up paginated links.
	        $links = paginate_links( array(
				'type' => 'array',
				'prev_next' => true,
				'prev_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z"></path></svg>', 'aihub' ), 'svg' ) . '</span>',
				'next_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>', 'aihub' ), 'svg' ) . '</span>'
			));
			if( !empty( $links ) ) {
				printf( '<div class="page-nav"><nav aria-label="'. esc_attr__( 'Page navigation', 'aihub' ) . '"><ul class="pagination"><li>%s</li></ul></nav></div>', join( "</li>\n\t<li>", $links ) );
			}
		}

		if( in_array( $atts['pagination'], array( 'ajax', 'ajax2', 'ajax3', 'ajax4' ) ) && $url = get_next_posts_page_link( $GLOBALS['wp_query']->max_num_pages ) ) {
			$hash = array(
				'ajax' => 'btn btn-md ajax-load-more',
			);

			$attributes = array(
				'href' => add_query_arg( 'ajaxify', '1', $url),
				'rel' => 'nofollow',
				'data-ajaxify' => true,
				'data-ajaxify-options' => json_encode( array(
					'wrapper' => '.liquid-portfolio-list .liquid-portfolio-list-row',
					'items'   => '> .masonry-item'
				))
			);

			echo '<div class="liquid-pf-nav ld-pf-nav-ajax"><div class="page-nav text-center"><nav aria-label="'. esc_attr__( 'Page navigation', 'aihub' ) . '">';
			switch( $atts['pagination'] ) {

				case 'ajax':
					$ajax_text = ! empty( $atts['ajax_text'] ) ? esc_html( $atts['ajax_text'] ) : esc_html__( 'Load more', 'aihub' );
					$attributes['class'] = 'ld-ajax-loadmore';
					printf( '<a%2$s><span><span class="static">%1$s</span><span class="loading"><span class="dots"><span></span><span></span><span></span></span><span class="uppercase lts-sp-1">Loading</span></span><span class="all-loaded">All items loaded <i class="fa fa-check"></i></span></span></a>', $ajax_text, ld_helper()->html_attributes( $attributes ), $url );
					break;
			}

			echo '</nav></div></div>';
		}

		echo '</div>';

	}
}
new Liquid_ThemePortfolio;