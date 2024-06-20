<?php

use Elementor\Core\Files\Uploads_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Liquid color control.
 *
 * @since 1.0.0
 */
class LQD_Color_Control extends \Elementor\Base_Data_Control {

	/**
	 * Get color control type.
	 *
	 * Retrieve the control type, in this case `color`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'liquid-color';
	}

	/**
	 * Enqueue media control scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the media
	 * control.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue() {

		wp_register_style( 'easylogic-colorpicker', plugins_url( 'color/EasyLogicColorPicker.css', dirname( __FILE__ ) ) );
		wp_register_style( 'liquid-color', plugins_url( 'color/color.css', dirname( __FILE__ ) ) );

		wp_register_script( 'easylogic-colorpicker', plugins_url( 'color/EasyLogicColorPicker.js', dirname( __FILE__ ) ) );
		wp_register_script( 'liquid-color', plugins_url( 'color/color.js', dirname( __FILE__ ) ), [ 'easylogic-colorpicker' ] );

		wp_enqueue_style( 'easylogic-colorpicker' );
		wp_enqueue_style( 'liquid-color' );

		wp_enqueue_script( 'easylogic-colorpicker' );
		wp_enqueue_script( 'liquid-color' );

	}

	/**
	 * Render color control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		?>
		<div class="elementor-control-field">
			<# if ( data.label && data.label !== '' ) { #>
				<label class="elementor-control-title">{{{ data.label || '' }}}</label>
			<# } #>
			<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
			<# } #>
			<div class="elementor-control-input-wrapper lqd-control-input-wrapper lqd-control-color-wrapper elementor-control-dynamic-switcher-wrapper">
				<button class="liquid-color-picker-trigger"></button>
				<div class="liquid-color-picker-placeholder"></div>
			</div>
		</div>
		<?php
	}

	/**
	 * Get color control default settings.
	 *
	 * Retrieve the default settings of the color control. Used to return the default
	 * settings while initializing the color control.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'dynamic' => [
				'categories' => [
					TagsModule::COLOR_CATEGORY,
				],
				'active' => false,
			],
			'global' => [
				'active' => true,
			],
			'types' => 'all',
			'label_block' => false
		];
	}
}
\Elementor\Plugin::instance()->controls_manager->register( new LQD_Color_Control() );