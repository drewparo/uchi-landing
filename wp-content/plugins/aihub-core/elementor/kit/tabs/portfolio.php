<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Portfolio extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-portfolio-kit';
	}

	public function get_title() {
		return __( 'Portfolio', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_archives',
			[
				'label' => esc_html__('General Portfolio Archives', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_portfolio_archive_style',
			[
				'label' => esc_html__( 'Portfolio style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'style01',
				'options' => [
					'style01' => esc_html__( 'Style 1', 'aihub-core' ),
					'style02' => esc_html__( 'Style 2', 'aihub-core' ),
					'style03' => esc_html__( 'Style 3', 'aihub-core' ),
					'style04' => esc_html__( 'Style 4', 'aihub-core' ),
					'style05' => esc_html__( 'Style 5', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_portfolio_horizontal_alignment',
			[
				'label' => esc_html__( 'Horizontal alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'' => [
						'title' => esc_html__( 'Default', 'aihub-core' ),
						'icon' => 'fa fa-minus',
					],
					'pf-details-h-str' => [
						'title' => esc_html__( 'Left', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'pf-details-h-mid' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'pf-details-h-end' => [
						'title' => esc_html__( 'Right', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => '',
				'toggle' => false,
			]
		);

		$this->add_control(
			'liquid_portfolio_vertical_alignment',
			[
				'label' => esc_html__( 'Vertical alignment', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'' => [
						'title' => esc_html__( 'Default', 'aihub-core' ),
						'icon' => 'fa fa-minus',
					],
					'pf-details-v-str' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'pf-details-v-mid' => [
						'title' => esc_html__( 'Middle', 'aihub-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'pf-details-v-end' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => '',
				'toggle' => false,
			]
		);

		$this->add_control(
			'liquid_portfolio_grid_columns',
			[
				'label' => esc_html__( 'Columns', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '2',
				'options' => [
					'1' => esc_html__( '1 Column', 'aihub-core' ),
					'2' => esc_html__( '2 Columns', 'aihub-core' ),
					'3' => esc_html__( '3 Columns', 'aihub-core' ),
					'4' => esc_html__( '4 Columns', 'aihub-core' ),
					'6' => esc_html__( '6 Columns', 'aihub-core' ),
				],
				'condition' => [
					'liquid_portfolio_archive_style' => [
						'style02',
						'style06',
					]

				],
			]
		);

		$this->add_control(
			'liquid_portfolio_columns_gap',
			[
				'label' => esc_html__( 'Columns gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 35,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
			]
		);

		$this->add_control(
			'liquid_portfolio_bottom_gap',
			[
				'label' => esc_html__( 'Bottom gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
			]
		);

		$this->add_control(
			'liquid_portfolio_enable_parallax',
			[
				'label' => esc_html__( 'Enable parallax?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'true',
				'default' => '',
			]
		);

		$this->add_control(
			'liquid_portfolio_single_slug',
			[
				'label' => esc_html__( 'Portfolio slug', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'myslug', 'aihub-core' ),
				'description' => esc_html__( 'After saving your custom portfolio slug, flush the permalinks from "Wordpress Settings > Permalinks" for the changes to take effect.', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_portfolio_category_slug',
			[
				'label' => esc_html__( 'Portfolio category slug', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'myslug', 'aihub-core' ),
				'description' => esc_html__( 'After saving your custom portfolio slug, flush the permalinks from "Wordpress Settings > Permalinks" for the changes to take effect.', 'aihub-core' ),
			]
		);

		$this->end_controls_section();


		/* Disabled beacause no need to use this
		$this->start_controls_section(
			'section_' . $this->get_id() . '_single',
			[
				'label' => esc_html__('Portfolio Single', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_portfolio_single_style',
			[
				'label' => esc_html__( 'Portfolio style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'custom',
				'options' => [
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
					'default' => esc_html__( 'Basic', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_portfolio_single_width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'description' => esc_html__( 'Defines the width of the featured image on the portfolio listing page', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Default', 'aihub-core' ),
					'auto' => esc_html__( 'Auto - width determined by thumbnail width', 'aihub-core' ),
					'2' => esc_html__( '2 columns - 1/6', 'aihub-core' ),
					'3' => esc_html__( '3 columns - 1/4', 'aihub-core' ),
					'4' => esc_html__( '4 columns - 1/3', 'aihub-core' ),
					'5' => esc_html__( '5 columns - 5/12', 'aihub-core' ),
					'6' => esc_html__( '6 columns - 1/2', 'aihub-core' ),
					'7' => esc_html__( '7 columns - 7/12', 'aihub-core' ),
					'8' => esc_html__( '8 columns - 2/3', 'aihub-core' ),
					'9' => esc_html__( '9 columns - 3/4', 'aihub-core' ),
					'10' => esc_html__( '10 columns - 5/6', 'aihub-core' ),
					'11' => esc_html__( '11 columns - 11/12', 'aihub-core' ),
					'12' => esc_html__( '12 columns - 12/12', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_portfolio_single_portfolio_image_size',
			[
				'label' => esc_html__( 'Thumb dimension', 'aihub-core' ),
				'description' => esc_html__( 'Choose a dimension for your portfolio thumb', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '',
				'options' => [
					'liquid-portfolio' => esc_html__( 'Default - (370 x 300)', 'aihub-core' ),
					'liquid-portfolio-sq' => esc_html__( 'Square - (295 x 295)', 'aihub-core' ),
					'liquid-portfolio-big-sq' => esc_html__( 'Big Square - (600 x 600)', 'aihub-core' ),
					'liquid-portfolio-portrait' => esc_html__( 'Portrait - (350 x 500)', 'aihub-core' ),
					'liquid-portfolio-wide' => esc_html__( 'Wide - (600 x 295)', 'aihub-core' ),
					'liquid-packery-wide' => esc_html__( 'Packery Wide - (570 x 370)', 'aihub-core' ),
					'liquid-packery-portrait' => esc_html__( 'Packery Portrait - (270 x 370)', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_portfolio_single_social_box_enable',
			[
				'label' => esc_html__( 'Social sharing module', 'aihub-core' ),
				'description' => esc_html__( 'Switch on to display the social sharing module on single portfolio pages', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'true',
				'default' => '',
			]
		);

		$this->add_control(
			'liquid_portfolio_single_archive_link',
			[
				'label' => esc_html__( 'Portfolio archive link', 'aihub-core' ),
				'description' => esc_html__( 'Custom link to portfolio page on navigation to link to the default portfolio archive.', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
			]
		);

		$this->end_controls_section();
		*/

	}

}

new Liquid_Global_Portfolio( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-portfolio-kit', Liquid_Global_Portfolio::class );
	}
);
