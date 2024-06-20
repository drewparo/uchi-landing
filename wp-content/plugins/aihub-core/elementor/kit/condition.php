<?php

defined( 'ABSPATH' ) || die();
use Elementor\Controls_Manager;

class Liquid_Page_Condition {

    public static function add_condition_controls( $prefix, $prefix2, $option_name, $cpt ){

        switch ( $cpt ){
            case 'liquid-header':
                $section_label = esc_html__( 'Header Manager', 'aihub-core' );
                $title = esc_html__( 'Header', 'aihub-core' );
            break;
            case 'liquid-footer':
                $section_label = esc_html__( 'Footer Manager', 'aihub-core' );
                $title = esc_html__( 'Footer', 'aihub-core' );
            break;
            case 'liquid-title-wrapper':
                $section_label = esc_html__( 'Title Wrapper Manager', 'aihub-core' );
                $title = esc_html__( 'Title Wrapper', 'aihub-core' );
            break;
        }

		$cache_option_name = 'liquid_' . strtolower($title) . '_cache';

        $prefix->start_controls_section(
            'section_' . $prefix->get_id(),
            [
                'label' => $section_label,
                'tab' => $prefix->get_id(),
            ]
        );

        $prefix->add_control(
            $option_name.'_enable',
            [
                'label' => esc_html__( 'Enable', 'aihub-core' ) . ' ' . $title,
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'aihub-core' ),
                'label_off' => esc_html__( 'Off', 'aihub-core' ),
                'return_value' => 'on',
                'default' => 'on',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Rule title', 'aihub-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Rule' , 'aihub-core' ),
                'label_block' => true,
            ]
        );

