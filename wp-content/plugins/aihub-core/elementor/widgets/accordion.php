<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Accordion extends Widget_Base {

	public function get_name() {
		return 'lqd-accordion';
	}

	public function get_title() {
		return __( 'Liquid Accordion', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-accordion lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'accordion', 'tab', 'toggle' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$active_item = $settings['active_item'];
		$el_id = $this->get_id();

		$behavior = [];
		$behavior[] = [
			'behaviorClass' => 'LiquidToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdAccordionToggle-$el_id'",
				'openedItems' => !empty( $active_item ) ? [ $active_item - 1 ] : [ 0 ],
				'parentToChangeClassname' => "'.lqd-accordion-item'",
				'toggleOffActiveItem' => true,
				'ui' => [
					'togglableTriggers' => "'.lqd-accordion-trigger'",
					'togglableElements' => "'.lqd-accordion-content-wrap'",
				]
			]
		];
		$behavior[] = [
			'behaviorClass' => 'LiquidEffectsSlideToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdAccordionToggle-$el_id'",
			]
		];

		return $behavior;

	}

	protected function register_controls() {

		// Items Section
		$this->start_controls_section(
			'items_section',
			[
				'label' => __( 'Items', 'aihub-core' ),
			]
		);

		$this->add_control(
			'lqd_predefined_style',
			[
				'label' => __( 'Predefined style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'aihub-core' ),
					'style-1' => __( 'Style 1', 'aihub-core' ),
					'style-2' => __( 'Style 2', 'aihub-core' ),
					'style-3' => __( 'Style 3', 'aihub-core' ),
					'style-4' => __( 'Style 4', 'aihub-core' ),
				],
				'default' => '',
				'frontend_available' => true
			]
		);

		$this->add_control(
			'active_item',
			[
				'label' => __( 'Active item', 'aihub-core' ),
				'description' => __( 'Set this to 0 if you want all items closed.', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 1,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Accordion Title', 'aihub-core' ),
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'content',
			[
				'label' => __( 'Content', 'aihub-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Accordion Content', 'aihub-core' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Accordion items', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Accordion #1', 'aihub-core' ),
						'content' => __( '<p>Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'aihub-core' ),
					],
					[
						'title' => __( 'Accordion #2', 'aihub-core' ),
						'content' => __( '<p>Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'aihub-core' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title element tag', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h4',
			]
		);

		$this->add_control(
			'faq_schema',
			[
				'label' => esc_html__( 'FAQ schema', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'aihub-core' ),
				'label_off' => __( 'Off', 'aihub-core' ),
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Trigger icon Section
		$this->start_controls_section(
			'trigger_icon_section',
			[
				'label' => __( 'Trigger icon', 'aihub-core' ),
			]
		);

		$this->add_control(
			'enable_trigger_icon',
			[
				'label' => __( 'Enable trigger icon', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'trigger_icon_position',
			[
				'label' => __( 'Position', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'end' => __( 'End', 'aihub-core' ),
					'start' => __( 'Start', 'aihub-core' ),
				],
				'default' => 'end',
				'condition' => [
					'enable_trigger_icon' => 'yes',
				]
			]
		);

		$this->start_controls_tabs(
			'trigger_icon_tabs',
			[
				'condition' => [
					'enable_trigger_icon' => 'yes'
				],
			]
		);

		$this->start_controls_tab(
			'trigger_icon_tab_normal',
			[
				'label'   => esc_html__( 'Normal', 'aihub-core' ),
			]
		);

		$this->add_control(
			'trigger_icon_closed',
			[
				'label' => __( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-chevron-down',
					'library' => 'solid',
				],
				'condition' => [
					'enable_trigger_icon' => 'yes'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'trigger_icon_tab_active',
			[
				'label'   => esc_html__( 'Active', 'aihub-core' ),
			]
		);

		$this->add_control(
			'trigger_icon_opened',
			[
				'label' => __( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-chevron-up',
					'library' => 'solid',
				],
				'condition' => [
					'enable_trigger_icon' => 'yes'
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// $this->add_control(
		// 	'liquid_help_dark_colors',
		// 	[
		// 		'type' => 'liquid-help-me',
		// 		'text' => esc_html__( 'Help me Liquid!', 'aihub-core' ),
		// 		'event' => 'liquid:help-me:dark-color:{{ELEMENT_ID}}',
		// 		'label_block' => true,
		// 		'separator' => 'after'
		// 	]
		// );

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'accordion',
			[
				'item' => [
					'controls' => [
						[
							'type' => 'margin',
							'css_var' => '--lqd-acc-i-m'
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-acc-i-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-acc-i-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-acc-i-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-acc-i-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-acc-i-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ]
				],
				'trigger' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-acc-t-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-acc-t-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-acc-t-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-acc-t-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-acc-t-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-acc-t-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ]
				],
				'trigger_icon' => [
					'controls' => [
						[
							'type' => 'font_size',
							'label' => 'Icon size',
							'tabbable' => false
						],
						[
							'type' => 'liquid_linked_dimensions',
						],
						[
							'type' => 'margin',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-acc-ti-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-acc-ti-bg',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-acc-ti-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-acc-ti-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-acc-ti-bs'
						],
					],
					'condition' => [
						'enable_trigger_icon' => 'yes'
					],
					'state_tabs' => [ 'normal', 'hover', 'active' ],
					'state_selectors_before' => [ 'hover' => '.lqd-accordion-item', 'active' => '.lqd-accordion-item' ]
				],
				'content' => [
					'controls' => [
						[
							'type' => 'typography',
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-acc-c-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-acc-c-bg',
						],
						[
							'type' => 'padding',
							'css_var' => '--lqd-acc-c-p'
						],
					],
				],
			],
		);

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();
		$classnames = [ 'lqd-accordion', 'w-full' ];

		$this->add_render_attribute( '_wrapper', [
			'class' => $classnames
		] );
	}

	protected function get_trigger_icon( $settings, $i ) {

		if ( $settings['enable_trigger_icon'] !== 'yes' ) return '';

		$trigger_icon_attrs_id = $this->get_repeater_setting_key( 'expander', 'items', $i );
		$trigger_icon_position = $settings['trigger_icon_position'];
		$trigger_icon_classnames = [ 'lqd-accordion-trigger-icon', 'inline-grid', 'place-content-center', 'shrink-0', 'pointer-events-none', 'transition-all' ];

		if ( $trigger_icon_position === 'start' ) {
			$trigger_icon_classnames[] = '-order-1';
		}

		$this->add_render_attribute( $trigger_icon_attrs_id, [
			'class' => $trigger_icon_classnames
		] );

		?><span <?php $this->print_render_attribute_string($trigger_icon_attrs_id) ?>>
			<span class="lqd-accordion-trigger-icon-icon lqd-accordion-trigger-icon-closed inline-flex grid-area-1-1"><?php
				\LQD_Elementor_Helper::render_icon( $settings['trigger_icon_closed'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
			?></span>
			<span class="lqd-accordion-trigger-icon-icon lqd-accordion-trigger-icon-opened inline-flex grid-area-1-1"><?php
				\LQD_Elementor_Helper::render_icon( $settings['trigger_icon_opened'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
			?></span>
		</span><?php

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$trigger_icon_position = $settings['trigger_icon_position'];

		$settings_active_item = $settings['active_item'];
		$active_item = is_numeric ($settings_active_item) ? $settings_active_item - 1 : 0;

		$title_tag = Utils::validate_html_tag( $settings['title_tag'] );

		foreach (  $settings['items'] as $i => $item )  {

			$active = $i === $active_item ? 'lqd-is-active' : '';
			$expanded = $i === $active_item ? 'true' : 'false';
			$item_attrs_id = $this->get_repeater_setting_key( 'item', 'items', $i );
			$content_wrap_attrs_id = $this->get_repeater_setting_key( 'content_wrap', 'items', $i );
			$content_attrs_id = $this->get_repeater_setting_key( 'content', 'items', $i );
			$button_attrs_id = $this->get_repeater_setting_key( 'button', 'items', $i );
			$content_id = 'lqd-accordion-' . $this->get_id() . '-content';
			$item_classnames = [ 'lqd-accordion-item', 'elementor-repeater-item-' . $item['_id'], 'transition-colors' ];
			$tirgger_classnames = [ 'lqd-accordion-trigger', 'lqd-togglable-trigger', 'lqd-widget-trigger', 'flex', 'items-center', 'w-full', 'cursor-pointer', 'transition-colors' ];
			$content_wrap_classnames = [ 'lqd-accordion-content-wrap', 'lqd-togglable-element' ];

			if ( $trigger_icon_position === 'end' ) {
				$tirgger_classnames[] = 'justify-between';
			}

			if ( !empty($active) ) {
				$item_classnames[] = $active;
				$tirgger_classnames[] = $active;
				$content_wrap_classnames[] = $active;
			} else {
				$content_wrap_classnames[] = 'hidden';
			}

			$this->add_render_attribute( $item_attrs_id, [
				'class' => $item_classnames,
			] );
			$this->add_render_attribute( $button_attrs_id, [
				'class' => $tirgger_classnames,
				'href' => '#' . $content_id,
				'aria-expanded' => $expanded,
				'aria-controls' => $content_id,
			] );
			$this->add_render_attribute( $content_wrap_attrs_id, [
				'class' => $content_wrap_classnames,
				'id' => $content_id
			] );
			$this->add_render_attribute( $content_attrs_id, [
				'class' => [ 'lqd-accordion-content' ]
			] );

		?>

		<div <?php $this->print_render_attribute_string( $item_attrs_id ); ?>>
			<<?php echo $title_tag ?> class="lqd-accordion-heading m-0 p-0" tabindex="-1">
				<a <?php $this->print_render_attribute_string( $button_attrs_id ); ?> tabindex="0">
					<span class="lqd-accordion-heading-txt pointer-events-none"><?php echo $item['title']; ?></span>
					<?php $this->get_trigger_icon( $settings, $i ); ?>
				</a>
			</<?php echo $title_tag ?>>
			<div <?php $this->print_render_attribute_string( $content_wrap_attrs_id ); ?>>
				<div <?php $this->print_render_attribute_string( $content_attrs_id ); ?>>
					<?php echo $item['content']; ?>
				</div>
			</div>
		</div>

		<?php } // end $items foreach;

		// FAQ Schema
		if ( isset( $settings['faq_schema'] ) && 'yes' === $settings['faq_schema'] ) {
			$json = [
				'@context' => 'https://schema.org',
				'@type' => 'FAQPage',
				'mainEntity' => [],
			];

			foreach ( $settings['items'] as $index => $item ) {
				$json['mainEntity'][] = [
					'@type' => 'Question',
					'name' => wp_strip_all_tags( $item['title'] ),
					'acceptedAnswer' => [
						'@type' => 'Answer',
						'text' => preg_replace('/[\x00-\x1F\x80-\xFF]/', '', strip_tags( $item['content'] )),
					],
				];
			}
			?>
			<script type="application/ld+json"><?php echo wp_json_encode( $json ); ?></script>
		<?php }

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Accordion() );