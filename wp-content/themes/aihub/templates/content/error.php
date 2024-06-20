<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Hub theme
 */
?>

<div class="lqd-container ms-auto me-auto mb-60">
	<div class="w-full mx-auto text-center">
		<section class="no-results not-found pt-60 pb-60">
			<header class="page-header pt-60">
				<h2 class="page-title mt-0 mb-20 text-30"><?php esc_html_e( 'We couldn\'t find any results.', 'aihub' ); ?></h2>
			</header>

			<div class="page-content">

				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'aihub' ), 'a' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

				<?php elseif ( is_search() ) : ?>

					<p class="text-22"><?php esc_html_e( 'Maybe try something else?', 'aihub' ); ?></p>
					<?php get_search_form(); ?>

				<?php else : ?>

					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'aihub' ); ?></p>
					<?php get_search_form(); ?>

				<?php endif; ?>

			</div>
		</section>
	</div>
</div>
