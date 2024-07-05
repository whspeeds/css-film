<?php
/**
 * Movie features
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include taxonomy and custom post type.
require_once dirname( __FILE__ ) . '/taxonomy-post-type.php';

// Include custom query.
require_once dirname( __FILE__ ) . '/query.php';

if ( is_admin() ) {
	// Include other metaboxes .
	require_once dirname( __FILE__ ) . '/metabox.php';
	require_once dirname( __FILE__ ) . '/metabox.tv.php';
	require_once dirname( __FILE__ ) . '/metabox.eps.php';

	/**
	* Loading required functions to uploading poster via url.
	*/
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
}

