<?php
/**
 * Dashicons
 *
 * @package Icon_Picker
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 */


require_once dirname( __FILE__ ) . '/font.php';

/**
 * Icon type: Dashicons
 *
 * @since 0.1.0
 */
class Icon_Picker_Type_Dashicons extends Icon_Picker_Type_Font {

	/**
	 * Icon type ID
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $id = 'dashicons';

	/**
	 * Icon type name
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $name = 'Dashicons';

	/**
	 * Icon type version
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $version = '4.3.1';

	/**
	 * Stylesheet URI
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $stylesheet_uri = '';


	/**
	 * Register assets
	 *
	 * @since   0.1.0
	 * @wp_hook action icon_picker_loader_init
	 *
	 * @param  Icon_Picker_Loader  $loader Icon_Picker_Loader instance.
	 *
	 * @return void
	 */
	public function register_assets( Icon_Picker_Loader $loader ) {
		$loader->add_style( $this->stylesheet_id );
	}


	/**
	 * Get icon groups
	 *
	 * @since  0.1.0
	 * @return array
	 */
	public function get_groups() {
		$groups = array(
			array(
				'id'   => 'admin',
				'name' => __( 'Admin', 'aihub' ),
			),
			array(
				'id'   => 'post-formats',
				'name' => __( 'Post Formats', 'aihub' ),
			),
			array(
				'id'   => 'welcome-screen',
				'name' => __( 'Welcome Screen', 'aihub' ),
			),
			array(
				'id'   => 'image-editor',
				'name' => __( 'Image Editor', 'aihub' ),
			),
			array(
				'id'   => 'text-editor',
				'name' => __( 'Text Editor', 'aihub' ),
			),
			array(
				'id'   => 'post',
				'name' => __( 'Post', 'aihub' ),
			),
			array(
				'id'   => 'sorting',
				'name' => __( 'Sorting', 'aihub' ),
			),
			array(
				'id'   => 'social',
				'name' => __( 'Social', 'aihub' ),
			),
			array(
				'id'   => 'jobs',
				'name' => __( 'Jobs', 'aihub' ),
			),
			array(
				'id'   => 'products',
				'name' => __( 'Internal/Products', 'aihub' ),
			),
			array(
				'id'   => 'taxonomies',
				'name' => __( 'Taxonomies', 'aihub' ),
			),
			array(
				'id'   => 'alerts',
				'name' => __( 'Alerts/Notifications', 'aihub' ),
			),
			array(
				'id'   => 'media',
				'name' => __( 'Media', 'aihub' ),
			),
			array(
				'id'   => 'misc',
				'name' => __( 'Misc./Post Types', 'aihub' ),
			),
		);

		/**
		 * Filter dashicon groups
		 *
		 * @since 0.1.0
		 * @param array $groups Icon groups.
		 */
		$groups = apply_filters( 'icon_picker_dashicons_groups', $groups );

		return $groups;
	}


