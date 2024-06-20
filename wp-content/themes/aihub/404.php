<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Hub theme
 */

get_header();

$data_content = liquid_helper()->get_kit_option( 'liquid_error_404_content' );

$is_elementor = defined( 'ELEMENTOR_VERSION' );
$classnames = array(
	'page-404',
	'error-404',
	'not-found',
	'entry',
	$is_elementor ? 'elementor' : ''
);

?>
<article id="post-404" class="<?php echo esc_attr(implode(' ', $classnames)) ?>">

	<div class="lqd-container ms-auto me-auto">
        <div class="w-full mx-auto text-center">

            <div class="text-404">

                <h1 class="liquid-counter-element text-primary">
                    <span><?php echo esc_html( liquid_helper()->get_kit_option( 'liquid_error_404_title' ) ) ?></span>
                </h1>

            </div>

            <?php if( !class_exists( 'Liquid_Addons' ) ) : ?>

                <h1 class="mb-20"><?php esc_html_e( 'Looks like you are lost.', 'aihub' ); ?></h1>
                <p class="mb-36 text-20 opacity-70"><?php esc_html_e( 'We can’t seem to find the page you’re looking for.', 'aihub' ) ?></p>
                <a href="<?php echo esc_url( home_url('/') ) ?>" class="lqd-btn inline-flex items-center pt-16 pb-16 px-32 ps-32 pe-32 rounded-full bg-primary shadow-md transition-all">
                    <span class="lqd-btn-txt relative"><?php esc_html_e( 'Back to home', 'aihub' ); ?></span>
                    <span class="lqd-btn-icon inline-flex items-center justify-center relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path d="M5.313 17.336h16.231l-7.481 7.481L16 26.687 26.688 16 16 5.312l-1.87 1.87 7.414 7.482H5.312v2.672z" fill="currentColor"></path></svg>
                    </span>
                </a>

            <?php else : ?>

                <h1 class="mb-20"><?php echo esc_html( liquid_helper()->get_kit_option( 'liquid_error_404_subtitle' ) ) ?></h1>
                <?php if( !empty( $data_content ) ) : ?>
                    <p class="mb-36 text-20 opacity-70"><?php echo wp_kses( $data_content, 'lqd_post' ); ?></p>
                <?php endif ?>
                <?php if( 'on' === liquid_helper()->get_kit_option( 'liquid_error_404_enable_btn' ) ) { ?>
                    <a href="<?php echo esc_url( home_url('/') ) ?>" class="lqd-btn inline-flex items-center pt-16 pb-16 px-32 ps-32 pe-32 rounded-full bg-primary shadow-md transition-all">
                    <span class="lqd-btn-txt relative"><?php echo esc_html( liquid_helper()->get_kit_option( 'liquid_error_404_btn_title' ) ) ?></span>
                    <span class="lqd-btn-icon inline-flex items-center justify-center relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path d="M5.313 17.336h16.231l-7.481 7.481L16 26.687 26.688 16 16 5.312l-1.87 1.87 7.414 7.482H5.312v2.672z" fill="currentColor"></path></svg>
                    </span>
                </a>
                <?php } ?>
            <?php endif; ?>

        </div>
	</div>

</article>

<?php get_footer();