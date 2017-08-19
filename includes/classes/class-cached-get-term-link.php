<?php
/**
 * Cached get term link.
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

namespace WP_Cavalry\Includes\Classes;

if ( ! class_exists( 'Cached_Get_Term_Link' ) ) {

	/**
	 * Cached get term link.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 */
	class Cached_Get_Term_Link {

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
		 * @param string $term     The term object, ID, or slug whose link will be retrieved.
		 * @param string $taxonomy Taxonomy.
		 *
		 * @return string|WP_Error HTML link to taxonomy term archive on success, WP_Error if term does not exist.
		 */
		public function init( $term, $taxonomy = '' ) {

			// If $term is numeric or object.
			if ( is_numeric( $term ) || is_object( $term ) ) {
				// @codingStandardsIgnoreLine.
				return get_term_link( $term, $taxonomy );
			}

			// Get the term by slug.
			$term_object = cached_get_term_by( 'slug', $term, $taxonomy );

			// @codingStandardsIgnoreLine.
			return get_term_link( $term_object );
		}
	}
}
