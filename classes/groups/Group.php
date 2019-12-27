<?php


namespace TFR\ACFToPost\Groups;

/**
 * Class Group
 *
 * Factory to create ACF Groups
 *
 * @package TFR\ACFToPost\Groups
 * @since 0.1.0
 */
class Group {
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
	 * Args that can be passed:
	 * 'key' is the key for the group
	 * 'title' is the title for the group
	 * 'fields' is an array of acf field arrays
	 * 'post_types' is an array of post types on which to show the group
	 * 'templates' is an array of page templates on which to show the group
	 * 'hide_on_screen' is an array of elements to hide on the edit screen
	 *
	 * @param $args
	 *
	 * @since 0.1.0
	 */
	public function __construct( $args ) {

		$this->params = $this->parseArgs( $args );

		add_action( 'acf/init', [$this, 'add'] );
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
	private function parseArgs( $args ) {
		$key = strtolower( preg_replace( '%([a-z])([A-Z])%', '\1_\2', stripslashes( self::class ) ) );

		$default = [
			'key'            => $key,
			'title'          => ucwords( $key ),
			'fields'         => [],
			'post_types'     => [],
			'templates'      => [],
			'hide_on_screen' => [],
		];

		return wp_parse_args( $args, $default );
	}

	/**
	 * Callback for the 'acf/init' hook to add the group
	 *
	 * @since 0.1.0
	 */
	public function add() {
		acf_add_local_field_group( $this->groupArgsArray() );
	}

	/**
	 * Returns a valid ACF Group array
	 *
	 * @return array
	 *
	 * @since 0.1.0
	 */
	private function groupArgsArray() {
		return [
			'key' => $this->params['key'],
			'title' => $this->params['title'],
			'fields' => $this->params['fields'],
			'location' => $this->locations(),
			'hide_on_screen' => $this->params['hide_on_screen'],
		];
	}

	/**
	 * Builds array of locations to add group
	 *
	 * @return array
	 *
	 * @since 0.1.0
	 */
	public function locations() {
		$results = [];

		foreach ( $this->params['templates'] as $template ) {
			$toAdd =[
				[
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => $template,
				]
			];

			array_push($results, $toAdd);
		}

		foreach ($this->params['post_types'] as $post_type) {
			$toAdd =[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => $post_type,
				]
			];
			array_push($results, $toAdd);
		}

		return $results;
	}
}
