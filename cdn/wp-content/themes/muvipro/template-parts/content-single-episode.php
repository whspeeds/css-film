<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disable thumbnail options via customizer.
$thumbnail = get_theme_mod( 'gmr_active-singlethumb', 0 );

$hasthumbnail = '';
if ( has_post_thumbnail() ) {
	$hasthumbnail = ' has-post-thumbnail';
}

// layout masonry base sidebar options.
$classes = '';
if ( 0 === $thumbnail ) {
	$classes = 'hentry single-thumb';
} else {
	$classes = 'hentry no-single-thumb';
}
$downloadrea = get_theme_mod( 'gmr_downloadarea', 'after' );
?>

<article id="post-<?php the_ID(); ?>" class="<?php echo esc_html( $classes ); ?><?php echo esc_html( $hasthumbnail ); ?>" <?php echo muvipro_itemtype_schema( 'Movie' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="gmr-box-content gmr-single">

		<?php
		/**
		 * Called player.php for custom movie player.
		 * Display content if have no embed code via player metaboxes
		 */

		do_action( 'muvipro_share_action' ); // Social share.

		$player_style = get_theme_mod( 'gmr_player_style', 'ajax' );
		if ( 'subpage' === $player_style ) {
			get_template_part( 'template-parts/player', '2' );
		} else {
			get_template_part( 'template-parts/player' );
		}

		echo '<div class="clearfix">';
			// List Episode.
			do_action( 'gmr_tvshow_serie_list' );
		echo '</div>';
		
		if ( 'player' === $downloadrea ) {
			do_action( 'gmr_video_download' );
		}
		
		do_action( 'idmuvi_core_before_title' ); // banner before title

		echo '<div class="gmr-movie-data clearfix">';
		if ( 0 === $thumbnail ) {
			if ( has_post_thumbnail() ) {
				echo '<figure class="pull-left">';
					the_post_thumbnail( 'thumbnail', array( 'itemprop' => 'image' ) );
					if ( $caption = get_post( get_post_thumbnail_id() )->post_excerpt ) :
						echo '<figcaption class="wp-caption-text hidden">' . esc_html( $caption ) . '</figcaption>';
					endif;
				echo '</figure>';
			}
		}

		// Check if the custom field has a value.
		echo '<div class="gmr-movie-data-top">';
		the_title( '<h1 class="entry-title" ' . muvipro_itemprop_schema( 'name' ) . '>', '</h1>' );

		// Rating.
		$rating = get_post_meta( $post->ID, 'IDMUVICORE_tmdbRating', true );
		$user   = get_post_meta( $post->ID, 'IDMUVICORE_tmdbVotes', true );
		// Check if the custom field has a value.
		if ( ! empty( $rating ) ) {
			$display = number_format_i18n( $rating, 1 );

			echo '<div class="clearfix gmr-rating" itemscope="itemscope" itemprop="aggregateRating" itemtype="//schema.org/AggregateRating">';
			echo '<meta itemprop="worstRating" content="1">';
			echo '<meta itemprop="bestRating" content="10">';
			echo '<div class="gmr-rating-content">';
			echo '<div class="gmr-rating-bar">';
			echo '<span style="width:' . ( esc_html( $display ) * 10 ) . '%"></span>';
			echo '</div>';
			if ( ! empty( $user ) ) {
				echo '<div class="gmr-meta-rating">';
				echo '<span itemprop="ratingCount">' . esc_html( $user ) . '</span>';
				echo esc_html__( ' votes, ', 'muvipro' );
				echo esc_html__( ' average ', 'muvipro' ) . '<span itemprop="ratingValue">' . esc_html( $display ) . '</span> ' . esc_html__( 'out of 10', 'muvipro' );
				echo '</div>';
			}
			echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="clearfix gmr-rating">';
			echo '<div class="gmr-rating-content">';
			echo '<div class="gmr-rating-bar">';
			echo '<span style="width:0%"></span>';
			echo '</div>';
			echo '<div class="gmr-meta-rating">';
			echo esc_html__( 'No votes', 'muvipro' );
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}


		echo '</div>';
		echo '</div>';

		?>
		<div class="entry-content entry-content-single" <?php echo muvipro_itemprop_schema( 'description' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
				// Content.
				the_content();
			?>
		</div><!-- .entry-content -->
		
		<?php
			if ( 'after' === $downloadrea || 'popup' === $downloadrea ) {
				do_action( 'gmr_video_download' );
			}
		?>
		
		<?php do_action( 'idmuvi_core_add_banner_after_content' ); ?>

	</div><!-- .gmr-box-content -->
</article><!-- #post-## -->
