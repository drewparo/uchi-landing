<?php

use Elementor\Controls_Manager;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor background control.
 *
 * A base control for creating background control. Displays input fields to define
 * the background color, background image, background gradient or background video.
 *
 * @since 1.0.0
 */
class Liquid_Group_Control_Background extends \Elementor\Group_Control_Base {

	/**
	 * Fields.
	 *
	 * Holds all the background control fields.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @static
	 *
	 * @var array Background control fields.
	 */
	protected static $fields;

	/**
	 * Background Types.
	 *
	 * Holds all the available background types.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var array
	 */
	private static $background_types;

	/**
	 * css attribute
	 *
	 * background is the default. it can be something else like --lqd-accordion-i-bg
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var string
	 */
	private static $css_attr;

	/**
	 * Get background control type.
	 *
	 * Retrieve the control type, in this case `background`.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Control type.
	 */
	public static function get_type() {
		return 'liquid-background';
	}

	/**
	 * Get background control types.
	 *
	 * Retrieve available background types.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array Available background types.
	 */
	public static function get_background_types() {
		if ( null === self::$background_types ) {
			self::$background_types = self::get_default_background_types();
		}

		return self::$background_types;
	}

	/**
	 * Get css attribute
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string
	 */
	public static function get_css_attr() {
		if ( null === self::$css_attr ) {
			self::$css_attr = self::get_default_css_attr();
		}

		return self::$css_attr;
	}

	/**
	 * Get Default background types.
	 *
	 * Retrieve background control initial types.
	 *
	 * @since 2.0.0
	 * @access private
	 * @static
	 *
	 * @return array Default background types.
	 */
	private static function get_default_background_types() {
		return [
			'color' => [
				'title' => _x( 'Color and gradient', 'Background Control', 'aihub-core' ),
				'icon' => 'eicon-paint-brush',
			],
			'image' => [
				'title' => _x( 'Image', 'Background Control', 'aihub-core' ),
				'icon' => 'eicon-image-bold',
			],
			// 'video' => [
			// 	'title' => _x( 'Video', 'Background Control', 'aihub-core' ),
			// 	'icon' => 'eicon-video-camera',
			// ],
			// 'slideshow' => [
			// 	'title' => _x( 'Slideshow', 'Background Control', 'aihub-core' ),
			// 	'icon' => 'eicon-slideshow',
			// ],
			'particles' => [
				'title' => _x( 'Particles', 'Background Control', 'aihub-core' ),
				'icon' => 'eicon-rating',
			],
			'animated-gradient' => [
				'title' => _x( 'Animated gradient', 'Background Control', 'aihub-core' ),
				'icon' => 'eicon-barcode',
			],
		];
	}

	/**
	 * Get Default css attr.
	 *
	 *
	 * @since 2.0.0
	 * @access private
	 * @static
	 *
	 * @return string
	 */
	private static function get_default_css_attr() {
		return 'background';
	}

	/**
	 * Init fields.
	 *
	 * Initialize background control fields.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Control fields.
	 */
	public function init_fields() {
		$fields = [];
		$items = new \Elementor\Repeater();

		$items->add_control(
			'background', [
				'label' => _x( 'Type', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => self::get_background_types(),
			]
		);

		// color
		$items->add_control(
			'color', [
				'type' => 'liquid-color',
				'label' => _x( 'Color and gradient', 'Background Control', 'aihub-core' ),
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'color' ],
				],
			]
		);

