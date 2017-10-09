<?php
/**
 * Cached attachment url to post ID.
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

if ( ! function_exists( 'cached_attachment_url_to_postid' ) ) {
	/**
	 * Cached attachment url to post ID.
	 *
	 * @author Jason Witt
	 * @since  0.0.1
	 *
	 * @param string $url The URL to resolve.
	 *
	 * @return Cached_Attachment_Url_To_Postid()->Init()
	 */
	function cached_attachment_url_to_postid( $url ) {

		$cached_attachment_url_to_postid = new WP_Cavalry\Includes\Classes\Cached_Attachment_Url_To_Postid;
		return $cached_attachment_url_to_postid->init( $url );
	}
}
