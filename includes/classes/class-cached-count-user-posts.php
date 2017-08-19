<?php
/**
 * Cached count user posts.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Count_User_Posts' ) ) {

	/**
	 * Cached count user posts.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Count_User_Posts {

		/**
		 * Cache name.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $name = 'count_user_posts_';

		/**
		 * Cache group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'default';

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
		 * @param integer $user_id   The ID of the user to count posts for.
		 * @param string  $post_type Post type to count the number of posts for.
		 *
		 * @return integer $cache The user post count.
		 */
		public function init( $user_id, $post_type = 'post' ) {

			// Bail early if $user_id is not set.
			if ( ! $user_id ) {
				return;
			}

			// If $user_id not an integer return 0.
			if ( ! is_numeric( $user_id ) ) {
				return 0;
			}

			// Set the cache key.
			$cache_key = $this->name . (int) $user_id;

			// Get the cache.
			$count = wp_cache_get( $cache_key, $this->group );

			// If cache not set.
			if ( false === $count ) {

				// Get the user count
				// @codingStandardsIgnoreLine.
				$count = count_user_posts( $user_id, $post_type );

				// Set the cache.
				wp_cache_set( $cache_key, $count, $this->group, 5 * MINUTE_IN_SECONDS );
			}

			return $count;
		}
	}
}
