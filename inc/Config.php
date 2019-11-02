<?php


namespace TFR\ACFToPost\Inc;

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
	 * Array of post types to add flexible layout
	 */
	const POST_TYPES = [
		'post',
		'page'
	];

	/**
	 * Templates that use the flexible layout
	 */
	const TEMPLATES = [
		'default'
	];

	/**
	 * Name of filter for the layouts array
	 */
	const LAYOUTS_FILTER = 'flexible_group_layouts';

	/**
	 * Label for the flexible layouts group displayed on page editor
	 */
	const GROUP_LABEL = 'Content Blocks';

	/**
	 * Unique key for flexible layout group
	 */
	const KEY = 'blocks';

	/**
	 * Unique name for flexible layout group
	 */
	const NAME = 'blocks';

	/**
	 * Builds array of locations to add flexible layout
	 *
	 * @return array
	 */
	public static function locations() {
		$results = [];

		foreach (self::TEMPLATES as $PAGE_TEMPLATE) {
			$toAdd =[
				[
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => $PAGE_TEMPLATE,
				]
			];

			array_push($results, $toAdd);
		}

		foreach (self::POST_TYPES as $POST_TYPE) {
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
		if(class_exists( 'ACF' ) ) {

			Layouts\Hero::init();

		}
	}
}
