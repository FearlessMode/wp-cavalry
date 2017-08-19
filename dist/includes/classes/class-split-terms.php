<?php
/**
 * Split Terms.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Split_Terms' ) ) {

	/**
	 * Split Terms.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Split_Terms {

		/**
		 * Initialize the class.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @return void
		 */
		public function __construct() {

			// Split terms.
			add_action( 'split_shared_term', array( $this, 'init' ), 10, 4 );
		}

		/**
		 * Initalize.
		 *
		 * When a term is split we need to delete the caches we have put in place.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @param string $term_id          The term ID.
		 * @param string $new_term_id      The new split term ID.
		 * @param string $term_taxonomy_id The term taxonomy ID.
		 * @param string $taxonomy         The taxonomy name.
		 *
		 * @return void
		 */
		public function init( $term_id, $new_term_id, $term_taxonomy_id, $taxonomy ) {

			// Get term by ID.
			$term = cached_get_term_by( 'id', $new_term_id, $taxonomy );

			// Loop through the term ID, name, and term taxonomy ID.
			foreach ( array( 'slug', 'name', 'term_taxonomy_id' ) as $field ) {

				// Set the cache key.
				$cache_key = $field . '_' . $taxonomy . '|' . md5( $term->$field );

				// Delete the cache.
				wp_cache_delete( $cache_key, 'get_term_by' );
			}

			// Loop through the term ID, name, and slug.
			foreach ( array( 'term_id', 'name', 'slug' ) as $field ) {

				// Set the cache key.
				$cache_key = $term->$field . '_' . $taxonomy ;

				// Delete the cache.
				wp_cache_delete( $cache_key, 'term_exists' );

				// Set the cache key.
				$cache_key = $term->$field ;

				// Delete the cache.
				wp_cache_delete( $cache_key, 'term_exists' );
			}

			$posts_per_page = apply_filters( 'split_terms_posts_per_page', 100 );
			$paged = 1;

			do {

				// Set the query argsuments.
				$args = array(
					'posts_per_page' => $posts_per_page,
					'fields'    => 'ids',
					'paged'     => $paged,
					// @codingStandardsIgnoreLine.
					'tax_query' => array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'term_id',
							'terms'    => $new_term_id,
						),
					),
				);

				// Query the posts.
				// @codingStandardsIgnoreLine.
				$posts = get_posts( $args );

				// Loop through the posts and delete the cache.
				foreach ( $posts as $post ) {
					wp_cache_delete( $post, $taxonomy . '_relationships' );
				}

				$paged++;
				sleep( 2 );
			// @codingStandardsIgnoreLine.
			} while ( count( $posts ) );
		}
	}
}
