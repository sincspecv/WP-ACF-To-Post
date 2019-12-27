<?php


namespace TFR\ACFToPost\Groups;


use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Repeaters\Page;
use TFR\ACFToPost\Util\Util;

class PageGroup {

	public static function init() {
		$fields = apply_filters( 'acf_to_post/' . self::key() . '/fields', self::fields() );

		$args = [
			'key'            => self::key(),
			'title'          => __( 'Page Fields', 'tfr' ),
			'fields'         => $fields,
			'post_types'     => ['page'],
			'hide_on_screen' => ['the_content']
		];

		return new Group( $args );
	}

	protected static function key() {
		return Util::slugifyClassName( self::class );
	}

	private static function fields() {
		$fields = new FieldGenerator( self::key() );

		return [
			$fields->add( 'text', [
				'name'  => 'text',
				'label' => __( 'Page Group Text', 'tfr' ),
			] ),
			Page::add(),
		];
	}
}
