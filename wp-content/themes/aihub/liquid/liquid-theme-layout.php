<?php
/**
 * Liquid Themes Theme Framework
 */

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

/**
 * Liquid_Theme_Layout
 */
#[AllowDynamicProperties]
class Liquid_Theme_Layout extends Liquid_Base {

	public function __construct() {

		$this->add_action( 'wp', 'init' );
		$this->add_filter( 'body_class', 'body_classes' );

		$this->add_action( 'liquid_attr_contents_wrap', 'start_container' );

		$this->add_action( 'liquid_before_content', 'start_row_wrapper' );
		$this->add_action( 'liquid_after_content', 'end_row_wrapper' );

		$this->add_action( 'liquid_after_content', 'end_container' );

		$this->add_action( 'liquid_single_post_sidebar', 'add_single_post_sidebar' );
		$this->add_action( 'liquid_start_single_post_container', 'start_single_post_container' );
		$this->add_action( 'liquid_end_single_post_container', 'end_single_post_container' );

	}

	public function init() {

		// Get the sidebars and assign to public variable.
		$this->sidebars = $this->setup_sidebar( $this->setup_options() );

        if ( $this->has_sidebar() ) {
			wp_enqueue_style( 'liquid-theme-sidebar', get_template_directory_uri() . '/assets/css/sidebar/sidebar.css', [ 'liquid-theme', 'liquid-theme-utils' ], null, false );
		}
	}

	public function body_classes( $classes ) {

		if( $this->has_sidebar() ) {
			$classes[] = 'has-sidebar';

			if( 'left' === $this->sidebars['position'] ) {
				$classes[] = 'has-left-sidebar';
			}
		}

		if( isset( $this->sidebars['hide_on_mobile'] ) && $this->sidebars['hide_on_mobile'] === 'on' ) {
			$classes[] = 'lqd-hide-sidebar-on-mobile';
		}

		return $classes;
	}

	public function start_container( $attributes ) {

		if( is_404() ) {
			return;
		}

		global $post;
		$content = '';

		if( $post ) {
			$content = $post->post_content;
		}

		$sp_custom_layout_enable = get_post_meta( get_the_ID(), 'liquid_product_layout_enable', true );

		if ( $sp_custom_layout_enable === 'on' ) {
			$sp_custom_layout = get_post_meta( get_the_ID(), 'liquid_product_layout', true );
		} elseif ( $sp_custom_layout_enable === '0' || empty( $sp_custom_layout_enable ) ) {
			$sp_custom_layout_enable = liquid_helper()->get_kit_option( 'liquid_wc_custom_layout_enable' );
			$sp_custom_layout = liquid_helper()->get_kit_option( 'liquid_wc_custom_layout' );
		}

		if( ( 'on' === $sp_custom_layout_enable && !empty( $sp_custom_layout ) && is_singular( 'product' ) ) ) {
			unset( $attributes['class'] );
		}

		$attributes['data-lqd-view'] = 'liquidPageContent';

		return $attributes;

	}

	public function end_container() {

		if( is_404() ) {
			return;
		}

		global $post;
		$content = '';

		if( $post ) {
			$content = $post->post_content;
		}

		if( !is_singular( 'post' )
			|| is_search()
			|| is_home()
			|| is_category()
			|| is_tag()
			|| is_author()
			|| is_post_type_archive( 'liquid-portfolio' )
			|| is_tax( 'liquid-portfolio-category' )
			|| class_exists( 'WooCommerce' ) && is_product_taxonomy()
			|| class_exists( 'WooCommerce' ) && is_product_category()
			|| class_exists( 'WooCommerce' ) && is_singular( 'product' )
			|| $this->has_sidebar()
		) :
			//echo '</div><!-- #site-container -->';
		endif;
	}

