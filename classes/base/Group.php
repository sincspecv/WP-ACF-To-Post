<?php


namespace TFR\ACFToPost\Base;


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
	 * Templates on which to display group
	 *
	 * @var $templates    array
	 */
	protected $templates;

	/**
	 * Elements to hide on screen
	 *
	 * @var $hidden_elements    array
	 */
	protected $hidden_elements;


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
	public function buildArray() {
		return [
			'key'            => $this->key,
			'title'          => isset( $this->title ) ? $this->title : ucwords( $this->key ),
			'fields'         => isset( $this->fields ) ? $this->fields : [],
			'location'       => $this->getLocations(),
			'hide_on_screen' => isset( $this->hidden_elements ) ? $this->hidden_elements : [],
		];
	}

	/**
	 * Callback for the 'acf/init' hook to add the group
	 *
	 * @since 0.1.0
	 */
	public function addGroup() {
		if( empty( $this->key ) ) {
			$this->setKey();
		}

		acf_add_local_field_group( $this->buildArray() );
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
		$this->key = empty( $key ) ? strtolower( preg_replace( '/\B([A-Z])/', '_$1', substr( strrchr( $this->class, "\\" ), 1 ) ) ) : $key;
	}

	/**
	 * Get the group key
	 *
	 * @since 0.1.0
	 */
	public function getKey() {
		return $this->key;
	}

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
	 * Set the templates on which to show the group
	 *
	 * @param array $templates
	 * @since 0.1.0
	 */
	public function setTemplates( $templates = [] ) {
		$this->templates = $templates;
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
	 * Set the fields for the group
	 *
	 * @param array $fields
	 * @since 0.1.0
	 */
	public function setFields( $fields = [] ) {
		$this->fields = apply_filters( "acf_to_post/{$this->key}/fields", $fields );
	}

	/**
	 * Builds array of locations to add group to
	 *
	 * @return array
	 *
	 * @since 0.1.0
	 */
	public function getLocations() {
		$results = [];

		if( ! empty( $this->templates ) ) {
			foreach( $this->templates as $template ) {
				$toAdd =[
					[
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => $template,
					]
				];

				array_push($results, $toAdd);
			}
		}

		if( ! empty( $this->post_types ) ) {
			foreach( $this->post_types as $post_type) {
				$toAdd =[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => $post_type,
					]
				];
				array_push($results, $toAdd);
			}
		}

		return $results;
	}
}
