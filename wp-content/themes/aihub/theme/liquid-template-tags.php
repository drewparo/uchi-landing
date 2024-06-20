<?php
/**
 * The Template Tags
 */

/**
 * [liquid_get_header_layout description]
 * @method liquid_get_header_layout
 * @return [type]                  [description]
 */
function liquid_get_header_layout() {

	global $post;

	$ID = 0;

	//Keep old id
	if( !is_404() || is_search() ) {
		$ID = get_the_ID();
	}

	// which one
	$id = liquid_get_custom_header_id();
	$header = get_post( $id );

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {

        $header_class = ['z-99'];
		$header_overlay = liquid_helper()->get_page_option( 'header_overlay', $id );

        if ( $header_overlay === 'yes' ) {
            $header_class[] = 'lqd-site-header-overlay';
            $header_class[] = 'absolute';
            $header_class[] = 'start-0';
            $header_class[] = 'end-0';
        } else {
            $header_class[] = 'relative';
        }

		// Attributes
		$attributes = array();

		$attributes['class'] = implode( ' ', $header_class );

		$out = array(
			'id' => $id,
			'attributes' => $attributes,
		);

		// reset
		wp_reset_postdata();
		return $out;
	}

}

function liquid_logo_url( $retina = false, $light = false ) {

	$logo = $mobile_logo = '';

	if ( !$light ){
		$logo = $mobile_logo = get_template_directory_uri() . '/assets/img/logo/logo.svg';
	} else {
		$logo = $mobile_logo = get_template_directory_uri() . '/assets/img/logo/logo-light.svg';
	}

	$logo_arr = liquid_helper()->get_kit_frontend_option( 'header_logo' );

	if( is_array( $logo_arr ) && ! empty( $logo_arr['url'] ) ) {
		$logo = $logo_arr['url'];
	}

    echo esc_url( $logo );

}

/**
 * [liquid_get_footer_layout description]
 * @method liquid_get_footer_layout
 * @return [type]                  [description]
 */
function liquid_get_footer_layout() {
}

/**
 * [liquid_header_mobile_trigger_button description]
 * @method liquid_header_mobile_trigger_button
 * @return [type]                [description]
 */
 function liquid_header_mobile_section() {
}

add_action( 'liquid_after_header_tag', 'liquid_header_mobile_section' );

function liquid_get_mobile_nav_ajax() {

	$id = liquid_get_custom_header_id();
	$menu_id = '';

	if ( is_nav_menu( $menu_id ) ) {
		$output	 .=	wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu'           => $menu_id,
				'container'      => 'ul',
				'before'         => false,
				'after'          => false,
				'link_before'    => '',
				'link_after'     => '',
				'menu_id'        => 'primary-nav',
				'menu_class'     => 'lqd-site-mobile-nav p-0 m-0 list-none',
				'walker'         => class_exists( 'Liquid_Menu_Walker' ) ? new Liquid_Menu_Walker : '',
				'echo'           => false
			 ) );
	} else {
		$output	 .=	wp_page_menu( array(
				'container'   => 'ul',
				'before'      => false,
				'after'       => false,
				'link_before' => '',
				'link_after'  => '',
				'menu_class'  => 'lqd-site-mobile-nav p-0 m-0 list-none',
				'menu_id'     => 'primary-nav',
				'depth'       => 3,
				'echo'        => false
			) );
	}

	echo apply_filters( 'liquid_get_mobile_nav_ajax', $output );

	wp_die();

 }

add_action( 'wp_ajax_liquid_get_mobile_nav_ajax', 'liquid_get_mobile_nav_ajax' );
add_action( 'wp_ajax_nopriv_liquid_get_mobile_nav_ajax', 'liquid_get_mobile_nav_ajax' );

/**
 * [liquid_header_mobile_trigger_button description]
 * @method liquid_header_mobile_trigger_button
 * @return [type]                [description]
 */
function liquid_header_mobile_trigger_button(  $args = array() ) {

	$defaults = array(
		'class' => 'navbar-toggle collapsed',
		'data-toggle' => 'collapse',
		'data-ld-toggle' => 'true',
		'data-target' => '#lqd-site-header-collapse',
		'aria-expanded' => 'false',
		'data-toggle-options' => '{ "changeClassnames": {"html": "mobile-nav-activated"} }'
	);

	$args = wp_parse_args( $args, $defaults );

	$args = array_map( 'esc_attr', $args );

	?>
	<button type="button" <?php foreach ( $args as $name => $value ) { echo " $name=" . '"' . $value . '"'; } ?>>
		<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'aihub' ) ?></span>
		<span class="bars">
			<span class="bars-inner">
				<span class="bar"></span>
				<span class="bar"></span>
				<span class="bar"></span>
			</span>
		</span>
	</button>
