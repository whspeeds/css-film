<?php
/**
 * Template part for displaying player.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
	$notification = get_post_meta( $post->ID, 'IDMUVICORE_Notif', true );

	$player1      = get_post_meta( $post->ID, 'IDMUVICORE_Player1', true );
	$titleplayer1 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player1', true );

	$player2      = get_post_meta( $post->ID, 'IDMUVICORE_Player2', true );
	$titleplayer2 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player2', true );

	$player3      = get_post_meta( $post->ID, 'IDMUVICORE_Player3', true );
	$titleplayer3 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player3', true );

	$player4      = get_post_meta( $post->ID, 'IDMUVICORE_Player4', true );
	$titleplayer4 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player4', true );

	$player5      = get_post_meta( $post->ID, 'IDMUVICORE_Player5', true );
	$titleplayer5 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player5', true );

	$player6      = get_post_meta( $post->ID, 'IDMUVICORE_Player6', true );
	$titleplayer6 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player6', true );

	$player7      = get_post_meta( $post->ID, 'IDMUVICORE_Player7', true );
	$titleplayer7 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player7', true );

	$player8      = get_post_meta( $post->ID, 'IDMUVICORE_Player8', true );
	$titleplayer8 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player8', true );

	$player9      = get_post_meta( $post->ID, 'IDMUVICORE_Player9', true );
	$titleplayer9 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player9', true );

	$player10      = get_post_meta( $post->ID, 'IDMUVICORE_Player10', true );
	$titleplayer10 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player10', true );

	$player11      = get_post_meta( $post->ID, 'IDMUVICORE_Player11', true );
	$titleplayer11 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player11', true );

	$player12      = get_post_meta( $post->ID, 'IDMUVICORE_Player12', true );
	$titleplayer12 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player12', true );

	$player13      = get_post_meta( $post->ID, 'IDMUVICORE_Player13', true );
	$titleplayer13 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player13', true );

	$player14      = get_post_meta( $post->ID, 'IDMUVICORE_Player14', true );
	$titleplayer14 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player14', true );

	$player15      = get_post_meta( $post->ID, 'IDMUVICORE_Player15', true );
	$titleplayer15 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player15', true );

	$trailer = get_post_meta( $post->ID, 'IDMUVICORE_Trailer', true );

	$download1 = get_post_meta( $post->ID, 'IDMUVICORE_Download1', true );

if ( ! empty( $player1 )
|| ! empty( $player2 )
|| ! empty( $player3 )
|| ! empty( $player4 )
|| ! empty( $player5 )
|| ! empty( $player6 )
|| ! empty( $player7 )
|| ! empty( $player8 )
|| ! empty( $player9 )
|| ! empty( $player10 )
|| ! empty( $player11 )
|| ! empty( $player12 )
|| ! empty( $player13 )
|| ! empty( $player14 )
|| ! empty( $player15 )
) {

	do_action( 'idmuvi_core_top_player' ); // Banner before player.

	$globalnotification = get_theme_mod( 'gmr_notifplayer' );

	if ( ! empty( $globalnotification ) ) {
		?>
		<div class="gmr-notification player-notification global-notification">
			<div class="marquee">
				<?php echo esc_html( $globalnotification ); ?>
			</div>
		</div>
	<?php } ?>

	<?php
	if ( ! empty( $notification ) ) {
		?>
		<div class="gmr-notification player-notification">
			<div class="marquee">
				<?php echo esc_html( $notification ); ?>
			</div>
		</div>
	<?php } ?>

	<div class="gmr-server-wrap clearfix">
		<div class="clearfix player-wrap">
			<?php do_action( 'idmuvi_core_banner_player' ); ?>
			<?php
			if ( isset( $_GET['player'] ) && ( '2' === $_GET['player'] ) ) {
				if ( ! empty( $player2 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-2">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player2 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '3' === $_GET['player'] ) ) {
				if ( ! empty( $player3 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-3">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player3 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '4' === $_GET['player'] ) ) {
				if ( ! empty( $player4 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-4">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player4 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '5' === $_GET['player'] ) ) {
				if ( ! empty( $player5 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-5">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player5 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '6' === $_GET['player'] ) ) {
				if ( ! empty( $player6 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-6">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player6 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '7' === $_GET['player'] ) ) {
				if ( ! empty( $player7 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-7">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player7 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '8' === $_GET['player'] ) ) {
				if ( ! empty( $player8 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-8">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player8 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '9' === $_GET['player'] ) ) {
				if ( ! empty( $player9 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-9">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player9 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '10' === $_GET['player'] ) ) {
				if ( ! empty( $player10 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-10">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player10 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '11' === $_GET['player'] ) ) {
				if ( ! empty( $player11 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-11">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player11 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '12' === $_GET['player'] ) ) {
				if ( ! empty( $player12 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-12">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player12 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '13' === $_GET['player'] ) ) {
				if ( ! empty( $player13 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-13">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player13 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '14' === $_GET['player'] ) ) {
				if ( ! empty( $player14 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-14">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player14 ); ?></div>
						</div>
					<?php
				}
			} elseif ( isset( $_GET['player'] ) && ( '15' === $_GET['player'] ) ) {
				if ( ! empty( $player15 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-15">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player15 ); ?></div>
						</div>
					<?php
				}
			} else {
				if ( ! empty( $player1 ) ) {
					?>
						<div class="gmr-pagi-player tab-content" id="player-1">
							<div class="gmr-embed-responsive"><?php echo do_shortcode( $player1 ); ?></div>
						</div>
					<?php
				}
			}
			?>
		</div>

		<ul class="gmr-player-nav clearfix">
			<li><a href="javascript:void(0)" id="gmr-button-light" class="gmr-switch-button" title="<?php echo esc_html_e( 'Turn off light', 'muvipro' ); ?>" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M20 11h3v2h-3v-2M1 11h3v2H1v-2M13 1v3h-2V1h2M4.92 3.5l2.13 2.14l-1.42 1.41L3.5 4.93L4.92 3.5m12.03 2.13l2.12-2.13l1.43 1.43l-2.13 2.12l-1.42-1.42M12 6a6 6 0 0 1 6 6c0 2.22-1.21 4.16-3 5.2V19a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-1.8c-1.79-1.04-3-2.98-3-5.2a6 6 0 0 1 6-6m2 15v1a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-1h4m-3-3h2v-2.13c1.73-.44 3-2.01 3-3.87a4 4 0 0 0-4-4a4 4 0 0 0-4 4c0 1.86 1.27 3.43 3 3.87V18z" fill="currentColor"/></svg> <span class="text"><?php echo esc_html_e( 'Turn off light', 'muvipro' ); ?></span></a></li>
			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
			<li><a href="<?php comments_link(); ?>" title="<?php echo esc_html_e( 'Comments', 'muvipro' ); ?>" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 12 12"><g fill="none"><path d="M3.5 3a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 1 .5.5v.617L6.743 8.07A.5.5 0 0 1 7 8h1.5a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5h-5zM2 3.5A1.5 1.5 0 0 1 3.5 2h5A1.5 1.5 0 0 1 10 3.5v4A1.5 1.5 0 0 1 8.5 9H7.138l-2.38 1.429A.5.5 0 0 1 4 10V9h-.5A1.5 1.5 0 0 1 2 7.5v-4z" fill="currentColor"/></g></svg> <span class="text"><?php echo esc_html_e( 'Comments', 'muvipro' ); ?></span></a></li>
			<?php } ?>
			<?php
			if ( ! empty( $trailer ) ) {
				echo '<li>';
				echo '<a href="https://www.youtube.com/watch?v=' . esc_html( $trailer ) . '" class="gmr-trailer-popup" title="';
				the_title_attribute(
					array(
						'before' => __( 'Trailer for ', 'muvipro' ),
						'after'  => '',
						'echo'   => true,
					)
				);
				echo '" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5l7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></g></svg> <span class="text">' . esc_html__( 'Trailer', 'muvipro' ) . '</span></a>';
				echo '</li>';
			}
			if ( ! empty( $download1 ) ) {
				$downloadrea = get_theme_mod( 'gmr_downloadarea', 'after' );
				?>
				<?php if ( 'popup' === $downloadrea ) { ?>
					<li class="pull-right"><button id="share-modal" data-modal="gmr-id-download"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 17a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm3.293-7.707a1 1 0 0 1 1.414 0L9 10.586V3a1 1 0 1 1 2 0v7.586l1.293-1.293a1 1 0 1 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z" fill="currentColor"/></g></svg> <span class="textdownload"><?php echo esc_html_e( 'Download', 'muvipro' ); ?></span></button></li>
				<?php } else { ?>
					<li class="pull-right"><a class="popup-download" href="#download" title="<?php echo esc_html__( 'Download', 'muvipro' ); ?>" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 17a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm3.293-7.707a1 1 0 0 1 1.414 0L9 10.586V3a1 1 0 1 1 2 0v7.586l1.293-1.293a1 1 0 1 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z" fill="currentColor"/></g></svg> <span class="textdownload"><?php echo esc_html_e( 'Download', 'muvipro' ); ?></span></a></li>
				<?php } ?>
			<?php } ?>
		</ul>

		<ul class="muvipro-player-tabs nav nav-tabs clearfix">
			<?php
			if ( ! empty( $player1 ) ) {
				if ( empty( $_GET['player'] ) ) {
					$class1 = ' class="active"';
				} else {
					$class1 = '';
				}
				echo '<li><a href="' . esc_url( get_permalink() ) . '"' . $class1 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer1 ) ) {
					echo esc_html( $titleplayer1 );
				} else {
					echo esc_html_e( 'Server 1', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player2 ) ) {
				if ( isset( $_GET['player'] ) && ( '2' === $_GET['player'] ) ) {
					$class2 = ' class="active"';
				} else {
					$class2 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '2' ) ) . '"' . $class2 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer2 ) ) {
					echo esc_html( $titleplayer2 );
				} else {
					echo esc_html_e( 'Server 2', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player3 ) ) {
				if ( isset( $_GET['player'] ) && ( '3' === $_GET['player'] ) ) {
					$class3 = ' class="active"';
				} else {
					$class3 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '3' ) ) . '"' . $class3 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer3 ) ) {
					echo esc_html( $titleplayer3 );
				} else {
					echo esc_html_e( 'Server 3', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player4 ) ) {
				if ( isset( $_GET['player'] ) && ( '4' === $_GET['player'] ) ) {
					$class4 = ' class="active"';
				} else {
					$class4 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '4' ) ) . '"' . $class4 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer4 ) ) {
					echo esc_html( $titleplayer4 );
				} else {
					echo esc_html_e( 'Server 4', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player5 ) ) {
				if ( isset( $_GET['player'] ) && ( '5' === $_GET['player'] ) ) {
					$class5 = ' class="active"';
				} else {
					$class5 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '5' ) ) . '"' . $class5 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer5 ) ) {
					echo esc_html( $titleplayer5 );
				} else {
					echo esc_html_e( 'Server 5', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player6 ) ) {
				if ( isset( $_GET['player'] ) && ( '6' === $_GET['player'] ) ) {
					$class6 = ' class="active"';
				} else {
					$class6 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '6' ) ) . '"' . $class6 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer6 ) ) {
					echo esc_html( $titleplayer6 );
				} else {
					echo esc_html_e( 'Server 6', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player7 ) ) {
				if ( isset( $_GET['player'] ) && ( '7' === $_GET['player'] ) ) {
					$class7 = ' class="active"';
				} else {
					$class7 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '7' ) ) . '"' . $class7 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer7 ) ) {
					echo esc_html( $titleplayer7 );
				} else {
					echo esc_html_e( 'Server 7', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player8 ) ) {
				if ( isset( $_GET['player'] ) && ( '8' === $_GET['player'] ) ) {
					$class8 = ' class="active"';
				} else {
					$class8 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '8' ) ) . '"' . $class8 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer8 ) ) {
					echo esc_html( $titleplayer8 );
				} else {
					echo esc_html_e( 'Server 8', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player9 ) ) {
				if ( isset( $_GET['player'] ) && ( '9' === $_GET['player'] ) ) {
					$class9 = ' class="active"';
				} else {
					$class9 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '9' ) ) . '"' . $class9 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer9 ) ) {
					echo esc_html( $titleplayer9 );
				} else {
					echo esc_html_e( 'Server 9', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player10 ) ) {
				if ( isset( $_GET['player'] ) && ( '10' === $_GET['player'] ) ) {
					$class10 = ' class="active"';
				} else {
					$class10 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '10' ) ) . '"' . $class10 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer10 ) ) {
					echo esc_html( $titleplayer10 );
				} else {
					echo esc_html_e( 'Server 10', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player11 ) ) {
				if ( isset( $_GET['player'] ) && ( '11' === $_GET['player'] ) ) {
					$class11 = ' class="active"';
				} else {
					$class11 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '11' ) ) . '"' . $class11 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer11 ) ) {
					echo esc_html( $titleplayer11 );
				} else {
					echo esc_html_e( 'Server 11', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player12 ) ) {
				if ( isset( $_GET['player'] ) && ( '12' === $_GET['player'] ) ) {
					$class12 = ' class="active"';
				} else {
					$class12 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '12' ) ) . '"' . $class12 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer12 ) ) {
					echo esc_html( $titleplayer12 );
				} else {
					echo esc_html_e( 'Server 12', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player13 ) ) {
				if ( isset( $_GET['player'] ) && ( '13' === $_GET['player'] ) ) {
					$class13 = ' class="active"';
				} else {
					$class13 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '13' ) ) . '"' . $class13 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer13 ) ) {
					echo esc_html( $titleplayer13 );
				} else {
					echo esc_html_e( 'Server 13', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player14 ) ) {
				if ( isset( $_GET['player'] ) && ( '14' === $_GET['player'] ) ) {
					$class14 = ' class="active"';
				} else {
					$class14 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '14' ) ) . '"' . $class14 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer14 ) ) {
					echo esc_html( $titleplayer14 );
				} else {
					echo esc_html_e( 'Server 14', 'muvipro' );
				}
				echo '</a></li>';
			}
			if ( ! empty( $player15 ) ) {
				if ( isset( $_GET['player'] ) && ( '15' === $_GET['player'] ) ) {
					$class15 = ' class="active"';
				} else {
					$class15 = '';
				}
				echo '<li><a href="' . esc_url( add_query_arg( 'player', '15' ) ) . '"' . $class15 . ' rel="nofollow">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $titleplayer15 ) ) {
					echo esc_html( $titleplayer15 );
				} else {
					echo esc_html_e( 'Server 15', 'muvipro' );
				}
				echo '</a></li>';
			}
			?>
		</ul>
	</div>

	<div id="lightoff"></div>

<?php } else { ?>

	<?php
	// Display content if have no embed code via player metaboxes.
	$noembed_setting = get_theme_mod( 'gmr_player_appear', 'trailer' );
	if ( ! empty( $trailer ) && 'trailer' === $noembed_setting ) {
		?>

		<?php do_action( 'idmuvi_core_top_player' ); // Banner before player. ?>

		<div class="gmr-server-wrap">
			<div class="clearfix player-wrap">
				<?php do_action( 'idmuvi_core_banner_player' ); ?>
				<div class="tab-content">
					<div class="gmr-embed-responsive">
						<iframe src="https://www.youtube.com/embed/<?php echo esc_html( $trailer ); ?>" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
			<ul class="gmr-player-nav clearfix">
				<li><a href="javascript:void(0)" id="gmr-button-light" class="gmr-switch-button" title="<?php echo esc_html_e( 'Turn off light', 'muvipro' ); ?>" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M20 11h3v2h-3v-2M1 11h3v2H1v-2M13 1v3h-2V1h2M4.92 3.5l2.13 2.14l-1.42 1.41L3.5 4.93L4.92 3.5m12.03 2.13l2.12-2.13l1.43 1.43l-2.13 2.12l-1.42-1.42M12 6a6 6 0 0 1 6 6c0 2.22-1.21 4.16-3 5.2V19a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-1.8c-1.79-1.04-3-2.98-3-5.2a6 6 0 0 1 6-6m2 15v1a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-1h4m-3-3h2v-2.13c1.73-.44 3-2.01 3-3.87a4 4 0 0 0-4-4a4 4 0 0 0-4 4c0 1.86 1.27 3.43 3 3.87V18z" fill="currentColor"/></svg> <span class="text"><?php echo esc_html_e( 'Turn off light', 'muvipro' ); ?></span></a></li>
				<li><a href="#comments" title="<?php echo esc_html_e( 'Comments', 'muvipro' ); ?>" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 12 12"><g fill="none"><path d="M3.5 3a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 1 .5.5v.617L6.743 8.07A.5.5 0 0 1 7 8h1.5a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5h-5zM2 3.5A1.5 1.5 0 0 1 3.5 2h5A1.5 1.5 0 0 1 10 3.5v4A1.5 1.5 0 0 1 8.5 9H7.138l-2.38 1.429A.5.5 0 0 1 4 10V9h-.5A1.5 1.5 0 0 1 2 7.5v-4z" fill="currentColor"/></g></svg> <span class="text"><?php echo esc_html_e( 'Comments', 'muvipro' ); ?></span></a></li>
				<?php if ( ! empty( $download1 ) ) {
					$downloadrea = get_theme_mod( 'gmr_downloadarea', 'after' );
					?>
					<?php if ( 'popup' === $downloadrea ) { ?>
						<li class="pull-right"><button id="share-modal" data-modal="gmr-id-download"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 17a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm3.293-7.707a1 1 0 0 1 1.414 0L9 10.586V3a1 1 0 1 1 2 0v7.586l1.293-1.293a1 1 0 1 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z" fill="currentColor"/></g></svg> <span class="textdownload"><?php echo esc_html_e( 'Download', 'muvipro' ); ?></span></button></li>
					<?php } else { ?>
						<li class="pull-right"><a class="popup-download" href="#download" title="<?php echo esc_html__( 'Download', 'muvipro' ); ?>" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 17a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm3.293-7.707a1 1 0 0 1 1.414 0L9 10.586V3a1 1 0 1 1 2 0v7.586l1.293-1.293a1 1 0 1 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z" fill="currentColor"/></g></svg> <span class="textdownload"><?php echo esc_html_e( 'Download', 'muvipro' ); ?></span></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>

		<div id="lightoff"></div>

	<?php } elseif ( 'text' === $noembed_setting ) { ?>
		<?php
		if ( ! is_singular( 'tv' ) ) {
			$textcommingsoon = get_theme_mod( 'gmr_textplayer' );
			?>
			<div class="gmr-server-wrap clearfix">
				<div class="gmr-embed-text">
					<?php
					if ( $textcommingsoon ) {
						// sanitize html output than convert it again using htmlspecialchars_decode.
						echo esc_html( $textcommingsoon );

					} else {
						echo esc_html__( 'Comming Soon', 'muvipro' );

					}
					?>
				</div>
			</div>
		<?php } ?>
		
	<?php } ?>
<?php } ?>
