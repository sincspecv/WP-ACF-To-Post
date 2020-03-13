<?php


namespace TFR\ACFToPost\Repeaters;


use TFR\ACFToPost\Base\FlexibleContent;

class Modules extends FlexibleContent {
	public function __construct() {
		parent::__construct();

		$this->setLabel( __( 'Page Modules', 'tfr' ) );
		$this->setName( 'page_modules' );
		$this->setButtonLabel( __( 'Add Module', 'tfr' ) );
		$this->setGroups( ['page'] );
	}
}
