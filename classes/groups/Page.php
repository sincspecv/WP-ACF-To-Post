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
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add( 'text', [
				'name'  => 'text',
				'label' => __( 'Page Group Text', 'tfr' ),
			] ),
		];
	}
}
