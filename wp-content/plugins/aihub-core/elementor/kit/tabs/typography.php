<?php

use Elementor\Core\Settings\Page\Manager as PageManager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Typography extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );

	}

	public function get_id() {
		return 'liquid-custom-typography-kit';
	}

	public function get_title() {
		return __( 'Liquid Typography', 'aihub-core' );
	}

	public function get_group() {
		return 'theme-style';
	}

	public function get_icon() {
		return 'eicon-typography-1';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$kit = Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();

		/**
		 * Retrieve the settings directly from DB, because of an open issue when a controls group is being initialized
		 * from within another group
		 */
		$kit_settings = $kit->get_meta( PageManager::META_KEY );

		$default_fonts = isset( $kit_settings['default_generic_fonts'] ) ? $kit_settings['default_generic_fonts'] : 'Sans-serif';

		if ( $default_fonts ) {
			$default_fonts = ', ' . $default_fonts;
		}

		$this->start_controls_section(
			'section_' . $this->get_id(),
			[
				'label' => $this->get_title(),
				'tab' => $this->get_id(),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => esc_html__( 'Font title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'woff',
			[
				'label' => esc_html__( 'WOFF', 'aihub-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['woff'],
			]
		);

		$repeater->add_control(
			'woff2',
			[
				'label' => esc_html__( 'WOFF2', 'aihub-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['woff'],
			]
		);

		$repeater->add_control(
			'ttf',
			[
				'label' => esc_html__( 'TTF', 'aihub-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['ttf'],
			]
		);

		$repeater->add_control(
			'weight',
			[
				'label' => esc_html__( 'Weight', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '400',
				'options' => [
					'100' => esc_html__( '100 (Thin)', 'aihub-core' ),
					'200' => esc_html__( '200 (Extra Light)', 'aihub-core' ),
					'300' => esc_html__( '300 (Light)', 'aihub-core' ),
					'400' => esc_html__( '400 (Normal)', 'aihub-core' ),
					'500' => esc_html__( '500 (Medium)', 'aihub-core' ),
					'600' => esc_html__( '600 (Semi Bold)', 'aihub-core' ),
					'700' => esc_html__( '700 (Bold)', 'aihub-core' ),
					'800' => esc_html__( '800 (Extra Bold)', 'aihub-core' ),
					'900' => esc_html__( '900 (Black)', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'custom_fonts_heading',
			[
				'label' => esc_html__( 'Custom fonts', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'liquid_custom_fonts',
			[
				'label' => esc_html__( 'Fonts', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title +\' - \'+ weight }}}',
			]
		);

		$this->add_control(
			'liquid_typekit_id',
			[
				'label' => esc_html__( 'Adobe Fonts (Typekit)', 'aihub-core' ),
				'placeholder' => esc_html__( 'Enter Typekit ID', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'liquid_typography_custom_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'liquid_body_typography_heading',
			[
				'label' => esc_html__( 'Body', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_body_typography',
				'label' => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}}',
				'fields_options' => [
					'font_family' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-font-family: "{{VALUE}}"' . $default_fonts . ';',
						]
					],
					'font_size' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-font-size: {{SIZE}}{{UNIT}}',
						]
					],
					'font_weight' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-font-weight: {{VALUE}}',
						]
					],
					'text_transform' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-text-transform: {{VALUE}}',
						]
					],
					'font_style' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-font-style: {{VALUE}}',
							'body' => 'font-style: var(--lqd-body-font-style)',
						]
					],
					'text_decoration' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-text-decoration: {{VALUE}}',
							'body' => 'text-decoration: var(--lqd-body-text-decoration)',
						]
					],
					'line_height' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-line-height: {{SIZE}}{{UNIT}}',
						]
					],
					'letter_spacing' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-letter-spacing: {{SIZE}}{{UNIT}}',
						]
					],
					'word_spacing' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-body-word-spacing: {{SIZE}}{{UNIT}}',
							'body' => 'word-spacing: var(--lqd-body-word-spacing)',
						]
					],
				]
			]
		);

		$this->add_control(
			'liquid_body_color',
			[
				'label' => esc_html__( 'Text color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-body-text-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'liquid_paragraph_spacing',
			[
				'label' => esc_html__( 'Paragraph spacing', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-p-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'liquid_typography_body_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'liquid_link_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Link', 'aihub-core' ),
			]
		);

		$this->start_controls_tabs( 'liquid_tabs_link_style' );

		$this->start_controls_tab(
			'liquid_tab_link_normal',
			[
				'label' => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_link_normal_typography',
				'selector' => '{{WRAPPER}}',
				'fields_options' => [
					'font_family' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-font-family: "{{VALUE}}"' . $default_fonts . ';',
							'a' => 'font-family: var(--lqd-link-font-family)'
						]
					],
					'font_size' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-font-size: {{SIZE}}{{UNIT}}',
							'a' => 'font-family: var(--lqd-link-font-size)'
						]
					],
					'font_weight' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-font-weight: {{VALUE}}',
							'a' => 'font-family: var(--lqd-link-font-weight)'
						]
					],
					'text_transform' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-text-transform: {{VALUE}}',
							'a' => 'text-transform: var(--lqd-link-text-transform)'
						]
					],
					'font_style' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-font-style: {{VALUE}}',
							'a' => 'font-style: var(--lqd-link-font-style)',
						]
					],
					'text_decoration' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-text-decoration: {{VALUE}}',
							'a' => 'text-decoration: var(--lqd-link-text-decoration)',
						]
					],
					'line_height' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-line-height: {{SIZE}}{{UNIT}}',
							'a' => 'line-height: var(--lqd-link-line-height)',
						]
					],
					'letter_spacing' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-letter-spacing: {{SIZE}}{{UNIT}}',
							'a' => 'letter-spacing: var(--lqd-link-letter-spacing)',
						]
					],
					'word_spacing' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-link-word-spacing: {{SIZE}}{{UNIT}}',
							'a' => 'word-spacing: var(--lqd-link-word-spacing)',
						]
					],
				]
			]
		);

		$this->add_control(
			'liquid_link_normal_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'dynamic' => [],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-link-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'liquid_tab_link_hover',
			[
				'label' => esc_html__( 'Hover', 'aihub-core' ),
			]
		);

		$this->add_control(
			'liquid_link_hover_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'dynamic' => [],
				'selectors' => [
					'{{WRAPPER}} a:hover' => '--lqd-link-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'liquid_headings_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		// Headings.
		$this->add_element_controls( esc_html__( 'Headings common typography', 'aihub-core' ), 'heading', '{{WRAPPER}}', $default_fonts );
		$this->add_element_controls( esc_html__( 'H1', 'aihub-core' ), 'h1', '{{WRAPPER}}', $default_fonts );
		$this->add_element_controls( esc_html__( 'H2', 'aihub-core' ), 'h2', '{{WRAPPER}}', $default_fonts );
		$this->add_element_controls( esc_html__( 'H3', 'aihub-core' ), 'h3', '{{WRAPPER}}', $default_fonts );
		$this->add_element_controls( esc_html__( 'H4', 'aihub-core' ), 'h4', '{{WRAPPER}}', $default_fonts );
		$this->add_element_controls( esc_html__( 'H5', 'aihub-core' ), 'h5', '{{WRAPPER}}', $default_fonts );
		$this->add_element_controls( esc_html__( 'H6', 'aihub-core' ), 'h6', '{{WRAPPER}}', $default_fonts );

		$this->end_controls_section();
	}

	private function add_element_controls( $label, $prefix, $selector, $default_fonts ) {

		$this->add_control(
			'liquid_' . $prefix . '_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => $label,
				'separator' => $prefix !== 'heading' ? 'before' : ''
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'liquid_' . $prefix . '_typography',
				'selector' => $selector,
				'fields_options' => [
					'font_family' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-font-family: "{{VALUE}}"' . $default_fonts . ';',
						]
					],
					'font_size' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-font-size: {{SIZE}}{{UNIT}}',
						]
					],
					'font_weight' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-font-weight: {{VALUE}}',
						]
					],
					'text_transform' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-text-transform: {{VALUE}}',
						]
					],
					'font_style' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-font-style: {{VALUE}}',
							$prefix => 'font-style: var(--lqd-' . $prefix . '-font-style)',
						]
					],
					'text_decoration' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-text-decoration: {{VALUE}}',
							$prefix => 'text-decoration: var(--lqd-' . $prefix . '-text-decoration)',
						]
					],
					'line_height' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-line-height: {{SIZE}}{{UNIT}}',
						]
					],
					'letter_spacing' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-letter-spacing: {{SIZE}}{{UNIT}}',
						]
					],
					'word_spacing' => [
						'selectors' => [
							'{{SELECTOR}}' => '--lqd-' . $prefix . '-word-spacing: {{SIZE}}{{UNIT}}',
							$prefix => 'word-spacing: var(--lqd-' . $prefix . '-word-spacing)',
						]
					],
				]
			]
		);

		$this->add_control(
			'liquid_' . $prefix . '_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'dynamic' => [],
				'selectors' => [
					$selector => '--lqd-' . $prefix . '-color: {{VALUE}};',
				],
			]
		);
	}

}

