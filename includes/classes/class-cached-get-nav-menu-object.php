<?php
/**
 * Cached get nav menu object.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

// Include cached-get-term-by.php.
require_once trailingslashit( WP_PLUGIN_DIR ) . 'wp-cavalry/includes/functions/cached-get-term-by.php';

if ( ! class_exists( 'Cached_Get_Nav_Menu_Object' ) ) {

	/**
	 * Cached get nav menu object.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Get_Nav_Menu_Object {

		/**
		 * Term.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $term = 'nav_menu';

		/**
		 * Initialize the class.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return void
		 */
		public function __construct() {}

		/**
		 * Initialize.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param string $menu Menu ID, slug, or name.
		 *
		 * @return mixed false if $menu param isn't supplied or term does not exist, menu object if successful.
		 */
		public function init( $menu ) {

			// Bail if $menu is not set.
			if ( ! $menu ) {
				return;
			}

			// Get by ID.
			$menu_obj = get_term( $menu, $this->term );

			// Get by slug.
			if ( ! $menu_obj ) {
				$menu_obj = cached_get_term_by( 'slug', $menu, $this->term );
			}

			// Get by name.
			if ( ! $menu_obj ) {
				$menu_obj = cached_get_term_by( 'name', $menu, $this->term );
			}

			// Bail if $menu_obj is not set.
			if ( ! $menu_obj ) {
				$menu_obj = false;
			}

			return $menu_obj;
		}
	}
}
