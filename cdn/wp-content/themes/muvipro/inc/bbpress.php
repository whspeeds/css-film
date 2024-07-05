<?php
/**
 * Custom functions for bbpress
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Remove breadcrumb.
add_filter( 'bbp_no_breadcrumb', '__return_true' );
