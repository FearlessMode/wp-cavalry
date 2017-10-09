<?php
/**
 * Cached get adjacent post.
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

if ( ! function_exists( 'cached_get_adjacent_post' ) ) {
	/**
	 * Cached get adjacent post.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param bool   $in_same_term   Whether post should be in a same taxonomy term.
	 * @param int    $excluded_terms Array or comma-separated list of excluded term IDs.
	 * @param bool   $previous       Whether to retrieve previous post. Default true.
	 * @param string $taxonomy       Taxonomy, if $in_same_term is true.
	 *
	 * @return Cached_Get_Adjacent_Post()->Init()
	 */
	function cached_get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {

		$cached_get_adjacent_post = new WP_Cavalry\Includes\Classes\Cached_Get_Adjacent_Post;
		return $cached_get_adjacent_post->init( $in_same_term, $excluded_terms, $previous, $taxonomy );
	}
}
