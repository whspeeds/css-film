<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
			</div><!-- .row -->
		</div><!-- .container -->
		<div id="stop-container"></div>
		<?php do_action( 'idmuvi_core_banner_footer' ); ?>
	</div><!-- .gmr-content -->

<div id="footer-container">

	<div class="gmr-bgstripes">
		<span class="gmr-bgstripe gmr-color1"></span><span class="gmr-bgstripe gmr-color2"></span>
		<span class="gmr-bgstripe gmr-color3"></span><span class="gmr-bgstripe gmr-color4"></span>
		<span class="gmr-bgstripe gmr-color5"></span><span class="gmr-bgstripe gmr-color6"></span>
		<span class="gmr-bgstripe gmr-color7"></span><span class="gmr-bgstripe gmr-color8"></span>
		<span class="gmr-bgstripe gmr-color9"></span><span class="gmr-bgstripe gmr-color10"></span>
		<span class="gmr-bgstripe gmr-color11"></span><span class="gmr-bgstripe gmr-color12"></span>
		<span class="gmr-bgstripe gmr-color13"></span><span class="gmr-bgstripe gmr-color14"></span>
		<span class="gmr-bgstripe gmr-color15"></span><span class="gmr-bgstripe gmr-color16"></span>
		<span class="gmr-bgstripe gmr-color17"></span><span class="gmr-bgstripe gmr-color18"></span>
		<span class="gmr-bgstripe gmr-color19"></span><span class="gmr-bgstripe gmr-color20"></span>
	</div>

	<?php
	$mod = get_theme_mod( 'gmr_footer_column', '3col' );
	if ( '4col' === $mod ) {
		$class = 'col-md-3';
	} elseif ( '1col' === $mod ) {
		$class = 'col-md-12';
	} elseif ( '2col' === $mod ) {
		$class = 'col-md-6';
	} else {
		$class = 'col-md-4';
	}

	if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) :
		?>
		<div id="footer-sidebar" class="widget-footer" role="complementary">
			<div class="container">
				<div class="row">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-4' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<footer id="colophon" class="text-center site-footer" role="contentinfo" <?php muvipro_itemtype_schema( 'WPFooter' ); ?>>
		<div class="container">
			<div class="site-info">
			<?php
			$copyright = get_theme_mod( 'gmr_copyright' );
			if ( $copyright ) :
				// sanitize html output than convert it again using htmlspecialchars_decode.
				echo wp_kses_post( $copyright );
			else :
				?>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'muvipro' ) ); ?>" title="<?php printf( esc_html__( 'Proudly powered by %s', 'muvipro' ), 'WordPress' ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'muvipro' ), 'WordPress' ); ?></a>
				<span class="sep"> / </span>
				<a href="<?php echo esc_url( __( 'https://www.idtheme.com/muvipro/', 'muvipro' ) ); ?>" title="<?php printf( esc_html__( 'Theme: %s', 'muvipro' ), 'Muvipro' ); ?>" rel="nofollow"><?php printf( esc_html__( 'Theme: %s', 'muvipro' ), 'Muvipro' ); ?></a>
			<?php endif; ?>
			</div><!-- .site-info -->
		</div><!-- .container -->
		<?php do_action( 'idmuvi_core_floating_footer' ); ?>
	</footer><!-- #colophon -->

</div><!-- #footer-container -->

</div><!-- #site-container -->

<div class="gmr-ontop gmr-hide"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><path class="clr-i-outline clr-i-outline-path-1" d="M29.52 22.52L18 10.6L6.48 22.52a1.7 1.7 0 0 0 2.45 2.36L18 15.49l9.08 9.39a1.7 1.7 0 0 0 2.45-2.36z" fill="currentColor"/></svg></div>

<?php wp_footer(); ?>

</body>
</html>
