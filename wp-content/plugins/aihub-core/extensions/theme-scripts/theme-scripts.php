<?php

/**
 * Class for "Performance"
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('Liquid_Theme_Assets_Extended')) :

    class Liquid_Theme_Assets_Extended extends Liquid_Base{

        public function __construct(){

			if ( function_exists('liquid_helper') ) {
				$this->init_hooks();
			}

        }

        private function init_hooks(){

            $this->add_action( 'wp_enqueue_scripts', 'lqd_enqueue', 9999 );

            if ( liquid_helper()->get_kit_option( 'liquid_disable_wp_emojis' ) === 'off' ){
                $this->add_action( 'init', 'disable_emojis' );
            }

            if ( liquid_helper()->get_kit_option( 'liquid_lazy_load' ) === 'on' ){
                add_filter('kses_allowed_protocols', function ($protocols) {
                    $protocols[] = 'data';
                    return $protocols;
                });
            }

        }

        function lqd_enqueue(){

            // disable css
            $disable_css = liquid_helper()->get_kit_option('liquid_disable_css');
            if ( is_array( $disable_css ) ){
                foreach ( $disable_css as $style){
                    wp_deregister_style($style);
                    wp_dequeue_style($style);
                }
            }

            // Manage wp and plugins scripts
            if ( liquid_helper()->get_kit_option( 'liquid_disable_cf7_js' ) === 'off' ){
                $this->apply_script_action( 'deq', 'contact-form-7' );
            }
            if ( liquid_helper()->get_kit_option( 'liquid_disable_cf7_css' ) === 'off' ){
                $this->apply_style_action( 'deq', 'contact-form-7' );
            }
            if ( liquid_helper()->get_kit_option( 'liquid_disable_wc_cart_fragments' ) === 'off' ){
                $this->apply_script_action( 'deq', 'wc-cart-fragments' );
            }

			if ( liquid_helper()->get_kit_option( 'liquid_jquery_rearrange' ) === 'on' ) {
				$this->jquery_rearrange();
			}

            if ( defined( 'ELEMENTOR_VERSION' ) ){

                if ( !\Elementor\Plugin::$instance->preview->is_preview_mode() ){

                    // elementor animations
                    if ( liquid_helper()->get_kit_option( 'liquid_elementor_animations_css' ) === 'off' ){
                        $this->apply_style_action( 'deq', 'e-animations' );
                    }

                    // elementor icons
                    if ( liquid_helper()->get_kit_option( 'liquid_elementor_icons_css' ) === 'off' ){
                        $this->apply_style_action( 'deq', 'elementor-icons' );
                    }

                    // elementor dialog.js
                    if ( liquid_helper()->get_kit_option( 'liquid_elementor_dialog_js' ) === 'off' ){
                        $this->apply_script_action( 'deq', 'elementor-dialog' );
                    }

                    // elementor frontend.js
                    if ( liquid_helper()->get_kit_option( 'liquid_elementor_frontend_js' ) === 'off' ){
                        $this->apply_script_action( 'deq', 'elementor-frontend' );
                    }

                }
            }

        }

        // enq or deq scripts
        function apply_script_action( $action, $handle ){
            switch( $action ){
                case 'deq':
                    wp_deregister_script( $handle );
                    wp_dequeue_script( $handle );
                break;
                case 'enq':
                    wp_enqueue_script( $handle );
                break;
            }
        }

        // enq or deq styles
        function apply_style_action( $action, $handle ){
            switch( $action ){
                case 'deq':
                    wp_deregister_style( $handle );
                    wp_dequeue_style( $handle );
                break;
                case 'enq':
                    wp_enqueue_style( $handle );
                break;
            }
        }

        function disable_emojis() {
            remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'wp_print_styles', 'print_emoji_styles' );
            remove_action( 'admin_print_styles', 'print_emoji_styles' );
            remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
            remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
            remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        }

		function jquery_rearrange() {
			wp_dequeue_script('jquery');
			wp_dequeue_script('jquery-core');
			wp_dequeue_script('jquery-migrate');
			wp_enqueue_script('jquery', false, array(), false, true);
			wp_enqueue_script('jquery-core', false, array(), false, true);
			wp_enqueue_script('jquery-migrate', false, array(), false, true);
		}

    }
    new Liquid_Theme_Assets_Extended();

endif;