<?php
/**
 * Cached WP_Query.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    0.7.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_WP_Query' ) ) {

	/**
	 * Cached WP_Query.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_WP_Query {

		/**
		 * Query Name.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $name;

		/**
		 * Cache Group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'wp_query';

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

			// Flush cache.
			add_action( 'transition_post_status', array( $this, 'flush_cache' ), 10, 3 );
		}

		/**
		 * Initialize.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param string $name       The name to assign the queried object.
		 * @param array  $query_args The WP_Query arguments.
		 *
		 * @return WP_Query
		 */
		public function init( $name, $query_args = array() ) {

			// Bail if $name not set.
			if ( ! $name ) {
				return;
			} else {
				$this->name = $name;
			}

			$defaults = array(
				'post_type' => 'post',
			);

			$query_args = wp_parse_args( $query_args, $defaults );

			// Set cache key.
			$cache_key = $query_args['post_type'] . '_' . md5( $this->name );

			// Get the cache.
			$query = wp_cache_get( $cache_key, $this->group );

			// If cache is not set.
			if ( false === $query ) {

				// If $query_args is not empty.
				if ( ! empty( $query_args ) ) {

					// Get the query.
					$query = new \WP_Query( $query_args );

					// Set the cache.
					wp_cache_set( $cache_key, $query, $this->group, 7 * DAY_IN_SECONDS );
				}
			}

			// Bail if $query not set.
			if ( ! $query ) {
				return;
			}

			return $query;
		}

		/**
		 * Flush Cache.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param string  $new_status The post's new status.
		 * @param string  $old_status The post's previous status.
		 * @param WP_Post $post The post.
		 *
		 * @return void
		 */
		public function flush_cache( $new_status, $old_status, $post ) {

			// If published.
			if ( 'publish' === $new_status || 'publish' === $old_status ) {

				// Delete the caache.
				wp_cache_delete( $post->post_type . '_' . md5( $this->name ), $this->group );
			}
		}
	}
}
