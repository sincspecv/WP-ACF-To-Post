<?php


namespace TFR\ACFToPost\Repeaters;


use TFR\ACFToPost\Base\Repeater;

class Modules extends Repeater {
	public function __construct() {
		parent::__construct();

		$this->setLabel( __( 'Page Modules', 'tfr' ) );
		$this->setName( 'page_modules' );
		$this->setButtonLabel( __( 'Add Module', 'tfr' ) );
		$this->setGroups( ['page'] );
	}

	protected static function layouts() {
		$layouts = apply_filters( 'acf_to_post/' . self::$key . '/layouts', [] );

		error_log(print_r($layouts, true));

		return $layouts;
	}

}
