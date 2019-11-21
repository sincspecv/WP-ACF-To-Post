<?php


namespace TFR\ACFToPost\Layouts;

use TFR\ACFToPost\Util\FieldGenerator;

class Hero extends LayoutBase {
	public static function init() {
		parent::init();

		self::$label = __( 'Hero', 'tfr');
	}

	protected static function fields() {
		$fields = new FieldGenerator( self::$key );

		$fields = [
			$fields->add( 'text', [
				'name' => 'hero_text',
				'label' => __( 'Hero Text', 'tfr' ),
			] ),
		];

		return $fields;
	}
}
