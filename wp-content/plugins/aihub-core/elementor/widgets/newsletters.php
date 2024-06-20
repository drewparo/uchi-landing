<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Newsletters extends Widget_Base {

	public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);

		wp_register_script( 'liquid-newsletter-form',
			get_template_directory_uri() . '/liquid/assets/js/widgets/liquid-newsletter-form.js',
			[ 'jquery' ],
			LQD_CORE_VERSION,
			true
		);

	}

	public function get_name() {
		return 'lqd-newsletters';
	}

	public function get_title() {
		return __( 'Liquid Newsletters', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-mail lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'newsletter', 'form', 'mailchimp', 'hubspot' ];
	}

	public function get_script_depends() {
		return [ 'liquid-newsletter-form' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'service',
			[
				'label' => esc_html__( 'Service', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'mailchimp',
				'options' => [
					'mailchimp' => esc_html__( 'MailChimp', 'aihub-core' ),
				],
			]
		);

		if ( ! \LQD_Newsletters_Handler::get_mailchimp_lists() ) {
			$this->add_control(
				'mailchimp_list_id',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( 'Go to the <strong><u>Elementor Site Settings > API Keys</u></strong> to add your API Key.', 'aihub-core' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		} else {
			$this->add_control(
				'mailchimp_list_id',
				[
					'label' => __( 'List ID', 'aihub-core' ),
					'description' => __( 'Select the list from mailchimp to add emails. The API Key of the Mailchimp should be added in Theme Options', 'aihub-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => \LQD_Newsletters_Handler::get_mailchimp_lists(),
				]
			);
		}


		$this->add_control(
			'placeholder_email',
			[
				'label' => esc_html__( 'Email placeholder', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter your email', 'aihub-core' ),
				'placeholder' => esc_html__( 'Enter your email', 'aihub-core' ),
				'ai' => [
					'active' => false,
				],
			]
		);

		$this->add_control(
			'use_tags',
			[
				'label' => __( ' Use Tags?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
				'description' => esc_html__( 'Tags are labels you create to help organize your contacts.', 'aihub-core' ),
			]
		);

		$this->add_control(
			'tags',
			[
				'label' => esc_html__( 'Tags', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'show_label' => false,
				'default' => esc_html__( '', 'aihub-core' ),
				'placeholder' => esc_html__( 'Newsletter,Footer', 'aihub-core' ),
				'description' => esc_html__( 'You can define multiple tags with comma(,)', 'aihub-core' ),
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'use_tags' => 'yes'
				]
			]
		);

		$this->add_control(
			'use_opt_in',
			[
				'label' => __( 'Use Opt-in?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_responsive_control(
			'items_orientation',
			[
				'label' => esc_html__('Orientation', 'aihub-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Horizontal', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-h',
					],
					'column' => [
						'title' => esc_html__( 'Vertical', 'aihub-core' ),
						'icon' => 'eicon-ellipsis-v',
					],
				],
				'default' => 'row',
				'toggle' => false,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-newsletter-form' => 'flex-direction: {{VALUE}}'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'newsletter_effects',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'lqd_outline_glow_effect',
			[
				'label' => esc_html__( 'Glow effect style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'effect-1' => esc_html__( 'Effect 1', 'aihub-core' ),
					'effect-2' => esc_html__( 'Effect 2', 'aihub-core' ),
				],
				'default' => '',
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'newsletters',
			[
				'form' => [
					'controls' => [
						[
							'type' => 'margin'
						],
						[
							'type' => 'padding'
						],
						[
							'type' => 'liquid_background_css'
						],
						[
							'type' => 'border'
						],
						[
							'type' => 'border_radius'
						],
						[
							'type' => 'box_shadow'
						],
					],
					'plural_heading' => false,
					'selector' => '.lqd-newsletter-form',
					'state_tabs' => [ 'normal', 'hover' ],
				],
				'input' => [
					'controls' => [
						[
							'type' => 'typography'
						],
						[
							'type' => 'margin'
						],
						[
							'type' => 'padding'
						],
						[
							'type' => 'liquid_color',
						],
						[
							'type' => 'liquid_background_css'
						],
						[
							'type' => 'border'
						],
						[
							'type' => 'border_radius'
						],
						[
							'type' => 'box_shadow'
						],
					],
					'plural_heading' => false,
					'selector' => '.lqd-newsletter-input-wrap',
					'state_tabs' => [ 'normal', 'focus-within' ],
				],
				'response_text' => [
					'controls' => [
						[
							'type' => 'padding'
						],
						[
							'type' => 'margin'
						],
						[
							'type' => 'typography'
						],
						[
							'type' => 'liquid_color'
						],
						[
							'type' => 'liquid_background_css'
						],
						[
							'type' => 'border'
						],
						[
							'type' => 'border_radius'
						],
						[
							'type' => 'box_shadow'
						],
					],
					'selector' => '.lqd-newsletter--response'
				],
				'glow' => [
					'controls' => [
						[
							'type' => 'width',
							'css_var' => '--lqd-outline-glow-w',
						],
						[
							'type' => 'slider',
							'name' => 'duration',
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 1,
									'max' => 10,
								]
							],
							'unit' => 's',
							'css_var' => '--lqd-outline-glow-duration',
						],
						[
							'type' => 'liquid_color',
							'name' => 'color',
							'types' => [ 'solid' ],
							'css_var' => '--lqd-outline-glow-color',
						],
						[
							'type' => 'liquid_color',
							'name' => 'color_secondary',
							'types' => [ 'solid' ],
							'css_var' => '--lqd-outline-glow-color-secondary',
						],
					],
					'apply_css_var_to_el' => true,
					'plural_heading' => false,
					'selector' => '.lqd-newsletter-input-wrap',
					'condition' => [
						'lqd_outline_glow_effect!' => ''
					]
				],
			],
		);

		lqd_elementor_add_button_controls( $this, 'ib_', [], true, 'all', true, 'submit' );

	}

	protected function get_outline_glow_markup() {

		$settings = $this->get_settings_for_display();
		$glow_effect = $settings[ 'lqd_outline_glow_effect' ];

		if ( empty( $glow_effect ) ) return;

		$glow_attrs = [
			'class' => [ 'lqd-outline-glow', 'lqd-outline-glow-' . $glow_effect, 'inline-block', 'rounded-inherit', 'absolute', 'pointer-events-none' ]
		];

		$this->add_render_attribute( 'outline_glow', $glow_attrs );

		?>
			<span <?php $this->print_render_attribute_string( 'outline_glow' ); ?>>
				<span class="lqd-outline-glow-inner inline-block min-w-full min-h-full rounded-inherit aspect-square absolute top-1/2 start-1/2"></span>
			</span>
		<?php

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>
			<div class="lqd-newsletter">
				<form class="lqd-newsletter-form flex" method="post" action="<?php echo the_permalink() ?>">
					<div class="lqd-newsletter-input-wrap flex grow relative">
						<?php $this->get_outline_glow_markup(); ?>
						<input class="lqd-newsletter-form-input grow w-full outline-none relative transition-all" type="email" name="email" placeholder="<?php echo esc_attr( $settings['placeholder_email'] ); ?>" autocomplete="off">
					</div>
					<?php \LQD_Elementor_Render_Button::get_button( $this, 'ib_', '', 'submit' ); ?>
					<?php if ( !empty( $settings['mailchimp_list_id'] ) ) : ?>
						<input type="hidden" class="lqd-newsletter-form--list-id" name="list-id" value="<?php echo esc_attr( $settings['mailchimp_list_id'] ); ?>">
					<?php endif; ?>
					<?php if ( !empty( $settings['tags'] ) ) : ?>
						<input type="hidden" class="lqd-newsletter-form--tags" name="tags" value="<?php echo esc_attr( $settings['tags'] ); ?>">
					<?php endif; ?>
					<input type="hidden" class="lqd-newsletter-form--service" name="service" value="<?php echo esc_attr( $settings['service'] ); ?>">
					<?php wp_nonce_field( 'lqd-newsletter-form', 'security' ); ?>
				</form>

				<div class="lqd-newsletter--response hidden">
				</div>
			</div>

		<?php

	}


}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Newsletters() );