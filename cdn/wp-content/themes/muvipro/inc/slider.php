<?php
/**
 * Custom homepage category content.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'muvipro_display_carousel' ) ) :
	/**
	 * This function for display slider in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function muvipro_display_carousel() {
		global $post;
		$post_num = get_theme_mod( 'gmr_slider_number', '8' );
		$cat      = get_theme_mod( 'gmr_category-slider', 0 );

		$args = array(
			'post_type'              => array( 'post', 'tv' ),
			'cat'                    => $cat,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'posts_per_page'         => $post_num,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			// make it fast withour update term cache and cache results.
			// https://thomasgriffin.io/optimize-wordpress-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'cache_results'          => false,
			'no_found_rows'          => true,
			'fields'                 => 'ids',
		);

		$recent = get_posts( $args );
		echo '<div class="clearfix gmr-element-carousel">';
		echo '<div class="gmr-owl-wrap">';
		echo '<div class="gmr-owl-carousel owl-carousel owl-theme">';
		foreach ( $recent as $post ) :
			setup_postdata( $post );
			$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
			if ( ! empty( $featured_image_url ) ) {
				?>
				<div class="gmr-slider-content">
					<div class="other-content-thumbnail">
						<?php
						echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
						the_title_attribute(
							array(
								'before' => __( 'Permalink to: ', 'muvipro' ),
								'after'  => '',
								'echo'   => true,
							)
						);
						echo '" rel="bookmark">';
						if ( has_post_thumbnail() ) :
							$imgthumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
							echo '<img class="tns-lazy-img" src="data:image/gif;base64,R0lGODlhAQABAPAAAMzMzAAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="' . esc_url( $imgthumb[0] ) . '" height="' . esc_html( $imgthumb[2] ) . '" width="' . esc_html( $imgthumb[1] ) . '" itemprop="image" alt="';
							the_title_attribute(
								array(
									'before' => '',
									'after'  => '',
									'echo'   => true,
								)
							);
							echo '">';
						endif;
						echo '</a>';
						?>
						<div class="gmr-slide-title">
							<a href="<?php the_permalink(); ?>" class="gmr-slide-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</div>
						<?php
						if ( ! is_wp_error( get_the_term_list( get_the_ID(), 'muviquality' ) ) ) {
							$termlist = get_the_term_list( get_the_ID(), 'muviquality' );
							if ( ! empty( $termlist ) ) {
								echo '<div class="gmr-quality-item">';
								echo get_the_term_list( get_the_ID(), 'muviquality', '', ', ', '' );
								echo '</div>';
							}
						}
						?>
					</div>
				</div>
				<?php
			}
		endforeach;
		wp_reset_postdata();
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
endif; // endif muvipro_display_carousel.
add_action( 'muvipro_display_carousel', 'muvipro_display_carousel', 50 );