	public function start_row_wrapper() {
		$types = apply_filters( 'liquid_single_post_types', 'post' );
		// Example - add_filter( 'liquid_single_post_types' , function(){ return array('post', 'my-cpt', 'my-cpt2'); } );

		if( is_singular( $types ) || is_404() ) {
			return;
		}

        $content_class = '';

        /**
         * @TODO: if making any changes here don't forget to update end_row_wrapper() as well
         */
		if( $this->has_sidebar() ) {
            if ( !is_singular() ) {
                $content_class = 'lqd-contents lqd-container grid columns-3 gap-30 ms-auto me-auto tablet:columns-2 mobile:columns-1 mb-60';
            } else {
                $content_class = 'lqd-contents';
            }
		} else {

            if ( ( !class_exists( 'Liquid_Addons' ) || !defined( 'ELEMENTOR_VERSION' ) ) ) {
                $content_class = 'lqd-contents lqd-container grid columns-3 gap-30 ms-auto me-auto tablet:columns-2 mobile:columns-1 mb-60';
                if ( is_singular() ) {
                    $content_class = 'lqd-contents lqd-container ms-auto me-auto mb-60';
                }
            }

            if (
                !liquid_helper()->is_page_elementor() ||
                (
                    class_exists( 'WooCommerce' ) &&
                    ( is_shop() || is_product() || is_cart() || is_checkout() || is_account_page() || ( get_option( 'woocommerce_thanks_page_id' ) && is_page( get_option( 'woocommerce_thanks_page_id' ) ) ) )
                )
            ) {
                $content_class = 'lqd-contents lqd-container ms-auto me-auto mb-60';
            }

            if (
                (
                    ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ||
                    liquid_helper()->is_page_elementor()
                ) &&
                // in case if titlewrapper enabled in woo pages
                !(
                    class_exists( 'WooCommerce' ) &&
                    ( is_shop() || is_product() || is_cart() || is_checkout() || is_account_page() || ( get_option( 'woocommerce_thanks_page_id' ) && is_page( get_option( 'woocommerce_thanks_page_id' ) ) ) )
                )
            ) {
                $content_class = 'lqd-contents';
            }

        }

		$content_class = apply_filters( 'liquid_single_post_class', $content_class );
		if ( $content_class ) {
			echo '<div class="'. $content_class .'">';
		}

	}

	public function end_row_wrapper() {
		$types = apply_filters( 'liquid_single_post_types', 'post' );
        $close_tag = null;

		if( is_singular( $types ) || is_404() ) {
			return;
		}

		if( $this->has_sidebar() ) {
			echo '</div><!-- /.lqd-contents -->';
			get_template_part( 'templates/sidebar' );
            return;
		}

        // basically same conditions as in start_row_wrapper()
        if (
            ( !class_exists( 'Liquid_Addons' ) || !defined( 'ELEMENTOR_VERSION' ) ) ||
            (
                !liquid_helper()->is_page_elementor() ||
                (
                    class_exists( 'WooCommerce' ) &&
                    ( is_shop() || is_product() || is_cart() || is_checkout() || is_account_page() || ( get_option( 'woocommerce_thanks_page_id' ) && is_page( get_option( 'woocommerce_thanks_page_id' ) ) ) )
                )
            ) ||
            (
                (
                    ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ||
                    liquid_helper()->is_page_elementor()
                ) &&
                // in case if titlewrapper enabled in woo pages
                !(
                    class_exists( 'WooCommerce' ) &&
                    ( is_shop() || is_product() || is_cart() || is_checkout() || is_account_page() || ( get_option( 'woocommerce_thanks_page_id' ) && is_page( get_option( 'woocommerce_thanks_page_id' ) ) ) )
                )
            )
        ) {
            $close_tag = true;
        }

        if ( $close_tag ) {
            echo '</div><!-- /.lqd-contents -->';
        }
	}

	public function start_single_post_container() {

		if( !$this->has_sidebar() ) {
			return;
		}

		$content_class = 'lqd-contents';

		$content_class = apply_filters( 'liquid_single_post_container', $content_class );

		echo '<div class="'. $content_class .'">';
	}

	public function end_single_post_container() {

		if( !$this->has_sidebar() ) {
			return;
		}

		echo '</div><!-- /.lqd-contents -->';

	}

	public function add_single_post_sidebar() {
		if( $this->has_sidebar() ) {
			get_template_part( 'templates/sidebar' );
		}
	}

	public function setup_sidebar( $sidebar_options ) {

        $sidebar = null;

		if( ( !class_exists( 'Liquid_Addons' ) || !defined( 'ELEMENTOR_VERSION' ) ) && is_active_sidebar( 'main' ) ) {
			$sidebar          = 'main';
			$sidebar_position = 'right';
		}
		else {
			// Post Options.
			if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
				if ( liquid_helper()->check_post_types() ) {
					return;
				}
				$sidebar='';
			}
		}

		$opts_sidebar = isset( $sidebar_options['sidebar'] ) ? $sidebar_options['sidebar'] : '';
		// Setting Default
		$sidebar_position = $sidebar ? $sidebar_position : 'default';
		$sidebar = $sidebar ? $sidebar : $opts_sidebar;

