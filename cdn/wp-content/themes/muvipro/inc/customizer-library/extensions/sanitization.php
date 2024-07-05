<?php
/**
 * Customizer Sanization
 *
 * @package Customizer_Library
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'customizer_library_sanitize_text' ) ) :
	/**
	 * Sanitize a string to allow only tags in the allowedtags array.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string $string The unsanitized string.
	 */
	function customizer_library_sanitize_text( $string ) {
		global $allowedtags;
		return wp_kses( $string, $allowedtags );
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_checkbox' ) ) :
	/**
	 * Sanitize a checkbox to only allow 0 or 1
	 *
	 * @since  1.0.0.
	 *
	 * @param  boolean $value The unsanitized value.
	 */
	function customizer_library_sanitize_checkbox( $value ) {
		$value = (int) $value;

		if ( $value == 1 ) {
			return (int) 1;
		} else {
			return (int) 0;
		}
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_choices' ) ) :
	/**
	 * Sanitize a value from a list of allowed values.
	 *
	 * @since 1.0.0.
	 *
	 * @param  mixed $value   The value to sanitize.
	 * @param  mixed $setting The setting for which the sanitizing is occurring.
	 */
	function customizer_library_sanitize_choices( $value, $setting ) {
		if ( is_object( $setting ) ) {
			$setting = $setting->id;
		}

		$choices         = customizer_library_get_choices( $setting );
		$allowed_choices = array_keys( $choices );

		if ( ! in_array( $value, $allowed_choices ) ) {
			$value = customizer_library_get_default( $setting );
		}

		return $value;
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_file_url' ) ) :
	/**
	 * Sanitize the url of uploaded media.
	 *
	 * @since 1.0.0.
	 *
	 * @param  string $url The url to sanitize.
	 */
	function customizer_library_sanitize_file_url( $url ) {

		$output = '';

		$filetype = wp_check_filetype( $url );
		if ( $filetype['ext'] ) {
			$output = esc_url_raw( $url );
		}

		return $output;
	}
endif;

if ( ! function_exists( 'sanitize_hex_color' ) ) :
	/**
	 * Sanitizes a hex color.
	 *
	 * Returns either '', a 3 or 6 digit hex color (with #), or null.
	 * For sanitizing values without a #, see sanitize_hex_color_no_hash().
	 *
	 * @since 3.4.0
	 *
	 * @param string $color Color hex.
	 * @return string|null
	 */
	function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		return null;
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_range' ) ) :
	/**
	 * Sanitizes a range value
	 *
	 * @since 1.3.0
	 *
	 * @param number $value Options value.
	 * @return string|null
	 */
	function customizer_library_sanitize_range( $value ) {

		if ( is_numeric( $value ) ) {
			return $value;
		}

		return 0;
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_number' ) ) :
	/**
	 * Sanitizes a range value
	 *
	 * @since 1.3.0
	 *
	 * @param number $value Options value.
	 * @return string|null
	 */
	function customizer_library_sanitize_number( $value ) {

		if ( is_numeric( $value ) ) {
			return $value;
		}

		return 0;
	}
endif;
