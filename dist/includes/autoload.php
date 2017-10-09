<?php
/**
 * Autoloader
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes
 * @author     Jason Witt info@jawdev.io
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    0.7.0
 */

namespace WP_Cavalry\Includes;

/**
 * Autoloader
 *
 * @param string $class Name of the class being requested.
 *
 * @since 0.0.1
 *
 * @return void
 */
function _autoload_classes( $class ) {

	// Get the class name.
	$class = explode( '\\', $class );

	// Full path to the classes directory.
	$path  = trailingslashit( plugin_dir_path( __FILE__ ) ) . trailingslashit( 'classes' );
	$files  = new \RecursiveDirectoryIterator( trailingslashit( plugin_dir_path( __FILE__ ) ) . trailingslashit( 'classes' ) );
	
	
	// Loop through the files.
	foreach ( new \RecursiveIteratorIterator( $files ) as $file ) {
		
		$filename = $file->getFilename();
		$filepath = $file->getPath();
		
		// Exclude dot files.
		if ( '.' === substr( $filename, 0, 1 ) ) {
			continue;
		}

		// Constructed file with full path to autoload.
		$path  = trailingslashit( $filepath ) . 'class-' . strtolower( str_replace( '_', '-', end( $class ) ) ) . '.php';

		// Add classes to be excluded from autoloading. example: array( $path . 'class-name.php' );.
		$excludes  = array();

		// Require file if the file exists and is not in the excludes list.
		if ( file_exists( $path ) && ! in_array( $path, $excludes, true ) ) {

			require_once( $path );
		}
	}
}
spl_autoload_register( __NAMESPACE__ . '\\_autoload_classes' );