        $get_cpt = liquid_helper()->get_available_custom_post( $cpt );
        if ( ! empty( $get_cpt ) ) {

            $repeater->add_control(
                'cpt_id',
                [
                    'label' => $title,
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    //'default' => array_key_first( $get_cpt ),
                    'options' => $get_cpt,
                ]
            );

        } else {
            $repeater->add_control(
                'cpt_id',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf( __( '<strong>There are no %1$s in your site.</strong><br>Go to the <a href="%2$s" target="_blank">%1$s</a> to create one.', 'aihub-core' ), $title, admin_url( 'edit.php?post_type=' . $cpt ) ),
                    'separator' => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'default' => 0,
                ]
            );
        }

        $repeater->add_control(
            'condition',
            [
                'label' => esc_html__( 'Archive', 'aihub-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'entire',
                'label_block' => true,
                'options' => [
                    'entire'  => esc_html__( 'Entire Site', 'aihub-core' ),
                    'archives' => esc_html__( 'Archives', 'aihub-core' ),
                    'singular' => esc_html__( 'Singular', 'aihub-core' ),
                    'woocommerce' => esc_html__( 'Woocommerce', 'aihub-core' ),
                ],
            ]
        );

        $cpts = apply_filters( 'liquid_condition_cpt', array( 'post', 'liquid-portfolio' ) );

        $archive_items = array(
            'all' => esc_html__( 'All', 'aihub-core' ),
            'author' => esc_html__( 'Author', 'aihub-core' ),
            'cats' => esc_html__( 'Category', 'aihub-core' ),
            'tags' => esc_html__( 'Tags', 'aihub-core' ),
        );

        foreach ( $cpts as $cpt ) {
            $archive_items[$cpt] = get_post_type_object( $cpt )->labels->archives;
        }

        $repeater->add_control(
            'archives_condition',
            [
                'label' => esc_html__( 'Show Elements', 'aihub-core' ),
                'type' => Controls_Manager::SELECT,
                //'multiple' => true,
                'label_block' => true,
                'options' => $archive_items,
                'default' => [ 'all' ],
                'condition' => [
                    'condition' => 'archives',
                ]
            ]
        );

        $repeater->add_control(
            'woocommerce_condition',
            [
                'label' => esc_html__( 'Show Elements', 'aihub-core' ),
                'type' => Controls_Manager::SELECT,
                //'multiple' => true,
                'label_block' => true,
                'options' => [
                    'all' => esc_html__( 'All', 'aihub-core' ),
                    'archive' => esc_html__( 'Product Archives', 'aihub-core' ),
                    'shop' => esc_html__( 'Shop Page', 'aihub-core' ),
                    'cats' => esc_html__( 'Product Categories', 'aihub-core' ),
                    'tags' => esc_html__( 'Product Tags', 'aihub-core' ),
                    'products' => esc_html__( 'Single Products', 'aihub-core' ),
                    'product' => esc_html__( 'Single Product', 'aihub-core' ),
                ],
                'default' => [ 'all' ],
                'condition' => [
                    'condition' => 'woocommerce',
                ]
            ]
        );

        $singular_items = array(
            'all' => esc_html__( 'All', 'aihub-core' ),
            'front-page' => esc_html__( 'Front Page', 'aihub-core' ),
            'pages' => esc_html__( 'Pages', 'aihub-core' ),
            'search' => esc_html__( 'Seach Results', 'aihub-core' ),
            'page-404' => esc_html__( '404 Page', 'aihub-core' ),
        );

        foreach ( $cpts as $cpt ) {
            $singular_items[$cpt] = get_post_type_object( $cpt )->labels->singular_name;
        }

        //print_r($singular_items);

        $repeater->add_control(
            'singular_condition',
            [
                'label' => esc_html__( 'Show Elements', 'aihub-core' ),
                'type' => Controls_Manager::SELECT,
                //'multiple' => true,
                'label_block' => true,
                'options' => $singular_items,
                'default' => [ 'all' ],
                'condition' => [
                    'condition' => 'singular',
                ]
            ]
        );

        $repeater->add_control(
            'singular_page_condition',
            [
                'label' => esc_html__( 'Show Elements', 'aihub-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => liquid_helper()->get_available_custom_post( 'page' ),
                'condition' => [
                    'condition' => 'singular',
                    'singular_condition' => [ 'pages' ]
                ]
            ]
        );

        foreach ( $cpts as $cpt ) {
            $repeater->add_control(
                'singular_' . $cpt . '_condition',
                [
                    'label' => esc_html__( 'Show Elements '.$cpt, 'aihub-core' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'label_block' => true,
                    'options' => liquid_helper()->get_available_custom_post( $cpt ),
                    'condition' => [
                        'condition' => 'singular',
                        'singular_condition' => [ $cpt ]
                    ]
                ]
            );
        }

        $repeater->add_control(
            'singular_product_condition',
            [
                'label' => esc_html__( 'Show Elements', 'aihub-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => liquid_helper()->get_available_custom_post( 'product' ),
                'condition' => [
                    'condition' => 'woocommerce',
                    'woocommerce_condition' => [ 'product' ]
                ]
            ]
        );

		$exlude_items = array(
            'entire' => esc_html__( 'Entire Site', 'aihub-core' ),
			'front-page' => esc_html__( 'Front Page', 'aihub-core' ),
            'pages' => esc_html__( 'Pages', 'aihub-core' ),
            'search' => esc_html__( 'Seach Results', 'aihub-core' ),
            'page-404' => esc_html__( '404 Page', 'aihub-core' ),
			'author' => esc_html__( 'Author Archives', 'aihub-core' ),
			'cats' => esc_html__( 'Category Archives', 'aihub-core' ),
			'tags' => esc_html__( 'Tag Archives', 'aihub-core' ),
			'woo_all' => esc_html__( 'Entire WooCommerce', 'ai-hub-core' ),
			'woo_archive' => esc_html__( 'WooCommerce Archive', 'ai-hub-core' ),
			'woo_shop' => esc_html__( 'WooCommerce Shop', 'ai-hub-core' ),
			'woo_cats' => esc_html__( 'WooCommerce Categories', 'ai-hub-core' ),
			'woo_tags' => esc_html__( 'WooCommerce Tags', 'ai-hub-core' ),
			'woo_products' => esc_html__( 'WooCommerce Products', 'ai-hub-core' ),
        );

        foreach ( $cpts as $cpt ) {
            $exlude_items[$cpt] = get_post_type_object( $cpt )->labels->archives;
        }

		$repeater->add_control(
            'exclude',
            [
                'label' => esc_html__( 'Exclude', 'aihub-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
				'separator' => 'before',
                'options' => $exlude_items
            ]
        );

        $prefix->add_control(
            $option_name,
            [
                'label' => esc_html__( 'Rules', 'aihub-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

		if ( in_array( $cache_option_name, ['liquid_header_cache', 'liquid_footer_cache'] ) ) {
			$prefix->add_control(
				$cache_option_name,
				[
					'label' =>  $title . ' ' . esc_html__( 'Cache', 'aihub-core' ),
					'description' =>  esc_html__( 'This improves the performance. If you get any error or break something, disable it.', 'aihub-core' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'aihub-core' ),
					'label_off' => esc_html__( 'Off', 'aihub-core' ),
					'return_value' => 'on',
					'default' => 'on',
					'separator' => 'before',
				]
			);
		}

        $prefix->end_controls_section();

    }

    public static function render_condition( $rules ){

        $id = '';

        $rules = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( $rules );

        if ( ! $rules ){
            //return;
        }

        foreach ( $rules as $rule ) {

			if ( ! isset($rule['cpt_id'])){
				return;
			}

			$cpt_id = $rule['cpt_id'];
			$condition = $rule['condition'];
			$archives_condition = is_array($rule['archives_condition']) ? 'all' : $rule['archives_condition'];
			$singular_condition = is_array($rule['singular_condition']) ? 'all' : $rule['singular_condition'];
			$woocommerce_condition = is_array($rule['woocommerce_condition']) ? 'all' : $rule['woocommerce_condition'];
			$singular_page_condition = $rule['singular_page_condition'];
			$singular_post_condition = $rule['singular_post_condition'];
			$singular_product_condition = $rule['singular_product_condition'];

			$exlude = is_array($rule['exclude']) ? $rule['exclude'] : array();

            $cpts = apply_filters( 'liquid_condition_cpt', array( 'post', 'liquid-portfolio' ) );


			switch ($condition) {
				// entire
				case 'entire':
					$id = $cpt_id;
				break;
				// archives
				case 'archives':
					if ( is_archive() && $archives_condition === 'all' ) {
						$id = $cpt_id;
					} elseif ( is_author() && $archives_condition === 'author' ){
						$id = $cpt_id;
					} elseif ( is_category() && $archives_condition === 'cats' ){
						$id = $cpt_id;
					} elseif ( is_tag() && $archives_condition === 'tags' ){
						$id = $cpt_id;
					} else  {
                        foreach ( $cpts as $cpt ) {
                            if ( is_archive() && $archives_condition === $cpt && get_post_type() === $cpt ) {
                                $id = $cpt_id;
                            }
                        }
                    }
					break;
				// singular
				case 'singular':
					if ( is_singular() ) {
						if ( is_page() && $singular_condition === 'pages' ){
							//$id = $cpt_id;
							if ( ! empty( $singular_page_condition ) && is_page($singular_page_condition ) ){
								$id = $cpt_id;
							} elseif( empty( $singular_page_condition ) && is_page($singular_page_condition ) ){ // page is not selected: Show on all pages
								$id = $cpt_id;
							}
						} elseif ( is_single() && in_array( $singular_condition, $cpts ) ){
                            foreach ( $cpts as $cpt ) {
                            	if ( $singular_condition === $cpt && get_post_type() == $singular_condition ){
                                    if ( ! empty( $rule['singular_' . $cpt . '_condition']) && in_array( get_the_ID(), $rule['singular_' . $cpt . '_condition'] ) ){
                                        $id = $cpt_id;
                                    } elseif ( empty( $rule['singular_' . $cpt . '_condition'] ) ) { // post is selected: Show on all posts
										$id = $cpt_id;
									}
                                }
                            }
						} elseif ( $singular_condition === 'all' ){
							$id = $cpt_id;
						} elseif ( is_front_page() && $singular_condition === 'front-page' ){
							$id = $cpt_id;
						}
                    } elseif ( is_search() && $singular_condition === 'search' ) {
                        $id = $cpt_id;
                    } elseif ( is_404() && $singular_condition === 'page-404') {
                        $id = $cpt_id;
                    }
				break;
				// woocommerce
				case 'woocommerce':
					if ( class_exists( 'WooCommerce' ) ){
						if ( $woocommerce_condition === 'all' && ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
							$id = $cpt_id;
						} elseif ( $woocommerce_condition === 'archive' && ( is_product_category() || is_product_tag() ) ){
							$id = $cpt_id;
						} elseif ( $woocommerce_condition === 'shop' && is_shop() ){
							$id = $cpt_id;
						} elseif ( $woocommerce_condition === 'cats' && is_product_category() ){
							$id = $cpt_id;
						} elseif ( $woocommerce_condition === 'tags' && is_product_tag() ){
							$id = $cpt_id;
						} elseif ( $woocommerce_condition === 'products' && is_product() ){
							$id = $cpt_id;
						} elseif ( $woocommerce_condition === 'product' && is_product() && ( array_search( get_the_ID() , $singular_product_condition ) !== false ) ){
							$id = $cpt_id;
						}
					}
				break;
			}

			// Exclude
			if (
				(in_array('entire', $exlude)) ||
				(in_array('front-page', $exlude) && is_front_page()) ||
				(in_array('pages', $exlude) && is_singular()) ||
				(in_array('search', $exlude) && is_search()) ||
				(in_array('page-404', $exlude) && is_404()) ||
				(in_array('author', $exlude) && is_author()) ||
				(in_array('cats', $exlude) && is_category()) ||
				(in_array('tags', $exlude) && is_tag()) ||
				(class_exists( 'WooCommerce' ) &&
					(
						( in_array('woo_all', $exlude) && ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) ) ||
						( in_array('woo_archive', $exlude) && ( is_product_category() || is_product_tag() ) ) ||
						( in_array('woo_shop', $exlude) && is_shop() ) ||
						( in_array('woo_cats', $exlude) && is_product_category() ) ||
						( in_array('woo_tags', $exlude) && is_product_tag() ) ||
						( in_array('woo_products', $exlude) && is_product() )
					)
				)
			) {
				$id = '';
			} elseif (is_single()) {
				foreach ($cpts as $cpt) {
					if (in_array($cpt, $exlude)) {
						$id = '';
						break;
					}
				}
			}

		}

        return $id;

    }

}