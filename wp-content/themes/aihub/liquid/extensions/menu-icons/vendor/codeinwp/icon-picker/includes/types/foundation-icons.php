<?php
/**
 * Foundation Icons
 *
 * @package Icon_Picker
 * @author  Dzikri Aziz <kvcrvt@gmail.com>
 */
class Icon_Picker_Type_Foundation extends Icon_Picker_Type_Font {

	/**
	 * Icon type ID
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $id = 'foundation-icons';

	/**
	 * Icon type name
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $name = 'Foundation';

	/**
	 * Icon type version
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $version = '3.0';


	/**
	 * Get icon groups
	 *
	 * @since  0.1.0
	 * @return array
	 */
	public function get_groups() {
		$groups = array(
			array(
				'id'   => 'accessibility',
				'name' => __( 'Accessibility', 'aihub' ),
			),
			array(
				'id'   => 'arrows',
				'name' => __( 'Arrows', 'aihub' ),
			),
			array(
				'id'   => 'devices',
				'name' => __( 'Devices', 'aihub' ),
			),
			array(
				'id'   => 'ecommerce',
				'name' => __( 'Ecommerce', 'aihub' ),
			),
			array(
				'id'   => 'editor',
				'name' => __( 'Editor', 'aihub' ),
			),
			array(
				'id'   => 'file-types',
				'name' => __( 'File Types', 'aihub' ),
			),
			array(
				'id'   => 'general',
				'name' => __( 'General', 'aihub' ),
			),
			array(
				'id'   => 'media-control',
				'name' => __( 'Media Controls', 'aihub' ),
			),
			array(
				'id'   => 'misc',
				'name' => __( 'Miscellaneous', 'aihub' ),
			),
			array(
				'id'   => 'people',
				'name' => __( 'People', 'aihub' ),
			),
			array(
				'id'   => 'social',
				'name' => __( 'Social/Brand', 'aihub' ),
			),
		);
		/**
		 * Filter genericon groups
		 *
		 * @since 0.1.0
		 * @param array $groups Icon groups.
		 */
		$groups = apply_filters( 'icon_picker_foundations_groups', $groups );

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
				'group' => 'accessibility',
				'id'    => 'fi-asl',
				'name'  => __( 'ASL', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-blind',
				'name'  => __( 'Blind', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-braille',
				'name'  => __( 'Braille', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-closed-caption',
				'name'  => __( 'Closed Caption', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-elevator',
				'name'  => __( 'Elevator', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-guide-dog',
				'name'  => __( 'Guide Dog', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-hearing-aid',
				'name'  => __( 'Hearing Aid', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-universal-access',
				'name'  => __( 'Universal Access', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-male',
				'name'  => __( 'Male', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-female',
				'name'  => __( 'Female', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-male-female',
				'name'  => __( 'Male & Female', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-male-symbol',
				'name'  => __( 'Male Symbol', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-female-symbol',
				'name'  => __( 'Female Symbol', 'aihub' ),
			),
			array(
				'group' => 'accessibility',
				'id'    => 'fi-wheelchair',
				'name'  => __( 'Wheelchair', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrow-up',
				'name'  => __( 'Arrow: Up', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrow-down',
				'name'  => __( 'Arrow: Down', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrow-left',
				'name'  => __( 'Arrow: Left', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrow-right',
				'name'  => __( 'Arrow: Right', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrows-out',
				'name'  => __( 'Arrows: Out', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrows-in',
				'name'  => __( 'Arrows: In', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrows-expand',
				'name'  => __( 'Arrows: Expand', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'fi-arrows-compress',
				'name'  => __( 'Arrows: Compress', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-bluetooth',
				'name'  => __( 'Bluetooth', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-camera',
				'name'  => __( 'Camera', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-compass',
				'name'  => __( 'Compass', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-laptop',
				'name'  => __( 'Laptop', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-megaphone',
				'name'  => __( 'Megaphone', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-microphone',
				'name'  => __( 'Microphone', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-mobile',
				'name'  => __( 'Mobile', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-mobile-signal',
				'name'  => __( 'Mobile Signal', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-monitor',
				'name'  => __( 'Monitor', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-tablet-portrait',
				'name'  => __( 'Tablet: Portrait', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-tablet-landscape',
				'name'  => __( 'Tablet: Landscape', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-telephone',
				'name'  => __( 'Telephone', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-usb',
				'name'  => __( 'USB', 'aihub' ),
			),
			array(
				'group' => 'devices',
				'id'    => 'fi-video',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-bitcoin',
				'name'  => __( 'Bitcoin', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-bitcoin-circle',
				'name'  => __( 'Bitcoin', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-dollar',
				'name'  => __( 'Dollar', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-euro',
				'name'  => __( 'EURO', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-pound',
				'name'  => __( 'Pound', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-yen',
				'name'  => __( 'Yen', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-burst',
				'name'  => __( 'Burst', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-burst-new',
				'name'  => __( 'Burst: New', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-burst-sale',
				'name'  => __( 'Burst: Sale', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-credit-card',
				'name'  => __( 'Credit Card', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-dollar-bill',
				'name'  => __( 'Dollar Bill', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-paypal',
				'name'  => 'PayPal',
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-price-tag',
				'name'  => __( 'Price Tag', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-pricetag-multiple',
				'name'  => __( 'Price Tag: Multiple', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-shopping-bag',
				'name'  => __( 'Shopping Bag', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'fi-shopping-cart',
				'name'  => __( 'Shopping Cart', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-bold',
				'name'  => __( 'Bold', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-italic',
				'name'  => __( 'Italic', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-underline',
				'name'  => __( 'Underline', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-strikethrough',
				'name'  => __( 'Strikethrough', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-text-color',
				'name'  => __( 'Text Color', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-background-color',
				'name'  => __( 'Background Color', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-superscript',
				'name'  => __( 'Superscript', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-subscript',
				'name'  => __( 'Subscript', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-align-left',
				'name'  => __( 'Align Left', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-align-center',
				'name'  => __( 'Align Center', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-align-right',
				'name'  => __( 'Align Right', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-align-justify',
				'name'  => __( 'Justify', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-list-number',
				'name'  => __( 'List: Number', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-list-bullet',
				'name'  => __( 'List: Bullet', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-indent-more',
				'name'  => __( 'Indent', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-indent-less',
				'name'  => __( 'Outdent', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-add',
				'name'  => __( 'Add Page', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-copy',
				'name'  => __( 'Copy Page', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-multiple',
				'name'  => __( 'Duplicate Page', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-delete',
				'name'  => __( 'Delete Page', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-remove',
				'name'  => __( 'Remove Page', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-edit',
				'name'  => __( 'Edit Page', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-export',
				'name'  => __( 'Export', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-export-csv',
				'name'  => __( 'Export to CSV', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-export-pdf',
				'name'  => __( 'Export to PDF', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-filled',
				'name'  => __( 'Fill Page', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-crop',
				'name'  => __( 'Crop', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-filter',
				'name'  => __( 'Filter', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-paint-bucket',
				'name'  => __( 'Paint Bucket', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-photo',
				'name'  => __( 'Photo', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-print',
				'name'  => __( 'Print', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-save',
				'name'  => __( 'Save', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-link',
				'name'  => __( 'Link', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-unlink',
				'name'  => __( 'Unlink', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-quote',
				'name'  => __( 'Quote', 'aihub' ),
			),
			array(
				'group' => 'editor',
				'id'    => 'fi-page-search',
				'name'  => __( 'Search in Page', 'aihub' ),
			),
			array(
				'group' => 'file-types',
				'id'    => 'fi-page',
				'name'  => __( 'File', 'aihub' ),
			),
			array(
				'group' => 'file-types',
				'id'    => 'fi-page-csv',
				'name'  => __( 'CSV', 'aihub' ),
			),
			array(
				'group' => 'file-types',
				'id'    => 'fi-page-doc',
				'name'  => __( 'Doc', 'aihub' ),
			),
			array(
				'group' => 'file-types',
				'id'    => 'fi-page-pdf',
				'name'  => __( 'PDF', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-address-book',
				'name'  => __( 'Addressbook', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-alert',
				'name'  => __( 'Alert', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-annotate',
				'name'  => __( 'Annotate', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-archive',
				'name'  => __( 'Archive', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-bookmark',
				'name'  => __( 'Bookmark', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-calendar',
				'name'  => __( 'Calendar', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-clock',
				'name'  => __( 'Clock', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-cloud',
				'name'  => __( 'Cloud', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-comment',
				'name'  => __( 'Comment', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-comment-minus',
				'name'  => __( 'Comment: Minus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-comment-quotes',
				'name'  => __( 'Comment: Quotes', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-comment-video',
				'name'  => __( 'Comment: Video', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-comments',
				'name'  => __( 'Comments', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-contrast',
				'name'  => __( 'Contrast', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-database',
				'name'  => __( 'Database', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-folder',
				'name'  => __( 'Folder', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-folder-add',
				'name'  => __( 'Folder: Add', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-folder-lock',
				'name'  => __( 'Folder: Lock', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-eye',
				'name'  => __( 'Eye', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-heart',
				'name'  => __( 'Heart', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-plus',
				'name'  => __( 'Plus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-minus',
				'name'  => __( 'Minus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-minus-circle',
				'name'  => __( 'Minus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-x',
				'name'  => __( 'X', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-x-circle',
				'name'  => __( 'X', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-check',
				'name'  => __( 'Check', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-checkbox',
				'name'  => __( 'Check', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-download',
				'name'  => __( 'Download', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-upload',
				'name'  => __( 'Upload', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-upload-cloud',
				'name'  => __( 'Upload to Cloud', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-flag',
				'name'  => __( 'Flag', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-foundation',
				'name'  => __( 'Foundation', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-graph-bar',
				'name'  => __( 'Graph: Bar', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-graph-horizontal',
				'name'  => __( 'Graph: Horizontal', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-graph-pie',
				'name'  => __( 'Graph: Pie', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-graph-trend',
				'name'  => __( 'Graph: Trend', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-home',
				'name'  => __( 'Home', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-layout',
				'name'  => __( 'Layout', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-like',
				'name'  => __( 'Like', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-dislike',
				'name'  => __( 'Dislike', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-list',
				'name'  => __( 'List', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-list-thumbnails',
				'name'  => __( 'List: Thumbnails', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-lock',
				'name'  => __( 'Lock', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-unlock',
				'name'  => __( 'Unlock', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-marker',
				'name'  => __( 'Marker', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-magnifying-glass',
				'name'  => __( 'Magnifying Glass', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-refresh',
				'name'  => __( 'Refresh', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-paperclip',
				'name'  => __( 'Paperclip', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-pencil',
				'name'  => __( 'Pencil', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-play-video',
				'name'  => __( 'Play Video', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-results',
				'name'  => __( 'Results', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-results-demographics',
				'name'  => __( 'Results: Demographics', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-rss',
				'name'  => __( 'RSS', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-share',
				'name'  => __( 'Share', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-sound',
				'name'  => __( 'Sound', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-star',
				'name'  => __( 'Star', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-thumbnails',
				'name'  => __( 'Thumbnails', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-trash',
				'name'  => __( 'Trash', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-web',
				'name'  => __( 'Web', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-widget',
				'name'  => __( 'Widget', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-wrench',
				'name'  => __( 'Wrench', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-zoom-out',
				'name'  => __( 'Zoom Out', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'fi-zoom-in',
				'name'  => __( 'Zoom In', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-record',
				'name'  => __( 'Record', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-play-circle',
				'name'  => __( 'Play', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-play',
				'name'  => __( 'Play', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-pause',
				'name'  => __( 'Pause', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-stop',
				'name'  => __( 'Stop', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-previous',
				'name'  => __( 'Previous', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-rewind',
				'name'  => __( 'Rewind', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-fast-forward',
				'name'  => __( 'Fast Forward', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-next',
				'name'  => __( 'Next', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-volume',
				'name'  => __( 'Volume', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-volume-none',
				'name'  => __( 'Volume: Low', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-volume-strike',
				'name'  => __( 'Volume: Mute', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-loop',
				'name'  => __( 'Loop', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-shuffle',
				'name'  => __( 'Shuffle', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-eject',
				'name'  => __( 'Eject', 'aihub' ),
			),
			array(
				'group' => 'media-control',
				'id'    => 'fi-rewind-ten',
				'name'  => __( 'Rewind 10', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-anchor',
				'name'  => __( 'Anchor', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-asterisk',
				'name'  => __( 'Asterisk', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-at-sign',
				'name'  => __( '@', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-battery-full',
				'name'  => __( 'Battery: Full', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-battery-half',
				'name'  => __( 'Battery: Half', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-battery-empty',
				'name'  => __( 'Battery: Empty', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-book',
				'name'  => __( 'Book', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-book-bookmark',
				'name'  => __( 'Bookmark', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-clipboard',
				'name'  => __( 'Clipboard', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-clipboard-pencil',
				'name'  => __( 'Clipboard: Pencil', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-clipboard-notes',
				'name'  => __( 'Clipboard: Notes', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-crown',
				'name'  => __( 'Crown', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-die-one',
				'name'  => __( 'Dice: 1', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-die-two',
				'name'  => __( 'Dice: 2', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-die-three',
				'name'  => __( 'Dice: 3', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-die-four',
				'name'  => __( 'Dice: 4', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-die-five',
				'name'  => __( 'Dice: 5', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-die-six',
				'name'  => __( 'Dice: 6', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-safety-cone',
				'name'  => __( 'Cone', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-first-aid',
				'name'  => __( 'Firs Aid', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-foot',
				'name'  => __( 'Foot', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-info',
				'name'  => __( 'Info', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-key',
				'name'  => __( 'Key', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-lightbulb',
				'name'  => __( 'Lightbulb', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-map',
				'name'  => __( 'Map', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-mountains',
				'name'  => __( 'Mountains', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-music',
				'name'  => __( 'Music', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-no-dogs',
				'name'  => __( 'No Dogs', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-no-smoking',
				'name'  => __( 'No Smoking', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-paw',
				'name'  => __( 'Paw', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-power',
				'name'  => __( 'Power', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-prohibited',
				'name'  => __( 'Prohibited', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-projection-screen',
				'name'  => __( 'Projection Screen', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-puzzle',
				'name'  => __( 'Puzzle', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-sheriff-badge',
				'name'  => __( 'Sheriff Badge', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-shield',
				'name'  => __( 'Shield', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-skull',
				'name'  => __( 'Skull', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-target',
				'name'  => __( 'Target', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-target-two',
				'name'  => __( 'Target', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-ticket',
				'name'  => __( 'Ticket', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-trees',
				'name'  => __( 'Trees', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'fi-trophy',
				'name'  => __( 'Trophy', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torso',
				'name'  => __( 'Torso', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torso-business',
				'name'  => __( 'Torso: Business', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torso-female',
				'name'  => __( 'Torso: Female', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torsos',
				'name'  => __( 'Torsos', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torsos-all',
				'name'  => __( 'Torsos: All', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torsos-all-female',
				'name'  => __( 'Torsos: All Female', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torsos-male-female',
				'name'  => __( 'Torsos: Male & Female', 'aihub' ),
			),
			array(
				'group' => 'people',
				'id'    => 'fi-torsos-female-male',
				'name'  => __( 'Torsos: Female & Male', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-500px',
				'name'  => '500px',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-adobe',
				'name'  => 'Adobe',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-amazon',
				'name'  => 'Amazon',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-android',
				'name'  => 'Android',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-apple',
				'name'  => 'Apple',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-behance',
				'name'  => 'Behance',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-bing',
				'name'  => 'bing',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-blogger',
				'name'  => 'Blogger',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-css3',
				'name'  => 'CSS3',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-delicious',
				'name'  => 'Delicious',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-designer-news',
				'name'  => 'Designer News',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-deviant-art',
				'name'  => 'deviantArt',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-digg',
				'name'  => 'Digg',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-dribbble',
				'name'  => 'dribbble',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-drive',
				'name'  => 'Drive',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-dropbox',
				'name'  => 'DropBox',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-evernote',
				'name'  => 'Evernote',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-facebook',
				'name'  => 'Facebook',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-flickr',
				'name'  => 'flickr',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-forrst',
				'name'  => 'forrst',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-foursquare',
				'name'  => 'Foursquare',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-game-center',
				'name'  => 'Game Center',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-github',
				'name'  => 'GitHub',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-google-plus',
				'name'  => 'Google+',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-hacker-news',
				'name'  => 'Hacker News',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-hi5',
				'name'  => 'hi5',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-html5',
				'name'  => 'HTML5',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-instagram',
				'name'  => 'Instagram',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-joomla',
				'name'  => 'Joomla!',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-lastfm',
				'name'  => 'last.fm',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-linkedin',
				'name'  => 'LinkedIn',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-medium',
				'name'  => 'Medium',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-myspace',
				'name'  => 'My Space',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-orkut',
				'name'  => 'Orkut',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-path',
				'name'  => 'path',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-picasa',
				'name'  => 'Picasa',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-pinterest',
				'name'  => 'Pinterest',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-rdio',
				'name'  => 'rdio',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-reddit',
				'name'  => 'reddit',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-skype',
				'name'  => 'Skype',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-skillshare',
				'name'  => 'SkillShare',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-smashing-mag',
				'name'  => 'Smashing Mag.',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-snapchat',
				'name'  => 'Snapchat',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-spotify',
				'name'  => 'Spotify',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-squidoo',
				'name'  => 'Squidoo',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-stack-overflow',
				'name'  => 'StackOverflow',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-steam',
				'name'  => 'Steam',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-stumbleupon',
				'name'  => 'StumbleUpon',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-treehouse',
				'name'  => 'TreeHouse',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-tumblr',
				'name'  => 'Tumblr',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-twitter',
				'name'  => 'Twitter',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-windows',
				'name'  => 'Windows',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-xbox',
				'name'  => 'XBox',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-yahoo',
				'name'  => 'Yahoo!',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-yelp',
				'name'  => 'Yelp',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-youtube',
				'name'  => 'YouTube',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-zerply',
				'name'  => 'Zerply',
			),
			array(
				'group' => 'social',
				'id'    => 'fi-social-zurb',
				'name'  => 'Zurb',
			),
		);

		/**
		 * Filter genericon items
		 *
		 * @since 0.1.0
		 * @param array $items Icon names.
		 */
		$items = apply_filters( 'icon_picker_foundations_items', $items );

		return $items;
	}
}
