<?php


namespace TFR\ACFToPost\Layouts;

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
	 * Layout parameters
	 *
	 * @var array
	 *
	 * @since 0.1.0
	 */
	private $params = [];

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
	 * Args that can be passed:
	 * 'key' is the key for the layout
	 * 'label' is the title for the layout
	 * 'name' is the name for the layout
	 * 'sub_fields' is an array of acf field arrays
	 * 'repeaters' is an array of the repeater or flexible content fields to add the layout to
	 *
	 * @param $args
	 *
	 * @since 0.1.0
	 */
	public function __construct( $args = [] ) {
		if( empty( $args ) ) {
			return null;
		}

		$this->params    = $this->parseArgs( $args );
		$this->repeaters = $this->params['repeaters'];
		unset( $this->params['repeaters'] );

		foreach( $this->repeaters as $repeater ) {
			add_filter( "acf_to_post/{$repeater}/layouts", [$this, 'getParams'] );
		}
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
