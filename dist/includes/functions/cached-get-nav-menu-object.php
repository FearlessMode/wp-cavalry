<?php
/**
 * Cached get nav menu object.
 *
 * Load: true
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    0.7.0
 */

if ( ! function_exists( 'cached_get_nav_menu_object' ) ) {
	/**
	 * Cached get nav menu object.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param string $menu Menu ID, slug, or name.
	 *
	 * @return Cached_Get_Nav_Menu_Object()->Init()
	 */
	function cached_get_nav_menu_object( $menu ) {

		$cached_get_nav_menu_object = new WP_Cavalry\Includes\Classes\Cached_Get_Nav_Menu_Object;
		return $cached_get_nav_menu_object->init( $menu );
	}
}
