<?php
/**
 * Ajax Search
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.6
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'muvipro_core_search_movie' ) ) {
	/**
	 * Ajax search movie
	 *
	 * @since 1.0.8
	 * @return void
	 */
	function muvipro_core_search_movie() {
		$movie          = array();
		$search_keyword = esc_attr( wp_unslash( $_REQUEST['query'] ) );

		$args = array(
			's'                   => $search_keyword,
			'post_type'           => array( 'post', 'tv', 'episode' ),
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => 'title',
			'order'               => 'asc',
			'posts_per_page'      => 5,
		);

		$search_query = new WP_Query( $args );
		if ( $search_query->have_posts() ) {
			while ( $search_query->have_posts() ) {
				$search_query->the_post();
				if ( has_post_thumbnail() ) :
					$thumbs = wp_get_attachment_image_src( get_post_thumbnail_id() );
					$image = $thumbs[0];
				else :
					$image = '';
				endif;
				$movie[] = array(
					'id'    => get_the_ID(),
					'value' => wp_strip_all_tags( get_the_title() ),
					'thumb' => '<img src="' . $image . '" />',
					'url'   => esc_url( get_permalink() ),
				);
			}
		} else {
			$movie[] = array(
				'id'    => -1,
				'value' => __( 'No results', 'muvipro_core' ),
				'thumb' => '',
				'url'   => '',
			);
		}

		wp_reset_postdata();

		$movie = array(
			'suggestions' => $movie,
		);

		echo wp_json_encode( $movie );
		die();
	}
}
add_action( 'wp_ajax_muvipro_core_ajax_search_movie', 'muvipro_core_search_movie' );
add_action( 'wp_ajax_nopriv_muvipro_core_ajax_search_movie', 'muvipro_core_search_movie' );
