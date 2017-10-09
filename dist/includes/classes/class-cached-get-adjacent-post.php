<?php
/**
 * Cached get adjacent post.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    0.7.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Get_Adjacent_Post' ) ) {

	/**
	 * Cached get adjacent post.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Get_Adjacent_Post {

		/**
		 * Cache name.
		 *
		 * @author Jason Witt
		 * @since  0.0.1
		 *
		 * @var string
		 */
		protected $name = 'adjacent_post_';

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
		 * @param bool   $in_same_term   Whether post should be in a same taxonomy term.
		 * @param int    $excluded_terms Array or comma-separated list of excluded term IDs.
		 * @param bool   $previous       Whether to retrieve previous post. Default true.
		 * @param string $taxonomy       Taxonomy, if $in_same_term is true.
		 *
		 * @global wpdb $wpdb
		 *
		 * @return null|string|WP_Post Post object if successful. Null if global $post is not set. Empty string if no corresponding post exists.
		 */
		public function init( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {

			// Get $wpdb global.
			global $wpdb;

			$post = get_post();

			// If no there are posts or if taxonomy doesn't exist return null.
			if ( ( ! $post ) || ! taxonomy_exists( $taxonomy ) ) {
				return null;
			}
			$join  = '';
			$where = '';

			// Get the post date.
			$current_post_date = $post->post_date;

			// If posts have the sane term.
			if ( $in_same_term ) {

				// If the term object is set in the taxonomy.
				if ( is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {

					// Get the terms for the posts.
					$term_array = get_the_terms( $post->ID, $taxonomy );

					// If $term array is set and not empty.
					if ( ! empty( $term_array ) && ! is_wp_error( $term_array ) ) {

						// Get the term IDs.
						$term_array_ids = wp_list_pluck( $term_array, 'term_id' );

						// Remove any exclusions from the term array to include.
						$excluded_terms = explode( ',', $excluded_terms );

						// If there are exclusions.
						if ( ! empty( $excluded_terms ) ) {
							$term_array_ids = array_diff( $term_array_ids, (array) $excluded_terms );
						}

						// If $term_array_ids is not empty.
						if ( ! empty( $term_array_ids ) ) {
							$term_array_ids = array_map( 'intval', $term_array_ids );
							$term_id_to_search = array_pop( $term_array_ids );
						} else {
							$term_id_to_search = false;
						}

						$term_id_to_search = apply_filters( 'limit_adjacent_post_term_id', $term_id_to_search, $term_array_ids, $excluded_terms, $taxonomy, $previous );

						// If $term_id_to_search is not empty.
						if ( ! empty( $term_id_to_search ) ) {

							// Set the query.
							$join = "INNER JOIN $wpdb->term_relationships
									 AS tr ON p.ID = tr.object_id
									 INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
							$where = $wpdb->prepare( 'AND tt.taxonomy = %s AND tt.term_id IN (%d)  ', $taxonomy, $term_id_to_search );
						}
					}
				}
			}

			$operators = $previous ? '<' : '>';
			$order     = $previous ? 'DESC' : 'ASC';
			$limit     = 1;

			// If $excluded_term is not empty limit query to 5 posts.
			if ( ! empty( $excluded_term ) ) {
				$limit = 5;
			}

			// Set the query.
			$sort  = "ORDER BY p.post_date $order LIMIT $limit";
			// @codingStandardsIgnoreLine.
			$where = $wpdb->prepare( "WHERE p.post_date $operators %s AND p.post_type = %s AND p.post_status = 'publish' $where", $current_post_date, $post->post_type );
			$query = "SELECT p.ID FROM $wpdb->posts AS p $join $where $sort";

			$found_post = '';

			// Set the cache key.
			$cache_key = $this->name . md5( $query );

			// Get the cache.
			$cache = wp_cache_get( $cache_key, $this->group );

			// If no adjacent posts found.
			if ( $this->not_found === $cache ) {
				return false;
			} elseif ( false !== $cache ) {
				return get_post( $cache );
			}

			// If $excluded_term is empty.
			if ( empty( $excluded_term ) ) {
				// @codingStandardsIgnoreLine.
				$result = $wpdb->get_var( $query );
			} else {
				// @codingStandardsIgnoreLine.
				$result = $wpdb->get_results( $query );
			}

			// If $excluded_term not empty find the first post which doesn't have an excluded term.
			if ( ! empty( $excluded_term ) ) {

				// Loop through the query results.
				foreach ( $result as $result_post ) {

					// Get the post terms.
					$post_terms = get_the_terms( $result_post, $taxonomy );

					// Get the term IDs.
					$terms_array = wp_list_pluck( $post_terms, 'term_id' );

					// If the terms are not in the exclude list.
					if ( ! in_array( $excluded_term, $terms_array, true ) ) {

						// Get the post ID.
						$found_post = $result_post->ID;
						break;
					}
				}
			} else {
				$found_post = $result;
			}

			// If no post set cache to 'not found'.
			if ( empty( $found_post ) ) {

				// Set the cache.
				wp_cache_set( $cache_key, $this->not_found, $this->group, 15 * MINUTE_IN_SECONDS + rand( 0, 15 * MINUTE_IN_SECONDS ) );

				// Bail.
				return false;
			}

			// Set the cache if posts are found.
			wp_cache_set( $cache_key, $found_post, $this->group, 6 * HOUR_IN_SECONDS + rand( 0, 2 * HOUR_IN_SECONDS ) );

			// Get the post.
			$found_post = get_post( $found_post );

			return $found_post;
		}
	}
}
