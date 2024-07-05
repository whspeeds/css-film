<?php
/**
 * Importer plugin filter.
 *
 * @link https://wordpress.org/plugins/one-click-demo-import/
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'muvipro_ocdi_import_files' ) ) :
	/**
	 * Set one click import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 *
	 * @return array
	 */
	function muvipro_ocdi_import_files() {
		return array(
			array(
				'import_file_name'             => 'Muvipro Demo Import',
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-data/demo-content.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-data/widgets.json',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-data/customizer.dat',
				'import_notice'                => __( 'Import demo from http://demo.idtheme.com/muvipro/.', 'muvipro' ),
			),
		);
	}
endif;
add_filter( 'pt-ocdi/import_files', 'muvipro_ocdi_import_files' );

if ( ! function_exists( 'muvipro_ocdi_after_import' ) ) :
	/**
	 * Set action after import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @param Array $selected_import Import selected.
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 *
	 * @return void
	 */
	function muvipro_ocdi_after_import( $selected_import ) {

		// Menus to Import and assign - you can remove or add as many as you want.
		$top_menu    = get_term_by( 'name', 'Top menus', 'nav_menu' );
		$second_menu = get_term_by( 'name', 'Second menus', 'nav_menu' );

		set_theme_mod(
			'nav_menu_locations',
			array(
				'primary'   => $top_menu->term_id,
				'secondary' => $second_menu->term_id,
			)
		);

		// update option post per page.
		update_option( 'posts_per_page', 15 );

	}
endif;
add_action( 'pt-ocdi/after_import', 'muvipro_ocdi_after_import' );

if ( ! function_exists( 'muvipro_change_time_of_single_ajax_call' ) ) :
	/**
	 * Change ajax call timeout
	 *
	 * @link https://github.com/awesomemotive/one-click-demo-import/blob/master/docs/import-problems.md.
	 */
	function muvipro_change_time_of_single_ajax_call() {
		return 60;
	}
endif;
add_action( 'pt-ocdi/time_for_one_ajax_call', 'muvipro_change_time_of_single_ajax_call' );

// disable generation of smaller images (thumbnails) during the content import.
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

// disable the branding notice.
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
