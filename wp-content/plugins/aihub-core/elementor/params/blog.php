<?php

if( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class LQD_Blog {

	protected function get_grid_class() {

		$column = $this->atts['grid_columns'];
		$hash = array(
			'1' => '12',
			'2' => '6',
			'3' => '4',
			'4' => '3',
			'6' => '2'
		);

		if ( ! empty( $hash[ $column ] ) ) {
			$col = $hash[ $column ];
			if ( $col !== '12' ) {
				$col .= ' col-sm-6';
			}
			return sprintf( 'col-md-%s', $col );
		}

		return 'col-md-12';

	}

		/**
	 * [entry_term_classes description]
	 * @method entry_term_classes
	 * @return [type]             [description]
	 */
	protected function entry_term_classes() {

		$postcats = get_the_category();
		$cat_slugs = array();
		if ( count( $postcats ) > 0 ) :
			foreach ( $postcats as $postcat ):
				$cat_slugs[] = 	$postcat->slug;
			endforeach;
		endif;

		return implode( ' ', $cat_slugs );


	}

	protected function entry_tags( $classes = '' ) {

		$show_meta = $this->atts['show_meta'];
		if( 'no' === $show_meta ) {
			return;
		}

		global $post;

		$out = '';

		$meta_type    = $this->atts['meta_type'];
		$one_category = $this->atts['one_category'];
		$style = $this->atts['style'];

		$tags_list = wp_get_post_tags( $post->ID );

		$rel = 'rel="tag"';

		if( 'cats' === $meta_type ) {
			$tags_list = get_the_category( $post->ID );
			$rel = 'rel="category"';
		}

		$before       = '<ul class="lqd-lp-cat ' . esc_attr( $classes ) . '">';
		$after        = '</ul>';
		$before_link  = '<li>';
		$after_link   = '</li>';
		$before_label = '';
		$after_label  = '';

		if ( $tags_list ) {
			$out .= $before;
			if( 'yes' === $one_category ) {
				if( 'style05' == $this->atts['style'] ) {
					$out .= '<li class="rounded-6"><a class="lh-1" href="' . get_category_link( $tags_list['0']->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tags_list['0']->name ) . $after_label . '</a></li>';
				}
				elseif( 'style01' == $this->atts['style'] || 'style02' == $this->atts['style'] || 'style02-alt' == $this->atts['style'] || 'style03' == $this->atts['style'] || 'style06' == $this->atts['style'] || 'style06-alt' == $this->atts['style'] || 'style11' == $this->atts['style'] || 'style15' == $this->atts['style'] || 'style23' == $this->atts['style'] ) {
					$out .= '<li><a class="lh-15 rounded-full" href="' . get_category_link( $tags_list['0']->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tags_list['0']->name ) . $after_label . '</a></li>';
				}
				elseif( 'style10' == $this->atts['style'] ) {
					$out .= '<li><a class="lh-15 rounded-4" href="' . get_category_link( $tags_list['0']->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tags_list['0']->name ) . $after_label . '</a></li>';
				}
				else {
					$out .= '<li><a href="' . get_category_link( $tags_list['0']->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tags_list['0']->name ) . $after_label . '</a></li>';
				}

			}
			else {
				foreach( $tags_list as $tag ) {
					if( 'style05' == $this->atts['style'] ) {
						$out .= '<li class="rounded-6"><a href="' . get_category_link( $tag->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tag->name ) . $after_label . '</a></li>';
					}
					elseif( 'style01' == $this->atts['style'] || 'style02' == $this->atts['style'] || 'style02-alt' == $this->atts['style'] || 'style03' == $this->atts['style'] || 'style06' == $this->atts['style'] || 'style06-alt' == $this->atts['style'] || 'style11' == $this->atts['style'] || 'style15' == $this->atts['style'] || 'style23' == $this->atts['style'] ) {
						$out .= '<li><a class="lh-15 rounded-full" href="' . get_category_link( $tag->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tag->name ) . $after_label . '</a></li>';
					}
					elseif( 'style10' == $this->atts['style'] ) {
						$out .= '<li><a class="rounded-4" href="' . get_category_link( $tag->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tag->name ) . $after_label . '</a></li>';
					}
					else {
						$out .= '<li><a href="' . get_category_link( $tag->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $tag->name ) . $after_label . '</a></li>';
					}
				}
			}
			$out .= $after;
		}

		if( $out ) {
			printf( '<div><span class="screen-reader-text">%1$s </span>%2$s</div>',
				_x( 'Tags', 'Used before tag names.', 'aihub-core' ),
				$out
			);
		}

	}

	protected function entry_terms( $term = '', $classes = '' ) {

		global $post;

		$term_list = wp_get_object_terms( $post->ID, $term );

		$out = '';
		$before       = '<ul class="lqd-lp-cat ' . esc_attr( $classes ) . '">';
		$after        = '</ul>';
		$before_link  = '<li>';
		$after_link   = '</li>';
		$before_label = '';
		$after_label  = '';
		$rel = 'rel="category"';

		if ( $term_list ){

			$out .= $before;

			if ( $term === 'liquid-listing-category' ){
				$before_label = '<svg style="margin-right: 0.5em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 7l8.445-5.63a1 1 0 0 1 1.11 0L21 7v14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7zm9 4a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>';
			} elseif ( $term === 'liquid-listing-location' ){
				$before_label = '<svg style="margin-right: 0.5em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 17.938A8.001 8.001 0 0 1 12 2a8 8 0 0 1 1 15.938v2.074c3.946.092 7 .723 7 1.488 0 .828-3.582 1.5-8 1.5s-8-.672-8-1.5c0-.765 3.054-1.396 7-1.488v-2.074zM12 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>';
			}

			foreach( $term_list as $term ) {

				$out .= '<li><a class="items-center" href="' . get_category_link( $term->term_id ) . '" ' . $rel . '>' . $before_label . esc_html( $term->name ) . $after_label . '</a></li>';

			}

			$out .= $after;

		}

		if ( $out ){
			echo $out;
		}



	}

	protected function entry_time() {

		printf( '<time class="lqd-lp-date relative z-2" datetime="%s">', get_the_date( 'c' ) );
		echo liquid_helper()->liquid_post_date();
		echo '</time>';

	}

	protected function entry_title( $classes = '' ) {

		$style = $this->atts['style'];

		$format = get_post_format();
		if ( 'link' !== $format && is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
			return;
		}

		$url = 'link' == $format ? get_post_meta( get_the_ID(), 'post-link-url', true ) : get_permalink();
		$target = 'link' == $format ? 'target="_blank"' : '';

		the_title( sprintf( '<h2 class="entry-title lqd-lp-title %s"><a ' . $target . ' href="%s" rel="bookmark">', $classes, esc_url( $url ) ), '</a></h2>' );

	}

	protected function overlay_link() {

		$format = get_post_format();
		$url = 'link' == $format ? get_post_meta( get_the_ID(), 'post-link-url', true ) : get_permalink();
		$target = 'link' == $format ? 'target="_blank"' : '';

		echo '<a ' . $target . ' href="' . esc_url( $url ) . '" class="lqd-lp-overlay-link absolute top-0 start-0 z-2"></a>';

	}

	protected function entry_thumbnail( $size = 'liquid-thumbnail', $attr = '', $background = false ) {

		//Check
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		$figure_classnames = '';

		if( 'rounded' === $this->atts['style'] ) {
			$figure_classnames = 'rounded';
		}
		elseif( 'square' === $this->atts['style'] ) {
			$figure_classnames = 'round';
		}

		$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );
		$src = liquid_get_resized_image_src( $src, $size );

		$format = get_post_format();
		$style = $this->atts['style'];
		$url = 'link' == $format ? get_post_meta( get_the_ID(), 'post-link-url', true ) : get_permalink();
		$target = 'link' == $format ? 'target="_blank"' : '';

		if( has_post_thumbnail() ) {

			if( 'style01' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img"><figure class="rounded-2 overflow-hidden">' );
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-full' ), true );
				echo '</figure></div>';
			}
			elseif( 'style02-alt' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img absolute top-0 start-0 w-full h-full"><figure class="w-full h-full overflow-hidden">' );
				liquid_the_post_thumbnail( 'liquid-style3-lb', array( 'class' => 'w-full' ), true );
				echo '<div class="lqd-lp-content-bg absolute top-0 start-0"></div>';
				echo '</figure></div>';
			}
			elseif( 'style03' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img mb-5"><figure class="relative overflow-hidden rounded-6">' );
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-full' ), true );
				echo '<div class="absolute top-0 start-0 items-center justify-center">
			<div class="absolute top-0 start-0 lqd-overlay-bg"></div><!-- /.absolute top-0 start-0 lqd-overlay-bg -->
			<i class="lqd-icn-ess icon-md-arrow-forward"></i>
		</div><!-- /.absolute top-0 start-0 items-center justify-center -->';
				echo '</figure></div>';
			}
			elseif( 'style04' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img w-25"><figure class="relative overflow-hidden rounded-6">' );
				liquid_the_post_thumbnail( 'liquid-style4-lb', array( 'class' => 'w-full' ), true );
				echo '</figure></div>';
			}
			elseif( 'style05' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img mb-5 mb-md-0 w-md-50 w-full"><figure class="overflow-hidden rounded-6">' );
				liquid_the_post_thumbnail( 'liquid-style5-lb', array( 'class' => 'w-full' ), true );
				echo '</figure></div>';
			}
			elseif( 'style06' == $this->atts['style'] ) {
				printf( '<figure>' );
				liquid_the_post_thumbnail( 'liquid-style6-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style06-alt' == $this->atts['style'] || 'style23' == $this->atts['style'] ) {
				printf( '<figure>' );
				liquid_the_post_thumbnail( 'liquid-style6-alt-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style07' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img overflow-hidden rounded-6 mb-6"><figure>' );
				liquid_the_post_thumbnail( 'liquid-style5-lb', array( 'class' => 'w-full' ), true );
				echo '</figure></div>';
			}
			elseif( 'style09' == $this->atts['style'] ) {
				liquid_the_post_thumbnail( 'liquid-style9-lb', array( 'class' => 'w-full' ), true );
			}
			elseif( 'style10' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img absolute top-0 start-0"><figure class="relative bg-cover bg-center w-full">' );
				liquid_the_post_thumbnail( 'liquid-style5-lb', array( 'class' => 'w-full' ), true );
				echo '</figure></div>';
			}
			elseif( 'style11' == $this->atts['style'] ) {
				printf( '<div class="lqd-lp-img absolute top-0 start-0"><figure class="relative bg-cover bg-center w-full">' );
				liquid_the_post_thumbnail( 'liquid-style5-lb', array( 'class' => 'w-full' ), true );
				echo '</figure></div>';
			}
			elseif( 'style13' == $this->atts['style'] ) {
				printf( '<figure class="relative overflow-hidden">' );
				liquid_the_post_thumbnail( 'liquid-style5-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style14' == $this->atts['style'] ) {
				printf( '<figure class="relative bg-cover bg-center w-full">' );
				liquid_the_post_thumbnail( 'liquid-style5-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style17' == $this->atts['style'] ) {
				printf( '<figure class="relative bg-cover bg-center w-full">' );
				liquid_the_post_thumbnail( 'liquid-style18-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style16' == $this->atts['style'] ) {
				printf( '<figure class="relative bg-cover bg-center w-full">' );
				liquid_the_post_thumbnail( $size, array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style18' == $this->atts['style'] ) {
				printf( '<figure>' );
				liquid_the_post_thumbnail( 'liquid-style18-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style19' == $this->atts['style'] ) {
				printf( '<figure class="relative overflow-hidden">' );
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style20' == $this->atts['style'] ) {
				printf( '<figure class="relative">' );
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-full' ), true );
				echo '</figure>';
			}
			elseif( 'style21' == $this->atts['style'] ) {
				printf( '<figure class="absolute pos-tl w-full h-full">' );
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-full' ), true );
				echo '<div class="absolute top-0 start-0 items-center justify-center"><i class="lqd-icn-ess icon-md-arrow-forward"></i></div><!-- /.absolute top-0 start-0 items-center justify-center -->';
				echo '</figure>';
			}
			elseif( 'style22' == $this->atts['style'] || 'style22-alt' == $this->atts['style'] ) {
					printf( '<figure>' );
					liquid_the_post_thumbnail( $size, array( 'class' => 'w-full' ), true );
					echo '</figure>';
			}
			else {
				printf( '<figure class="lqd-lp-img %s">', $figure_classnames );
				liquid_the_post_thumbnail( $size, $attr, true );
				echo '</figure>';

			}

		}

	}

	protected function entry_content( $class = '' ) {

		$style = $this->atts['style'];

		if( empty( $class ) ) {
			$class = 'lqd-lp-excerpt w-80 mb-3';
		}

		if( !is_single() ) :

	?>
			<div class="<?php echo $class; ?>">
				<?php
					add_filter( 'excerpt_length', array( $this, 'excerpt_lengh' ), 999 );
					add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
					add_filter( 'liquid_dinamic_css_output', array( $this, 'clean_excerpt' ) );
					the_excerpt();
					remove_filter( 'liquid_dinamic_css_output', array( $this, 'clean_excerpt' ) ); ?>
			</div><!-- /.latest-post-excerpt -->
		<?php else: ?>
			<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Continue reading %s', 'aihub-core' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'aihub-core' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'aihub-core' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
	    </div>
	<?php endif;

	}

	public function excerpt_lengh( $length ) {

		if( !isset( $this->atts['post_excerpt_length'] ) ) {
			return '20';
		}
		return $this->atts['post_excerpt_length'];
	}

	public function excerpt_more( $more ) {

		if( !isset( $this->atts['post_excerpt_length'] ) ) {
			return $more;
		}
		return '';

	}

	public function clean_excerpt() {
		return false;
	}

	public function entry_read_more_button() {

		return 'yes';

	}


}
new LQD_Blog;