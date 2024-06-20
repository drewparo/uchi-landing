<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Gallery extends Widget_Base {

	public function get_name() {
		return 'lqd-gallery';
	}

	public function get_title() {
		return __( 'Liquid Gallery', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'gallery', 'image' ];
	}

	public function get_behavior() {

		$settings = $this->get_settings_for_display();
		$behavior = [];

		if ( !empty( $settings['look_mouse'] ) ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidLookAtMouseBehavior',
			];
		}

		if ( $settings['layout'] === 'masonry' ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidMasonryBehavior',
			];
		}

		if ( isset( $settings['lqd_hover_3d_intensity']['size'] ) && $settings['lqd_hover_3d_intensity']['size'] > 0 ) {
			$behavior[] = [
				'behaviorClass' => 'LiquidHover3dBehavior',
				'options' => [
					'intensity' => $settings['lqd_hover_3d_intensity']['size']
				]
			];
		}

		return $behavior;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'General', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => __( 'Add Images', 'aihub-core' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'grid' => esc_html__( 'Grid', 'aihub-core' ),
					'masonry' => esc_html__( 'Masonry', 'aihub-core' ),
				],
				'default' => 'grid',
			]
		);

		$this->add_responsive_control(
			'aspect_ratio',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Aspect Ratio', 'aihub-core' ),
				'default' => '3:2',
				'options' => [
					'1:1' => '1:1',
					'3:2' => '3:2',
					'4:3' => '4:3',
					'9:16' => '9:16',
					'16:9' => '16:9',
					'21:9' => '21:9',
				],
				'selectors_dictionary' => [
					'1:1' => '100%',
					'3:2' => '66.6666666667%',
					'4:3' => '75%',
					'9:16' => '177.7777777778%',
					'16:9' => '56.25%',
					'21:9' => '42.8571428571%',
				],
				'condition' => [
					'layout' => 'grid',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-gallery-figure' => '--lqd-aspect-ratio-p: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => esc_html__( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'file',
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'file' => esc_html__( 'Media File', 'aihub-core' ),
					'custom' => esc_html__( 'Custom URL', 'aihub-core' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'url',
			[
				'label' => esc_html__( 'URL', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'condition' => [
					'link_to' => 'custom',
				],
				'frontend_available' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'description' => sprintf(
					/* translators: 1: Link open tag, 2: Link close tag. */
					esc_html__( 'Manage your site’s lightbox settings in the %1$sLightbox panel%2$s.', 'aihub-core' ),
					'<a href="javascript: $e.run( \'panel/global/open\' ).then( () => $e.route( \'panel/global/settings-lightbox\' ) )">',
					'</a>'
				),
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'aihub-core' ),
					'yes' => esc_html__( 'Yes', 'aihub-core' ),
					'no' => esc_html__( 'No', 'aihub-core' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->add_responsive_control(
			'items_gap_grid',
			[
				'label' => esc_html__( 'Gap', 'aihub-core' ),
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-gallery' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout!' => 'masonry'
				]
			]
		);

		$this->add_responsive_control(
			'items_gap_masonry',
			[
				'label' => esc_html__( 'Gap', 'aihub-core' ),
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-gallery' => 'margin: 0 calc({{SIZE}}{{UNIT}} / 2 * -1);',
					'{{WRAPPER}} .lqd-gallery-item' => 'margin-bottom: {{SIZE}}{{UNIT}}; padding: 0 calc({{SIZE}}{{UNIT}} / 2)',
				],
				'condition' => [
					'layout' => 'masonry'
				]
			]
		);

		$this->add_responsive_control(
			'items_width',
			[
				'label' => esc_html__( 'Item width', 'aihub-core' ),
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
					'unit' => '%',
					'size' => 33.3,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-gallery-item' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'effects_section',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'lqd_hover_3d_intensity',
			[
				'label' => esc_html__( '3D hover intenisty', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.5
					]
				],
			]
		);

		$this->add_control(
			'look_mouse',
			[
				'label' => esc_html__( 'Look at cursor?', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( !$settings['gallery'] ) return;

		$layout = $settings['layout'];
		$img_class = 'lqd-gallery-img inline-flex';
		$hover3d_enabled = isset( $settings['lqd_hover_3d_intensity']['size'] ) && $settings['lqd_hover_3d_intensity']['size'] > 0;

		$this->add_render_attribute(
			'gallery_item',
			[
				'class' => [ 'lqd-gallery-item', 'lqd-masonry-item', 'flex', 'justify-center', 'relative' ],
			]
		);

		$this->add_render_attribute(
			'figure',
			[
				'class' => 'lqd-gallery-figure'
			]
		);

		if ( $layout === 'grid' ) {
			$this->add_render_attribute(
				'figure',
				[
					'class' => 'lqd-aspect-ratio-p w-full',
				]
			);
			$img_class .= ' w-full !h-full absolute top-0 start-0 object-cover object-center';
		}

		if ( !empty( $settings['look_mouse'] ) ) {
			$this->add_render_attribute(
				'figure',
				[
					'data-lqd-look-at-mouse' => 'true',
				]
			);
		}

		?>

		<div id="<?php echo esc_attr( 'lqd-gallery-' . $this->get_id() ); ?>" class="lqd-gallery lqd-masonry-container flex flex-wrap items-start relative">
			<?php
				foreach ( $settings['gallery'] as $image ) {
					$id = $image['id'];
					if ( $settings['link_to'] === 'file' ) {
						$href = wp_get_attachment_image_src( $id, 'full' )['0'];

						$this->add_render_attribute( 'gallery_item_' . $id, [
							'href' => $href,
							'data-elementor-lightbox-slideshow' => $this->get_id()
						] );

						if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
							$this->add_render_attribute( 'gallery_item_' . $id, 'class', 'elementor-clickable' );
						}

						$this->add_lightbox_data_attributes( 'gallery_item_' . $id, $this->get_id(), $settings['open_lightbox'] );
					} elseif ( 'custom' === $settings['link_to'] ) {
						$this->add_link_attributes( 'gallery_item_' . $id, $settings['url'] );
					}
				?>
					<div <?php $this->print_render_attribute_string('gallery_item') ?>>
						<?php if ( $hover3d_enabled ) : ?>
						<div class="lqd-transform-perspective" data-lqd-hover3d-el>
						<?php endif; ?>
						<figure <?php $this->print_render_attribute_string('figure') ?>>
							<?php if ( $settings['link_to'] === 'file' ) : ?>
							<a <?php $this->print_render_attribute_string( 'gallery_item_' . $id ); ?>>
							<?php endif; ?>
								<?php echo wp_get_attachment_image( $image['id'], 'full', false, [ 'class' => $img_class ] ); ?>
							<?php if ( $settings['link_to'] === 'file' ) : ?>
							</a>
							<?php endif; ?>
						<figure>
						<?php if ( $hover3d_enabled ) : ?>
						</div>
						<?php endif; ?>
					</div>
				<?php }//endforeach;
			?>
		</div>


		<?php

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Gallery() );