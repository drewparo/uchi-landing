<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Glow extends Widget_Base {

	public function get_name() {
		return 'lqd-glow';
	}

	public function get_title() {
		return __( 'Liquid Glow', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-barcode lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'glow', 'animation', 'svg', 'blur' ];
	}

	protected function register_controls() {

		$elementor_doc_selector = '.elementor';
		$dark_selectors = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} svg, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} svg, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} svg';

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'aihub-core' ),
			]
		);

		$this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'blur',
			[
				'label' => esc_html__( 'Blur', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--glow-blur-value: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} svg' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control( 'hr', [
			'type' => Controls_Manager::DIVIDER,
		] );

		$this->add_control(
			'start_options',
			[
				'label' => esc_html__( 'Start Options', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'duration_start',
			[
				'label' => esc_html__( 'Duration (seconds)', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4.25,
				],
			]
		);

		$repeater_start = new Repeater();

		$repeater_start->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
			]
		);

		$this->add_control(
			'colors_start',
			[
				'label' => esc_html__( 'Colors', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_start->get_controls(),
				'default' => [
					[ 'color' => '#f8f7a1' ],
					[ 'color' => '#b185fe' ],
					[ 'color' => '#53fd87' ],
					[ 'color' => '#f8f7a1' ],
				],
				'title_field' => '<span style="display:inline-block;width:17px;height:17px;margin-inline-end:2px;background:{{{color}}};vertical-align:middle;border-radius:3px;"></span> {{{ color }}}',
			]
		);

		$this->add_control( 'hr2', [
			'type' => Controls_Manager::DIVIDER,
		] );

		$this->add_control(
			'end_options',
			[
				'label' => esc_html__( 'End Options', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'duration_end',
			[
				'label' => esc_html__( 'Duration (seconds)', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4.25,
				],
			]
		);

		$repeater_start = new Repeater();

		$repeater_start->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
			]
		);

		$this->add_control(
			'colors_end',
			[
				'label' => esc_html__( 'Colors', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_start->get_controls(),
				'default' => [
					[ 'color' => '#ff9c00' ],
					[ 'color' => '#6ed5fb' ],
					[ 'color' => '#ff7274' ],
					[ 'color' => '#ff9c00' ],
				],
				'title_field' => '<span style="display:inline-block;width:17px;height:17px;margin-inline-end:2px;background:{{{color}}};vertical-align:middle;border-radius:3px;"></span> {{{ color }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'glow_dark_section',
			[
				'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'glow_dark_opacity',
			[
				'label' => esc_html__( 'Opacity', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					$dark_selectors => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$filter_id = 'filter_' . $this->get_id();
		$paint_id = 'paint_' . $this->get_id();
		$duration = [
			'start' => isset( $settings['duration_start']['size'] ) ? $settings['duration_start']['size'] . 's' : '4.25s',
			'end' => isset( $settings['duration_end']['size'] ) ? $settings['duration_end']['size'] . 's' : '3s'
		];
		$colors = [
			'start' => '',
			'end' => '',
		];
		$start_first_color = '';
		$end_first_color = '';

		if ( !empty( $settings['colors_start'] ) ) {
			$start_first_color = $settings['colors_start'][0]['color'];
			foreach( $settings['colors_start'] as $colors_start ) {
				$colors['start'] .= $colors_start['color'] . ';';
			}
		}

		if ( !empty( $settings['colors_end'] ) ) {
			$end_first_color = $settings['colors_end'][0]['color'];
			foreach( $settings['colors_end'] as $colors_end ) {
				$colors['end'] .= $colors_end['color'] . ';';
			}
		}

		?>

		<svg class="w-full h-full" width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
			<circle cx="32.5" cy="32.5" r="32.5" fill="<?php echo esc_attr( 'url(#' . $paint_id . ')' ); ?>"/>
			<defs>
				<linearGradient id="<?php echo esc_attr( $paint_id ); ?>" x1="0" y1="0" x2="65" y2="65" gradientUnits="userSpaceOnUse">
					<stop offset="0" stop-color="<?php echo esc_attr( $start_first_color ); ?>">
						<animate attributeName="stop-color" values="<?php echo esc_attr( rtrim( $colors['start'] ) ); ?>" dur="<?php echo esc_attr( $duration['start'] ); ?>" repeatCount="indefinite"></animate>
					</stop>
					<stop offset="1" stop-color="<?php echo esc_attr( $end_first_color ); ?>">
						<animate attributeName="stop-color" values="<?php echo esc_attr( rtrim( $colors['end'] ) ); ?>" dur="<?php echo esc_attr( $duration['end'] ); ?>" repeatCount="indefinite"></animate>
					</stop>
				</linearGradient>
			</defs>
		</svg>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Glow() );