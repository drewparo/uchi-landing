<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Header extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-header-kit';
	}

	public function get_title() {
		return __( 'Header', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		/*
		 *
		 * Header Manager
		 *
		 */

		Liquid_Page_Condition::add_condition_controls( $this, null, 'liquid_header_condition', 'liquid-header' );

	}

}

new Liquid_Global_Header( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-header-kit', Liquid_Global_Header::class );
	}
);
