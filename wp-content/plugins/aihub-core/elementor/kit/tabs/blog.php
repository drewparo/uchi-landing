<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_Blog extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-blog-kit';
	}

	public function get_title() {
		return __( 'Blog', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-archive';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_archives',
			[
				'label' => esc_html__('General Blog', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_blog_date_format',
			[
				'label' => esc_html__( 'Blog Date Format', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ago',
				'options' => [
					'ago' => esc_html__( 'Time ago', 'aihub-core' ),
					'wp' => esc_html__( 'Wordpress Date Format (WP Settings > General)', 'aihub-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_' . $this->get_id() . '_single',
			[
				'label' => esc_html__('Blog Single', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_blog_single_post_style',
			[
				'label' => esc_html__( 'Post style', 'aihub-core' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'wide',
				'options' => [
					'wide' => esc_html__( 'Wide', 'aihub-core' ),
					'modern-full-screen' => esc_html__( 'Modern Full Screen', 'aihub-core' ),
					'dark' => esc_html__( 'Wide title overlay', 'aihub-core' ),
				],
			]
		);

		$this->add_control(
			'liquid_blog_single_post_date',
			[
				'label' => esc_html__( 'Post meta date', 'aihub-core' ),
				'description' => esc_html__( 'Switch on to display the post date on single post pages.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->add_control(
			'liquid_blog_single_post_author',
			[
				'label' => esc_html__( 'Post meta author', 'aihub-core' ),
				'description' => esc_html__( 'Switch on to display the post author on single post pages.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->add_control(
			'liquid_blog_single_reading_time',
			[
				'label' => esc_html__( 'Post meta reading time', 'aihub-core' ),
				'description' => esc_html__( 'Will display the text about time needs to read the article.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
				'condition' => [
					'liquid_blog_single_author_box_enable' => 'on'
				]
			]
		);

		$this->add_control(
			'liquid_blog_single_reading_time_label',
			[
				'label' => __( 'Label', 'aihub-core' ),
				'description' => __( 'Add label after the reading time', 'aihub-core' ),
				'default' => __( 'min read', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'liquid_blog_single_reading_time' => 'on'
				]
			]
		);

		$this->add_control(
			'liquid_blog_single_author_box_enable',
			[
				'label' => esc_html__( 'Author meta', 'aihub-core' ),
				'description' => esc_html__( 'Switch on to display the author info box on single post pages.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->add_control(
			'liquid_blog_single_author_role_enable',
			[
				'label' => esc_html__( 'Author role', 'aihub-core' ),
				'description' => esc_html__( 'Turn on to display the author role in info box below posts.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
			]
		);

		$this->add_control(
			'liquid_blog_single_navigation_enable',
			[
				'label' => esc_html__( 'Neighbour posts', 'aihub-core' ),
				'description' => esc_html__( 'Switch on to display the previous post and next post on single post pages.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->add_control(
			'liquid_blog_single_archive_link',
			[
				'label' => esc_html__( 'Blog archive link', 'aihub-core' ),
				'description' => esc_html__( 'Custom link to post on navigation to link to the default blog archive.', 'aihub-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'aihub-core' ),
				'default' => [
					'url' => '',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'liquid_blog_single_related_enable',
			[
				'label' => esc_html__( 'Related posts', 'aihub-core' ),
				'description' => esc_html__( 'Display the related posts on single posts.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);
		
		$this->add_control(
			'liquid_blog_single_related_template',
			[
				'label' => esc_html__( 'Releted posts template', 'aihub-core' ),
				'description' => esc_html__( 'Liquid Templates > Archives', 'aihub-core' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => false,
				'options' => liquid_helper()->get_available_custom_post( 'liquid-archives' ),
				'condition' => [
					'liquid_blog_single_related_enable' => 'on'
				]
			]
		);

		$this->add_control(
			'liquid_blog_single_related_title',
			[
				'label' => esc_html__( 'Title of related posts', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'You may also like', 'aihub-core' ),
				'condition' => [
					'liquid_blog_single_related_enable' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_blog_single_related_number',
			[
				'label' => esc_html__( 'Related posts quantity', 'aihub-core' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'condition' => [
					'liquid_blog_single_related_enable' => 'on',
				],
			]
		);

		$this->add_control(
			'liquid_blog_single_social_box_enable',
			[
				'label' => esc_html__( 'Social sharing', 'aihub-core' ),
				'description' => esc_html__( 'Display the social sharing box on single post pages.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'aihub-core' ),
				'label_off' => esc_html__( 'Hide', 'aihub-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_' . $this->get_id() . '_social_links',
			[
				'label' => esc_html__('Blog Social Share Links', 'aihub-core'),
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
			'liquid_blog_single_social_links',
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
			'liquid_blog_single_social_link_color',
			[
				'label' => esc_html__( 'Color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-social-icon-blog li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'liquid_blog_single_social_link_hover_color',
			[
				'label' => esc_html__( 'Hover color', 'aihub-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-social-icon-blog li a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_Blog( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-blog-kit', Liquid_Global_Blog::class );
	}
);
