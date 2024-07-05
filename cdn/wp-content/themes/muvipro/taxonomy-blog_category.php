<?php
/**
 * The template for displaying a single blog
 *
 * @package muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

?>

<div id="primary" class="content-area col-md-9 gmr-grid">

	<?php
	echo '<h1 class="page-title" itemprop="headline">';
		the_archive_title();
	echo '</h1>';

	// display description archive page.
	the_archive_description( '<div class="taxonomy-description">', '</div>' );
	?>

	<main id="main" class="site-main" role="main">

	<?php do_action( 'idmuvi_core_topbanner_archive' ); ?>

	<?php
	if ( have_posts() ) :

		echo '<div id="gmr-main-load" class="row grid-container">';

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'blogs' );

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

	else :
		echo esc_html__( 'No Blog', 'muvipro' );

	endif;

	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar( 'blogs' );

get_footer();
