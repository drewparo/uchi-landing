<?php
/**
* Liquid Themes Theme Framework
* The Liquid_Mega_Menu_Manager class
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

// Load front-end menu walker
require_once( get_template_directory() . '/liquid/extensions/mega-menu/liquid-mega-menu-walker.php' );
require_once( get_template_directory() . '/liquid/extensions/mega-menu/liquid-mega-menu-icons.php' );
require_once( get_template_directory() . '/liquid/extensions/mega-menu/liquid-mega-menu-custom-icon.php' );

class Liquid_Mega_Menu_Manager extends Liquid_Base {

	function __construct() {

		// Custom Fields - Add
		$this->add_filter( 'wp_setup_nav_menu_item',  'setup_nav_menu_item' );

		// Custom Fields - Save
		$this->add_action( 'wp_update_nav_menu_item', 'update_nav_menu_item', 100, 3 );

		// Custom Walker - Edit
		$this->add_filter( 'wp_edit_nav_menu_walker', 'edit_nav_menu_walker', 100, 2 );

		// Filter
		$this->add_filter('nav_menu_link_attributes', 'add_additional_class_on_a', 1, 3);
	}

	// Custom Fields - Add
    function setup_nav_menu_item( $menu_item ) {

		$menu_item->liquid_megaprofile = get_post_meta( $menu_item->ID, '_menu_item_liquid_megaprofile', true );
		$menu_item->liquid_badge = get_post_meta( $menu_item->ID, '_menu_item_liquid_badge', true );
		$menu_item->liquid_badge_color = get_post_meta( $menu_item->ID, '_menu_item_liquid_badge_color', true );
		$menu_item->liquid_badge_bg = get_post_meta( $menu_item->ID, '_menu_item_liquid_badge_bg', true );
		$menu_item->liquid_counter = get_post_meta( $menu_item->ID, '_menu_item_liquid_counter', true );

        return $menu_item;
    }

	// Custom Fields - Save
	function update_nav_menu_item( $menu_id, $menu_item_db_id, $menu_item_data ) {

		if ( isset( $_REQUEST['menu-item-liquid-megaprofile'][$menu_item_db_id] ) ) {
			update_post_meta($menu_item_db_id, '_menu_item_liquid_megaprofile', $_REQUEST['menu-item-liquid-megaprofile'][$menu_item_db_id]);
		}
		if ( isset( $_REQUEST['menu-item-liquid-badge'][$menu_item_db_id] ) ) {
			update_post_meta($menu_item_db_id, '_menu_item_liquid_badge', $_REQUEST['menu-item-liquid-badge'][$menu_item_db_id]);
		}
		if ( isset( $_REQUEST['menu-item-liquid-badge-color'][$menu_item_db_id] ) ) {
			update_post_meta($menu_item_db_id, '_menu_item_liquid_badge_color', $_REQUEST['menu-item-liquid-badge-color'][$menu_item_db_id]);
		}
		if ( isset( $_REQUEST['menu-item-liquid-badge-bg'][$menu_item_db_id] ) ) {
			update_post_meta($menu_item_db_id, '_menu_item_liquid_badge_bg', $_REQUEST['menu-item-liquid-badge-bg'][$menu_item_db_id]);
		}
		if ( isset( $_REQUEST['menu-item-liquid-counter'][$menu_item_db_id] ) ) {
			update_post_meta($menu_item_db_id, '_menu_item_liquid_counter', $_REQUEST['menu-item-liquid-counter'][$menu_item_db_id]);
		}

	}

	// Custom Backend Walker - Edit
	function edit_nav_menu_walker( $walker, $menu_id ) {

		if ( ! class_exists( 'Liquid_Mega_Menu_Edit_Walker' ) ) {
			require_once( get_template_directory() . '/liquid/extensions/mega-menu/liquid-mega-menu-edit.php' );
		}

		return 'Liquid_Mega_Menu_Edit_Walker';
	}

	function add_additional_class_on_a($classes, $item, $args) {

        $class = [ 'lqd-menu-link', 'transition-all' ];

        if ( 0 != $item->menu_item_parent ) {
            $class[] = 'lqd-menu-dropdown-link';
        } else {
            $class[] = 'lqd-menu-link-top';
		}

		if ( isset( $args->add_a_class ) ) {
			$class[] = $args->add_a_class;
		}

        $classes['class'] = implode( ' ', $class );

		return $classes;

	}

}
new Liquid_Mega_Menu_Manager;
