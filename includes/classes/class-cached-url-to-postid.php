<?php
/**
 * Cached url to post ID.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Url_To_Postid' ) ) {

	/**
	 * Cached url to post ID.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Url_To_Postid {

		/**
		 * Cache group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'url_to_postid';

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
		 * @param string $url Permalink to check.
		 *
		 * @return int Post ID, or 0 on failure.
		 */
		public function init( $url ) {

			// If not ran after 'init' return 0.
			if ( ! did_action( 'init' ) ) {
				_doing_it_wrong(
					'cached_url_to_postid',
					__( 'cached_url_to_postid() must be called after the init action, as home_url() has not yet been filtered', 'wp-cavalry' ),
					''
				);

				return 0;
			}

			// Make sure the URL is on the same host.
			if ( wp_parse_url( $url, PHP_URL_HOST ) !== wp_parse_url( home_url(), PHP_URL_HOST ) ) {
				return 0;
			}

			// Set the cache key.
			$cache_key = md5( $url );

			// Get the cache.
			$post_id = wp_cache_get( $cache_key, $this->group );

			// If cache is not set.
			if ( false === $post_id ) {

				// Get the URL.
				// @codingStandardsIgnoreLine.
				$post_id = url_to_postid( $url );

				// Set the cache.
				wp_cache_set( $cache_key, $post_id, $this->group, 3 * HOUR_IN_SECONDS );
			}

			return $post_id;
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

				// Get the permalink.
				$url = get_permalink( $post->ID );

				// Delete the caache.
				wp_cache_delete( md5( $url ), $this->group );
			}
		}
	}
}