<?php }

/**
 * [liquid_portfolio_archive_link description]
 * @method liquid_portfolio_archive_link
 * @return [type]               [description]
 */
function liquid_blog_archive_link() {

	$blog_archive_link = isset( liquid_helper()->get_page_option( 'blog_archive_link' )['url'] ) ? liquid_helper()->get_page_option( 'blog_archive_link' )['url'] : '';
	if ( ! $blog_archive_link ) {
		$blog_archive_link = isset( liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_archive_link' )['url'] ) ? liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_archive_link' )['url'] : '';
	}

	if( empty( $blog_archive_link ) ) {
		return;
	}
	?>
	<a href="<?php echo esc_url( $blog_archive_link ) ?>" class="lqd-pf-nav-link lqd-pf-nav-all">
		<i class="nav-subtitle"><?php esc_html_e( 'View All Articles', 'aihub' ); ?><span></span></i>
	</a>
	<?php
}

/**
 * [liquid_portfolio_media description]
 * @method liquid_portfolio_media
 * @return [type]                [description]
 */
function liquid_portfolio_media( $args = array() ) {

	if ( post_password_required() || is_attachment() ) {
		return;
	}

	$defaults = array(
		'before' => '',
		'after' => '',
		'image_class' => 'portfolio-image'
	);
	extract( wp_parse_args( $args, $defaults ) );

	$format = get_post_format();
	$style = liquid_helper()->get_page_option( 'portfolio_style' );
	$style = $style ? $style : 'gallery-stacked';
	$lightbox = get_post_meta( get_the_ID(), 'post-gallery-lightbox', true );

	// Audio
	if( 'audio' === $format && $audio = get_post_meta( get_the_ID(), 'post-audio', true ) ) {

		printf( '<div class="post-audio">%s</div>', do_shortcode( '[audio src="' . $audio . '"]' ) );
	}

	// Gallery
	elseif( 'gallery' === $format && $gallery = get_post_meta( get_the_ID(), 'post-gallery', true ) ) {

		if( 'gallery-slider' === $style ) {

			echo '<div class="carousel-container carousel-nav-floated carousel-nav-center carousel-nav-middle carousel-nav-xl carousel-nav-solid carousel-nav-rectangle">';

				echo '<div class="carousel-items flex" data-lqd-flickity=\'{ "prevNextButtons": true, "navArrow": "1", "pageDots": false, "navOffsets":{"prev":"28px","next":"28px"}, "parallax": true }\'>';

					foreach ( $gallery as $item ) {
						if ( isset ( $item['attachment_id'] ) ) {

							$src_image     = wp_get_attachment_image_src( $item['attachment_id'], 'full' );
							$resized_image = liquid_get_resized_image_src( $src_image, 'liquid-large-slider' );
							$retina_image  = liquid_get_retina_image( $resized_image );

							printf( '<div class="carousel-item w-full"><figure><img src="%s" alt="%s"></figure></div>',$resized_image , esc_attr( $item['title'] ) );

						}
					}

				echo '</div>';

			echo '</div>';
		}

	}

	// Video
	elseif( 'video' === $format ) {
		$video = '';
		if( $url = get_post_meta( get_the_ID(), 'post-video-url', true ) ) {
			global $wp_embed;
			echo $wp_embed->run_shortcode( '[embed]' . $url . '[/embed]' );
		}
		elseif( $file = get_post_meta( get_the_ID(), 'post-video-file', true ) ) {
			if( liquid_helper()->str_contains( '[embed', $file ) ) {
				global $wp_embed;
				echo wp_kses_post( $wp_embed->run_shortcode( $file ) );
			} else {
				echo do_shortcode( $file );
			}
		}
		if( '' != $video ) {
			$my_allowed = wp_kses_allowed_html( 'post' );

			// iframe
			$my_allowed['iframe'] = array(
				'align' => true,
				'width' => true,
				'height' => true,
				'frameborder' => true,
				'name' => true,
				'src' => true,
				'id' => true,
				'class' => true,
				'style' => true,
				'scrolling' => true,
				'marginwidth' => true,
				'marginheight' => true,
			);

			echo wp_kses( $video, $my_allowed );
		}

	}

	else {

		$attachment = get_post( get_post_thumbnail_id() );


		printf( '%s <figure class="%s" data-element-inview="true">', $before, $image_class );
			echo '<div class="overlay"></div>';
			liquid_the_post_thumbnail( 'liquid-large', array(
			));
			if( is_object( $attachment ) && ! empty( $attachment->post_excerpt ) ) {
				printf( '<figcaption><span>%s</span></figcaption>', $attachment->post_excerpt );
			}
		echo '</figure>' . $after;
	}
}

