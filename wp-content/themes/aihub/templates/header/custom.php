<?php
/**
 * Default header template
 *
 * @package Hub
 */

$header = liquid_get_header_layout();

if( function_exists( 'icl_object_id' ) ) {
    $header['id'] = icl_object_id( $header['id'], 'page', false, ICL_LANGUAGE_CODE );
}
if ( function_exists( 'pll_get_post' ) ) {
    $header['id'] = pll_get_post( $header['id'] );
}


?>
<header <?php liquid_helper()->attr( 'header', $header['attributes'] ); ?>>

    <?php liquid_helper()->get_elementor_edit_cpt( $header['id'], 'Header' ); ?>

    <div id="lqd-page-header" data-lqd-view="liquidPageHeader">
        <?php
        liquid_action( 'before_header_tag' );

        if ( defined( 'ELEMENTOR_VERSION' ) ){

            $cache = liquid_helper()->get_kit_option('liquid_header_cache');

            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() || liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal' ) {
                $content = Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header['id'] );
            } elseif( ! $cache  ) {
                $content = Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header['id'] );
                // $has_bg_ids = get_option( 'lqd_el_container_bg' );
                // $content = liquid_helper()->lqd_el_container_bg( $content, $has_bg_ids );
            } else {
                $content = get_post_meta($header['id'], '_liquid_post_content', true);
                if (!$content) {
                    $content = Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header['id'], true );
                    update_post_meta( $header['id'], '_liquid_post_content', $content );
                }

                $has_bg = get_post_meta($header['id'], '_liquid_post_content_has_bg', true);
                $has_bg_ids = get_option( 'lqd_el_container_bg' );
                if (!$has_bg && $has_bg_ids) {
                    $content = liquid_helper()->lqd_el_container_bg( $content, $has_bg_ids );
                    update_post_meta( $header['id'], '_liquid_post_content', $content );
                    update_post_meta( $header['id'], '_liquid_post_content_has_bg', 'yes' );
                }
            }

            echo $content;

        }

        liquid_action( 'after_header_tag' );
        ?>
    </div>
</header>