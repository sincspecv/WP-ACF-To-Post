<?php


namespace TFR\ACFToPost\Util;

/**
 * Class FormatFieldType
 *
 * Adds sanitation to ACF fields based on type.
 *
 * Each method is named exactly the same as the type and is passed to the acf/format_value/type=* filter.
 *
 * Custom sanitation can be added using the acf_to_post/format_field/type filter. This filter passes an
 * array with two keys: 'type' and 'function'. The 'type' value is a string to specify the type of field to
 * apply the formatting function to, and the 'function' value is an array or string that is passed directly
 * to the acf/format_value/type=* filter as the callback.
 *
 * TODO: Add all field types
 *
 * @package TFR\ACFToPost\Util
 * @since 0.1.0
 */
class FormatFieldType {

	/**
	 * Initializes the class. Adds all built in format methods.
	 *
	 * @since 0.1.0
	 */
	public static function init() {
		$defaults = apply_filters( 'acf_to_post/format_field/type/use_defaults', true );
		$methods = $defaults ? array_map( [self::class, 'builtInFormats'], get_class_methods( self::class ) ) : [];
		$formats = apply_filters( 'acf_to_post/format_field/type', $methods );

		foreach( $formats as $format ) {
			if ( ! empty( $format ) ) {
				add_filter( "acf/format_value/type={$format['type']}", $format['function'], 10, 3 );
			}
		}
	}

	/**
	 * Return array with the 'type' and 'function' values specified based on the method name
	 *
	 * @param $method
	 *
	 * @return array|null
	 * @since 0.1.0
	 */
	private static function builtInFormats( $method ) {
		if( $method !== 'init' && $method !== 'builtInFormats' ) {
			return [
				'type'     => $method,
				'function' => [self::class, $method]
			];
		}

		return null;
	}

	/**
	 * Text field sanitation
	 *
	 * @param $value
	 * @param $post_id
	 * @param $field
	 *
	 * @return string|void
	 * @since 0.1.0
	 */
	public static function text( $value, $post_id, $field ) {
		return esc_attr( $value );
	}

	/**
	 * URL field sanitation
	 *
	 * @param $value
	 * @param $post_id
	 * @param $field
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public static function url( $value, $post_id, $field ) {
		return esc_url_raw( $value );
	}

}
