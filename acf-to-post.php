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

use TFR\ACFToPost\Groups\Page;
use TFR\ACFToPost\Layouts\Hero;
use TFR\ACFToPost\Repeaters\Modules;
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
	 * @since 0.1.0
	 */
	public $version = "0.1.0";

	/**
	 * Path to root directory of plugin
	 *
	 * @var string $path
	 */
	public $path;

	/**
	 * Plugin constructor
	 *
	 * @since 0.1.0
	 */
	function __construct() {
		$this->path = dirname(__FILE__);
		$this->autoload();

		Fields::init();
		FormatFieldType::init();

		add_action( 'plugins_loaded', [$this, 'initLayouts'] );
		add_action( 'plugins_loaded', [$this, 'initFields'] );
		add_action( 'plugins_loaded', [$this, 'initGroups'] );
	}

	/**
	 * Load classes
	 *
	 * @since 0.1.0
	 */
	private function autoload() {
		require_once $this->path . '/autoload.php';
	}

	/**
	 * Initialize ACF layouts
	 *
	 * The $layouts variable is an array of class names. Each class represents an
	 * ACF layout and must contain a method named init that adds the layout to an ACF group.
	 *
	 * @since 0.1.0
	 */
	public function initLayouts() {
		$layouts = apply_filters( 'acf_to_post/init/layouts', [] );

		if( ! empty( $layouts ) ) {
			foreach( $layouts as $layout ) {
				// Make sure the init method exists before calling it
				if( method_exists( $layout, 'init' ) ) {
					$obj = new $layout;
					$obj->init();
				}
			}
		}
	}

	public function initFields() {
		$fields = apply_filters( 'acf_to_post/init/fields', [] );

		if( ! empty( $fields ) ) {
			foreach( $fields as $field ) {
				// Make sure the init method exists before calling it
				if( method_exists( $field, 'init' ) ) {
					$obj = new $field;
					$obj->init();
				}
			}
		}
	}

	/**
	 * Initialize ACF groups
	 *
	 * The $groups variable is an array of class names. Each class represents an
	 * ACF group and must contain a method named init that adds the group.
	 *
	 * @since 0.1.0
	 */
	public function initGroups() {
		$groups = apply_filters( 'acf_to_post/init/groups', [] );

		if( ! empty( $groups ) ) {
			foreach( $groups as $group ) {
				// Make sure the init method exists before calling it
				if( method_exists ( $group, 'init' ) ) {
					$obj = new $group;
					$obj->init();
				}
			}
		}
	}
}

// bootstrap the plugin
new Plugin();



