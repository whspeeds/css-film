<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Disable sidebar using metabox.
$sidebar_display = get_post_meta( $post->ID, '_gmr_sidebar_key', true );

// Sidebar layout options via customizer.
$sidebar_layout = get_theme_mod( 'gmr_single_sidebar', 'sidebar' );

if ( 'fullwidth' === $sidebar_layout ) :
	$class = ' col-md-12';
elseif ( $sidebar_display ) :
	$class = ' col-md-12';
else :
	$class = ' col-md-9';
endif;

?>

<div id="primary" class="content-area<?php echo esc_attr( $class ); ?>">

	<?php do_action( 'muvipro_view_breadcrumbs' ); ?>

	<main id="main" class="site-main" role="main">

	<?php
	while ( have_posts() ) :
		the_post();
		if ( is_singular( 'tv' ) ) {
			get_template_part( 'template-parts/content', 'single-tv' );
		} elseif ( is_singular( 'episode' ) ) {
			get_template_part( 'template-parts/content', 'single-episode' );
		} elseif ( is_singular( 'attachment' ) ) {
			get_template_part( 'template-parts/content', 'single-attachment' );
		} else {
			get_template_part( 'template-parts/content', 'single' );
		}

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php
if ( $sidebar_display || 'fullwidth' === $sidebar_layout ) :
else :
	get_sidebar();
endif;

get_footer();