new Liquid_Global_Typography( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-custom-typography-kit', Liquid_Global_Typography::class );
	}
);

add_action('elementor/css-file/post/parse', function( $post_css ){
	$get_fonts = liquid_helper()->get_kit_option( 'liquid_custom_fonts' );
	$font_display = liquid_helper()->get_kit_option( 'liquid_custom_fonts_display' );


	if ( $get_fonts ){
		$font_face = '';

		foreach( $get_fonts as $key => $font ) {

			if ( ! isset($font['title']) ) return;

			$weight = isset( $font['weight'] ) ? $font['weight'] : '400';

			$urls = array();
			if ( isset( $font['woff']['url'] ) && ! empty( $font['woff']['url'] ) ){
				$urls[] = 'url(' . esc_url( $font['woff']['url'] ) . ')';
			}
			if ( isset( $font['woff2']['url'] ) && ! empty( $font['woff2']['url'] ) ){
				$urls[] = 'url(' . esc_url( $font['woff2']['url'] ) . ')';
			}
			if ( isset( $font['ttf']['url'] ) && ! empty( $font['ttf']['url'] ) ){
				$urls[] = 'url(' . esc_url( $font['ttf']['url'] ) . ')';
			}

			$uploads = wp_upload_dir();
			$replaced_urls = array_map(function($element) {
				return str_replace(
					array(
						"https://staging.liquid-themes.com/ai-carousel/wp-content/uploads",
						"https://staging.liquid-themes.com/ai-default/wp-content/uploads",
						"https://staging.liquid-themes.com/ai-demo2/wp-content/uploads",
						"https://staging.liquid-themes.com/ai-stable-diffusion/wp-content/uploads",
						"https://staging.liquid-themes.com/ai-demo3/wp-content/uploads",
						"https://staging.liquid-themes.com/ai-text-generator/wp-content/uploads",
					),
					wp_upload_dir()['baseurl'],
					$element
				);
			}, $urls);

			$font_face .= '@font-face {' . "\n";
			$font_face .= 'font-family:"' . esc_attr( $font['title'] ) . '";' . "\n";
			$font_face .= 'src:';
			$font_face .= implode( ', ', $replaced_urls ) . ';';
			$font_face .= 'font-weight:' . esc_attr( $weight ) . ';' . "\n";
			$font_face .= 'font-display:'. esc_attr( $font_display ) .';' . "\n";
			$font_face .= '}' . "\n";

		}

		$custom_css = '/* Start Liquid Custom Font CSS */' . $font_face . '/* End Liquid Custom Font CSS */';

		$post_css->get_stylesheet()->add_raw_css( $custom_css );

	}
});

