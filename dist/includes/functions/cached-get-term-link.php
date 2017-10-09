<?php
/**
 * Cached get term link.
 *
 * Load: true
 *
 * @package    WP_Cavalry
 * @subpackage WP_Cavalry/Includes/Classes
 * @author     Jason Witt <info@jawdev.io>
 * @copyright  Copyright (c) 2017, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    0.7.0
 */

if ( ! function_exists( 'cached_get_term_link' ) ) {
	/**
	 * Cached get term link.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param string $term     The term object, ID, or slug whose link will be retrieved.
	 * @param string $taxonomy Taxonomy.
	 *
	 * @return Cached_Get_Term_Link()->Init()
	 */
	function cached_get_term_link( $term, $taxonomy = '' ) {

		$cached_get_term_link = new WP_Cavalry\Includes\Classes\Cached_Get_Term_Link;
		return $cached_get_term_link->init( $term, $taxonomy );
	}
}
