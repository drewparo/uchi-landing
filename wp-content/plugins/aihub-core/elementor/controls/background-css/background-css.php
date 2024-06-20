<?php

use Elementor\Controls_Manager;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor background control.
 *
 * A base control for creating background control. Displays input fields to define
 * the background color, background image, background gradient or background video.
 *
 * @since 1.0.0
 */
class Liquid_Group_Control_Background_CSS extends \Elementor\Group_Control_Base {

	/**
	 * Fields.
	 *
	 * Holds all the background control fields.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @static
	 *
	 * @var array Background control fields.
	 */
	protected static $fields;

	/**
	 * Background Types.
	 *
	 * Holds all the available background types.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var array
	 */
	private static $background_types;

	/**
	 * css attribute
	 *
	 * background is the default. it can be something else like --lqd-accordion-i-bg
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var string
	 */
	private static $css_attr;

	/**
	 * Get background control type.
	 *
	 * Retrieve the control type, in this case `background`.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Control type.
	 */
	public static function get_type() {
		return 'liquid-background-css';
	}

	/**
	 * Get background control types.
	 *
	 * Retrieve available background types.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array Available background types.
	 */
	public static function get_background_types() {
		if ( null === self::$background_types ) {
			self::$background_types = self::get_default_background_types();
		}

		return self::$background_types;
	}

	/**
	 * Get css attribute
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string
	 */
	public static function get_css_attr() {
		if ( null === self::$css_attr ) {
			self::$css_attr = self::get_default_css_attr();
		}

		return self::$css_attr;
	}

	/**
	 * Get Default background types.
	 *
	 * Retrieve background control initial types.
	 *
	 * @since 2.0.0
	 * @access private
	 * @static
	 *
	 * @return array Default background types.
	 */
	private static function get_default_background_types() {
		return [
			'color' => [
				'title' => _x( 'Color', 'Background Control', 'aihub-core' ),
				'icon' => 'eicon-paint-brush',
			],
			'image' => [
				'title' => _x( 'Image', 'Background Control', 'aihub-core' ),
				'icon' => 'eicon-image-bold',
			]
		];
	}

	/**
	 * Get Default css attr.
	 *
	 *
	 * @since 2.0.0
	 * @access private
	 * @static
	 *
	 * @return string
	 */
	private static function get_default_css_attr() {
		return 'background';
	}

