<?php


namespace TFR\ACFToPost\Repeaters;


class Page extends FlexibleContent {

	public static function add() {
		self::$label = __( 'Page Modules', 'tfr' );
		self::$name = 'page_modules';
		self::$button_label = __( 'Add Module' );

		return parent::add();
	}

	protected static function layouts() {
		$layouts = apply_filters( 'acf_to_post/repeater_fields/' . self::$key, [] );

		return $layouts;
	}

}