	/**
	 * Get icon names
	 *
	 * @since  0.1.0
	 * @return array
	 */
	public function get_items() {
		$items = array(
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-appearance',
				'name'  => __( 'Appearance', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-collapse',
				'name'  => __( 'Collapse', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-comments',
				'name'  => __( 'Comments', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-customizer',
				'name'  => __( 'Customizer', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-dashboard',
				'name'  => __( 'Dashboard', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-generic',
				'name'  => __( 'Generic', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-filter',
				'name'  => __( 'Filter', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-home',
				'name'  => __( 'Home', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-media',
				'name'  => __( 'Media', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-menu',
				'name'  => __( 'Menu', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-multisite',
				'name'  => __( 'Multisite', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-network',
				'name'  => __( 'Network', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-page',
				'name'  => __( 'Page', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-plugins',
				'name'  => __( 'Plugins', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-settings',
				'name'  => __( 'Settings', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-site',
				'name'  => __( 'Site', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-tools',
				'name'  => __( 'Tools', 'aihub' ),
			),
			array(
				'group' => 'admin',
				'id'    => 'dashicons-admin-users',
				'name'  => __( 'Users', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-standard',
				'name'  => __( 'Standard', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-aside',
				'name'  => __( 'Aside', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-image',
				'name'  => __( 'Image', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-video',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-audio',
				'name'  => __( 'Audio', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-quote',
				'name'  => __( 'Quote', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-gallery',
				'name'  => __( 'Gallery', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-links',
				'name'  => __( 'Links', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-status',
				'name'  => __( 'Status', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'dashicons-format-chat',
				'name'  => __( 'Chat', 'aihub' ),
			),
			array(
				'group' => 'welcome-screen',
				'id'    => 'dashicons-welcome-add-page',
				'name'  => __( 'Add page', 'aihub' ),
			),
			array(
				'group' => 'welcome-screen',
				'id'    => 'dashicons-welcome-comments',
				'name'  => __( 'Comments', 'aihub' ),
			),
			array(
				'group' => 'welcome-screen',
				'id'    => 'dashicons-welcome-edit-page',
				'name'  => __( 'Edit page', 'aihub' ),
			),
			array(
				'group' => 'welcome-screen',
				'id'    => 'dashicons-welcome-learn-more',
				'name'  => __( 'Learn More', 'aihub' ),
			),
			array(
				'group' => 'welcome-screen',
				'id'    => 'dashicons-welcome-view-site',
				'name'  => __( 'View Site', 'aihub' ),
			),
			array(
				'group' => 'welcome-screen',
				'id'    => 'dashicons-welcome-widgets-menus',
				'name'  => __( 'Widgets', 'aihub' ),
			),
			array(
				'group' => 'welcome-screen',
				'id'    => 'dashicons-welcome-write-blog',
				'name'  => __( 'Write Blog', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-image-crop',
				'name'  => __( 'Crop', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-image-filter',
				'name'  => __( 'Filter', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-image-rotate',
				'name'  => __( 'Rotate', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-image-rotate-left',
				'name'  => __( 'Rotate Left', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-image-rotate-right',
				'name'  => __( 'Rotate Right', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-image-flip-vertical',
				'name'  => __( 'Flip Vertical', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-image-flip-horizontal',
				'name'  => __( 'Flip Horizontal', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-undo',
				'name'  => __( 'Undo', 'aihub' ),
			),
			array(
				'group' => 'image-editor',
				'id'    => 'dashicons-redo',
				'name'  => __( 'Redo', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-bold',
				'name'  => __( 'Bold', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-italic',
				'name'  => __( 'Italic', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-ul',
				'name'  => __( 'Unordered List', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-ol',
				'name'  => __( 'Ordered List', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-quote',
				'name'  => __( 'Quote', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-alignleft',
				'name'  => __( 'Align Left', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-aligncenter',
				'name'  => __( 'Align Center', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-alignright',
				'name'  => __( 'Align Right', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-insertmore',
				'name'  => __( 'Insert More', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-spellcheck',
				'name'  => __( 'Spell Check', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-distractionfree',
				'name'  => __( 'Distraction-free', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-kitchensink',
				'name'  => __( 'Kitchensink', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-underline',
				'name'  => __( 'Underline', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-justify',
				'name'  => __( 'Justify', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-textcolor',
				'name'  => __( 'Text Color', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-paste-word',
				'name'  => __( 'Paste Word', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-paste-text',
				'name'  => __( 'Paste Text', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-removeformatting',
				'name'  => __( 'Clear Formatting', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-video',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-customchar',
				'name'  => __( 'Custom Characters', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-indent',
				'name'  => __( 'Indent', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-outdent',
				'name'  => __( 'Outdent', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-help',
				'name'  => __( 'Help', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-strikethrough',
				'name'  => __( 'Strikethrough', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-unlink',
				'name'  => __( 'Unlink', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'dashicons-editor-rtl',
				'name'  => __( 'RTL', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-align-left',
				'name'  => __( 'Align Left', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-align-right',
				'name'  => __( 'Align Right', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-align-center',
				'name'  => __( 'Align Center', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-align-none',
				'name'  => __( 'Align None', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-lock',
				'name'  => __( 'Lock', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-calendar',
				'name'  => __( 'Calendar', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-calendar-alt',
				'name'  => __( 'Calendar', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-hidden',
				'name'  => __( 'Hidden', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-visibility',
				'name'  => __( 'Visibility', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-post-status',
				'name'  => __( 'Post Status', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-post-trash',
				'name'  => __( 'Post Trash', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-edit',
				'name'  => __( 'Edit', 'aihub' ),
			),
			array(
				'group' => 'post',
				'id'    => 'dashicons-trash',
				'name'  => __( 'Trash', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-up',
				'name'  => __( 'Arrow: Up', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-down',
				'name'  => __( 'Arrow: Down', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-left',
				'name'  => __( 'Arrow: Left', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-right',
				'name'  => __( 'Arrow: Right', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-up-alt',
				'name'  => __( 'Arrow: Up', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-down-alt',
				'name'  => __( 'Arrow: Down', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-left-alt',
				'name'  => __( 'Arrow: Left', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-right-alt',
				'name'  => __( 'Arrow: Right', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-up-alt2',
				'name'  => __( 'Arrow: Up', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-down-alt2',
				'name'  => __( 'Arrow: Down', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-left-alt2',
				'name'  => __( 'Arrow: Left', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-arrow-right-alt2',
				'name'  => __( 'Arrow: Right', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-leftright',
				'name'  => __( 'Left-Right', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-sort',
				'name'  => __( 'Sort', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-list-view',
				'name'  => __( 'List View', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-exerpt-view',
				'name'  => __( 'Excerpt View', 'aihub' ),
			),
			array(
				'group' => 'sorting',
				'id'    => 'dashicons-grid-view',
				'name'  => __( 'Grid View', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-share',
				'name'  => __( 'Share', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-share-alt',
				'name'  => __( 'Share', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-share-alt2',
				'name'  => __( 'Share', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-twitter',
				'name'  => __( 'Twitter', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-rss',
				'name'  => __( 'RSS', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-email',
				'name'  => __( 'Email', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-email-alt',
				'name'  => __( 'Email', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-facebook',
				'name'  => __( 'Facebook', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-facebook-alt',
				'name'  => __( 'Facebook', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-googleplus',
				'name'  => __( 'Google+', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'dashicons-networking',
				'name'  => __( 'Networking', 'aihub' ),
			),
			array(
				'group' => 'jobs',
				'id'    => 'dashicons-art',
				'name'  => __( 'Art', 'aihub' ),
			),
			array(
				'group' => 'jobs',
				'id'    => 'dashicons-hammer',
				'name'  => __( 'Hammer', 'aihub' ),
			),
			array(
				'group' => 'jobs',
				'id'    => 'dashicons-migrate',
				'name'  => __( 'Migrate', 'aihub' ),
			),
			array(
				'group' => 'jobs',
				'id'    => 'dashicons-performance',
				'name'  => __( 'Performance', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-wordpress',
				'name'  => __( 'WordPress', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-wordpress-alt',
				'name'  => __( 'WordPress', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-pressthis',
				'name'  => __( 'PressThis', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-update',
				'name'  => __( 'Update', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-screenoptions',
				'name'  => __( 'Screen Options', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-info',
				'name'  => __( 'Info', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-cart',
				'name'  => __( 'Cart', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-feedback',
				'name'  => __( 'Feedback', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-cloud',
				'name'  => __( 'Cloud', 'aihub' ),
			),
			array(
				'group' => 'products',
				'id'    => 'dashicons-translation',
				'name'  => __( 'Translation', 'aihub' ),
			),
			array(
				'group' => 'taxonomies',
				'id'    => 'dashicons-tag',
				'name'  => __( 'Tag', 'aihub' ),
			),
			array(
				'group' => 'taxonomies',
				'id'    => 'dashicons-category',
				'name'  => __( 'Category', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-yes',
				'name'  => __( 'Yes', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-no',
				'name'  => __( 'No', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-no-alt',
				'name'  => __( 'No', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-plus',
				'name'  => __( 'Plus', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-minus',
				'name'  => __( 'Minus', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-dismiss',
				'name'  => __( 'Dismiss', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-marker',
				'name'  => __( 'Marker', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-star-filled',
				'name'  => __( 'Star: Filled', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-star-half',
				'name'  => __( 'Star: Half', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-star-empty',
				'name'  => __( 'Star: Empty', 'aihub' ),
			),
			array(
				'group' => 'alerts',
				'id'    => 'dashicons-flag',
				'name'  => __( 'Flag', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-skipback',
				'name'  => __( 'Skip Back', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-back',
				'name'  => __( 'Back', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-play',
				'name'  => __( 'Play', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-pause',
				'name'  => __( 'Pause', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-forward',
				'name'  => __( 'Forward', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-skipforward',
				'name'  => __( 'Skip Forward', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-repeat',
				'name'  => __( 'Repeat', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-volumeon',
				'name'  => __( 'Volume: On', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-controls-volumeoff',
				'name'  => __( 'Volume: Off', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-archive',
				'name'  => __( 'Archive', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-audio',
				'name'  => __( 'Audio', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-code',
				'name'  => __( 'Code', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-default',
				'name'  => __( 'Default', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-document',
				'name'  => __( 'Document', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-interactive',
				'name'  => __( 'Interactive', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-spreadsheet',
				'name'  => __( 'Spreadsheet', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-text',
				'name'  => __( 'Text', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-media-video',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-playlist-audio',
				'name'  => __( 'Audio Playlist', 'aihub' ),
			),
			array(
				'group' => 'media',
				'id'    => 'dashicons-playlist-video',
				'name'  => __( 'Video Playlist', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-album',
				'name'  => __( 'Album', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-analytics',
				'name'  => __( 'Analytics', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-awards',
				'name'  => __( 'Awards', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-backup',
				'name'  => __( 'Backup', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-building',
				'name'  => __( 'Building', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-businessman',
				'name'  => __( 'Businessman', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-camera',
				'name'  => __( 'Camera', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-carrot',
				'name'  => __( 'Carrot', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-chart-pie',
				'name'  => __( 'Chart: Pie', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-chart-bar',
				'name'  => __( 'Chart: Bar', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-chart-line',
				'name'  => __( 'Chart: Line', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-chart-area',
				'name'  => __( 'Chart: Area', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-desktop',
				'name'  => __( 'Desktop', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-forms',
				'name'  => __( 'Forms', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-groups',
				'name'  => __( 'Groups', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-id',
				'name'  => __( 'ID', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-id-alt',
				'name'  => __( 'ID', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-images-alt',
				'name'  => __( 'Images', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-images-alt2',
				'name'  => __( 'Images', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-index-card',
				'name'  => __( 'Index Card', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-layout',
				'name'  => __( 'Layout', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-location',
				'name'  => __( 'Location', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-location-alt',
				'name'  => __( 'Location', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-products',
				'name'  => __( 'Products', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-portfolio',
				'name'  => __( 'Portfolio', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-book',
				'name'  => __( 'Book', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-book-alt',
				'name'  => __( 'Book', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-download',
				'name'  => __( 'Download', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-upload',
				'name'  => __( 'Upload', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-clock',
				'name'  => __( 'Clock', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-lightbulb',
				'name'  => __( 'Lightbulb', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-money',
				'name'  => __( 'Money', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-palmtree',
				'name'  => __( 'Palm Tree', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-phone',
				'name'  => __( 'Phone', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-search',
				'name'  => __( 'Search', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-shield',
				'name'  => __( 'Shield', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-shield-alt',
				'name'  => __( 'Shield', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-slides',
				'name'  => __( 'Slides', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-smartphone',
				'name'  => __( 'Smartphone', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-smiley',
				'name'  => __( 'Smiley', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-sos',
				'name'  => __( 'S.O.S.', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-sticky',
				'name'  => __( 'Sticky', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-store',
				'name'  => __( 'Store', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-tablet',
				'name'  => __( 'Tablet', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-testimonial',
				'name'  => __( 'Testimonial', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-tickets-alt',
				'name'  => __( 'Tickets', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-thumbs-up',
				'name'  => __( 'Thumbs Up', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-thumbs-down',
				'name'  => __( 'Thumbs Down', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-unlock',
				'name'  => __( 'Unlock', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-vault',
				'name'  => __( 'Vault', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-video-alt',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-video-alt2',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-video-alt3',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'dashicons-warning',
				'name'  => __( 'Warning', 'aihub' ),
			),
		);

		/**
		 * Filter dashicon items
		 *
		 * @since 0.1.0
		 * @param array $items Icon names.
		 */
		$items = apply_filters( 'icon_picker_dashicons_items', $items );

		return $items;
	}
}
