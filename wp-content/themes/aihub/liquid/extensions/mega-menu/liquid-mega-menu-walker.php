<?php
/**
 * The Menu Walker
 * Menu Walker class extends from Nav Menu Walker
*/

if( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Liquid_Menu_Walker extends Walker_Nav_Menu {

	/**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"lqd-menu-dropdown lqd-togglable-element flex list-none m-0 absolute top-100 start-0\">\n";
    }

	/**
     * @see Walker::start_el()
     */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$item_html = '';

		// add lqd custom class
		$item->classes[] = 'lqd-menu-li relative';

		if ( $depth === 0 ) {
			$item->classes[] = 'lqd-menu-li-top';
		} else {
			$item->classes[] = 'lqd-menu-dropdown-li';
        }

		if ( !isset( $args->link_before )){
			return;
		}

		$args->link_before = '';

		if( $item->hasChildren || !empty( $item->liquid_megaprofile ) ) {
			$args->link_after = '<svg class="lqd-dropdown-arrow lqd-menu-icon max-w-1em max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use xlink:href="#lqd-icon-chevron-down" /><span class="lqd-dropdown-trigger hidden items-center justify-center relative lqd-has-before lqd-before:inline-block lqd-before:w-full lqd-before:h-full lqd-before:absolute lqd-before:top-0 lqd-before:start-0 lqd-before:rounded-inherit lqd-before:bg-current lqd-before:opacity-10"><svg class="max-w-1em max-h-1em" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use xlink:href="#lqd-icon-chevron-down" /></svg></span>';
			$item->classes[] = 'lqd-togglable-trigger lqd-menu-dropdown-trigger';
			if ( !empty( $item->liquid_megaprofile ) ){
				$item->classes[] = 'lqd-menu-megamenu menu-item-has-children';
			} else {
				$item->classes[] = 'relative';
			}
		} else {
			$args->link_after = '';
		}

		if( ! empty( $item->liquid_counter ) ) {
			$args->old_link_after = $args->link_after;
			$args->link_after = $args->link_after . '<sup class="lqd-menu-item-sup absolute top-0 end-0">' . esc_html( $item->liquid_counter ) . '</sup>';
		}

		if( !empty( $item->liquid_badge ) ) {
			$args->old_link_after = $args->link_after;
			$badge_style = '';
			if ( !empty( $item->liquid_badge_color ) ) {
				$badge_style .= '--lqd-menu-badge-color:' . $item->liquid_badge_color . ';';
			}
			if ( !empty( $item->liquid_badge_bg ) ) {
				$badge_style .= '--lqd-menu-badge-bg:' . $item->liquid_badge_bg .';';
			}
			$badge_class = 'lqd-menu-badge leading-none';
			$badge_attrs = 'class="' . $badge_class . '"';

			if ( !empty( $badge_style ) ) {
				$badge_attrs .= ' style="' . $badge_style . '"';
			}

			$args->link_after = $args->link_after . '<span ' . $badge_attrs . '>'. esc_html( $item->liquid_badge ) . '</span>';
		}

        parent::start_el( $item_html, $item, $depth, $args, $id );

		if( !empty( $args->old_link_before ) ) {
			$args->link_before = $args->old_link_before;
			$args->old_link_before = '';
		}

		if( !empty( $args->old_link_after ) ) {
			$args->link_after = $args->old_link_after;
			$args->old_link_after = '';
		}

		if( !empty( $item->liquid_megaprofile ) ) {
			$item_html .= $this->get_megamenu( $item->liquid_megaprofile );
		}

		$output .= $item_html;
	}

	function get_megamenu( $id ) {

		$post = get_post( $id );
		$content = $post->post_content;
		$content = do_shortcode( $content );

		if ( ! defined( 'ELEMENTOR_VERSION' ) || ! is_callable( 'Elementor\Plugin::instance' ) ) return '';

		$out = sprintf(
			'<div class="lqd-menu-dropdown lqd-megamenu-dropdown lqd-togglable-element flex absolute top-full start-0 z-10" data-lqd-align-h="center">%s</div>',
			\Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id, $with_css = true )
		);

		return $out;

	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		// check whether this item has children, and set $item->hasChildren accordingly
		$element->hasChildren = isset( $children_elements[$element->ID] ) && !empty( $children_elements[$element->ID] );

		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

}
