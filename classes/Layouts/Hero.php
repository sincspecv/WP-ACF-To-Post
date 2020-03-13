<?php


namespace TFR\ACFToPost\Layouts;

use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class Hero extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'hero' );
		$this->setLabel( __( 'Hero', 'tfr' ) );
		$this->setRepeaters( ['modules'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add( 'text', [
				'name'  => 'text',
				'label' => __( 'Hero Text', 'tfr' ),
			]),

			$fields->add( 'image', [
				'name'  => 'image',
				'label' => __( 'Background Image', 'tfr' ),
			])
		];
	}
}
