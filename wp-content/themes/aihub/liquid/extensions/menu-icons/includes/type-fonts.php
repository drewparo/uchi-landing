<?php
/**
 * Icon fonts handler
 *
 * @package Liquid_Menu_Icons
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 */

require_once dirname( __FILE__ ) . '/type.php';

/**
 * Generic handler for icon fonts
 *
 */
abstract class Liquid_Menu_Icons_Type_Fonts extends Liquid_Menu_Icons_Type {
	/**
	 * Constructor
	 *
	 * @since 0.9.0
	 */
	public function __construct() {
		_deprecated_function( __CLASS__, '0.9.0', 'Icon_Picker_Type_Font' );
	}
}
