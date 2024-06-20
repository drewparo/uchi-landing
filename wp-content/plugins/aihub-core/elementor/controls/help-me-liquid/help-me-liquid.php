<?php

use Elementor\Core\Files\Uploads_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Liquid help control.
 *
 * @since 1.0.0
 */
class LQD_Help_Me extends \Elementor\Control_Button {

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
		return 'liquid-help-me';
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

		wp_register_style( 'liquid-help-me', plugins_url( 'help-me-liquid/help-me-liquid.css', dirname( __FILE__ ) ) );

		wp_register_script( 'tinycolor', plugins_url( 'help-me-liquid/tinycolor.js', dirname( __FILE__ ) ) );
		wp_register_script( 'liquid-help-me', plugins_url( 'help-me-liquid/help-me-liquid.js', dirname( __FILE__ ) ), ['tinycolor'] );

		wp_enqueue_style( 'liquid-help-me' );

		wp_enqueue_script( 'tinycolor' );
		wp_enqueue_script( 'liquid-help-me' );

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
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<button type="button" class="lqd-help-me-btn elementor-button elementor-button-{{{ data.button_type }}}" data-event="{{{ data.event }}}">{{{ data.text }}}</button>
				<button type="button" class="lqd-help-me-btn-modifier lqd-help-me-btn-saturate elementor-button elementor-button-{{{ data.button_type }}}" data-event="{{{ data.event }}}" data-action="saturate:+">More saturated</button>
				<button type="button" class="lqd-help-me-btn-modifier lqd-help-me-btn-desaturate elementor-button elementor-button-{{{ data.button_type }}}" data-event="{{{ data.event }}}" data-action="saturate:-">More desaturated</button>
				<button type="button" class="lqd-help-me-btn-modifier lqd-help-me-btn-brighten elementor-button elementor-button-{{{ data.button_type }}}" data-event="{{{ data.event }}}" data-action="lighten:+">Lighter</button>
				<button type="button" class="lqd-help-me-btn-modifier lqd-help-me-btn-darken elementor-button elementor-button-{{{ data.button_type }}}" data-event="{{{ data.event }}}" data-action="lighten:-">Darker</button>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
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
			'text' => '',
			'event' => '',
			'button_type' => 'default',
		];
	}
}
\Elementor\Plugin::instance()->controls_manager->register( new LQD_Help_Me() );