<?php


namespace TFR\ACFToPost\Repeaters;


abstract class FlexibleContent {
	/**
	 * Reference to called class
	 *
	 * @var $class  string
	 */
	private static $class;

	/**
	 * Unique key for field
	 *
	 * @var $key    string
	 */
	protected static $key;

	/**
	 * Label for field on frontend
	 *
	 * @var $label  string
	 */
	protected static $label;

	/**
	 * Name for field on frontend
	 *
	 * @var $name   string
	 */
	protected static $name;

	/**
	 * Instructions for field on frontend
	 *
	 * @var $instructions   string
	 */
	protected static $instructions;

	/**
	 * Bool for making field required
	 *
	 * @var $required   bool
	 */
	protected static $required;

	/**
	 * Conditional logic
	 *
	 * @var $conditional    array
	 */
	protected static $conditional;

	/**
	 * Wrapper styling
	 *
	 * @var $wrapper    array
	 */
	protected static $wrapper;

	/**
	 * Button label
	 *
	 * @var $button_label    string
	 */
	protected static $button_label;

	/**
	 * Minimum number of rows
	 *
	 * @var $min    int
	 */
	protected static $min;

	/**
	 * Maximum number of rows
	 *
	 * @var $max    int
	 */
	protected static $max;

	public static function add() {
		self::$key = self::key();

		return self::buildArray();
	}

	protected static function buildArray() {

		return [
			'key'               => self::$key,
			'label'             => isset( self::$label ) ? self::$label : '',
			'name'              => isset( self::$name ) ? self::$name : self::$key,
			'type'              => 'flexible_content',
			'instructions'      => isset( self::$instructions) ? self::$instructions : '',
			'required'          => isset( self::$required ) ? self::$required : 0,
			'conditional_logic' => isset( self::$conditional ) ? self::$conditional : 0,
			'wrapper'           => isset( self::$wrapper ) ? self::$wrapper : [],
			'layouts'           => self::layouts(),
			'button_label'      => isset( self::$button_label ) ? self::$button_label : __( 'Add Row', 'tfr' ),
			'min'               => isset( self::$min ) ? self::$min : '',
			'max'               => isset( self::$max ) ? self::$max : '',
		];

	}

	protected static function layouts() {

		$layouts = [

		];
		$layouts = apply_filters( 'acf_to_post/repeater_fields/' . self::$key, $layouts );

		return $layouts;
	}

	public static function key() {
		self::$class = get_called_class();
		return strtolower( preg_replace( '/\B([A-Z])/', '_$1', substr( strrchr( self::$class, "\\" ), 1 ) ) );
	}
}
