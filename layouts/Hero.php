<?php


namespace TFR\ACFToPost\Layouts;

use TFR\ACFToPost\Util\FieldGenerator;

class Hero extends LayoutBase {
	public static function init() {
		parent::init();

		self::$label = __( 'Hero', 'tfr');
	}

	protected static function fields() {
		$fieldGen = new FieldGenerator( self::$key );

		$fields = [
			$fieldGen->text( [
				'name' => 'hero_text',
				'label' => __( 'Hero Text', 'tfr' ),
			] ),
		];

		return $fields;
	}
}
