<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Header_Search extends Widget_Base {

	public function get_name() {
		return 'lqd-search';
	}

	public function get_title() {
		return __( 'Liquid Search', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-search lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'search', 'form' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$el_id = $this->get_id();
		$behavior = [];

		$behavior[] = [
			'behaviorClass' => 'LiquidToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdSearchToggle-$el_id'",
				'toggleAllTriggers' => 'true',
				'ignoreEnterOnFocus' => 'true',
				'toggleOffOnEscPress' => 'true',
				'toggleOffOnOutsideClick' => 'true',
				'triggerElements' => [
					"'click @togglableTriggers'",
				]
			]
		];
		$behavior[] = [
			'behaviorClass' => 'LiquidEffectsSlideToggleBehavior',
			'options' => [
				'changePropPrefix' => "'lqdSearchToggle-$el_id'",
			]
		];

		return $behavior;
	}

	protected function register_controls() {

		// General Section
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Header search', 'aihub-core' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => [
					'classic' => __( 'Classic', 'aihub-core' ),
					'slide' => __( 'Slide', 'aihub-core' ),
				],
				'prefix_class' => 'lqd-search-style-',
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'search_type',
			[
				'label' => __( 'Search by', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => [
					'all'  => __( 'All', 'aihub-core' ),
					'post'  => __( 'Post', 'aihub-core' ),
					'product' => __( 'Product', 'aihub-core' ),
					'custom' => __( 'Custom', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'custom_search_type',
			[
				'label' => __( 'Custom post type', 'aihub-core' ),
				'description' => __( 'Enter the custom post type slug', 'aihub-core' ),
				'placeholder' => 'my-post-type-slug',
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'search_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Type and hit enter', 'aihub-core' ),
				'placeholder' => __( 'Description under serchform', 'aihub-core' ),
			]
		);

		$this->end_controls_section();

		\LQD_Elementor_Helper::add_style_controls(
			$this,
			'search',
			[
				'container' => [
					'controls' => [
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-search-dropdown-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-search-dropdown-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-search-dropdown-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-search-dropdown-bs'
						],
					],
					'plural_heading' => false,
				],
				'input' => [
					'label' => 'Input',
					'controls' => [
						[
							'type' => 'padding',
							'css_var' => '--lqd-search-input-p'
						],
						[
							'type' => 'liquid_color',
							'css_var' => '--lqd-search-input-color'
						],
						[
							'type' => 'liquid_background_css',
							'css_var' => '--lqd-search-input-bg'
						],
						[
							'type' => 'border',
							'css_var' => '--lqd-search-input-br'
						],
						[
							'type' => 'border_radius',
							'css_var' => '--lqd-search-input-brr'
						],
						[
							'type' => 'box_shadow',
							'css_var' => '--lqd-search-input-bs'
						],
					],
					'plural_heading' => false,
					'state_tabs' => [ 'normal', 'focus' ],
				],
			],
		);

		\LQD_Elementor_Trigger::register_controls( $this, 'ib_' );

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$style = $settings['style'];
		$search_type = $settings['search_type'];
		$dropdown_classname = [ 'lqd-dropdown', 'lqd-search-dropdown', 'lqd-togglable-element', 'hidden', 'w-full', 'flex-col', 'overflow-hidden', 'backface-hidden', '[&.lqd-is-active:flex]' ];
		$input_icon_classname = [ 'lqd-input-icon', 'inline-block', 'absolute', 'top-1/2', 'lqd-transform', '-translate-y-1/2' ];

		if ( $search_type == 'custom' && empty( $settings['custom_search_type'] ) ) {
			$search_type = 'all';
		} else if ( $search_type == 'custom' && !empty( $settings['custom_search_type'] ) ) {
			$search_type = $settings['custom_search_type'];
		}

		if ( $style === 'slide' ) {
			$dropdown_classname[] = 'h-full fixed top-0 start-0 end-0';
			$input_icon_classname[] = 'end-0';
		} else {
			$dropdown_classname[] = 'absolute end-0';
			$input_icon_classname[] = 'start-0';
		}

		$this->add_render_attribute( 'dropdown', [
			'class' => $dropdown_classname
		] );

		$this->add_render_attribute( 'input_icon', [
			'class' => $input_icon_classname
		] );

		\LQD_Elementor_Trigger::render( $this, 'ib_' );
		?>

		<div <?php $this->print_render_attribute_string( 'dropdown' ) ?>>
			<div class="lqd-search-container flex flex-col justify-center h-full mx-auto backface-hidden">
				<form class="lqd-search-form w-full relative leading-none" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
					<input class="lqd-search-input w-full transition-colors" type="search" placeholder="<?php echo esc_attr_x( 'Start searching', 'placeholder', 'aihub-core' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
					<span <?php $this->print_render_attribute_string( 'input_icon' ) ?>>
						<?php if ( $style === 'classic' ) : ?>
						<svg class="w-1em h-1em" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ai ai-Search"><path d="M21 21l-4.486-4.494M19 10.5a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0z"/></svg>
						<?php elseif ( $style === 'slide' ) : ?>
							<?php \LQD_Elementor_Trigger::render( $this, 'ib_' ); ?>
						<?php endif; ?>
					</span>
					<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type  ); ?>" />
				</form>
			</div>
		</div>

		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Header_Search() );