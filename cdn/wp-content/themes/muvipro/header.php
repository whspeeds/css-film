<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php echo muvipro_itemtype_schema( 'WebSite' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo muvipro_itemtype_schema( 'WebPage' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
	<?php do_action( 'wp_body_open' ); ?>
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'muvipro' ); ?></a>

	<?php
		global $post;
	?>
	<div class="site inner-wrap" id="site-container">
	<?php do_action( 'idmuvi_core_floating_banner_left' ); ?>
	<?php do_action( 'idmuvi_core_floating_banner_right' ); ?>
	<?php
		// Top banner.
		do_action( 'idmuvi_core_top_banner' );
	?>

	<header id="masthead" class="site-header pos-stickymenu-mobile" role="banner" <?php echo muvipro_itemtype_schema( 'WPHeader' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
		<?php
		$enable_logo = get_theme_mod( 'gmr_active-logosection', 0 );
		if ( 0 === $enable_logo ) {
			?>
			<div class="container">
				<div class="clearfix gmr-headwrapper">
					<div class="list-table">
						<div class="table-row">
							<div class="table-cell logo-wrap">
							<?php
								do_action( 'gmr_the_custom_logo' );
							?>
							</div>
							<div class="table-cell search-wrap">
								<?php
									do_action( 'gmr_top_searchbutton' );
								?>
							</div>
							<div class="table-cell menutop-wrap">
								<a id="gmr-topnavresponsive-menu" href="#menus" title="Menus" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M21 6v2H3V6h18zM3 18h18v-2H3v2zm0-5h18v-2H3v2z" fill="currentColor"/></svg></a>
								<div class="close-topnavmenu-wrap"><a id="close-topnavmenu-button" rel="nofollow" href="#"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M685.4 354.8c0-4.4-3.6-8-8-8l-66 .3L512 465.6l-99.3-118.4l-66.1-.3c-4.4 0-8 3.5-8 8c0 1.9.7 3.7 1.9 5.2l130.1 155L340.5 670a8.32 8.32 0 0 0-1.9 5.2c0 4.4 3.6 8 8 8l66.1-.3L512 564.4l99.3 118.4l66 .3c4.4 0 8-3.5 8-8c0-1.9-.7-3.7-1.9-5.2L553.5 515l130.1-155c1.2-1.4 1.8-3.3 1.8-5.2z" fill="currentColor"/><path d="M512 65C264.6 65 64 265.6 64 513s200.6 448 448 448s448-200.6 448-448S759.4 65 512 65zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/></svg></a></div>
								<?php
								// Second top menu.
								if ( has_nav_menu( 'topnav' ) ) {
									?>
									<nav id="site-navigation" class="gmr-topnavmenu pull-right" role="navigation" <?php echo muvipro_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
										<?php
										wp_nav_menu(
											array(
												'theme_location' => 'topnav',
												'container' => 'ul',
												'fallback_cb' => '',
												'menu_id' => 'primary-menu',
												'link_before' => '<span itemprop="name">',
												'link_after' => '</span>',
											)
										);
										?>
									</nav><!-- #site-navigation -->
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</header><!-- #masthead -->

	<?php
	// Menu style via customizer.
	$menu_style = get_theme_mod( 'gmr_menu_style', 'gmr-fluidmenu' );
	?>

	<div class="menu-wrap pos-stickymenu">
		<div class="top-header">
			<?php if ( 'gmr-boxmenu' === $menu_style ) : ?>
			<div class="container">
			<?php endif; ?>
				<?php // first top menu. ?>
					<div class="gmr-menuwrap clearfix">
						<?php if ( 'gmr-fluidmenu' === $menu_style ) : ?>
						<div class="container">
						<?php endif; ?>
							<nav id="site-navigation" class="gmr-mainmenu" role="navigation" <?php echo muvipro_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'container'      => 'ul',
										'menu_id'        => 'primary-menu',
										'link_before'    => '<span itemprop="name">',
										'link_after'     => '</span>',
									)
								);
								?>
							</nav><!-- #site-navigation -->
						<?php if ( 'gmr-fluidmenu' === $menu_style ) : ?>
						</div>
						<?php endif; ?>
					</div>
			<?php if ( 'gmr-boxmenu' === $menu_style ) : ?>
			</div>
			<?php endif; ?>
		</div><!-- .top-header -->

		<div class="second-header">
			<?php if ( 'gmr-boxmenu' === $menu_style ) : ?>
			<div class="container">
			<?php endif; ?>
				<?php
				// Second top menu.
				if ( has_nav_menu( 'secondary' ) ) {
					?>
					<div class="gmr-secondmenuwrap clearfix">
						<?php if ( 'gmr-fluidmenu' === $menu_style ) : ?>
							<div class="container">
						<?php endif; ?>
							<nav id="site-navigation" class="gmr-secondmenu" role="navigation" <?php echo muvipro_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'secondary',
										'container'      => 'ul',
										'fallback_cb'    => '',
										'menu_id'        => 'primary-menu',
										'link_before'    => '<span itemprop="name">',
										'link_after'     => '</span>',
									)
								);
								?>
							</nav><!-- #site-navigation -->
						<?php if ( 'gmr-fluidmenu' === $menu_style ) : ?>
							</div>
						<?php endif; ?>
					</div>
					<?php
				}
				?>
			<?php if ( 'gmr-boxmenu' === $menu_style ) : ?>
			</div>
			<?php endif; ?>
		</div><!-- .top-header -->
	</div>

	<?php
	$setting = 'gmr_text_notification';
	$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$slider  = get_theme_mod( 'gmr_active-slider', 0 );

	if ( ( 0 === $slider ) || ( isset( $mod ) && ! empty( $mod ) ) ) {
		if ( is_front_page() ) {
			?>
			<?php if ( 'gmr-boxmenu' === $menu_style ) : ?>
				<div class="container">
			<?php endif; ?>
			<?php
			if ( 'gmr-boxmenu' === $menu_style ) :
				$class = ' boxmenu-padding';
			else :
				$class = '';
			endif;
			?>
			<div class="gmr-boxaftermenu<?php echo esc_html( $class ); ?>">
				<?php if ( 'gmr-fluidmenu' === $menu_style ) : ?>
					<div class="container">
				<?php endif; ?>
						<?php do_action( 'gmr_socialicon' ); ?>
						<?php if ( isset( $mod ) && ! empty( $mod ) ) { ?>
						<div class="gmr-notification">
							<div class="marquee">
								<?php echo do_shortcode( wp_kses_post( $mod ) ); ?>
							</div>
						</div>
						<?php } ?>
						<?php
						if ( 0 === $slider ) {
							do_action( 'muvipro_display_carousel' );
						}
						?>
				<?php if ( 'gmr-fluidmenu' === $menu_style ) : ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( 'gmr-boxmenu' === $menu_style ) : ?>
				</div>
			<?php endif; ?>
			<?php
		}
	}
	?>

	<div id="content" class="gmr-content">

		<?php
			do_action( 'idmuvi_core_top_banner_after_menu' );
		?>

		<?php
		// Home module.
		if ( is_active_sidebar( 'home-module' ) ) {
			if ( is_front_page() ) {
				echo '<div class="container">';
				echo '<div class="row">';
				echo '<div class="col-md-12">';
				dynamic_sidebar( 'home-module' );
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
		}
		?>

		<div class="container gmr-maincontent">
			<div class="row">
