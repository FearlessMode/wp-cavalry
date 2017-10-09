<?php
/**
 * Cached term exists.
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

if ( ! function_exists( 'cached_term_exists' ) ) {
	/**
	 * Cached term exists.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param int|string $term     The term to check can be id, slug or name.
	 * @param string     $taxonomy The taxonomy name to use.
	 * @param int        $parent   ID of parent term under which to confine the exists search.
	 *
	 * @return Cached_Term_Exists()->Init()
	 */
	function cached_term_exists( $term, $taxonomy = '', $parent = null ) {

		$cached_term_exists = new WP_Cavalry\Includes\Classes\Cached_Term_Exists;
		return $cached_term_exists->init( $term, $taxonomy, $parent );
	}
}
