<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Sidebar extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-sidebar-kit';
	}

	public function get_title() {
		return __( 'Sidebars', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-sidebar';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_add_sidebars',
			[
				'label' => esc_html__('Add sidebars', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'liquid_custom_sidebars',
			[
				'label' => esc_html__( 'Sidebars', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'liquid_sidebar_widgets_style',
			[
				'label' => esc_html__( 'Sidebar Style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sidebar-widgets-outline',
				'options' => [
					'sidebar-widgets-default'  => esc_html__( 'Default', 'aihub-core' ),
					'sidebar-widgets-outline'  => esc_html__( 'Outline', 'aihub-core' ),
				],
			]
		);

		$this->add_responsive_control(
			'liquid_sidebar_top_spacing',
			[
				'label' => esc_html__( 'Sidebar Top Spacing', 'aihub-core' ),
				'description' => esc_html__( 'Manages the spacing between sidebar and titlbar.', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}}.has-sidebar #lqd-contents-wrap' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Sidebar manager
		$this->start_controls_section(
			'section_' . $this->get_id() . '_manage',
			[
				'label' => esc_html__('Sidebar manager', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$repeater = new \Elementor\Repeater();


		$repeater->add_control(
			'enable',
			[
				'label' => esc_html__( 'Enable this rule', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Sidebar Rule', 'aihub-core' ),
				'placeholder' => esc_html__( 'Type your title here', 'aihub-core' ),
			]
		);

		$repeater->add_control(
			'archive',
			[
				'label' => esc_html__( 'Select archive', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => [
					'page'  => esc_html__( 'Page', 'aihub-core' ),
					'blog-posts'  => esc_html__( 'Blog Posts', 'aihub-core' ),
					'blog-archive'  => esc_html__( 'Blog Archive', 'aihub-core' ),
					'portfolio-posts' => esc_html__( 'Portfolio Posts', 'aihub-core' ),
					'portfolio-archive' => esc_html__( 'Portfolio Archive', 'aihub-core' ),
					'search-page' => esc_html__( 'Portfolio Posts', 'aihub-core' ),
					'product-single' => esc_html__( 'Product', 'aihub-core' ),
					'product-archive' => esc_html__( 'Product Archive', 'aihub-core' ),
				],
			]
		);

		$repeater->add_control(
			'enable_shop',
			[
				'label' => esc_html__( 'Enable also for shop page', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'enable_shop',
				'condition' => [
					'archive' => 'product-archive',
				],
			]
		);

		$repeater->add_control(
			'hide_on_mobile',
			[
				'label' => esc_html__( 'Hide on mobile', 'aihub-core' ),
				'description' => esc_html__( 'Hide sidebar on mobile devices.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
			]
		);

		$repeater->add_control(
			'sidebar',
			[
				'label' => __( 'Select sidebar', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => liquid_helper()->get_sidebars( array('main' => esc_html__( 'Main Sidebar', 'aihub-core' ) ) ),
				'default' => 'main',
				'save_default' => true,
			]
		);

		$repeater->add_control(
			'position',
			[
				'label' => esc_html__( 'Position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
				'toggle' => false,
			]
		);

		$this->add_control(
			'liquid_sidebar_manager',
			[
				'label' => esc_html__( 'Rules', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_Sidebar( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-sidebar-kit', Liquid_Global_Sidebar::class );
	}
);
