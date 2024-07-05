<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fb_comment = get_theme_mod( 'gmr_comment', 'default-comment' );
if ( 'fb-comment' === $fb_comment ) {
	return get_template_part( '/inc/fb-comment', '' );
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="gmr-box-content">

	<div id="comments" class="comments-area">

		<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :
			?>
			<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( 1 === $comments_number ) {
				/* translators: %s: post title */
				printf( __( 'One thought on &ldquo;%s&rdquo;', 'muvipro' ), get_the_title() ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			} else {
				printf( __( '%1$s thoughts on &ldquo;%2$s&rdquo;', 'muvipro' ), number_format_i18n( $comments_number ), get_the_title() ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			}
			?>
			</h2>

			<ol class="comment-list">
				<?php
					wp_list_comments(
						array(
							'style'       => 'ol',
							'short_ping'  => true,
							'avatar_size' => 42,
						)
					);
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'muvipro' ); ?></h2>
				<?php
				paginate_comments_links(
					apply_filters(
						'gmr_get_comment_pagination_args',
						array(
							'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.207 5.5l-2 2l2 2l-.707.707L3.793 7.5L6.5 4.793l.707.707zm3 0l-2 2l2 2l-.707.707L6.793 7.5L9.5 4.793l.707.707z" fill="currentColor"/></g></svg>',
							'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 4.793L8.207 7.5L5.5 10.207L4.793 9.5l2-2l-2-2l.707-.707zm3 0L11.207 7.5L8.5 10.207L7.793 9.5l2-2l-2-2l.707-.707z" fill="currentColor"/></g></svg>',
							'type'      => 'list',
						)
					)
				);
				?>
			</nav><!-- #comment-nav-below -->
				<?php
			endif; // Check for comment navigation.

		endif; // Check for have_comments().


		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'muvipro' ); ?></p>
			<?php
		endif;

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );

		$fields = array(
			'author' =>
			'<p class="comment-form-author">' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" placeholder="' . __( 'Name', 'muvipro' ) . ( $req ? '*' : '' ) . '" size="30"' . $aria_req . ' /></p>',

			'email'  =>
			'<p class="comment-form-email">' .
			'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" placeholder="' . __( 'Email', 'muvipro' ) . ( $req ? '*' : '' ) . '" size="30"' . $aria_req . ' /></p>',

			'url'    =>
			'<p class="comment-form-url">' .
			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" placeholder="' . __( 'Website', 'muvipro' ) . '" size="30" /></p>',
		);

		$args = array(
			'comment_field' => '<p class="comment-form-comment"><label for="comment" class="gmr-hidden">' . _x( 'Comment', 'noun', 'muvipro' ) .
			'</label><textarea id="comment" name="comment" cols="45" rows="4" placeholder="' . _x( 'Comment', 'noun', 'muvipro' ) . '" aria-required="true">' .
			'</textarea></p>',

			'fields'        => apply_filters( 'comment_form_default_fields', $fields ),
		);
		comment_form( $args );
		?>

	</div><!-- #comments -->

</div><!-- .gmr-box-content -->
