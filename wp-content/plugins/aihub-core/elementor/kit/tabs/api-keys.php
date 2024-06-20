<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_APIKeys extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-api-keys-kit';
	}

	public function get_title() {
		return __( 'API Keys', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-plug';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_general',
			[
				'label' => esc_html__('API Keys', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_google_api_key',
			[
				'label' => esc_html__( 'Google Maps API Key', 'aihub-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'enter-api-key', 'aihub-core' ),
				'description' => __( 'Follow the steps in <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key#key">the Google docs</a> to get the API key. This key applies to the google map element.', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->add_control(
			'liquid_mailchimp_api_key',
			[
				'label' => esc_html__( 'Mailchimp API Key', 'aihub-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'enter-api-key', 'aihub-core' ),
				'description' => __( 'Follow the steps <a target="_blank" href="https://mailchimp.com/help/about-api-keys/">MailChimp</a> to get the API key. This key applies to the newsletter element.', 'aihub-core' ),
				'ai' => [
					'active' => false
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'liquid_mailchimp_text__missing_api',
			[
				'label' => esc_html__( 'Missing API Text', 'aihub-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Please, input the MailChimp Api Key in Theme Options Panel', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);
		
		$this->add_control(
			'liquid_mailchimp_text__missing_list',
			[
				'label' => esc_html__( 'Missing List Text', 'aihub-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Wrong List ID, please select a real one', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);
		
		$this->add_control(
			'liquid_mailchimp_text__thanks',
			[
				'label' => esc_html__( 'Thank you Text', 'aihub-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Thank you, you have been added to our mailing list.', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);
		
		$this->add_control(
			'liquid_mailchimp_text__member_exists',
			[
				'label' => esc_html__( 'Member Exists', 'aihub-core' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '[email] is already a list member. Use PUT to insert or update list members.', 'aihub-core' ),
				'ai' => [
					'active' => false
				]
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_APIKeys( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-api-keys-kit', Liquid_Global_APIKeys::class );
	}
);
