<?php

require_once dirname( __FILE__ ) . '/font.php';

/**
 * Akar Icons
 *
 * @package Icon_Picker
 * @author  Dzikri Aziz <kvcrvt@gmail.com>
 */
class Icon_Picker_Type_Akar_Icons extends Icon_Picker_Type_Font {

	/**
	 * Icon type ID
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $id = 'akar-icons';

	/**
	 * Icon type name
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $name = 'Akar';

	/**
	 * Icon type version
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $version = '1.1.19';


	/**
	 * Get icon groups
	 *
	 * @since  0.1.0
	 * @return array
	 */
	public function get_groups() {
		$groups = array(
			array(
				'id'   => 'arrows',
				'name' => __( 'Arrows', 'aihub' ),
			),
			array(
				'id'   => 'ecommerce',
				'name' => __( 'Ecommerce', 'aihub' ),
			),
			array(
				'id'   => 'general',
				'name' => __( 'General', 'aihub' ),
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
				'group' => 'arrows',
				'id'    => 'ai-arrow-left',
				'name'  => __( 'Arrow Left', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-right',
				'name'  => __( 'Arrow Right', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-up',
				'name'  => __( 'Arrow Up', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-down',
				'name'  => __( 'Arrow Down', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-down-left',
				'name'  => __( 'Arrow Down Left', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-up-left',
				'name'  => __( 'Arrow Up Left', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-up-right',
				'name'  => __( 'Arrow Up Right', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-down-right',
				'name'  => __( 'Arrow Down Right', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-chevron-left',
				'name'  => __( 'Chevron Left', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-chevron-right-small',
				'name'  => __( 'Chevron Right Small', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-chevron-right',
				'name'  => __( 'Chevron Right', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-chevron-up',
				'name'  => __( 'Chevron Up', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-chevron-down-small',
				'name'  => __( 'Chevron Down Small', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-chevron-down',
				'name'  => __( 'Chevron Down', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-cycle',
				'name'  => __( 'Arrow Cycle', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-clockwise',
				'name'  => __( 'Arrow Clockwise', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-counter-clockwise',
				'name'  => __( 'Arrow Counter Clockwise', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-back-thick',
				'name'  => __( 'Arrow Back Thick', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-back-thick-fill',
				'name'  => __( 'Arrow Back Thick Fill', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-forward-thick',
				'name'  => __( 'Arrow Forward Thick', 'aihub' ),
			),
			array(
				'group' => 'arrows',
				'id'    => 'ai-arrow-forward-thick-fill',
				'name'  => __( 'Arrow Forward Thick Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-width',
				'name'  => __( 'Width', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-height',
				'name'  => __( 'Height', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-enlarge',
				'name'  => __( 'Enlarge', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-reduce',
				'name'  => __( 'Reduce', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-left-thick',
				'name'  => __( 'Arrow Left Thick', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-down-thick',
				'name'  => __( 'Arrow Down Thick', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-right-thick',
				'name'  => __( 'Arrow Right Thick', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-up-thick',
				'name'  => __( 'Arrow Up Thick', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-back',
				'name'  => __( 'Arrow Back', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-forward',
				'name'  => __( 'Arrow Forward', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-left',
				'name'  => __( 'Triangle Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-right-fill',
				'name'  => __( 'Triangle Right Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-right',
				'name'  => __( 'Triangle Right', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-up-fill',
				'name'  => __( 'Triangle Up Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-up',
				'name'  => __( 'Triangle Up', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-down-fill',
				'name'  => __( 'Triangle Down Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-down',
				'name'  => __( 'Triangle Down', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-right',
				'name'  => __( 'Circle Triangle Right', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-left-fill',
				'name'  => __( 'Circle Triangle Left Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-left',
				'name'  => __( 'Circle Triangle Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-up',
				'name'  => __( 'Circle Triangle Up', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-down',
				'name'  => __( 'Circle Triangle Down', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-left-small',
				'name'  => __( 'Circle Chevron Left Small', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-left',
				'name'  => __( 'Circle Chevron Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-right',
				'name'  => __( 'Circle Chevron Right', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-up',
				'name'  => __( 'Circle Chevron Up', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-down',
				'name'  => __( 'Circle Chevron Down', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-right-fill',
				'name'  => __( 'Circle Triangle Right Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-left-fill',
				'name'  => __( 'Circle Triangle Left Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-up-fill',
				'name'  => __( 'Circle Triangle Up Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-triangle-down-fill',
				'name'  => __( 'Circle Triangle Down Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-left-fill',
				'name'  => __( 'Circle Chevron Left Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-right-fill',
				'name'  => __( 'Circle Chevron Right Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-up-fill',
				'name'  => __( 'Circle Chevron Up Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-chevron-down-fill',
				'name'  => __( 'Circle Chevron Down Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chevron-horizontal',
				'name'  => __( 'Chevron Horizontal', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chevron-vertical',
				'name'  => __( 'Chevron Vertical', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-up-down',
				'name'  => __( 'Arrow Up Down', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-right-left',
				'name'  => __( 'Arrow Right Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-shuffle',
				'name'  => __( 'Arrow Shuffle', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-arrow-repeat',
				'name'  => __( 'Arrow Repeat', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-fork-right',
				'name'  => __( 'Fork Right', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-fork-left',
				'name'  => __( 'Fork Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-plus',
				'name'  => __( 'Plus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-minus',
				'name'  => __( 'Minus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-cross',
				'name'  => __( 'Cross', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-check',
				'name'  => __( 'Check', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-question',
				'name'  => __( 'Question', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-alert',
				'name'  => __( 'Circle Alert', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-x',
				'name'  => __( 'Circle X', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-check',
				'name'  => __( 'Circle Check', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-plus',
				'name'  => __( 'Circle Plus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-minus',
				'name'  => __( 'Circle Minus', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-alert',
				'name'  => __( 'Triangle Alert', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-stop',
				'name'  => __( 'Stop', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-info',
				'name'  => __( 'Info', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-play',
				'name'  => __( 'Play', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-pause',
				'name'  => __( 'Pause', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-command',
				'name'  => __( 'Command', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sound-down',
				'name'  => __( 'Sound Down', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sound-on',
				'name'  => __( 'Sound On', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sound-off',
				'name'  => __( 'Sound Off', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sound-up',
				'name'  => __( 'Sound Up', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-infinite',
				'name'  => __( 'Infinite', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-airplay-audio',
				'name'  => __( 'Airplay Audio', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-airplay-video',
				'name'  => __( 'Airplay Video', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-miniplayer',
				'name'  => __( 'Miniplayer', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-text-align-left',
				'name'  => __( 'Text Align Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-text-align-center',
				'name'  => __( 'Text Align Center', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-text-align-right',
				'name'  => __( 'Text Align Right', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-threads-fill',
				'name'  => __( 'Threads Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-text-align-justified',
				'name'  => __( 'Text Align Justified', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-mention',
				'name'  => __( 'Mention', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-heart',
				'name'  => __( 'Heart', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-full-screen',
				'name'  => __( 'Full Screen', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-normal-screen',
				'name'  => __( 'Normal Screen', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-left',
				'name'  => __( 'Align Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-horizontal-center',
				'name'  => __( 'Align Horizontal Center', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-right',
				'name'  => __( 'Align Right', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-top',
				'name'  => __( 'Align Top', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-vertical-center',
				'name'  => __( 'Align Vertical Center', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-bottom',
				'name'  => __( 'Align Bottom', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-share-box',
				'name'  => __( 'Share Box', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-download',
				'name'  => __( 'Download', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-to-top',
				'name'  => __( 'Align To Top', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-to-middle',
				'name'  => __( 'Align To Middle', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-align-to-bottom',
				'name'  => __( 'Align To Bottom', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-block',
				'name'  => __( 'Block', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-more-horizontal-fill',
				'name'  => __( 'More Horizontal Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-more-vertical-fill',
				'name'  => __( 'More Vertical Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-wifi',
				'name'  => __( 'Wifi', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-bluetooth',
				'name'  => __( 'Bluetooth', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-location',
				'name'  => __( 'Location', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-link-chain',
				'name'  => __( 'Link Chain', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-link-out',
				'name'  => __( 'Link Out', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sign-out',
				'name'  => __( 'Sign Out', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-hashtag',
				'name'  => __( 'Hashtag', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-grid',
				'name'  => __( 'Grid', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-link-on',
				'name'  => __( 'Link On', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-link-off',
				'name'  => __( 'Link Off', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-bubble',
				'name'  => __( 'Chat Bubble', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-add',
				'name'  => __( 'Chat Add', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-remove',
				'name'  => __( 'Chat Remove', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-zoom-in',
				'name'  => __( 'Zoom In', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-zoom-out',
				'name'  => __( 'Zoom Out', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-box',
				'name'  => __( 'Box', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-check-box',
				'name'  => __( 'Check Box', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-check-box-fill',
				'name'  => __( 'Check Box Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-rss',
				'name'  => __( 'Rss', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-backspace',
				'name'  => __( 'Backspace', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-backspace-fill',
				'name'  => __( 'Backspace Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-double-check',
				'name'  => __( 'Double Check', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-drag-vertical-fill',
				'name'  => __( 'Drag Vertical Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-drag-horizontal-fill',
				'name'  => __( 'Drag Horizontal Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dot-grid-fill',
				'name'  => __( 'Dot Grid Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-dots',
				'name'  => __( 'Chat Dots', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-error',
				'name'  => __( 'Chat Error', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-health',
				'name'  => __( 'Health', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-question-fill',
				'name'  => __( 'Question Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-alert-fill',
				'name'  => __( 'Circle Alert Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-x-fill',
				'name'  => __( 'Circle X Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-plus-fill',
				'name'  => __( 'Circle Plus Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-minus-fill',
				'name'  => __( 'Circle Minus Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-circle-check-fill',
				'name'  => __( 'Circle Check Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-triangle-alert-fill',
				'name'  => __( 'Triangle Alert Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-stop-fill',
				'name'  => __( 'Stop Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-info-fill',
				'name'  => __( 'Info Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-cloud-download',
				'name'  => __( 'Cloud Download', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-cloud-upload',
				'name'  => __( 'Cloud Upload', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-network',
				'name'  => __( 'Network', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-toggle-off',
				'name'  => __( 'Toggle Off', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-toggle-on',
				'name'  => __( 'Toggle On', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-toggle-off-fill',
				'name'  => __( 'Toggle Off Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-toggle-on-fill',
				'name'  => __( 'Toggle On Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-three-line-horizontal',
				'name'  => __( 'Three Line Horizontal', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-three-line-vertical',
				'name'  => __( 'Three Line Vertical', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-two-line-horizontal',
				'name'  => __( 'Two Line Horizontal', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-two-line-vertical',
				'name'  => __( 'Two Line Vertical', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-pointer-left-fill',
				'name'  => __( 'Pointer Left Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-pointer-right-fill',
				'name'  => __( 'Pointer Right Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-pointer-up-fill',
				'name'  => __( 'Pointer Up Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-pointer-down-fill',
				'name'  => __( 'Pointer Down Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-approve',
				'name'  => __( 'Chat Approve', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-question',
				'name'  => __( 'Chat Question', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chat-edit',
				'name'  => __( 'Chat Edit', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-cursor',
				'name'  => __( 'Cursor', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-frame',
				'name'  => __( 'Frame', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-slice',
				'name'  => __( 'Slice', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-percentage',
				'name'  => __( 'Percentage', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-check-in',
				'name'  => __( 'Check In', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-video',
				'name'  => __( 'Video', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-cut',
				'name'  => __( 'Cut', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-filter',
				'name'  => __( 'Filter', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-settings-horizontal',
				'name'  => __( 'Settings Horizontal', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-settings-vertical',
				'name'  => __( 'Settings Vertical', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-ascending',
				'name'  => __( 'Ascending', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-descending',
				'name'  => __( 'Descending', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-statistic-up',
				'name'  => __( 'Statistic Up', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-statistic-down',
				'name'  => __( 'Statistic Down', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-panel-right',
				'name'  => __( 'Panel Right', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-panel-left',
				'name'  => __( 'Panel Left', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-panel-split',
				'name'  => __( 'Panel Split', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dashboard',
				'name'  => __( 'Dashboard', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-panel-bottom',
				'name'  => __( 'Panel Bottom', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-panel-top',
				'name'  => __( 'Panel Top', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-panel-split-row',
				'name'  => __( 'Panel Split Row', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-panel-split-column',
				'name'  => __( 'Panel Split Column', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-language',
				'name'  => __( 'Language', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sort',
				'name'  => __( 'Sort', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-equal',
				'name'  => __( 'Equal', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-equal-fill',
				'name'  => __( 'Equal Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-radio',
				'name'  => __( 'Radio', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-radio-fill',
				'name'  => __( 'Radio Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-save',
				'name'  => __( 'Save', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-augmented-reality',
				'name'  => __( 'Augmented Reality', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-ribbon',
				'name'  => __( 'Ribbon', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-phone',
				'name'  => __( 'Phone', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-attach',
				'name'  => __( 'Attach', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-thunder',
				'name'  => __( 'Thunder', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-send',
				'name'  => __( 'Send', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sun',
				'name'  => __( 'Sun', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-moon',
				'name'  => __( 'Moon', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-pencil',
				'name'  => __( 'Pencil', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-pin',
				'name'  => __( 'Pin', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-draft',
				'name'  => __( 'Draft', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-eye-open',
				'name'  => __( 'Eye Open', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-eye-slashed',
				'name'  => __( 'Eye Slashed', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-eye-closed',
				'name'  => __( 'Eye Closed', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-airpods',
				'name'  => __( 'Airpods', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-paper',
				'name'  => __( 'Paper', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-file',
				'name'  => __( 'File', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-headphone',
				'name'  => __( 'Headphone', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-mobile-device',
				'name'  => __( 'Mobile Device', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-tablet-device',
				'name'  => __( 'Tablet Device', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-laptop-device',
				'name'  => __( 'Laptop Device', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-desktop-device',
				'name'  => __( 'Desktop Device', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-watch-device',
				'name'  => __( 'Watch Device', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-wallet',
				'name'  => __( 'Wallet', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-search',
				'name'  => __( 'Search', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-lock-on',
				'name'  => __( 'Lock On', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-lock-off',
				'name'  => __( 'Lock Off', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-camera',
				'name'  => __( 'Camera', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-image',
				'name'  => __( 'Image', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-folder',
				'name'  => __( 'Folder', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-folder-add',
				'name'  => __( 'Folder Add', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-calendar',
				'name'  => __( 'Calendar', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-bell',
				'name'  => __( 'Bell', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-battery-empty',
				'name'  => __( 'Battery Empty', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-battery-low',
				'name'  => __( 'Battery Low', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-battery-medium',
				'name'  => __( 'Battery Medium', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-battery-full',
				'name'  => __( 'Battery Full', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-flashlight',
				'name'  => __( 'Flashlight', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-calculator',
				'name'  => __( 'Calculator', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-alarm',
				'name'  => __( 'Alarm', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-globe',
				'name'  => __( 'Globe', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-book-open',
				'name'  => __( 'Book Open', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-cloud',
				'name'  => __( 'Cloud', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-envelope',
				'name'  => __( 'Envelope', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-shopping-bag',
				'name'  => __( 'Shopping Bag', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-gift',
				'name'  => __( 'Gift', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-map',
				'name'  => __( 'Map', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-shield',
				'name'  => __( 'Shield', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-tag',
				'name'  => __( 'Tag', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-gear',
				'name'  => __( 'Gear', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-flag',
				'name'  => __( 'Flag', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-ticket',
				'name'  => __( 'Ticket', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-bug',
				'name'  => __( 'Bug', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-copy',
				'name'  => __( 'Copy', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-lifesaver',
				'name'  => __( 'Lifesaver', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-star',
				'name'  => __( 'Star', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-battery-charging',
				'name'  => __( 'Battery Charging', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-trophy',
				'name'  => __( 'Trophy', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-leaf',
				'name'  => __( 'Leaf', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-schedule',
				'name'  => __( 'Schedule', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-money',
				'name'  => __( 'Money', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-scissor',
				'name'  => __( 'Scissor', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-coin',
				'name'  => __( 'Coin', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-telescope',
				'name'  => __( 'Telescope', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-planet',
				'name'  => __( 'Planet', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-game-controller',
				'name'  => __( 'Game Controller', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-vr-ar',
				'name'  => __( 'Vr Ar', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-computing',
				'name'  => __( 'Computing', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-inbox',
				'name'  => __( 'Inbox', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-light-bulb',
				'name'  => __( 'Light Bulb', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-chess',
				'name'  => __( 'Chess', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-trash-can',
				'name'  => __( 'Trash Can', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-microphone',
				'name'  => __( 'Microphone', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-coffee',
				'name'  => __( 'Coffee', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-credit-card',
				'name'  => __( 'Credit Card', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-utensils',
				'name'  => __( 'Utensils', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-radish',
				'name'  => __( 'Radish', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-clipboard',
				'name'  => __( 'Clipboard', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-bicycle',
				'name'  => __( 'Bicycle', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-plane',
				'name'  => __( 'Plane', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-plane-fill',
				'name'  => __( 'Plane Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-jar',
				'name'  => __( 'Jar', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-glasses',
				'name'  => __( 'Glasses', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-plant',
				'name'  => __( 'Plant', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-edit',
				'name'  => __( 'Edit', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-trash-bin',
				'name'  => __( 'Trash Bin', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sun-fill',
				'name'  => __( 'Sun Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-moon-fill',
				'name'  => __( 'Moon Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-key-cap',
				'name'  => __( 'Key Cap', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-newspaper',
				'name'  => __( 'Newspaper', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-door',
				'name'  => __( 'Door', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-water',
				'name'  => __( 'Water', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-fire',
				'name'  => __( 'Fire', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-air',
				'name'  => __( 'Air', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-home',
				'name'  => __( 'Home', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-umbrella',
				'name'  => __( 'Umbrella', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-togo-cup',
				'name'  => __( 'Togo Cup', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-devices',
				'name'  => __( 'Devices', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'ai-shipping-box-v1',
				'name'  => __( 'Shipping Box V1', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'ai-shipping-box-v2',
				'name'  => __( 'Shipping Box V2', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'ai-cart',
				'name'  => __( 'Cart', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'ai-basket',
				'name'  => __( 'Basket', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-open-envelope',
				'name'  => __( 'Open Envelope', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-clock',
				'name'  => __( 'Clock', 'aihub' ),
			),
			array(
				'group' => 'ecommerce',
				'id'    => 'ai-truck',
				'name'  => __( 'Truck', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-wine-glass',
				'name'  => __( 'Wine Glass', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-x-fill',
				'name'  => __( 'X Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-x-small',
				'name'  => __( 'X Small', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-vape-kit',
				'name'  => __( 'Vape Kit', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-briefcase',
				'name'  => __( 'Briefcase', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-boat',
				'name'  => __( 'Boat', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-crown',
				'name'  => __( 'Crown', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sword',
				'name'  => __( 'Sword', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-double-sword',
				'name'  => __( 'Double Sword', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-key',
				'name'  => __( 'Key', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dental',
				'name'  => __( 'Dental', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-cake',
				'name'  => __( 'Cake', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-book-close',
				'name'  => __( 'Book Close', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-sparkles',
				'name'  => __( 'Sparkles', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-music',
				'name'  => __( 'Music', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-music-note',
				'name'  => __( 'Music Note', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-music-album',
				'name'  => __( 'Music Album', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-music-album-fill',
				'name'  => __( 'Music Album Fill', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-bank',
				'name'  => __( 'Bank', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-paper-airplane',
				'name'  => __( 'Paper Airplane', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-home-alt1',
				'name'  => __( 'Home Alt1', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-credit-card-alt1',
				'name'  => __( 'Credit Card Alt1', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-receipt',
				'name'  => __( 'Receipt', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-hammer',
				'name'  => __( 'Hammer', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-data',
				'name'  => __( 'Data', 'aihub' ),
			),

			array(
				'group' => 'general',
				'id'    => 'ai-dice-6',
				'name'  => __( 'Dice6', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dice-5',
				'name'  => __( 'Dice5', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dice-4',
				'name'  => __( 'Dice 4', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dice-3',
				'name'  => __( 'Dice 3', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dice-2',
				'name'  => __( 'Dice 2', 'aihub' ),
			),
			array(
				'group' => 'general',
				'id'    => 'ai-dice-1',
				'name'  => __( 'Dice 1', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-person',
				'name'  => __( 'Person', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-person-add',
				'name'  => __( 'Person Add', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-person-check',
				'name'  => __( 'Person Check', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-person-cross',
				'name'  => __( 'Person Cross', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-face-very-happy',
				'name'  => __( 'Face Very Happy', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-face-happy',
				'name'  => __( 'Face Happy', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-face-neutral',
				'name'  => __( 'Face Neutral', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-face-sad',
				'name'  => __( 'Face Sad', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-face-very-sad',
				'name'  => __( 'Face Very Sad', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-face-wink',
				'name'  => __( 'Face Wink', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-thumbs-up',
				'name'  => __( 'Thumbs Up', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-thumbs-down',
				'name'  => __( 'Thumbs Down', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-victory-hand',
				'name'  => __( 'Victory Hand', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-pointing-up',
				'name'  => __( 'Pointing Up', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-rock-on',
				'name'  => __( 'Rock On', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-people-multiple',
				'name'  => __( 'People Multiple', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-people-group',
				'name'  => __( 'People Group', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-hand',
				'name'  => __( 'Hand', 'aihub' ),
			),
			array(
				'group' => 'person',
				'id'    => 'ai-pointer-hand',
				'name'  => __( 'Pointer Hand', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-facebook-fill',
				'name'  => __( 'Facebook Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-twitter-fill',
				'name'  => __( 'Twitter Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-linkedin-box-fill',
				'name'  => __( 'Linkedin Box Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-dribbble-fill',
				'name'  => __( 'Dribbble Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-reddit-fill',
				'name'  => __( 'Reddit Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-tumblr-fill',
				'name'  => __( 'Tumblr Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-pinterest-fill',
				'name'  => __( 'Pinterest Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-vk-fill',
				'name'  => __( 'Vk Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-youtube-fill',
				'name'  => __( 'Youtube Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-instagram-fill',
				'name'  => __( 'Instagram Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-figma-fill',
				'name'  => __( 'Figma Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-github-fill',
				'name'  => __( 'Github Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-telegram-fill',
				'name'  => __( 'Telegram Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-dropbox-fill',
				'name'  => __( 'Dropbox Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-google-fill',
				'name'  => __( 'Google Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-google-contained-fill',
				'name'  => __( 'Google Contained Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-android-fill',
				'name'  => __( 'Android Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-bitcoin-fill',
				'name'  => __( 'Bitcoin Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-spotify-fill',
				'name'  => __( 'Spotify Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-soundcloud-fill',
				'name'  => __( 'Soundcloud Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-codepen-fill',
				'name'  => __( 'Codepen Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-whatsapp-fill',
				'name'  => __( 'Whatsapp Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-linkedin-fill',
				'name'  => __( 'Linkedin Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-vimeo-fill',
				'name'  => __( 'Vimeo Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-medium-fill',
				'name'  => __( 'Medium Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-zoom-fill',
				'name'  => __( 'Zoom Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-slack-fill',
				'name'  => __( 'Slack Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-stack-overflow-fill',
				'name'  => __( 'Stack Overflow Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-twitch-fill',
				'name'  => __( 'Twitch Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-snapchat-fill',
				'name'  => __( 'Snapchat Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-octocat-fill',
				'name'  => __( 'Octocat Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-discord-fill',
				'name'  => __( 'Discord Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-behance-fill',
				'name'  => __( 'Behance Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-postgresql-fill',
				'name'  => __( 'Postgresql Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-price-cut',
				'name'  => __( 'Price Cut', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-mastodon-fill',
				'name'  => __( 'Mastodon Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-tiktok-fill',
				'name'  => __( 'Tiktok Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-unsplash-fill',
				'name'  => __( 'Unsplash Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-product-hunt-fill',
				'name'  => __( 'Product Hunt Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-circle',
				'name'  => __( 'Circle', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-circle-fill',
				'name'  => __( 'Circle Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-triangle',
				'name'  => __( 'Triangle', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-triangle-fill',
				'name'  => __( 'Triangle Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-square',
				'name'  => __( 'Square', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-square-fill',
				'name'  => __( 'Square Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-tetragon',
				'name'  => __( 'Tetragon', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-tetragon-fill',
				'name'  => __( 'Tetragon Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-pentagon',
				'name'  => __( 'Pentagon', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-pentagon-fill',
				'name'  => __( 'Pentagon Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-hexagon',
				'name'  => __( 'Hexagon', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-history',
				'name'  => __( 'History', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-hexagon-fill',
				'name'  => __( 'Hexagon Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-heptagon',
				'name'  => __( 'Heptagon', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-heptagon-fill',
				'name'  => __( 'Heptagon Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-octagon',
				'name'  => __( 'Octagon', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-octagon-fill',
				'name'  => __( 'Octagon Fill', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-oval',
				'name'  => __( 'Oval', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-parallelogram',
				'name'  => __( 'Parallelogram', 'aihub' ),
			),
			array(
				'group' => 'shapes',
				'id'    => 'ai-diamond',
				'name'  => __( 'Diamond', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-bootstrap-fill',
				'name'  => __( 'Bootstrap Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-react-fill',
				'name'  => __( 'React Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-angular-fill',
				'name'  => __( 'Angular Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-vue-fill',
				'name'  => __( 'Vue Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-javascript-fill',
				'name'  => __( 'Javascript Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-node-fill',
				'name'  => __( 'Node Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-html-fill',
				'name'  => __( 'Html Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-css-fill',
				'name'  => __( 'Css Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-vercel-fill',
				'name'  => __( 'Vercel Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-nextjs-fill',
				'name'  => __( 'Nextjs Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-redux-fill',
				'name'  => __( 'Redux Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-python-fill',
				'name'  => __( 'Python Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-graphql-fill',
				'name'  => __( 'Graphql Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-php-fill',
				'name'  => __( 'Php Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-jquery-fill',
				'name'  => __( 'Jquery Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-sass-fill',
				'name'  => __( 'Sass Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-gatsby-fill',
				'name'  => __( 'Gatsby Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-npm-fill',
				'name'  => __( 'Npm Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-yarn-fill',
				'name'  => __( 'Yarn Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-yelp-fill',
				'name'  => __( 'Yelp Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-django-fill',
				'name'  => __( 'Django Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-vscode-fill',
				'name'  => __( 'Vscode Fill', 'aihub' ),
			),
			array(
				'group' => 'social',
				'id'    => 'ai-typescript-fill',
				'name'  => __( 'Typescript Fill', 'aihub' ),
			),
		);

		/**
		 * Filter genericon items
		 *
		 * @since 0.1.0
		 * @param array $items Icon names.
		 */
		$items = apply_filters( 'icon_picker_akar_items', $items );

		return $items;
	}
}
