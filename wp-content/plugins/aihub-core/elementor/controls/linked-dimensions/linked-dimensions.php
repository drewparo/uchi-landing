<?php

class Liquid_Linked_Dimensions_Control extends \Elementor\Control_Dimensions {

	public function get_type() {
		return 'liquid-linked-dimensions';
	}

	public function enqueue() {
		
		wp_register_script( 'liquid-linked-dimensions', plugins_url( './linked-dimensions/linked-dimensions.js', dirname( __FILE__ ) ));
		wp_enqueue_script( 'liquid-linked-dimensions' );
		
	}

	public function get_default_value() {
		return array_merge(
			parent::get_default_value(), [
				'width' => '',
				'height' => '',
				'isLinked' => true,
			]
		);
	}
	
	protected function get_default_settings() {
		return array_merge(
			parent::get_default_settings(), [
				'label_block' => true,
				'placeholder' => '',
			]
		);
	}

	public function content_template() {
		$dimensions = [
			'width' => esc_html__( 'Width', 'aihub-core' ),
			'height' => esc_html__( 'Height', 'aihub-core' ),
		];
		?>
		<div class="elementor-control-field elementor-control-type-dimensions">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<?php $this->print_units_template(); ?>
			<div class="elementor-control-input-wrapper">
				<ul class="elementor-control-dimensions">
					<?php
					foreach ( $dimensions as $dimension_key => $dimension_title ) :
						?>
						<li class="elementor-control-dimension" style="width: 33.33%;">
							<input id="<?php $this->print_control_uid( $dimension_key ); ?>" type="number" data-setting="<?php
								// PHPCS - the variable $dimension_key is a plain text.
								echo $dimension_key; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>" placeholder="<#
								placeholder = view.getControlPlaceholder();
								if ( _.isObject( placeholder ) ) {
									if ( ! _.isUndefined( placeholder.<?php
										// PHPCS - the variable $dimension_key is a plain text.
										echo $dimension_key; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									?> ) ) {
										print( placeholder.<?php
											// PHPCS - the variable $dimension_key is a plain text.
											echo $dimension_key; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?> );
									}
								} else {
								print( placeholder );
								} #>" />
							<label for="<?php $this->print_control_uid( $dimension_key ); ?>" class="elementor-control-dimension-label"><?php
								// PHPCS - the variable $dimension_title holds an escaped translated value.
								echo $dimension_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?></label>
						</li>
					<?php endforeach; ?>
					<li style="width: 33.33%;">
						<button class="elementor-link-dimensions tooltip-target" data-tooltip="<?php echo esc_attr__( 'Link values together', 'aihub-core' ); ?>">
							<span class="elementor-linked">
								<i class="eicon-link" aria-hidden="true"></i>
								<span class="elementor-screen-only"><?php echo esc_html__( 'Link values together', 'aihub-core' ); ?></span>
							</span>
							<span class="elementor-unlinked">
								<i class="eicon-chain-broken" aria-hidden="true"></i>
								<span class="elementor-screen-only"><?php echo esc_html__( 'Unlinked values', 'aihub-core' ); ?></span>
							</span>
						</button>
					</li>
				</ul>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

}
\Elementor\Plugin::instance()->controls_manager->register( new Liquid_Linked_Dimensions_Control() );