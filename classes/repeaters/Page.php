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
		$layouts = apply_filters( 'acf_to_post/' . self::$key . '/layouts', [] );

		error_log(print_r($layouts, true));

		return $layouts;
	}

}
