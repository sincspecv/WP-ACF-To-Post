<?php


namespace TFR\ACFToPost;

use TFR\ACFToPost\Layouts;

/**
 * Class Config
 *
 * Configuration for the plugin
 *
 * @package TFR\ACFToPost\Inc
 * @since 0.1.0
 */
class Config {

	/**
	 * Return an array of post types to add flexible layout
	 *
	 * @return mixed|void
	 */
	public static function postTypes() {
		$post_types = [
			'post',
			'page'
		];
		return apply_filters( 'acf_to_post/post_types', $post_types );
	}

	/**
	 * Return an array of templates to add flexible layout
	 *
	 * @return mixed|void
	 */
	public static function templates() {
		$templates = [
			'default'
		];
		return apply_filters( 'acf_to_post/templates', $templates );
	}

	/**
	 * Return array of layouts to use in flexible layout
	 *
	 * @return mixed|void
	 */
	public static function layouts() {
		$layouts = [];
		return apply_filters( 'acf_to_post/layouts', $layouts );
	}

	/**
	 * Return label for flexible content
	 *
	 * @return mixed|void
	 */
	public static function flexibleContentLabel() {
		$flex_content_label = __( 'Blocks', 'tfr' );
		return apply_filters( 'acf_to_post/flexible_content_label', $flex_content_label );
	}

	public static function groupKey() {
		$group_key = strtolower( str_replace(['\\', '-'], '_', __NAMESPACE__ ) ) . '_flexible_layout';
		return apply_filters( 'acf_to_post/group_key', $group_key );
	}
	/**
	 * Return the label text for the flexible layout group
	 *
	 * @return mixed|void
	 */
	public static function groupLabel() {
		$group_label = __( 'Content Blocks', 'tfr' );
		return apply_filters( 'acf_to_post/group_label', $group_label );
	}

	/**
	 * Return the 'Add Layout' button label
	 *
	 * @return mixed|void
	 */
	public static function buttonLabel() {
		$button_label = __('Add Block', 'tfr');
		return apply_filters( 'acf_to_post/button_label', $button_label);
	}

	/**
	 * Return unique key for flexible layout group
	 *
	 * @return mixed|void
	 */
	public static function key() {
		$key = 'blocks';
		return apply_filters( 'acf_to_post/key', $key );
	}

	/**
	 * Return unique name for flexible layout group
	 *
	 * @return mixed|void
	 */
	public static function name() {
		$name = 'blocks';
		return apply_filters( 'acf_to_post/name', $name );
	}

	/**
	 * Builds array of locations to add flexible layout
	 *
	 * @return array
	 */
	public static function locations() {
		$results = [];

		foreach (self::templates() as $PAGE_TEMPLATE) {
			$toAdd =[
				[
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => $PAGE_TEMPLATE,
				]
			];

			array_push($results, $toAdd);
		}

		foreach (self::postTypes() as $POST_TYPE) {
			$toAdd =[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => $POST_TYPE,
				]
			];
			array_push($results, $toAdd);
		}

		return $results;
	}

	/**
	 * Initialize layouts to be added to the flexible layout group
	 */
	public static function initLayouts() {
		if( class_exists( 'ACF' ) ) {

			Layouts\Hero::init();

		}
	}
}
