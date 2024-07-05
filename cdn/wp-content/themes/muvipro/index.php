<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

	<?php
	$texthomepage = get_theme_mod( 'gmr_texttitlehomepage' );
	if ( $texthomepage ) :
		// sanitize html output.
		echo '<h3 class="homemodule-title">' . esc_html( $texthomepage ) . '</h3>';
	else :
		echo '<h3 class="homemodule-title">' . esc_html__( 'Latest Movie', 'muvipro' ) . '</h3>';
	endif;
	?>

	<main id="main" class="site-main" role="main">

	<?php do_action( 'idmuvi_core_topbanner_archive' ); ?>

	<?php
	if ( have_posts() ) :

		if ( is_home() && ! is_front_page() ) :
			?>
			<header>
				<h1 class="page-title screen-reader-text" <?php echo muvipro_itemprop_schema( 'headline' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>><?php single_post_title(); ?></h1>
			</header>
			<?php
		endif;

		if ( is_front_page() && is_home() ) :
			?>
			<header>
				<h1 class="page-title screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
			</header>
			<?php
		endif;

		echo '<div id="gmr-main-load" class="row grid-container">';
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

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

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
if ( 'sidebar' === $sidebar_layout ) {
	get_sidebar();
}

get_footer();
