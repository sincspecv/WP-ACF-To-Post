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

	public function text( $args = [] ) {
		$params = $this->getParams( $args, __FUNCTION__ );

		$fieldArr = [
			'key'   => "{$this->key}_{$params['name']}",
			'label' => $params['label'],
			'type'  => __FUNCTION__,
			'name'  => $params['name'],
			'wrapper' => [
				'width' => $params['width'],
			],
		];

		return $fieldArr;
	}

	public function textarea( $args = [] ) {
		$params = $this->getParams( $args, __FUNCTION__ );

		$fieldArr = [
			'key'   => "{$this->key}_{$params['name']}",
			'label' => $params['label'],
			'type'  => __FUNCTION__,
			'name'  => $params['name'],
			'wrapper' => [
				'width' => $params['width'],
			],
		];

		return $fieldArr;
	}

	public function wysiwyg( $args = [] ) {
		$params = $this->getParams( $args, __FUNCTION__ );

		$fieldArr = [
			'key'   => "{$this->key}_{$params['name']}",
			'label' => $params['label'],
			'type'  => __FUNCTION__,
			'name'  => $params['name'],
			'wrapper' => [
				'width' => $params['width'],
			],
		];

		return $fieldArr;
	}

	private function getParams( $args, $type, $defaultArgs = [] ) {
		if( empty( $defaultArgs )) {
			$defaultArgs = [
				'name'  => $type,
				'label' => __( str_replace( ['_','-'], ' ',  ucwords($type)), 'tfr' ),
				'width' => 100,
			];
		}

		return wp_parse_args( $args, $defaultArgs );
	}
}
