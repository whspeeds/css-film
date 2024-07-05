<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gmr_checkIsAValidDate' ) ) :
	/**
	 * Check if date true or false
	 *
	 * @since 1.0.0
	 *
	 * @param string $mydatestring Date String.
	 * @return bool
	 */
	function gmr_checkIsAValidDate( $mydatestring ) {
		return (bool) strtotime( $mydatestring );
	}
endif;

if ( ! function_exists( 'gmr_body_classes' ) ) :
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function gmr_body_classes( $classes ) {
		$classes[] = 'gmr-theme idtheme kentooz';

		$sticky_menu = get_theme_mod( 'gmr_sticky_menu', 'nosticky' );

		$layout = get_theme_mod( 'gmr_layout', 'full-layout' );

		$btnstyle = get_theme_mod( 'gmr_button_style', 'default' );

		if ( 'sticky' === $sticky_menu ) {
			$classes[] = 'gmr-sticky';
		} else {
			$classes[] = 'gmr-no-sticky';
		}

		if ( 'box-layout' === $layout ) {
			$classes[] = 'gmr-box-layout';
		} else {
			$classes[] = 'gmr-fullwidth-layout';
		}

		$layout = get_theme_mod( 'gmr_active-sticky-sidebar', 0 );

		if ( 0 !== $layout ) {
			$classes[] = 'gmr-disable-sticky';
		}

		if ( 'lk' === $btnstyle ) {
			$classes[] = 'gmr-button-lk';
		}

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
endif; // endif gmr_body_classes.
add_filter( 'body_class', 'gmr_body_classes' );

if ( ! function_exists( 'gmr_pingback_header' ) ) :
	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
		}
	}
endif;
add_action( 'wp_head', 'gmr_pingback_header' );

if ( ! function_exists( 'gmr_add_img_title' ) ) :
	/**
	 * Add a image title tag.
	 *
	 * @since 1.0.0
	 * @param array $attr attribute image.
	 * @param array $attachment returning attacment.
	 * @return array
	 */
	function gmr_add_img_title( $attr, $attachment = null ) {
		$attr['title'] = trim( wp_strip_all_tags( $attachment->post_title ) );
		return $attr;
	}
endif;
add_filter( 'wp_get_attachment_image_attributes', 'gmr_add_img_title', 10, 2 );

if ( ! function_exists( 'gmr_add_title_alt_gravatar' ) ) :
	/**
	 * Add a gravatar title and alt tag.
	 *
	 * @since 1.0.0
	 * @param string $text Text attribute gravatar.
	 * @return string
	 */
	function gmr_add_title_alt_gravatar( $text ) {
		$text = str_replace( 'alt=\'\'', 'alt=\'' . __( 'Gravatar Image', 'muvipro' ) . '\' title=\'' . __( 'Gravatar', 'muvipro' ) . '\'', $text );
		return $text;
	}
endif;
add_filter( 'get_avatar', 'gmr_add_title_alt_gravatar' );

if ( ! function_exists( 'gmr_thumbnail_upscale' ) ) :
	/**
	 * Thumbnail upscale
	 *
	 * @since 1.0.0
	 *
	 * @Source http://wordpress.stackexchange.com/questions/50649/how-to-scale-up-featured-post-thumbnail
	 * @param array $default for image sizes.
	 * @param array $orig_w for width orginal.
	 * @param array $orig_h for height sizes image original.
	 * @param array $new_w new width image sizes.
	 * @param array $new_h new height image sizes.
	 * @param bool  $crop croping for image sizes.
	 * @return array
	 */
	function gmr_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ) {
		if ( ! $crop ) {
			return null; // let the WordPress default function handle this.
		}
		$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

		$crop_w = round( $new_w / $size_ratio );
		$crop_h = round( $new_h / $size_ratio );

		$s_x = floor( ( $orig_w - $crop_w ) / 2 );
		$s_y = floor( ( $orig_h - $crop_h ) / 2 );

		if ( is_array( $crop ) ) {

			// Handles left, right and center (no change).
			if ( 'left' === $crop[0] ) {
				$s_x = 0;
			} elseif ( 'right' === $crop[0] ) {
				$s_x = $orig_w - $crop_w;
			}

			// Handles top, bottom and center (no change).
			if ( 'top' === $crop[1] ) {
				$s_y = 0;
			} elseif ( 'bottom' === $crop[1] ) {
				$s_y = $orig_h - $crop_h;
			}
		}
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}
endif; // endif gmr_thumbnail_upscale.
add_filter( 'image_resize_dimensions', 'gmr_thumbnail_upscale', 10, 6 );