		// Theme options.
		$sidebar_position_theme_option = array_key_exists( 'position', $sidebar_options ) ? strtolower( $sidebar_options['position'] ) : '';

		// Get sidebars and position from theme options if it's being forced globally.
		if ( array_key_exists( 'global', $sidebar_options ) && 'on' === $sidebar_options['global'] ) {
			$sidebar = ( '' != $sidebar_options['sidebar'] ) ? $sidebar_options['sidebar'] : '';
			$sidebar_position = $sidebar_position_theme_option;
		}

		// If sidebar position is default OR no entry in database exists.
		if ( 'default' === $sidebar_position ) {
			$sidebar_position = $sidebar_position_theme_option;
		}

		$return = array( 'position' => $sidebar_position );
		$return['hide_on_mobile'] = isset($sidebar_options['hide_on_mobile']) ? $sidebar_options['hide_on_mobile'] : '';

		if ( $sidebar && 'none' !== $sidebar ) {
			$return['sidebar'] = $sidebar;
		}

		return $return;
	}

	public function has_sidebar( $which = '1' ) {

		if( is_array( $this->sidebars ) && isset( $this->sidebars['sidebar'] ) && ! empty( $this->sidebars['sidebar'] ) ) {
			return true;
		}

		return false;
	}

	public function has_double_sidebars() {

		if( $this->has_sidebar('1') && $this->has_sidebar('2') ) {
			return true;
		}

		return false;
	}

	public function setup_options() {

		$manager = liquid_helper()->get_kit_option( 'liquid_sidebar_manager' );
		$sidebars = array();

		if ( !$manager ){
			return $sidebars;
		}

		foreach ( $manager as $items ) {

			if ( isset($items['enable_shop']) && $items['enable_shop'] === 'enable_shop' ){
				array_push($items['archive'], 'enable_shop');
			}

			if ( isset($items['enable']) && $items['enable'] === 'on' ){
				if ( $this->check_archive( $items['archive'] ) ){
					//$sidebars['global'] = 'off';
					$sidebars['sidebar'] = $items['sidebar'];
					$sidebars['position'] = isset($items['position']) ? $items['position'] : 'right';
					// hide_on_mobile
					if ( isset ( $items['hide_on_mobile'] ) && $items['hide_on_mobile'] === 'on' ) {
						$sidebars['hide_on_mobile'] = 'on';
					}
					break; // break the loop.
				}
			}

		}

		// Remove sidebars from the certain woocommerce pages.
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_cart() || is_checkout() || is_account_page() || ( get_option( 'woocommerce_thanks_page_id' ) && is_page( get_option( 'woocommerce_thanks_page_id' ) ) ) ) {
				$sidebars = array();
			}
		}

		return $sidebars;
	}

	public function check_archive( $rule ){

		if( is_home() && (array_search( 'blog-archive', $rule ) !== false) ) {
			$sidebars = true;
		}
		elseif ( class_exists( 'WooCommerce' ) && is_product() && (array_search( 'product-single', $rule ) !== false) ) {
			$sidebars = true;
		}
		elseif ( class_exists( 'WooCommerce' ) && ( is_product_taxonomy() || is_product_category() ) && (array_search( 'product-archive', $rule ) !== false) ) {
			$sidebars = true;
		}
		elseif ( class_exists( 'WooCommerce' ) && (is_shop() && (array_search( array( 'product-archive', 'enable_shop' ), $rule ) !== false ) ) ) {
			$sidebars = true;
		}
		elseif ( is_page() && (array_search( 'page', $rule ) !== false) ) {
			$sidebars = true;
		}
		elseif ( is_single() && (array_search( array( 'blog-posts', 'portfolio-posts' ), $rule ) !== false) ) {
			$sidebars = true;
			if ( is_singular( 'liquid-portfolio' ) ) {
				$sidebars = true;
			}
		}
		elseif ( is_archive() && (array_search( array( 'blog-archive', 'portfolio-archive' ), $rule ) !== false) ) {
			$sidebars = true;
			if ( is_post_type_archive( 'liquid-portfolio' ) || is_tax( 'liquid-portfolio-category' ) ) {
				$sidebars = true;
			}
		}
		 elseif ( is_search() && ( array_search( 'search-page', $rule ) !== false) ) {
			$sidebars = true;
		}
		else {
			$sidebars = false;
		}

		return $sidebars;

	}

}
return new Liquid_Theme_Layout;