add_action('wp_head', function(){

	$get_fonts = liquid_helper()->get_kit_option( 'liquid_custom_fonts' );

	if ( $get_fonts ){
		$font_face = '';

		foreach( $get_fonts as $key => $font ) {

			if ( ! isset($font['title']) ) return;

			if ( isset( $font['woff']['url'] ) && ! empty( $font['woff']['url'] ) ){
				$font_face .= sprintf( '<link %1$s href="%2$s" as="font" type="font/woff" crossorigin>', esc_attr('rel=preload'), esc_url( $font['woff']['url'] ) );
			}
			if ( isset( $font['woff2']['url'] ) && ! empty( $font['woff2']['url'] ) ){
				$font_face .= sprintf( '<link %1$s href="%2$s" as="font" type="font/woff2" crossorigin>', esc_attr('rel=preload'), esc_url( $font['woff2']['url'] ) );
			}
			if ( isset( $font['ttf']['url'] ) && ! empty( $font['ttf']['url'] ) ){
				$font_face .= sprintf( '<link %1$s href="%2$s" as="font" type="font/ttf" crossorigin>', esc_attr('rel=preload'), esc_url( $font['ttf']['url'] ) );
			}

			$uploads = wp_upload_dir();
			$font_face = str_replace(
				array(
					"https://staging.liquid-themes.com/ai-carousel/wp-content/uploads",
					"https://staging.liquid-themes.com/ai-default/wp-content/uploads",
					"https://staging.liquid-themes.com/ai-demo2/wp-content/uploads",
					"https://staging.liquid-themes.com/ai-stable-diffusion/wp-content/uploads",
					"https://staging.liquid-themes.com/ai-demo3/wp-content/uploads",
					"https://staging.liquid-themes.com/ai-text-generator/wp-content/uploads",
				),
				wp_upload_dir()['baseurl'],
				$font_face
			);

		}

		echo $font_face;

	}

}, 1); 