/**
 * [liquid_portfolio_subtitle description]
 * @method liquid_portfolio_subtitle
 * @param  [type]               $key   [description]
 * @param  [type]               $label [description]
 * @return [type]                      [description]
 */
function liquid_portfolio_subtitle( $before, $after ) {

	if( !empty( liquid_helper()->get_page_option( 'portfolio_subtitle' ) ) ) {
		printf( '%1$s %2$s %3$s', $before, esc_html( $value ), $after  );
	}

}

/**
 * [liquid_portfolio_meta description]
 * @method liquid_portfolio_meta
 * @param  [type]               $key   [description]
 * @param  [type]               $label [description]
 * @return [type]                      [description]
 */
function liquid_portfolio_meta( $key, $label, $col = 6 ) {

	$value = get_post_meta( get_the_ID(), 'portfolio-' . $key, true );
	if( !$value ) {
		return;
	}
	?>
	<div class="w-<?php echo esc_attr( $col ) ?>/12 mobile-extra:w-full">

		<p>
			<strong class="info-title"><?php echo esc_html( $label ) ?>:</strong> <?php echo esc_html( $value ); ?>
		</p>

	</div>
	<?php
}

/**
 * [liquid_portfolio_atts description]
 * @method liquid_portfolio_date
 * @return [type]               [description]
 */
function liquid_portfolio_atts( $col = 6 ) {

	$atts = explode("\n", str_replace("\r", "", liquid_helper()->get_page_option( 'portfolio_attributes' )));
	if ( is_array( $atts ) ) {
		foreach ( $atts as $attr ) {
			if( !empty( $attr ) ) {
				$attr = explode( "|", $attr );
				$label = isset( $attr[0] ) ? $attr[0] : '';
				$value = isset( $attr[1] ) ? $attr[1] : $label;
			?>
			<span>
				<?php if( $label ) { ?><small class="uppercase ltr-sp-100"><?php echo esc_html( $label ) ?>:</small><?php } ?>
				<h5 class="mt-0 mb-0"><?php echo esc_html( $value ); ?></h5>
			</span>
			<?php
			}
		}
	}

}

/**
 * [liquid_portfolio_archive_link description]
 * @method liquid_portfolio_archive_link
 * @return [type]               [description]
 */
function liquid_portfolio_archive_link() {

	$pf_link         = get_post_meta( get_the_ID(), 'portfolio-archive-link', true );
	$pf_archive_link = get_post_type_archive_link( 'liquid-portfolio' );

	$link = ! empty( $pf_link ) ? $pf_link : '#';
	?>
	<a href="<?php echo esc_url( $link ) ?>" class="lqd-pf-nav-link lqd-pf-nav-all"><span></span></a>
	<?php
}

/**
 * [liquid_portfolio_date description]
 * @method liquid_portfolio_date
 * @return [type]               [description]
 */
function liquid_portfolio_date() {

	if( 'off' === get_post_meta( get_the_ID(), 'portfolio-enable-date', true ) ) {
		return;
	}

	$label = get_post_meta( get_the_ID(), 'portfolio-date-label', true ) ? get_post_meta( get_the_ID(), 'portfolio-date-label', true ) : esc_html__( 'Date', 'aihub' );
	$date  = get_post_meta( get_the_ID(), 'portfolio-date', true ) ? get_post_meta( get_the_ID(), 'portfolio-date', true ) : get_the_date();

	?>
	<span>
		<?php if( $label ) { ?>
			<small class="uppercase ltr-sp-100"><?php echo esc_html( $label ) ?>:</small>
		<?php } ?>
		<h5 class="mt-0 mb-0"><?php echo esc_html( $date ) ?></h5>
	</span>
	<?php
}

