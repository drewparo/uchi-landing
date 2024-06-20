<?php
/**
 * The Asset Manager
 * Enqueue scripts and styles for the frontend
 */

if( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Liquid_Theme_Assets extends Liquid_Base {

    /**
     * Hold data for wa_theme for frontend
     * @var array
     */
    private static $theme_json = array();

	/**
	 * [__construct description]
	 * @method __construct
	 */
    public function __construct() {

        $this->add_action( 'wp_enqueue_scripts', 'register' );
        $this->add_action( 'wp_enqueue_scripts', 'enqueue', 11 );
        $this->add_action( 'wp_enqueue_scripts', 'woo_register' );
        $this->add_action( 'wp_enqueue_scripts', 'script_data' );
        $this->add_action( 'elementor/editor/after_enqueue_script', 'script_data' );
		if ( liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal' ) {
			add_action( 'wp_head', function(){
				?>
				<script>
					<?php echo Liquid_Dynamic_Scripts::instance()->get_breakpoints(); ?>;
				</script>
				<?php
			} );
		}

        self::add_config( 'uris', array(
            'ajax' => admin_url( 'admin-ajax.php' ),
            'theme' => get_template_directory_uri()
        ));

		// Add defer attr
		add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {

			// include

			$script_name = liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal' ? 'liquid-theme-inline' : 'liquid-theme-frontend';
			if ( $handle === $script_name ){
				if ( $script_name !== 'liquid-theme-inline' ) {
					return str_replace( '<script', '<script type="module" data-no-optimize="1" data-no-defer="1" defer', $tag );
				}
			}
			return $tag; // exit

			// exclude
			// if ( in_array( $handle, array('wp-i18n', 'wp-hooks', 'admin-bar', 'jquery', 'jquery-core') ) ) {
			// 	return $tag;
			// }

			// include
			// if ( in_array( $handle, array( 'fastdom', 'fastdom-promised', 'underscore', 'backbone', 'backbone-native', 'backbone-radio', 'gsap', 'gsap-scrolltrigger', 'gsap-scrollto', 'gsap-flip', 'gsap-draw-svg') ) ) {
			// 	return str_replace( '<script', '<script', $tag );
			// }

			// return str_replace( '<script', '<script', $tag );

		}, 10, 3 );

    }

    /**
     * Register Scripts and Styles
     * @method register
     * @return [type]   [description]
     */
    public function register() {

		//Theme Css
		wp_register_style( 'liquid-wp-style', get_template_directory_uri() . '/style.css' );
		wp_register_style( 'liquid-theme', $this->get_css_uri( 'themes/aihub/theme' ) );

		// Register ----------------------------------------------------------
		wp_register_script( 'fastdom', $this->get_vendor_uri( 'fastdom/fastdom.min.js' ), [], null, true );
		wp_register_script( 'fastdom-promised', $this->get_vendor_uri( 'fastdom/fastdom-promised.js' ), [], null, true );
		wp_register_script( 'underscore', $this->get_vendor_uri( 'underscore/underscore-umd-min.js' ), [], null, true );
		// wp_register_script( 'backbone', $this->get_vendor_uri( 'backbone/backbone-min.js' ), [], null, true );
		wp_register_script( 'backbone-native', $this->get_vendor_uri( 'backbone-native/backbone.native.min.js' ), [], null, true );
		wp_register_script( 'lazyload', $this->get_vendor_uri( 'lazyload.min.js' ), [], null, true );
		wp_register_script( 'gsap', $this->get_vendor_uri( 'gsap/minified/gsap.min.js' ), [], null, true );
		wp_register_script( 'gsap-flip', $this->get_vendor_uri( 'gsap/minified/Flip.min.js' ), [], null, true );
		wp_register_script( 'gsap-scrolltrigger', $this->get_vendor_uri( 'gsap/minified/ScrollTrigger.min.js' ), [], null, true );
		wp_register_script( 'gsap-splittext', $this->get_vendor_uri( 'gsap/minified/SplitText.min.js' ), [], null, true );
		wp_register_script( 'gsap-scrollto', $this->get_vendor_uri( 'gsap/minified/ScrollToPlugin.min.js' ), [], null, true );
        wp_register_script( 'gsap-draw-svg', $this->get_vendor_uri('gsap/minified/DrawSVGPlugin.min.js'), [], null, true );
		wp_register_script( 'google-maps-api', $this->google_map_api_url(), [], null, true );
		wp_register_script( 'tsparticles', $this->get_vendor_uri( 'tsparticles/tsparticles.bundle.min.js' ), [], null, true );
		wp_register_script( 'threejs', $this->get_vendor_uri( 'threejs/three.min.js' ), [], null, true );
		wp_register_script( 'matter', $this->get_vendor_uri( 'matter/matter.min.js' ), [], null, true );
		wp_register_script( 'typewriter-effect', $this->get_vendor_uri( 'typewriter-effect/typewriter-effect.js' ), [], null, true );

		// Liquid Const Scripts
		wp_register_script( 'LiquidLibConsts', $this->get_js_uri( 'minified/lib/consts' ), [], null, true );
		wp_register_script( 'LiquidUtilsCollide', $this->get_js_uri( 'minified/utils/collide' ), [], null, true );
		wp_register_script( 'LiquidUtilsColors', $this->get_js_uri( 'minified/utils/colors' ), [], null, true );
		wp_register_script( 'LiquidUtilsGetElementFromString', $this->get_js_uri( 'minified/utils/getElementFromString' ), [], null, true );
		wp_register_script( 'LiquidUtilsGetSize', $this->get_js_uri( 'minified/utils/getSize' ), [], null, true );
		wp_register_script( 'LiquidUtilsModulo', $this->get_js_uri( 'minified/utils/modulo' ), [], null, true );

		wp_register_script( 'LiquidModelsBase', $this->get_js_uri( 'minified/models/base' ), [], null, true );
		wp_register_script( 'LiquidModelsWidgetsBase', $this->get_js_uri( 'minified/models/widgets/base' ), [], null, true );

		wp_register_script( 'LiquidModelsViewsBase', $this->get_js_uri( 'minified/views/base' ), [], null, true );

		wp_register_script( 'LiquidBehaviorsBase', $this->get_js_uri( 'minified/behaviors/base' ), [], null, true );

		wp_register_script( 'LiquidApp', $this->get_js_uri( 'minified/app' ), [], null, true );

		// Register Behaviors
		wp_register_script( 'LiquidAdaptiveBackgroundBehavior', $this->get_js_uri( 'minified/behaviors/adaptive-background' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidAdaptiveColorBehavior', $this->get_js_uri( 'minified/behaviors/adaptive-color' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidAnimationsBehavior', $this->get_js_uri( 'minified/behaviors/animations' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidCarouselAutoplayBehavior', $this->get_js_uri( 'minified/behaviors/carousel-autoplay' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidCarouselDotsBehavior', $this->get_js_uri( 'minified/behaviors/carousel-dots' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidCarouselDragBehavior', $this->get_js_uri( 'minified/behaviors/carousel-drag' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidCarouselNavBehavior', $this->get_js_uri( 'minified/behaviors/carousel-nav' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidCarouselSlidesIndicatorBehavior', $this->get_js_uri( 'minified/behaviors/carousel-slides-indicator' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidCarouselBehavior', $this->get_js_uri( 'minified/behaviors/carousel' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidCounterBehavior', $this->get_js_uri( 'minified/behaviors/counter' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidDrawShapeBehavior', $this->get_js_uri( 'minified/behaviors/draw-shape' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidDropdownBehavior', $this->get_js_uri( 'minified/behaviors/dropdown' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidDynamicRangeBehavior', $this->get_js_uri( 'minified/behaviors/dynamic-range' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidFilterBehavior', $this->get_js_uri( 'minified/behaviors/filter' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidGetElementComputedStylesBehavior', $this->get_js_uri( 'minified/behaviors/get-element-computed-styles' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidHover3dBehavior', $this->get_js_uri( 'minified/behaviors/hover-3d' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidLiquidSwapBehavior', $this->get_js_uri( 'minified/behaviors/liquid-swap' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidLocalScrollBehavior', $this->get_js_uri( 'minified/behaviors/local-scroll' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidLookAtMouseBehavior', $this->get_js_uri( 'minified/behaviors/look-at-mouse' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidLottieBehavior', $this->get_js_uri( 'minified/behaviors/lottie' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidMarqueeBehavior', $this->get_js_uri( 'minified/behaviors/marquee' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidMasonryBehavior', $this->get_js_uri( 'minified/behaviors/masonry' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidMoveElementBehavior', $this->get_js_uri( 'minified/behaviors/move-element' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidPinBehavior', $this->get_js_uri( 'minified/behaviors/pin' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidRangeBehavior', $this->get_js_uri( 'minified/behaviors/range' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidSlideshowBehavior', $this->get_js_uri( 'minified/behaviors/slideshow' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidSplitTextBehavior', $this->get_js_uri( 'minified/behaviors/split-text' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidStackBehavior', $this->get_js_uri( 'minified/behaviors/stack' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidStickyCursorBehavior', $this->get_js_uri( 'minified/behaviors/sticky-cursor' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidStickyHeaderBehavior', $this->get_js_uri( 'minified/behaviors/sticky-header' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidSwitchBehavior', $this->get_js_uri( 'minified/behaviors/switch' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidTextRotatorBehavior', $this->get_js_uri( 'minified/behaviors/text-rotator' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidThrowableBehavior', $this->get_js_uri( 'minified/behaviors/throwable' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidEffectsDisplayToggleBehavior', $this->get_js_uri( 'minified/behaviors/toggle-display' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidEffectsFadeToggleBehavior', $this->get_js_uri( 'minified/behaviors/toggle-fade' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidEffectsSlideToggleBehavior', $this->get_js_uri( 'minified/behaviors/toggle-slide' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidToggleBehavior', $this->get_js_uri( 'minified/behaviors/toggle' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidTypewriterBehavior', $this->get_js_uri( 'minified/behaviors/typewriter' ), ['LiquidBehaviorsBase'], null, true );
		wp_register_script( 'LiquidVideoBackgroundBehavior', $this->get_js_uri( 'minified/behaviors/video-background' ), ['LiquidBehaviorsBase'], null, true );

		$deps = array(
			'fastdom',
			'fastdom-promised',
			'underscore',
			'backbone',
			'backbone-native',
			'gsap',
			'gsap-scrolltrigger',
			'gsap-scrollto',
			'gsap-draw-svg',
		);

		if (
			defined( 'ELEMENTOR_VERSION' ) &&
			!\Elementor\Plugin::$instance->preview->is_preview_mode() &&
			liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal'
		) {
			array_push( $deps,
				'LiquidLibConsts',
				'LiquidUtilsCollide',
				'LiquidUtilsColors',
				'LiquidUtilsGetElementFromString',
				'LiquidUtilsGetSize',
				'LiquidUtilsModulo',
				'LiquidModelsBase',
				'LiquidModelsWidgetsBase',
				'LiquidModelsViewsBase',
				'LiquidBehaviorsBase',
				'LiquidApp',
			);
		}

		if ( 'on' === liquid_helper()->get_kit_option( 'liquid_lazy_load' ) ) {
			array_push( $deps,
				'lazyload'
			);
		}

		if ( !empty(liquid_helper()->get_kit_option( 'liquid_google_api_key' ) ) ){
			array_push( $deps,
				'google-maps-api'
			);
		}

		if ( liquid_helper()->is_page_elementor( true ) ) {
			array_push( $deps,
                'elementor-frontend'
			);
		}

		$post_id = liquid_helper()->get_script_id();
		wp_register_script( 'liquid-theme-frontend', set_url_scheme( wp_upload_dir()['baseurl'] . '/liquid-scripts/liquid-frontend-script-'. $post_id .'.js' ), $deps, null, true );
		wp_register_script( 'liquid-theme-inline', get_template_directory_uri() . '/liquid/assets/js/theme-inline.js', $deps, null, true );
    }

    /**
     * Enqueue Scripts and Styles
     * @method enqueue
     * @return [type]  [description]
     */
    public function enqueue() {

		// Styles-----------------------------------------------------

		//Base css files
		wp_enqueue_style( 'liquid-wp-style' );
		wp_enqueue_style( 'liquid-theme' );

		if ( ( !defined( 'ELEMENTOR_VERSION' ) || !is_callable( 'Elementor\Plugin::instance' ) ) ) {
			wp_enqueue_style( 'liquid-theme-utils', $this->get_css_uri( 'utils/lqd-utils' ) );
			wp_enqueue_script( 'liquid-theme-static', $this->get_js_uri( 'themes/aihub/theme-static' ), ['theme-js'], null, true );
		}

        if ( is_singular( 'post' ) ) {
			wp_enqueue_style( 'liquid-theme-sidebar', get_template_directory_uri() . '/assets/css/sidebar/sidebar.css' );
		}

		// Scripts -----------------------------------------------------

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Liquid Theme Frontend js, Load except for the editor.
		// Liquid Theme Frontend js, Load except for the editor.
		if (
			( liquid_helper()->is_page_elementor( true ) && !\Elementor\Plugin::$instance->preview->is_preview_mode() ) ||
			( liquid_helper()->is_page_elementor( true ) && !\Elementor\Plugin::$instance->preview->is_preview_mode() && ( liquid_helper()->get_page_id_by_url() == 0 || liquid_helper()->get_page_id_by_url() > 0 ) ) ||
			( defined( 'ELEMENTOR_VERSION') && wp_style_is( 'elementor-frontend' ) && !\Elementor\Plugin::$instance->preview->is_preview_mode() )
		){
			if ( liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal' ) {
				wp_enqueue_script( 'liquid-theme-inline' );
				if ( class_exists( 'Liquid_Dynamic_Scripts' ) ) {
					wp_add_inline_script( 'liquid-theme-inline', "
					window.liquidAppOptions = {
						layoutRegions: {
							liquidPageHeader: {
								el: 'lqd-page-header-wrap',
								contentWrap: 'lqd-page-header',
								behaviors: [
									". liquid_helper()->updateBehaviorNames(Liquid_Dynamic_Scripts::instance()->get_header_behavior()) . "
								]
							},
							liquidPageContent: {
								el: 'lqd-page-content-wrap',
								contentWrap: 'lqd-page-content',
								behaviors: [],
							},
							liquidPageFooter: {
								el: 'lqd-page-footer-wrap',
								contentWrap: 'lqd-page-footer',
							},
						},
					}", 'before');
				}
				if ( liquid_helper()->get_kit_frontend_option( 'liquid_stcu' ) === 'yes' ) {
					wp_enqueue_script( 'LiquidStickyCursorBehavior' );
				}
			} else {
				wp_enqueue_script( 'liquid-theme-frontend' );
			}
		} else {
			wp_enqueue_script(
				'theme-js',
				$this->get_js_uri( 'themes/logistics-hub/theme' ),
				[
					'fastdom',
					'fastdom-promised',
					'underscore',
					'backbone',
					'backbone-native',
					'gsap',
					//'elementor-frontend'
				],
				null,
				true
			);
		}

		if( !class_exists( 'Liquid_Addons' ) ) {
			wp_enqueue_style( 'google-font-rubik', $this->google_rubik_font_url(), array(), '1.0' );
			wp_enqueue_style( 'google-font-manrope', $this->google_manrope_font_url(), array(), '1.0' );
		}

		// enqueue scripts only on liquid gdpr is enabled
		if ( liquid_helper()->get_kit_option( 'liquid_gdpr' ) === 'on' ){

			wp_enqueue_script(
				'liquid-gdpr-box',
				$this->get_vendor_uri( 'liquid-gdpr/liquid-gdpr.min.js' ),
				array(),
				null,
				true
			);

			wp_enqueue_style(
				'liquid-gdpr-box',
				$this->get_vendor_uri( 'liquid-gdpr/liquid-gdpr.min.css' ),
				array(),
				null,
			);

		}

        if( is_404() || is_search() ) {
			wp_enqueue_style( 'not-found', $this->get_css_uri( 'pages/not-found' ) );
		}

		if (
            is_singular( 'post' ) ||
            (
				is_singular() &&
                ( !defined( 'ELEMENTOR_VERSION' ) || !is_callable( 'Elementor\Plugin::instance' ) )
            )
        ){
			$style = liquid_helper()->get_page_option( 'post_style' );
			$style = $style ? $style : liquid_helper()->get_kit_frontend_option( 'liquid_blog_single_post_style' );

			wp_enqueue_style( 'blog-single-base', $this->get_css_uri( 'blog/blog-single/blog-single-base' ) );

			if ( $style && in_array( $style, array( 'classic', 'dark', 'minimal', 'modern-full-screen', 'overlay', 'wide') ) ){
				wp_enqueue_style( 'blog-single-style-'. $style, $this->get_css_uri( 'blog/blog-single/blog-single-style-'. $style .'' ) );
			}
		}

	}

	public function google_map_api_url() {
		$api_key = liquid_helper()->get_kit_option( 'liquid_google_api_key' );
		$google_map_api = add_query_arg( 'key', $api_key, '//maps.googleapis.com/maps/api/js' );

		return $google_map_api;
	}

	public function google_rubik_font_url() {
		$font_url = add_query_arg( array( 'family' => 'Rubik', 'display' => liquid_helper()->get_kit_option( 'liquid_google_font_display' ) ), "//fonts.googleapis.com/css2" );
		return $font_url;
	}

	public function google_manrope_font_url() {
		$font_url = add_query_arg( array( 'family' =>  'Manrope:wght@600', 'display' => liquid_helper()->get_kit_option( 'liquid_google_font_display' ) ), "//fonts.googleapis.com/css2" );
		return $font_url;
	}

	//Register the woocommerce  shop styles
	public function woo_register() {
		//check if woocommerce is activated and styles are loaded
		if( class_exists( 'WooCommerce' ) ) {
			$deps = array( 'woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general' );
			wp_register_style( 'theme-shop', $this->get_css_uri('themes/aihub/theme.shop'), $deps );
			wp_enqueue_style( 'theme-shop' );
			// Enqueue the wc-cart-fragments script
			if ( ! wp_script_is( 'wc-cart-fragments', 'enqueued' ) && wp_script_is( 'wc-cart-fragments', 'registered' ) ) {
				wp_enqueue_script( 'wc-cart-fragments' );
			}
		}

		// Fix shop page enq elementor-frontend-css
		if ( class_exists('WooCommerce') && is_shop() ) {
			wp_dequeue_style( 'elementor-frontend' );
			wp_enqueue_style( 'elementor-frontend' );
		}
	}


    /**
     * Localize Data Object
     * @method script_data
     * @return [type]      [description]
     */
    public function script_data() {
		$script_name = liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal' ? 'liquid-theme-inline' : 'liquid-theme-frontend';
        wp_localize_script( $script_name, 'liquidTheme', self::$theme_json );
    }

    /**
     * Add items to JSON object
     * @method add_config
     * @param  [type]     $id    [description]
     * @param  string     $value [description]
     */
    public static function add_config( $id, $value = '' ) {

        if(!$id) {
            return;
        }

        if(isset(self::$theme_json[$id])) {
            if(is_array(self::$theme_json[$id])) {
                self::$theme_json[$id] = array_merge(self::$theme_json[$id],$value);
            }
            elseif(is_string(self::$theme_json[$id])) {
                self::$theme_json[$id] = self::$theme_json[$id].$value;
            }
        }
        else {
            self::$theme_json[$id] = $value;
        }
    }

    // Uri Helpers ---------------------------------------------------------------

    public function get_theme_uri($file = '') {
        return get_template_directory_uri() . '/' . $file;
    }

    public function get_child_uri($file = '') {
        return get_stylesheet_directory_uri() . '/' . $file;
    }

    public function get_css_uri($file = '') {
        return $this->get_theme_uri('assets/css/'.$file.'.css');
    }

    public function get_widgets_uri( $file = '' ) {
		return $this->get_theme_uri( 'assets/css/widgets/' . $file . '.css' );
    }

    public function get_js_uri($file = '') {
        return $this->get_theme_uri('assets/js/'.$file.'.js');
    }

    public function get_vendor_uri($file = '') {
        return $this->get_theme_uri('assets/vendors/'.$file);
    }
}
new Liquid_Theme_Assets;