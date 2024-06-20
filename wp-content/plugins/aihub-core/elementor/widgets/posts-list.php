<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LQD_Posts_List extends Widget_Base {

	public function get_name() {
		return 'lqd-posts-list';
	}

	public function get_title() {
		return __( 'Liquid Posts List', 'aihub-core' );
	}

	public function get_icon() {
		return 'eicon-posts-grid lqd-element';
	}

	public function get_categories() {
		return [ 'liquid-core' ];
	}

	public function get_keywords() {
		return [ 'blog', 'post', 'page', 'portfolio', 'list', 'grid', 'cpt', 'custom post type' ];
	}

	protected function add_render_attributes() {
		parent::add_render_attributes();
		$classnames = [ 'lqd-widget-container-flex', 'lqd-widget-container-flex-wrap' ];

		if ( empty( $this->get_settings_for_display( '_element_width' ) ) ) {
			$classnames[] = 'w-full';
		}

		if ( $this->get_settings_for_display( 'post_type' ) === 'product' ) {
			$classnames[] = 'woocommerce';
		}

		$this->add_render_attribute( '_wrapper', [
			'class' => $classnames
		] );
	}

	protected function get_liquid_background( $option_name = '', $content_template = false ) {

		$background = new \LQD_Elementor_Render_Background;
		if ( $content_template ){
			$background->render_template();
		} else {
			$background->render( $this, $this->get_settings_for_display(), $option_name );
		}

	}

    protected function get_data_source() {

		$postTypesList = [
			'post' => __( 'Posts', 'aihub-core' ),
			'ids' => __( 'List of IDs', 'aihub-core' ),
			'custom' => __( 'Custom Query', 'aihub-core' ),
			'related_posts' => __( 'Related Posts', 'aihub-core' ),
		];

		return $postTypesList;
	}

	protected function get_post_type() {

		$post_types = get_post_types(
			[
				'public' => true,
				'exclude_from_search' => false,
				'_builtin'  => false
			], 'objects'
		);

		$posts = [ 'post' => __( 'Post', 'aihub-core' ) ];

		foreach ( $post_types as $post_type ) {
			// exclude some post-types
			if ( ! in_array( $post_type->name, [ 'e-landing-page' ] ) ) {
				$posts[$post_type->name] = $post_type->labels->singular_name;
			}
		}

		return $posts;

	}

	protected function get_post( $post_type = 'post' ) {

		$get_posts = get_posts(
			[ 'post_type' => $post_type, 'posts_per_page' => -1 ]
		);

		$posts = [];
		foreach ( $get_posts as $post ) {
			$posts[$post->ID] = $post->post_title;
		}

		return $posts;

	}

	protected function get_taxonomies( $post_type ) {

		$args = [ 'object_type' => [ $post_type ] ];
		$output = 'objects'; // objects or names
		$operator = 'and'; // 'and' or 'or'
		$taxonomies = get_taxonomies( $args, $output, $operator );
		$tax = [];

		$exclude_taxonomies = [
			'product_tag',
			'product_cat',
			'product_type',
			'pa_color',
			'pa_size',
			'category',
			'post_tag',
			'liquid-portfolio-category',
			'liquid-listing-category',
		];

		if ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				if ( ! in_array( $taxonomy->name, $exclude_taxonomies ) ){
					$tax[$taxonomy->name] = $taxonomy->labels->name;
				}
			}
			return $tax;
		}

	}

	protected function get_cat( $post_type = 'post' ) {

		$args = [
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => true
		];

		if ( $post_type !== 'post'  ) {
			$args['taxonomy'] = $post_type . '-category';
		}

		$cats = get_categories( $args );

		$options = [];

		foreach ( $cats as $cat ) {
			$options[ $cat->cat_ID ] = $cat->name;
		}

		return $options;

	}

	protected function add_meta_controls( $state, $context, $selector, $meta_part = '', $condition = '', $is_dark = false ) {

		if ( $state === 'hover' ) {
			$selector .= ':hover';
		}

		if ( $is_dark ) {
			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} ' . $selector . ', ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} ' . $selector . ', ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} ' . $selector . '';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} ' . $selector . ':hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} ' . $selector . ':hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} ' . $selector . ':hover';
			}
		}

		if ( ! empty( $meta_part ) ) {
			$meta_part .= '_';
		}

		$context->add_control(
			( $is_dark ? 'dark_' : '' ) . 'meta_' . $meta_part . 'color' . ( $state === 'normal' ? '' : '_' . $state ),
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$selector => '--lqd-link-color: {{VALUE}}; color: {{VALUE}}',
				],
				'condition' => $condition
			]
		);

		$context->add_group_control(
			'liquid-background-css',
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . 'meta_' . $meta_part . 'background' . ( $state === 'normal' ? '' : '_' . $state ),
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
				'condition' => $condition
			]
		);

		$context->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . 'meta_' . $meta_part . 'border' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
				'condition' => $condition
			]
		);

		if ( !$is_dark ) {
			$context->add_responsive_control(
				'meta_' . $meta_part . 'border_radius' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( 'Border radius', 'aihub-core' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => $condition
				]
			);
		}

		$context->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . 'meta_' . $meta_part . 'box_shadow' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
				'condition' => $condition
			]
		);

	}

	protected function add_tabbed_controls( $selector, $part, $state, $is_dark = false ) {

		if ( $is_dark ) {
			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} ' . $selector . ', ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-post:hover .lqd-product-price, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-post:hover .lqd-product-price';
		} else {
			$selector = '{{WRAPPER}} ' . $selector;
		}

		$this->add_control(
			( $is_dark ? 'dark_' : '' ) . $part . '_color' . ( $state === 'normal' ? '' : '_' . $state ),
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$selector => 'color: {{VALUE}}',
				],
				'condition' => [
					'post_type' => 'product'
				]
			]
		);

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . $part . '_background' . ( $state === 'normal' ? '' : '_' . $state ),
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
				'condition' => [
					'post_type' => 'product'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . $part . '_border' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
				'condition' => [
					'post_type' => 'product'
				]
			]
		);

		if ( !$is_dark ) {
			$this->add_responsive_control(
			 $part	. '_border_radius' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( 'Border radius', 'aihub-core' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'post_type' => 'product'
					]
				]
			);
		}

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . $part . '_box_shadow' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
				'condition' => [
					'post_type' => 'product'
				]
			]
		);

	}

	protected function add_articles_controls( $state, $is_dark = false ) {

		$selector = '{{WRAPPER}} .lqd-post';

		if ( $state === 'hover' ) {
			$selector .= ':hover';
		}

		if ( $is_dark ) {
			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-post, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-post, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-post';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-post:hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-post:hover, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-post:hover';
			}
		}

		$this->add_group_control(
			'liquid-background-css',
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . 'articles_background' . ( $state === 'normal' ? '' : '_' . $state ),
				'label' => __( 'Background', 'aihub-core' ),
				'selector' => $selector,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . 'articles_border' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
			]
		);

		if ( !$is_dark ) {
			$this->add_responsive_control(
				'articles_border_radius' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( 'Border radius', 'aihub-core' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		}

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => ( $is_dark ? 'dark_' : '' ) . 'articles_box_shadow' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
			]
		);

	}

	protected function add_text_controls( $state, $text_part, $selector, $is_dark = false ) {

		$this->add_control(
			( $is_dark ? 'dark_' : '' ) . $text_part . '_color' . ( $state === 'normal' ? '' : '_' . $state ),
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => 'liquid-color',
				'types' => [ 'solid' ],
				'selectors' => [
					$selector => 'color: {{VALUE}}',
				],
			]
		);

	}

	protected function add_media_controls( $state ) {

		$selector = '{{WRAPPER}} .lqd-post-media';

		if ( $state === 'hover' ) {
			$selector = '{{WRAPPER}} .lqd-post:hover .lqd-post-media';
		}

		$this->add_group_control(
			'liquid-background',
			[
				'name' => 'media_overlay_background' . ( $state === 'normal' ? '' : '_' . $state ),
				'types' => [ 'color', 'particles', 'animated-gradient' ],
				'selector' => '{{WRAPPER}} .lqd-post-media-hover-bg',
				'fields_options' => [
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'media_border' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
			]
		);

		$this->add_responsive_control(
			'media_border_radius' . ( $state === 'normal' ? '' : '_' . $state ),
			[
				'label' => esc_html__( 'Border radius', 'aihub-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					$selector . ' img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'media_box_shadow' . ( $state === 'normal' ? '' : '_' . $state ),
				'selector' => $selector,
			]
		);

	}

	protected function register_controls() {

		$this->start_controls_section(
			'data_section',
			[
				'label' => __( 'Data', 'aihub-core' ),
			]
		);

		$this->add_control(
			'data_source',
			[
				'label' => __( 'Data source', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => self::get_data_source(),
			]
		);

		$this->add_control(
			'post_ids',
			[
				'label' => __( 'List of IDs', 'aihub-core' ),
				'placeholder' => __( 'Enter the any post id with comma. Example: 1,25,92', 'aihub-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'condition' => [
					'data_source' => [
                        'ids'
					],
				]
			]
		);

		$this->add_control(
			'custom_query',
			[
				'label' => esc_html__( 'Custom Query', 'aihub-core' ),
				'placeholder' => 'post_type=my-post-type&posts_per_page=4',
				'description' => sprintf( 'About the <a href="%s" target="_blank">WP_Query</a>', esc_url('https://developer.wordpress.org/reference/classes/wp_query/') ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'condition' => [
					'data_source' => [
                        'custom'
					],
				]
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Post type', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => self::get_post_type(),
				'condition' => [
                    'data_source!' => [
                        'ids',
						'custom'
					],
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __( 'Date', 'aihub-core' ),
					'ID' => __( 'Order by post ID', 'aihub-core' ),
					'author' => __( 'Author', 'aihub-core' ),
					'title' => __( 'Title', 'aihub-core' ),
					'modified' => __( 'Last modified date', 'aihub-core' ),
					'parent' => __( 'Post/page parent ID', 'aihub-core' ),
					'comment_count' => __( 'Number of comments', 'aihub-core' ),
					'menu_order' => __( 'Menu order/Page Order', 'aihub-core' ),
					'meta_value' => __( 'Meta value', 'aihub-core' ),
					'meta_value_num' => __( 'Meta value number', 'aihub-core' ),
					'rand' => __( 'Random order', 'aihub-core' ),
				],
                'condition' => [
                    'data_source!' => [
                        'ids',
						'custom'
					],
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Sort order', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __( 'Descending', 'aihub-core' ),
					'ASC' => __( 'Ascending', 'aihub-core' ),
				],
                'condition' => [
                    'data_source!' => [
                        'ids',
						'custom'
					],
				],
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label' => __( 'Meta key', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Input meta key for grid ordering.', 'aihub-core' ),
                'condition' => [
                    'orderby' => [
                        'meta_value',
						'meta_value_num',
					],
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Posts per page', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -1,
				'max' => 1000,
				'step' => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0,
                'condition' => [
                    'data_source!' => [
                        'ids',
						'custom'
					],
				],
			]
		);

		$this->add_control(
			'exclude_type',
			[
				'label' => __( 'Exclude type', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'aihub-core' ),
					'post' => __( 'Posts', 'aihub-core' ),
					'cat' => __( 'Category', 'aihub-core' ),
				],
				'condition' => [
                    'data_source!' => [
                        'ids',
						'custom'
					],
				],
			]
		);

		foreach ( self::get_post_type() as $key => $post ) {

			$this->add_control(
				$key . '_exclude_post',
				[
					'label' => __( 'Exclude', 'aihub-core' ),
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => self::get_post( $key ),
					'condition' => [
						'data_source!' => [
							'ids',
							'custom',
						],
						'exclude_type' => [
							'post'
						],
						'post_type' => [
							$key
						]
					],
				]
			);

			$this->add_control(
				$key . '_exclude_cat',
				[
					'label' => __( 'Exclude', 'aihub-core' ),
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => self::get_cat( $key ),
					'condition' => [
						'data_source!' => [
							'ids',
							'custom',
						],
						'exclude_type' => [
							'cat'
						],
						'post_type' => [
							$key
						]
					],
				]
			);

		}

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt length', 'aihub-core' ),
				'description' => __( 'Set the excerpt length. Leave blank to set default ( 20 words )', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '20',
				'placeholder' => __( '20', 'aihub-core' ),
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => esc_html__( 'Pagination', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'pagination' => [
						'title' => esc_html__( 'Pagination', 'aihub-core' ),
						'icon' => 'eicon-post-navigation',
					],
					// 'ajax' => [
					// 	'title' => esc_html__( 'Load More', 'aihub-core' ),
					// 	'icon' => 'eicon-button',
					// ],
				],
				'toggle' => true,
			]
		);

		$this->add_control(
			'ajax_trigger',
			[
				'label' => __( 'Ajax Trigger', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'click',
				'options' => [
					'click' => __( 'Click', 'aihub-core' ),
					'inview' => __( 'Inview', 'aihub-core' ),
				],
				'condition' => [
					'pagination' => 'ajax',
				]
			]
		);

		$this->add_control(
			'ajax_text',
			[
				'label' => __( 'Button Label', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Load more', 'aihub-core' ),
				'condition' => [
					'pagination' => 'ajax',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'aihub-core' ),
			]
		);

		$content_parts_repeater = new Repeater();

		$content_part_options = [
			'media' => esc_html__( 'Media', 'aihub-core' ),
			'title' => esc_html__( 'Title', 'aihub-core' ),
			'excerpt' => esc_html__( 'Excerpt', 'aihub-core' ),
			'meta' => esc_html__( 'Meta', 'aihub-core' ),
			'button' => esc_html__( 'Button', 'aihub-core' ),
		];

		if ( class_exists( 'WooCommerce' ) ){
			$content_part_options['price'] = esc_html__( 'Woo - Price', 'aihub-core' );
			$content_part_options['add_to_cart_btn'] = esc_html__( 'Woo - Add to cart button', 'aihub-core' );
		}

		$content_parts_repeater->add_control(
			'content_part',
			[
				'label'   => esc_html__( 'Content part', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'show_label' => false,
				'label_block' => true,
				'options' => $content_part_options,
				'default' => 'title'
			]
		);

		$meta_part_options = [
			'author' => esc_html__( 'Author', 'aihub-core' ),
			'time' => esc_html__( 'Time', 'aihub-core' ),
			'tags' => esc_html__( 'Tags', 'aihub-core' ),
			'categories' => esc_html__( 'Categories', 'aihub-core' ),
		];

		if ( function_exists('lha_helper') ) {
			$meta_part_options['lha_features'] = esc_html__( 'Listing Features', 'aihub-core' );
		}

		foreach ( self::get_post_type() as $key => $post ) {
			if ( ! empty( self::get_taxonomies( $key ) ) ) {
				$meta_part_options = array_merge($meta_part_options, self::get_taxonomies( $key ) );
			}
		}

		$content_parts_repeater->add_control(
			'meta_parts' ,
			[
				'label' => esc_html__( 'Meta parts', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $meta_part_options,
				'multiple' => true,
				'default' => [ 'time', 'categories' ],
				'condition' => [
					'content_part' => 'meta',
				]
			]
		);

		$content_parts_repeater->add_control(
			'meta_separator',
			[
				'label' => esc_html__( 'Parts separator', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'A character e.g. <b>,</b> <b>⏺</b> or an html element e.g. <b>&lt;i class="fa-solid fa-circle"&gt;&lt;/i&gt;</b>', 'aihub-core' ),
				'default' => '⏺',
				'condition' => [
					'content_part' => 'meta',
				]
			]
		);

		$content_parts_repeater->add_control(
			'meta_separator_size',
			[
				'label' => esc_html__( 'Separator size', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'size' => '0.5',
					'unit' => 'em'
				],
				'condition' => [
					'content_part' => 'meta',
					'meta_separator!' => ''
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-post-meta-separator' => 'font-size: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$content_parts_repeater->add_control(
			'meta_enable_author_avatar',
			[
				'label' => esc_html__( 'Enable author avatar', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'content_part' => 'meta',
					'meta_parts' => 'author'
				]
			]
		);

		$content_parts_repeater->add_control(
			'meta_categories_count',
			[
				'label' => esc_html__( 'Categories count', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '1',
				'condition' => [
					'content_part' => 'meta',
					'meta_parts' => 'categories'
				]
			]
		);

		$content_parts_repeater->add_control(
			'meta_categories_separator',
			[
				'label' => esc_html__( 'Categories separator', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'A character e.g. <b>,</b> <b>⏺</b> or an html element e.g. <b>&lt;i class="fa-solid fa-circle"&gt;&lt;/i&gt;</b>', 'aihub-core' ),
				'condition' => [
					'content_part' => 'meta',
					'meta_parts' => 'categories'
				]
			]
		);

		$content_parts_repeater->add_control(
			'meta_tags_count',
			[
				'label' => esc_html__( 'Tags count', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '1',
				'condition' => [
					'content_part' => 'meta',
					'meta_parts' => 'tags'
				]
			]
		);

		$content_parts_repeater->add_control(
			'meta_tags_separator',
			[
				'label' => esc_html__( 'Tags separator', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'A character e.g. <b>,</b> <b>⏺</b> or an html element e.g. <b>&lt;i class="fa-solid fa-circle"&gt;&lt;/i&gt;</b>', 'aihub-core' ),
				'condition' => [
					'content_part' => 'meta',
					'meta_parts' => 'tags'
				]
			]
		);

		$content_parts_repeater->add_responsive_control(
			'parts_gap',
			[
				'label' => esc_html__( 'Gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'vw' ],
				'default' => [
					'size' => '13',
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'gap: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$content_parts_repeater->add_control(
			'part_position',
			[
				'label' => __( 'Position', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'relative' => [
						'title' => esc_html__( 'Relative', 'aihub-core' ),
						'icon' => 'eicon-sign-out',
					],
					'absolute' => [
						'title' => esc_html__( 'Absolute', 'aihub-core' ),
						'icon' => 'eicon-square',
					],
				],
				'default' => 'relative',
				'toggle' => false,
				'separator' => 'before'
			]
		);

		$content_parts_repeater->add_control(
			'part_appear_on_hover',
			[
				'label' => __( 'Appear on hover', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'part_position' => 'absolute'
				]
			]
		);

		$content_parts_repeater->add_control(
			'part_position_based_on_media',
			[
				'label' => esc_html__( 'Position based on image', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'part_position' => 'absolute'
				]
			]
		);

		$content_parts_repeater->add_control(
			'part_absolute_with_thumbnail',
			[
				'label' => esc_html__( 'Absolute only for posts with thumbnail', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'part_position' => 'absolute'
				]
			]
		);

		$content_parts_repeater->add_control(
			'part_position_h',
			[
				'label' => esc_html__( 'Horizontal orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'start',
				'condition' => [
					'part_position' => 'absolute',
				],
			]
		);

		$content_parts_repeater->add_responsive_control(
			'part_offset_x',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.absolute' => 'inset-inline-start: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'part_position' => 'absolute',
					'part_position_h' => 'start'
				],
			]
		);

		$content_parts_repeater->add_responsive_control(
			'part_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.absolute' => 'inset-inline-end: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'part_position' => 'absolute',
					'part_position_h' => 'end'
				],
			]
		);

		$content_parts_repeater->add_control(
			'part_position_v',
			[
				'label' => esc_html__( 'Vertical orientation', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'aihub-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'aihub-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'condition' => [
					'part_position' => 'absolute',
				],
			]
		);

		$content_parts_repeater->add_responsive_control(
			'part_offset_y',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.absolute' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'part_position' => 'absolute',
					'part_position_v' => 'top'
				],
			]
		);

		$content_parts_repeater->add_responsive_control(
			'part_offset_y_bottom',
			[
				'label' => esc_html__( 'Offset', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.absolute' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'part_position' => 'absolute',
					'part_position_v' => 'bottom'
				],
			]
		);

		$content_parts_repeater->add_responsive_control(
			'part_margin',
			[
				'label'      => esc_html__( 'Margin', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.lqd-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_part' => 'meta',
				]
			]
		);

		$content_parts_repeater->add_responsive_control(
			'part_padding',
			[
				'label'      => esc_html__( 'Padding', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.lqd-post-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_part' => 'meta',
				]
			]
		);

		$content_parts_repeater->start_controls_tabs(
			'part_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$content_parts_repeater->start_controls_tab(
				'part_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
					'condition' => [
						'content_part' => 'meta'
					]
				]
			);

			$this->add_meta_controls(
				$state,
				$content_parts_repeater,
				'{{WRAPPER}} {{CURRENT_ITEM}}.lqd-post-meta',
				'',
				[ 'content_part' => 'meta' ]
			);

			$content_parts_repeater->end_controls_tab();

		}

		$content_parts_repeater->add_control(
			'part_enable_post_link',
			[
				'label' => esc_html__( 'Enable post link', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'content_part' => [ 'title', 'media' ],
				]
			]
		);

		lqd_elementor_add_button_controls( $content_parts_repeater, 'ib_', ['content_part' => 'button'], false, 'general', true );

		$content_parts_repeater->end_controls_tabs();

		$this->add_control(
			'content_parts',
			[
				'label' => esc_html__( 'Content parts', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $content_parts_repeater->get_controls(),
				'default' => [
					[ 'content_part' => 'media' ],
					[ 'content_part' => 'meta' ],
					[ 'content_part' => 'title' ],
				],
				'title_field' => '{{{ `${content_part.charAt(0).toUpperCase()}${content_part.substring(1).replace(/[-_]/g, " ")}` }}}',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title HTML tag', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h4',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'posts_list_effects',
			[
				'label' => __( 'Effects <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">⚡️<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_list_post_hover_effect',
			[
				'label' => esc_html__( 'Hover effect', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'aihub-core' ),
					'rise' => esc_html__( 'Rise', 'aihub-core' ),
					'scale-up' => esc_html__( 'Scale up', 'aihub-core' ),
					'scale-down' => esc_html__( 'Scale down', 'aihub-core' ),
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
				],
				'default' => '',
				'selectors_dictionary' => [
					'rise' => 'translateY(-10px)',
					'scale-up' => 'scale(1.05)',
					'scale-down' => 'scale(0.95)',
					'custom' => 'translate(var(--lqd-post-hover-x, 0),var(--lqd-post-hover-y, 0)) rotateX(var(--lqd-post-hover-rotate-x, 0)) rotateY(var(--lqd-post-hover-rotate-y, 0))  rotateZ(var(--lqd-post-hover-rotate-z, 0)) skewX(var(--lqd-post-hover-skew-x, 0)) skewY(var(--lqd-post-hover-skew-y, 0)) scale(var(--lqd-post-hover-scale, 1));',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-post:hover' => 'transform: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'posts_list_post_hover_effect_custom',
			[
				'label' => __( 'Effect', 'aihub-core' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'default' => 'yes',
				'condition' => [
					'posts_list_post_hover_effect' => 'custom'
				],
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_x',
			[
				'label' => __( 'Translate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 30,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-x: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_y',
			[
				'label' => __( 'Translate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-y: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_scale',
			[
				'label' => __( 'Scale', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-scale: {{SIZE}}'
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_skewX',
			[
				'label' => __( 'Skew X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-skewX: {{SIZE}}deg'
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_skewY',
			[
				'label' => __( 'Skew Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-skewY: {{SIZE}}deg'
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_rotateX',
			[
				'label' => __( 'Rotate X', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-rotateX: {{SIZE}}deg',
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_rotateY',
			[
				'label' => __( 'Rotate Y', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-rotateY: {{SIZE}}deg',
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->add_responsive_control(
			'posts_list_post_hover_effect_custom_rotateZ',
			[
				'label' => __( 'Rotate Z', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-post-hover-rotateZ: {{SIZE}}deg'
				],
				'condition' => [
					'posts_list_post_hover_effect_custom' => 'yes',
					'posts_list_post_hover_effect' => 'custom'
				]
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
		 'articles_styles',
			 [
			   'label' => esc_html__( 'Articles', 'aihub-core' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_responsive_control(
			'articles_width',
			[
				'label' => esc_html__( 'Width', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'size' => '31.57',
					'unit' => '%'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-post' => 'width: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'articles_gap',
			[
				'label' => esc_html__( 'Gap', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'custom' ],
				'default' => [
					'size' => '30',
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'gap: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'articles_margin',
			[
				'label'      => esc_html__( 'Margin', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'articles_padding',
			[
				'label'      => esc_html__( 'Padding', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'articles_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$this->start_controls_tab(
				'articles_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_articles_controls( $state );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
		 'title_styles',
			 [
			   'label' => esc_html__( 'Title', 'aihub-core' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label' => esc_html__( 'Text align', 'aihub-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'aihub-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'aihub-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'aihub-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-post-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label'   => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-post-title',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'title_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$selector = '{{WRAPPER}} .lqd-post-title, {{WRAPPER}} .lqd-post-title a';

			if ( $state === 'hover' ) {
				$selector = '{{WRAPPER}} .lqd-post:hover .lqd-post-title, {{WRAPPER}} .lqd-post:hover .lqd-post-title a';
			}

			$this->start_controls_tab(
				'title_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_text_controls( $state, 'title', $selector );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
		 'media_styles',
			 [
			   'label' => esc_html__( 'Media', 'aihub-core' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__( 'Image height', 'aihub-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'description' => esc_html__( 'This option does not crop the image. Just changes the CSS height property of the image.', 'aihub-core' ),
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-post-media' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .lqd-post-media-fig, {{WRAPPER}} .lqd-post-media img' => 'height: 100%'
				]
			]
		);

		$this->add_responsive_control(
			'media_margin',
			[
				'label'      => esc_html__( 'Margin', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post-media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'media_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$this->start_controls_tab(
				'media_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_media_controls( $state );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
		 'meta_styles',
			 [
			   'label' => esc_html__( 'Meta', 'aihub-core' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'label'   => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-post-meta',
			]
		);

		$this->add_responsive_control(
			'meta_margin',
			[
				'label'      => esc_html__( 'Margin', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_padding',
			[
				'label'      => esc_html__( 'Padding', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'meta_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$this->start_controls_tab(
				'meta_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_meta_controls( $state, $this, '{{WRAPPER}} .lqd-post-meta' );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
		 'excerpt_styles',
			 [
			   'label' => esc_html__( 'Excerpt', 'aihub-core' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'label'   => esc_html__( 'Typography', 'aihub-core' ),
				'selector' => '{{WRAPPER}} .lqd-post-excerpt',
			]
		);

		$this->add_responsive_control(
			'excerpt_margin',
			[
				'label'      => esc_html__( 'Margin', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_padding',
			[
				'label'      => esc_html__( 'Padding', 'aihub-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .lqd-post-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'excerpt_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$selector = '{{WRAPPER}} .lqd-post-excerpt';

			if ( $state === 'hover' ) {
				$selector = '{{WRAPPER}} .lqd-post:hover .lqd-post-excerpt';
			}

			$this->start_controls_tab(
				'excerpt_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_text_controls( $state, 'excerpt', $selector );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->end_controls_section();

		foreach( $meta_part_options as $meta_style_key => $meta_style ){
			$this->start_controls_section(
					$meta_style_key . '_items_styles',
					[
					  'label' => esc_html__( $meta_style, 'aihub-core' ),
					  'tab'   => Controls_Manager::TAB_STYLE,
					]
			   );

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => $meta_style_key . '_typography',
						'label'   => esc_html__( 'Typography', 'aihub-core' ),
						'selector' => '{{WRAPPER}} [data-lqd-post-meta-part=' . $meta_style_key . ']',
					]
				);

			   $this->add_responsive_control(
				   $meta_style_key . '_items_gap',
				   [
					   'label' => esc_html__( 'Gap', 'aihub-core' ),
					   'type' => Controls_Manager::SLIDER,
					   'size_units' => [ 'px', '%', 'vw' ],
					   'selectors' => [
						   '{{WRAPPER}} [data-lqd-post-meta-part=' . $meta_style_key . ']' => 'gap: {{SIZE}}{{UNIT}}',
					   ]
				   ]
			   );

			   $this->add_responsive_control(
				   $meta_style_key . '_items_margin',
				   [
					   'label'      => esc_html__( 'Margin', 'aihub-core' ),
					   'type'       => Controls_Manager::DIMENSIONS,
					   'size_units' => [ 'px', '%', 'em' ],
					   'selectors'  => [
						   '{{WRAPPER}} [data-lqd-post-meta-part=' . $meta_style_key . ']' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					   ],
				   ]
			   );

			   $this->add_responsive_control(
				   $meta_style_key . '_items_padding',
				   [
					   'label'      => esc_html__( 'Padding', 'aihub-core' ),
					   'type'       => Controls_Manager::DIMENSIONS,
					   'size_units' => [ 'px', '%', 'em' ],
					   'selectors'  => [
						   '{{WRAPPER}} [data-lqd-post-meta-part='. $meta_style_key . ']' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					   ],
				   ]
			   );

			   $this->start_controls_tabs(
				   $meta_style_key . '_items_style_tabs'
			   );

			   foreach ( [ 'normal', 'hover' ] as $state ) {

				   $this->start_controls_tab(
					   $meta_style_key . '_items_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
					   [
						   'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
					   ]
				   );

				   $this->add_meta_controls( $state, $this, '{{WRAPPER}} [data-lqd-post-meta-part=' . $meta_style_key . ']', $meta_style_key );

				   $this->end_controls_tab();

			   }

			   $this->end_controls_tabs();

			   $this->end_controls_section();
		}

		if ( class_exists( 'WooCommerce' ) ){

			$this->start_controls_section(
				'price_styles',
				[
					'label' => esc_html__( 'Price', 'aihub-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'price_typography',
					'label'   => esc_html__( 'Typography', 'aihub-core' ),
					'selector' => '{{WRAPPER}} .lqd-product-price',
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->add_responsive_control(
				'price_margin',
				[
					'label'      => esc_html__( 'Margin', 'aihub-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .lqd-product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->add_responsive_control(
				'price_padding',
				[
					'label'      => esc_html__( 'Padding', 'aihub-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .lqd-product-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->start_controls_tabs(
				'price_style_tabs'
			);

			foreach ( [ 'normal', 'hover' ] as $state ) {

				$selector = '.lqd-product-price';

				if ( $state === 'hover' ) {
					$selector = '.lqd-post:hover .lqd-product-price';
				}

				$this->start_controls_tab(
					'price_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
					[
						'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
					]
				);

				$this->add_tabbed_controls( $selector, 'price', $state );

				$this->end_controls_tab();

			}

			$this->end_controls_tabs();

			$this->end_controls_section();

			$this->start_controls_section(
				'add_to_cart_btn_styles',
				[
					'label' => esc_html__( 'Add to cart button', 'aihub-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'add_to_cart_btn_typography',
					'label'   => esc_html__( 'Typography', 'aihub-core' ),
					'selector' => '{{WRAPPER}} .lqd-product-btn .lqd-btn',
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->add_responsive_control(
				'add_to_cart_btn_margin',
				[
					'label'      => esc_html__( 'Margin', 'aihub-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .lqd-product-btn .lqd-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->add_responsive_control(
				'add_to_cart_btn_padding',
				[
					'label'      => esc_html__( 'Padding', 'aihub-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .lqd-product-btn .lqd-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'post_type' => 'product'
					]
				]
			);

			$this->start_controls_tabs(
				'add_to_cart_btn_style_tabs'
			);

			foreach ( [ 'normal', 'hover' ] as $state ) {

				$selector = '.lqd-product-btn .lqd-btn';

				if ( $state === 'hover' ) {
					$selector .= ':hover';
				}

				$this->start_controls_tab(
					'add_to_cart_btn_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
					[
						'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
					]
				);

				$this->add_tabbed_controls( $selector, 'add_to_cart_btn', $state );

				$this->end_controls_tab();

			}

			$this->end_controls_tabs();

			$this->end_controls_section();

		} // if class_exists( 'WooCommerce' )

		$this->start_controls_section(
			'dark_style_section',
			[
				'label' => __( 'Dark <span style="font-size: 1.5em; vertical-align:middle; margin-inline-start:0.35em;">🌘<span>', 'aihub-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dark_articles_style_heading',
			[
				'label' => esc_html__( 'Articles', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->start_controls_tabs(
			'dark_articles_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$this->start_controls_tab(
				'dark_articles_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_articles_controls( $state, true );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->add_control(
			'dark_title_style_heading',
			[
				'label' => esc_html__( 'Title', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs(
			'dark_title_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-post-title a, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-post-title a, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-post-title a';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-post:hover .lqd-post-title a, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-post:hover .lqd-post-title a, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-post:hover .lqd-post-title a';
			}

			$this->start_controls_tab(
				'dark_title_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_text_controls( $state, 'title', $selector, true );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->add_control(
			'dark_meta_style_heading',
			[
				'label' => esc_html__( 'Meta', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs(
			'dark_meta_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$this->start_controls_tab(
				'dark_meta_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_meta_controls( $state, $this, '.lqd-post-meta', '', '', true );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		$this->add_control(
			'dark_excerpt_style_heading',
			[
				'label' => esc_html__( 'Excerpt', 'aihub-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs(
			'dark_excerpt_style_tabs'
		);

		foreach ( [ 'normal', 'hover' ] as $state ) {

			$elementor_doc_selector = '.elementor';
			$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-post-excerpt, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-post-excerpt, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-post-excerpt';

			if ( $state === 'hover' ) {
				$selector = '[data-lqd-page-color-scheme=dark] {{WRAPPER}} .lqd-post:hover .lqd-post-excerpt, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark].elementor-element.elementor-element-{{ID}} .lqd-post:hover .lqd-post-excerpt, ' . $elementor_doc_selector . ' [data-lqd-color-scheme=dark] .elementor-element.elementor-element-{{ID}} .lqd-post:hover .lqd-post-excerpt';
			}

			$this->start_controls_tab(
				'dark_excerpt_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
				[
					'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
				]
			);

			$this->add_text_controls( $state, 'excerpt', $selector, true );

			$this->end_controls_tab();

		}

		$this->end_controls_tabs();

		foreach( $meta_part_options as $meta_style_key => $meta_style ) {
			$this->add_control(
				'dark_' . $meta_style_key . '_style_heading',
				[
					'label' => esc_html__( $meta_style, 'aihub-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			$this->start_controls_tabs(
				'dark_' . $meta_style_key . '_items_style_tabs'
			);

			foreach ( [ 'normal', 'hover' ] as $state ) {

				$this->start_controls_tab(
					'dark_' . $meta_style_key . '_items_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
					[
						'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
					]
				);

				$this->add_meta_controls( $state, $this, '[data-lqd-post-meta-part=' . $meta_style_key . ']', $meta_style_key, '', true );

				$this->end_controls_tab();

			}

			$this->end_controls_tabs();
		}

		if ( class_exists( 'WooCommerce' ) ){

			$this->add_control(
				'dark_price_style_heading',
				[
					'label' => esc_html__( 'Price', 'aihub-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			$this->start_controls_tabs(
				'dark_price_style_tabs'
			);

			foreach ( [ 'normal', 'hover' ] as $state ) {

				$selector = '.lqd-product-price';

				if ( $state === 'hover' ) {
					$selector = '.lqd-post:hover .lqd-product-price';
				}

				$this->start_controls_tab(
					'dark_price_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
					[
						'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
					]
				);

				$this->add_tabbed_controls( $selector, 'price', $state, true );

				$this->end_controls_tab();

			}

			$this->add_control(
				'dark_add_to_cart_btn_style_heading',
				[
					'label' => esc_html__( 'Add to cart button', 'aihub-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			$this->end_controls_tabs();

			$this->start_controls_tabs(
				'dark_add_to_cart_btn_style_tabs'
			);

			foreach ( [ 'normal', 'hover' ] as $state ) {

				$selector = '.lqd-product-btn .lqd-btn';

				if ( $state === 'hover' ) {
					$selector .= ':hover';
				}

				$this->start_controls_tab(
					'dark_add_to_cart_btn_style_tab' . ( $state === 'normal' ? '' : '_' . $state ),
					[
						'label' => esc_html__( strtoupper( $state ), 'aihub-core' ),
					]
				);

				$this->add_tabbed_controls( $selector, 'add_to_cart_btn', $state, true );

				$this->end_controls_tab();

			}

			$this->end_controls_tabs();

		} // if class_exists( 'WooCommerce' )

		$this->end_controls_section();

		// button styles
		lqd_elementor_add_button_controls( $this, 'ib_', [], false, 'style' );

	}

	protected function get_post_link_attrs( $post_id ) {

		$settings = $this->get_settings_for_display();
		$post_type = $settings['post_type'] ? $settings['post_type'] : $GLOBALS['wp_query']->query['post_type'];
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $post_id );
		$external_url_param = null;

		switch ( $post_type ) {
			case 'liquid-portfolio':
				$external_url_param = $page_settings_model->get_settings( 'portfolio_website' );
				break;
		}

		return ( $external_url_param && isset( $external_url_param['url'] ) && !empty( $external_url_param['url'] ) ) ?
			$external_url_param :
			[
				'url' => get_the_permalink(),
				'is_external' => '',
				'nofollow' => '',
				'custom_attributes' => ''
			];

	}

	protected function render_part_media( $settings, $part, $part_index, $post_id ) {

		if ( post_password_required() || is_attachment() || !has_post_thumbnail() ) {
			return '';
		}

		$css_position = $part['part_absolute_with_thumbnail'] && !has_post_thumbnail() ? 'relative' : $part['part_position'];
		$media_attrs_id = $this->get_repeater_setting_key( 'media', 'content_part', $part_index ) . '.' . $post_id;
		$fig_attrs_id = $media_attrs_id . '-fig';
		$media_classnames = [ 'lqd-post-media', $css_position, 'z-0', 'elementor-repeater-item-' . esc_attr( $part['_id'] ) ];
		$fig_classnames = [ 'lqd-post-media-fig', 'rounded-inherit' ];
		$media_link_attrs_id = $this->get_repeater_setting_key( 'media_link', 'content_part', $part_index ) . '.' . $post_id;

		if ( $css_position === 'absolute' ) {
			array_push( $media_classnames, 'h-full', 'rounded-inherit' );
			array_push( $fig_classnames, 'h-full', 'rounded-inherit' );
		}

		if ( $part['part_appear_on_hover'] === 'yes' ) {
			$media_classnames[] = 'lqd-post-part-visible-onhover';
			$media_classnames[] = 'transition-all';
		}

		$media_attrs = [
			'class' => $media_classnames
		];
		$fig_attrs = [
			'class' => $fig_classnames
		];

		$parts_inside_media = array_filter( $settings['content_parts'], function( $content_part ) {
			return $content_part['part_position_based_on_media'] === 'yes';
		} );

		$this->add_render_attribute( $media_attrs_id, $media_attrs );
		$this->add_render_attribute( $fig_attrs_id, $fig_attrs );

		if ( $part['part_enable_post_link'] === 'yes' ) {
			$this->add_link_attributes( $media_link_attrs_id, $this->get_post_link_attrs( $post_id ) );
		}

		?>
		<div <?php $this->print_render_attribute_string( $media_attrs_id ) ?>>
			<figure <?php $this->print_render_attribute_string( $fig_attrs_id ) ?>>
				<?php if ( $part['part_enable_post_link'] === 'yes' ) : ?>
				<a <?php $this->print_render_attribute_string( $media_link_attrs_id ) ?>>
				<?php endif; ?>
				<?php the_post_thumbnail( 'full', [ 'class' => 'w-full rounded-inherit object-cover object-center' ] ) ?>
				<?php if ( $part['part_enable_post_link'] === 'yes' ) : ?>
				</a>
				<?php endif; ?>
			</figure><?php
			if ( !empty( $settings['media_overlay_background_hover_liquid_background_items'] ) ): ?>
			<div class="lqd-bg-hover-wrap lqd-post-media-overlay-hover-bg rounded-inherit overflow-hidden opacity-0">
				<?php $this->get_liquid_background( 'media_overlay_background_hover' ); ?>
			</div>
			<?php endif;
			if ( !empty( $settings['media_overlay_background_liquid_background_items'] ) ) {
				$this->get_liquid_background( 'media_overlay_background' );
			}
			if ( !empty( $parts_inside_media ) ) {
				foreach( $parts_inside_media as $i => $part_in_media ) {
					$this->render_part( $settings, $part_in_media, $part_index + $i, $post_id, true );
				}
			} ?>
		</div>
		<?php

	}

	protected function render_part_title( $settings, $part, $part_index, $post_id ) {

		$css_position = $part['part_absolute_with_thumbnail'] && !has_post_thumbnail() ? 'relative' : $part['part_position'];
		$title_tag = Utils::validate_html_tag( $settings['title_tag'] );
		$title_attrs_id = $this->get_repeater_setting_key( 'title', 'content_part', $part_index ) . '.' . $post_id;
		$title_classnames = [ 'lqd-post-title', 'm-0', 'p-0', $css_position, 'z-1', 'elementor-repeater-item-' . esc_attr( $part['_id'] ) ];
		$title_link_attrs_id = $this->get_repeater_setting_key( 'title_link', 'content_part', $part_index ) . '.' . $post_id;

		if ( $part['part_appear_on_hover'] === 'yes' ) {
			$title_classnames[] = 'lqd-post-part-visible-onhover';
			$title_classnames[] = 'transition-all';
		}

		$title_attrs = [
			'class' => $title_classnames
		];

		$this->add_render_attribute( $title_attrs_id, $title_attrs );

		if ( $part['part_enable_post_link'] === 'yes' ) {
			$this->add_link_attributes( $title_link_attrs_id, $this->get_post_link_attrs( $post_id ) );
		}

		the_title(
			sprintf(
				'<%1$s %2$s>%3$s',
				$title_tag,
				$this->get_render_attribute_string( $title_attrs_id ),
				$part['part_enable_post_link'] === 'yes' ? sprintf( '<a class="transition-colors" %s>', $this->get_render_attribute_string( $title_link_attrs_id ) ) : ''
			),
			sprintf(
				'%2$s</%1$s>',
				$title_tag,
				$part['part_enable_post_link'] === 'yes' ? '</a>' : ''
			)
		);

	}

	protected function render_part_excerpt( $settings, $part, $part_index, $post_id ) {

		$css_position = $part['part_absolute_with_thumbnail'] && !has_post_thumbnail() ? 'relative' : $part['part_position'];
		$excerpt_attrs_id = $this->get_repeater_setting_key( 'excerpt', 'content_part', $part_index ) . '.' . $post_id;
		$excerpt_classnames = [ 'lqd-post-excerpt', 'm-0', 'p-0', $css_position, 'z-1', 'elementor-repeater-item-' . esc_attr( $part['_id'] ) ];

		if ( $part['part_appear_on_hover'] === 'yes' ) {
			$excerpt_classnames[] = 'lqd-post-part-visible-onhover';
			$excerpt_classnames[] = 'transition-all';
		}

		$excerpt_attrs = [
			'class' => $excerpt_classnames
		];

		$this->add_render_attribute( $excerpt_attrs_id, $excerpt_attrs );

		add_filter( 'excerpt_length', [ $this, 'excerpt_lengh' ], 999 );
		add_filter( 'excerpt_more', [ $this, 'excerpt_more' ] );

		?>
		<div <?php $this->print_render_attribute_string( $excerpt_attrs_id ) ?>><?php
			the_excerpt();
		?></div>
		<?php

	}

	protected function render_part_button( $settings, $part, $part_index, $post_id ) {

		//if ( $settings['show_button'] !== 'yes'	) return;

		$button_attrs_id = $this->get_repeater_setting_key( 'button', 'content_part', $part_index ) . '.' . $post_id;
		$button_classnames = [ 'lqd-post-btn', 'm-0', 'p-0', 'z-1', 'elementor-repeater-item-' . esc_attr( $part['_id'] ) ];

		$button_attrs = [
			'class' => $button_classnames
		];

		$this->add_render_attribute( $button_attrs_id, $button_attrs );

		?>
		<div <?php $this->print_render_attribute_string( $button_attrs_id ) ?>>
			<?php \LQD_Elementor_Render_Button::get_button( $this, 'ib_', $part ); ?>
		</div>
		<?php

	}

	protected function render_part_price( $settings, $part, $part_index, $post_id ) {

		if ( $settings['post_type'] !== 'product' ) return;

		$css_position = $part['part_absolute_with_thumbnail'] && !has_post_thumbnail() ? 'relative' : $part['part_position'];
		$price_attrs_id = $this->get_repeater_setting_key( 'price', 'content_part', $part_index ) . '.' . $post_id;
		$price_classnames = [ 'lqd-product-price', 'm-0', 'p-0', $css_position, 'z-1', 'transition-all', 'elementor-repeater-item-' . esc_attr( $part['_id'] ) ];

		if ( $part['part_appear_on_hover'] === 'yes' ) {
			$price_classnames[] = 'lqd-post-part-visible-onhover';
			$price_classnames[] = 'transition-all';
		}

		$price_attrs = [
			'class' => $price_classnames
		];

		$this->add_render_attribute( $price_attrs_id, $price_attrs );

		?>
		<div <?php $this->print_render_attribute_string( $price_attrs_id ) ?>><?php
			woocommerce_template_single_price();
		?></div>
		<?php

	}

	protected function render_part_add_to_cart_btn( $settings, $part, $part_index, $post_id ) {

		if ( $settings['post_type'] !== 'product' ) return;

		$css_position = $part['part_absolute_with_thumbnail'] && !has_post_thumbnail() ? 'relative' : $part['part_position'];
		$btn_attrs_id = $this->get_repeater_setting_key( 'price', 'content_part', $part_index ) . '.' . $post_id;
		$btn_classnames = [ 'lqd-product-btn', 'm-0', 'p-0', $css_position, 'z-1', 'elementor-repeater-item-' . esc_attr( $part['_id'] ) ];

		if ( $part['part_appear_on_hover'] === 'yes' ) {
			$btn_classnames[] = 'lqd-post-part-visible-onhover';
			$btn_classnames[] = 'transition-all';
		}

		$btn_attrs = [
			'class' => $btn_classnames
		];

		$this->add_render_attribute( $btn_attrs_id, $btn_attrs );

		?>
		<div <?php $this->print_render_attribute_string( $btn_attrs_id ) ?>><?php
			woocommerce_template_loop_add_to_cart();
		?></div>
		<?php

	}

	public function excerpt_lengh( $excerpt_length ) {

		$excerpt_length = $this->get_settings_for_display( 'excerpt_length' );

		if( !isset( $excerpt_length ) ) {
			return '20';
		}

		return $excerpt_length;

	}

	public function excerpt_more( $more ) {

		$excerpt_length = $this->get_settings_for_display( 'excerpt_length' );

		if( !isset( $excerpt_length ) ) {
			return $more;
		}

		return '';

	}

	protected function render_tax( $part, $list, $type, $sr_text, $rel ) {

		$separator = $part['meta_' . $type . '_separator'];
		$count_option = $part['meta_' . $type . '_count'];

		if ( ! is_array( $list ) ) return;

		if ( $count_option === 0 || count( $list ) === 0 ) return;

		if ( !empty( $count_option ) ) {
			$list = array_slice( $list, 0, $count_option );
		}

		?>

		<span class="screen-reader-text">
			<?php echo esc_html__( $sr_text, 'aihub-core' ) ?>
		</span>
		<?php foreach( $list as $i => $item ) : ?>
		<a href="<?php echo esc_attr( get_category_link( $item->term_id ) ); ?>" class="text-inherit rounded-inherit transition-colors" rel="<?php echo esc_attr( $rel ) ?>"><?php
			echo esc_html( $item->name );
			if ( !empty( $separator) && $i !== count( $list ) - 1 ) :
				?><span class="lqd-post-tax-separator"><?php echo $separator ; ?></span>
			<?php endif;
		?></a>
		<?php endforeach;

	}

	protected function render_meta_terms( $settings, $part, $post_id, $taxonomy ) {

		if ( $taxonomy === 'lha_features' ) {
			if ( function_exists('lha_helper') ){
				lha_helper()->entry_custom_meta( 'inline-flex items-center reset-ul inline-ul relative z-3' );
			}
		}

		if ( get_the_terms($post_id, $taxonomy) ){
			$this->render_tax( $part, get_the_terms($post_id, $taxonomy), 'tags', esc_html__( 'Tags', 'aihub-core' ), 'tag' );
		}

	}

	protected function render_meta_tags( $settings, $part, $post_id ) {

		switch ( $settings['post_type'] ) {
			case 'product':
				$term = get_the_terms( $post_id, 'product_tag' );
				break;
			default:
				$term = wp_get_post_tags( $post_id );
				break;
		}

		if ( $term ){
			$this->render_tax( $part, $term, 'tags', esc_html__( 'Tags', 'aihub-core' ), 'tag' );
		}

	}

	protected function render_meta_categories( $settings, $part, $post_id ) {

		$post_type = $settings['post_type'] ? $settings['post_type'] : $GLOBALS['wp_query']->query['post_type'];

		switch ( $post_type ) {
			case 'product':
				$term = get_the_terms( $post_id, 'product_cat' );
				break;
			case 'liquid-portfolio':
				$term = get_the_terms( $post_id, 'liquid-portfolio-category' );
				break;
			case 'liquid-listing':
				$term = get_the_terms( $post_id, 'liquid-listing-category' );
				break;
			default:
				$term = get_the_category( $post_id );
				break;
		}

		if ( $term ) {
			$this->render_tax( $part, $term, 'categories', esc_html__( 'Categories', 'aihub-core' ), 'category' );
		}

	}

	protected function render_meta_author_avatar() {

		echo get_avatar( get_the_author_meta( 'ID' ), '50', get_option( 'avatar_default', 'mystery' ), get_the_author(), [ 'class' => 'shrink-0 grow-0 basis-auto me-3' ] );

	}

	protected function render_meta_author_name() {

		echo get_the_author();

	}

	protected function render_meta_author( $settings, $part ) {

		if ( $part['meta_enable_author_avatar'] ) {
			$this->render_meta_author_avatar();
		}
		$this->render_meta_author_name();

	}

	protected function render_meta_time( $settings ) {

		printf( '<time class="lqd-post-date" datetime="%s">%s</time>', get_the_date( 'c' ), liquid_helper()->liquid_post_date() );

	}

	protected function render_part_meta( $settings, $part, $part_index, $post_id ) {

		$css_position = $part['part_absolute_with_thumbnail'] && !has_post_thumbnail() ? 'relative' : $part['part_position'];
		$meta_attrs_id = $this->get_repeater_setting_key( 'meta', 'content_part', $part_index ) . '.' . $post_id;
		$meta_classnames = [ 'lqd-post-meta', 'flex', 'flex-wrap', 'items-center', $css_position, 'z-1', 'transition-colors', 'elementor-repeater-item-' . esc_attr( $part['_id'] ) ];

		if ( $part['part_appear_on_hover'] === 'yes' ) {
			$meta_classnames[] = 'lqd-post-part-visible-onhover';
			$meta_classnames[] = 'transition-all';
		}

		$meta_attrs = [
			'class' => $meta_classnames
		];

		$meta_parts = $part['meta_parts'];
		$meta_separator = $part['meta_separator'];

		$this->add_render_attribute( $meta_attrs_id, $meta_attrs );

		if ( empty( $meta_parts ) ) return '';

		?>

		<div <?php $this->print_render_attribute_string( $meta_attrs_id ); ?>><?php
			foreach( $meta_parts as $i => $meta_part ) : ?>
				<span class="lqd-post-meta-part inline-flex flex-wrap items-center transition-colors" data-lqd-post-meta-part="<?php echo esc_attr( $meta_part ); ?>">
				<?php
					if ( in_array( $meta_part, [ 'time', 'author', 'tags', 'categories' ] ) ){
						$this->{'render_meta_' . $meta_part}( $settings, $part, $post_id, $meta_part );
					} else {
						$this->render_meta_terms( $settings, $part, $post_id, $meta_part );
					}
				?>
				</span><?php
				if ( !empty( $meta_separator ) && $i < count( $meta_parts ) -1 ) : ?>
					<span class="lqd-post-meta-separator"><?php echo $meta_separator ?></span>
				<?php endif;
			endforeach;
		?></div>

		<?php

	}

	protected function render_part( $settings, $part, $part_index, $post_id, $is_inside_media = false ) {

		$part_id = $part['_id'];
		$content_part = $part['content_part'];
		$part_position_based_on_media = $part['part_position_based_on_media'];

		if ( ! $is_inside_media && $part_position_based_on_media === 'yes' && has_post_thumbnail() ) return '';

		$this->{'render_part_' . $content_part}( $settings, $part, $part_index, $post_id );

	}

	protected function render_post( $settings ) {

		$content_parts = $settings['content_parts'];

		if ( empty( $content_parts ) ) return;

		$post_classnames = [ 'lqd-post', 'relative', 'transition-all' ];
		$post_id = get_the_ID();

		$attributes = [
			'id' => 'post-' . $post_id,
			'class' => join( ' ', get_post_class( $post_classnames, get_the_ID() ) ),
			'data-lqd-post-type' => esc_attr__( $settings['post_type'], 'aihub-core' )
		];

		$this->add_render_attribute( $post_id, $attributes );

		?>

		<article <?php $this->print_render_attribute_string( $post_id ) ?>><?php
			foreach ( $settings['content_parts'] as $part_index => $part ) {
				$this->render_part( $settings, $part, $part_index, $post_id );
			}
		?></article>

		<?php

	}

	// @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
	protected function build_query() {

		extract( $this->get_settings_for_display() );
		$settings = [];

		if( 'custom' === $data_source && ! empty( $custom_query ) ) {
			$query = html_entity_decode(  $custom_query , ENT_QUOTES, 'utf-8' );
			$settings = wp_parse_args( $query );
		}
		elseif( 'ids' === $data_source ) {

			if ( empty( $post_ids ) ) {
				$post_ids = - 1;
			}

			$incposts = wp_parse_id_list( $post_ids );
			$settings = [
				'post__in' => $incposts,
				'posts_per_page' => count( $incposts ),
				'post_type' => 'any',
				'orderby' => 'post__in',
			];
		}
		elseif( 'related_posts' === $data_source ) {

			$post_id = get_the_ID();

			$post_type = get_post_type( $post_id );
			$taxonomy = 'post' === $post_type ? 'category' : $post_type . '-category';

			$item_array = array();
			$item_cats = get_the_terms( $post_id, $taxonomy );
			if ( $item_cats ) {
				foreach( $item_cats as $item_cat ) {
					if ( isset($item_cat->term_id) ){
						$item_array[] = $item_cat->term_id;
					}
				}
			}
		
			$settings = [
				'post_type'				=> $post_type,
				'posts_per_page'		=> isset( $posts_per_page ) ? (int) $posts_per_page : 100,
				'post__not_in'			=> [ $post_id ],
				'ignore_sticky_posts'	=> 0,
				'tax_query'				=> [
					[
						'field'		=> 'id',
						'taxonomy'	=> $taxonomy,
						'terms'		=> $item_array
					]
				]
			];


		}
		else {
			$settings = [
				'posts_per_page' => isset( $posts_per_page ) ? (int) $posts_per_page : 100,
				'orderby' => $orderby,
				'order' => $order,
				'meta_key' => in_array( $orderby, [
					'meta_value',
					'meta_value_num',
				] ) ? $meta_key : '',
				'post_type' => $post_type,
				'ignore_sticky_posts' => true,
			];

			if ( !empty( $offset ) ){
				$settings['offset'] = $offset;
			}

			if ( empty( $pagination ) ) {
				$settings['no_found_rows'] = true;
			} else {
				$settings['paged'] = ld_helper()->get_paged();
			}

			if ( $settings['posts_per_page'] < 1 ) {
				$settings['posts_per_page'] = 1000;
			}

			// elementor pro archive filter
			if ( is_category() ){
				$settings['cat'] = get_the_category()[0]->term_id;
			}

			// exlude
			if ( $exclude_type === 'post' ) {
				$exclude = $this->get_settings_for_display($post_type . '_exclude_post');
			$settings['post__not_in'] = wp_parse_id_list( $exclude );
			} elseif ( $exclude_type === 'cat' ) {
				$taxonomies = $this->get_settings_for_display($post_type . '_exclude_cat');
				$terms = get_terms( [
					'hide_empty' => false,
					'include' => $taxonomies,
				] );
				$settings['tax_query'] = [];
				$tax_queries = []; // List of taxnonimes
				foreach ( $terms as $t ) {
					if ( ! isset( $tax_queries[ $t->taxonomy ] ) ) {
						$tax_queries[ $t->taxonomy ] = [
							'taxonomy' => $t->taxonomy,
							'field'    => 'id',
							'terms'    => [ $t->term_id ],
							'relation' => 'IN',
						];
					} else {
						$tax_queries[ $t->taxonomy ]['terms'][] = $t->term_id;
					}
				}
				$settings['tax_query'] = array_values( $tax_queries );
				$settings['tax_query']['relation'] = 'OR';
			}

		}

		$settings['post_status'] = 'publish';

		return $settings;

	}

	protected function render_pagination() {

		switch ( $this->get_settings_for_display( 'pagination' ) ) {
			case 'pagination':

				$max = $GLOBALS['wp_query']->max_num_pages;

				// Set up paginated links.
				$links = paginate_links( array(
					'type' => 'array',
					// 'format' => '?page=%#%',
					'prev_next' => true,
					'prev_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z"></path></svg>', 'landinghub-core' ), 'svg' ) . '</span>',
					'next_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>', 'landinghub-core' ), 'svg' ) . '</span>',
				) );

				if ( !empty( $links ) ) {
					printf( '<nav class="lqd-posts-nav w-full grid-span-full mt-40" aria-label="Page navigation"><ul class="lqd-posts-nav-ul flex items-center list-none gap-6 m-0 p-0"><li class="lqd-posts-nav-li">%s</li></ul></nav>', join( "</li>\n\t<li class=\"lqd-posts-nav-li\">", $links ) );
				}

				break;

			case 'ajax':

				$unique_id = 'blog-id-' . $this->get_id_int();
				$ajax_wrapper = '.' . $unique_id;
				$hash = [
					'ajax' => 'lqd-btn lqd-btn-md ajax-load-more',
				];

				$url = get_next_posts_page_link( $GLOBALS['wp_query']->max_num_pages );
				$attributes = [
					'href' => add_query_arg( 'ajaxify', '1', $url ),
					'rel' => 'nofollow',
					'data-ajaxify' => true,
					'data-ajaxify-options' => json_encode( [
						'wrapper' => '.elementor-element-'. $this->get_id() .' > .elementor-widget-container',
						'items'   => 'article',
						'trigger' => $this->get_settings_for_display( 'ajax_trigger' ),
				 	] )
				];

				echo '<div class="lqd-posts-nav lqd-posts-nav-ajax"><nav aria-label="' . esc_attr__( 'Page navigation', 'landinghub-core' ) . '">';

				$ajax_text = $this->get_settings_for_display( 'ajax_text' );
				$attributes['class'] = 'lqd-btn lqd-ajax-loadmore whitespace-nowrap';
				printf( '<a%2$s><span class="static block">%1$s</span><span class="loading block absolute"><span class="dots block"><span class="inline-block"></span><span class="inline-block"></span><span class="inline-block"></span></span><span class="block mt-1">' . esc_html__( 'Loading', 'landinghub-core' ) . '</span></span><span class="all-loaded block absolute">' . esc_html__( 'All items loaded', 'landinghub-core' ) . ' <svg width="32" height="29" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 29" style="width: 1.5em; height: 1.5em; margin-inline-start: 0.5em;"><path fill="currentColor" d="M25.74 6.23c0.38 0.34 0.42 0.9 0.09 1.28l-12.77 14.58a0.91 0.91 0 0 1-1.33 0.04l-5.46-5.46a0.91 0.91 0 1 1 1.29-1.29l4.77 4.78 12.12-13.85a0.91 0.91 0 0 1 1.29-0.08z"></path></svg></span></a>', $ajax_text, ld_helper()->html_attributes( $attributes ), $url );
				break;

				echo '</nav></div>';

				break;

		}

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		// Build Query
		$GLOBALS['wp_query'] = new \WP_Query( $this->build_query() );

		if ( have_posts() ) {
			while( have_posts() ): the_post();
				$this->render_post( $settings );
			endwhile;
			$this->render_pagination();
			wp_reset_query();
		} else {
			echo esc_html_e( 'Sorry, no posts matched your criteria.' );
		}

	}

}
\Elementor\Plugin::instance()->widgets_manager->register( new LQD_Posts_List() );