<?php

use Elementor\Core\Base\Module;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Element_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Settings\Manager;

defined( 'ABSPATH' ) || exit;

class LD_Global_Controls extends Module {

	public function __construct() {
		add_action( 'elementor/element/kit/section_settings-site-identity/after_section_end', array( $this, 'tweak_siteidentity_section' ), 999, 2 );
		add_action( 'elementor/element/kit/section_global_colors/after_section_end', array( $this, 'tweak_globalcolors_section' ), 999, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_header_options' ), 250, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_post_options' ), 250, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_portfolio_options' ), 250, 2 );
		// add_action( 'elementor/element/after_section_end', array( $this, 'register_sizeguide_options' ), 250, 2 );
		// add_action( 'elementor/element/after_section_end', array( $this, 'register_sticky_atc_options' ), 250, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_archives_options' ), 250, 2 );

		// Custom CSS
		add_action( 'elementor/element/kit/section_custom_css_pro/after_section_end', array( $this, 'register_custom_css_section' ), 20, 2 );
		add_action( 'elementor/css-file/post/parse', [ $this, 'lqd_add_custom_css' ] );

	}

	public function get_the_selectors(){
		if ( version_compare( ELEMENTOR_VERSION, '3.6', '<' ) ) { // compare versions
			$selector = '> .elementor-section-wrap > .elementor-section';
		} else {
			$selector = '> .elementor-section';
		}

		return $selector;
	}

	public function get_name() {
		return 'hub-global-controls';
	}

	public function register_header_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$section_name = 'lqd_header_options_hide';

		if ( get_post_type() === 'liquid-header' ){
			$section_name = 'lqd_header_options';
		}

