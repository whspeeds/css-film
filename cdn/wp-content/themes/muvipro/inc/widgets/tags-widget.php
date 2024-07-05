<?php
/**
 * Widget API: Muvipro_Tag_Widget class
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
 * Add the Tag widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Muvipro_Tag_Widget extends WP_Widget {
	/**
	 * Sets up a Recent Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'muvipro-tag-cloud',
			'description'                 => __( 'A cloud of your most used tags.', 'muvipro' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'muvipro_tag_cloud', __( 'Tag Cloud (Muvipro)', 'muvipro' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current Tag Cloud widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Tag Cloud widget instance.
	 */
	public function widget( $args, $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy( $instance );
		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' === $current_taxonomy ) {
				$title = __( 'Tags', 'muvipro' );
			} else {
				$tax   = get_taxonomy( $current_taxonomy );
				$title = $tax->labels->name;
			}
		}

		/* Number tags */
		$number_tags = ( ! empty( $instance['number_tags'] ) ) ? absint( $instance['number_tags'] ) : absint( 10 );

		/* Orderby */
		$orderby_tags = ( ! empty( $instance['orderby_tags'] ) ) ? wp_strip_all_tags( $instance['orderby_tags'] ) : wp_strip_all_tags( 'name' );

		/* Format */
		$format_tags = ( ! empty( $instance['format_tags'] ) ) ? wp_strip_all_tags( $instance['format_tags'] ) : wp_strip_all_tags( 'flat' );

		/**
		 * Filters the taxonomy used in the Tag Cloud widget.
		 *
		 * @since 1.0.0
		 * Added taxonomy drop-down.
		 *
		 * @see wp_tag_cloud()
		 *
		 * @param array $args Args used for the tag cloud widget.
		 */
		$tag_cloud = wp_tag_cloud(
			apply_filters(
				'widget_muvipro_tag_cloud_args',
				array(
					'taxonomy' => $current_taxonomy,
					'number'   => $number_tags,
					'format'   => $format_tags,
					'orderby'  => $orderby_tags,
					'echo'     => false,
				)
			)
		);

		if ( empty( $tag_cloud ) ) {
			return;
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo '<div class="tagcloud">';
			echo $tag_cloud;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo "</div>\n";
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Tag Cloud widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array(
			'orderby_tags' => 'name',
			'format_tags'  => 'flat',
			'number_tags'  => 10,
		);

		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['taxonomy'] = stripslashes( $new_instance['taxonomy'] );

		/* Number tag */
		$instance['number_tags'] = absint( $new_instance['number_tags'] );

		/* Orderby tag */
		$instance['orderby_tags'] = wp_strip_all_tags( $new_instance['orderby_tags'] );

		/* Format tag */
		$instance['format_tags'] = wp_strip_all_tags( $new_instance['format_tags'] );
		return $instance;
	}

	/**
	 * Outputs the Tag Cloud widget settings form.
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
				'orderby_tags' => 'name',
				'format_tags'  => 'flat',
				'number_tags'  => 10,
			)
		);

		$current_taxonomy  = $this->_get_current_taxonomy( $instance );
		$title_id          = $this->get_field_id( 'title' );
		$instance['title'] = ! empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		/* Number tags */
		$number_tags = absint( $instance['number_tags'] );

		/* Orderby tags */
		$orderby_tags = wp_strip_all_tags( $instance['orderby_tags'] );

		/* Format tags */
		$format_tags = wp_strip_all_tags( $instance['format_tags'] );

		echo '<p><label for="' . esc_attr( $title_id ) . '">' . esc_html__( 'Title:', 'muvipro' ) . '</label>
			<input type="text" class="widefat" id="' . esc_attr( $title_id ) . '" name="' . esc_attr( $this->get_field_name( 'title', 'muvipro' ) ) . '" value="' . esc_attr( $instance['title'] ) . '" />
		</p>';

		echo '<p>
			<label for="' . esc_attr( $this->get_field_id( 'number_tags' ) ) . '">' . esc_html__( 'Number post', 'muvipro' ) . '</label>
			<input class="widefat" id="' . esc_attr( $this->get_field_id( 'number_tags' ) ) . '" name="' . esc_attr( $this->get_field_name( 'number_tags' ) ) . '" type="number" value="' . esc_attr( $number_tags ) . '" />
		</p>';

		echo '<p>
			<label for="' . esc_attr( $this->get_field_id( 'orderby_tags' ) ) . '">' . esc_html__( 'Order By', 'muvipro' ) . '</label>
            <select class="widefat" id="' . esc_attr( $this->get_field_id( 'orderby_tags', 'muvipro' ) ) . '" name="' . esc_attr( $this->get_field_name( 'orderby_tags' ) ) . '">
				<option value="name" ' . selected( $instance['orderby_tags'], 'name', false ) . '>' . esc_html__( 'Name', 'muvipro' ) . '</option>
				<option value="count" ' . selected( $instance['orderby_tags'], 'count', false ) . '>' . esc_html__( 'Count', 'muvipro' ) . '</option>
            </select>
		</p>';

		echo '<p>
			<label for="' . esc_attr( $this->get_field_id( 'format_tags' ) ) . '">' . esc_html__( 'Style', 'muvipro' ) . '</label>
            <select class="widefat" id="' . esc_attr( $this->get_field_id( 'format_tags', 'muvipro' ) ) . '" name="' . esc_attr( $this->get_field_name( 'format_tags' ) ) . '">
				<option value="flat" ' . selected( $instance['format_tags'], 'flat', false ) . '>' . esc_html__( 'Flat', 'muvipro' ) . '</option>
				<option value="list" ' . selected( $instance['format_tags'], 'list', false ) . '>' . esc_html__( 'List', 'muvipro' ) . '</option>
            </select>
		</p>';

		$taxonomies = get_taxonomies( array( 'show_tagcloud' => true ), 'object' );
		$id         = $this->get_field_id( 'taxonomy' );
		$name       = $this->get_field_name( 'taxonomy' );
		$input      = '<input type="hidden" id="' . $id . '" name="' . $name . '" value="%s" />';

		switch ( count( $taxonomies ) ) {
			/* No tag cloud supporting taxonomies found, display error message */
			case 0:
				echo '<p>' . esc_html__( 'The tag cloud will not be displayed since there are no taxonomies that support the tag cloud widget.', 'muvipro' ) . '</p>';
				printf( $input, '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				break;

			/* Just a single tag cloud supporting taxonomy found, no need to display options */
			case 1:
				$keys     = array_keys( $taxonomies );
				$taxonomy = reset( $keys );
				printf( $input, esc_attr( $taxonomy ) );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				break;

			/* More than one tag cloud supporting taxonomy found, display options */
			default:
				printf(
					'<p><label for="%1$s">%2$s</label>' .
					'<select class="widefat" id="%1$s" name="%3$s">',
					esc_html( $id ),
					esc_html__( 'Taxonomy:', 'muvipro' ),
					esc_html( $name )
				);

				foreach ( $taxonomies as $taxonomy => $tax ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $taxonomy ),
						selected( $taxonomy, $current_taxonomy, false ),
						$tax->labels->name  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					);
				}

				echo '</select></p>';
		}
	}

	/**
	 * Retrieves the taxonomy for the current Tag cloud widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 * @return string Name of the current taxonomy if set, otherwise 'post_tag'.
	 */
	public function _get_current_taxonomy( $instance ) {
		if ( ! empty( $instance['taxonomy'] ) && taxonomy_exists( $instance['taxonomy'] ) ) {
			return $instance['taxonomy'];
		} else {
			return 'post_tag';
		}
	}
}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Muvipro_Tag_Widget' );
	}
);
