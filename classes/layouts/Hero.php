<?php


namespace TFR\ACFToPost\Layouts;

use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Repeaters\Page;
use TFR\ACFToPost\Util\Util;

class Hero {
	public static function init() {
		$args = [
			'key'        => self::key(),
			'label'      => __( 'Hero', 'tfr' ),
			'name'       => self::key(),
			'sub_fields' => self::fields(),
			'repeaters'  => [Page::key()],
		];

		return new Layout( $args );
	}

	public static function fields() {
		$fields = new FieldGenerator( self::key() );

		return [
			$fields->add( 'text', [
				'name'  => 'text',
				'label' => __( 'Hero Text', 'tfr' ),
			])
		];
	}

	public static function key() {
		return Util::slugifyClassName( self::class );
	}
}
