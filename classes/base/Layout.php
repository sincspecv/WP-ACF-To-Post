<?php


namespace TFR\ACFToPost\Base;

use TFR\ACFToPost\Util\Util;

/**
 * Class LayoutBase
 *
 * Base class for building layouts
 *
 * @package TFR\ACFToPost\Layouts
 * @since 0.1.0
 */
class Layout {
	/**
	 * Reference to called class
	 *
	 * @var $class  string
	 * @since 0.1.0
	 */
	private $class;

	/**
	 * Unique key for layout
	 *
	 * @var $key    string
	 * @since 0.1.0
	 */
	protected $key;

	/**
	 * Label for layout
	 *
	 * @var $label    string
	 */
	protected $label;

	/**
	 * Name for layout
	 *
	 * @var $name    string
	 */
	protected $name;

	/**
	 * Fields for layout
	 *
	 * @var $fields    array
	 */
	protected $fields;

	/**
	 * Post types on which to display group
	 *
	 * @var $post_types    array
	 */
	protected $post_types;

	/**
	 * Repeaters to add layout to
	 *
	 * @var array
	 *
	 * @since 0.1.0
	 */
	private $repeaters = [];

	/**
	 * Layout constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->class = get_called_class();
	}

	/**
	 * Parses the provided args
	 *
	 * @param $args
	 *
	 * @return array
	 *
	 * @since 0.1.0
	 */
	private function parseArgs( $args = [] ) {
		$key = Util::slugifyClassName( self::class );

		$default = [
			'key'            => $key,
			'label'          => ucwords( $key ),
			'name'           => $key,
			'sub_fields'     => [],
			'repeaters'      => [],
		];

		return wp_parse_args( $args, $default );
	}

	public function getFields() {
		return $this->params['sub_fields'];
	}

	public function getParams() {
		return $this->params;
	}
}
