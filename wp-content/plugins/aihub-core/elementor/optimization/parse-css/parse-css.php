<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('Liquid_Elementor_Parse_CSS')) :

    class Liquid_Elementor_Parse_CSS{

        private $rules = array();
        private $preset_css;
		private static $widgets = array(
			'lqd-image',
			'lqd-box'
		);

        public function __construct(){

            $this->init_hooks();

        }

        private function init_hooks(){

            include_once 'css.php';
            add_action( 'elementor/element/parse_css', [ $this, 'prepare_widget_css' ], 10, 2 );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_widget_css'], 10 );

        }

        function prepare_widget_css( $post_css_file, $element ) {

            $element_name = $element->get_name();

			if ( in_array( $element->get_name(), self::$widgets ) ){
				if ( !empty( $element->get_utility_classnames() ) ) {
					$this->rules = array_merge( $this->rules, $element->get_utility_classnames() );
				}
			}

            $this->rules = array_unique($this->rules);

        }

        function enqueue_widget_css(){

			$cached = get_option( 'liquid_widget_asset_css', array() );

			if ( $this->rules ) {
				$css = $this->generate_css_by_classnames($this->rules);
				$cached[get_the_ID()] = $css;
				update_option( 'liquid_widget_asset_css', $cached );
			} else {
				$css = isset( $cached[get_the_ID()] ) ? $cached[get_the_ID()] : '';
			}

			if ( !empty( $css ) ) {
				wp_add_inline_style( 'liquid-base', $css );
			}

			$this->generate_default_css_file(); // generate & enqueue css file

        }

        function sanitize_css_classes( $class ){

            return str_replace( array(':', '/'), array('\:', '\/'), $class );

        }

        function generate_css_by_classnames( $classnames ){

            $css = $mobile = $mobile_extra = $tablet = $tablet_extra = $laptop = '';

            if ( !$classnames ){
                return;
            }

            foreach( $classnames as $class ){

                if ( isset( $this->preset_css[$class] ) ){

                    if ( strpos( $class, "laptop:" ) !== false ){
                        $laptop .= $this->sanitize_css_classes($class) . '{' . $this->preset_css[$class] . '}';
                    } else if ( strpos( $class, "tablet-extra:" ) !== false ){
                        $tablet_extra .= $this->sanitize_css_classes($class) . '{' . $this->preset_css[$class] . '}';
                    } else if ( strpos( $class, "tablet:" ) !== false ){
                        $tablet .= $this->sanitize_css_classes($class) . '{' . $this->preset_css[$class] . '}';
                    } else if ( strpos( $class, "mobile-extra:" ) !== false ){
                        $mobile_extra .= $this->sanitize_css_classes($class) . '{' . $this->preset_css[$class] . '}';
                    } else if ( strpos( $class, "mobile:" ) !== false ){
                        $mobile .= $this->sanitize_css_classes($class) . '{' . $this->preset_css[$class] . '}';
                    } else {
                        $css .= $class . '{' . $this->preset_css[$class] . '}';
                    }

                }

            }

            if ( !empty( $laptop ) ){
                $css .= '@media (max-width: ' . $this->get_breakpoint('laptop') . 'px){' . $laptop . '}';
            }

            if ( !empty( $tablet_extra ) ){
                $css .= '@media (max-width: ' . $this->get_breakpoint('tablet_extra') . 'px){' . $tablet_extra . '}';
            }
			if ( !empty( $tablet ) ){
                $css .= '@media (max-width: ' . $this->get_breakpoint('tablet') . 'px){' . $tablet . '}';
            }


            if ( !empty( $mobile_extra ) ){
                $css .= '@media (max-width: ' . $this->get_breakpoint('mobile_extra') . 'px){' . $mobile_extra . '}';
            }
            if ( !empty( $mobile ) ){
                $css .= '@media (max-width: ' . $this->get_breakpoint('mobile') . 'px){' . $mobile . '}';
            }

            return $css;

        }

        function generate_default_css_file() {

			$uploads = wp_upload_dir();
			$file_path = '/liquid-styles/liquid-utils.css';
			$cached = get_option( 'liquid_utils_css', '' );

			// TODO: Add dev mode option
			if( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				$cached = '';
			}
			
			if ( ! $cached ) {

				$classnames = $this->preset_css;
				$css = $mobile = $mobile_extra = $tablet = $tablet_extra = $laptop = '';

				foreach( $classnames as $class => $rule ){

					if ( strpos( $class, "mobile:" ) !== false ){
						$mobile .= $this->sanitize_css_classes($class) . '{' . $rule . '}';
					} else if ( strpos( $class, "mobile-extra:" ) !== false ){
						$mobile_extra .= $this->sanitize_css_classes($class) . '{' . $rule . '}';
					} else if ( strpos( $class, "tablet:" ) !== false ){
						$tablet .= $this->sanitize_css_classes($class) . '{' . $rule . '}';
					} else if ( strpos( $class, "tablet-extra:" ) !== false ){
						$tablet_extra .= $this->sanitize_css_classes($class) . '{' . $rule . '}';
					} else if ( strpos( $class, "laptop:" ) !== false ){
						$laptop .= $this->sanitize_css_classes($class) . '{' . $rule . '}';
					} else {
						$css .= $class . '{' . $rule . '}';
					}

				}

				if ( !empty( $laptop ) ){
					$css .= '@media (max-width: ' . $this->get_breakpoint('laptop') . 'px){' . $laptop . '}';
				}

				if ( !empty( $tablet_extra ) ){
					$css .= '@media (max-width: ' . $this->get_breakpoint('tablet_extra') . 'px){' . $tablet_extra . '}';
				}
				if ( !empty( $tablet ) ){
					$css .= '@media (max-width: ' . $this->get_breakpoint('tablet') . 'px){' . $tablet . '}';
				}

				if ( !empty( $mobile_extra ) ){
					$css .= '@media (max-width: ' . $this->get_breakpoint('mobile_extra') . 'px){' . $mobile_extra . '}';
				}
				if ( !empty( $mobile ) ){
					$css .= '@media (max-width: ' . $this->get_breakpoint('mobile') . 'px){' . $mobile . '}';
				}

				// write rules into css file
				$styles_folder = $uploads['basedir'] . DIRECTORY_SEPARATOR . 'liquid-styles';
				if ( !file_exists( $styles_folder ) ) {
					wp_mkdir_p( $styles_folder );
				}

				file_put_contents( $uploads['basedir'] . $file_path, $css );
				update_option( 'liquid_utils_css', $css );
			}

			wp_enqueue_style( 'liquid-utils', set_url_scheme( $uploads['baseurl'] . $file_path ), ['liquid-wp-style'], null );
			if ( !liquid_helper()->is_page_elementor() ) {
				wp_enqueue_style( 'liquid-site-settings', set_url_scheme( $this->get_css_site_settings(), ['liquid-utils'] ), null );
			}

        }

        function get_breakpoint( $b ){

            $breakpoint = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'viewport_' . $b );

            $defaults = [
                'viewport_mobile' => 767,
                'viewport_mobile_extra' => 880,
                'viewport_tablet' => 1024,
                'viewport_tablet_extra' => 1200,
                'viewport_laptop' => 1366,
                'viewport_widescreen' => 2400,
            ];

            if ( $breakpoint ){
                return $breakpoint;
            } else {
                return $defaults['viewport_'.$b];
            }

        }

		function get_css_site_settings() {

			$kit_id = get_option('elementor_active_kit');
			$path = wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'elementor/css/post-' . $kit_id . '.css';
			$url = wp_upload_dir()['baseurl'] . DIRECTORY_SEPARATOR . 'elementor/css/post-' . $kit_id . '.css';
	
			if ( !file_exists( $path ) ){
				if ( ! empty( $val = get_post_meta( $kit_id, '_elementor_css', true ) ) ) {
					if ( isset( $val['css'] ) ) {
						file_put_contents( $path , $val['css'] );
					}
				}
			}
			
			return $url;
		}

    }
    new Liquid_Elementor_Parse_CSS();

endif;