<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class LQD_Site_Logo extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'lqd_site_logo';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Site Logo', 'aihub-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-site-logo lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'liquid-core' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'header', 'logo', 'image' ];
	}

	public function get_behavior() {
		$settings = $this->get_settings_for_display();
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

	public function get_behavior_pageContent() {
		$settings = $this->get_settings_for_display();
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

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// General Section
		$this->start_controls_section(
			'general_section',
			array(
				'label' => __( 'Logo', 'aihub-core' ),
			)
		);

		$this->add_control(
			'logo_redirect_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'Go to the <strong><u>Elementor Site Settings > Site Identity</u></strong> to add your logo.', 'aihub-core' ) ),
				'separator' => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'uselogo',
			[
				'label' => __( 'Use logo from site settings?', 'aihub-core' ),
				'description' => __( 'Use logo set in elementor site settings panel', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'dark_image',
			[
				'label' => __( 'Dark image', 'aihub-core' ),
				'description' => __( 'Dark image is used on dark sections or when page color scheme is set to dark.', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'linkhome',
			[
				'label' => __( 'Link to homepage?', 'aihub-core' ),
				'description' => __( 'Link the logo to homepage', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'aihub-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => array(
					'linkhome' => ''
				)
			]
		);

		$this->add_control(
			'usestickylogo',
			[
				'label' => __( 'Use sticky logo from site settings?', 'aihub-core' ),
				'description' => __( 'Use sticky logo set in site settings panel', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sticky_image',
			[
				'label' => __( 'Sticky image', 'aihub-core' ),
				'description' => __( 'Add image from gallery or upload new', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'usestickylogo' => ''
				)
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'logo_effects',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'lqd_adaptive_color',
			[
				'label' => esc_html__( 'Enable adaptive color?', 'aihub-core' ),
				'description' => esc_html__( 'Useful for elements with fixed css position or when inside sticky header. This option make the element chage color dynamically when it is over light or dark sections.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		?>

		<?php $this->get_logo(); ?>

		<?php
	}

	protected function get_logo() {

		$image = $this->get_image();
		$sticky_image = $this->get_sticky_image();
		$dark_image = $this->get_dark_image();

		if( empty( $image ) ) {
			return;
		}

		$href = esc_url( home_url( '/' ) );

		if( isset( $this->get_settings_for_display('link')['url'] ) && !$settings['linkhome'] ) {
			$href = $this->get_settings_for_display('link')['url'];
		}

		printf( '<a class="lqd-logo flex p-0 relative" href="%s" rel="home">%s %s %s</a>', $href, $dark_image, $sticky_image, $image ) ;

	}

	protected function get_image() {

		$src = get_template_directory_uri() . '/assets/img/logo/logo.svg';
		$classname = 'lqd-logo-default';

		$logo = $this->get_settings_for_display( 'image' );
		$dark_logo = $this->get_settings_for_display('dark_image');

		if( $this->get_settings_for_display( 'uselogo' ) ) {
			$img_array    = liquid_helper()->get_kit_frontend_option( 'header_logo' );
			$dark_logo = liquid_helper()->get_kit_frontend_option( 'header_dark_logo' );

			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
		} else {
			$src = $logo['url'];
		}

		if( $this->get_settings_for_display( 'usestickylogo' ) ) {
			$sticky_logo = liquid_helper()->get_kit_frontend_option( 'header_sticky_logo' );
		} else {
			$sticky_logo = $this->get_settings_for_display('sticky_image');
		}

		if ( $dark_logo && !empty( $dark_logo['url'] ) ) {
			$classname .= ' lqd-dark:hidden';
		}
		if ( $sticky_logo && !empty( $sticky_logo['url'] ) ) {
			$classname .= ' lqd-sticky:hidden';
		}

		$image = sprintf(
			'<img class="%s" src="%s" alt="%s" />',
			esc_attr( $classname ),
			$src,
			$alt = get_bloginfo( 'title' )
		);

		return $image;

	}

	protected function get_sticky_image() {

		$src = $image = '';
		$classname = 'lqd-logo-sticky';

		$default_logo = $this->get_settings_for_display( 'image' );
		$logo = $this->get_settings_for_display( 'sticky_image' );

		if( $this->get_settings_for_display( 'usestickylogo' ) ) {
			$default_logo    = liquid_helper()->get_kit_frontend_option( 'header_logo' );
			$img_array    = liquid_helper()->get_kit_frontend_option( 'header_sticky_logo' );

			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
		}
		else {
			$src = $logo['url'];
		}

		if ( $default_logo && !empty( $default_logo['url'] ) ) {
			$classname .= ' hidden lqd-sticky:block';
		}

		if( !empty( $src ) ) {
			$image = sprintf(
				'<img class="%s" src="%s" alt="%s"/>',
				esc_attr( $classname ),
				$src,
				get_bloginfo( 'title' )
			 );
		}

		return $image;

	}

	protected function get_dark_image() {

		$src = $image = '';

		$logo = $this->get_settings_for_display( 'dark_image' );

		if( $this->get_settings_for_display( 'uselogo' ) ) {
			$img_array = liquid_helper()->get_kit_frontend_option( 'header_dark_logo' );

			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
		}
		else {
			$src = $logo['url'];
		}

		if( !empty( $src ) ) {
			$image = sprintf(
				'<img class="lqd-logo-dark hidden lqd-dark:block" src="%s" alt="%s" />',
				$src,
				get_bloginfo( 'title' )
			);
		}

		return $image;

	}


}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Site_Logo() );