/**
 * [liquid_portfolio_likes description]
 * @method liquid_portfolio_likes
 * @return [type]                [description]
 */
function liquid_portfolio_likes( $class = 'portfolio-likes style-alt', $post_type = 'portfolio' ) {

	$option_name = str_replace( 'liquid-', '', $post_type ) . '-likes-';
	if( 'off' === get_post_meta( get_the_ID(), $option_name . 'enable', true ) || ! function_exists( 'liquid_likes_button' ) ) {
		return;
	}

	liquid_likes_button(array(
		'container' => 'div',
		'container_class' => $class,
		'format' => wp_kses( __( '<span><i class="fa fa-heart"></i> <span class="post-likes-count">%s</span></span>', 'aihub' ), array( 'span' => array( 'class' => array() ), 'i' => array( 'class' => array() ) ) )
	));
}

/**
 * [liquid_get_lightbox_link]
 * @method liquid_get_lightbox_link
 * @return [type]                [description]
 */
function liquid_get_lightbox_link( $link_to_image ) {
	if( empty( $link_to_image ) ) {
		return;
	}

	return '<a class="lightbox-link" data-type="image" href="' . esc_url( $link_to_image ) . '"></a>';
}

/**
 * [liquid_render_related_posts description]
 * @method liquid_render_related_posts
 * @param  string                     $post_type [description]
 * @return [type]                                [description]
 */
