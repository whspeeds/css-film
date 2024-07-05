<?php
/**
 * Widget API: MuviPro_Posts_Widget class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Muvipro
 * @subpackage Widgets
 * @since 1.0.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the RPSL widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class MuviPro_Posts_Widget extends WP_Widget {
	/**
	 * Sets up a Recent Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'muvipro-posts-module',
			'description' => __( 'Module posts for module home.', 'muvipro' ),
		);
		parent::__construct( 'muvipro-posts', __( 'Module Posts (Muvipro)', 'muvipro' ), $widget_ops );
		// add action for admin_register_scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_register_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'admin_print_scripts' ), 9999 );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0
	 *
	 * @param string $hook_suffix Hook Suffix.
	 */
	public function admin_register_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}
		wp_enqueue_script( 'suggest' );
	}

	/**
	 * Print scripts.
	 *
	 * @since 1.0
	 */
	public function admin_print_scripts() {
		?>
		<script>
			function setSuggest_cat_recent(id) {
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=category", {multiple:true, multipleSep: ","});
			}
			function setSuggest_tag_recent(id) {
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=post_tag", {multiple:true, multipleSep: ","});
			}
			function setSuggest_country_recent(id) {
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=muvicountry", {multiple:true, multipleSep: ","});
			}
			function setSuggest_year_recent(id) {
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=muviyear", {multiple:true, multipleSep: ","});
			}
		</script>
		<?php
	}

	/**
	 * Outputs the content for Mailchimp Form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Mailchimp Form.
	 */
	public function widget( $args, $instance ) {
		global $post;
		// Title.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		// Link Title.
		$link_title = ( ! empty( $instance['link_title'] ) ) ? esc_url( $instance['link_title'] ) : '';
		echo $args['before_widget']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
		if ( $title ) {
			if ( ! empty( $link_title ) ) {
				echo '<div class="row">';
					echo '<div class="col-md-10">';
			}
				echo $args['before_title'] . $title . $args['after_title']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			if ( ! empty( $link_title ) ) {
					echo '</div>';
					echo '<div class="col-md-2"><div class="module-linktitle"><h4><a href="' . esc_url( $link_title ) . '" title="' . esc_html__( 'Permalink to: ', 'muvipro' ) . esc_html( $title ) . '">' . esc_html__( 'More Movie', 'muvipro' ) . '</a></h4></div></div>';
				echo '</div>';
			}
		}
		// Base Id Widget.
		$idmuv_widget_id = $this->id_base . '-' . $this->number;
		// Post type.
		$idmuv_posttype = ( isset( $instance['idmuv_posttype'] ) ) ? esc_attr( $instance['idmuv_posttype'] ) : esc_attr( 'all' );
		// Category Name.
		$idmuv_category = ( ! empty( $instance['idmuv_category'] ) ) ? wp_strip_all_tags( $instance['idmuv_category'] ) : '';
		// Tag Name.
		$idmuv_tag = ( ! empty( $instance['idmuv_tag'] ) ) ? wp_strip_all_tags( $instance['idmuv_tag'] ) : '';
		// Country Name.
		$idmuv_country = ( ! empty( $instance['idmuv_country'] ) ) ? wp_strip_all_tags( $instance['idmuv_country'] ) : '';
		// Year Name.
		$idmuv_year = ( ! empty( $instance['idmuv_year'] ) ) ? wp_strip_all_tags( $instance['idmuv_year'] ) : '';
		// orderby.
		$idmuv_orderby = ( ! empty( $instance['idmuv_orderby'] ) ) ? wp_strip_all_tags( $instance['idmuv_orderby'] ) : wp_strip_all_tags( 'date' );
		// Excerpt Length.
		$idmuv_number_posts = ( ! empty( $instance['idmuv_number_posts'] ) ) ? absint( $instance['idmuv_number_posts'] ) : absint( 8 );
		// Title Length.
		$idmuv_title_length = ( ! empty( $instance['idmuv_title_length'] ) ) ? absint( $instance['idmuv_title_length'] ) : absint( 40 );

		// standard params.
		$query_args = array(
			'posts_per_page'         => $idmuv_number_posts,
			'post_status'            => 'publish',
			// make it fast withour update term cache and cache results
			// https://thomasgriffin.io/optimize-wordpress-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'cache_results'          => false,
			'no_found_rows'          => true,
			'fields'                 => 'ids',
		);

		if ( 'all' === $idmuv_posttype ) {
			$query_args['post_type'] = array( 'post', 'tv' );
		} elseif ( 'movie' === $idmuv_posttype ) {
			$query_args['post_type'] = array( 'post' );
		} elseif ( 'tvshows' === $idmuv_posttype ) {
			$query_args['post_type'] = array( 'tv' );
		} else {
			$query_args['post_type'] = array( 'post', 'tv' );
		}

		$query_args['ignore_sticky_posts'] = true;

		// set order of posts in widget.
		$query_args['orderby'] = $idmuv_orderby;
		$query_args['order']   = 'DESC';

		// add categories param only if 'all categories' was not selected.
		$cat_id_array = $this->generate_cat_id_from_name( $idmuv_category );
		if ( count( $cat_id_array ) > 0 ) {
			$query_args['category__in'] = $cat_id_array;
		}

		// add tags param only if 'all tags' was not selected.
		$tag_id_array = $this->generate_tag_id_from_name( $idmuv_tag );
		if ( count( $tag_id_array ) > 0 ) {
			$query_args['tag__in'] = $tag_id_array;
		}

		$taxquery             = array();
		$taxquery['relation'] = 'AND';
		// add year param only if 'all years' was not selected.
		$year_id_array = $this->generate_year_id_from_name( $idmuv_year );
		if ( count( $year_id_array ) > 0 ) {
			$taxquery[] = array(
				'taxonomy' => 'muviyear',
				'field'    => 'term_id',
				'operator' => 'IN',
				'terms'    => $year_id_array,
			);
		}

		// add country param only if 'all countrys' was not selected.
		$country_id_array = $this->generate_country_id_from_name( $idmuv_country );
		if ( count( $country_id_array ) > 0 ) {
			$taxquery[] = array(
				'taxonomy' => 'muvicountry',
				'field'    => 'term_id',
				'operator' => 'IN',
				'terms'    => $country_id_array,
			);
		}

		$query_args['tax_query'] = $taxquery;

		// run the query: get the latest posts.
		$rp = new WP_Query( apply_filters( 'idmuv_rp_widget_posts_args', $query_args ) );

		?>

			<div class="row grid-container gmr-module-posts">
				<?php
				while ( $rp->have_posts() ) :
					$rp->the_post();
					?>
					<div class="col-md-125" <?php echo muvipro_itemtype_schema( 'Movie' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
						<div class="gmr-item-modulepost">
							<?php
							// Add thumnail.
							if ( has_post_thumbnail() ) :
								echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
								the_title_attribute(
									array(
										'before' => __( 'Permalink to: ', 'muvipro' ),
										'after'  => '',
										'echo'   => true,
									)
								);
								echo '" rel="bookmark">';
									the_post_thumbnail( 'medium', array( 'itemprop' => 'image' ) );
								echo '</a>';
							endif; // endif has_post_thumbnail.
							?>

							<header class="entry-header text-center">
								<div class="gmr-button-widget">
									<?php
									$trailer = get_post_meta( get_the_ID(), 'IDMUVICORE_Trailer', true );
									// Check if the custom field has a value.
									if ( ! empty( $trailer ) ) {
										echo '<div class="clearfix gmr-popup-button-widget">';
										echo '<a href="https://www.youtube.com/watch?v=' . esc_html( $trailer ) . '" class="button gmr-trailer-popup" title="';
										the_title_attribute(
											array(
												'before' => __( 'Trailer for ', 'muvipro' ),
												'after'  => '',
												'echo'   => true,
											)
										);
										echo '" rel="nofollow">' . esc_html__( 'Trailer', 'muvipro' ) . '</a>';
										echo '</div>';
									}
									?>
									<div class="clearfix">
										<?php
										echo '<a href="' . esc_url( get_permalink() ) . '" class="button gmr-watch-btn" itemprop="url" title="';
										the_title_attribute(
											array(
												'before' => __( 'Permalink to: ', 'muvipro' ),
												'after'  => '',
												'echo'   => true,
											)
										);
										echo '" rel="bookmark">';
											echo esc_html__( 'Watch Movie', 'muvipro' );
										echo '</a>';
										?>
									</div>
								</div>
								<h2 class="entry-title" <?php echo muvipro_itemprop_schema( 'headline' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
									<?php
									echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
									the_title_attribute(
										array(
											'before' => __( 'Permalink to: ', 'muvipro' ),
											'after'  => '',
											'echo'   => true,
										)
									);
									echo '" rel="bookmark">';
									if ( $post_title = $this->get_the_trimmed_post_title( $idmuv_title_length ) ) {
										echo esc_html( $post_title );
									} else {
										the_title();
									}
									echo '</a>';
									?>
								</h2>
							</header><!-- .entry-header -->

							<?php
							$rating = get_post_meta( get_the_ID(), 'IDMUVICORE_tmdbRating', true );
							if ( ! empty( $rating ) ) {
								echo '<div class="gmr-rating-item"><span class="icon_star"></span> ' . esc_html( $rating ) . '</div>';
							}

							$release = get_post_meta( get_the_ID(), 'IDMUVICORE_Released', true );
							// Check if the custom field has a value.
							if ( ! empty( $release ) ) {
								if ( true === gmr_checkIsAValidDate( $release ) ) {
									$datetime = new DateTime( $release );
									echo '<span class="screen-reader-text"><time itemprop="dateCreated" datetime="' . esc_html( $datetime->format( 'c' ) ) . '">' . esc_html( $release ) . '</time></span>';
								}
							}

							if ( ! is_wp_error( get_the_term_list( get_the_ID(), 'muvidirector' ) ) ) {
								$muvidir = get_the_term_list( get_the_ID(), 'muvidirector' );
								if ( ! empty( $muvidir ) ) {
									echo '<span class="screen-reader-text">';
									echo get_the_term_list( get_the_ID(), 'muvidirector', '<span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>' );
									echo '</span>';
								}
							}

							if ( ! is_wp_error( get_the_term_list( get_the_ID(), 'muviquality' ) ) ) {
								$termlist = get_the_term_list( get_the_ID(), 'muviquality' );
								if ( ! empty( $termlist ) ) {
									echo '<div class="gmr-quality-item ' . strip_tags( strtolower( get_the_term_list( get_the_ID(), 'muviquality', '', ' ', '' ) ) ) . '">';
									echo get_the_term_list( get_the_ID(), 'muviquality', '', ', ', '' );
									echo '</div>';
								}
							}

							$episodes = get_post_meta( get_the_ID(), 'IDMUVICORE_Numbepisode', true );
							// Check if the custom field has a value.
							if ( ! empty( $episodes ) ) {
								echo '<div class="gmr-numbeps">' . __( 'Eps:', 'muvipro' ) . '<br />';
								echo '<span>' . $episodes . '</span></div>';
							}
							?>

						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>

		<?php
		echo $args['after_widget']; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
	}

	/**
	 * Handles updating settings for the current Mailchimp widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            MuviPro_Posts_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance     = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title'              => '',
				'link_title'         => '',
				'idmuv_posttype'     => 'all',
				'idmuv_category'     => '',
				'idmuv_tag'          => '',
				'idmuv_country'      => '',
				'idmuv_year'         => '',
				'idmuv_orderby'      => 'date',
				'idmuv_number_posts' => 8,
				'idmuv_title_length' => 40,
			)
		);
		// Title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// Link Title.
		$instance['link_title'] = esc_url( $new_instance['link_title'] );
		// Post type.
		$instance['idmuv_posttype'] = esc_attr( $new_instance['idmuv_posttype'] );
		// Category Name.
		$instance['idmuv_category'] = wp_strip_all_tags( $new_instance['idmuv_category'] );
		// Tag Name.
		$instance['idmuv_tag'] = wp_strip_all_tags( $new_instance['idmuv_tag'] );
		// Country Name.
		$instance['idmuv_country'] = wp_strip_all_tags( $new_instance['idmuv_country'] );
		// Year Name.
		$instance['idmuv_year'] = wp_strip_all_tags( $new_instance['idmuv_year'] );
		// Order by.
		$instance['idmuv_orderby'] = wp_strip_all_tags( $new_instance['idmuv_orderby'] );
		// Number posts.
		$instance['idmuv_number_posts'] = absint( $new_instance['idmuv_number_posts'] );
		// Title Length.
		$instance['idmuv_title_length'] = absint( $new_instance['idmuv_title_length'] );

		return $instance;
	}

	/**
	 * Outputs the settings form for the Mailchimp widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'              => 'Recent Post',
				'link_title'         => '',
				'idmuv_posttype'     => 'all',
				'idmuv_category'     => '',
				'idmuv_tag'          => '',
				'idmuv_country'      => '',
				'idmuv_year'         => '',
				'idmuv_orderby'      => 'date',
				'idmuv_number_posts' => 8,
				'idmuv_title_length' => 40,
			)
		);
		// Title.
		$title = sanitize_text_field( $instance['title'] );
		// Link Title.
		$link_title = esc_url( $instance['link_title'] );
		// Post type.
		$idmuv_posttype = esc_attr( $instance['idmuv_posttype'] );
		// Category Name.
		$idmuv_category = wp_strip_all_tags( $instance['idmuv_category'] );
		// Tag Name.
		$idmuv_tag = wp_strip_all_tags( $instance['idmuv_tag'] );
		// Country Name.
		$idmuv_country = wp_strip_all_tags( $instance['idmuv_country'] );
		// Year Name.
		$idmuv_year = wp_strip_all_tags( $instance['idmuv_year'] );
		// Order by.
		$idmuv_orderby = wp_strip_all_tags( $instance['idmuv_orderby'] );
		// Number posts.
		$idmuv_number_posts = absint( $instance['idmuv_number_posts'] );
		// Title Length.
		$idmuv_title_length = absint( $instance['idmuv_title_length'] );

		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>"><?php esc_html_e( 'Link Title:', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'link_title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'link_title' ) ); ?>" type="url" value="<?php echo esc_attr( $link_title ); ?>" />
			<br />
			<small><?php esc_html_e( 'Target url for title (example: http://www.domain.com/target), leave blank if you want using title without link.', 'muvipro' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_posttype' ) ); ?>"><?php esc_html_e( 'Post Type:', 'muvipro' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_posttype', 'muvipro' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_posttype' ) ); ?>">
				<option value="all" <?php selected( $instance['idmuv_posttype'], 'all' ); ?>><?php esc_html_e( 'All Post (Movie & TV Shows)', 'muvipro' ); ?></option>
				<option value="movie" <?php selected( $instance['idmuv_posttype'], 'movie' ); ?>><?php esc_html_e( 'Movie', 'muvipro' ); ?></option>
				<option value="tvshows" <?php selected( $instance['idmuv_posttype'], 'tvshows' ); ?>><?php esc_html_e( 'TV Shows', 'muvipro' ); ?></option>
			</select>
			<br/>
			<small><?php esc_html_e( 'Select post type.', 'muvipro' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_category' ) ); ?>"><?php esc_html_e( 'Selected categories', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_category' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_category' ) ); ?>" type="text" value="<?php echo esc_html( $idmuv_category ); ?>" onfocus ="setSuggest_cat_recent('<?php echo esc_html( $this->get_field_id( 'idmuv_category' ) ); ?>');" />
			<br />
			<small><?php esc_html_e( 'Category Names, separated by commas. Eg: News, Home Design, Technology.', 'muvipro' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_tag' ) ); ?>"><?php esc_html_e( 'Selected tags', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_tag' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_tag' ) ); ?>" type="text" value="<?php echo esc_html( $idmuv_tag ); ?>" onfocus ="setSuggest_tag_recent('<?php echo esc_html( $this->get_field_id( 'idmuv_tag' ) ); ?>');" />
			<br />
			<small><?php esc_html_e( 'Tag Names, separated by commas. Eg: Tag 1, Tag 2, etc.', 'muvipro' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_country' ) ); ?>"><?php esc_html_e( 'Selected countries', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_country' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_country' ) ); ?>" type="text" value="<?php echo esc_html( $idmuv_country ); ?>" onfocus ="setSuggest_country_recent('<?php echo esc_html( $this->get_field_id( 'idmuv_country' ) ); ?>');" />
			<br />
			<small><?php esc_html_e( 'Country Names, separated by commas. Eg: Indonesia, India, Etc.', 'muvipro' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_year' ) ); ?>"><?php esc_html_e( 'Selected years', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_year' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_year' ) ); ?>" type="text" value="<?php echo esc_html( $idmuv_year ); ?>" onfocus ="setSuggest_year_recent('<?php echo esc_html( $this->get_field_id( 'idmuv_year' ) ); ?>');" />
			<br />
			<small><?php esc_html_e( 'Year Names, separated by commas. Eg: 2011, 2012, etc.', 'muvipro' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_orderby' ) ); ?>"><?php esc_html_e( 'Orderby', 'muvipro' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_orderby', 'muvipro' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_orderby' ) ); ?>">
				<option value="date" <?php echo selected( $instance['idmuv_orderby'], 'date', false ); ?>><?php esc_html_e( 'Date', 'muvipro' ); ?></option>
				<option value="rand" <?php echo selected( $instance['idmuv_orderby'], 'rand', false ); ?>><?php esc_html_e( 'Random', 'muvipro' ); ?></option>
				<option value="modified" <?php echo selected( $instance['idmuv_orderby'], 'modified', false ); ?>><?php esc_html_e( 'Modified', 'muvipro' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_number_posts' ) ); ?>"><?php esc_html_e( 'Number post', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $idmuv_number_posts ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_title_length' ) ); ?>"><?php esc_html_e( 'Maximum length of title', 'muvipro' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_title_length' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_title_length' ) ); ?>" type="number" value="<?php echo esc_attr( $idmuv_title_length ); ?>" />
		</p>
		<?php
	}

	/**
	 * Return the array index of a given ID
	 *
	 * @since 1.0.0
	 * @param array $arr Array.
	 * @param int   $id Post ID.
	 * @access private
	 */
	private function get_parent_index( $arr, $id ) {
		$len = count( $arr );
		if ( 0 === $len ) {
			return false;
		}
		$id = absint( $id );
		for ( $i = 0; $i < $len; $i++ ) {
			if ( $id === $arr[ $i ]['id'] ) {
				return $i;
			}
		}
		return false;
	}

	/**
	 * Returns the shortened post title, must use in a loop.
	 *
	 * @since 1.0.0
	 * @param int    $len Number text to display.
	 * @param string $more Text Button.
	 * @return string.
	 */
	private function get_the_trimmed_post_title( $len = 40, $more = '&hellip;' ) {

		// get current post's post_title.
		$post_title = get_the_title();

		// if post_title is longer than desired.
		if ( mb_strlen( $post_title ) > $len ) {
			// get post_title in desired length.
			$post_title = mb_substr( $post_title, 0, $len );
			// append ellipses.
			$post_title .= $more;
		}
		// return text.
		return $post_title;
	}

	/**
	 * Generate Tag id from Tag name
	 *
	 * @param String $tags Tag Name.
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of tag ids
	 */
	private function generate_tag_id_from_name( $tags ) {
		global $post;

		$tag_id_array = array();

		if ( ! empty( $tags ) ) {
			$tag_array = explode( ',', $tags );

			foreach ( $tag_array as $tag ) {
				$tag_id_array[] = $this->get_tag_ID( trim( $tag ) );
			}
		}

		return $tag_id_array;
	}

	/**
	 * Generate Cat id from Cat name
	 *
	 * @param String $cats Cat Name.
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of cat ids
	 */
	private function generate_cat_id_from_name( $cats ) {
		global $post;

		$cat_id_array = array();

		if ( ! empty( $cats ) ) {
			$cat_array = explode( ',', $cats );

			foreach ( $cat_array as $cat ) {
				$cat_id_array[] = $this->get_cat_ID( trim( $cat ) );
			}
		}

		return $cat_id_array;
	}

	/**
	 * Generate country id from country name
	 *
	 * @param String $countrys Country Name.
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of country ids
	 */
	private function generate_country_id_from_name( $countrys ) {
		global $post;

		$country_id_array = array();

		if ( ! empty( $countrys ) ) {
			$country_array = explode( ',', $countrys );

			foreach ( $country_array as $country ) {
				$country_id_array[] = $this->get_Country_ID( trim( $country ) );
			}
		}

		return $country_id_array;
	}

	/**
	 * Generate year id from year name
	 *
	 * @param String $years Year Name.
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of year ids
	 */
	private function generate_year_id_from_name( $years ) {
		global $post;

		$year_id_array = array();

		if ( ! empty( $years ) ) {
			$year_array = explode( ',', $years );

			foreach ( $year_array as $year ) {
				$year_id_array[] = $this->get_Year_ID( trim( $year ) );
			}
		}

		return $year_id_array;
	}

	/**
	 * Get tag id from tag name or slug
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @param string $tag_name Tag name or slug.
	 * @return int Term id. 0 if not found
	 */
	private function get_tag_ID( $tag_name ) {
		// Try tag name first.
		$tag = get_term_by( 'name', $tag_name, 'post_tag' );
		if ( $tag ) {
			return $tag->term_id;
		} else {
			// if Tag name is not found, try tag slug.
			$tag = get_term_by( 'slug', $tag_name, 'post_tag' );
			if ( $tag ) {
				return $tag->term_id;
			}
			return 0;
		}
	}

	/**
	 * Get cat id from cat name or slug
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @param string $cat_name cat name or slug.
	 * @return int Term id. 0 if not found
	 */
	private function get_cat_ID( $cat_name ) {
		// Try cat name first.
		$cat = get_term_by( 'name', $cat_name, 'category' );
		if ( $cat ) {
			return $cat->term_id;
		} else {
			// if cat name is not found, try cat slug.
			$cat = get_term_by( 'slug', $cat_name, 'category' );
			if ( $cat ) {
				return $cat->term_id;
			}
			return 0;
		}
	}

	/**
	 * Get country id from country name or slug
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @param string $country_name country name or slug.
	 * @return int Term id. 0 if not found
	 */
	private function get_Country_ID( $country_name ) {
		// Try country name first.
		$country = get_term_by( 'name', $country_name, 'muvicountry' );
		if ( $country ) {
			return $country->term_id;
		} else {
			// if country name is not found, try country slug.
			$country = get_term_by( 'slug', $country_name, 'muvicountry' );
			if ( $country ) {
				return $country->term_id;
			}
			return 0;
		}
	}

	/**
	 * Get year id from year name or slug
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @param string $year_name year name or slug.
	 * @return int Term id. 0 if not found
	 */
	private function get_Year_ID( $year_name ) {
		// Try year name first.
		$year = get_term_by( 'name', $year_name, 'muviyear' );
		if ( $year ) {
			return $year->term_id;
		} else {
			// if year name is not found, try year slug.
			$year = get_term_by( 'slug', $year_name, 'muviyear' );
			if ( $year ) {
				return $year->term_id;
			}
			return 0;
		}
	}

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'MuviPro_Posts_Widget' );
	}
);
