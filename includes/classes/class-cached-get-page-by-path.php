<?php
/**
 * Cached get page by path.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Get_Page_By_Path' ) ) {

	/**
	 * Cached get page by path.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Get_Page_By_Path {

		/**
		 * Cache group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'get_page_by_path';

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
		 * @param string $page_path Page path.
		 * @param string $output    The required return type. One of OBJECT, ARRAY_A, or ARRAY_N.
		 * @param string $post_type Post type or array of post types.
		 *
		 * @return WP_Post (or array) on success, or null on failure.
		 */
		public function init( $page_path, $output = OBJECT, $post_type = 'page' ) {

			// Bail early if $page_path is not set.
			if ( ! $page_path ) {
				return;
			}

			// Set cache key.
			if ( is_array( $post_type ) ) {
				// @codingStandardsIgnoreLine.
				$cache_key = sanitize_key( $page_path ) . '_' . md5( serialize( $post_type ) );
			} else {
				$cache_key = $post_type . '_' . sanitize_key( $page_path );
			}

			// Get the cache.
			$cache = wp_cache_get( $cache_key, $this->group );

			// If cache is not set.
			if ( false === $cache ) {

				// Get the page by path.
				// @codingStandardsIgnoreLine.
				$page = get_page_by_path( $page_path, $output, $post_type );

				// Set $page_ID. Set to 0 if there is no ID.
				$cache = $page ? $page->ID : 0;

				// Set the cache.
				if ( 0 === $cache ) {
					wp_cache_set( $cache_key, $cache, $this->group, ( 1 * HOUR_IN_SECONDS + mt_rand( 0, HOUR_IN_SECONDS ) ) );
				} else {
					wp_cache_set( $cache_key, $cache, $this->group, 0 );
				}
			}

			// If $cache is set return the page.
			if ( $cache ) {
				return get_page( $cache, $output );
			}

			return null;
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

				// Get the URI.
				$page_path = get_page_uri( $post->ID );

				// Delete the caache.
				wp_cache_delete( $post->post_type . '_' . sanitize_key( $page_path ), $this->group );
			}
		}
	}
}
