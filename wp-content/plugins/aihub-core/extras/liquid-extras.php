<?php

function liquid_woo_share( $args = array() ) {


	if( !liquid_helper()->get_kit_option( 'liquid_wc_share_enable' ) ) {
		return;
	}

	if ( $social_links = liquid_helper()->get_kit_frontend_option( 'liquid_wc_social_links' ) ) {

		$defaults = array(
			'class' => 'flex flex-wrap items-center gap-20 list-none p-0 m-0',
			'before' => '',
			'after' => '',
		);

		extract( wp_parse_args( $args, $defaults ) );

		$url = esc_url( get_the_permalink() );
		$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );

		$crunchifyURL       = urlencode( get_permalink() );
		$crunchifyTitle     = str_replace( ' ', '%20', get_the_title());
		$crunchifyThumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );

		if ( !empty( $before ) ) { echo $before; }
		printf( '<ul class="lqd-social-icon-wc %s">', $class );
		foreach ( $social_links as $link ) {

			$type = isset( $link['type'] ) ? $link['type'] : 'custom';

			switch ( $type ) {
				case 'facebook':
					?>
					<li>
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $crunchifyURL . '&amp;t=' . $crunchifyTitle ); ?>">
							<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
						</a>
					</li>
					<?php
					break;
				case 'twitter':
					?>
					<li>
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( 'https://twitter.com/intent/tweet?text=' . $crunchifyTitle . '&amp;url=' . $crunchifyURL ); ?>">
						<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
						</a>
					</li>
					<?php
					break;
				case 'pinterest':
					if( ! empty( $pinterest_image ) ) {
						?>
						<li>
							<a rel="nofollow" target="_blank" href="<?php echo esc_url( 'https://pinterest.com/pin/create/button/?url=' . $crunchifyURL . '&amp;media=' . $crunchifyThumbnail . '&amp;description=' . $crunchifyTitle ); ?>">
							<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
							</a>
						</li>
						<?php
					}
					break;
				case 'linkedin':
					?>
					<li>
						<a rel="nofollow" target="_blank" href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . $crunchifyURL . '&amp;title=' . $crunchifyTitle . '&amp;source=' . get_bloginfo( "name" ) ); ?>">
							<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
						</a>
					</li>
					<?php
					break;
				default:
					?>
					<li>
						<a rel="nofollow" target="_blank" href="<?php echo esc_url($link['link']['url']); ?>">
						<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
						</a>
					</li>
					<?php
					break;
			}


		}
		?></ul><?php
		if ( !empty( $after ) ) { echo $after; }
	}
}
add_action( 'woocommerce_share', 'liquid_woo_share' );

if( ! function_exists( 'liquid_portfolio_share' ) ) {

	function liquid_portfolio_share( $post_type = 'post', $args = array(), $echo = true ) {

		if ( class_exists( 'Liquid_Addons' ) ){

			if ( !$post_social_box_enable = liquid_helper()->get_page_option( 'post_social_box_enable' ) ){
				$post_social_box_enable = liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_social_box_enable' );
			}
		} else {
			$post_social_box_enable = liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_social_box_enable' );
		}


		if ( 'off' === $post_social_box_enable || empty( $post_social_box_enable ) ) {
			return;
		}

		if ( $social_links = liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_social_links' ) ) {

			$defaults = array(
				'class' => 'social-icon flex items-center list-none p-0 m-0',
				'before' => '',
				'after' => '',
			);

			extract( wp_parse_args( $args, $defaults ) );

			$url = esc_url( get_the_permalink() );
			$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
			if ( !empty( $before ) ) { echo $before; }
			printf( '<ul class="lqd-social-icon-blog gap-20 text-16 %s">', $class );
			foreach ( $social_links as $link ) {

				$type = isset( $link['type'] ) ? $link['type'] : 'custom';

				switch ( $type ) {
					case 'facebook':
						?>
						<li>
							<a rel="nofollow" target="_blank" href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u='. $url ); ?>">
								<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
							</a>
						</li>
						<?php
						break;
					case 'twitter':
						?>
						<li>
							<a rel="nofollow" target="_blank" href="<?php echo esc_url('https://twitter.com/intent/tweet?text=' . get_the_title() .'&amp;url='. $url ); ?>">
							<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
							</a>
						</li>
						<?php
						break;
					case 'pinterest':
						if( ! empty( $pinterest_image ) ) {
							?>
							<li>
								<a rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/button/?url=&amp;media=<?php echo esc_url( $pinterest_image ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>">
								<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
								</a>
							</li>
							<?php
						}
						break;
					case 'linkedin':
						?>
						<li>
							<a rel="nofollow" target="_blank" href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&amp;title=' . get_the_title() . '&amp;source=' . get_bloginfo( "name" ) ); ?>">
								<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
							</a>
						</li>
						<?php
						break;
					default:
						?>
						<li>
							<a rel="nofollow" target="_blank" href="<?php echo esc_url($link['link']['url']); ?>">
							<?php \LQD_Elementor_Helper::render_icon( $link['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] ); ?>
							</a>
						</li>
						<?php
						break;
				}


			}
			?></ul><?php
			if ( !empty( $after ) ) { echo $after; }
		}

	}
}