		// image
		$items->add_responsive_control(
			'image', [
				'label' => _x( 'Image', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'title' => _x( 'Background Image', 'Background Control', 'aihub-core' ),
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-image: url("{{URL}}");',
				],
				'render_type' => 'template',
				'condition' => [
					'background' => [ 'image' ],
				],
			]
		);
		$items->add_responsive_control(
			'position', [
				'label' => _x( 'Position', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'Default', 'Background Control', 'aihub-core' ),
					'center center' => _x( 'Center Center', 'Background Control', 'aihub-core' ),
					'center left' => _x( 'Center Left', 'Background Control', 'aihub-core' ),
					'center right' => _x( 'Center Right', 'Background Control', 'aihub-core' ),
					'top center' => _x( 'Top Center', 'Background Control', 'aihub-core' ),
					'top left' => _x( 'Top Left', 'Background Control', 'aihub-core' ),
					'top right' => _x( 'Top Right', 'Background Control', 'aihub-core' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'aihub-core' ),
					'bottom left' => _x( 'Bottom Left', 'Background Control', 'aihub-core' ),
					'bottom right' => _x( 'Bottom Right', 'Background Control', 'aihub-core' ),
					'initial' => _x( 'Custom', 'Background Control', 'aihub-core' ),
				],
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-position: {{VALUE}};',
				],
				'of_type' => 'image',
				'condition' => [
					'background' => [ 'image' ],
					'image[url]!' => '',
				],
			]
		);
		$items->add_responsive_control(
			'xpos', [
				'label' => _x( 'X Position', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
					'em' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
				],
				'of_type' => 'image',
				'condition' => [
					'position' => [ 'initial' ],
					'background' => [ 'image' ],
					'image[url]!' => '',
				],
				'required' => true,
			]
		);
		$items->add_responsive_control(
			'ypos', [
				'label' => _x( 'Y Position', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vh' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
					'em' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-position: {{xpos.SIZE}}{{xpos.UNIT}} {{SIZE}}{{UNIT}}',
				],
				'of_type' => 'image',
				'condition' => [
					'position' => [ 'initial' ],
					'background' => [ 'image' ],
					'image[url]!' => '',
				],
				'required' => true,
			]
		);
		$items->add_control(
			'attachment', [
				'label' => _x( 'Attachment', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'Default', 'Background Control', 'aihub-core' ),
					'scroll' => _x( 'Scroll', 'Background Control', 'aihub-core' ),
					'fixed' => _x( 'Fixed', 'Background Control', 'aihub-core' ),
				],
				'selectors' => [
					'(desktop+){{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-attachment: {{VALUE}};',
				],
				'of_type' => 'image',
				'condition' => [
					'background' => [ 'image' ],
					'image[url]!' => '',
				],
			]
		);
		$items->add_control(
			'attachment_alert', [
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-control-field-description',
				'raw' => esc_html__( 'Note: Attachment Fixed works only on desktop.', 'aihub-core' ),
				'separator' => 'none',
				'of_type' => 'image',
				'condition' => [
					'background' => [ 'image' ],
					'image[url]!' => '',
					'attachment' => 'fixed',
				],
			]
		);
		$items->add_responsive_control(
			'repeat', [
				'label' => _x( 'Repeat', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'Default', 'Background Control', 'aihub-core' ),
					'no-repeat' => _x( 'No-repeat', 'Background Control', 'aihub-core' ),
					'repeat' => _x( 'Repeat', 'Background Control', 'aihub-core' ),
					'repeat-x' => _x( 'Repeat-x', 'Background Control', 'aihub-core' ),
					'repeat-y' => _x( 'Repeat-y', 'Background Control', 'aihub-core' ),
				],
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-repeat: {{VALUE}};',
				],
				'of_type' => 'image',
				'condition' => [
					'background' => [ 'image' ],
					'image[url]!' => '',
				],
			]
		);
		$items->add_responsive_control(
			'size', [
				'label' => _x( 'Size', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'Default', 'Background Control', 'aihub-core' ),
					'auto' => _x( 'Auto', 'Background Control', 'aihub-core' ),
					'cover' => _x( 'Cover', 'Background Control', 'aihub-core' ),
					'contain' => _x( 'Contain', 'Background Control', 'aihub-core' ),
					'initial' => _x( 'Custom', 'Background Control', 'aihub-core' ),
				],
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-size: {{VALUE}};',
				],
				'of_type' => 'image',
				'condition' => [
					'background' => [ 'image' ],
					'image[url]!' => '',
				],
			]
		);
		$items->add_responsive_control(
			'bg_width', [
				'label' => _x( 'Width', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'required' => true,
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background-size: {{SIZE}}{{UNIT}} auto',

				],
				'of_type' => 'image',
				'condition' => [
					'size' => [ 'initial' ],
					'background' => [ 'image' ],
					'image[url]!' => '',
				],
			]
		);

		$items->add_control(
			'video_link', [
				'label' => _x( 'Video Link', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'description' => esc_html__( 'YouTube/Vimeo link, or link to video file (mp4 is recommended).', 'aihub-core' ),
				'label_block' => true,
				'default' => '',
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'condition' => [
					'background' => [ 'video' ],
				],
				'of_type' => 'video',
				'frontend_available' => true,
			]
		);
		$items->add_control(
			'video_start', [
				'label' => esc_html__( 'Start Time', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify a start time (in seconds)', 'aihub-core' ),
				'placeholder' => 10,
				'condition' => [
					'background' => [ 'video' ],
				],
				'of_type' => 'video',
				'frontend_available' => true,
			]
		);
		$items->add_control(
			'video_end', [
				'label' => esc_html__( 'End Time', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify an end time (in seconds)', 'aihub-core' ),
				'placeholder' => 70,
				'condition' => [
					'background' => [ 'video' ],
				],
				'of_type' => 'video',
				'frontend_available' => true,
			]
		);
		$items->add_control(
			'play_once', [
				'label' => esc_html__( 'Play Once', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'background' => [ 'video' ],
				],
				'of_type' => 'video',
				'frontend_available' => true,
			]
		);
		$items->add_control(
			'play_on_mobile', [
				'label' => esc_html__( 'Play On Mobile', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'background' => [ 'video' ],
				],
				'of_type' => 'video',
				'frontend_available' => true,
			]
		);
		// This control was added to handle a bug with the Youtube Embed API. The bug: If there is a video with Privacy
		// Mode on, and at the same time the page contains another video WITHOUT privacy mode on, one of the videos
		// will not run properly. This added control allows users to align all their videos to one host (either
		// youtube.com or youtube-nocookie.com, depending on whether the user wants privacy mode on or not).
		// $items->add_control(
		// 	'privacy_mode', [
		// 		'label' => esc_html__( 'Privacy Mode', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'description' => esc_html__( 'Only works for YouTube videos.', 'aihub-core' ),
		// 		'condition' => [
		// 			'background' => [ 'video' ],
		// 		],
		// 		'of_type' => 'video',
		// 		'frontend_available' => true,
		// 	]
		// );
		$items->add_control(
			'video_fallback', [
				'label' => _x( 'Background Fallback', 'Background Control', 'aihub-core' ),
				'description' => esc_html__( 'This cover image will replace the background video in case that the video could not be loaded.', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'background' => [ 'video' ],
				],
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
				],
				'of_type' => 'video',
			]
		);

		// slideshow
		$items->add_control(
			'slideshow_gallery', [
				'label' => _x( 'Images', 'Background Control', 'aihub-core' ),
				'type' => Controls_Manager::GALLERY,
				'condition' => [
					'background' => [ 'slideshow' ],
				],
				'show_label' => false,
				'of_type' => 'slideshow',
				'frontend_available' => true,
			]
		);
		$items->add_control(
			'slideshow_slide_duration', [
				'label' => esc_html__( 'Duration', 'aihub-core' ) . ' (ms)',
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'background' => [ 'slideshow' ],
				],
				'frontend_available' => true,
			]
		);
		// $items->add_control(
		// 	'slideshow_slide_transition', [
		// 		'label' => esc_html__( 'Transition', 'aihub-core' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'fade',
		// 		'options' => [
		// 			'fade' => 'Fade',
		// 			'slide_right' => 'Slide Right',
		// 			'slide_left' => 'Slide Left',
		// 			'slide_up' => 'Slide Up',
		// 			'slide_down' => 'Slide Down',
		// 		],
		// 		'condition' => [
		// 			'background' => [ 'slideshow' ],
		// 		],
		// 		'of_type' => 'slideshow',
		// 		'frontend_available' => true,
		// 	]
		// );
		$items->add_control(
			'slideshow_transition_duration', [
				'label' => esc_html__( 'Transition Duration', 'aihub-core' ) . ' (ms)',
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'condition' => [
					'background' => [ 'slideshow' ],
				],
				'frontend_available' => true,
			]
		);
		// $items->add_responsive_control(
		// 	'slideshow_background_size', [
		// 		'label' => esc_html__( 'Background Size', 'aihub-core' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => '',
		// 		'options' => [
		// 			'' => esc_html__( 'Default', 'aihub-core' ),
		// 			'auto' => esc_html__( 'Auto', 'aihub-core' ),
		// 			'cover' => esc_html__( 'Cover', 'aihub-core' ),
		// 			'contain' => esc_html__( 'Contain', 'aihub-core' ),
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .elementor-background-slideshow__slide__image' => 'background-size: {{VALUE}};',
		// 		],
		// 		'condition' => [
		// 			'background' => [ 'slideshow' ],
		// 		],
		// 	]
		// );
		// $items->add_responsive_control(
		// 	'slideshow_background_position', [
		// 		'label' => esc_html__( 'Background Position', 'aihub-core' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => '',
		// 		'options' => [
		// 			'' => esc_html__( 'Default', 'aihub-core' ),
		// 			'center center' => _x( 'Center Center', 'Background Control', 'aihub-core' ),
		// 			'center left' => _x( 'Center Left', 'Background Control', 'aihub-core' ),
		// 			'center right' => _x( 'Center Right', 'Background Control', 'aihub-core' ),
		// 			'top center' => _x( 'Top Center', 'Background Control', 'aihub-core' ),
		// 			'top left' => _x( 'Top Left', 'Background Control', 'aihub-core' ),
		// 			'top right' => _x( 'Top Right', 'Background Control', 'aihub-core' ),
		// 			'bottom center' => _x( 'Bottom Center', 'Background Control', 'aihub-core' ),
		// 			'bottom left' => _x( 'Bottom Left', 'Background Control', 'aihub-core' ),
		// 			'bottom right' => _x( 'Bottom Right', 'Background Control', 'aihub-core' ),
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .elementor-background-slideshow__slide__image' => 'background-position: {{VALUE}};',
		// 		],
		// 		'condition' => [
		// 			'background' => [ 'slideshow' ],
		// 		],
		// 	]
		// );
		// $items->add_control(
		// 	'slideshow_ken_burns', [
		// 		'label' => esc_html__( 'Ken Burns Effect', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'separator' => 'before',
		// 		'condition' => [
		// 			'background' => [ 'slideshow' ],
		// 		],
		// 		'of_type' => 'slideshow',
		// 		'frontend_available' => true,
		// 	]
		// );
		// $items->add_control(
		// 	'slideshow_ken_burns_zoom_direction', [
		// 		'label' => esc_html__( 'Direction', 'aihub-core' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'in',
		// 		'options' => [
		// 			'in' => esc_html__( 'In', 'aihub-core' ),
		// 			'out' => esc_html__( 'Out', 'aihub-core' ),
		// 		],
		// 		'condition' => [
		// 			'background' => [ 'slideshow' ],
		// 			'slideshow_ken_burns!' => '',
		// 		],
		// 		'of_type' => 'slideshow',
		// 		'frontend_available' => true,
		// 	]
		// );

		// particles
		$items->add_control(
			'particles', [
				'label' => _x( 'Particles', 'Background Control', 'aihub-core' ),
				'type' => 'liquid-particles',
				'condition' => [
					'background' => [ 'particles' ],
				],
			]
		);
		$items->add_control(
			'particles_config', [
				'label' => _x( 'Particles config', 'Background Control', 'aihub-core' ),
				'description' => __( 'You can get the config from <a target="_blank" href="https://particles.js.org">https://particles.js.org</a>', 'aihub-core' ),
				'type' => Controls_Manager::CODE,
				'language' => 'javascript',
				'of_type' => 'particles',
				'condition' => [
					'background' => [ 'particles' ],
				],
			]
		);

		$items->add_control(
			'animated_gradient_colors', [
				'label' => esc_html__( 'Colors', 'aihub-core' ),
				'description' => esc_html__( 'Just add colors. Position of each stop does not matter.', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'linear-gradient' ],
				'default' => 'linear-gradient(145deg, #FFB7B7 0%, #BDFFF5 16.66%, #F6FFA6 33.32%, #59D877 49.98%, #32F1B8 66.64%, #356EF4 83.33%, #FF3CF6 100%)',
				'of_type' => 'animated-gradient',
				'condition' => [
					'background' => [ 'animated-gradient' ],
				],
			]
		);

		$items->add_control(
			'animated_gradient_duration', [
				'label' => esc_html__( 'Duration', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'of_type' => 'animated-gradient',
				'condition' => [
					'background' => 'animated-gradient',
				],
			]
		);

		$items->add_control(
			'lqd_bg_layer_opacity', [
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'opacity: {{SIZE}}'
				]
			]
		);

		$items->add_control(
			'lqd_bg_layer_blend_mode',
			[
				'label' => esc_html__( 'Blend mode', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'aihub-core' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'hard-light' => 'Hard light',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'difference' => 'Difference',
					'exclusion' => 'Exclusion',
					'hue' => 'Hue',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{SELECTOR}} {{CURRENT_ITEM}}-{{ID}}' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$fields['liquid_background_items'] = [
			'label' => esc_html__( 'Background', 'aihub-core' ),
			'description' => esc_html__( 'If you choose something other than image, video or slideshow as the first layer, you have to set an image height from Style tab.', 'aihub-core' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => $items->get_controls(),
			'default' => [],
			'prevent_empty' => false,
			'title_field' => '{{{ `${background.charAt(0).toUpperCase()}${background.substring(1).replace("-", " ")}` }}}',
		];

		return $fields;
	}

	/**
	 * Get child default args.
	 *
	 * Retrieve the default arguments for all the child controls for a specific group
	 * control.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Default arguments for all the child controls.
	 */
	protected function get_child_default_args() {
		return [
			'types' => [ 'color', 'image' ],
			'selector' => '{{WRAPPER}}',
			'css_attr' => 'background'
		];
	}

	/**
	 * Filter fields.
	 *
	 * Filter which controls to display, using `include`, `exclude`, `condition`
	 * and `of_type` arguments.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control fields.
	 */
	protected function filter_fields() {
		$fields = parent::filter_fields();

		$args = $this->get_args();

		foreach ( $fields as &$field ) {
			if ( isset( $field['of_type'] ) && ! in_array( $field['of_type'], $args['types'] ) ) {
				unset( $field );
			}
		}

		return $fields;
	}

	/**
	 * Prepare fields.
	 *
	 * Process background control fields before adding them to `add_control()`.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param array $fields Background control fields.
	 *
	 * @return array Processed fields.
	 */
	protected function prepare_fields( $fields ) {
		$args = $this->get_args();

		$background_types = self::get_background_types();

		$choose_types = [];

		foreach ( $args['types'] as $type ) {
			if ( isset( $background_types[ $type ] ) ) {
				$choose_types[ $type ] = $background_types[ $type ];
			}
		}

		$fields['liquid_background_items']['fields']['background']['options'] = $choose_types;

		return parent::prepare_fields( $fields );
	}

	/**
	 * Get default options.
	 *
	 * Retrieve the default options of the background control. Used to return the
	 * default options while initializing the background control.
	 *
	 * @since 1.9.0
	 * @access protected
	 *
	 * @return array Default background control options.
	 */
	protected function get_default_options() {
		return [
			'popover' => false,
			'css_attr' => 'background'
		];
	}
}

\Elementor\Plugin::instance()->controls_manager->add_group_control( Liquid_Group_Control_Background::get_type(), new Liquid_Group_Control_Background() );
