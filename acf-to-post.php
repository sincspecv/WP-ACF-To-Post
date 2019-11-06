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
use TFR\ACFToPost\Inc\Fields;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Plugin
 *
 * @package TFR\ACFToPost
 * @since 0.1.0
 *
 * TODO: Break this out into a bootstrap class
 * TODO: Figure out a better place to init Fields
 */
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

		Fields::init();

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

		acf_add_local_field_group([
			'key'            => Config::groupKey(),
			'title'          => Config::groupLabel(),
			'fields'         => [
				[
					'key'          => Config::key(),
					'label'        => Config::flexibleContentLabel(),
					'name'         => Config::name(),
					'type'         => 'flexible_content',
					'layouts'      => Config::layouts(),
					'button_label' => Config::buttonLabel(),
				],
			],
			'location'       => Config::locations(),
			'hide_on_screen' => ['the_content'],
		]);

	}

}

// bootstrap the plugin
new Plugin();



