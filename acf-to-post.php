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

use TFR\ACFToPost\Groups\PageGroup;
use TFR\ACFToPost\Layouts\Hero;
use TFR\ACFToPost\Util\FormatFieldType;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Plugin
 *
 * @package TFR\ACFToPost
 * @since 0.1.0
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

		Fields::init();
		FormatFieldType::init();

		$this->initLayouts();
		$this->initGroups();
	}

	/**
	 * Load classes
	 */
	private function autoload() {
		require_once $this->path . '/autoload.php';
	}

	private function initLayouts() {
		$layouts = [
			Hero::class,
		];
		$layouts = apply_filters( 'acf_to_post/init/layouts', $layouts );
		if( ! empty( $layouts ) ) {
			foreach( $layouts as $layout ) {
				forward_static_call( [$layout, 'init'] );
			}
		}
	}

	private function initGroups() {
		$groups = [
			PageGroup::class,
		];
		$groups = apply_filters( 'acf_to_post/init/groups', $groups );
		if( ! empty( $groups ) ) {
			foreach( $groups as $group ) {
				forward_static_call( [$group, 'init'] );
			}
		}
	}
}

// bootstrap the plugin
new Plugin();



