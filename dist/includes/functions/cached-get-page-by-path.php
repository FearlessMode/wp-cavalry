<?php
/**
 * Cached get page by path.
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

if ( ! function_exists( 'cached_get_page_by_path' ) ) {
	/**
	 * Cached get page by path.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param string $page_path Page path.
	 * @param string $output    The required return type. One of OBJECT, ARRAY_A, or ARRAY_N.
	 * @param string $post_type Post type or array of post types.
	 *
	 * @return Cached_Get_Page_By_Path()->Init()
	 */
	function cached_get_page_by_path( $page_path, $output = OBJECT, $post_type = 'page' ) {

		$cached_get_page_by_path = new WP_Cavalry\Includes\Classes\Cached_Get_Page_By_Path;
		return $cached_get_page_by_path->init( $page_path, $output, $post_type );
	}
}
