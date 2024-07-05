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

$hasthumbnail = '';
if ( has_post_thumbnail() ) {
	$hasthumbnail = ' has-post-thumbnail';
}
?>

<article id="post-<?php the_ID(); ?>" class="hentry <?php echo esc_html( $hasthumbnail ); ?>" <?php echo muvipro_itemtype_schema( 'CreativeWork' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="gmr-box-content gmr-single gmr-blog">
		<?php
		do_action( 'muvipro_share_action' ); // Social share.

		if ( has_post_thumbnail() ) {
			?>
			<figure class="wp-caption alignnone gmr-thumbnail-blog">
				<?php the_post_thumbnail(); ?>
				<?php if ( $caption = get_post( get_post_thumbnail_id() )->post_excerpt ) : ?>
					<figcaption class="wp-caption-text"><?php echo esc_html( $caption ); ?></figcaption>
				<?php endif; ?>
			</figure>
			<?php
		}
		?>

		<header class="entry-header gmr-movie-data">
			<?php the_title( '<h1 class="entry-title" ' . muvipro_itemprop_schema( 'name' ) . '>', '</h1>' ); ?>
			<div class="gmr-header-posted-on">
				<?php gmr_posted_on(); ?>
			</div>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			the_content(
				sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'muvipro' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Blogs:', 'muvipro' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
		
		<?php do_action( 'idmuvi_core_add_banner_after_content' ); ?>
		
		<?php do_action( 'muvipro_share_action' ); ?>

		<footer class="entry-footer">
		<?php
		$tags_list = idmuvi_core_get_the_blog_tags( $post->ID, '', ', ' );
		$cats_list = idmuvi_core_get_the_blog_category( $post->ID, '', ', ' );

		if ( $cats_list ) {
			printf(
				'<span class="cat-links">%1$s %2$s</span>',
				esc_html_x( 'Posted in', 'Used before categories names.', 'muvipro' ),
				$cats_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}

		if ( $tags_list ) {
			printf(
				'<span class="tags-links">%1$s %2$s</span>',
				esc_html_x( 'Tagged', 'Used before tag names.', 'muvipro' ),
				$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'muvipro' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);

		// Post navigation.
		the_post_navigation(
			array(
				'prev_text' => __( '<span>Previous post</span> %title', 'muvipro' ),
				'next_text' => __( '<span>Next post</span> %title', 'muvipro' ),
			)
		);
		?>
		</footer><!-- .entry-footer -->

	</div><!-- .gmr-box-content -->

	<?php
		// Authorbox this function from action in idmuvi core plugin.
		do_action( 'idmuvi_core_author_box' );
	?>

</article><!-- #post-## -->
