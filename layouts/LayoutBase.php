<?php


namespace TFR\ACFToPost\Layouts;

use TFR\ACFToPost\Inc\Config;

/**
 * Class LayoutBase
 *
 * Base class for building layouts
 *
 * @package TFR\ACFToPost\Layouts
 * @since 0.1.0
 */
class LayoutBase {
	/**
	 * Reference to called class
	 *
	 * @var $class
	 */
	private static $class;

	/**
	 * Unique key for layout
	 *
	 * @var $key
	 */
	protected static $key;

	/**
	 * Label for layout on frontend
	 *
	 * @var $label
	 */
	protected static $label;

	/**
	 * Initializes the layout and adds it to the list of layouts
	 */
	public static function init() {
		self::$class = get_called_class();
		self::$key = strtolower( preg_replace( '%([a-z])([A-Z])%', '\1_\2', stripslashes( self::$class ) ) );

		add_filter( 'acf_to_post/layouts', [self::$class, 'addLayout'] );
	}

	/**
	 * Removes the layout from the list of layouts
	 */
	public static function remove() {
		remove_filter( 'acf_to_post/layouts', [self::$class, 'addLayout'] );
	}

	/**
	 * Filters the ACF layouts array
	 *
	 * @param $layouts
	 *
	 * @return array|null
	 */
	public static function addLayout( $layouts ) {
		if( empty( self::$label ) ) {
			return null;
		}

		$layouts[] = [
			'key'        => self::$key,
			'label'      => self::$label,
			'name'       => self::$key,
			'sub_fields' => self::$class::fields(),
		];

		return $layouts;
	}

	/**
	 * Returns an array of ACF fields to be added to the layouts array
	 *
	 * @see https://www.advancedcustomfields.com/resources/register-fields-via-php/
	 */
	protected static function fields() {}
}
