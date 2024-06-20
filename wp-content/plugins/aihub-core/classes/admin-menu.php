<?php

defined( 'ABSPATH' ) || die();

class LQD_AdminBarMenu {

    public static function init() {

        if ( current_user_can('edit_posts') ) {

            add_action( 'admin_bar_menu', [ __CLASS__, 'add_toolbar_items' ], 100 );
            add_action( 'wp_head', [__CLASS__, 'cache_purge_action_css'], 100);
            add_action( 'admin_head', [__CLASS__, 'cache_purge_action_css'], 100);
            add_action( 'wp_footer', [ __CLASS__, 'cache_purge_action_js'] );
            add_action( 'admin_footer', [ __CLASS__, 'cache_purge_action_js_admin'] );
            add_action( 'wp_ajax_hub_cache_purge', [ __CLASS__, 'hub_cache_purge_callback'] );
			add_action( 'wp_update_nav_menu', function ( $id, $data = NULL ) {
				if ( $data ) {
					liquid_helper()->purge_all_cache();
				}
			}, 10, 2);

        }

    }

    public static function add_toolbar_items( $admin_bar ){

        $admin_bar->add_menu([
            'id'    => 'ld-edit-header-footer',
            'title' => 'Edit Header & Footer',
			'href'  => esc_url( admin_url( 'edit.php?post_type=liquid-header' ) ),
            'meta'  => [
                'title' => __( 'Edit Header & Footer', 'aihub-core'),
            ],
        ]);

        $header_and_footer = array_merge(self::get_available_custom_post('liquid-header'), self::get_available_custom_post('liquid-footer'));

        foreach ( $header_and_footer as $item ){
            if ( liquid_get_custom_header_id() == $item['id'] || liquid_get_custom_footer_id() == $item['id'] ){
                $current = '<span class="ld-edit-header-footer-current" style="background: #55595c; font-size: 11px; line-height: 1.15em; margin-inline-start: 5px; padding: 4px 8px; border-radius: 3px;">Current</span>';
            } else {
                $current = '';
            }

            $admin_bar->add_menu(
				[
					'id' => 'ld-edit-header-footer-' . $item['id'],
					'parent' => 'ld-edit-header-footer',
					'title' => sprintf( '%s - %s %s', $item['title'], $item['type'], $current ),
					'href' => \Elementor\Plugin::$instance->documents->get( $item['id'] )->get_edit_url(),
					'meta' => [
						'title' => $item['title'],
						'target' => '_blank',
						'class' => 'ld_edit_header_footer ' . strtolower( $item['type'] ),
					],
				]
			);
        }

		// Purge cache menu
		if ( liquid_helper()->get_kit_option('liquid_script_print_method') == 'external' ) {
			$admin_bar->add_menu(
				[
					'id'    => 'ld-purge-assets-cache',
					'title' => sprintf( '<img style="display:inline-block;margin-right: 7px;height: 15px;opacity: .7;vertical-align:text-top;" src="%s">%s', get_template_directory_uri() . '/liquid/assets/img/liquid-menu-logo.svg', __( 'Purge Cache', 'aihub-core' ) ),
					'href'  => '#',
					'meta'  => [
						'title' => __( 'Liquid Purge Cache', 'aihub-core'),
					],
				]
			);
	
			// Purge cache by page id
			if ( is_array( get_option( 'liquid_scripts_cache' ) ) ) {
				if ( get_the_ID() && in_array( get_the_ID(), get_option( 'liquid_scripts_cache', array() ) ) ) {
					$admin_bar->add_menu(
						[
							'id' => 'ld-purge-assets-cache-' . get_the_ID(),
							'parent' => 'ld-purge-assets-cache',
							'title' => __( 'Purge this page cache', 'aihub-core'),
							'href' => '#',
							'meta' => [
								'title' => __( 'Purge this page cache', 'aihub-core'),
								'class' => 'purge-page-cache',
							],
						]
					);
				}
			}
		}

    }

    static function cache_purge_action_css() {
        echo('<style>@keyframes spin {from {transform: rotate(0deg)} to{transform: rotate(360deg)}}#wpadminbar .ld_edit_header_footer a {display:flex;align-items:center;justify-content:space-between;} #wpadminbar .ld_edit_header_footer.header+.footer{border-top: 1px solid #464b50;margin-top: 4px; padding-top: 3px;}.ab-item.lqd-is-loading{display:flex !important;align-items:center;}.ab-item.lqd-is-loading img{display:none !important;}.ab-item.lqd-is-loading:before{content: "";box-sizing:border-box;display: inline-block;width: 18px; height: 18px;border: 2px solid rgb(255 255 255 / 15%);border-radius: 10px;border-top-color:#fff;margin-inline-end:0.5em;animation: spin 1s linear infinite;}</style>');
    }

    static function cache_purge_action_js() {
        wp_add_inline_script( 'admin-bar', '
            const ajaxurl = "' . admin_url('admin-ajax.php') . '";
            jQuery("li#wp-admin-bar-ld-purge-assets-cache .ab-item").on("click", function (e) {

                e.preventDefault();

                const link = e.target;
                const data = {
                    "action": "hub_cache_purge",
                    "type" : link.parentElement.classList.value,
                    "id" : ' . get_the_ID() . '
                };

                link.classList.add("lqd-is-loading");

                jQuery.post(ajaxurl, data, function (response) {
                    link.classList.remove("lqd-is-loading");
					window.location.reload();
                });

            });
        ');
    }

    static function cache_purge_action_js_admin() {
		?>
            <script type="text/javascript">
                jQuery("li#wp-admin-bar-ld-purge-assets-cache .ab-item").on("click", function (e) {
                    e.preventDefault();

                    const link = e.target;
                    var data = {
                        'action': 'hub_cache_purge',
                        "type" : link.parentElement.classList.value,
                    };

                    link.classList.add("lqd-is-loading");

                    jQuery.post(ajaxurl, data, function (response) {
                        link.classList.remove("lqd-is-loading");
                            window.location.reload();
                    });

                });
            </script>
		<?php
    }

    static function hub_cache_purge_callback() {

		global $wpdb;

		$wpdb->delete($wpdb->postmeta, ['meta_key' => '_liquid_post_content']);
		$wpdb->delete($wpdb->postmeta, ['meta_key' => '_liquid_post_content_has_bg']);

		if ( defined('ELEMENTOR_VERSION') ){
			\Elementor\Plugin::instance()->files_manager->clear_cache();
		}

		update_option( 'lqd_el_container_bg', array() );
		update_option( 'liquid_utils_css', '' );
		update_option( 'liquid_typekit_css', '' );

        if ( $_POST['type'] == 'purge-page-cache' ) {
            liquid_helper()->purge_scripts_cache( $_POST['id'] );
            wp_send_json_success( 'Page cache purged' );
        } else {
            liquid_helper()->purge_scripts_cache( true );
            wp_send_json_success( 'All page cache purged' );
        }

    }

    private static function get_available_custom_post( $type ) {

		$posts = get_posts( array(
			'post_type' => $type,
			'posts_per_page' => -1,
		) );

		$options = [];

        $type = $type === 'liquid-header' ? 'Header' : 'Footer';

		foreach ( $posts as $post ) {
		  $options[] = [ 'id' => $post->ID, 'title' => $post->post_title, 'type' => $type ];
		}

		return $options;

	}

}
LQD_AdminBarMenu::init();