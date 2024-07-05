<?php
/**
 * Template Name: Order by title
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Sidebar layout options via customizer.
$sidebar_layout = get_theme_mod( 'gmr_blog_sidebar', 'sidebar' );

if ( 'fullwidth' === $sidebar_layout ) {
	$class_sidebar = ' col-md-12';
} else {
	$class_sidebar = ' col-md-9';
}

?>

<div id="primary" class="content-area<?php echo esc_attr( $class_sidebar ); ?> gmr-grid">
	<?php the_title( '<h1 class="page-title" ' . muvipro_itemprop_schema( 'headline' ) . '>', '</h1>' ); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<div class="entry-content entry-content-page" <?php echo muvipro_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php
		the_content();
		?>
		</div><!-- .entry-content -->
		<?php
		endwhile; // End of the loop.
	?>

	<main id="main" class="site-main" role="main">

	<?php do_action( 'idmuvi_core_topbanner_archive' ); ?>

	<?php
	global $paged;

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	$catug = get_post_meta( $post->ID, '_catmode', true );
	if ( isset( $catug ) && ! empty( $catug ) ) {
		$categ = (int) $catug;
	} else {
		$categ = 0;
	}

	$args = array(
		'paged'               => $paged,
		'post_type'           => array( 'post', 'tv' ),
		'ignore_sticky_posts' => 1,
		'orderby'             => 'title',
		'cat'                 => $categ,
		'order'               => 'ASC',
	);

	$the_query = new WP_Query( $args );

	global $wp_query;
	// Put default query object in a temp variable.
	$tmp_query = $wp_query;
	// Now wipe it out completely.
	$wp_query = null;
	// Re-populate the global with our custom query.
	$wp_query = $the_query;

	if ( $the_query->have_posts() ) {

		echo '<div id="gmr-main-load" class="row grid-container">';

		/* Start the Loop */
		while ( $the_query->have_posts() ) :
			$the_query->the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;

		echo '</div>';

		$loadmore = get_theme_mod( 'gmr_blog_pagination', 'gmr-more' );
		if ( ( 'gmr-infinite' === $loadmore ) || ( 'gmr-more' === $loadmore ) ) {
			$class = 'inf-pagination';
		} else {
			$class = 'pagination';
		}
		echo '<div class="' . esc_html( $class ) . '">';
		echo gmr_get_pagination(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
		if ( ( 'gmr-infinite' === $loadmore ) || ( 'gmr-more' === $loadmore ) ) :
			echo '
			<div class="text-center gmr-newinfinite">
				<div class="page-load-status">
					<div class="loader-ellips infinite-scroll-request gmr-ajax-load-wrapper gmr-loader">
						<div class="gmr-ajax-wrap">
							<div class="gmr-ajax-loader"><div class="loader-yellow"></div><div class="loader-blue"></div><div class="loader-red"></div></div>
						</div>
					</div>
					<p class="infinite-scroll-last">' . esc_attr__( 'No More Posts Available.', 'muvipro' ) . '</p>
					<p class="infinite-scroll-error">' . esc_attr__( 'No more pages to load.', 'muvipro' ) . '</p>
				</div>';
				if ( 'gmr-more' === $loadmore ) {
					echo '<p><button class="view-more-button heading-text">' . esc_attr__( 'View More', 'muvipro' ) . '</button></p>';
				}
			echo '
			</div>
			';
		endif;

		wp_reset_postdata();

	} else {
		get_template_part( 'template-parts/content', 'none' );

	}
	// Restore original query object.
	$wp_query = null;
	$wp_query = $tmp_query;
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
if ( 'sidebar' === $sidebar_layout ) {
	get_sidebar();
}

get_footer();
