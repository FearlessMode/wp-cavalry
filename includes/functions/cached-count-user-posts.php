<?php
/**
 * Cached count user posts.
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

if ( ! function_exists( 'cached_count_user_posts' ) ) {
	/**
	 * Cached count user posts.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param integer $user_id   The ID of the user to count posts for.
	 * @param string  $post_type Post type to count the number of posts for.
	 *
	 * @return Cached_Count_User_Posts()->Init()
	 */
	function cached_count_user_posts( $user_id, $post_type = 'post' ) {

		$cached_count_user_posts = new WP_Cavalry\Includes\Classes\Cached_Count_User_Posts;
		return $cached_count_user_posts->init( $user_id, $post_type );
	}
}
