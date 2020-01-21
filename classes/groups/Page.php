<?php

namespace TFR\ACFToPost\Groups;

use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Util\Util;

class Page extends Group {

	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setKey( Util::slugifyClassName( __CLASS__ ) );
		$this->setPostTypes( ['page', 'post'] );
		$this->setFields( $this->fields() );
	}

	private function fields() {
		$fields = new FieldGenerator( $this->getKey() );

		return [
			$fields->add( 'text', [
				'name'  => 'text',
				'label' => __( 'Page Group Text', 'tfr' ),
			] ),
		];
	}
}
