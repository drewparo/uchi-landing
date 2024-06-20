<?php
/**
 * LiquidThemes Theme Framework
 * Include the TGM_Plugin_Activation class and register the required plugins.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 */

liquid()->load_library( 'class-tgm-plugin-activation' );

/**
 * Register the required plugins for this theme.
 */
add_action( 'tgmpa_register', 'liquid_register_required_plugins' );

function liquid_register_required_plugins() {

	$images = get_template_directory_uri() . '/theme/plugins/images';

	$plugins = array(

		array(
			'name' 		         => esc_html__( 'AIHub Core', 'aihub' ),
			'slug' 		         => 'aihub-core',
			'required' 	         => true,
			'source'             => 'http://api.liquid-themes.com/download.php?type=plugins&file=aihub-core.zip',
			'liquid_logo'        => $images . '/one-core-min.png',
			'version'            => '1.3.2',
			'liquid_author'      => esc_html__( 'Liquid Themes', 'aihub' ),
			'liquid_description' => esc_html__( 'Intelligent and Powerful Elements Plugin, exclusively for Hub WordPress Theme.', 'aihub' ),
		),
		array(
			'name'               => esc_html__( 'Elementor', 'aihub' ),
			'slug'               => 'elementor',
			'required'           => true,
			'liquid_logo'        => $images . '/elementor.png',
			'liquid_author'      => esc_html__( 'Elementor.com', 'aihub' ),
			'liquid_description' => esc_html__( 'Introducing a WordPress website builder, with no limits of design. A website builder that delivers high-end page designs and advanced capabilities, never before seen on WordPress.', 'aihub' )
		),
		array(
			'name'               => esc_html__( 'Metform', 'aihub' ),
			'slug'               => 'metform',
			'required'           => false,
			'liquid_logo'        => $images . '/elementor.png',
			'liquid_author'      => esc_html__( 'Wpmet', 'aihub' ),
			'liquid_description' => esc_html__( 'MetForm, the contact form builder is an addon for Elementor, build any fast and secure contact form on the fly with its drag and drop builder.', 'aihub' )
		),
		array(
			'name'               => esc_html__( 'WooCommerce', 'aihub' ),
			'slug'               => 'woocommerce',
			'required'           => false,
			'liquid_logo'        => $images . '/woo-min.png',
			'liquid_author'      => esc_html__( 'Automattic', 'aihub' ),
			'liquid_description' => esc_html__( 'WooCommerce is the world’s most popular open-source eCommerce solution.', 'aihub' )
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
	);

	tgmpa( $plugins, $config );
}