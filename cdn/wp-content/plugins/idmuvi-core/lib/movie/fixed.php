<?php
/**
 * Fixed New Wordpress Version
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gmr_category_checklist_fixed( $args, $post_id ) {
    if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'category' ) {
        if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) {
            if ( ! class_exists( 'GMR_Category_Checklist_Fixed' ) ) {
                class GMR_Category_Checklist_Fixed extends Walker_Category_Checklist {
                    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
						if ( empty( $args['taxonomy'] ) ) {
							$taxonomy = 'category';
						} else {
							$taxonomy = $args['taxonomy'];
						}

						if ( 'category' === $taxonomy ) {
							$name = 'post_category';
						} else {
							$name = 'tax_input[' . $taxonomy . ']';
						}

						$args['popular_cats'] = empty( $args['popular_cats'] ) ? array() : $args['popular_cats'];
						$class                = in_array( $category->term_id, $args['popular_cats'] ) ? ' class="popular-category"' : '';

						$args['selected_cats'] = empty( $args['selected_cats'] ) ? array() : $args['selected_cats'];

						if ( ! empty( $args['list_only'] ) ) {
							$aria_checked = 'false';
							$inner_class  = 'category';

							if ( in_array( $category->term_id, $args['selected_cats'] ) ) {
								$inner_class .= ' selected';
								$aria_checked = 'true';
							}

							$output .= "\n" . '<li' . $class . '>' .
								'<div class="' . $inner_class . '" data-term-id=' . $category->term_id .
								' tabindex="0" role="checkbox" aria-checked="' . $aria_checked . '">' .
								/** This filter is documented in wp-includes/category-template.php */
								esc_html( apply_filters( 'the_category', $category->name, '', '' ) ) . '</div>';
						} else {
							$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" .
								'<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' .
								checked( in_array( $category->term_id, $args['selected_cats'] ), true, false ) .
								disabled( empty( $args['disabled'] ), false, false ) . ' /> ' .
								/** This filter is documented in wp-includes/category-template.php */
								esc_html( apply_filters( 'the_category', $category->name, '', '' ) ) . '</label>';
						}
                    }
                }
            }
            $args['walker'] = new GMR_Category_Checklist_Fixed;
        }
    }
    return $args;
}

if ( is_admin() ) {
	// Add filter.
	add_filter( 'wp_terms_checklist_args', 'gmr_category_checklist_fixed', 10, 2 );
}
