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
	 * Add the layout to specified repeaters
	 *
	 * @since 0.1.0
	 */
	public function init() {
		foreach( $this->repeaters as $repeater ) {
			if( is_string( $repeater ) ) {
				add_filter( "acf_to_post/{$repeater}/layouts", [$this, 'getArray'] );
			}
		}
	}

	/**
	 * Set the layout key
	 *
	 * If key is not passed as string the key will be generated based on the class name
	 *
	 * @param string $key
	 * @since 0.1.0
	 */
	protected function setKey( $key = '' ) {
		$this->key = empty( $key ) ? Util::slugifyClassName( $this->class ) : $key;
	}

	/**
	 * Get the array to be passed to ACF
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getArray( $layouts = [] ) {
		$layouts[] = [
			'key'            => $this->getKey(),
			'label'          => isset( $this->label ) ? $this->label : ucwords( $this->getKey() ),
			'name'           => isset( $this->name ) ? $this->name : $this->getKey(),
			'sub_fields'     => $this->getFields(),
		];

		return $layouts;
	}

	/**
	 * Get the layout key
	 *
	 * @since 0.1.0
	 */
	public function getKey() {
		if( empty( $this->key ) ) {
			$this->setKey();
		}
		return $this->key;
	}

	/**
	 * Get the class
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * Set the label for the layout
	 *
	 * @param string $label
	 * @since 0.1.0
	 */
	public function setLabel( $label = '' ) {
		$this->label = $label;
	}

	/**
	 * Set the name for the layout
	 *
	 * @param string $name
	 * @since 0.1.0
	 */
	public function setName( $name = '' ) {
		$this->name = $name;
	}

	/**
	 * Set the fields for the layout.
	 *
	 * This method MUST be defined in the child class.
	 * Returns standard ACF field array
	 *
	 * @since 0.1.0
	 */
	public function setFields() {
		$this->fields = [];
	}

	/**
	 * Get the fields array for the layout
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getFields() {
		if( ! isset( $this->fields ) ) {
			$this->setFields();
		}

		return $this->fields;
	}

	/**
	 * Set the repeaters to add the layout to
	 *
	 * Accepts an array of strings. Each string should be the key of the repeater.
	 *
	 * @param array $repeaters
	 * @since 0.1.0
	 */
	public function setRepeaters( $repeaters = [] ) {
		$this->repeaters = $repeaters;
	}
}
