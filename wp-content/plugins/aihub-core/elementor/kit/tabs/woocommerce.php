<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_WooCommerce extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-woocommerce-kit';
	}

	public function get_title() {
		return __( 'WooCommerce', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_general',
			[
				'label' => esc_html__('General WooCommerce', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_wc_archive_product_style',
			[
				'label' => esc_html__( 'Category product style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'aihub-core' ),
					'classic' => esc_html__( 'Classic', 'aihub-core' ),
					'classic-alt' => esc_html__( 'Classic 2', 'aihub-core' ),
					'minimal' => esc_html__( 'Minimal', 'aihub-core' ),
					'minimal-2' => esc_html__( 'Minimal 2', 'aihub-core' ),
					'minimal-hover-shadow' => esc_html__( 'Minimal Hover Shadow', 'aihub-core' ),
					'minimal-hover-shadow-2' => esc_html__( 'Minimal Hover Shadow 2', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_wc_products_per_page',
			[
				'label' => esc_html__( 'Product per page', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => true,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 9,
			]
		);

		$this->add_control(
			'liquid_wc_columns',
			[
				'label' => esc_html__( 'Product per row', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => true,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 3,
			]
		);

		// $this->add_control(
		// 	'liquid_wc_ajax_filter',
		// 	[
		// 		'label' => esc_html__( 'Ajax filter', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_ajax_pagination',
		// 	[
		// 		'label' => esc_html__( 'Ajax pagination', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_ajax_pagination_type',
		// 	[
		// 		'label' => esc_html__( 'Ajax pagination type', 'aihub-core' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'label_block' => true,
		// 		'default' => 'classic',
		// 		'options' => [
		// 			'classic' => esc_html__( 'Classic', 'aihub-core' ),
		// 			'scroll' => esc_html__( 'Scroll', 'aihub-core' ),
		// 			'button' => esc_html__( 'Button', 'aihub-core' ),
		// 		],
		// 		'condition' => [
		// 			'liquid_wc_ajax_pagination' => 'on',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_ajax_pagination_button_text',
		// 	[
		// 		'label' => esc_html__( 'Ajax pagination button text', 'aihub-core' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => esc_html__( 'Load more products', 'aihub-core' ),
		// 		'placeholder' => esc_html__( 'Load more products', 'aihub-core' ),
		// 		'condition' => [
		// 			'liquid_wc_ajax_pagination' => 'on',
		// 			'liquid_wc_ajax_pagination_type' => 'button',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_archive_breadcrumb',
		// 	[
		// 		'label' => esc_html__( 'Breadcrumb', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_archive_grid_list',
		// 	[
		// 		'label' => esc_html__( 'Show Grid/List option', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_archive_sorter_enable',
		// 	[
		// 		'label' => esc_html__( 'Show Sorter by option', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_archive_show_number',
		// 	[
		// 		'label' => esc_html__( 'Show products limiter option', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_archive_result_count',
		// 	[
		// 		'label' => esc_html__( 'Show result count', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_archive_image_gallery',
		// 	[
		// 		'label' => esc_html__( 'Show gallery on product hover', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_archive_show_product_cats',
		// 	[
		// 		'label' => esc_html__( 'Show widgetized side drawer', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_widget_side_drawer_label',
		// 	[
		// 		'label' => esc_html__( 'Side drawer label', 'aihub-core' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => esc_html__( 'Filter Products', 'aihub-core' ),
		// 		'placeholder' => esc_html__( 'Filter Products', 'aihub-core' ),
		// 		'condition' => [
		// 			'liquid_wc_archive_show_product_cats' => 'on',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_widget_side_drawer_sidebar_id',
		// 	[
		// 		'label' => esc_html__( 'Side drawer widget', 'aihub-core' ),
		// 		'description' => esc_html__( 'Choose the widgetized area to display in the side drawer.', 'aihub-core' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'label_block' => true,
		// 		'default' => 'main',
		// 		'options' => liquid_helper()->get_sidebars(),
		// 		'condition' => [
		// 			'liquid_wc_archive_show_product_cats' => 'on',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'liquid_wc_widget_side_drawer_mobile',
		// 	[
		// 		'label' => esc_html__( 'Show on mobile only?', 'aihub-core' ),
		// 		'description' => esc_html__( 'Show the widgetized side drawer only for mobile devices?', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'yes',
		// 		'default' => '',
		// 		'condition' => [
		// 			'liquid_wc_archive_show_product_cats' => 'on',
		// 		],
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_' . $this->get_id() . '_single',
			[
				'label' => esc_html__('Product Single', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_wc_product_page_style',
			[
				'label' => esc_html__( 'Single product style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '0',
				'options' => [
					'0' => esc_html__( 'Default', 'aihub-core' ),
					'1' => esc_html__( 'Style 1', 'aihub-core' ),
					'2' => esc_html__( 'Style 2', 'aihub-core' ),
					'3' => esc_html__( 'Style 3', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_wc_custom_layout_enable',
			[
				'label' => esc_html__( 'Custom product layout', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$layout = liquid_helper()->get_available_custom_post( 'ld-product-layout' );

		if ( !empty( $layout ) ){
			$this->add_control(
				'liquid_wc_custom_layout',
				[
					'label' => esc_html__( 'Product layout', 'aihub-core' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					//'default' => '0',
					'options' => $layout,
					'condition' => [
						'liquid_wc_custom_layout_enable' => 'on',
					],
				]
			);
		} else {
			$this->add_control(
				'liquid_wc_custom_layout',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no Product in your site.</strong><br>Go to the <a href="%2$s" target="_blank">%1$s</a> to create one.', 'plugin_name' ), 'Product Layout', admin_url( 'edit.php?post_type=ld-product-layout' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition' => [
						'liquid_wc_custom_layout_enable' => 'on',
					],
				]
			);
		}

		// $this->add_control(
		// 	'liquid_wc_add_to_cart_ajax_enable',
		// 	[
		// 		'label' => esc_html__( 'Ajax add to cart', 'aihub-core' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'On', 'aihub-core' ),
		// 		'label_off' => esc_html__( 'Off', 'aihub-core' ),
		// 		'return_value' => 'on',
		// 		'default' => '',
		// 	]
		// );

		$this->add_control(
			'liquid_wc_share_enable',
			[
				'label' => esc_html__( 'Product share', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->add_control(
			'liquid_wc_related_columns',
			[
				'label' => esc_html__( 'Number of related products columns', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => true,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'liquid_wc_cross_sell_columns',
			[
				'label' => esc_html__( 'Number of displayed cross-sells columns', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => true,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 2,
			]
		);

		$this->add_control(
			'liquid_wc_up_sell_columns',
			[
				'label' => esc_html__( 'Number of displayed up-sells columns', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => true,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_' . $this->get_id() . '_social_links',
			[
				'label' => esc_html__('Product Social Share Links', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$social_links_items = new \Elementor\Repeater();

		$social_links_items->add_control(
			'type',
			[
				'label' => esc_html__( 'Type', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'label_block' => true,
				'options' => [
					'custom' => esc_html__( 'Custom', 'aihub-core' ),
					'facebook' => esc_html__( 'Facebook', 'aihub-core' ),
					'twitter'  => esc_html__( 'Twitter', 'aihub-core' ),
					'linkedin' => esc_html__( 'Linkedin', 'aihub-core' ),
					'pinterest' => esc_html__( 'Pinterest', 'aihub-core' ),
				],
			]
		);

		$social_links_items->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'aihub-core' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
				'condition' => [
					'type' => 'custom'
				]
			]
		);

		$social_links_items->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'aihub-core' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'elementor',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mix',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				]
			]
		);

		$this->add_control(
			'liquid_wc_social_links',
			[
				'label' => esc_html__( 'Social Links', 'aihub-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $social_links_items->get_controls(),
				'default' => [
					[
						'icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
						'type' => 'facebook'
					],
					[
						'icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
						'type' => 'twitter'
					],
					[
						'icon' => [
							'value' => 'fab fa-pinterest',
							'library' => 'fa-brands',
						],
						'type' => 'pinterest'
					],
					[
						'icon' => [
							'value' => 'fab fa-linkedin',
							'library' => 'fa-brands',
						],
						'type' => 'linkedin'
					],
				],
				'title_field' => '{{{ elementor.helpers.renderIcon( this, icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}}',

			]
		);

		$this->add_control(
			'liquid_wc_social_link_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-social-icon-wc li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_wc_social_link_hover_color',
			[
				'label' => esc_html__( 'Hover color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-social-icon-wc li a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_WooCommerce( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-woocommerce-kit', Liquid_Global_WooCommerce::class );
	}
);