		// Header Design Options
		$element->start_controls_section(
			$section_name,
			array(
				'label' => __( 'Header design options', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			)
		);

		// $element->add_control(
		// 	'header_apply',
		// 	[
		// 		'label' => __( 'Apply changes', 'aihub-core' ),
		// 		'description' => __( 'This option allows you to see the changes without refreshing the page.', 'aihub-core' ),
		// 		'type' => Controls_Manager::BUTTON,
		// 		'separator' => 'after',
		// 		'button_type' => 'success liquid-page-refresh',
		// 		'event' => 'liquid:page:refresh',
		// 		'text' => __( 'Apply', 'aihub-core' ),
		// 	]
		// );

		$element->add_control(
			'header_overlay',
			[
				'label' => __( 'Overlay?', 'aihub-core' ),
				'description' => __( 'Placing the header on top of the content.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$element->add_control(
			'header_sticky',
			[
				'label' => __( 'Enable sticky header?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$element->add_responsive_control(
			'header_sticky_offset',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'header_sticky' => 'yes'
				]
			]
		);

		$element->end_controls_section();

	}

	public function register_post_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$post_type = get_post_type( get_the_ID() );

		// Page, Header and Footer Options
		if ( $post_type === 'post' || $post_type === 'page' || $post_type === 'liquid-portfolio' ) {

			// Page Options
			// $element->start_controls_section(
			// 	'lqd_post_options',
			// 	[
			// 		'label' => __( 'Page options', 'aihub-core' ),
			// 		'tab'   => Controls_Manager::TAB_SETTINGS,
			// 	]
			// );

			// $element->add_control(
			// 	'lqd_post_options_apply',
			// 	[
			// 		'label' => __( 'Apply changes', 'aihub-core' ),
			// 		'description' => __( 'This option allows you to see the changes without refreshing the page.', 'aihub-core' ),
			// 		'type' => Controls_Manager::BUTTON,
			// 		'separator' => 'after',
			// 		'button_type' => 'success liquid-page-refresh',
			// 		'event' => 'liquid:page:refresh',
			// 		'text' => __( 'Apply', 'aihub-core' ),
			// 	]
			// );

			// $element->add_control(
			// 	'page_enable_liquid_bg',
			// 	[
			// 		'label' => __( 'Adaptive background color', 'aihub-core' ),
			// 		'type' => Controls_Manager::SWITCHER,
			// 		'return_value' => 'on',
			// 		'separator' => 'before',
			// 	]
			// );

			// $element->end_controls_section();

		}

		// Sidebar Options
		if ( $post_type === 'post' || $post_type === 'page' ){
			// Sidebar Options
			$element->start_controls_section(
				'lqd_post_sidebar_options',
				[
					'label' => __( 'Page sidebar options', 'aihub-core' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$element->add_control(
				'lqd_post_sidebar_options_apply',
				[
					'label' => __( 'Apply changes', 'aihub-core' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'aihub-core' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'liquid:page:refresh',
					'text' => __( 'Apply', 'aihub-core' ),
				]
			);

			$element->add_control(
				'liquid_sidebar_one',
				[
					'label' => __( 'Select sidebar', 'aihub-core' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'options' => liquid_helper()->get_sidebars( array( 'none' => esc_html__( 'No Sidebar', 'aihub-core' ), 'main' => esc_html__( 'Main Sidebar', 'aihub-core' ) ) ),
					'save_default' => true,
					'separator' => 'after',
					'description'  => __( 'Select sidebar that will display on this page. Choose "No Sidebar" for full width.', 'aihub-core' ),
				]
			);

			$element->add_control(
				'liquid_sidebar_position',
				[
					'label' => __( 'Sidebar position', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'aihub-core' ),
							'icon' => 'eicon-h-align-left',
						],
						'0' => [
							'title' => __( 'Use Global Settings', 'aihub-core' ),
							'icon' => 'fa fa-adjust',
						],
						'right' => [
							'title' => __( 'Right', 'aihub-core' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'default' => '0',
					'toggle' => false,
					'condition' => [
						'liquid_sidebar_one!' => [ '', 'none' ],
					],
				]
			);

			$element->add_control(
				'sidebar_widgets_style',
				[
					'label' => __( 'Sidebar style', 'aihub-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __( 'Use Global Settings', 'aihub-core' ),
						'sidebar-widgets-default' => __( 'Default', 'aihub-core' ),
						'sidebar-widgets-outline' => __( 'Outline', 'aihub-core' ),
					],
					'condition' => [
						'liquid_sidebar_one!' => [ '', 'none' ],
					],
				]
			);
			$element->end_controls_section();
		}

		if ( $post_type === 'post' ){

			$element->start_controls_section(
				'lqd_singlepost_options',
				[
					'label' => __( 'Post options', 'aihub-core' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$element->add_control(
				'lqd_post_singlepost_options_apply',
				[
					'label' => __( 'Apply changes', 'aihub-core' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'aihub-core' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'liquid:page:refresh',
					'text' => __( 'Apply', 'aihub-core' ),
				]
			);

			$element->add_control(
				'post_style',
				[
					'label' => __( 'Single post style', 'aihub-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'aihub-core' ),
						'modern-full-screen'  => __( 'Modern Full Screen', 'aihub-core' ),
						'wide'  => __( 'Wide', 'aihub-core' ),
						'dark'  => __( 'Wide title overlay', 'aihub-core' ),

					],
				]
			);

			$element->add_control(
				'post_extra_text',
				[
					'label' => __( 'Extra text', 'aihub-core' ),
					'description' => __( 'Text will display near meta section', 'aihub-core' ),
					'type' => Controls_Manager::TEXT,
					'separator' => 'before',
					'condition' => [
						'post_style' => [ 'default', 'cover-spaced', 'modern' ],
						'lqd_disabled' => 'no',
					],
				]
			);

			$element->add_control(
				'liquid_post_cover_style_image',
				[
					'label' => __( 'Cover image', 'aihub-core' ),
					'description' => __( 'Will override the featured image in single post', 'aihub-core' ),
					'type' => Controls_Manager::MEDIA,
					'separator' => 'before',
				]
			);

			$element->add_control(
				'post_parallax_enable',
				[
					'label' => __( 'Enable parallax', 'aihub-core' ),
					'description' => __( 'Turn on parallax effect on post featured image', 'aihub-core' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'aihub-core' ),
						'on'  => __( 'On', 'aihub-core' ),
						'off'  => __( 'Off', 'aihub-core' ),
					],
					'condition' => [
						'post_style' => [ 'modern', 'modern-full-screen', 'dark' ],
					],
				]
			);

			$element->add_control(
				'post_social_box_enable',
				[
					'label' => __( 'Social sharing box', 'aihub-core' ),
					'description' => __( 'Turn on to display the social sharing box on single posts.', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'' => [
							'title' => esc_html__( 'Global', 'aihub-core' ),
							'icon' => 'eicon-global-settings',
						],
						'on' => [
							'title' => esc_html__( 'On', 'aihub-core' ),
							'icon' => 'eicon-check',
						],
						'off' => [
							'title' => esc_html__( 'Off', 'aihub-core' ),
							'icon' => 'eicon-close',
						],
					],
					'default' => '',
					'toggle' => false,
				]
			);

			$element->add_control(
				'post_author_meta_enable',
				[
					'label' => __( 'Author info meta', 'aihub-core' ),
					'description' => __( 'Turn on to display the author meta.', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'' => [
							'title' => esc_html__( 'Global', 'aihub-core' ),
							'icon' => 'eicon-global-settings',
						],
						'on' => [
							'title' => esc_html__( 'On', 'aihub-core' ),
							'icon' => 'eicon-check',
						],
						'off' => [
							'title' => esc_html__( 'Off', 'aihub-core' ),
							'icon' => 'eicon-close',
						],
					],
					'default' => '',
					'toggle' => false,
				]
			);

			$element->add_control(
				'post_author_box_enable',
				[
					'label' => __( 'Author info box', 'aihub-core' ),
					'description' => __( 'Turn on to display the author info box below posts', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'' => [
							'title' => esc_html__( 'Global', 'aihub-core' ),
							'icon' => 'eicon-global-settings',
						],
						'on' => [
							'title' => esc_html__( 'On', 'aihub-core' ),
							'icon' => 'eicon-check',
						],
						'off' => [
							'title' => esc_html__( 'Off', 'aihub-core' ),
							'icon' => 'eicon-close',
						],
					],
					'default' => '',
					'toggle' => false,
				]
			);

			$element->add_control(
				'post_author_role_enable',
				[
					'label' => __( 'Author role', 'aihub-core' ),
					'description' => __( 'Turn on to display the author role in info box below posts.', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'' => [
							'title' => esc_html__( 'Global', 'aihub-core' ),
							'icon' => 'eicon-global-settings',
						],
						'on' => [
							'title' => esc_html__( 'On', 'aihub-core' ),
							'icon' => 'eicon-check',
						],
						'off' => [
							'title' => esc_html__( 'Off', 'aihub-core' ),
							'icon' => 'eicon-close',
						],
					],
					'default' => '',
					'toggle' => false,
				]
			);

			$element->add_control(
				'post_navigation_enable',
				[
					'label' => __( 'Previous/next pagination', 'aihub-core' ),
					'description' => __( 'Turn on to display the previous/next post pagination for single posts.', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'' => [
							'title' => esc_html__( 'Global', 'aihub-core' ),
							'icon' => 'eicon-global-settings',
						],
						'on' => [
							'title' => esc_html__( 'On', 'aihub-core' ),
							'icon' => 'eicon-check',
						],
						'off' => [
							'title' => esc_html__( 'Off', 'aihub-core' ),
							'icon' => 'eicon-close',
						],
					],
					'default' => '',
					'toggle' => false,
				]
			);

			$element->add_control(
				'blog_archive_link',
				[
					'label' => __( 'Blog archive url', 'aihub-core' ),
					'description' => __( 'Custom link to post on navigation to link to the default blog archive', 'aihub-core' ),
					'type' => Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'aihub-core' ),
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => true,
						'nofollow' => true,
					],
					'condition' => [
						'post_navigation_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'post_related_enable',
				[
					'label' => __( 'Related posts', 'aihub-core' ),
					'description' => __( 'Turn on to display related posts/projects on single posts.', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'' => [
							'title' => esc_html__( 'Global', 'aihub-core' ),
							'icon' => 'eicon-global-settings',
						],
						'on' => [
							'title' => esc_html__( 'On', 'aihub-core' ),
							'icon' => 'eicon-check',
						],
						'off' => [
							'title' => esc_html__( 'Off', 'aihub-core' ),
							'icon' => 'eicon-close',
						],
					],
					'default' => '',
					'toggle' => false,
				]
			);

			$element->add_control(
				'post_related_style',
				[
					'label' => __( 'Related posts section style', 'aihub-core' ),
					'description' => __( 'Select desired style for the related posts section to display on single post', 'aihub-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'aihub-core' ),
						'style-1'  => __( 'Style 1', 'aihub-core' ),
						'style-2'  => __( 'Style 2', 'aihub-core' ),
						'style-3'  => __( 'Style 3', 'aihub-core' ),
					],
					'condition' => [
						'post_related_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'post_related_title',
				[
					'label' => __( 'Related posts section title', 'aihub-core' ),
					'type' => Controls_Manager::TEXT,
					'condition' => [
						'post_related_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'post_related_number',
				[
					'label' => __( 'Number of related projects', 'aihub-core' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 2,
					'max' => 5,
					'step' => 1,
					'default' => 2,
					'condition' => [
						'post_related_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'post_reading_time',
				[
					'label' => __( 'Post reading time', 'aihub-core' ),
					'description' => __( 'Will display the text about time needs to read the article', 'aihub-core' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'' => [
							'title' => esc_html__( 'Global', 'aihub-core' ),
							'icon' => 'eicon-global-settings',
						],
						'on' => [
							'title' => esc_html__( 'On', 'aihub-core' ),
							'icon' => 'eicon-check',
						],
						'off' => [
							'title' => esc_html__( 'Off', 'aihub-core' ),
							'icon' => 'eicon-close',
						],
					],
					'default' => '',
					'toggle' => false,
					'separator' => 'before',
					'condition' => [
						'post_author_meta_enable!' => 'off'
					]
				]
			);

			$element->add_control(
				'post_reading_time_label',
				[
					'label' => __( 'Label', 'aihub-core' ),
					'description' => __( 'Add label after the reading time', 'aihub-core' ),
					'default' => __( 'min read', 'aihub-core' ),
					'type' => Controls_Manager::TEXT,
					'condition' => [
						'post_reading_time' => 'on'
					]
				]
			);

			$element->end_controls_section();
		}

	}

	public function register_portfolio_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}

		if ( get_post_type() !== 'liquid-portfolio' ) {
			return;
		}

		$element->start_controls_section(
			'lqd_portfolio_options',
			[
				'label' => __( 'Portfolio general', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'lqd_portfolio_options_apply',
			[
				'label' => __( 'Apply changes', 'aihub-core' ),
				'description' => __( 'This option allows you to see the changes without refreshing the page.', 'aihub-core' ),
				'type' => Controls_Manager::BUTTON,
				'separator' => 'after',
				'button_type' => 'success liquid-page-refresh',
				'event' => 'liquid:page:refresh',
				'text' => __( 'Apply', 'aihub-core' ),
			]
		);

		$element->add_control(
			'portfolio_description',
			[
				'label' => __( 'Portfolio description', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
			]
		);

		$element->add_control(
			'portfolio_subtitle',
			[
				'label' => __( 'Subtitle', 'aihub-core' ),
				'description' => __( 'Manage the subtitle of portfolio listing', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$element->add_control(
			'portfolio_style',
			[
				'label' => __( 'Portfolio style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'separator' => 'before',
				'options' => [
					'custom' => __( 'Custom', 'aihub-core' ),
					'default' => __( 'Basic', 'aihub-core' ),
				],
			]
		);

		$element->add_control(
			'portfolio_width',
			[
				'label' => __( 'Width', 'aihub-core' ),
				'description' => __( 'Defines the width of the featured image on the portfolio listing page', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => [
					'' => __( 'Default', 'aihub-core' ),
					'auto' => __( 'Auto - width determined by thumbnail width', 'aihub-core' ),
					'2' => __( '2 columns - 1/6', 'aihub-core' ),
					'3' => __( '3 columns - 1/4', 'aihub-core' ),
					'4' => __( '4 columns - 1/3', 'aihub-core' ),
					'5' => __( '5 columns - 5/12', 'aihub-core' ),
					'6' => __( '6 columns - 1/2', 'aihub-core' ),
					'7' => __( '7 columns - 7/12', 'aihub-core' ),
					'8' => __( '8 columns - 2/3', 'aihub-core' ),
					'9' => __( '9 columns - 3/4', 'aihub-core' ),
					'10' => __( '10 columns - 5/6', 'aihub-core' ),
					'11' => __( '11 columns - 11/12', 'aihub-core' ),
					'12' => __( '12 columns - 12/12', 'aihub-core' ),
				],
			]
		);

		$element->add_control(
			'_portfolio_image_size',
			[
				'label' => __( 'Crop thumbnail image?', 'aihub-core' ),
				'description' => __( 'Choose a dimension for your portfolio thumb. 1. The images need to regenerated after this. 2. Image resolutions need to be greater than selected resolution.', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => [
					'' => __( 'Select a size', 'aihub-core' ),
					'liquid-portfolio' => __( 'Default - (760 x 520)', 'aihub-core' ),
					'liquid-portfolio-sq' => __( 'Square - (760 x 640)', 'aihub-core' ),
					'liquid-portfolio-big-sq' => __( 'Bigger Square - (1520 x 1280)', 'aihub-core' ),
					'liquid-portfolio-portrait' => __( 'Vertical - (700 x 1000)', 'aihub-core' ),
					'liquid-portfolio-wide' => __( 'Horizontal - (1200 x 590)', 'aihub-core' ),
					'liquid-packery-wide' => __( 'Packery Horizontal - (1140 x 740)', 'aihub-core' ),
					'liquid-packery-portrait' => __( 'Packery Vertical - (540 x 740)', 'aihub-core' ),
				],
			]
		);
		$element->end_controls_section();

		$element->start_controls_section(
			'lqd_portfolio_meta_options',
			[
				'label' => __( 'Portfolio meta', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'lqd_portfolio_meta_options_apply',
			[
				'label' => __( 'Apply changes', 'aihub-core' ),
				'description' => __( 'This option allows you to see the changes without refreshing the page.', 'aihub-core' ),
				'type' => Controls_Manager::BUTTON,
				'separator' => 'after',
				'button_type' => 'success liquid-page-refresh',
				'event' => 'liquid:page:refresh',
				'text' => __( 'Apply', 'aihub-core' ),
			]
		);

		$element->add_control(
			'portfolio_badge',
			[
				'label' => __( 'Badge', 'aihub-core' ),
				'description' => __( 'Will show badge for the style 6 of the portfolio listing', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$element->add_control(
			'portfolio_website',
			[
				'label' => __( 'External url', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'separator' => 'before',
				'placeholder' => __( 'https://your-link.com', 'aihub-core' ),
				'show_external' => false,
				'default' => [
					'url' => '',
				],
			]
		);

		$element->add_control(
			'portfolio_attributes',
			[
				'label' => __( 'Attributes', 'aihub-core' ),
				'description' => __( 'Add custom portfolio attributes. Divide by | label with value ( Label | Value ). Each row (Enter) is a new item', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'separator' => 'before',
				'default' =>  __( 'Client | Liquid Themes', 'aihub-core' ),
			]
		);

		$element->end_controls_section();

	}

	public function register_sizeguide_options ( Controls_Stack $element, $section_id ) {

		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$section_name = 'lqd_sizeguide_show_tax_hide';
		if ( get_post_type() === 'ld-product-sizeguide' ){
			$section_name = 'lqd_sizeguide_show_tax';
		}

		$element->start_controls_section(
			$section_name,
			[
				'label' => __( 'Size Guide Options', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'lqd_sizeguide_type',
			[
				'label' => esc_html__( 'Type', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'direct',
				'options' => [
					'direct' => esc_html__( 'Direct', 'aihub-core' ),
					'modal'  => esc_html__( 'Modal', 'aihub-core' ),
				],
			]
		);

		$element->add_control(
			'lqd_sizeguide_popover',
			[
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label' => esc_html__( 'Button Style', 'aihub-core' ),
				'label_off' => esc_html__( 'Default', 'aihub-core' ),
				'label_on' => esc_html__( 'Custom', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'.lqd-size-guide-button i' => 'margin-right: 0.5em',
				],
				'condition' => [
					'lqd_sizeguide_type' => 'modal'
				]
			]
		);

		$element->start_popover();

			$element->add_control(
				'lqd_sizeguide_btn_text',
				[
					'label' => esc_html__( 'Button Text', 'aihub-core' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Size Guide', 'aihub-core' ),
				]
			);

			$element->add_control(
				'lqd_sizeguide_btn_icon',
				[
					'label' => esc_html__( 'Icon', 'aihub-core' ),
					'type' => Controls_Manager::ICONS,
					'condition' => [
						'lqd_sizeguide_popover' => 'yes',
						'lqd_sizeguide_type' => 'modal'
					]
				]
			);

			$element->add_control(
				'lqd_sizeguide_btn_colors_heading',
				[
					'label' => esc_html__( 'Colors', 'aihub-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$element->add_control(
				'lqd_sizeguide_btn_color',
				[
					'label' => esc_html__( 'Text Color', 'aihub-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.lqd-size-guide-button' => 'color: {{VALUE}}',
					],
					'condition' => [
						'lqd_sizeguide_popover' => 'yes',
						'lqd_sizeguide_type' => 'modal'
					]
				]
			);

			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'lqd_sizeguide_btn_bg',
					'label' => esc_html__( 'Background', 'aihub-core' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '.lqd-size-guide-button',
					'condition' => [
						'lqd_sizeguide_popover' => 'yes',
						'lqd_sizeguide_type' => 'modal'
					]
				]
			);

			$element->add_control(
				'lqd_sizeguide_btn_colors_hover_heading',
				[
					'label' => esc_html__( 'Hover Colors', 'aihub-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$element->add_control(
				'lqd_sizeguide_btn_color_hover',
				[
					'label' => esc_html__( 'Text Color', 'aihub-core' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.lqd-size-guide-button:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'lqd_sizeguide_popover' => 'yes',
						'lqd_sizeguide_type' => 'modal'
					]
				]
			);

			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'lqd_sizeguide_btn_bg_hover',
					'label' => esc_html__( 'Background', 'aihub-core' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '.lqd-size-guide-button:hover',
					'condition' => [
						'lqd_sizeguide_popover' => 'yes',
						'lqd_sizeguide_type' => 'modal'
					]
				]
			);

			$element->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'lqd_sizeguide_btn_typography',
					'selector' => '.lqd-size-guide-button',
					'condition' => [
						'lqd_sizeguide_popover' => 'yes',
						'lqd_sizeguide_type' => 'modal'
					]
				]
			);


		$element->end_popover();

		$element->add_control(
			'lqd_sizeguide_show_by',
			[
				'label' => esc_html__( 'Show by', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'  => esc_html__( 'All products', 'aihub-core' ),
					'cats'  => esc_html__( 'Category', 'aihub-core' ),
					'products' => esc_html__( 'Product', 'aihub-core' ),
				],
			]
		);

		$element->add_control(
			'lqd_sizeguide_cats',
			[
				'label' => esc_html__( 'Select Categories', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => liquid_helper()->get_available_custom_taxonomies( 'product_cat' ),
				'condition' => [
					'lqd_sizeguide_show_by' => 'cats'
				]
			]
		);

		$element->add_control(
			'lqd_sizeguide_products',
			[
				'label' => esc_html__( 'Select Products', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => liquid_helper()->get_available_custom_post( 'product' ),
				'condition' => [
					'lqd_sizeguide_show_by' => 'products'
				]
			]
		);

		$element->end_controls_section();

	}

	public function register_sticky_atc_options ( Controls_Stack $element, $section_id ) {

		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$section_name = 'lqd_sticky_atc_hide';
		if ( get_post_type() === 'liquid-sticky-atc' ){
			$section_name = 'lqd_sticky_atc_show_tax';
		}

		$element->start_controls_section(
			$section_name,
			[
				'label' => __( 'Sticky Add to Cart Options', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'lqd_sticky_atc_show_by',
			[
				'label' => esc_html__( 'Show by', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'  => esc_html__( 'All products', 'aihub-core' ),
					'cats'  => esc_html__( 'Category', 'aihub-core' ),
					'products' => esc_html__( 'Product', 'aihub-core' ),
				],
			]
		);

		$element->add_control(
			'lqd_sticky_atc_cats',
			[
				'label' => esc_html__( 'Select Categories', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => liquid_helper()->get_available_custom_taxonomies( 'product_cat' ),
				'condition' => [
					'lqd_sticky_atc_show_by' => 'cats'
				]
			]
		);

		$element->add_control(
			'lqd_sticky_atc_products',
			[
				'label' => esc_html__( 'Select Products', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => liquid_helper()->get_available_custom_post( 'product' ),
				'condition' => [
					'lqd_sticky_atc_show_by' => 'products'
				]
			]
		);

		$element->end_controls_section();

	}

	public function register_archives_options ( Controls_Stack $element, $section_id ) {

		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$section_name = 'lqd_archives_hide';
		if ( get_post_type() === 'liquid-archives' ){
			$section_name = 'lqd_archives';
		}

		$element->start_controls_section(
			$section_name,
			[
				'label' => __( 'Layout Condition', 'aihub-core' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$cpts = apply_filters( 'liquid_condition_cpt', array( 'post', 'liquid-portfolio' ) );

		$archive_items = [
			'blog-archive'  => esc_html__( 'Blog Archive', 'aihub-core' ),
			'author-archive' => esc_html__( 'Author Archive', 'aihub-core' ),
			'category-archive' => esc_html__( 'Category Archive', 'aihub-core' ),
			'tag-archive' => esc_html__( 'Tag Archive', 'aihub-core' ),
			'date-archive' => esc_html__( 'Date Archive', 'aihub-core' ),
			'blog-search' => esc_html__( 'Search Page Results', 'aihub-core' ),
			'taxonomy-archive' => esc_html__( 'Taxonomy Archive', 'aihub-core' ),
		];

		foreach ( $cpts as $cpt ) {
			if ( $cpt == 'post' ){ continue; }
            $archive_items[$cpt] = get_post_type_object( $cpt )->labels->archives;
        }

		$element->add_control(
			'lqd_archives_rule',
			[
				'label' => esc_html__( 'Rule', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => $archive_items,
			]
		);

		$element->end_controls_section();

	}

	public function tweak_siteidentity_section( $element ) {
		$element->start_injection(
			array(
				'of' => 'site_logo',
				'at' => 'before',
			)
		);

		$element->add_control(
			'header_logo',
			[
				'label' => __( 'Default logo', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_sticky_logo',
			[
				'label' => __( 'Sticky header logo', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_dark_logo',
			[
				'label' => __( 'Dark logo', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'favicon',
			[
				'label' => __( 'Favicon', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'iphone_icon',
			[
				'label' => __( 'Apple iphone icon', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'ipad_icon',
			[
				'label' => __( 'Apple ipad icon', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->end_injection();
	}

	public function tweak_globalcolors_section( $element ) {
		$element->start_injection(
			array(
				'of' => 'custom_colors',
				'at' => 'after',
			)
		);

		$element->add_control(
			'lqd_init_color_scheme',
			[
				'label' => esc_html__( 'Initial page color scheme', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'system' => esc_html__( 'User system prefrence', 'aihub-core' ),
					'light' => esc_html__( 'Light', 'aihub-core' ),
					'dark' => esc_html__( 'Dark', 'aihub-core' ),
				],
			]
		);

		$element->end_injection();
	}

	public function register_custom_css_section( Controls_Stack $element, $section_id ) {

		$element->start_controls_section(
			'lqd_custom_css_section',
			[
				'label' => __( 'Liquid Custom Css', 'aihub-core' ),
				'tab' => 'settings-custom-css',
			]
		);

		$element->add_control(
			'lqd_custom_css',
			[
				'type' => Controls_Manager::CODE,
				'language' => 'css'
			]
		);

		$element->end_controls_section();
	}

	public function lqd_add_custom_css( $post_css ) {

		$custom_css = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display('lqd_custom_css');

		$custom_css = trim( $custom_css );

		if ( empty( $custom_css ) ) {
			return;
		}

		// Add a css comment
		$custom_css = '/* Start Liquid custom CSS */' . $custom_css . '/* End Liquid custom CSS */';

		$post_css->get_stylesheet()->add_raw_css( $custom_css );
	}

}

new LD_Global_Controls();
