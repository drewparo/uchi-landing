<?php
/**
 * Merlin WP configuration file.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new Merlin(

	$config = array(
		'directory'            => 'merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'liquid-setup', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'liquid', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => true, // EDD license activation step.
		'license_required'     => true, // Require the license activation step.
		'license_help_url'     => 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => home_url( '/' ), // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Setup Wizard', 'aihub' ),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'aihub' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'aihub' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'aihub' ),

		'btn-skip'                 => esc_html__( 'Skip', 'aihub' ),
		'btn-next'                 => esc_html__( 'Next', 'aihub' ),
		'btn-start'                => esc_html__( 'Start', 'aihub' ),
		'btn-no'                   => esc_html__( 'Cancel', 'aihub' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'aihub' ),
		'btn-child-install'        => esc_html__( 'Install', 'aihub' ),
		'btn-content-install'      => esc_html__( 'Install', 'aihub' ),
		'btn-import'               => esc_html__( 'Import', 'aihub' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'aihub' ),
		'btn-license-skip'         => esc_html__( 'Later', 'aihub' ),

		/* translators: Theme Name */
		'license-header'         => esc_html__( 'Activate Theme', 'aihub' ),
		'license-header2'         => esc_html__( 'Activate Your Theme', 'aihub' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'aihub' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Please add your Envato purchase code along with your email address to confirm the purchase.', 'aihub' ),
		'license-label'            => esc_html__( 'License key', 'aihub' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'aihub' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'aihub' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'aihub' ),

		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Let\'s Get You Started', 'aihub' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'aihub' ),
		'welcome%s'                => esc_html__( 'Thanks for purchasing Hub! You can now register your product in 10 seconds to install plugins, import demos and unlock exlusive features.', 'aihub' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'aihub' ),

		'child-header'             => esc_html__( 'Install Child Theme', 'aihub' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'aihub' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'aihub' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'aihub' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'aihub' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'aihub' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'aihub' ),

		'plugins-header'           => esc_html__( 'Install Plugins', 'aihub' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'aihub' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get you started.', 'aihub' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'aihub' ),
		'plugins-action-link'      => esc_html__( 'View Plugins', 'aihub' ),

		'import-header'            => esc_html__( 'Import Content', 'aihub' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'aihub' ),
		'import-action-link'       => esc_html__( 'Advanced', 'aihub' ),

		'ready-header'             => esc_html__( 'You\'re Ready!', 'aihub' ),

		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'aihub' ),
		'ready-action-link'        => esc_html__( 'Extras', 'aihub' ),
		'ready-big-button'         => esc_html__( 'View your website', 'aihub' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://docs.liquid-themes.com/', esc_html__( 'Help center', 'aihub' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://liquidthemes.freshdesk.com/support/home', esc_html__( 'Get Theme Support', 'aihub' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'aihub' ) ),
	)
);