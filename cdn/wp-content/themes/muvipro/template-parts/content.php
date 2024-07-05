<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Sidebar layout options via customizer.
$sidebar_layout = get_theme_mod( 'gmr_blog_sidebar', 'sidebar' );

$hasthumbnail = '';
if ( has_post_thumbnail() ) {
	$hasthumbnail = ' has-post-thumbnail';
}

// layout masonry base sidebar options.
$classes = '';
if ( 'fullwidth' === $sidebar_layout ) {
	$classes = 'col-md-2 item';
} else {
	$classes = 'col-md-20 item';
}

?>

<article id="post-<?php the_ID(); ?>" class="item-infinite <?php echo esc_html( $classes ); ?><?php echo esc_html( $hasthumbnail ); ?>" <?php echo muvipro_itemtype_schema( 'Movie' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<div class="gmr-box-content gmr-box-archive text-center">
		<?php
		// Add thumnail.
		echo '<div class="content-thumbnail text-center">';
		if ( has_post_thumbnail() ) :
			echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
			the_title_attribute(
				array(
					'before' => __( 'Permalink to: ', 'muvipro' ),
					'after'  => '',
					'echo'   => true,
				)
			);
			echo '" rel="bookmark">';
			if ( 'fullwidth' === $sidebar_layout ) {
				the_post_thumbnail( 'large', array( 'itemprop' => 'image' ) );
			} else {
				the_post_thumbnail( 'medium', array( 'itemprop' => 'image' ) );
			}
			echo '</a>';
		endif; // endif has_post_thumbnail.
		$rating = get_post_meta( $post->ID, 'IDMUVICORE_tmdbRating', true );
		if ( ! empty( $rating ) ) {
			echo '<div class="gmr-rating-item"><span class="icon_star"></span> ' . esc_html( $rating ) . '</div>';
		}
		$duration = get_post_meta( $post->ID, 'IDMUVICORE_Runtime', true );
		if ( ! empty( $duration ) ) {
			echo '<div class="gmr-duration-item" property="duration"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm176.5 585.7l-28.6 39a7.99 7.99 0 0 1-11.2 1.7L483.3 569.8a7.92 7.92 0 0 1-3.3-6.5V288c0-4.4 3.6-8 8-8h48.1c4.4 0 8 3.6 8 8v247.5l142.6 103.1c3.6 2.5 4.4 7.5 1.8 11.1z" fill="currentColor"/></svg> ' . esc_html( $duration ) . esc_html__( ' min', 'muvipro' ) . '</div>';
		}
		if ( is_sticky() ) {
			echo '<div class="kbd-sticky">' . esc_html__( 'Sticky', 'muvipro' ) . '</div>';
		}
		if ( ! is_wp_error( get_the_term_list( $post->ID, 'muviquality' ) ) ) {
			$termlist = get_the_term_list( $post->ID, 'muviquality' );
			if ( ! empty( $termlist ) ) {
				echo '<div class="gmr-quality-item ' . strip_tags( strtolower( get_the_term_list( $post->ID, 'muviquality', '', ' ', '' ) ) ) . '">';
				echo get_the_term_list( $post->ID, 'muviquality', '', ', ', '' );
				echo '</div>';
			}
		}
		$episodes = get_post_meta( $post->ID, 'IDMUVICORE_Numbepisode', true );
		// Check if the custom field has a value.
		if ( ! empty( $episodes ) ) {
			echo '<div class="gmr-numbeps">' . __( 'Eps:', 'muvipro' ) . '<br />';
			echo '<span>' . $episodes . '</span></div>';
		}
		if ( 'tv' === get_post_type() ) {
			echo '<div class="gmr-posttype-item">';
			echo esc_html__( 'TV Show', 'muvipro' );
			echo '</div>';
		}

		echo '</div>';
		?>

		<div class="item-article">
			<header class="entry-header">
				<h2 class="entry-title" <?php echo muvipro_itemprop_schema( 'headline' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
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
					the_title();
					echo '</a>';
					?>
				</h2>
				<?php gmr_movie_on(); ?>
				<?php
				$release = get_post_meta( $post->ID, 'IDMUVICORE_Released', true );
				// Check if the custom field has a value.
				if ( ! empty( $release ) ) {
					if ( true === gmr_checkIsAValidDate( $release ) ) {
						$datetime = new DateTime( $release );
						echo '<span class="screen-reader-text"><time itemprop="dateCreated" datetime="' . esc_html( $datetime->format( 'c' ) ) . '">' . esc_html( $release ) . '</time></span>';
					}
				}
				if ( ! is_wp_error( get_the_term_list( $post->ID, 'muvidirector' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muvidirector' );
					if ( ! empty( $termlist ) ) {
						echo '<span class="screen-reader-text">';
						echo get_the_term_list( $post->ID, 'muvidirector', '<span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>' );
						echo '</span>';
					}
				}
				?>
				<?php
				$trailer = get_post_meta( $post->ID, 'IDMUVICORE_Trailer', true );
				// Check if the custom field has a value.
				if ( ! empty( $trailer ) ) {
					echo '<div class="gmr-popup-button">';
					echo '<a href="https://www.youtube.com/watch?v=' . esc_html( $trailer ) . '" class="button gmr-trailer-popup" title="';
					the_title_attribute(
						array(
							'before' => __( 'Trailer for ', 'muvipro' ),
							'after'  => '',
							'echo'   => true,
						)
					);
					echo '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path d="M0 2v12h16V2H0zm3 11H1v-2h2v2zm0-4H1V7h2v2zm0-4H1V3h2v2zm9 8H4V3h8v10zm3 0h-2v-2h2v2zm0-4h-2V7h2v2zm0-4h-2V3h2v2zM6 5v6l4-3z" fill="currentColor"/></svg><span class="text-trailer">' . esc_html__( 'Trailer', 'muvipro' ) . '</span></a>';
					echo '</div>';
				}
				?>
				<div class="gmr-watch-movie">
					<?php
					echo '<a href="' . esc_url( get_permalink() ) . '" class="button gmr-watch-button" itemprop="url" title="';
					the_title_attribute(
						array(
							'before' => __( 'Permalink to: ', 'muvipro' ),
							'after'  => '',
							'echo'   => true,
						)
					);
					echo '" rel="bookmark">';
					echo esc_html__( 'Watch', 'muvipro' );
					echo '</a>';
					?>
				</div>
			</header><!-- .entry-header -->
		</div><!-- .item-article -->

	</div><!-- .gmr-box-content -->

</article><!-- #post-## -->
