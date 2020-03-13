<?php


namespace TFR\ACFToPost\Util;

/**
 * Class Util
 *
 * Utility methods to be used throughout the plugin to keep code DRY
 *
 * @package TFR\ACFToPost\Util
 * @since   0.1.0
 */
class Util {

	/**
	 * Adds an underscore between capital letters and converts all
	 * characters to lowercase
	 *
	 * @param string $class
	 *
	 * @return string
	 */
	public static function slugifyClassName( $class = '' ) {
		return strtolower( preg_replace( '/\B([A-Z])/', '_$1', substr( strrchr( $class, "\\" ), 1 ) ) );
	}

}
