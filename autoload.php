<?php

namespace TFR\ACFToPost;

spl_autoload_register( function ( $class ) {
	$prefix   = __NAMESPACE__; // change this to your root namespace
	$base_dir = dirname(__FILE__) . '/classes'; // make sure this is the directory with your classes
	$len      = strlen( $prefix );

	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$relative_class = substr( $class, $len );
	$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

	if ( file_exists( $file ) ) {
		require_once $file;
	}

} );
