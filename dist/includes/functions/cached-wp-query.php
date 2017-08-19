<?php
/**
 * Cached WP_Query.
 *
 * Load: true
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

if ( ! function_exists( 'cached_wp_query' ) ) {
	/**
	 * Cached WP_Query.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param string $name       The name to assign the queried object.
	 * @param array  $query_args The WP_Query arguments.
	 *
	 * @return Cached_WP_Query()->Init()
	 */
	function cached_wp_query( $name, $query_args = array() ) {

		$cached_wp_query = new WP_Cavalry\Includes\Classes\Cached_WP_Query;
		return $cached_wp_query->init( $name, $query_args );
	}
}
