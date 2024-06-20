<?php

defined( 'ABSPATH' ) || exit;

// WordPress Init
add_action( 'wp', function(){
	$script_id = liquid_helper()->get_script_id();

	if ( function_exists('liquid_helper') && (!liquid_helper()->get_scripts_cache( $script_id ) || liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal') ) {
		include LQD_CORE_PATH . 'elementor/optimization/dynamic-scripts.php';
	}

    include LQD_CORE_PATH . 'elementor/optimization/parse-css/parse-css.php';
} );

// load elementor styles in the editor
add_action( 'wp_enqueue_scripts', function(){

    // Load elementor-fronend css on archive pages
    if ( is_archive() || is_search() || is_home() || is_404() || !liquid_helper()->is_page_elementor() ) {
        wp_enqueue_style('elementor-frontend');
    }

    if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
        wp_dequeue_style( 'liquid-theme' );

        wp_enqueue_style(
            'theme-css',
            LQD_CORE_URL . 'assets/css/themes/aihub/theme.css',
            ['elementor-frontend'],
            LQD_CORE_VERSION
        );

        wp_enqueue_style(
            'theme-editor',
            LQD_CORE_URL . 'assets/css/themes/aihub/theme.editor.css',
            ['theme-css'],
            LQD_CORE_VERSION
        );
    }
});

// Register controls
add_action( 'elementor/controls/register', [ $this, 'register_controls' ] );

// Register widgets
add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

// Elementor After Enqueue
add_action( 'elementor/editor/after_enqueue_scripts', function() {

	wp_enqueue_style(
        'liquid-elementor-editor-controls-style',
        LQD_CORE_URL . 'assets/css/themes/aihub/theme.editor-controls.css',
        ['elementor-editor'],
        LQD_CORE_VERSION
    );

	wp_enqueue_script(
        'liquid-elementor-editor-controls-script',
        LQD_CORE_URL . 'assets/js/themes/aihub/theme.editor-controls.js',
        [],
        LQD_CORE_VERSION,
        true
    );

	wp_localize_script( 'elementor-editor', 'liquidTheme', [
        'uris' => [
            'ajax' => admin_url( 'admin-ajax.php' ),
            'theme' => get_template_directory_uri(),
        ]
    ] );

	// Collections CSS
	wp_add_inline_style( 'liquid-elementor-editor-controls-style', '#elementor-template-library-templates{padding-bottom:40px}.elementor-template-library-expanded-template{position:absolute;right:10px;top:10px;background:#f9da68;color:#34383c;padding:2px 6px;border-radius:1.5px;font-weight:bold}.elementor-template-library-expanded-template-alert{display:grid;place-content:center;position:absolute;width:100%;bottom:0;left:0;z-index:999;height:40px;padding:20px;font-size:14px;font-weight:bold;background:#f9da68;color:#34383c}.elementor-template-library-expanded-template-alert a{color:inherit;text-decoration:underline}.elementor-template-library-hub-title{margin-top:.5em}.elementor-template-library-hub-title span{opacity:.5}' );

	// Liquid Template Editor JS
	wp_add_inline_script( 'elementor-editor', '

		let tmpl_id = 0,
		new_tmpl_id = 0,
		tmpl_control = "",
		tmpl_action = "";

		function lqd_edit_tmpl(event){

			tmpl_action = "edit";
			document.querySelector("#lqd-tmpl-edit").style.display = "block";

			// get current template id
			var parent = (event.target).parentElement.parentElement.parentElement;
			var children = parent.children;
			tmpl_control = children[0].children[0].control;
			tmpl_id = tmpl_control.value ? tmpl_control.value : "";

			if ( tmpl_id ) {
				document.getElementById("lqd-tmpl-edit-iframe").setAttribute("src", "'. admin_url() .'post.php?post=" + tmpl_id + "&action=elementor");
				console.log("LIQUID - Editing Template: " + tmpl_id);
			} else {
				console.log("LIQUID - Template ID not found!");
			}

		}

		function lqd_add_tmpl(event){

			tmpl_action = "add";
			document.querySelector("#lqd-tmpl-edit").style.display = "block";

			// get current template id
			var parent = (event.target).parentElement.parentElement.parentElement;
			var children = parent.children;
			tmpl_control = children[0].children[0].control;
			tmpl_id = tmpl_control.value ? tmpl_control.value : "";


			jQuery.post(ajaxurl, { "action": "lqd_add_tmpl" }, function (response) {
				new_tmpl_id = response.data;
				jQuery(tmpl_control).append("<option value="+ new_tmpl_id +">Template #" + new_tmpl_id + "</option>");
				document.getElementById("lqd-tmpl-edit-iframe").setAttribute("src", "'. admin_url() .'post.php?post=" + new_tmpl_id + "&action=elementor");
				console.log("LIQUID - New Template Added: Template #" + new_tmpl_id );
			});


			if ( tmpl_id ) {
				console.log("LIQUID - Editing Template: " + tmpl_id);
			} else {
				console.log("LIQUID - Template ID not found!");
			}

		}

		// Edit Custom CPT
		elementor.on( "document:loaded", () => {

			console.log("LIQUID - Elementor iframe loaded!");

			const elementorPreviewIframe = document.querySelector("#elementor-preview-iframe");

			// Get the button element from the iframe

			const editButtons = elementorPreviewIframe.contentWindow.document.querySelectorAll(".lqd-tmpl-edit-cpt--btn");

			editButtons.forEach(function(button) {
				button.addEventListener("click", function(event) {

					tmpl_id = button.getAttribute("data-post-id");
					document.querySelector("#lqd-tmpl-edit").style.display = "block";
					document.getElementById("lqd-tmpl-edit-iframe").setAttribute("src", "'. admin_url() .'post.php?post=" + tmpl_id + "&action=elementor");
					console.log("LIQUID - Editing Template: " + tmpl_id);
				});
			});

			// Close iFrame
			document.querySelector(".lqd-tmpl-edit--close").addEventListener("click", function(){
				document.getElementById("lqd-tmpl-edit-iframe").setAttribute("src", "about:blank");
				document.querySelector("#lqd-tmpl-edit").style.display = "none";
				if ( tmpl_action === "add" ) {
					jQuery(tmpl_control).val( new_tmpl_id );
					jQuery(tmpl_control).trigger( "change" );
				} else if ( tmpl_action === "edit" ) {
					jQuery(tmpl_control).val( tmpl_id );
					jQuery(tmpl_control).trigger( "change" );
				} else if ( tmpl_action === "cpt" ) {
					// do something
				}

			});

		} );

		'
	);
} );