	/**
	 * Init fields.
	 *
	 * Initialize background control fields.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Control fields.
	 */
	public function init_fields() {
		$fields = [];

		$fields['background'] = [
			'label' => _x( 'Background', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::CHOOSE,
			'render_type' => 'ui',
			'options' => self::get_background_types(),
		];

		// color
		$fields['color'] = [
			'type' => 'liquid-color',
			'label' => _x( 'Color', 'Background Control', 'aihub-core' ),
			'condition' => [
				'background' => [ 'color' ],
			],
		];

		// image
		$fields['image'] = [
			'label' => _x( 'Image', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::MEDIA,
			'dynamic' => [
				'active' => true,
			],
			'title' => _x( 'Background Image', 'Background Control', 'aihub-core' ),
			'render_type' => 'template',
			'condition' => [
				'background' => [ 'image' ],
			],
		];

		$fields['position'] = [
			'label' => _x( 'Position', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => _x( 'Default', 'Background Control', 'aihub-core' ),
				'center center' => _x( 'Center Center', 'Background Control', 'aihub-core' ),
				'center left' => _x( 'Center Left', 'Background Control', 'aihub-core' ),
				'center right' => _x( 'Center Right', 'Background Control', 'aihub-core' ),
				'top center' => _x( 'Top Center', 'Background Control', 'aihub-core' ),
				'top left' => _x( 'Top Left', 'Background Control', 'aihub-core' ),
				'top right' => _x( 'Top Right', 'Background Control', 'aihub-core' ),
				'bottom center' => _x( 'Bottom Center', 'Background Control', 'aihub-core' ),
				'bottom left' => _x( 'Bottom Left', 'Background Control', 'aihub-core' ),
				'bottom right' => _x( 'Bottom Right', 'Background Control', 'aihub-core' ),
				'initial' => _x( 'Custom', 'Background Control', 'aihub-core' ),
			],
			'of_type' => 'image',
			'condition' => [
				'background' => [ 'image' ],
				'image[url]!' => '',
			],
		];

		$fields['xpos'] = [
			'label' => _x( 'X Position', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', '%', 'vw' ],
			'default' => [
				'unit' => 'px',
				'size' => 0,
			],
			'tablet_default' => [
				'unit' => 'px',
				'size' => 0,
			],
			'mobile_default' => [
				'unit' => 'px',
				'size' => 0,
			],
			'range' => [
				'px' => [
					'min' => -800,
					'max' => 800,
				],
				'em' => [
					'min' => -100,
					'max' => 100,
				],
				'%' => [
					'min' => -100,
					'max' => 100,
				],
				'vw' => [
					'min' => -100,
					'max' => 100,
				],
			],
			'of_type' => 'image',
			'condition' => [
				'position' => [ 'initial' ],
				'background' => [ 'image' ],
				'image[url]!' => '',
			],
			'required' => true,
		];

		$fields['ypos'] = [
			'label' => _x( 'Y Position', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', '%', 'vh' ],
			'default' => [
				'unit' => 'px',
				'size' => 0,
			],
			'tablet_default' => [
				'unit' => 'px',
				'size' => 0,
			],
			'mobile_default' => [
				'unit' => 'px',
				'size' => 0,
			],
			'range' => [
				'px' => [
					'min' => -800,
					'max' => 800,
				],
				'em' => [
					'min' => -100,
					'max' => 100,
				],
				'%' => [
					'min' => -100,
					'max' => 100,
				],
				'vh' => [
					'min' => -100,
					'max' => 100,
				],
			],
			'of_type' => 'image',
			'condition' => [
				'position' => [ 'initial' ],
				'background' => [ 'image' ],
				'image[url]!' => '',
			],
			'required' => true,
		];

		$fields['attachment'] = [
			'label' => _x( 'Attachment', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => _x( 'Default', 'Background Control', 'aihub-core' ),
				'scroll' => _x( 'Scroll', 'Background Control', 'aihub-core' ),
				'fixed' => _x( 'Fixed', 'Background Control', 'aihub-core' ),
			],
			'of_type' => 'image',
			'condition' => [
				'background' => [ 'image' ],
				'image[url]!' => '',
			],
		];

		$fields['attachment_alert'] = [
			'type' => Controls_Manager::RAW_HTML,
			'content_classes' => 'elementor-control-field-description',
			'raw' => esc_html__( 'Note: Attachment Fixed works only on desktop.', 'aihub-core' ),
			'separator' => 'none',
			'of_type' => 'image',
			'condition' => [
				'background' => [ 'image' ],
				'image[url]!' => '',
				'attachment' => 'fixed',
			],
		];

		$fields['repeat'] = [
			'label' => _x( 'Repeat', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => _x( 'Default', 'Background Control', 'aihub-core' ),
				'no-repeat' => _x( 'No-repeat', 'Background Control', 'aihub-core' ),
				'repeat' => _x( 'Repeat', 'Background Control', 'aihub-core' ),
				'repeat-x' => _x( 'Repeat-x', 'Background Control', 'aihub-core' ),
				'repeat-y' => _x( 'Repeat-y', 'Background Control', 'aihub-core' ),
			],
			'of_type' => 'image',
			'condition' => [
				'background' => [ 'image' ],
				'image[url]!' => '',
			],
		];

		$fields['size'] = [
			'label' => _x( 'Size', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => _x( 'Default', 'Background Control', 'aihub-core' ),
				'auto' => _x( 'Auto', 'Background Control', 'aihub-core' ),
				'cover' => _x( 'Cover', 'Background Control', 'aihub-core' ),
				'contain' => _x( 'Contain', 'Background Control', 'aihub-core' ),
				'initial' => _x( 'Custom', 'Background Control', 'aihub-core' ),
			],
			'of_type' => 'image',
			'condition' => [
				'background' => [ 'image' ],
				'image[url]!' => '',
			],
		];

		$fields['bg_width'] = [
			'label' => _x( 'Width', 'Background Control', 'aihub-core' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', '%', 'vw' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 1000,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
				'vw' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default' => [
				'size' => 100,
				'unit' => '%',
			],
			'required' => true,
			'of_type' => 'image',
			'condition' => [
				'size' => [ 'initial' ],
				'background' => [ 'image' ],
				'image[url]!' => '',
			],
		];

		return $fields;
	}

	/**
	 * Get child default args.
	 *
	 * Retrieve the default arguments for all the child controls for a specific group
	 * control.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Default arguments for all the child controls.
	 */
	protected function get_child_default_args() {
		return [
			'types' => [ 'color', 'image' ],
			'selector' => '{{WRAPPER}}',
			'css_attr' => 'background'
		];
	}

	/**
	 * Filter fields.
	 *
	 * Filter which controls to display, using `include`, `exclude`, `condition`
	 * and `of_type` arguments.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control fields.
	 */
	protected function filter_fields() {
		$fields = parent::filter_fields();

		$args = $this->get_args();

		foreach ( $fields as &$field ) {
			if ( isset( $field['of_type'] ) && ! in_array( $field['of_type'], $args['types'] ) ) {
				unset( $field );
			}
		}

		return $fields;
	}

	/**
	 * Prepare fields.
	 *
	 * Process background control fields before adding them to `add_control()`.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param array $fields Background control fields.
	 *
	 * @return array Processed fields.
	 */
	protected function prepare_fields( $fields ) {
		$args = $this->get_args();

		// add css_attr values to selectors
		$fields['color']['selectors'] = [ '{{SELECTOR}}' => $args['css_attr'] . ': {{VALUE}};'];
		$fields['image']['selectors'] = [ '{{SELECTOR}}' => ( $args['css_attr'] === 'background' ? 'background-image' : $args['css_attr'] ) . ': url("{{URL}}");'];

		if ( isset( $args['apply_other_bg_props_to'] ) && !empty( $args['apply_other_bg_props_to'] ) ) {
			$apply_other_bg_props_to = $args['apply_other_bg_props_to'];

			$fields['position']['selectors'] = [
				$apply_other_bg_props_to => 'background-position: {{VALUE}};'
			];
			$fields['xpos']['selectors'] = [
				$apply_other_bg_props_to => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}'
			];
			$fields['ypos']['selectors'] = [
				$apply_other_bg_props_to => 'background-position: {{xpos.SIZE}}{{xpos.UNIT}} {{SIZE}}{{UNIT}}'
			];
			$fields['attachment']['selectors'] = [
				'(desktop+)' . $apply_other_bg_props_to => 'background-attachment: {{VALUE}};'
			];
			$fields['repeat']['selectors'] = [
				$apply_other_bg_props_to => 'background-repeat: {{VALUE}};'
			];
			$fields['size']['selectors'] = [
				$apply_other_bg_props_to => 'background-size: {{VALUE}};'
			];
			$fields['bg_width']['selectors'] = [
				$apply_other_bg_props_to => 'background-size: {{SIZE}}{{UNIT}} auto'
			];
		}

		return parent::prepare_fields( $fields );
	}

	/**
	 * Get default options.
	 *
	 * Retrieve the default options of the background control. Used to return the
	 * default options while initializing the background control.
	 *
	 * @since 1.9.0
	 * @access protected
	 *
	 * @return array Default background control options.
	 */
	protected function get_default_options() {
		return [
			'popover' => false,
			'css_attr' => 'background'
		];
	}
}

\Elementor\Plugin::instance()->controls_manager->add_group_control( Liquid_Group_Control_Background_CSS::get_type(), new Liquid_Group_Control_Background_CSS() );
