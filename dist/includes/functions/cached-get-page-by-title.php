<?php
/**
 * Cached get page by title.
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

if ( ! function_exists( 'cached_get_page_by_title' ) ) {
	/**
	 * Cached get page by title.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param string $title     Page title.
	 * @param string $output    The required return type. One of OBJECT, ARRAY_A, or ARRAY_N.
	 * @param string $post_type Post type or array of post types.
	 *
	 * @return Cached_Get_Page_By_Title()->Init()
	 */
	function cached_get_page_by_title( $title, $output = OBJECT, $post_type = 'page' ) {

		$cached_get_page_by_title = new WP_Cavalry\Includes\Classes\Cached_Get_Page_By_Title;
		return $cached_get_page_by_title->init( $title, $output, $post_type );
	}
}