// Elementor Preview CSS / JS
add_action( 'elementor/preview/enqueue_styles', function() {
    wp_enqueue_script(
        'tinycolor',
        LQD_CORE_URL . 'assets/vendors/tinycolor.js',
        [
			'fastdom',
			'fastdom-promised',
			'underscore',
			'backbone',
			'backbone-native',
			'gsap',
			'gsap-scrolltrigger',
			'gsap-draw-svg',
			'gsap-scrollto',
			'elementor-frontend'
		],
        LQD_CORE_VERSION,
        true
    );

    wp_enqueue_script(
        'theme-js',
        LQD_CORE_URL . 'assets/js/themes/aihub/theme.js',
        [
			'fastdom',
			'fastdom-promised',
			'underscore',
			'backbone',
			'backbone-native',
			'gsap',
			'gsap-scrolltrigger',
			'gsap-scrollto',
			'gsap-draw-svg',
			'elementor-frontend'
		],
        LQD_CORE_VERSION,
        true
    );

    wp_enqueue_script(
        'theme-editor',
        LQD_CORE_URL . 'assets/js/themes/aihub/theme.editor.js',
        ['elementor-frontend'],
        LQD_CORE_VERSION,
        true
    );

	wp_enqueue_script( 'tsparticles' );
} );

// Elementor Template Editor - Add new template / ajax
add_action( 'wp_ajax_lqd_add_tmpl', function(){

	$post_id = wp_insert_post(
		[
			'post_type' => 'elementor_library',
			'meta_input' => [ '_elementor_template_type' => 'section' ]
		]
	);

	if( ! is_wp_error( $post_id ) ) {
		wp_update_post(
			[
				'ID' => $post_id,
				'post_title'=> sprintf( 'Template #%s', $post_id )
			]
		);
		wp_send_json_success( $post_id );
	}

} );

