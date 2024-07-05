<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

<div id="primary" class="content-area<?php echo esc_attr( $class_sidebar ); ?>">

	<main id="main" class="site-main" role="main">

		<section class="gmr-box-content error-404 not-found">

			<header class="entry-header">
				<h1 class="page-title screen-reader-text"><?php esc_html_e( 'Error 404', 'muvipro' ); ?></h1>
				<h2 class="page-title" <?php muvipro_itemprop_schema( 'headline' ); ?>><?php esc_html_e( 'Nothing Found', 'muvipro' ); ?></h2>
			</header><!-- .entry-header -->

			<div class="page-content" <?php muvipro_itemprop_schema( 'text' ); ?>>
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'muvipro' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .page-content -->

		</section><!-- .error-404 -->

	</main><!-- #main -->

</div><!-- #primary -->

<?php
if ( 'sidebar' === $sidebar_layout ) {
	get_sidebar();
}

get_footer();
