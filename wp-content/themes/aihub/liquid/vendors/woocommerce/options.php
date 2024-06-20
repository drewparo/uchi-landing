<?php

add_action( 'liquid_option_sidebars', 'liquid_woocommerce_option_sidebars' );

function liquid_woocommerce_option_sidebars( $obj ) {

	// Product Sidebar
	$obj->sections[] = array(
		'title'  => esc_html__('Products', 'aihub'),
		'subsection' => true,
		'fields' => array(

			array(
				'id'       => 'wc-enable-global',
				'type'	   => 'button_set',
				'title'    => esc_html__( 'Activate Global Sidebar For Products', 'aihub' ),
				'subtitle' => esc_html__( 'Turn on if you want to use the same sidebars on all product posts. This option overrides the product options.', 'aihub' ),
				'options'  => array(
					'on'   => esc_html__( 'On', 'aihub' ),
					'off'  => esc_html__( 'Off', 'aihub' ),
				),
				'default' => 'off'
			),
			array(
				'id'       => 'wc-sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Global Products Sidebar', 'aihub' ),
				'subtitle' => esc_html__( 'Select sidebar that will display on all product posts.', 'aihub' ),
				'data'     => 'sidebars'
			),
			array(
				'id'       => 'wc-sidebar-position',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Global Products Sidebar Position', 'aihub' ),
				'subtitle' => esc_html__( 'Controls the position of the sidebar for all product posts.', 'aihub' ),
				'options'  => array(
					'left'  => esc_html__( 'Left', 'aihub' ),
					'right' => esc_html__( 'Right', 'aihub' )
				),
				'default' => 'right'
			),
		)
	);

	// Product Archive Sidebar
	$obj->sections[] = array(
		'title'  => esc_html__( 'Product Archive', 'aihub' ),
		'subsection' => true,
		'fields' => array(
			array(
				'id'       =>'wc-archive-sidebar-one',
				'type'     => 'select',
				'title'    => esc_html__( 'Product Archive Sidebar', 'aihub' ),
				'subtitle' => esc_html__( 'Select sidebar 1 that will display on the product archive pages.', 'aihub' ),
				'data'     => 'sidebars'
			),
			array(
				'id'       => 'wc-archive-sidebar-position',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Global Products Archive Sidebar Position', 'aihub' ),
				'subtitle' => esc_html__( 'Controls the position of the sidebar for all product archives.', 'aihub' ),
				'options'  => array(
					'left'  => esc_html__( 'Left', 'aihub' ),
					'right' => esc_html__( 'Right', 'aihub' )
				),
				'default' => 'right'
			),
			array(
				'id'       => 'wc-archive-shop-enable',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Show Sidebar on Shop Page', 'aihub' ),
				'subtitle' => esc_html__( 'Activate it on the WooCommerce shop page as well. WooCommerce > Settings > Products > Shop page', 'aihub' ),
				'options'  => array(
					'yes'  => esc_html__( 'Yes', 'aihub' ),
					'no' => esc_html__( 'No', 'aihub' )
				),
				'default' => 'no'
			),
			array(
				'id'       => 'wc-archive-sidebar-hide-mobile',
				'type'	   => 'button_set',
				'title'    => esc_html__( 'Hide sidebar on mobile devices?', 'aihub' ),
				'subtitle' => esc_html__( 'Turn on to hide the sidebar on mobile devices', 'aihub' ),
				'options'  => array(
					'yes'   => esc_html__( 'Yes', 'aihub' ),
					'no'  => esc_html__( 'No', 'aihub' )
				),
				'default'  => 'no'
			),

		)
	);

}