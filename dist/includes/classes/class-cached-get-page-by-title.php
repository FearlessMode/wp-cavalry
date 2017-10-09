<?php
/**
 * Cached get page by title.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    0.7.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Get_Page_By_Title' ) ) {

	/**
	 * Cached get page by title.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Get_Page_By_Title {

		/**
		 * Cache group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'get_page_by_title';

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
		 * @param string $title     Page title.
		 * @param string $output    The required return type. One of OBJECT, ARRAY_A, or ARRAY_N.
		 * @param string $post_type Post type or array of post types.
		 *
		 * @return WP_Post|null WP_Post on success or null on failure
		 */
		public function init( $title, $output = OBJECT, $post_type = 'page' ) {

			// Set cache key.
			$cache_key = $post_type . '_' . sanitize_key( $title );

			// Get the cache.
			$page_id = wp_cache_get( $cache_key, $this->group );

			// If cache is not set.
			if ( false === $page_id ) {

				// Get the page by title.
				// @codingStandardsIgnoreLine.
				$page = get_page_by_title( $title, OBJECT, $post_type );

				// Set $page_ID. Set to 0 if there is no ID.
				$page_id = $page ? $page->ID : 0;

				// Set the cache.
				wp_cache_set( $cache_key, $page_id, $this->group, 3 * HOUR_IN_SECONDS );
			}

			// If $page_id is set return the page.
			if ( $page_id ) {
				return get_page( $page_id, $output );
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

				// Delete the caache.
				wp_cache_delete( $post->post_type . '_' . sanitize_key( $post->post_title ), $this->group );
			}
		}
	}
}
