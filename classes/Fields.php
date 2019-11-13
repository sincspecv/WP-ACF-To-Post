<?php


namespace TFR\ACFToPost;

/**
 * Class Fields
 *
 * This adds the fields to the post object via WP_Post's magic getter
 *
 * @see https://secure.php.net/manual/en/language.oop5.overloading.php#object.get
 *
 * @package TFR\ACFToPost\Inc
 * @since 0.1.0
 */
class Fields {
	public static function init() {
		add_filter( 'get_post_metadata', [self::class, 'addMetaData'], 10, 4 );
	}

	/**
	 * Get the associated ACF fields
	 *
	 * TODO: Filter/escape field values
	 *
	 * @since 0.1.0
	 *
	 * @param $post*
	 * @return array
	 */
	private static function getFields( $post ) {
		$fields = get_fields( $post->ID );

		if( ! array_key_exists( Config::name(), $fields ) ) {
			return [];
		}
		unset( $fields[Config::name()][0]['acf_fc_layout'] );

		return $fields[Config::name()];
	}

	/**
	 * Add dynamically-generated "post meta" to `\WP_Post` objects
	 *
	 * This makes it possible to access dynamic data related to a post object by simply referencing `$post->foo`.
	 * That keeps the calling code much cleaner than if it were to have to do something like
	 * `$foo = some_custom_logic( get_post_meta( $post->ID, 'bar', true ) ); echo esc_html( $foo )`.
	 *
	 * @param mixed  $value
	 * @param int    $post_id
	 * @param string $meta_key
	 * @param int    $single   @todo handle the case where this is false
	 *
	 * @see https://iandunn.name/2016/10/22/accessing-post-meta-and-more-via-post-meta_key/
	 *
	 * @since 0.1.0
	 *
	 * @return mixed
	 *      `null` to instruct `get_metadata()` to pull the value from the database
	 *      Any non-null value will be returned as if it were pulled from the database
	 */
	public static function addMetaData( $value, $post_id, $meta_key, $single ) {
		$post = get_post( $post_id );

		if( ! in_array( $post->post_type, Config::postTypes() ) ) {
			return $value;
		}

		switch ( $meta_key ) {
			case 'fields' :
				$value = self::getFields( $post );
				break;
			default :
				break;
		}

		return $value;
	}

	/**
	 * Remove the metadata
	 *
	 * @since 0.1.0
	 */
	public static function remove() {
		remove_action( 'get_post_metadata', [self::class, 'add'] );
	}
}
