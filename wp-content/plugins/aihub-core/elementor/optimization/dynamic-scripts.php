<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Liquid_Dynamic_Scripts' ) ) {

    class Liquid_Dynamic_Scripts {

		/**
		 * Instance
		 *
		 * @var Liquid_Dynamic_Scripts The single instance of the class.
		 */
		private static $_instance = null;


		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @return Liquid_Dynamic_Scripts An instance of the class.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        public function __construct(){

            $this->init_hooks();

        }

		public static $post_id;
        public static $scripts = array();
        public static $scripts_pageContent = array();
        public static $css = array();
		public static $widgets = array(
			'container',
			'lqd-accordion',
			'lqd-box',
			'lqd-carousel',
			'lqd-counter',
			'lqd-dark-switch',
			'lqd-draw-shape',
			'lqd-dynamic-range',
			'lqd-gallery',
			'lqd-image',
			'lqd-liquid-swap',
			'lqd-lottie',
			'lqd-marquee',
			'lqd-menu',
			'lqd-modal',
			'lqd-portfolio',
			'lqd-price-table',
			'lqd-search',
			'lqd_site_logo',
			'lqd-tabs',
			'lqd-text',
			'lqd-text-rotator',
			'lqd-throwable',
			'lqd-typewriter',
			'lqd-woo-cart-dropdown',
		);
		public static $widgets_pageContent = array(
			'container',
			'lqd-button',
			'lqd-dark-switch',
			'lqd-menu',
			'lqd_site_logo',
			'lqd-text',
		);
		public static $behavior_classes = array();

        public function init_hooks(){

			if ( liquid_helper()->get_kit_option('liquid_script_print_method') == 'external' ) {
				self::$post_id = liquid_helper()->get_script_id();
				$this->check_styles_folder();
				$this->delete_elementor_css();
				add_action( 'elementor/element/parse_css', [ $this, 'prepare_widget_assets' ], 10, 2 );
				add_action( 'wp_footer', [ $this, 'render_scripts' ] );
				$this->set_cache(self::$post_id);
			} else {

			}

        }

		function get_container_behavior( $element ) {
			$settings = $element->get_settings();
			$behavior = [];

			if ( $settings['lqd_adaptive_color'] === 'yes' ) {
				$behavior[] = [
					'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
					'options' => [
						'includeSelf' => 'true',
						'getRect' => 'true',
						'getStyles' => ["'position'"],
					]
				];
				$behavior[] = [
					'behaviorClass' => 'LiquidAdaptiveColorBehavior',
				];
			}

			return $behavior;
		}

		function get_container_behavior_pageContent( $element ) {

			$settings = $element->get_settings();
			$adaptive_color = $settings['lqd_adaptive_color'];
			$behavior = [];

			if ( !$adaptive_color ){
				return $behavior;
			}

			$behavior[] = [
				'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
				'options' => [
					'includeChildren' => true,
					'includeSelf' => true,
					'getOnlyContainers' => true,
					'getStyles' => ["'backgroundColor'"],
					'getBrightnessOf' => ["'backgroundColor'"],
					'getRect' => true
				]
			];

			return $behavior;
		}

		function prepare_widget_assets( $post_css_file, $element ) {

			$element_id = $element->get_id();
			$element_name = $element->get_name();

			if ( in_array( $element->get_name(), self::$widgets ) ){
				$behaviors = $element_name !== 'container' ? $element->get_behavior() : $this->get_container_behavior( $element );
				if ( !empty( $behaviors ) ) {
					foreach ( $behaviors as $bc ){
						self::$behavior_classes[] = $bc['behaviorClass'];
					}
					$behavior = wp_json_encode( $behaviors );
					$behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $behavior ) . ',';
					$this->_insert_script( $element->get_id(), $behavior );
				}
			}

			if ( in_array( $element->get_name(), self::$widgets_pageContent ) ){
				$pageContent_behaviors = $element_name !== 'container' ? $element->get_behavior_pageContent() : $this->get_container_behavior_pageContent( $element );
				if ( !empty( $pageContent_behaviors ) ) {
					foreach ( $pageContent_behaviors as $bc ){
						self::$behavior_classes[] = $bc['behaviorClass'];
					}
					$behavior = wp_json_encode( $pageContent_behaviors );
					$behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $behavior ) . ',';
					$this->_insert_script_pageContent( $element->get_id(), $behavior );
				}
			}

			// check button does exists
			if ( $element->get_settings('show_button') === 'yes' ) {
				// check local scroll
				if ( $element->get_settings('link_type') === 'local_scroll' || $element->get_settings('ib_link_type') === 'local_scroll' ) {
					// insert custom behavior (as JSON)
					$local_scroll_options = [];
					$offset_option = $element->get_settings('local_scroll_offset') ? $element->get_settings('local_scroll_offset') : $element->get_settings('ib_local_scroll_offset');
					if ( $offset_option && isset( $offset_option['size'] ) && !empty( $offset_option['size'] ) ) {
						$local_scroll_options['offset'] = $offset_option['size'];
					}
					$this->_insert_script( $element->get_id(), '{behaviorClass:LiquidLocalScrollBehavior, options: ' . wp_json_encode( $local_scroll_options ) . '},' );
					self::$behavior_classes[] =  'LiquidLocalScrollBehavior';
				}
				if ( $element->get_settings('lqd_adaptive_color') === 'yes' || $element->get_settings('ib_lqd_adaptive_color') === 'yes' ) {
					// insert custom behavior (as JSON)
					$this->_insert_script( $element->get_id(), '{ behaviorClass:LiquidGetElementComputedStylesBehavior, options: { includeSelf: true, getRect: true, getStyles: ["position"] } },' );
					self::$behavior_classes[] =  'LiquidGetElementComputedStylesBehavior';
					$this->_insert_script( $element->get_id(), '{ behaviorClass:LiquidAdaptiveColorBehavior },' );
					self::$behavior_classes[] =  'LiquidAdaptiveColorBehavior';
				}
			}

			// Parallax
			if ( $element->get_settings( 'lqd_parallax' ) ) {

				$keyframes = $repeat_animation = array();

				// general options
				$general_options = [
					'domain' => "'parallax'",
					'trigger' => "'" . $element->get_settings('lqd_parallax_trigger') . "'",
					'ease' => "'" . $element->get_settings('lqd_parallax_settings_ease') . "'",
					'scrub' => $element->get_settings('lqd_parallax_settings_scrub')['size'],
					// 'stagger' => [
					//     'each' => $element->get_settings('lqd_parallax_settings_stagger')['size'],
					//     'from' => $element->get_settings('lqd_parallax_settings_direction'),
					// ],
					'start' => "'" . $element->get_settings('lqd_parallax_settings_start') . "'",
					'end' => "'" . $element->get_settings('lqd_parallax_settings_end') . "'",
					'startElementOffset' => $element->get_settings('lqd_parallax_settings_startElementOffset')['size'],
					'startViewportOffset' => $element->get_settings('lqd_parallax_settings_startViewportOffset')['size'],
					'endElementOffset' => $element->get_settings('lqd_parallax_settings_endElementOffset')['size'],
					'endViewportOffset' => $element->get_settings('lqd_parallax_settings_endViewportOffset')['size'],
				];

				if ( $element->get_settings('lqd_parallax_settings_start') === 'percentage' ) {
					$general_options['start'] = $element->get_settings('lqd_parallax_settings_start_percentage')['size'];
				} else if ( $element->get_settings('lqd_parallax_settings_start') === 'custom' ) {
					$general_options['start'] = "'" . $element->get_settings('lqd_parallax_settings_start_custom') . "'";
				}

				if ( $element->get_settings('lqd_parallax_settings_end') === 'percentage' ) {
					$general_options['end'] = $element->get_settings('lqd_parallax_settings_end_percentage')['size'];
				} else if ( $element->get_settings('lqd_parallax_settings_end') === 'custom' ) {
					$general_options['end'] = "'" . $element->get_settings('lqd_parallax_settings_end_custom') . "'";
				}

				// animation repeat options
				if ( $element->get_settings('lqd_parallax_settings_animation_repeat_enable') ){
					$repeat_animation = [
						'repeat' => $element->get_settings('lqd_parallax_settings_animation_repeat')['size'],
						'repeatDelay' => $element->get_settings('lqd_parallax_settings_animation_repeat_delay')['size'],
						'yoyo' => $element->get_settings('lqd_parallax_settings_animation_yoyo') ? true : false,
						'yoyoEase' => $element->get_settings('lqd_parallax_settings_animation_yoyo_ease') ? true : false,
					];
				}

				// merge options
				$general_options = array_merge( $general_options, $repeat_animation );
				$devices = ['all'];

				$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

				if ( $active_breakpoints ) {

					foreach( array_reverse($active_breakpoints) as $key => $breakpoint ){
						$devices[] = $key;
					}

				}

				foreach( $devices as $device ){

					$get_keyframes = $element->get_settings('lqd_parallax_keyframes_' . $device);

					$count = 1;

					foreach ( $get_keyframes as $i => $keyframe_value ){

						$options = [
							'scaleX' => (float) $keyframe_value['scaleX']['size'],
							'scaleY' => (float) $keyframe_value['scaleY']['size'],
							'skewX' => (float) $keyframe_value['skewX']['size'],
							'skewY' => (float) $keyframe_value['skewY']['size'],
							'x' => "'" . $keyframe_value['x']['size'] . $keyframe_value['x']['unit'] . "'",
							'y' => "'" . $keyframe_value['y']['size'] . $keyframe_value['y']['unit'] . "'",
							'z' => "'" . $keyframe_value['z']['size'] . $keyframe_value['z']['unit'] . "'",
							'rotateX' => $keyframe_value['rotateX']['size'],
							'rotateY' => $keyframe_value['rotateY']['size'],
							'rotateZ' => $keyframe_value['rotateZ']['size'],
							'opacity' => $keyframe_value['opacity']['size'],
						];

						if ( $element->get_settings('lqd_parallax_devices_popover_'.$device) ){

							$breakpoint_options = [
								'ease' => "'" . $element->get_settings('lqd_parallax_settings_' . $device . '_ease') . "'",
								'stagger' => [
									'each' => $element->get_settings('lqd_parallax_settings_' . $device . '_stagger')['size'],
									'from' => "'" . $element->get_settings('lqd_parallax_settings_' . $i . '_direction') . "'",
								],
							];

							// animation repeat options
							if ( $element->get_settings('lqd_parallax_settings_' . $device . '_animation_repeat_enable') ){
								$breakpoint_repeat_animation = [
									'repeat' => $element->get_settings('lqd_parallax_settings_' . $device . '_animation_repeat')['size'],
									'repeatDelay' => $element->get_settings('lqd_parallax_settings_' . $device . '_animation_repeat_delay')['size'],
									'yoyo' => $element->get_settings('lqd_parallax_settings_' . $device . '_animation_yoyo') ? true : false,
									'yoyoEase' => $element->get_settings('lqd_parallax_settings_' . $device . '_animation_yoyo_ease') ? true : false,
								];
								// merge options
								$breakpoint_options = array_merge( $breakpoint_options, $breakpoint_repeat_animation );
							}

							$keyframes[$device]['options'] = $breakpoint_options;

						}

						// check inner ease
						if ( $keyframe_value['options'] ){
							$options = array_merge( $options, [
								'ease' => "'" . $keyframe_value['ease'] . "'",
								'duration' => $keyframe_value['duration']['size'],
								'delay' => $keyframe_value['delay']['size'],
							]);
						}

						// add init values
						if ( $element->get_settings('lqd_parallax_enable_css') ){
							if ( $count > 1 ){
								$keyframes[$device]['keyframes'][] = [ $options ];
							} else {
								$selector = '.elementor-element-' . $element_id . '';
								$opacity_value = $keyframe_value['opacity']['size'];

								$split_type = $element->get_settings('lqd_text_split_type');
								if ( $split_type && !empty( $split_type ) ) {
									if ( $split_type === 'words' ) {
										$selector = $element->get_unique_selector() . ' .lqd-split-text-words';
									} else if ( $split_type === 'chars,words' ) {
										$selector = $element->get_unique_selector() . ' .lqd-split-text-chars';
									}
								}

								$transform = "translate3d({$keyframe_value['x']['size']}{$keyframe_value['x']['unit']},{$keyframe_value['y']['size']}{$keyframe_value['y']['unit']},{$keyframe_value['z']['size']}{$keyframe_value['z']['unit']})";
								$transform .= " scale({$keyframe_value['scaleX']['size']}, {$keyframe_value['scaleY']['size']})";
								$transform .= " rotateX({$keyframe_value['rotateX']['size']}deg) rotateY({$keyframe_value['rotateY']['size']}deg) rotateZ({$keyframe_value['rotateZ']['size']}deg)";
								$transform .= " skew({$keyframe_value['skewX']['size']}deg, {$keyframe_value['skewY']['size']}deg)";

								$rules = [
									'transform' => $transform,
								];

								if ( $opacity_value !==  1 ) {
									$rules['opacity'] = $opacity_value;
								}

								if (
									( $keyframe_value['transformOriginX'][ 'size' ] !== 50 || $keyframe_value['transformOriginX'][ 'unit' ] !== '%' ) ||
									( $keyframe_value['transformOriginY'][ 'size' ] !== 50 || $keyframe_value['transformOriginY'][ 'unit' ] !== '%' ) ||
									( $keyframe_value['transformOriginZ'][ 'size' ] !== 0 )
								) {
									$rules['transform-origin'] = "{$keyframe_value['transformOriginX'][ 'size' ]}{$keyframe_value['transformOriginX'][ 'unit' ]} " .
										"{$keyframe_value['transformOriginY'][ 'size' ]}{$keyframe_value['transformOriginY'][ 'unit' ]} " .
										"{$keyframe_value['transformOriginZ'][ 'size' ]}px";
								}

								self::insert_style( $device, $selector, $rules ); // insert script
								$post_css_file->get_stylesheet()->add_raw_css( $this->generate_styles(self::$css) );
								self::$css = [];
							}
						} else {
							$keyframes[$device]['keyframes'][] = [ $options ];
						}

						$count++;
					}

				}

				// add animation keyframes in behavior > options
				$general_options['animations'][] = [[
					'elements' => "'self'",
					'breakpointsKeyframes' => $keyframes
				]];

				// finalize behavior
				$final = [
					[
						'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
						'options' => [
							'includeSelf' => true,
							'getRect' => true,
							'addGhosts' => true
						]
					],
					[
						'behaviorClass' => 'LiquidAnimationsBehavior',
						'options' => $general_options,
					]
				];

				// array to json
				$behavior = wp_json_encode($final);
				$behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $behavior ) . ',';

				self::$behavior_classes[] = 'LiquidGetElementComputedStylesBehavior'; // insert behavior
				self::$behavior_classes[] = 'LiquidAnimationsBehavior'; // insert behavior
				self::_insert_script( $element_id, $behavior ); // insert script

			}

			// Animation
			if ( $element->get_settings( 'lqd_inview' ) ) {

				$keyframes = $repeat_animation = array();

				// general options
				$general_options = [
					'domain' => "'inview'",
					'trigger' => "'" . $element->get_settings('lqd_parallax_trigger') . "'",
					'duration' => $element->get_settings('lqd_inview_settings_duration')['size'],
					'ease' => "'" . $element->get_settings('lqd_inview_settings_ease') . "'",
					'stagger' => [
						'each' => $element->get_settings('lqd_inview_settings_stagger')['size'],
						'from' => "'" . $element->get_settings('lqd_inview_settings_direction') . "'",
					],
					'delay' => $element->get_settings('lqd_inview_settings_start_delay')['size'],
					'start' => "'" . $element->get_settings('lqd_inview_settings_start') . "'",
					'startElementOffset' => $element->get_settings('lqd_inview_settings_startElementOffset')['size'],
					'startViewportOffset' => $element->get_settings('lqd_inview_settings_startViewportOffset')['size'],
				];

				if ( $element->get_settings('lqd_inview_settings_start') === 'percentage' ) {
					$general_options['start'] = $element->get_settings('lqd_inview_settings_start_percentage')['size'];
				} else if ( $element->get_settings('lqd_inview_settings_start') === 'custom' ) {
					$general_options['start'] = $element->get_settings('lqd_inview_settings_start_custom');
				}

				// animation repeat options
				if ( $element->get_settings('lqd_inview_settings_animation_repeat_enable') ){
					$repeat_animation = [
						'repeat' => $element->get_settings('lqd_inview_settings_animation_repeat')['size'],
						'repeatDelay' => $element->get_settings('lqd_inview_settings_animation_repeat_delay')['size'],
						'yoyo' => $element->get_settings('lqd_inview_settings_animation_yoyo') ? true : false,
						'yoyoEase' => $element->get_settings('lqd_inview_settings_animation_yoyo_ease') ? true : false,
					];
				}

				// merge options
				$general_options = array_merge( $general_options, $repeat_animation );

				// get animation keyframes
				if( 'custom' !== $element->get_settings( 'lqd_inview_preset' ) ) { // preset animations

					$defined_animations = [
						'Fade In' =>[
							['opacity' => 0],
							['opacity' => 1],
						],
						'Fade In Down' => [
							['opacity' => 0, 'y' => -150],
							['opacity' => 1, 'y' => 0],
						],
						'Fade In Up' => [
							['opacity' => 0, 'y' => 150],
							['opacity' => 1, 'y' => 0],
						],
						'Fade In Left' => [
							['opacity' => 0, 'x' => -150],
							['opacity' => 1, 'x' => 0],
						],
						'Fade In Right' => [
							['opacity' => 0, 'x' => 150],
							['opacity' => 1, 'x' => 0],
						],
						'Flip In Y' => [
							['opacity' => 0, 'x' => 150, 'rotateY' => 30],
							['opacity' => 1, 'x' => 0, 'rotateY' => 0],
						],
						'Flip In X' => [
							['opacity' => 0, 'y' => 150, 'rotateX' => -30],
							['opacity' => 1, 'y' => 0, 'rotateX' => 0],
						],
						'Scale Up' => [
							['opacity' => 0, 'scale' => 0.75],
							['opacity' => 1, 'scale' => 1],
						],
						'Scale Down' => [
							['opacity' => 0, 'scale' => 1.25],
							['opacity' => 1, 'scale' => 1],
						],
					];

					$keyframes['all'] = [
						'keyframes' => [ $defined_animations[$element->get_settings( 'lqd_inview_preset' )] ]
					];

				} else { // custom animations

					$devices = ['all'];

					$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

					if ( $active_breakpoints ) {

						foreach( array_reverse($active_breakpoints) as $key => $breakpoint ){
							$devices[] = $key;
						}

					}

					foreach( $devices as $device ){

						$get_keyframes = $element->get_settings('lqd_inview_keyframes_' . $device);

						$count = 1;

						foreach ( $get_keyframes as $i => $keyframe_value ){

							$options = [
								'scaleX' => (float) $keyframe_value['scaleX']['size'],
								'scaleY' => (float) $keyframe_value['scaleY']['size'],
								'skewX' => (float) $keyframe_value['skewX']['size'],
								'skewY' => (float) $keyframe_value['skewY']['size'],
								'x' => "'" . $keyframe_value['x']['size'] . $keyframe_value['x']['unit'] . "'",
								'y' => "'" . $keyframe_value['y']['size'] . $keyframe_value['y']['unit'] . "'",
								'z' => "'" . $keyframe_value['z']['size'] . $keyframe_value['z']['unit'] . "'",
								'rotateX' => $keyframe_value['rotateX']['size'],
								'rotateY' => $keyframe_value['rotateY']['size'],
								'rotateZ' => $keyframe_value['rotateZ']['size'],
								'opacity' => $keyframe_value['opacity']['size'],
							];

							if ( $element->get_settings('lqd_inview_devices_popover_'.$device) ){

								$breakpoint_options = [
									'ease' => "'" . $element->get_settings('lqd_inview_settings_' . $device . '_ease') . "'",
									'duration' => $element->get_settings('lqd_inview_settings_' . $device . '_duration')['size'],
									'stagger' => [
										'each' => $element->get_settings('lqd_inview_settings_' . $device . '_stagger')['size'],
										'from' => "'" . $element->get_settings('lqd_inview_settings_' . $key . '_direction') . "'",
									],
									'delay' => $element->get_settings('lqd_inview_settings_' . $device . '_start_delay')['size'],
								];

								// animation repeat options
								if ( $element->get_settings('lqd_inview_settings_' . $device . '_animation_repeat_enable') ){
									$breakpoint_repeat_animation = [
										'repeat' => $element->get_settings('lqd_inview_settings_' . $device . '_animation_repeat')['size'],
										'repeatDelay' => $element->get_settings('lqd_inview_settings_' . $device . '_animation_repeat_delay')['size'],
										'yoyo' => $element->get_settings('lqd_inview_settings_' . $device . '_animation_yoyo') ? true : false,
										'yoyoEase' => $element->get_settings('lqd_inview_settings_' . $device . '_animation_yoyo_ease') ? true : false,
									];
									// merge options
									$breakpoint_options = array_merge( $breakpoint_options, $breakpoint_repeat_animation );
								}

								$keyframes[$device]['options'] = $breakpoint_options;

							}

							// check inner duration, delay & ease
							if ( $keyframe_value['options'] ){
								$options = array_merge( $options, [
									'ease' => "'" . $keyframe_value['ease'] . "'",
									'duration' => $keyframe_value['duration']['size'],
									'delay' => $keyframe_value['delay']['size'],
								]);
							}

							// add init values
							if ( $element->get_settings('lqd_inview_enable_css') ){
								if ( $count > 1 ){
									$keyframes[$device]['keyframes'][] = [ $options ];
								} else {
									$selector = '.elementor-element-' . $element_id . '';
									$opacity_value = $keyframe_value['opacity']['size'];

									$split_type = $element->get_settings('lqd_text_split_type');
									if ( $split_type && !empty( $split_type ) ) {
										if ( $split_type !== '' ) {
											$selector = $element->get_unique_selector() . ' .lqd-split-text-' . ($split_type === 'words' ? 'words' : 'chars');
										}
									}

									$transform = "translate3d({$keyframe_value['x']['size']}{$keyframe_value['x']['unit']},{$keyframe_value['y']['size']}{$keyframe_value['y']['unit']},{$keyframe_value['z']['size']}{$keyframe_value['z']['unit']})";
									$transform .= " scale({$keyframe_value['scaleX']['size']}, {$keyframe_value['scaleY']['size']})";
									$transform .= " rotateX({$keyframe_value['rotateX']['size']}deg) rotateY({$keyframe_value['rotateY']['size']}deg) rotateZ({$keyframe_value['rotateZ']['size']}deg)";
									$transform .= " skew({$keyframe_value['skewX']['size']}deg, {$keyframe_value['skewY']['size']}deg)";

									$rules = [
										'transform' => $transform,
									];

									if ( $opacity_value !==  1 ) {
										$rules['opacity'] = $opacity_value;
									}

									if (
										( $keyframe_value['transformOriginX'][ 'size' ] !== 50 || $keyframe_value['transformOriginX'][ 'unit' ] !== '%' ) ||
										( $keyframe_value['transformOriginY'][ 'size' ] !== 50 || $keyframe_value['transformOriginY'][ 'unit' ] !== '%' ) ||
										( $keyframe_value['transformOriginZ'][ 'size' ] !== 0 )
									) {
										$rules['transform-origin'] = "{$keyframe_value['transformOriginX'][ 'size' ]}{$keyframe_value['transformOriginX'][ 'unit' ]} " .
											"{$keyframe_value['transformOriginY'][ 'size' ]}{$keyframe_value['transformOriginY'][ 'unit' ]} " .
											"{$keyframe_value['transformOriginZ'][ 'size' ]}px";
									}

									self::insert_style( $device, $selector, $rules ); // insert script
									$post_css_file->get_stylesheet()->add_raw_css( $this->generate_styles(self::$css) );
									self::$css = [];
								}
							} else {
								$keyframes[$device]['keyframes'][] = [ $options ];
							}

							$count++;
						}

					}

				}

				$animation_elements = 'self';

				$split_text = $element->get_settings('lqd_text_split_type');
				if ( $split_text && !empty( $split_text ) ) {
					$animation_elements = 'selfAnimatables';
				}

				// add animation keyframes in behavior > options
				$general_options['animations'][] = [[
					'elements' => "'$animation_elements'",
					'breakpointsKeyframes' => $keyframes
				]];

				// finalize behavior
				$final = [
					[
						'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
						'options' => [
							'includeSelf' => true,
							'getRect' => true,
							'addGhosts' => true
						]
					],
					[
						'behaviorClass' => 'LiquidAnimationsBehavior',
						'options' => $general_options,
					]
				];

				// array to json
				$behavior = wp_json_encode($final);
				$behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $behavior ) . ',';

				self::$behavior_classes[] = 'LiquidGetElementComputedStylesBehavior'; // insert behavior
				self::$behavior_classes[] = 'LiquidAnimationsBehavior'; // insert behavior
				self::_insert_script( $element_id, $behavior ); // insert script

			}

        }

        public function render_scripts(){

            if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ){
                return; // check elementor preview mode
            }

            $hash = $this->get_the_region();
            $get_scripts = self::$scripts;
			$get_scripts_pageContent = array_unique( self::$scripts_pageContent, SORT_REGULAR );
            $breakpoints = $this->get_breakpoints();

			$get_header_behavior = $this->get_header_behavior();

            $out = $behaviors = $behaviors_pageContent = '';
            $src = '../../themes/'.str_replace( '-child', '', get_stylesheet() ).'/assets/js/esm/';

			// check multisite - if multisite enabled, use direct url
			if ( is_multisite() ) {
				$src = LQD_CORE_URL . 'assets/js/esm/';
			}

			$behavior_classes = "import LiquidApp from '{$src}app.js';";
			$behavior_classes_scripts = array(
				'LiquidAdaptiveBackgroundBehavior' => 'behaviors/adaptive-background.js',
				'LiquidAdaptiveColorBehavior' => 'behaviors/adaptive-color.js',
				'LiquidAnimationsBehavior' => 'behaviors/animations.js',
				'LiquidCarouselAutoplayBehavior' => 'behaviors/carousel-autoplay.js',
				'LiquidCarouselDotsBehavior' => 'behaviors/carousel-dots.js',
				'LiquidCarouselDragBehavior' => 'behaviors/carousel-drag.js',
				'LiquidCarouselNavBehavior' => 'behaviors/carousel-nav.js',
				'LiquidCarouselSlidesIndicatorBehavior' => 'behaviors/carousel-slides-indicator.js',
				'LiquidCarouselBehavior' => 'behaviors/carousel.js',
				'LiquidCounterBehavior' => 'behaviors/counter.js',
				'LiquidDrawShapeBehavior' => 'behaviors/draw-shape.js',
				'LiquidDropdownBehavior' => 'behaviors/dropdown.js',
				'LiquidDynamicRangeBehavior' => 'behaviors/dynamic-range.js',
				'LiquidEffectsDisplayToggleBehavior' => 'behaviors/toggle-display.js',
				'LiquidEffectsFadeToggleBehavior' => 'behaviors/toggle-fade.js',
				'LiquidEffectsSlideToggleBehavior' => 'behaviors/toggle-slide.js',
				'LiquidFilterBehavior' => 'behaviors/filter.js',
				'LiquidGetElementComputedStylesBehavior' => 'behaviors/get-element-computed-styles.js',
				'LiquidHover3dBehavior' => 'behaviors/hover-3d.js',
				'LiquidLiquidSwapBehavior' => 'behaviors/liquid-swap.js',
				'LiquidLocalScrollBehavior' => 'behaviors/local-scroll.js',
				'LiquidLookAtMouseBehavior' => 'behaviors/look-at-mouse.js',
				'LiquidLottieBehavior' => 'behaviors/lottie.js',
				'LiquidMagneticMouseBehavior' => 'behaviors/magnetic-mouse.js',
				'LiquidMarqueeBehavior' => 'behaviors/marquee.js',
				'LiquidMasonryBehavior' => 'behaviors/masonry.js',
				'LiquidMoveElementBehavior' => 'behaviors/move-element.js',
				'LiquidRangeBehavior' => 'behaviors/range.js',
				'LiquidTextRotatorBehavior' => 'behaviors/text-rotator.js',
				'LiquidThrowableBehavior' => 'behaviors/throwable.js',
				'LiquidSplitTextBehavior' => 'behaviors/split-text.js',
				'LiquidStickyHeaderBehavior' => 'behaviors/sticky-header.js',
				'LiquidSwitchBehavior' => 'behaviors/switch.js',
				'LiquidToggleBehavior' => 'behaviors/toggle.js',
				'LiquidTypewriterBehavior' => 'behaviors/typewriter.js',
			);

			foreach( array_unique(self::$behavior_classes) as $class ) {
				$behavior_classes .= "import $class from '{$src}{$behavior_classes_scripts[$class]}';";
			}

            foreach ($get_scripts as $element_id => $behavior) {
                //$region = isset($hash[$value['element']]) ? $hash[$value['element']] : 'page';

				$behavior_unique = array_unique( $behavior['behaviors'], SORT_REGULAR );
				$behavior_uniqued = '';
				foreach ( $behavior_unique as $behavior_unique_value ) {
					$behavior_uniqued .= $behavior_unique_value;
				}

                $behaviors .= "window.liquid.behaviors.push( {
                    el: document.querySelector( '.elementor-element-$element_id' ),
                    behaviors:[
                        {$behavior_uniqued}
                    ]
                } );
                ";
            }

			foreach ($get_scripts_pageContent as $behavior_pageContent) {
                $behaviors_pageContent .= "{$behavior_pageContent['behaviors']}";
            }

            $out .= "

			$behavior_classes

            (() => {
                'use strict';
                $breakpoints

                _.extend( window.liquid, Backbone.Events );

                fastdom = fastdom.extend( fastdomPromised );

                /**
                 * Initiating elements
                 */

                $behaviors

                const liquidApp = new LiquidApp( {
                    layoutRegions: {
                        liquidPageHeader: {
                            el: 'lqd-page-header-wrap',
                            contentWrap: 'lqd-page-header',
							behaviors:[
								$get_header_behavior
							],
                        },
                        liquidPageContent: {
                            el: 'lqd-page-content-wrap',
                            contentWrap: 'lqd-page-content',
							behaviors:[
								$behaviors_pageContent
							],
                        },
                        liquidPageFooter: {
                            el: 'lqd-page-footer-wrap',
                            contentWrap: 'lqd-page-footer'
                        },
                    },
                } );

                window.liquid.app = liquidApp;

                liquidApp.start();
                })();";

            $this->create_script( $out );

        }

        // add behaviors to the global scripts array
        public static function _insert_script( $element_id, $behavior ){

            // check element id
            if ( empty( $element_id ) ){
                return;
            }

            if ( isset( self::$scripts[$element_id] ) ){ // if elements already exist, insert other behavior
				self::$scripts[$element_id]['behaviors'][]= $behavior;
            } else {
                self::$scripts[$element_id] = [ 'behaviors' => [$behavior] ]; // add new behavior
            }

        }

		// add behaviors to the global scripts array
        public static function _insert_script_pageContent( $element_id, $behavior ){

            // check element id
            if ( empty( $element_id ) ){
                return;
            }

            if ( isset( self::$scripts_pageContent[$element_id] ) ){ // if elements already exist, insert other behavior
                self::$scripts_pageContent[$element_id]['behaviors'] .= $behavior;
            } else {
                self::$scripts_pageContent[$element_id] = [ 'behaviors' => $behavior ]; // add new behavior
            }

        }

		// add behaviors to the global scripts array
        public static function _insert_behavior( $behavior ){

            // check element id
            if ( empty( $behavior ) ){
                return;
            }

			if ( ! in_array( $behavior, self::$behavior_classes ) ) {
				self::$behavior_classes[] = $behavior;
			}

        }

        public function get_dataid( $cpt_id ){

            if ( ! $cpt_id ) { // if no id, return false
                return;
            }
            $html = Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $cpt_id ); // get the elementor content from the id

			if ( empty( $html ) ) {
				return;
			}

            libxml_use_internal_errors( true ); // hide errors for HTM5
            $dom = new DOMDocument(); // create a new dom document
            @$dom->loadHTML( $html );   // load the html

            $xpath = new DOMXPath( $dom );  // create a new xpath object
            $nodes = $xpath->query( '//@data-id' ); // get all the data-id attributes

            $ids = [];
            foreach ($nodes as $node) { // loop through the data-id attributes
                $ids []= $node->value;
            }

            return $ids; // return the array of data-id attributes

        }

        public function get_the_region(){

			error_reporting(0);

            $hash = [];

            if ( empty( liquid_get_custom_header_id() ) || empty( liquid_get_custom_footer_id() ) ){
                return;
            }

			if ( $header = $this->get_dataid( liquid_get_custom_header_id() ) ) {
				foreach ($header as $key => $value) {
					$hash[$value] = 'pageHeader'; // assign the element to the header region
				}
			}

            if ( $footer = $this->get_dataid( liquid_get_custom_footer_id() ) ) {
				foreach ($footer as $key => $value) {
					$hash[$value] = 'pageFooter'; // assign the element to the footer region
				}
			}

            return $hash;
        }

		public function get_header_behavior() {

			/**
			 * YOU CAN GET ANY HEADER OPTION LIKE THIS
			 * $my_option = liquid_helper()->get_page_option( 'YOUR_HEADER_OPTION', liquid_get_custom_header_id() );
			 */

			if (
				!liquid_get_custom_header_id() || // check header_id is empty
				!liquid_helper()->get_page_option( 'header_sticky', liquid_get_custom_header_id() ) // check if sticky header if is off
			){
				return;
			}

			self::_insert_behavior( 'LiquidStickyHeaderBehavior' ); // insert behavior class (main js file)
			self::_insert_behavior( 'LiquidGetElementComputedStylesBehavior' ); // insert behavior class (main js file)

			$offset = liquid_helper()->get_page_option( 'header_sticky_offset', liquid_get_custom_header_id() );
			$sticky_header_options = [];

			if ( $offset && !empty( $offset['size'] ) ) {
				$sticky_header_options['offset'] = $offset['size'];
			}

			// insert sticky header deps
			$behavior = [];
			$behavior[] = [
				'behaviorClass' => 'LiquidStickyHeaderBehavior',
				'options' => $sticky_header_options
			];
			$behavior[] = [
				'behaviorClass' => 'LiquidGetElementComputedStylesBehavior',
				'options' => [
					'includeSelf' => true,
					'getRect' => true,
				]
			];

			if ( liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal' ) {
				wp_enqueue_script('LiquidStickyHeaderBehavior');
			}

			// convert php(array) to json
			$behavior = wp_json_encode($behavior);
			$behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $behavior ) . ',';

			return $behavior;
		}

		public function get_breakpoints_array() {

			$breakpoints_array = [];
			$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

			if ( ! $active_breakpoints ) {
				return $breakpoints_array;
			}

			foreach( array_reverse($active_breakpoints) as $key => $breakpoint ){
				$breakpoints_array[$key] = [
					'label' => $breakpoint->get_label(),
					'value' => $breakpoint->get_value(),
					'default_value' => $breakpoint->get_default_value(),
					'direction' => $breakpoint->get_direction(),
					'is_enabled' => $breakpoint->is_enabled()
				];
			}

			return $breakpoints_array;

		}

        public function get_breakpoints(){

			$breakpoints = $this->get_breakpoints_array();

            $out = [
                'app' => null,
				'behaviors' => [],
				'loadedBehaviors' => [],
				'breakpoints' => $breakpoints
            ];

            $out = wp_json_encode( $out );
            $out = str_replace('/"([a-zA-Z]+[a-zA-Z0-9_]*)":/','$1:', $out );
            $out = str_replace( array('},{', '/\[\{/', '/\}\]/'), array(',', '{', '}') , $out );

            return "window.liquid = " . $out;

        }

        public function get_breakpoints_value($device){

            $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

            $breakpoints = [
                'mobile' => 767,
                'mobile_extra' => 880,
                'tablet' => 1024,
                'tablet_extra' => 1200,
                'laptop' => 1366,
                'widescreen' => 2400,
            ];

            if ( isset($active_breakpoints[ $device ]) ){
				return $active_breakpoints[ $device ]->get_value();
            } else {
				return $breakpoints[ $device ];
			}

        }

        public function create_script( $rules, $type = 'js' ) {

            if ( $type == 'css' ){
                $name = 'liquid-scripts/liquid-frontend-animation-' . self::$post_id . '.css';
            } else {
                $name = 'liquid-scripts/liquid-frontend-script-' . self::$post_id . '.js';
            }

            $uploads = wp_upload_dir();

            $file_location = $uploads['basedir'] . DIRECTORY_SEPARATOR . $name;

            file_put_contents( $file_location , $rules);

        }

        // CSS
        public static function insert_style( $device, $selector, $rules ){
            self::$css[$device][$selector] = $rules;
        }

        public function generate_styles($rules, $indent = 0) {

            $css = '';

			foreach( $rules as $device_key => $device ){

				if ( $device_key !== 'all' ){
					$css .= "@media (max-width: {$this->get_breakpoints_value($device_key)}px){\n";
				}

				foreach( $device as $selector => $value ){

					$css .= "$selector {\n";
						foreach( $value as $prop => $v ){
							$css .= "   $prop: $v;\n";
						}
					$css .= "}\n";
				}

				if ( $device_key !== 'all' ){
					$css .= "}\n";
				}

			}

			return $css;


            //$this->create_script( $css, 'css' );
        }

		/**
		 * Deprecated on v1.2.dev
		 */
        public function render_styles(){

            if ( empty( self::$css ) ){
                if ( file_exists( $file = wp_upload_dir()['basedir'] . '/liquid-styles/liquid-frontend-animation-' . get_the_ID() . '.css' ) ){
                    wp_delete_file( $file ); // delete css file
                }
            }

            if ( (defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode()) || empty(self::$css) ){
                return; // check elementor preview mode
            }

           $this->generate_styles(self::$css);

        }

		// check folder
		function check_styles_folder() {
            $uploads = wp_upload_dir();
            $styles_folder = $uploads['basedir'] . DIRECTORY_SEPARATOR . 'liquid-scripts';
            if ( !file_exists( $styles_folder ) ) {
                wp_mkdir_p( $styles_folder );
            }
        }

		// set cache
		function set_cache( $post_id ) {
            $get_cache = get_option('liquid_scripts_cache');
            if ( !is_array($get_cache) ){
                $get_cache = array();
                $get_cache[] = $post_id;
                update_option('liquid_scripts_cache', $get_cache , 'yes' );
            } else {
                $get_cache[] = $post_id;
                update_option('liquid_scripts_cache', array_unique($get_cache), 'yes' );
            }
        }

		/**
		 * Delete `_elementor_css` post meta because it's means the cache for the `elementor/element/parse_css` hook!
		 */
		function delete_elementor_css() {

			$header = liquid_helper()->get_available_custom_post('liquid-header');
			foreach( $header as $id => $value ){
				delete_post_meta( $id, '_elementor_css' );
			}

			$footer = liquid_helper()->get_available_custom_post('liquid-footer');
			foreach( $footer as $id => $value ){
				delete_post_meta( $id, '_elementor_css' );
			}
		}

    }
    new Liquid_Dynamic_Scripts();

}