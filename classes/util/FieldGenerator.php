<?php


namespace TFR\ACFToPost\Util;

use TFR\ACFToPost\Plugin;

/**
 * Class FieldGenerator
 *
 * TODO: Add all field types
 *
 * @package TFR\ACFToPost\Util
 * @since 0.1.0
 * @see https://www.advancedcustomfields.com/resources/register-fields-via-php/
 */

class FieldGenerator {

	private $key;

	function __construct( $key ) {
		$this->key = esc_attr( $key );
	}

	public function add( $type = '', $args = [] ) {
		if( ! $type ) {
			return false;
		}

		$fieldArr = $this->parseArgs( $args, $type );
		$fieldArr['key'] = "{$this->key}_{$fieldArr['name']}";

		return $fieldArr;
	}

	private function parseArgs( $args, $type, $defaultArgs = [] ) {

		if( empty( $defaultArgs )) {
			$defaultArgs = [
				'key'   => '',
				'label' => __( str_replace( ['_','-'], ' ',  ucwords( $type ) ), 'tfr' ),
				'name'  => $type,
				'type'  => $type,
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value' => '',
				'placeholder'   => '',
				'prepend'       => '',
				'append'        => '',
				'maxlength'     => '',
				'min'           => '',
				'max'           => '',
				'step'          => '',
			];
		}

		return wp_parse_args( $args, $defaultArgs );
	}
}