function liquid_render_related_posts( $post_type = 'post' ) {

	$folder = str_replace( 'liquid-', '', $post_type );
	$option_name = $folder . '-related-';

	$post_related_enable = liquid_helper()->get_page_option( 'post_related_enable' );
	if ( !$post_related_enable ){ $post_related_enable = liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_related_enable' ); }

	$heading = liquid_helper()->get_page_option( 'post_related_title' );
	if ( !liquid_helper()->get_page_option( 'post_related_enable' ) ){ $heading = liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_related_title' ); }

	$style = liquid_helper()->get_page_option( 'post_related_style' );
	if ( !$style ){ $style = 'style1'; }

	$related_posts_view = 'style-1';

	$number_of_posts = liquid_helper()->get_page_option( 'post_related_number' );
	if ( !liquid_helper()->get_page_option( 'post_related_enable' ) ){ $number_of_posts = liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_related_number' ); }


	if( 'on' !== $post_related_enable) {
		return;
	}

	$number_of_posts = '0' == $number_of_posts ? '3' : strval( $number_of_posts );

	$taxonomy = 'post' === $post_type ? 'category' : $post_type . '-category';

	$related_posts = liquid_get_post_type_related_posts( get_the_ID(), $number_of_posts, $post_type, $taxonomy );

	if( $related_posts && $related_posts->have_posts() ) {
		$located = locate_template( array(
			'templates/related-'. $folder .'.php',
			'templates/related-posts.php'
		) );

		if( $located ) require $located;
	}
}

/**
 * [liquid_get_post_type_related_posts description]
 * @method liquid_get_post_type_related_posts
 * @param  [type]                            $post_id      [description]
 * @param  integer                           $number_posts [description]
 * @param  string                            $post_type    [description]
 * @param  string                            $taxonomy     [description]
 * @return [type]                                          [description]
 */
function liquid_get_post_type_related_posts( $post_id, $number_posts = 6, $post_type = 'post', $taxonomy = 'category' ) {

	if( 0 == $number_posts ) {
		return false;
	}

	$item_array = array();
	$item_cats = get_the_terms( $post_id, $taxonomy );
	if ( $item_cats ) {
		foreach( $item_cats as $item_cat ) {
			if ( isset($item_cat->term_id) ){
				$item_array[] = $item_cat->term_id;
			}
		}
	}

	if( empty( $item_array ) ) {
		return false;
	}

	$args = array(
		'post_type'				=> $post_type,
		'posts_per_page'		=> $number_posts,
		'post__not_in'			=> array( $post_id ),
		'ignore_sticky_posts'	=> 0,
		'tax_query'				=> array(
			array(
				'field'		=> 'id',
				'taxonomy'	=> $taxonomy,
				'terms'		=> $item_array
			)
		)
	);

	return new WP_Query( $args );
}

/**
 * [liquid_render_post_nav description]
 * @method liquid_render_post_nav
 * @param  string                $post_type [description]
 * @return [type]                           [description]
 */
function liquid_render_post_nav( $post_type = 'post' ) {

	$post_type = str_replace( 'liquid-', '', $post_type );

	$post_navigation_enable = liquid_helper()->get_page_option( 'post_navigation_enable' );
	if ( !$post_navigation_enable ){
		$post_navigation_enable = liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_navigation_enable' );
	}

	if( 'on' !== $post_navigation_enable ) {
		return;
	}

	$post_type = 'post' === $post_type ? 'blog' : $post_type;
	get_template_part( 'templates/'. $post_type .'/single/navigation' );

}

/**
 * [liquid_portfolio_the_content description]
 * @method liquid_portfolio_the_content
 * @return [type]                      [description]
 */
function liquid_portfolio_the_content() {


	$content = liquid_helper()->get_page_option( 'portfolio_description' );
	if ( isset( $content ) && !empty( $content ) ) {
		echo apply_filters( 'the_content', $content );
		return;
	}

	$content = get_the_content();
	the_content( sprintf(
		esc_html__( 'Continue reading %s', 'aihub' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	) );

}

/**
 * [liquid_portfolio_the_excerpt description]
 * @method liquid_portfolio_the_content
 * @return [type]                      [description]
 */
function liquid_portfolio_the_excerpt() {

	$excerpt = liquid_helper()->get_page_option( 'portfolio_description' );
	if( isset( $excerpt ) && !empty( $excerpt ) ) {
		$excerpt = apply_filters( 'get_the_excerpt', $excerpt );
		$excerpt = apply_filters( 'the_excerpt', $excerpt );
		echo wp_kses( $excerpt, 'lqd_post' );
		return;
	}

	$excerpt = get_the_excerpt();

}

/**
 * [liquid_author_link description]
 * @method liquid_author_link
 * @param  array             $args [description]
 * @return [type]                  [description]
 */
function liquid_author_link( $args = array() ) {

	global $authordata;
    if ( ! is_object( $authordata ) ) {
        return;
    }

	$defaults = array(
		'before' => '',
		'after' => ''
	);
	extract( wp_parse_args( $args, $defaults ) );

	$link = sprintf(
        '<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
        esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
        esc_attr( sprintf( esc_html__( 'Posts by %s', 'aihub' ), get_the_author() ) ),
        $before . get_the_author() . $after
    );
	?>
	<span <?php liquid_helper()->attr( 'entry-author', array( 'class' => 'vcard author' ) ); ?>>
		<span itemprop="name">
			<?php echo apply_filters( 'liquid_author_link', $link ); ?>
		</span>
	</span>
	<?php
}

/**
 * [liquid_get_category description]
 * @method liquid_get_category
 * @return [type]            [description]
 */
function liquid_get_category() {

	$cats_list = get_the_category();
	$cat = isset( $cats_list[0] ) ? $cats_list[0] : '';
	if( empty( $cat ) ) {
		return;
	}

	echo '<a class="transition-all" href="' . get_category_link( $cat->term_id ) . '" rel="category tag">' . esc_html( $cat->name  ) . '</a>';

}

/**
 * [liquid_author_role description]
 * @method liquid_author_role
 * @return [type]            [description]
 */
function liquid_author_role() {

	global $authordata;
    if ( ! is_object( $authordata ) ) {
        return;
    }

	$user = new WP_User( $authordata->ID );
    return array_shift( $user->roles );
}

function liquid_get_post_reading_time() {

	$content     = get_the_content();
	$word_count  = str_word_count( strip_tags( $content ) );
	$readingtime = ceil( $word_count / 200 );

	return $readingtime;

}

if ( ! function_exists( 'liquid_post_time' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function liquid_post_time( $icon = false, $echo = true ) {

	$time_string = '<time %5$s >%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() ),
		liquid_helper()->get_attr( 'entry-published' )
	);

	$time_url = get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) );
	$icon_html = $icon ? '<i class="fa fa-clock-o"></i>' : '';

	$out = sprintf( '<a href="%1$s">%3$s %2$s</a>', get_the_permalink(), $time_string, $icon_html );

	if( $echo ) {
		echo apply_filters( 'liquid_post_time', $out );
	} else {
		return apply_filters( 'liquid_post_time', $out );
	}
}
endif;