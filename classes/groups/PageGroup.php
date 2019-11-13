<?php


namespace TFR\ACFToPost\Groups;


use TFR\ACFToPost\Util\FieldGenerator;

class PageGroup {
	const KEY = 'page_group';

	public static function init() {
		$fields = apply_filters( 'acf_to_post/' . self::KEY . '_fields', self::fields() );

		$args = [
			'key'        => self::KEY,
			'title'      => __( 'Page Fields', 'tfr' ),
			'fields'     => $fields,
			'post_types' => ['page'],
		];

		return new Group( $args );
	}

	private static function fields() {
		$fields = new FieldGenerator( self::KEY );

		return [
			$fields->text( [
				'name'  => 'text',
				'label' => __( 'Page Group Text', 'tfr' ),
			] ),
		];
	}
}
