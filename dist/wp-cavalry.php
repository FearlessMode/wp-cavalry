<?php
/**
 * Plugin Name: WP Cavalry
 * Plugin URI:  https://github.com/jawittdesigns/wp-cavalry
 * Description: A library of WordPress helper classes and functions
 * Version:     0.7.0
 * Author:      Jason Witt
 * Author URI:  http://www.jawdev.io
 * License:     GPLv2
 * Text Domain: wp-cavalry
 * Domain Path: /languages
 *
 * @package   WP_Cavalry
 * @author    Jason Witt <info@jawdev.io>
 * @copyright Copyright (c) {{year}}, Jason Witt
 * @license   GNU General Public License v2 or later
 * @version   0.7.0
 */

namespace WP_Cavalry;

use WP_Cavalry\Includes\Classes as Classes;

/*
 * Autoloader
 */
require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . trailingslashit( 'includes' ) . 'autoload.php';

if ( ! class_exists( 'WP_Cavalry' ) ) {

	/**
	 * WP Cavalry.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class WP_Cavalry {

		/**
		 * Singleton instance of plugin.
		 *
		 * @var   WP_Cavalry
		 * @since 0.0.1
		 */
		protected static $single_instance = null;

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return A single instance of this class.
		 */
		public static function get_instance() {
			if ( null === self::$single_instance ) {
				self::$single_instance = new self();
			}

			return self::$single_instance;
		}

		/**
		 * Initialize the class
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return void
		 */
		public function __construct() {}

		/**
		 * Init
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return void
		 */
		public function init() {

			// Load translated strings for plugin.
			load_plugin_textdomain( 'wp-cavalry', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

			// Instantiate Classes.
			$this->classes();
		}

		/**
		 * Classes.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return void
		 */
		public function classes() {
			// Instantiate the Classes.
			$cached_full_comment_counts = new Classes\Cache\Cached_Full_Comment_Counts;
			$split_terms                = new Classes\Utilities\Split_Terms;
			$template_tags              = new Classes\Template_Tags( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/functions' );
		}
	}
}

/**
 * Return an instance of the plugin class.
 *
 * @author Jason Witt
 * @since  0.0.1
 *
 * @return Singleton instance of plugin class.
 */
function plugin_function() {
	return WP_Cavalry::get_instance();
}
add_action( 'plugins_loaded', array( plugin_function(), 'init' ) );
