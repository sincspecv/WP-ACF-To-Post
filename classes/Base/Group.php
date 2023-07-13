<?php


namespace TFR\ACFToPost\Base;


use TFR\ACFToPost\Util\Util;

class Group {
	/**
	 * Reference to called class
	 *
	 * @var $class  string
	 */
	private $class;

	/**
	 * Unique key for group
	 *
	 * @var $key    string
	 */
	protected $key;

	/**
	 * Title for group
	 *
	 * @var $title    string
	 */
	protected $title;

	/**
	 * Fields for group
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
	 * Page Types on which to display group
	 *
	 * @var $page_types    array
	 */
	protected $page_types;

	/**
	 * Templates on which to display group
	 *
	 * @var $templates    array
	 */
	protected $templates;

	/**
	 * Post types on which to ignore group
	 *
	 * @var $ignored_post_types    array
	 */
	protected $ignored_post_types;

	/**
	 * Templates on which to ignore group
	 *
	 * @var $ignored_templates    array
	 */
	protected $ignored_templates;

	/**
	 * Elements to hide on screen
	 *
	 * @var $hidden_elements    array
	 */
	protected $hidden_elements;

	/*
	 * Menu order option
	 *
	 * @var $order  int
	 */
	protected $order;

	/*
	 * Position option
	 *
	 * @var $order  int
	 */
	protected $position;

	/*
	 * Location option
	 *
	 * @var $location array
	 */
	protected $location = [];

	/**
	 * Group parameters
	 *
	 * @var array
	 *
	 * @since 0.1.0
	 */
	private $params = [];

	/**
	 * Group constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->class = get_called_class();
	}

	/**
	 * Add the group to ACF
	 *
	 * @since 0.1.0
	 */
	public function init() {
		add_action( 'acf/init', [$this, 'addGroup'] );
	}

	/**
	 * Build the array to be passed to ACF
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getArray() {
	    return [
            'key'            => $this->getKey(),
            'title'          => isset( $this->title ) ? $this->title : ucwords( $this->key ),
            'fields'         => $this->getFields(),
            'location'       => $this->getLocations(),
            'hide_on_screen' => isset( $this->hidden_elements ) ? $this->hidden_elements : [],
            'menu_order'     => $this->getOrder(),
		    'position'       => $this->getPosition(),
        ];
	}

	/**
	 * Callback for the 'acf/init' hook to add the group
	 *
	 * @since 0.1.0
	 */
	public function addGroup() {
		acf_add_local_field_group( $this->getArray() );
	}

	/**
	 * Set the group key
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
	 * Get the group key
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
	 * Set the title for the group
	 *
	 * @param string $title
	 * @since 0.1.0
	 */
	public function setTitle( $title = '' ) {
		$this->title = $title;
	}

	/**
	 * Set the post types on which to show the group
	 *
	 * @param array $post_types
	 * @since 0.1.0
	 */
	public function setPostTypes( $post_types = [] ) {
		$this->post_types = $post_types;
	}

	/**
	 * Set the post types on which to show the group
	 *
	 * @param array $post_types
	 * @since 0.1.0
	 */
	public function setPageTypes( $page_types = [] ) {
		$this->page_types = $page_types;
	}

	/**
	 * Set the post types on which to ignore the group
	 *
	 * @param array $post_types
	 * @since 0.1.0
	 */
	public function ignorePostTypes( $post_types = [] ) {
		$this->ignored_post_types = $post_types;
	}

	/**
	 * Set the templates on which to show the group
	 *
	 * @param array $templates
	 * @since 0.1.0
	 */
	public function setTemplates(array $templates = [] ) {
		$this->templates = $templates;
	}

	/**
	 * Set the templates on which to ignore the group
	 *
	 * @param array $templates
	 * @since 0.1.0
	 */
	public function ignoreTemplates( $templates = [] ) {
		$this->ignored_templates = $templates;
	}

	/**
	 * Set the elements to hide when group is shown
	 *
	 * @param array $hidden_elements
	 * @since 0.1.0
	 */
	public function setHiddenElements( $hidden_elements = [] ) {
		$this->hidden_elements = $hidden_elements;
	}

	/**
	 * Set the fields for the group.
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
	 * Get the fields array for the group
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getFields() {
		if( ! isset( $this->fields ) ) {
			$this->setFields();
		}

		return apply_filters( "acf_to_post/{$this->key}/fields", $this->fields );
	}

	/**
	 * Adds user defined array to the location array
	 *
	 * @return array
	 *
	 * @since 0.2.0
	 */
	public function setLocation(array $location = []) {
		if(!is_array($location)) {
			return false;
		}

		if(!is_array($this->location)) {
			$this->location = [];
        }

		array_push($this->location, $location);
	}

	/**
	 * Builds array of locations to add group to
	 *
	 * @return array
	 *
	 * @since 0.1.0
	 */
	public function getLocations() {

		/**
		 * Ideally we could just return $this->location, but this 
		 * must remain for legacy support
		 */
		if( ! empty( $this->ignored_templates ) ) {
			foreach( $this->ignored_templates as $template ) {
				$this->setLocation([
					'param'    => 'post_template',
					'operator' => '!=',
					'value'    => $template,
				]);
			}
		}

		if( ! empty( $this->templates ) ) {
			foreach( $this->templates as $template ) {
				$this->setLocation([
					'param'    => 'post_template',
					'operator' => '==',
					'value'    => $template,
				]);
			}
		}

		if( ! empty( $this->ignored_post_types ) ) {
			foreach( $this->ignored_post_types as $post_type) {
				$this->setLocation([
					'param'    => 'post_type',
					'operator' => '!=',
					'value'    => $post_type,
				]);
			}
		}

		if( ! empty( $this->post_types ) ) {
			foreach( $this->post_types as $post_type) {
				$this->setLocation([
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => $post_type,
				]);
			}
		}

		if( ! empty( $this->page_types ) ) {
			foreach( $this->page_types as $page_type) {
				$this->setLocation([
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => $page_type,
				]);
			}
		}

		return [$this->location];
	}

	/**
	 * Set the menu_order option
	 *
	 * @param int $order
	 */
	protected function setOrder($order = 0) {
		$this->order = (int)$order;
	}

	/**
	 * Get the menu_order option. Returns 0 if not set.
	 *
	 * @return int
	 */
	protected function getOrder() {
		return empty($this->order) ? 0 : $this->order;
	}

	/**
	 * Set the position option
	 *
	 * @param string $position
	 */
	protected function setPosition($position = 'normal') {
		$this->position = $position;
	}

	/**
	 * Get the position option
	 *
	 * @return string
	 */
	protected function getPosition() {
		return empty($this->position) ? 'normal' : $this->position;
	}
}
