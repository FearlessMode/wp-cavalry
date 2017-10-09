<?php
/**
 * Cached full comment counts.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    0.7.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Full_Comment_Counts' ) ) {

	/**
	 * Cached full comment counts.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Full_Comment_Counts {

		/**
		 * Cache name.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $name = 'full_comment_counts_';

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
		 * Theme Support.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $theme_support = 'full_comment_counts';

		/**
		 * Initialize the class.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return void
		 */
		public function __construct() {
			$this->hooks();
		}

		/**
		 * Hooks.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return void
		 */
		public function hooks() {

			// If theme support for 'full_comment_counts' is added.
			if ( current_theme_supports( $this->theme_support ) ) {
				add_filter( 'wp_count_comments', array( $this, 'init' ), 10, 2 );
			}
		}

		/**
		 * Initialize.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param int $post_id The post ID.
		 *
		 * @return mixed The comment stats object.
		 */
		public function init( $post_id = 0 ) {

			// Cache only the global comments.
			if ( 0 !== $post_id ) {
				return false;
			}

			// Set the cache key.
			$cache_key = $this->name . '_' . $post_id;

			// Get the cache.
			$stats_object = wp_cache_get( $cache_key, $this->group );

			// If no cache.
			if ( false === $stats_object ) {

				// Get the comment count.
				$stats = get_comment_count( $post_id );

				// Set moderated if awaiting moderation.
				$stats['moderated'] = $stats['awaiting_moderation'];

				// Unset comment awaiting moderation.
				unset( $stats['awaiting_moderation'] );

				// Set the stats object as an object.
				$stats_object = (object) $stats;

				// Set the cache.
				wp_cache_set( $cache_key, $stats_object, $this->group, 30 * MINUTE_IN_SECONDS );
			}

			return $stats_object;
		}
	}
}