if ( ! function_exists( 'muvipro_itemtype_schema' ) ) :
	/**
	 * Figure out which schema tags to apply to the <article> element
	 * The function determines the itemtype: muvipro_itemtype_schema( 'CreativeWork' )
	 *
	 * @since 1.0.0
	 * @param string $type Text attributes for scheme.
	 * @return string
	 */
	function muvipro_itemtype_schema( $type = 'Movie' ) {
		$schema = 'https://schema.org/';

		// Get the itemtype.
		$itemtype = apply_filters( 'muvipro_article_itemtype', $type );

		// Print the results.
		$scope = 'itemscope="itemscope" itemtype="' . $schema . $itemtype . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'muvipro_itemprop_schema' ) ) :
	/**
	 * Figure out which schema tags itemprop=""
	 * The function determines the itemprop: bloggingpro_itemprop_schema( 'headline' )
	 *
	 * @since 1.0.0
	 * @param string $type Text attributes for scheme.
	 * @return string
	 */
	function muvipro_itemprop_schema( $type = 'headline' ) {
		// Get the itemprop.
		$itemprop = apply_filters( 'muvipro_itemprop_filter', $type );

		// Print the results.
		$scope = 'itemprop="' . $itemprop . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'muvipro_the_archive_title' ) ) :
	/**
	 * Change category text with genre text.
	 *
	 * @param string $title Change title category with genre.
	 * @since 1.0.0
	 * @return string
	 */
	function muvipro_the_archive_title( $title ) {
		if ( is_category() ) {
			$title = __( 'Genre: ', 'muvipro' ) . single_cat_title( '', false );
		}
		return $title;
	}
endif;
add_filter( 'get_the_archive_title', 'muvipro_the_archive_title' );

if ( ! function_exists( 'muvipro_remove_p_archive_description' ) ) :
	/**
	 * Remove auto p in archive description
	 *
	 * @param string $description remove P in archive description.
	 * @since 1.0.0
	 * @return string
	 */
	function muvipro_remove_p_archive_description( $description ) {
		$remove      = array( '<p>', '</p>' );
		$description = str_replace( $remove, '', $description );
		return $description;
	}
endif;
add_filter( 'get_the_archive_description', 'muvipro_remove_p_archive_description' );

if ( ! function_exists( 'muvipro_template_search_blogs' ) ) :
	/**
	 * Search blog post type template redirect
	 *
	 * @param array $template Template locate.
	 * @since 1.0.0
	 * @return string
	 */
	function muvipro_template_search_blogs( $template ) {
		global $wp_query;
		$post_type = get_query_var( 'post_type' );
		if ( $wp_query->is_search && 'blogs' === $post_type ) {
			return locate_template( 'search-blogs.php' );
		}
		return $template;
	}
endif;
add_filter( 'template_include', 'muvipro_template_search_blogs' );

