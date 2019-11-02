<?php
/*
Plugin Name: ACF to Post
Plugin URI: https://thefancyrobot.com
Description: Automatically add ACF fields to the post object
Version: 0.1.0
Author: Matthew Schroeter
Author URI: https://mattschroeter.me
Text Domain: tfr
Domain Path: /lang
 */

namespace TFR\ACFToPost;

use TFR\ACFToPost\Inc\Config;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

class Plugin {
	/**
	 * Define the version of the plugin
	 *
	 * @var string $version
	 */
	public $version = "0.1.0";

	/**
	 * Path to root directory of plugin
	 *
	 * @var string $path
	 */
	public $path;

	/**
	 * Plugin constructor.
	 */
	function __construct() {
		$this->path = dirname(__FILE__);
		$this->autoload();

		add_action('plugins_loaded', [Config::class, 'initLayouts']);
		add_action('acf/init', [$this, 'addFlexibleLayouts']);
	}

	/**
	 * Load classes
	 */
	private function autoload() {
		$dirs = glob( "{$this->path}/*", GLOB_ONLYDIR);

		foreach( $dirs as $dir ) {
			if( file_exists( "{$dir}/autoload.php" ) ) {
				require_once( "{$dir}/autoload.php");
			}
		}
	}

	/**
	 * Add the flexible layout group
	 */
	public function addFlexibleLayouts()  {
		$layouts = apply_filters( Config::LAYOUTS_FILTER, []);

		acf_add_local_field_group([
			'key'            => strtolower( str_replace(['\\', '-'], '_', __NAMESPACE__ ) ) . '_flexible_layout',
			'title'          => __(Config::GROUP_LABEL, 'tfr'),
			'fields'         => [
				[
					'key'          => Config::KEY,
					'label'        => __('Blocks', 'tfr'),
					'name'         => Config::KEY,
					'type'         => 'flexible_content',
					'layouts'      => $layouts,
					'button_label' => __('Add Block', 'tfr'),
				],
			],
			'location'       => Config::locations(),
			'hide_on_screen' => ['the_content'],
		]);
	}

}

// bootstrap the plugin
new Plugin();

