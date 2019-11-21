<?php


namespace TFR\ACFToPost\Layouts;

use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Repeaters\Page;

class Hero extends LayoutBase {
	public static function init() {
		self::$label = __( 'Hero', 'tfr');
		self::$repeaters = [
			Page::key(),
		];
		parent::init();

		var_dump(Page::key());

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
