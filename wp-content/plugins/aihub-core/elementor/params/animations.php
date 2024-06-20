<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

function lqd_elementor_add_animation_controls( $widget ){

	$ease_list = [
		'linear' => 'Linear',
		'power1.in' => 'Power1 In',
		'power1.out' => 'Power1 Out',
		'power1.inOut' => 'Power1 In Out',
		'power2.in' => 'Power2 In',
		'power2.out' => 'Power2 Out',
		'power2.inOut' => 'Power2 In Out',
		'power3.in' => 'Power3 In',
		'power3.out' => 'Power3 Out',
		'power3.inOut' => 'Power3 In Out',
		'power4.in' => 'Power4 In',
		'power4.out' => 'Power4 Out',
		'power4.inOut' => 'Power4 In Out',
		'back.in' => 'Back In',
		'back.out' => 'Back Out',
		'back.inOut' => 'Back In Out',
		'bounce.in' => 'Bounce In',
		'bounce.out' => 'Bounce Out',
		'bounce.inOut' => 'Bounce In Out',
		'circ.in' => 'Circ In',
		'circ.out' => 'Circ Out',
		'circ.inOut' => 'Circ In Out',
		'elastic.in(1,0.2)' => 'Elastic In',
		'elastic.out(1,0.2)' => 'Elastic Out',
		'elastic.inOut(1,0.2)' => 'Elastic In Out',
		'expo.in' => 'Expo In',
		'expo.out' => 'Expo Out',
		'expo.inOut' => 'Expo In Out',
		'sine.in' => 'Sine In',
		'sine.out' => 'Sine Out',
		'sine.inOut' => 'Sine In Out',
	];

	$widget->add_control(
		'lqd_inview_hr',
		[
			'type' => Controls_Manager::DIVIDER,
		]
	);

	$widget->add_control(
		'lqd_inview',
		[
			'label' => __( 'Inview animations', 'aihub-core' ),
			'type' => Controls_Manager::SWITCHER,
			'condition' => [
				'lqd_parallax' => ''
			]
		]
	);

	$widget->add_control(
		'lqd_inview_control_apply',
		[
			'label' => __( 'Play animations', 'aihub-core' ),
			'type' => Controls_Manager::BUTTON,
			'button_type' => 'success',
			'text' => __( 'Play', 'aihub-core' ),
			'condition' => [
				'lqd_inview' => 'yes',
			],
			'event' => 'liquid:inview:play',
			// 'render_type' => 'none',
		]
	);

	$widget->add_control(
		'lqd_inview_settings_popover',
		[
			'label' => __( 'General Settings', 'aihub-core' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => __( 'Default', 'aihub-core' ),
			'label_on' => __( 'Custom', 'aihub-core' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => [
				'lqd_inview' => 'yes'
			],
			// 'render_type' => 'none',
		]
	);

	// Animation Settings
	$widget->start_popover();
		$widget->add_control(
			'lqd_inview_enable_css',
			[
				'label' => __( 'Enable CSS Initize?', 'aihub-core' ),
				'description' => __( 'The first keyframe will be initialized by CSS.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_preset_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$widget->add_control(
			'lqd_inview_preset',
			[
				'label' => __( 'Animation Presets', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'  => __( 'Custom', 'aihub-core' ),
					'Fade In'  => __( 'Fade In', 'aihub-core' ),
					'Fade In Down'  => __( 'Fade In Down', 'aihub-core' ),
					'Fade In Up'  => __( 'Fade In Up', 'aihub-core' ),
					'Fade In Left'  => __( 'Fade In Left', 'aihub-core' ),
					'Fade In Right'  => __( 'Fade In Right', 'aihub-core' ),
					'Flip In Y'  => __( 'Flip In Y', 'aihub-core' ),
					'Flip In X'  => __( 'Flip In X', 'aihub-core' ),
					'Scale Up'  => __( 'Scale Up', 'aihub-core' ),
					'Scale Down'  => __( 'Scale Down', 'aihub-core' ),
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_trigger',
			[
				'label' => __( 'Trigger', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ghost',
				'options' => [
					'ghost'  => __( 'Element itself', 'aihub-core' ),
					'closestParentContainer'  => __( 'Closest container', 'aihub-core' ),
					'topParentContainer'  => __( 'Last container', 'aihub-core' ),
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_ease',
			[
				'label' => __( 'Easing', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'expo.out',
				'options' => $ease_list,
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_direction',
			[
				'label' => __( 'Direction', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'start',
				'options' => [
					'start' => __( 'Start', 'aihub-core' ),
					'center' => __( 'Center', 'aihub-core' ),
					'end' => __( 'End', 'aihub-core' ),
					'edges' => __( 'Edges', 'aihub-core' ),
					'random' => __( 'Random', 'aihub-core' ),
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_duration',
			[
				'label' => __( 'Duration', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.65,
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_stagger',
			[
				'label' => __( 'Stagger', 'aihub-core' ),
				'description' => __( 'Delay between animated elements.', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.005,
					],
				],
				'default' => [
					'size' => .065,
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_start_delay',
			[
				'label' => __( 'Start Delay', 'aihub-core' ),
				'description' => __( 'Start delay of the animation.', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_animation_repeat_enable_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$widget->add_control(
			'lqd_inview_settings_animation_repeat_enable',
			[
				'label' => esc_html__( 'Repeat Animation?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
				],
				'separator' => 'before',
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_animation_repeat',
			[
				'label' => __( 'Repeat count', 'aihub-core' ),
				'description' => __( 'Count of the animation repeat. Set -1 for infinite repeeat.', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -1,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'size' => -1,
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_animation_repeat_enable' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_animation_repeat_delay',
			[
				'label' => __( 'Repeat Delay', 'aihub-core' ),
				'description' => __( 'Repeat delay of the animation.', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_animation_repeat_enable' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_animation_yoyo',
			[
				'label' => esc_html__( 'Yoyo?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_animation_repeat_enable' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_animation_yoyo_ease',
			[
				'label' => esc_html__( 'Yoyo Ease?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_animation_repeat_enable' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_start_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$widget->add_control(
			'lqd_inview_settings_start',
			[
				'label' => __( 'Start', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top+=30px bottom',
				'options' => [
					'top+=30px bottom'  => __( 'On Enter', 'aihub-core' ),
					'top top' => __( 'On Leave', 'aihub-core' ),
					'center center' => __( 'On Center', 'aihub-core' ),
					'percentage' => __( 'Percentage', 'aihub-core' ),
					'custom' => __( 'Custom', 'aihub-core' ),
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_start_percentage',
			[
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_start' => 'percentage'
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_start_custom',
			[
				'label' => __( 'Custom trigger', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '50% 50%', 'aihub-core' ),
				'description' => __( 'You can use numbers like this 50% 50% which means when center of the element hits center of the viewport.', 'aihub-core' ),
				'condition' => array(
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_start' => 'custom',
				),
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_startElementOffset',
			[
				'label' => __( 'Start Element Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_start!' => [ 'percentage', 'custom' ]
				],
				// 'render_type' => 'none',
			]
		);

		$widget->add_control(
			'lqd_inview_settings_startViewportOffset',
			[
				'label' => __( 'Start Viewport Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'condition' => [
					'lqd_inview_settings_popover' => 'yes',
					'lqd_inview_settings_start!' => [ 'percentage', 'custom' ]
				],
				// 'render_type' => 'none',
			]
		);

	$widget->end_popover(); // Settings


	$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'options',
			[
				'label' => esc_html__( 'Enable Inner Ease, Delay & Duration?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'ease',
			[
				'label' => __( 'Easing', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'expo.out',
				'options' => $ease_list,
				'condition' => [
					'options' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'duration',
			[
				'label' => __( 'Duration', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.65,
				],
				'condition' => [
					'options' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'delay',
			[
				'label' => __( 'Start Delay', 'aihub-core' ),
				'description' => __( 'Start delay of the animation.', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'options' => 'yes'
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'x_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$repeater->add_control(
			'x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 0,
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 0,
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'z',
			[
				'label' => __( 'Translate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'scaleX',
			[
				'label' => __( 'Scale X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'scaleY',
			[
				'label' => __( 'Scale Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'separator' => 'after',
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'skewX',
			[
				'label' => __( 'Skew X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'skewY',
			[
				'label' => __( 'Skew Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'rotateX',
			[
				'label' => __( 'Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'rotateY',
			[
				'label' => __( 'Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'rotateZ',
			[
				'label' => __( 'Rotate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'opacity',
			[
				'label' => __( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'transformOriginX',
			[
				'label' => __( 'Transform origin X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'separator' => 'before',
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'transformOriginY',
			[
				'label' => __( 'Transform origin Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				// 'render_type' => 'none',
			]
		);

		$repeater->add_control(
			'transformOriginZ',
			[
				'label' => __( 'Transform origin Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				// 'render_type' => 'none',
			]
		);

		$widget->start_controls_tabs(
			'lqd_inview_devices',
		);

		$lqd_inview_devices = [
			'all' => [
				'title' => esc_html__( 'All', 'aihub-core' ),
				'icon' => '<i class="eicon-animation"></i>',
			],
		];

		$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

		if ( $active_breakpoints ) {

			foreach( array_reverse($active_breakpoints) as $key => $breakpoint ){
				$icon_attrs = 'class="eicon-device-' . str_replace( [ 'widescreen', '_extra' ], [ 'desktop', '' ], $key )  . '"';

				if ( strpos( $key, '_extra' ) ) {
					$icon_attrs .= ' style="transform:rotate(90deg);"';
				}

				$lqd_inview_devices[$key] = [
					'title' => esc_html__( $breakpoint->get_label(), 'aihub-core' ),
					'icon' => '<i ' . $icon_attrs . '></i>',
				];
			}

		}

		foreach( $lqd_inview_devices as $key => $device ){

			$widget->start_controls_tab(
				'lqd_inview_devices_' . $key,
				[
					'label' => $device['icon'],
					'condition' => [
						'lqd_inview_preset' => 'custom',
						'lqd_inview' => 'yes',
					]
				]
			);

			$widget->add_control(
				'lqd_inview_devices_popover_' . $key,
				[
					'label' => __( 'Settings for ' . $device['title'], 'aihub-core' ),
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label_off' => __( 'Default', 'aihub-core' ),
					'label_on' => __( 'Custom', 'aihub-core' ),
					'return_value' => 'yes',
					'default' => '',
					'condition' => [
						'lqd_inview' => 'yes'
					],
					// 'render_type' => 'none',
				]
			);

				// Device Settings
				$widget->start_popover();

					$widget->add_control(
						'lqd_inview_settings_' . $key . '_ease',
						[
							'label' => __( 'Easing', 'aihub-core' ),
							'type' => Controls_Manager::SELECT,
							'default' => 'expo.out',
							'options' => $ease_list,
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes'
							],
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_' . $key . '_duration',
						[
							'label' => __( 'Duration', 'aihub-core' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 10,
									'step' => 0.05,
								],
							],
							'default' => [
								'size' => 0.65,
							],
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes'
							],
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_' . $key . '_stagger',
						[
							'label' => __( 'Stagger', 'aihub-core' ),
							'description' => __( 'Delay between animated elements.', 'aihub-core' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 10,
									'step' => 0.05,
								],
							],
							'default' => [
								'size' => .065,
							],
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes'
							],
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_' . $key . '_start_delay',
						[
							'label' => __( 'Start Delay', 'aihub-core' ),
							'description' => __( 'Start delay of the animation.', 'aihub-core' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => -0,
									'max' => 10,
									'step' => 0.1,
								],
							],
							'default' => [
								'size' => 0,
							],
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes'
							],
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_'. $key . '_animation_repeat_enable_hr',
						[
							'type' => Controls_Manager::DIVIDER,
						]
					);

					$widget->add_control(
						'lqd_inview_settings_'. $key . '_animation_repeat_enable',
						[
							'label' => esc_html__( 'Repeat Animation?', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes',
							],
							'separator' => 'before',
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_'. $key . '_animation_repeat',
						[
							'label' => __( 'Repeat count', 'aihub-core' ),
							'description' => __( 'Count of the animation repeat. Set -1 for infinite repeeat.', 'aihub-core' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => -1,
									'max' => 10,
									'step' => 1,
								],
							],
							'default' => [
								'size' => -1,
							],
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes',
								'lqd_inview_settings_' . $key . '_animation_repeat_enable' => 'yes'
							],
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_'. $key . '_animation_repeat_delay',
						[
							'label' => __( 'Repeat Delay', 'aihub-core' ),
							'description' => __( 'Repeat delay of the animation.', 'aihub-core' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 10,
									'step' => 0.1,
								],
							],
							'default' => [
								'size' => 0,
							],
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes',
								'lqd_inview_settings_' . $key . '_animation_repeat_enable' => 'yes'
							],
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_'. $key . '_animation_yoyo',
						[
							'label' => esc_html__( 'Yoyo?', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes',
								'lqd_inview_settings_' . $key . '_animation_repeat_enable' => 'yes'
							],
							// 'render_type' => 'none',
						]
					);

					$widget->add_control(
						'lqd_inview_settings_'. $key . '_animation_yoyo_ease',
						[
							'label' => esc_html__( 'Yoyo Ease?', 'aihub-core' ),
							'type' => Controls_Manager::SWITCHER,
							'condition' => [
								'lqd_inview_devices_popover_' . $key => 'yes',
								'lqd_inview_settings_' . $key . '_animation_repeat_enable' => 'yes'
							],
							// 'render_type' => 'none',
						]
					);



				$widget->end_popover();

			// Keyframes
			$widget->add_control(
				'lqd_inview_keyframes_' . $key,
				[
					'label' => esc_html__( 'Keyframes for ' . $device['title'], 'aihub-core' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' =>  $key === 'all' ? [[], []] : [],
					'prevent_empty' => false,
					'condition' => [
						'lqd_inview_preset' => 'custom',
						'lqd_inview' => 'yes',
					],
					'title_field' => 'X: {{{x.size}}}{{{x.unit}}} Y: {{{y.size}}}{{{y.unit}}} Z: {{{z.size}}}{{{z.unit}}} Scale X: {{{scaleX.size}}} Scale Y: {{{scaleY.size}}} Skew X: {{{skewX.size}}} Skew Y: {{{skewY.size}}} Rotation X: {{{rotateX.size}}} Rotation Y: {{{rotateY.size}}} Rotation Z: {{{rotateZ.size}}} opacity: {{{opacity.size}}} Transform Origin X: {{{transformOriginX.size}}} Transform Origin Y: {{{transformOriginY.size}}} Transform Origin Z: {{{transformOriginZ.size}}}',
				]
			);

			$widget->end_controls_tab();

		}

	$widget->end_controls_tabs();

}