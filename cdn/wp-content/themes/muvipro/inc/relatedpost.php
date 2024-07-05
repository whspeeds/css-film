<?php
/**
 * Related Post Features
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'muvipro_related_post' ) ) {
	/**
	 * Adding the related post to the end of your single post
	 *
	 * @since 1.0.0
	 * @param string $content Display content.
	 * @return string
	 */
	function muvipro_related_post( $content = null ) {
		$relatedposts = get_theme_mod( 'gmr_active-relpost', 0 );

		if ( 0 === $relatedposts ) {
			global $post;
			$numberposts = get_theme_mod( 'gmr_relpost_number', '5' );
			$taxonomy    = get_theme_mod( 'gmr_relpost_taxonomy', 'gmr-category' );

			if ( 'gmr-tags' === $taxonomy ) {
				$tags = wp_get_post_tags( get_the_ID() );
				if ( $tags ) {
					$tag_ids = array();

					foreach ( $tags as $individual_tag ) {
						$tag_ids[] = $individual_tag->term_id;

						$args = array(
							'post_type'              => array( 'post', 'tv' ),
							'tag__in'                => $tag_ids,
							'post__not_in'           => array( get_the_ID() ),
							'posts_per_page'         => $numberposts,
							'ignore_sticky_posts'    => 1,
							// make it fast withour update term cache and cache results.
							// https://thomasgriffin.io/optimize-wordpress-queries/.
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false,
							'cache_results'          => false,
							'fields'                 => 'ids',
						);
					}
				}
			} elseif ( 'gmr-year' === $taxonomy ) {
				$years = wp_get_post_terms( get_the_ID(), 'muviyear' );
				if ( $years ) {
					$years_id = array();

					foreach ( $years as $individual_tag ) {
						$years_id[] = $individual_tag->term_id;

						$args = array(
							'post_type'              => array( 'post', 'tv' ),
							'tax_query'              => array(
								array(
									'taxonomy' => 'muviyear',
									'field'    => 'id',
									'terms'    => $years_id,
								),
							),
							'post__not_in'           => array( get_the_ID() ),
							'posts_per_page'         => $numberposts,
							'ignore_sticky_posts'    => 1,
							// make it fast withour update term cache and cache results
							// https://thomasgriffin.io/optimize-wordpress-queries/.
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false,
							'cache_results'          => false,
						);
					}
				}
			} else {
				$categories = get_the_category( get_the_ID() );
				if ( $categories ) {
					$category_ids = array();
					foreach ( $categories as $individual_category ) {
						$category_ids[] = $individual_category->term_id;

						$args = array(
							'post_type'              => array( 'post', 'tv' ),
							'category__in'           => $category_ids,
							'post__not_in'           => array( get_the_ID() ),
							'posts_per_page'         => $numberposts,
							'ignore_sticky_posts'    => 1,
							// make it fast withour update term cache and cache results
							// https://thomasgriffin.io/optimize-wordpress-queries/.
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false,
							'cache_results'          => false,
						);
					}
				}
			}

			if ( ! isset( $args ) ) {
				$args = '';
			}
			$idmuvi_query = new WP_Query( $args );

			$content = '';
			$i       = 1;
			if ( $idmuvi_query->have_posts() ) {

				$content .= '<div class="gmr-grid idmuvi-core">';

				$content .= '<h3 class="widget-title gmr-related-title">' . __( 'Related Movies', 'muvipro' ) . '</h3>';

				$content .= '<div class="row grid-container">';

				while ( $idmuvi_query->have_posts() ) :
					$idmuvi_query->the_post();

					$content .= '<article class="item col-md-20" itemscope="itemscope" itemtype="http://schema.org/Movie">';
					$content .= '<div class="gmr-box-content gmr-box-archive text-center">';
					$content .= '<div class="content-thumbnail text-center">';

					if ( has_post_thumbnail() ) {
						$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute(
							array(
								'before' => __( 'Permalink to: ', 'muvipro' ),
								'after'  => '',
								'echo'   => false,
							)
						) . '" rel="bookmark">';
						$content .= get_the_post_thumbnail( get_the_ID(), 'medium', array( 'itemprop' => 'image' ) );
						$content .= '</a>';

					}

					$rating = get_post_meta( get_the_ID(), 'IDMUVICORE_tmdbRating', true );
					if ( ! empty( $rating ) ) {
						$content .= '<div class="gmr-rating-item"><span class="icon_star"></span> ' . $rating . '</div>';
					}
					$duration = get_post_meta( get_the_ID(), 'IDMUVICORE_Runtime', true );
					if ( ! empty( $duration ) ) {
						$content .= '<div class="gmr-duration-item" property="duration"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm176.5 585.7l-28.6 39a7.99 7.99 0 0 1-11.2 1.7L483.3 569.8a7.92 7.92 0 0 1-3.3-6.5V288c0-4.4 3.6-8 8-8h48.1c4.4 0 8 3.6 8 8v247.5l142.6 103.1c3.6 2.5 4.4 7.5 1.8 11.1z" fill="currentColor"/></svg> ' . $duration . __( ' min', 'muvipro' ) . '</div>';
					}

					if ( ! is_wp_error( get_the_term_list( get_the_ID(), 'muviquality' ) ) ) {
						$muviqu = get_the_term_list( get_the_ID(), 'muviquality' );
						if ( ! empty( $muviqu ) ) {
							$content .= '<div class="gmr-quality-item">';
							$content .= get_the_term_list( get_the_ID(), 'muviquality', '', ', ', '' );
							$content .= '</div>';
						}
					}
					$episodes = get_post_meta( get_the_ID(), 'IDMUVICORE_Numbepisode', true );
					// Check if the custom field has a value.
					if ( ! empty( $episodes ) ) {
						$content .= '<div class="gmr-numbeps">' . __( 'Eps:', 'muvipro' ) . '<br />';
						$content .= '<span>' . $episodes . '</span></div>';
					}

					if ( 'tv' === get_post_type() ) {
						$content .= '<div class="gmr-posttype-item">';
						$content .= __( 'TV Show', 'muvipro' );
						$content .= '</div>';
					}

					$content .= '</div>';

					$content .= '<div class="item-article">';
					$content .= '<h2 class="entry-title" itemprop="headline">';
					$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute(
						array(
							'before' => __( 'Permalink to: ', 'muvipro' ),
							'after'  => '',
							'echo'   => false,
						)
					) . '" rel="bookmark">' . get_the_title() . '</a>';
					$content .= '</h2>';
					$content .= '<div class="gmr-movie-on">';

					$categories_list = get_the_category_list( esc_html__( ', ', 'muvipro' ) );
					if ( $categories_list ) :
						$content .= $categories_list;
					endif;

					if ( ! is_wp_error( get_the_term_list( get_the_ID(), 'muvicountry' ) ) ) {
						$muvico = get_the_term_list( get_the_ID(), 'muvicountry' );
						if ( ! empty( $muvico ) ) {
							$content .= ', ';
							$content .= get_the_term_list( get_the_ID(), 'muvicountry', '<span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>' );
						}
					}
					$content .= '</div>';

					$release = get_post_meta( get_the_ID(), 'IDMUVICORE_Released', true );
					// Check if the custom field has a value.
					if ( ! empty( $release ) ) {
						if ( gmr_checkIsAValidDate( $release ) == true ) {
							$datetime = new DateTime( $release );
							$content .= '<span class="screen-reader-text"><time itemprop="dateCreated" datetime="' . $datetime->format( 'c' ) . '">' . $release . '</time></span>';
						}
					}

					if ( ! is_wp_error( get_the_term_list( get_the_ID(), 'muvidirector' ) ) ) {
						$muvidir = get_the_term_list( get_the_ID(), 'muvidirector' );
						if ( ! empty( $muvidir ) ) {
							$content .= '<span class="screen-reader-text">';
							$content .= get_the_term_list( get_the_ID(), 'muvidirector', '<span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>' );
							$content .= '</span>';
						}
					}

					$trailer = get_post_meta( get_the_ID(), 'IDMUVICORE_Trailer', true );
					// Check if the custom field has a value.
					if ( ! empty( $trailer ) ) {
						$content .= '<div class="gmr-popup-button">';
						$content .= '<a href="https://www.youtube.com/watch?v=' . $trailer . '" class="button gmr-trailer-popup" title="' . the_title_attribute(
							array(
								'before' => __( 'Trailer for ', 'muvipro' ),
								'after'  => '',
								'echo'   => false,
							)
						) . '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path d="M0 2v12h16V2H0zm3 11H1v-2h2v2zm0-4H1V7h2v2zm0-4H1V3h2v2zm9 8H4V3h8v10zm3 0h-2v-2h2v2zm0-4h-2V7h2v2zm0-4h-2V3h2v2zM6 5v6l4-3z" fill="currentColor"/></svg><span class="text-trailer">' . __( 'Trailer', 'muvipro' ) . '</span></a>';
						$content .= '</div>';
					}

					$content .= '<div class="gmr-watch-movie">';
					$content .= '<a href="' . get_permalink() . '" class="button gmr-watch-button" itemprop="url" title="' . the_title_attribute(
						array(
							'before' => __( 'Permalink to: ', 'muvipro' ),
							'after'  => '',
							'echo'   => false,
						)
					) . '" rel="bookmark">' . __( 'Watch', 'muvipro' ) . '</a>';
					$content .= '</div>';
					$content .= '</div>';

					$content .= '</div><!-- .gmr-box-content -->';

					$content .= '</article>';
					if ( $i%5 == 0 ) :
						$content .= '<div class="clearfix"></div>';
					endif;

					$i++;
				endwhile;
				wp_reset_postdata();
				$content .= '</div>';

				$content .= '</div>';
			} // if have posts
		}
		return $content;
	}
}

if ( ! function_exists( 'muvipro_add_related_post' ) ) :
	/**
	 * Displaying related Posts.
	 */
	function muvipro_add_related_post() {
		if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
			$related  = '<div class="salespro-core gmr-box-content">';
			$related .= do_shortcode( '[jetpack-related-posts]' );
			$related .= '</div>';
		} else {
			$related = muvipro_related_post();
		}
		echo $related; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif; // endif muvipro_add_related_post.
add_action( 'muvipro_add_related_post', 'muvipro_add_related_post' );
