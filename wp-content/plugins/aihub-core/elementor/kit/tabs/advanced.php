<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Advanced extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-advanced-kit';
	}

	public function get_title() {
		return __( 'Scripts & Tracking Code', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_custom_scripts',
			[
				'label' => esc_html__( 'Scripts and Tracking Code', 'aihub-core' ),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_custom_code_tracking',
			[
				'label' => esc_html__( 'Tracking Code', 'aihub-core' ),
				'description' => esc_html__( 'Paste your tracking code here. This will be added into the header template of your theme. Place code inside &lt;script&gt; tags.', 'aihub-core' ),
				'type' => Controls_Manager::CODE,
				'language' => 'html',
				'rows' => 20,
			]
		);

		$this->add_control(
			'liquid_custom_code_before_head',
			[
				'label' => esc_html__( 'Space before &lt;/head&gt;', 'aihub-core' ),
				'description' => esc_html__( 'Only accepts javascript code wrapped with &lt;script&gt; tags and HTML markup that is valid inside the &lt;/head&gt; tag.', 'aihub-core' ),
				'type' => Controls_Manager::CODE,
				'language' => 'html',
				'rows' => 20,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'liquid_custom_code_before_body',
			[
				'label' => esc_html__( 'Space before &lt;/body&gt;', 'aihub-core' ),
				'description' => esc_html__( 'Only accepts javascript code, wrapped with &lt;script&gt; tags and valid HTML markup inside the &lt;/body&gt; tag.', 'aihub-core' ),
				'type' => Controls_Manager::CODE,
				'language' => 'html',
				'rows' => 20,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_Advanced( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-advanced-kit', Liquid_Global_Advanced::class );
	}
);
