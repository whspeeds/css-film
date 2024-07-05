<?php
/**
 * Add Simple Metaboxes Settings
 *
 * @package Muvipro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a meta box using a class.
 *
 * @since 1.0.0
 */
class GMR_Metabox_Settings {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box.
	 *
	 * @param string $post_type Post Type.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'page' );
		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box(
				'gmr_header_metabox',
				__( 'Theme Settings', 'muvipro' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'side',
				'low'
			);
		}
	}

	/**
	 * Save the meta box.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return int $post_id
	 */
	public function save( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['gmr_customattribute_cat_nonce'] ) ) {
			return $post_id;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST['gmr_customattribute_cat_nonce'] ) );

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'gmr_customattribute_cat' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		// Sanitize the user input using boolean.
		$mydata = isset( $_POST['catmode_field'] ) ? (int) $_POST['catmode_field'] : '';

		// Update the meta field.
		update_post_meta( $post_id, '_catmode', $mydata );
	}

	/**
	 * Renders the meta box.
	 *
	 * @param string $post Post Object.
	 *
	 * @return void
	 */
	public function render_meta_box_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'gmr_customattribute_cat', 'gmr_customattribute_cat_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$saved_cat = get_post_meta( $post->ID, '_catmode', true );
		?>
		<p>
			<select name="catmode_field">
				<option value=""><?php echo esc_attr( __( 'Select category', 'muvipro' ) ); ?></option>
				<?php
					$categories     = get_categories();
					$select_options = '';
				foreach ( $categories as $category ) {
					$option          = '<option value="' . $category->cat_ID . '">';
					$option         .= $category->cat_name;
					$option         .= '</option>';
					$select_options .= $option;
				}
					// set saved data as selected.
					$select_options = str_replace( 'value="' . $saved_cat . '"', 'value="' . $saved_cat . '" selected="selected"', $select_options );
					echo $select_options;
				?>
			</select>
		</p>
		<p><?php esc_html_e( 'Please select category if you using page attribute, best rating, order by date, modified, title or year.', 'muvipro' ); ?></p>

		<?php
	}
}


/**
 * Load class GMR_Metabox_Settings
 */
function gmr_metaboxes_settings_init() {
	new GMR_Metabox_Settings();
}

// Load only if dashboard.
if ( is_admin() ) {
	add_action( 'load-post.php', 'gmr_metaboxes_settings_init' );
	add_action( 'load-post-new.php', 'gmr_metaboxes_settings_init' );
}