// Elementor Template Editor - Template & Style
add_action( 'elementor/editor/footer', function() {
	?>
		<style>
			.lqd-tmpl-edit-editor-buttons{
				display: flex;
				gap: 1em;
				width: 100%;
			}
			.lqd-tmpl-edit-editor-buttons button {
				width: 100%;
				padding: .7em;
				text-transform: capitalize;
				font-size: 10px;
			}
			#lqd-tmpl-edit {
				position: fixed;
				z-index: 99999;
				width: 90%;
				height: 90%;
				left:5%;
				top: calc(5% - 20px);
				background: #fff;
				box-shadow: 0 0 120px #000;
			}
			.lqd-tmpl-edit--header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				background-color: #26292C;
				height: 39px;
				border-bottom: solid 1px #404349;
				padding: 1em;
			}
			.lqd-tmpl-edit--logo {
				display: inline-flex;
				align-items: center;
				gap: 10px;
				font-weight: 500;
			}
			.lqd-tmpl-edit--close {
				font-size: 20px;
				cursor: pointer;
				padding: 20px;
				margin-inline-end: -20px;
			}
		</style>
		<div id="lqd-tmpl-edit" class="lqd-tmpl-edit" style="display:none;">
			<div class="lqd-tmpl-edit--header">
				<div class="lqd-tmpl-edit--logo"><img src="<?php echo esc_url( LQD_CORE_URL . 'assets/img/logo/liquid-logo.svg' );?>" height="20"><?php esc_html_e( 'Edit Template' ); ?></div>
				<div class="lqd-tmpl-edit--close">&times;</div>
			</div>
			<iframe src="about:blank" width="100%" height="100%" frameborder="0" id="lqd-tmpl-edit-iframe"></iframe>
		</div>
		<script>
			(() => {
				const closeModal = document.querySelector('.lqd-tmpl-edit--close');
				if ( !closeModal ) return;
				closeModal.addEventListener('click', async () => {
					if ( typeof $e === 'undefined' ) return;
					await $e.run('document/save/update', { force: true });
					elementor.reloadPreview();
				})
			})();
		</script>
	<?php
} );

// Add custom fonts to elementor from redux
if ( function_exists( 'liquid_helper' ) ){

    if ( !empty( liquid_helper()->get_kit_option( 'liquid_custom_fonts' ) ) ){
        // Add Fonts Group
        add_filter( 'elementor/fonts/groups', function( $font_groups ) {
            $font_groups['liquid_custom_fonts'] = __( 'Liquid Custom Fonts' );
            return $font_groups;
        } );

        // Add Group Fonts
        add_filter( 'elementor/fonts/additional_fonts', function( $additional_fonts ) {
            $font_list = liquid_helper()->get_kit_option( 'liquid_custom_fonts' );
            foreach( $font_list as $font){
                if ( !isset( $font['title']) ) return;
                // Font name/font group
                $additional_fonts[$font['title']] = 'liquid_custom_fonts';
            }
            return $additional_fonts;
        } );

    }

    // Google Fonts display
    if ( get_option( 'elementor_font_display' ) !== liquid_helper()->get_kit_option( 'liquid_google_font_display' ) ) {
        update_option( 'elementor_font_display', liquid_helper()->get_kit_option( 'liquid_google_font_display' ) );
    }

}

// Add missing Google Fonts
add_filter( 'elementor/fonts/additional_fonts', function( $additional_fonts ){
    if ( !is_array($additional_fonts) ) {
        $additional_fonts = [];
    }
    $fonts = array(
        // font name => font file (system / googlefonts / earlyaccess / local)
        'Outfit' => 'googlefonts',
        'Golos Text' => 'googlefonts',
        'Wix Madefor Text' => 'googlefonts',
        'Gloock' => 'googlefonts',
        'Bricolage Grotesque' => 'googlefonts',
		'Instrument Sans' => 'googlefonts',
    );
    $fonts = array_merge( $fonts, $additional_fonts );
    return $fonts;
} );

// Custom Shapes
add_action( 'elementor/shapes/additional_shapes', function( $additional_shapes ) {

    for ($i=1; $i<=16; $i++){
        $additional_shapes[ 'lqd-custom-shape-'.$i ] = [
            'title' => __('Liquid Shape - '.$i, 'aihub-core'),
            'path' => LQD_CORE_PATH . 'elementor/params/shape-divider/'.$i.'.svg',
            'url' => LQD_CORE_PLUGIN_URL . 'elementor/params/shape-divider/'.$i.'.svg',
            'has_flip' => false,
            'has_negative' => false,
        ];
    }
    return $additional_shapes;
});

