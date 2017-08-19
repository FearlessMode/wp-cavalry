<?php
/**
 * Cached attachment url to post ID.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Attachment_Url_To_Postid' ) ) {

	/**
	 * Cached attachment url to post ID.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Attachment_Url_To_Postid {

		/**
		 * Cache group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'attachment_url_post_id_';

		/**
		 * Not Found.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $not_found = 'not_found';

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
		 * @param string $url The URL to resolve.
		 *
		 * @return integer $cache The found post ID, or 0 on failure.
		 */
		public function init( $url ) {

			// Bail early if $url is not set.
			if ( ! $url ) {
				return;
			}

			// Set the cache key.
			$cache_key = md5( $url );

			// Get the cache.
			$cache = wp_cache_get( $cache_key, $this->group );

			// If no cache.
			if ( false === $cache ) {

				// Get the ID.
				// @codingStandardsIgnoreLine.
				$cache = attachment_url_to_postid( $url );

				// If $cache is empty.
				if ( empty( $cache ) ) {
					wp_cache_set( $cache_key, $this->not_found, $this->group, 12 * HOUR_IN_SECONDS + mt_rand( 0, 4 * HOUR_IN_SECONDS ) );
				} else {
					wp_cache_set( $cache_key, $cache, $this->group, 24 * HOUR_IN_SECONDS + mt_rand( 0, 12 * HOUR_IN_SECONDS ) );
				}

				// Bail if 'not found'.
			} elseif ( $this->not_found === $cache ) {
				return false;
			}

			return $cache;
		}
	}
}
