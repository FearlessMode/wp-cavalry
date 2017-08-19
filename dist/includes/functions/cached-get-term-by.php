<?php
/**
 * Cached get term by.
 *
 * Load: true
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version 0.1.0
 */

if ( ! function_exists( 'cached_get_term_by' ) ) {
	/**
	 * Cached get term by.
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
	 * @return Cached_Get_Term_By()->Init()
	 */
	function cached_get_term_by( $field, $value, $taxonomy, $output = OBJECT, $filter = 'raw' ) {

		$cached_get_term_by = new WP_Cavalry\Includes\Classes\Cached_Get_Term_By;
		return $cached_get_term_by->init( $field, $value, $taxonomy, $output, $filter );
	}
}

if ( ! function_exists( 'cached_get_category_by_slug' ) ) {
	/**
	 * Cached get category by slug.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param string $slug The category slug.
	 *
	 * @return Cached_Get_Term_By()->Init()
	 */
	function cached_get_category_by_slug( $slug ) {
		return cached_get_term_by( 'slug', $slug, 'category' );
	}
}
