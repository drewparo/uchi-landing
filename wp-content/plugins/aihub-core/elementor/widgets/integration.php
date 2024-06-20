<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class LQD_Integration extends Widget_Base {
	public function get_name() {
		return 'lqd-integration';
	}

	public function get_title() {
		return __('Liquid Integration', 'aihub-core');
	}

	public function get_icon() {
		return 'eicon-theme-builder lqd-element';
	}

	public function get_categories() {
		return ['liquid-core'];
	}

	public function get_keywords() {
		return ['icon', 'icon tree', 'integration'];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$behavior = [];

		return $behavior;
	}

	protected function get_liquid_background( $option_name = '', $content_template = false ) {

		$background = new \LQD_Elementor_Render_Background;
		if ( $content_template ){
			$background->render_template();
		} else {
			$background->render( $this, $this->get_settings_for_display(), $option_name );
		}

	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'aihub-core'),
			]
		);

		$this->add_control(
			'media_type',
			[
				'label' => esc_html__( 'Main image type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'image' => [
						'title' => esc_html__( 'Image', 'aihub-core' ),
						'icon' => 'eicon-image',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'aihub-core' ),
						'icon' => 'eicon-star-o',
					],
				],
				'default' => 'image',
				'toggle' => false,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'media_type' => 'icon'
				]
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_type' => 'image'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
				'condition' => [
					'media_type' => 'image'
				]
			]
		);

		$items_repeater = new Repeater();

		$items_repeater->add_control(
			'item_title',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Service name', 'aihub-core' ),
			]
		);

		$items_repeater->add_control(
			'item_media_type',
			[
				'label' => esc_html__( 'Item image type', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'image' => [
						'title' => esc_html__( 'Image', 'aihub-core' ),
						'icon' => 'eicon-image',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'aihub-core' ),
						'icon' => 'eicon-star-o',
					],
				],
				'default' => 'icon',
				'toggle' => false,
			]
		);

		$items_repeater->add_control(
			'item_icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'default' => [
					'value' => 'fab fa-squarespace',
					'library' => 'fa-brands',
				],
				'condition' => [
					'item_media_type' => 'icon'
				]
			]
		);

		$items_repeater->add_control(
			'item_image',
			[
				'label' => esc_html__( 'Choose image', 'aihub-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'item_media_type' => 'image'
				]
			]
		);

		$items_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'item_image_size',
				'default' => 'full',
				'condition' => [
					'item_media_type' => 'image'
				]
			]
		);

		$items_repeater->add_control(
			'item_position',
			[
				'label' => esc_html__( 'Position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-arrow-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-arrow-right',
					],
				],
				'render_type' => 'template',
				'default' => 'start',
				'toggle' => false
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $items_repeater->get_controls(),
				'default' => [
					[
						'item_title' => esc_html__( 'Squarespace', 'aihub-core' ),
						'item_media_type' => 'icon',
						'item_icon' => [
							'value' => 'fab fa-squarespace',
							'library' => 'fa-brands'
						],
						'item_position' => 'start'
					],
					[
						'item_title' => esc_html__( 'Wordpress', 'aihub-core' ),
						'item_media_type' => 'icon',
						'item_icon' => [
							'value' => 'fab fa-wordpress-simple',
							'library' => 'fa-brands'
						],
						'item_position' => 'start'
					],
					[
						'item_title' => esc_html__( 'Intercom', 'aihub-core' ),
						'item_media_type' => 'icon',
						'item_icon' => [
							'value' => 'fab fa-intercom',
							'library' => 'fa-brands'
						],
						'item_position' => 'start'
					],
					[
						'item_title' => esc_html__( 'Twitter', 'aihub-core' ),
						'item_media_type' => 'icon',
						'item_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands'
						],
						'item_position' => 'end'
					],
					[
						'item_title' => esc_html__( 'Amazon', 'aihub-core' ),
						'item_media_type' => 'icon',
						'item_icon' => [
							'value' => 'fab fa-amazon',
							'library' => 'fa-brands'
						],
						'item_position' => 'end'
					],
					[
						'item_title' => esc_html__( 'Mailchimp', 'aihub-core' ),
						'item_media_type' => 'icon',
						'item_icon' => [
							'value' => 'fab fa-mailchimp',
							'library' => 'fa-brands'
						],
						'item_position' => 'end'
					],
				],
				'title_field' => '{{{ item_title }}}',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'reverse_animation',
			[
				'label' => esc_html__( 'Reverse animation', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'integration',
			[
				'media_wrap' => [
					'label' => 'Main media',
					'controls' => [
						[
							'type' => 'liquid_linked_dimensions',
							'label' => 'Shape dimensions',
							'default' => [
								'width' => '155',
								'height' => '155',
								'unit' => 'px'
							],
							'css_var' => '--lqd-integration-m'
						],
						[
							'type' => 'liquid_background',
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-integration-m-br'
						],
						[
							'type' => 'border_radius',
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-integration-m-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '{{WRAPPER}}' ]
				],
				'item' => [
					'controls' => [
						[
							'type' => 'typography'
						],
						[
							'type' => 'font_size',
							'name' => 'icon_size',
							'label' => 'Icon size',
							'default' => [
								'size' => 1.1,
								'unit' => 'em'
							],
							'selector' => '.lqd-integration-item-media-wrap'
						],
						[
							'type' => 'gap',
							'name' => 'items_gap',
							'default' => [
								'size' => 22,
								'unit' => 'px'
							],
							'selector' => '.lqd-integration-items'
						],
						[
							'type' => 'gap',
							'name' => 'connector_gap',
							'label' => 'Connector and content gap',
							'default' => [
								'size' => 0.75,
								'unit' => 'em'
							]
						],
						[
							'type' => 'gap',
							'name' => 'content_gap',
							'default' => [
								'size' => 0.5,
								'unit' => 'em'
							],
							'selector' => '.lqd-integration-item-content'
						],
						[
							'type' => 'liquid_linked_dimensions',
							'name' => 'media_dimension',
							'css_var' => '--lqd-integration-item-m'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-integration-item-color'
						],
						[
							'type' => 'liquid_color',
							'name' => 'icon_color',
							'label' => 'Icon color',
							'css_var' => '--lqd-integration-item-m-color'
						],
						[
							'type' => 'liquid_color',
							'name' => 'connector_color',
							'label' => 'Connector color',
							'css_var' => '--lqd-integration-item-c-color'
						],
						[
							'type' => 'liquid_background_css',
							'name' => 'media_background',
							'css_var' => '--lqd-integration-item-m-bg'
						],
						[
							'type' => 'border',
							'name' => 'media_border',
							'css_var' => '--lqd-integration-item-m-br'
						],
						[
							'type' => 'border_radius',
							'name' => 'media_border_radius',
							'css_var' => '--lqd-integration-item-m-brr'
						],
						[
							'type' => 'box_shadow',
							'name' => 'media_box_shadow',
							'css_var' => '--lqd-integration-item-m-bs'
						],
					],
					'state_tabs' => [ 'normal', 'hover' ],
					'state_selectors_before' => [ 'hover' => '.lqd-integration-item' ]
				],
			],
		);

	}

	protected function render_item_image_image( $item ) {

		?>

		<span class="lqd-integration-item-media lqd-integration-item-image"><?php
			echo Group_Control_Image_Size::get_attachment_image_html( $item, 'item_image_size', 'item_image' );
		?></span>

		<?php

	}

	protected function render_item_image_icon( $item ) {

		?>

		<span class="lqd-integration-item-media lqd-integration-item-icon"><?php
			\LQD_Elementor_Helper::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		?></span>

		<?php

	}

	protected function render_item_image( $item ) {

		$media_type = $item['item_media_type'];
		$media_attrs_id = $this->get_repeater_setting_key( 'item_media_type', 'items', $item['_id'] );
		$media_classnames = [ 'lqd-integration-item-media-wrap', 'flex', 'items-center', 'justify-center', 'transition-colors' ];
		$item_pos = $item['item_position'];

		if ( $item_pos === 'start' ) {
			$media_classnames[] = '-order-1';
		}

		$this->add_render_attribute( $media_attrs_id, [
			'class' => $media_classnames
		] );

		?>

		<div <?php $this->print_render_attribute_string( $media_attrs_id ); ?>><?php
			$this->{ 'render_item_image_' . $media_type }( $item );
		?></div>

		<?php

	}

	protected function get_item_line( $item, $item_pos_in_array ) {

		$item_svg_attrs_id = $this->get_repeater_setting_key( 'item_svg', 'items', $item['_id'] );
		$svg_classnames = [ 'lqd-integration-item-connector', '-order-1', 'overflow-visible', 'lqd-transform', 'transition-colors' ];
		$duration = rand(2,8) . 's';
		$svg_mask_id = 'circle-border-' . $item['_id'];
		$animation_reversed = $this->get_settings_for_display('reverse_animation');
		$animation_dir = $animation_reversed ? 'keyPoints="1;0" keyTimes="0;1"' : '';

		if ( $item['item_position'] === 'end' ) {
			if ( $item_pos_in_array === 'middle' ) {
				$svg_classnames[] = 'flip-x';
			}
			if ( $item_pos_in_array === 'before_middle' ) {
				$svg_classnames[] = 'flip-y';
			}
		} else {
			if ( $item_pos_in_array !== 'middle' ) {
				if ( $item_pos_in_array === 'after_middle' ) {
					$svg_classnames[] = 'flip-x';
				} else {
					$svg_classnames[] = 'flip';
				}
			}
		}

		$this->add_render_attribute( $item_svg_attrs_id, [
			'class' => $svg_classnames,
		] );

		?>

		<?php if ( $item_pos_in_array !== 'middle' ) { ?>
		<svg <?php $this->print_render_attribute_string( $item_svg_attrs_id ); ?> width="127" height="82" viewBox="0 0 127 82" fill="none" stroke="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
			<defs>
				<mask id="<?php echo esc_attr( $svg_mask_id ); ?>">
					<path d="M2 2.02059C9.629 2.22859 25.2108 1.92059 39.9248 2.02059C41.8538 2.03359 43.8821 2.13661 46.2041 2.36861C47.3261 2.47961 48.75 2.66862 50.123 2.91762C59.423 4.57462 64.518 12.4566 64.583 18.8176V60.0896C64.583 60.0896 62.4827 80.0736 80.0127 80.5036C79.9057 80.5036 124.599 80.5036 124.759 80.5036" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" stroke="white"/>
					<circle r="8" fill="black">
						<animateMotion <?php echo $animation_dir ?> dur="<?php echo esc_attr( $duration ); ?>" repeatCount="indefinite" fill="freeze" path="M2 2.02059C9.629 2.22859 25.2108 1.92059 39.9248 2.02059C41.8538 2.03359 43.8821 2.13661 46.2041 2.36861C47.3261 2.47961 48.75 2.66862 50.123 2.91762C59.423 4.57462 64.518 12.4566 64.583 18.8176V60.0896C64.583 60.0896 62.4827 80.0736 80.0127 80.5036C79.9057 80.5036 124.599 80.5036 124.759 80.5036" />
					</circle>
				</mask>
			</defs>
			<path d="M2 2.02059C9.629 2.22859 25.2108 1.92059 39.9248 2.02059C41.8538 2.03359 43.8821 2.13661 46.2041 2.36861C47.3261 2.47961 48.75 2.66862 50.123 2.91762C59.423 4.57462 64.518 12.4566 64.583 18.8176V60.0896C64.583 60.0896 62.4827 80.0736 80.0127 80.5036C79.9057 80.5036 124.599 80.5036 124.759 80.5036" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" mask="url(#<?php echo esc_attr( $svg_mask_id ); ?>)"/>
			<circle class="lqd-integration-item-connector-circle" r="3" fill="currentColor" stroke-width="0">
				<animateMotion <?php echo $animation_dir ?> dur="<?php echo esc_attr( $duration ); ?>" repeatCount="indefinite" fill="freeze" path="M2 2.02059C9.629 2.22859 25.2108 1.92059 39.9248 2.02059C41.8538 2.03359 43.8821 2.13661 46.2041 2.36861C47.3261 2.47961 48.75 2.66862 50.123 2.91762C59.423 4.57462 64.518 12.4566 64.583 18.8176V60.0896C64.583 60.0896 62.4827 80.0736 80.0127 80.5036C79.9057 80.5036 124.599 80.5036 124.759 80.5036" />
			</circle>
		</svg>
		<?php } else { ?>
		<svg <?php $this->print_render_attribute_string( $item_svg_attrs_id ); ?> width="165" height="2" viewBox="0 0 165 2" fill="none" stroke="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
			<defs>
				<mask id="<?php echo esc_attr( $svg_mask_id ); ?>">
					<path d="M163.5 0 L 1.5 1" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" stroke="white"/>
					<circle r="8" fill="black">
						<animateMotion <?php echo $animation_dir ?> dur="<?php echo esc_attr( $duration ); ?>" repeatCount="indefinite" fill="freeze" path="M163.5 0 L 1.5 1" />
					</circle>
				</mask>
			</defs>
			<path d="M163.5 0 L 1.5 1" stroke-width="2.5" stroke-linecap="round" vector-effect="non-scaling-stroke" mask="url(#<?php echo esc_attr( $svg_mask_id ); ?>)"/>
			<circle class="lqd-integration-item-connector-circle" r="3" fill="currentColor" stroke-width="0">
				<animateMotion <?php echo $animation_dir ?> dur="<?php echo esc_attr( $duration ); ?>" repeatCount="indefinite" fill="freeze" path="M163.5 0 L 1.5 1" />
			</circle>
		</svg>
		<?php } ?>

		<?php

	}

	protected function render_item( $item, $total_items, $item_index ) {

		$item_attrs_id = $this->get_repeater_setting_key( 'item', 'items', $item['_id'] );
		$item_classnames = [ 'lqd-integration-item', 'flex', 'relative', 'transition-colors', 'elementor-repeater-item-' . $item['_id'] ];
		$item_pos_in_array = 'before_middle';

		if ( $item_index > floor( ( $total_items - 1 ) / 2 ) ) {
			$item_pos_in_array = 'after_middle';
		}
		if (
			( $item_index == floor( ( $total_items - 1 ) / 2 ) ) ||
			( $total_items % 2 == 0 && $item_index == floor( $total_items / 2 ) )
		) {
			$item_pos_in_array = 'middle';
		}

		if ( $item['item_position'] === 'start' ) {
			$item_classnames[] = 'flex-row-reverse';
		}
		if ( $item_pos_in_array === 'middle' ) {
			$item_classnames[] = 'items-center';
		} else if ( $item_pos_in_array === 'after_middle' ) {
			$item_classnames[] = 'items-end';
		} else {
			$item_classnames[] = 'items-start';
		}

		$this->add_render_attribute( $item_attrs_id, [
			'class' => $item_classnames,
			'data-lqd-integration-item-pos' => $item['item_position'],
			'data-lqd-integration-item-v-pos' => str_replace( [ '_' ], [ '-' ], $item_pos_in_array ),
		] );

		?>

		<div <?php $this->print_render_attribute_string( $item_attrs_id ) ?>>
			<?php $this->get_item_line( $item, $item_pos_in_array ); ?>
			<div class="lqd-integration-item-content flex items-center">
				<?php if ( !empty( $item['item_title'] ) ) :?>
					<span class="lqd-integration-item-title"><?php
						echo esc_html( $item['item_title'] );
					?></span>
				<?php endif; ?>
				<?php $this->render_item_image( $item ); ?>
			</div>
		</div>

		<?php

	}

	protected function render_items( $items, $pos = 'start' ) {

		$this->add_render_attribute( 'items_' . $pos, [
			'class' => [ 'lqd-integration-items', 'flex', 'flex-col', 'justify-between' ],
			'data-lqd-integration-items-pos' => $pos
		] );

		?>
		<div <?php $this->print_render_attribute_string( 'items_' . $pos ); ?>>
		<?php

		$item_index = 0;
		foreach ( $items as $item ) {
			$this->render_item( $item, count( $items ), $item_index );
			$item_index++;
		}

		?>
		</div>
		<?php

	}

	protected function render_main_image_image() {
		$settings = $this->get_settings_for_display();

		?>

		<span class="lqd-integration-media lqd-integration-image relative"><?php
			echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_size', 'image' );
		?></span>

		<?php

	}

	protected function render_main_image_icon() {
		$settings = $this->get_settings_for_display();

		?>

		<span class="lqd-integration-media lqd-integration-icon relative"><?php
			\LQD_Elementor_Helper::render_icon( $settings['icon'], [ 'aria-hidden' => 'true', 'class' => 'w-1em h-auto align-middle fill-current relative' ] );
		?></span>

		<?php

	}

	protected function render_main_image() {

		$settings = $this->get_settings_for_display();
		$media_type = $settings['media_type'];
		$media_classnames = [ 'lqd-integration-media-wrap', 'flex', 'items-center', 'justify-center', 'align-self-center', 'relative', 'z-1', 'overflow-hidden' ];

		$this->add_render_attribute( 'media', [
			'class' => $media_classnames
		] );

		?>

		<div <?php $this->print_render_attribute_string( 'media' ); ?>><?php
			$this->get_liquid_background( 'media_wrap_background' );
			if ( !empty( $settings['media_wrap_background_hover_liquid_background_items'] ) ): ?>
			<div class="lqd-bg-hover-wrap lqd-el-visible-on-hover rounded-inherit overflow-hidden">
				<?php $this->get_liquid_background( 'media_wrap_background_hover' ); ?>
			</div>
			<?php endif;
			$this->{ 'render_main_image_' . $media_type }();
		?></div>

		<?php

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();
		$classnames = [ 'lqd-widget-container-flex' ];

		$this->add_render_attribute( '_wrapper', [
			'class' => $classnames
		] );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items_array = $settings['items'];

		if ( empty( $items_array ) ) return;

		$start_items = array_filter( $items_array, function($item) {
			return $item['item_position'] === 'start';
		} );
		$end_items = array_filter( $items_array, function($item) {
			return $item['item_position'] === 'end';
		} );

		if ( !empty( $start_items ) ) {
			$this->render_items( $start_items, 'start' );
		};

		$this->render_main_image();

		if ( !empty( $end_items ) ) {
			$this->render_items( $end_items, 'end' );
		};


	}
}
\Elementor\Plugin::instance()->widgets_manager->register(new LQD_Integration());