// Woocommerce Session Handler
if ( class_exists( 'WooCommerce' ) && (! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin()) ) {
    add_action( 'admin_action_elementor', function(){
        \WC()->frontend_includes();
        if ( is_null( \WC()->cart ) ) {
            global $woocommerce;
            $session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
            $woocommerce->session = new $session_class();
            $woocommerce->session->init();

            $woocommerce->cart     = new \WC_Cart();
            $woocommerce->customer = new \WC_Customer( get_current_user_id(), true );
        }
    }, 5 );
}

// Regenerate css after save for footer
add_action( 'elementor/editor/after_save', function( $post_id ) {

    if (
        get_post_type( $post_id ) === 'liquid-header' ||
        get_post_type( $post_id ) === 'liquid-footer' ||
        get_post_type( $post_id ) === 'liquid-mega-menu'
    ){
        \Elementor\Plugin::instance()->files_manager->clear_cache();
		liquid_helper()->purge_scripts_cache( true );
		delete_post_meta( $post_id, '_liquid_post_content' );
		delete_post_meta( $post_id, '_liquid_post_content_has_bg' );
		update_option( 'liquid_utils_css', '' );
    } else {
        \Elementor\Plugin::instance()->files_manager->clear_cache();
		liquid_helper()->purge_scripts_cache( $post_id );
    }

	update_option( 'liquid_widget_asset_css', array() );
	update_option( 'lqd_el_container_bg', array() );

});

// Purge liquid cache after the document save 
add_action( 'elementor/document/after_save', function( $post_id ) {
	liquid_helper()->purge_all_cache();
});

// Hide performance kit with css
add_action( 'elementor/editor/wp_head', function(){
	echo '<style>.elementor-control-section_liquid-performance-kit_css,.elementor-control-section_liquid-performance-kit_js,.elementor-control-section_liquid-performance-kit_fonts_and_icon,.elementor-control-section_liquid-performance-kit_lazyload,.elementor-control-section_liquid-performance-kit_plugins,.elementor-panel-menu-item-liquid-portfolio-kit,.elementor-control-section_liquid-extras-kit_custom_cursor,.elementor-control-liquid_cc,.elementor-control-section_liquid-extras-kit_preloader,.elementor-control-section_liquid-extras-kit_local_scroll,.elementor-control-section_liquid-extras-kit_back_to_top{display:none!important}</style>';
});

function add_inline_script( $element ) {

	if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		return;
	}

	$behavior = $page_behavior = '';

	$element_id = $element->get_id();
	if ( method_exists( $element, 'get_behavior' ) ) {
		foreach( $element->get_behavior() as $behaviorArray ) {
			wp_enqueue_script($behaviorArray['behaviorClass']);
		}

		if ( !empty($element->get_behavior() ) ) {
			$get_behavior = wp_json_encode($element->get_behavior());
			$behavior .= preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $get_behavior ) . ',';
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

						$parallax_css[$device][$selector] = $rules;
						printf( '<style>%s</style>', liquid_helper()->generate_styles($parallax_css) );
						$parallax_css = [];
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

		if ( ! wp_script_is('LiquidGetElementComputedStylesBehavior') ) {
			wp_enqueue_script( 'LiquidGetElementComputedStylesBehavior' );
		}

		if ( ! wp_script_is('LiquidAnimationsBehavior') ) {
			wp_enqueue_script( 'LiquidAnimationsBehavior' );
		}

		// array to json
		$parallax_behavior = wp_json_encode($final);
		$parallax_behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $parallax_behavior ) . ',';
		$behavior .= $parallax_behavior;

	}

	// Animations
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

							$animations_css[$device][$selector] = $rules;
							printf( '<style>%s</style>', liquid_helper()->generate_styles($animations_css) );
							$animations_css = [];
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

		if ( ! wp_script_is('LiquidGetElementComputedStylesBehavior') ) {
			wp_enqueue_script( 'LiquidGetElementComputedStylesBehavior' );
		}

		if ( ! wp_script_is('LiquidAnimationsBehavior') ) {
			wp_enqueue_script( 'LiquidAnimationsBehavior' );
		}

		// array to json
		$animation_behavior = wp_json_encode($final);
		$animation_behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $animation_behavior ) . ',';

		$behavior .= $animation_behavior;

	}

	// Page Behaviors
	if ( method_exists( $element, 'get_behavior_pageContent' ) ) {
		if ( !empty( $element->get_behavior_pageContent() ) ) {
			foreach( $element->get_behavior_pageContent() as $page_behaviorArray ) {
				wp_enqueue_script($page_behaviorArray['behaviorClass']);
			}

			$page_behavior = wp_json_encode($element->get_behavior_pageContent());
			$page_behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $page_behavior ) . ',';

			$page_behavior = "
			window.liquid.behaviors.push( {
				layoutRegion: \"liquidPageContent\",
				behaviors:[
					{$page_behavior}
				]
			} );";
		}
	}

	if ( !empty( $behavior ) || !empty( $page_behavior ) ) {
		$behavior = "<script>
		window.liquid.behaviors.push( {
			dataId: \"$element_id\",
			behaviors:[
				{$behavior}
			]
		} );
		{$page_behavior}
		</script>";

		$behavior = liquid_helper()->updateBehaviorNames($behavior);

		echo $behavior;
	}
}

