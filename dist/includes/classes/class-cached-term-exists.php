<?php
/**
 * Cached term exists.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Term_Exists' ) ) {

	/**
	 * Cached term exists.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Term_Exists {

		/**
		 * Cache group.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $group = 'term_exists';

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
			add_action( 'delete_term', array( $this, 'flush_cache' ), 10, 4 );
		}

		/**
		 * Initialize.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param int|string $term     The term to check can be id, slug or name.
		 * @param string     $taxonomy The taxonomy name to use.
		 * @param int        $parent   ID of parent term under which to confine the exists search.
		 *
		 * @return mixed Returns null if the term does not exist. Returns the term ID
		 *               if no taxonomy is specified and the term ID exists. Returns
		 *               an array of the term ID and the term taxonomy ID the taxonomy
		 *               is specified and the pairing exists.
		 */
		public function init( $term, $taxonomy = '', $parent = null ) {

			// If $parent is not null, let's skip the cache.
			if ( null !== $parent ) {
				// @codingStandardsIgnoreLine.
				return term_exists( $term, $taxonomy, $parent );
			}

			// Set the cache key.
			if ( ! empty( $taxonomy ) ) {
				$cache_key = $term . '_' . $taxonomy;
			} else {
				$cache_key = $term;
			}

			// Get the cache value.
			$cache_value = wp_cache_get( $cache_key, $this->group );

			// Set the cache if there is not an error. Else set invalid value if error.
			if ( false === $cache_value ) {
				// @codingStandardsIgnoreLine.
				$term_exists = term_exists( $term, $taxonomy );
				wp_cache_set( $cache_key, $term_exists, $this->group, 3 * HOUR_IN_SECONDS );
			} else {
				$term_exists = $cache_value;
			}

			// If error return null.
			if ( is_wp_error( $term_exists ) ) {
				$term_exists = null;
			}

			return $term_exists;
		}

		/**
		 * Flush Cache.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param string $term             The term ID.
		 * @param string $term_taxonomy_id The term taxonomy ID.
		 * @param string $taxonomy         The taxonomy name.
		 * @param string $deleted_term     The deleted term.
		 *
		 * @return void
		 */
		public function flush_cache( $term, $term_taxonomy_id, $taxonomy, $deleted_term ) {

			// Loop through the term ID, name, and slug.
			foreach ( array( 'term_id', 'name', 'slug' ) as $field ) {
				// Set the cache key.
				$cache_key = $deleted_term->$field . '_' . $taxonomy ;

				// Delete the cache.
				wp_cache_delete( $cache_key, $this->group );
			}
		}
	}
}
