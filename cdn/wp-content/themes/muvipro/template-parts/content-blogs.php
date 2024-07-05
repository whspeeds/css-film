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

?>

<article id="post-<?php the_ID(); ?>" class="item-infinite col-md-6 item<?php echo esc_html( $hasthumbnail ); ?>" <?php echo muvipro_itemtype_schema( 'CreativeWork' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="gmr-box-blog">
	<?php
	// Add thumnail.
	echo '<div class="content-thumbnail">';
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
		the_post_thumbnail( 'blog-large', array( 'itemprop' => 'image' ) );
		echo '</a>';
	endif; // endif has_post_thumbnail.
	if ( is_sticky() ) {
		echo '<div class="kbd-sticky">' . esc_html__( 'Sticky', 'muvipro' ) . '</div>';
	}
	echo '</div>';
	?>

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
	</header><!-- .entry-header -->
	<?php the_excerpt(); ?>

	</div><!-- .gmr-box-content -->
</article><!-- #post-## -->