function add_container_inline_script( $element ) {

	if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		return;
	}

	$settings = $element->get_settings();
	$element_id = $element->get_id();
	$behavior = $page_behavior = '';

	if ( $settings['lqd_adaptive_color'] === 'yes' ) {
		$behavior = [];
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

		foreach( $behavior as $behaviorArray ) {
			wp_enqueue_script($behaviorArray['behaviorClass']);
		}
		$behavior = wp_json_encode($behavior);
		$behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $behavior ) . ',';

		// Page Behaviors
		$page_behavior = [];

		$page_behavior[] = [
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

		$page_behavior = wp_json_encode($page_behavior);
		$page_behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $page_behavior ) . ',';

		$page_behavior = "
		window.liquid.behaviors.push( {
			layoutRegion: \"liquidPageContent\",
			behaviors:[
				{$page_behavior}
			]
		} );";

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

						$parallax_css[$device][$selector] = $rules;
						printf( '<style>%s</style>', liquid_helper()->generate_styles($parallax_css) );
						$parallax_css = [];
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

		if ( ! wp_script_is('LiquidGetElementComputedStylesBehavior') ) {
			wp_enqueue_script( 'LiquidGetElementComputedStylesBehavior' );
		}

		if ( ! wp_script_is('LiquidAnimationsBehavior') ) {
			wp_enqueue_script( 'LiquidAnimationsBehavior' );
		}

		// array to json
		$parallax_behavior = wp_json_encode($final);
		$parallax_behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $parallax_behavior ) . ',';
		$behavior .= $parallax_behavior;

	}

	// Animations
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

							$animations_css[$device][$selector] = $rules;
							printf( '<style>%s</style>', liquid_helper()->generate_styles($animations_css) );
							$animations_css = [];
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

		if ( ! wp_script_is('LiquidGetElementComputedStylesBehavior') ) {
			wp_enqueue_script( 'LiquidGetElementComputedStylesBehavior' );
		}

		if ( ! wp_script_is('LiquidAnimationsBehavior') ) {
			wp_enqueue_script( 'LiquidAnimationsBehavior' );
		}

		// array to json
		$animation_behavior = wp_json_encode($final);
		$animation_behavior = preg_replace( ['/(?<!\\\\)"/','/\[\{/', '/\}\]/'], ['','{', '}'] , $animation_behavior ) . ',';

		$behavior .= $animation_behavior;

	}

	if ( !empty( $behavior ) ) {
		$behavior = "<script>
		window.liquid.behaviors.push( {
			dataId: \"$element_id\",
			behaviors:[
				{$behavior}
			]
		} );
		{$page_behavior}
		</script>";

		$behavior = liquid_helper()->updateBehaviorNames($behavior);

		echo $behavior;
	}


}

if ( function_exists('liquid_helper') && liquid_helper()->get_kit_option('liquid_script_print_method') == 'internal' ) {
	add_action( 'elementor/frontend/widget/after_render', 'add_inline_script' );
	add_action( 'elementor/frontend/container/after_render', 'add_container_inline_script' );
}
