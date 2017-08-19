<?php
/**
 * Cached get term by.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Get_Term_By' ) ) {

	/**
	 * Cached get term by.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Get_Term_By {

		/**
		 * Cache group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'get_term_by';

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
			add_action( 'edit_terms', array( $this, 'flush_cache' ), 10, 2 );
			add_action( 'create_term', array( $this, 'flush_cache' ), 10, 2 );
		}

		/**
		 * Initialize.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param string     $field    Either 'slug', 'name', 'id' (term_id), or 'term_taxonomy_id'.
		 * @param string|int $value    Search for this term value.
		 * @param string     $taxonomy Taxonomy name. Optional, if $field is 'term_taxonomy_id'.
		 * @param string     $output   The required return type. One of OBJECT, ARRAY_A, or ARRAY_N.
		 * @param string     $filter   Default is 'raw' or no WordPress defined filter will applied.
		 *
		 * @return mixed|null|bool Term Row from database in the type specified by $filter. Will return false if $taxonomy does not exist or $term was not found.
		 */
		public function init( $field, $value, $taxonomy, $output = OBJECT, $filter = 'raw' ) {

			// ID lookups are cached.
			if ( 'id' === $field ) {
				// @codingStandardsIgnoreLine.
				return get_term_by( $field, $value, $taxonomy, $output, $filter );
			}

			// Set the cache key.
			$cache_key = $field . '_' . $taxonomy . '_' . md5( $value );

			// Get the cached term.
			$term_id = wp_cache_get( $cache_key, $this->group );

			// If term is not cached.
			if ( false === $term_id ) {

				// Get the term.
				// @codingStandardsIgnoreLine.
				$term = get_term_by( $field, $value, $taxonomy );

				// Set the cache if there is not an error. Else set invalid value if error.
				if ( $term && ! is_wp_error( $term ) ) {
					wp_cache_set( $cache_key, $term->term_id, $this->group, 4 * HOUR_IN_SECONDS );
				} else {
					wp_cache_set( $cache_key, 0, $this->group, 15 * MINUTE_IN_SECONDS );
				}

				// If not set as an object.
				if ( OBJECT !== $output && $term && ! is_wp_error( $term ) ) {
					$term = get_term( $term->term_id, $taxonomy, $output, $filter );
				}
			} else {

				// Get the term.
				$term = get_term( $term_id, $taxonomy, $output, $filter );
			}

			// If error return false.
			if ( is_wp_error( $term ) ) {
				$term = false;
			}

			return $term;
		}

		/**
		 * Flush Cache.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param string $term_id The term ID.
		 * @param string $taxonomy Taxonomy Name.
		 *
		 * @return void
		 */
		public function flush_cache( $term_id, $taxonomy ) {

			// Get the term.
			// @codingStandardsIgnoreLine.
			$term = get_term_by( 'id', $term_id, $taxonomy );

			// Bail early if $term not set.
			if ( ! $term ) {
				return;
			}

			// Loop through the term name and slug.
			foreach ( array( 'name', 'slug' ) as $field ) {

				// Set the cache key.
				$cache_key = $field . '_' . $taxonomy . '_' . md5( $term->$field );

				// Delete the cache.
				wp_cache_delete( $cache_key, $this->group );
			}
		}
	}
}
