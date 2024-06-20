<?php
/**
 * Genericons
 *
 * @package Icon_Picker
 * @author  Dzikri Aziz <kvcrvt@gmail.com>
 */
class Icon_Picker_Type_Genericons extends Icon_Picker_Type_Font {

	/**
	 * Icon type ID
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $id = 'genericon';

	/**
	 * Icon type name
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $name = 'Genericons';

	/**
	 * Icon type version
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $version = '3.4';

	/**
	 * Stylesheet ID
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $stylesheet_id = 'genericons';


	/**
	 * Get icon groups
	 *
	 * @since  0.1.0
	 * @return array
	 */
	public function get_groups() {
		$groups = array(
			array(
				'id'   => 'actions',
				'name' => __( 'Actions', 'aihub' ),
			),
			array(
				'id'   => 'media-player',
				'name' => __( 'Media Player', 'aihub' ),
			),
			array(
				'id'   => 'meta',
				'name' => __( 'Meta', 'aihub' ),
			),
			array(
				'id'   => 'misc',
				'name' => __( 'Misc.', 'aihub' ),
			),
			array(
				'id'   => 'places',
				'name' => __( 'Places', 'aihub' ),
			),
			array(
				'id'   => 'post-formats',
				'name' => __( 'Post Formats', 'aihub' ),
			),
			array(
				'id'   => 'text-editor',
				'name' => __( 'Text Editor', 'aihub' ),
			),
			array(
				'id'   => 'social',
				'name' => __( 'Social', 'aihub' ),
			),
		);

		/**
		 * Filter genericon groups
		 *
		 * @since 0.1.0
		 * @param array $groups Icon groups.
		 */
		$groups = apply_filters( 'icon_picker_genericon_groups', $groups );

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
				'group' => 'actions',
				'id'    => 'genericon-checkmark',
				'name'  => __( 'Checkmark', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-close',
				'name'  => __( 'Close', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-close-alt',
				'name'  => __( 'Close', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-dropdown',
				'name'  => __( 'Dropdown', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-dropdown-left',
				'name'  => __( 'Dropdown left', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-collapse',
				'name'  => __( 'Collapse', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-expand',
				'name'  => __( 'Expand', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-help',
				'name'  => __( 'Help', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-info',
				'name'  => __( 'Info', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-lock',
				'name'  => __( 'Lock', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-maximize',
				'name'  => __( 'Maximize', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-minimize',
				'name'  => __( 'Minimize', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-plus',
				'name'  => __( 'Plus', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-minus',
				'name'  => __( 'Minus', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-previous',
				'name'  => __( 'Previous', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-next',
				'name'  => __( 'Next', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-move',
				'name'  => __( 'Move', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-hide',
				'name'  => __( 'Hide', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-show',
				'name'  => __( 'Show', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-print',
				'name'  => __( 'Print', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-rating-empty',
				'name'  => __( 'Rating: Empty', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-rating-half',
				'name'  => __( 'Rating: Half', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-rating-full',
				'name'  => __( 'Rating: Full', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-refresh',
				'name'  => __( 'Refresh', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-reply',
				'name'  => __( 'Reply', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-reply-alt',
				'name'  => __( 'Reply alt', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-reply-single',
				'name'  => __( 'Reply single', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-search',
				'name'  => __( 'Search', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-send-to-phone',
				'name'  => __( 'Send to', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-send-to-tablet',
				'name'  => __( 'Send to', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-share',
				'name'  => __( 'Share', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-shuffle',
				'name'  => __( 'Shuffle', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-spam',
				'name'  => __( 'Spam', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-subscribe',
				'name'  => __( 'Subscribe', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-subscribed',
				'name'  => __( 'Subscribed', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-unsubscribe',
				'name'  => __( 'Unsubscribe', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-top',
				'name'  => __( 'Top', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-unapprove',
				'name'  => __( 'Unapprove', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-zoom',
				'name'  => __( 'Zoom', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-unzoom',
				'name'  => __( 'Unzoom', 'aihub' ),
			),
			array(
				'group' => 'actions',
				'id'    => 'genericon-xpost',
				'name'  => __( 'X-Post', 'aihub' ),
			),
			array(
				'group' => 'media-player',
				'id'    => 'genericon-skip-back',
				'name'  => __( 'Skip back', 'aihub' ),
			),
			array(
				'group' => 'media-player',
				'id'    => 'genericon-rewind',
				'name'  => __( 'Rewind', 'aihub' ),
			),
			array(
				'group' => 'media-player',
				'id'    => 'genericon-play',
				'name'  => __( 'Play', 'aihub' ),
			),
			array(
				'group' => 'media-player',
				'id'    => 'genericon-pause',
				'name'  => __( 'Pause', 'aihub' ),
			),
			array(
				'group' => 'media-player',
				'id'    => 'genericon-stop',
				'name'  => __( 'Stop', 'aihub' ),
			),
			array(
				'group' => 'media-player',
				'id'    => 'genericon-fastforward',
				'name'  => __( 'Fast Forward', 'aihub' ),
			),
			array(
				'group' => 'media-player',
				'id'    => 'genericon-skip-ahead',
				'name'  => __( 'Skip ahead', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-comment',
				'name'  => __( 'Comment', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-category',
				'name'  => __( 'Category', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-hierarchy',
				'name'  => __( 'Hierarchy', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-tag',
				'name'  => __( 'Tag', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-time',
				'name'  => __( 'Time', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-user',
				'name'  => __( 'User', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-day',
				'name'  => __( 'Day', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-week',
				'name'  => __( 'Week', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-month',
				'name'  => __( 'Month', 'aihub' ),
			),
			array(
				'group' => 'meta',
				'id'    => 'genericon-pinned',
				'name'  => __( 'Pinned', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-uparrow',
				'name'  => __( 'Arrow Up', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-downarrow',
				'name'  => __( 'Arrow Down', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-leftarrow',
				'name'  => __( 'Arrow Left', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-rightarrow',
				'name'  => __( 'Arrow Right', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-activity',
				'name'  => __( 'Activity', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-bug',
				'name'  => __( 'Bug', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-book',
				'name'  => __( 'Book', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-cart',
				'name'  => __( 'Cart', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-cloud-download',
				'name'  => __( 'Cloud Download', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-cloud-upload',
				'name'  => __( 'Cloud Upload', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-cog',
				'name'  => __( 'Cog', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-document',
				'name'  => __( 'Document', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-dot',
				'name'  => __( 'Dot', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-download',
				'name'  => __( 'Download', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-draggable',
				'name'  => __( 'Draggable', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-ellipsis',
				'name'  => __( 'Ellipsis', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-external',
				'name'  => __( 'External', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-feed',
				'name'  => __( 'Feed', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-flag',
				'name'  => __( 'Flag', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-fullscreen',
				'name'  => __( 'Fullscreen', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-handset',
				'name'  => __( 'Handset', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-heart',
				'name'  => __( 'Heart', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-key',
				'name'  => __( 'Key', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-mail',
				'name'  => __( 'Mail', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-menu',
				'name'  => __( 'Menu', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-microphone',
				'name'  => __( 'Microphone', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-notice',
				'name'  => __( 'Notice', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-paintbrush',
				'name'  => __( 'Paint Brush', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-phone',
				'name'  => __( 'Phone', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-picture',
				'name'  => __( 'Picture', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-plugin',
				'name'  => __( 'Plugin', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-portfolio',
				'name'  => __( 'Portfolio', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-star',
				'name'  => __( 'Star', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-summary',
				'name'  => __( 'Summary', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-tablet',
				'name'  => __( 'Tablet', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-videocamera',
				'name'  => __( 'Video Camera', 'aihub' ),
			),
			array(
				'group' => 'misc',
				'id'    => 'genericon-warning',
				'name'  => __( 'Warning', 'aihub' ),
			),
			array(
				'group' => 'places',
				'id'    => 'genericon-404',
				'name'  => __( '404', 'aihub' ),
			),
			array(
				'group' => 'places',
				'id'    => 'genericon-trash',
				'name'  => __( 'Trash', 'aihub' ),
			),
			array(
				'group' => 'places',
				'id'    => 'genericon-cloud',
				'name'  => __( 'Cloud', 'aihub' ),
			),
			array(
				'group' => 'places',
				'id'    => 'genericon-home',
				'name'  => __( 'Home', 'aihub' ),
			),
			array(
				'group' => 'places',
				'id'    => 'genericon-location',
				'name'  => __( 'Location', 'aihub' ),
			),
			array(
				'group' => 'places',
				'id'    => 'genericon-sitemap',
				'name'  => __( 'Sitemap', 'aihub' ),
			),
			array(
				'group' => 'places',
				'id'    => 'genericon-website',
				'name'  => __( 'Website', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-standard',
				'name'  => __( 'Standard', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-aside',
				'name'  => __( 'Aside', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-image',
				'name'  => __( 'Image', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-gallery',
				'name'  => __( 'Gallery', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-video',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-status',
				'name'  => __( 'Status', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-quote',
				'name'  => __( 'Quote', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-link',
				'name'  => __( 'Link', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-chat',
				'name'  => __( 'Chat', 'aihub' ),
			),
			array(
				'group' => 'post-formats',
				'id'    => 'genericon-audio',
				'name'  => __( 'Audio', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'genericon-anchor',
				'name'  => __( 'Anchor', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'genericon-attachment',
				'name'  => __( 'Attachment', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'genericon-edit',
				'name'  => __( 'Edit', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'genericon-code',
				'name'  => __( 'Code', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'genericon-bold',
				'name'  => __( 'Bold', 'aihub' ),
			),
			array(
				'group' => 'text-editor',
				'id'    => 'genericon-italic',
				'name'  => __( 'Italic', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-codepen',
				'name'  => 'CodePen',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-digg',
				'name'  => 'Digg',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-dribbble',
				'name'  => 'Dribbble',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-dropbox',
				'name'  => 'DropBox',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-facebook',
				'name'  => 'Facebook',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-facebook-alt',
				'name'  => 'Facebook',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-flickr',
				'name'  => 'Flickr',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-foursquare',
				'name'  => 'Foursquare',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-github',
				'name'  => 'GitHub',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-googleplus',
				'name'  => 'Google+',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-googleplus-alt',
				'name'  => 'Google+',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-instagram',
				'name'  => 'Instagram',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-linkedin',
				'name'  => 'LinkedIn',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-linkedin-alt',
				'name'  => 'LinkedIn',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-path',
				'name'  => 'Path',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-pinterest',
				'name'  => 'Pinterest',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-pinterest-alt',
				'name'  => 'Pinterest',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-pocket',
				'name'  => 'Pocket',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-polldaddy',
				'name'  => 'PollDaddy',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-reddit',
				'name'  => 'Reddit',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-skype',
				'name'  => 'Skype',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-spotify',
				'name'  => 'Spotify',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-stumbleupon',
				'name'  => 'StumbleUpon',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-tumblr',
				'name'  => 'Tumblr',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-twitch',
				'name'  => 'Twitch',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-twitter',
				'name'  => 'Twitter',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-vimeo',
				'name'  => 'Vimeo',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-wordpress',
				'name'  => 'WordPress',
			),
			array(
				'group' => 'social',
				'id'    => 'genericon-youtube',
				'name'  => 'Youtube',
			),
		);

		/**
		 * Filter genericon items
		 *
		 * @since 0.1.0
		 * @param array $items Icon names.
		 */
		$items = apply_filters( 'icon_picker_genericon_items', $items );

		return $items;
	}
}
