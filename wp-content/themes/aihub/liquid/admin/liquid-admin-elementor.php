<?php

/**
* Liquid Themes Theme Framework
* The Liquid_Admin_Dashboard base class
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

if ( !defined( 'ELEMENTOR_VERSION' ) && !is_callable( 'Elementor\Plugin::instance' ) ){
	return;
}

class Liquid_Admin_Elementor_Settings extends Liquid_Admin_Page {

	/**
	 * [__construct description]
	 * @method __construct
	 */

	public function __construct() {

		$this->id = 'liquid-elementor';
		$this->page_title = esc_html__( 'Site Settings', 'aihub' );
		$this->menu_title = esc_html__( 'Site Settings', 'aihub' );
		$this->parent = 'liquid';
		$this->position = '45';
		parent::__construct();

	}

	/**
	 * [display description]
	 * @method display
	 * @return [type]  [description]
	 */

	public function display() {

	}

	/**
	 * [save description]
	 * @method save
	 * @return [type] [description]
	 */
	public function save() {

	}
}
new Liquid_Admin_Elementor_Settings;
