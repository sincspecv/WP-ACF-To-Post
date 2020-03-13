<?php


namespace TFR\ACFToPost\Base;

use TFR\ACFToPost\Util\Util;

class FlexibleContent {
	/**
	 * Reference to called class
	 *
	 * @var $class  string
	 */
	private $class;

	/**
	 * Unique key for field
	 *
	 * @var $key    string
	 */
	protected $key;

	/**
	 * Label for field on frontend
	 *
	 * @var $label  string
	 */
	protected $label;

	/**
	 * Name for field on frontend
	 *
	 * @var $name   string
	 */
	protected $name;

	/**
	 * Instructions for field on frontend
	 *
	 * @var $instructions   string
	 */
	protected $instructions;

	/**
	 * Bool for making field required
	 *
	 * @var $required   bool
	 */
	protected $required;

	/**
	 * Conditional logic
	 *
	 * @var $conditional    array
	 */
	protected $conditional;

	/**
	 * Wrapper styling
	 *
	 * @var $wrapper    array
	 */
	protected $wrapper;

	/**
	 * Button label
	 *
	 * @var $button_label    string
	 */
	protected $button_label;

	/**
	 * Minimum number of rows
	 *
	 * @var $min_rows    int
	 */
	protected $min_rows;

	/**
	 * Maximum number of rows
	 *
	 * @var $max_rows    int
	 */
	protected $max_rows;

	/**
	 * Array of layouts
	 *
	 * @var $layouts    array
	 */
	protected $layouts;

	/**
	 * Groups to add the repeater to
	 *
	 * @var $groups   array
	 */
	protected $groups;

	public function __construct() {
		$this->class = get_called_class();
	}

	/**
	 * Add the repeater field to specified groups
	 *
	 * @since 0.1.0
	 */
	public function init() {
		foreach( $this->groups as $group ) {
			if( is_string( $group ) ) {
				add_filter( "acf_to_post/{$group}/fields", [$this, 'getArray'] );
			}
		}
	}

	/**
	 * Return ACF formatted array to be added to group
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getArray( $fields ) {

		$fields[] = [
			'key'               => $this->getKey(),
			'label'             => isset( $this->label ) ? $this->label : ucwords( $this->getKey() ),
			'name'              => isset( $this->name ) ? $this->name : $this->getKey(),
			'type'              => 'flexible_content',
			'instructions'      => isset( $this->instructions) ? $this->instructions : '',
			'required'          => isset( $this->required ) ? $this->required : 0,
			'conditional_logic' => isset( $this->conditional ) ? $this->conditional : 0,
			'wrapper'           => isset( $this->wrapper ) ? $this->wrapper : [],
			'layouts'           => $this->getLayouts(),
			'button_label'      => isset( $this->button_label ) ? $this->button_label : __( 'Add Row', 'tfr' ),
			'min'               => isset( $this->min_rows ) ? $this->min_rows : '',
			'max'               => isset( $this->max_rows ) ? $this->max_rows : '',
		];

		return $fields;

	}

	/**
	 * Add layouts to repeater field
	 *
	 * @param array $layouts
	 * @since 0.1.0
	 */
	public function setLayouts( $layouts = [] ) {
		$this->layouts = apply_filters( "acf_to_post/{$this->key}/layouts", $layouts );
	}

	/**
	 * Get layouts for repeater field
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getLayouts() {
		if( ! isset( $this->layouts ) ) {
			$this->setLayouts();
		}
		return $this->layouts;
	}

	/**
	 * Set the repeater field key
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
	 * Get the key for the repeater field
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function getKey() {
		// Field key must be set
		if( empty( $this->key ) ) {
			$this->setKey();
		}

		return $this->key;
	}

	/**
	 * Set the label for the repeater field
	 *
	 * @param string $label
	 * @since 0.1.0
	 */
	public function setLabel( $label = '' ) {
		$this->label = $label;
	}

	/**
	 * Set the name for the repeater field
	 *
	 * @param string $name
	 * @since 0.1.0
	 */
	public function setName( $name = '' ) {
		$this->name = $name;
	}

	/**
	 * Set the instructions for the repeater field
	 *
	 * @param string $instructions
	 * @since 0.1.0
	 */
	public function setInstructions( $instructions = '' ) {
		$this->instructions = $instructions;
	}

	/**
	 * Set required boolean for repeater field
	 *
	 * @param bool $required
	 * @since 0.1.0
	 */
	public function setRequired( $required = false ) {
		$this->required = $required;
	}

	/**
	 * Set conditional arguments for repeater field
	 *
	 * @param array $conditional
	 * @since 0.1.0
	 */
	public function setConditional( $conditional = [] ) {
		$this->conditional = $conditional;
	}

	/**
	 * Set wrapper arguments for repeater field
	 *
	 * @param array $wrapper
	 * @since 0.1.0
	 */
	public function setWrapper( $wrapper = [] ) {
		$this->wrapper = $wrapper;
	}

	/**
	 * Set the button label for repeater field
	 *
	 * @param string $button_label
	 * @since 0.1.0
	 */
	public function setButtonLabel( $button_label = '' ) {
		$this->button_label = $button_label;
	}

	/**
	 * Set the minimum number of rows allowed for repeater field
	 *
	 * @param int $min_rows
	 * @since 0.1.0
	 */
	public function setMinRows( $min_rows = 0 ) {
		$this->min_rows = $min_rows;
	}

	/**
	 * Set the maximum number of rows allowed for repeater field
	 *
	 * @param int $max_rows
	 * @since 0.1.0
	 */
	public function setMaxRows( $max_rows = 0 ) {
		$this->max_rows = $max_rows;
	}

	/**
	 * Set the groups to add the repeater field to
	 *
	 * @param array $groups
	 * @since 0.1.0
	 */
	public function setGroups( $groups = [] ) {
		$this->groups = $groups;
	}
}