if ( ! function_exists( 'muvipro_player_content' ) ) :
	/**
	 * Main ajax action function for player tab
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function muvipro_player_content() {
		$tab      = $_POST['tab']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$post_id  = $_POST['post_id']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$player1  = get_post_meta( $post_id, 'IDMUVICORE_Player1', true );
		$player2  = get_post_meta( $post_id, 'IDMUVICORE_Player2', true );
		$player3  = get_post_meta( $post_id, 'IDMUVICORE_Player3', true );
		$player4  = get_post_meta( $post_id, 'IDMUVICORE_Player4', true );
		$player5  = get_post_meta( $post_id, 'IDMUVICORE_Player5', true );
		$player6  = get_post_meta( $post_id, 'IDMUVICORE_Player6', true );
		$player7  = get_post_meta( $post_id, 'IDMUVICORE_Player7', true );
		$player8  = get_post_meta( $post_id, 'IDMUVICORE_Player8', true );
		$player9  = get_post_meta( $post_id, 'IDMUVICORE_Player9', true );
		$player10 = get_post_meta( $post_id, 'IDMUVICORE_Player10', true );
		$player11 = get_post_meta( $post_id, 'IDMUVICORE_Player11', true );
		$player12 = get_post_meta( $post_id, 'IDMUVICORE_Player12', true );
		$player13 = get_post_meta( $post_id, 'IDMUVICORE_Player13', true );
		$player14 = get_post_meta( $post_id, 'IDMUVICORE_Player14', true );
		$player15 = get_post_meta( $post_id, 'IDMUVICORE_Player15', true );

		switch ( $tab ) {
			case 'p1':
				if ( ! empty( $player1 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player1 ); ?></div>
					<?php
				endif;
				break;
			case 'p2':
				if ( ! empty( $player2 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player2 ); ?></div>
					<?php
				endif;
				break;
			case 'p3':
				if ( ! empty( $player3 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player3 ); ?></div>
					<?php
				endif;
				break;
			case 'p4':
				if ( ! empty( $player4 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player4 ); ?></div>
					<?php
				endif;
				break;
			case 'p5':
				if ( ! empty( $player5 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player5 ); ?></div>
					<?php
				endif;
				break;
			case 'p6':
				if ( ! empty( $player6 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player6 ); ?></div>
					<?php
				endif;
				break;
			case 'p7':
				if ( ! empty( $player7 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player7 ); ?></div>
					<?php
				endif;
				break;
			case 'p8':
				if ( ! empty( $player8 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player8 ); ?></div>
					<?php
				endif;
				break;
			case 'p9':
				if ( ! empty( $player9 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player9 ); ?></div>
					<?php
				endif;
				break;
			case 'p10':
				if ( ! empty( $player10 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player10 ); ?></div>
					<?php
				endif;
				break;
			case 'p11':
				if ( ! empty( $player11 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player11 ); ?></div>
					<?php
				endif;
				break;
			case 'p12':
				if ( ! empty( $player12 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player12 ); ?></div>
					<?php
				endif;
				break;
			case 'p13':
				if ( ! empty( $player13 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player13 ); ?></div>
					<?php
				endif;
				break;
			case 'p14':
				if ( ! empty( $player14 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player14 ); ?></div>
					<?php
				endif;
				break;
			case 'p15':
				if ( ! empty( $player15 ) ) :
					?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player15 ); ?></div>
					<?php
				endif;
				break;
		}
		die(); // required to return a proper result.
	}
endif;
// ajax functions.
add_action( 'wp_ajax_muvipro_player_content', 'muvipro_player_content' );
add_action( 'wp_ajax_nopriv_muvipro_player_content', 'muvipro_player_content' );


if ( ! function_exists( '_gmr_ajax_add_hierarchical_term' ) ) :
	/**
	 * Important
	 * Semenjak WorPpress 4.8 ketika memasukkan category yang sama maka tidak otomatis check pada metabox category
	 * Nah kita kembalikan  ke versi sebelum nya menggunakan sebuah filter wp_ajax_add-category
	 * Sehingga fungsi tersebut bekerja kembali
	 * Note: Hapus filter ini jika fungsi kembali bekerja pada WorPpress terbaru yah.
	 *
	 * @link https://core.trac.wordpress.org/ticket/16567
	 */
	function _gmr_ajax_add_hierarchical_term() {
		$action   = $_POST['action'];
		$taxonomy = get_taxonomy( substr( $action, 4 ) );
		check_ajax_referer( $action, '_ajax_nonce-add-' . $taxonomy->name );
		if ( ! current_user_can( $taxonomy->cap->edit_terms ) ) {
			wp_die( -1 );
		}

		$names  = explode( ',', $_POST[ 'new' . $taxonomy->name ] );
		$parent = isset( $_POST[ 'new' . $taxonomy->name . '_parent' ] ) ? (int) $_POST[ 'new' . $taxonomy->name . '_parent' ] : 0;

		if ( 0 > $parent ) {
			$parent = 0;
		}

		if ( 'category' === $taxonomy->name ) {
			$post_category = isset( $_POST['post_category'] ) ? (array) $_POST['post_category'] : array();
		} else {
			$post_category = ( isset($_POST['tax_input']) && isset( $_POST['tax_input'][ $taxonomy->name ] ) ) ? (array) $_POST['tax_input'][ $taxonomy->name ] : array();
		}
		$checked_categories = array_map( 'absint', (array) $post_category );
		$popular_ids        = wp_popular_terms_checklist( $taxonomy->name, 0, 10, false );

		foreach ( $names as $cat_name ) {
			$cat_name          = trim( $cat_name );
			$category_nicename = sanitize_title( $cat_name );
			if ( '' === $category_nicename ) {
				continue;
			}

			if ( ! $cat_id = term_exists( $cat_name, $taxonomy->name, $parent ) ) {
				$cat_id = wp_insert_term( $cat_name, $taxonomy->name, array( 'parent' => $parent ) );
			}

			if ( ! $cat_id || is_wp_error( $cat_id ) ) {
				continue;
			} else {
				$cat_id = $cat_id['term_id'];
			}

			$checked_categories[] = $cat_id;
			if ( $parent ) {
				continue;
			}
			ob_start();

			wp_terms_checklist(
				0,
				array(
					'taxonomy'             => $taxonomy->name,
					'descendants_and_self' => $cat_id,
					'selected_cats'        => $checked_categories,
					'popular_cats'         => $popular_ids,
				)
			);

			$data = ob_get_clean();

			$add = array(
				'what'     => $taxonomy->name,
				'id'       => $cat_id,
				'data'     => str_replace( array( "\n", "\t" ), '', $data ),
				'position' => -1,
			);
		}

		if ( $parent ) { // Foncy - replace the parent and all its children.
			$parent  = get_term( $parent, $taxonomy->name );
			$term_id = $parent->term_id;

			while ( $parent->parent ) { // get the top parent.
				$parent = get_term( $parent->parent, $taxonomy->name );
				if ( is_wp_error( $parent ) ) {
					break;
				}
				$term_id = $parent->term_id;
			}

			ob_start();

			wp_terms_checklist(
				0,
				array(
					'taxonomy'             => $taxonomy->name,
					'descendants_and_self' => $term_id,
					'selected_cats'        => $checked_categories,
					'popular_cats'         => $popular_ids,
				)
			);

			$data = ob_get_clean();

			$add = array(
				'what'     => $taxonomy->name,
				'id'       => $term_id,
				'data'     => str_replace( array( "\n", "\t" ), '', $data ),
				'position' => -1,
			);
		}

		ob_start();

		wp_dropdown_categories(
			array(
				'taxonomy'         => $taxonomy->name,
				'hide_empty'       => 0,
				'name'             => 'new' . $taxonomy->name . '_parent',
				'orderby'          => 'name',
				'hierarchical'     => 1,
				'show_option_none' => '&mdash; ' . $taxonomy->labels->parent_item . ' &mdash;',
			)
		);

		$sup = ob_get_clean();

		$add['supplemental'] = array( 'newcat_parent' => $sup );

		$x = new WP_Ajax_Response( $add );
		$x->send();
	}
endif;

if ( is_admin() ) {
	// add the filter.
	add_filter( 'wp_ajax_add-category', '_gmr_ajax_add_hierarchical_term' );
	// remove the filter.
	remove_filter( 'wp_ajax_add-category', '_wp_ajax_add_hierarchical_term' );
}
