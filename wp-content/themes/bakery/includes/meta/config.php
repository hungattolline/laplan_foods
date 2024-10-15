<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! function_exists( 'bakery_save_meta_box' ) ) {
	function bakery_save_meta_box( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( ! isset($_POST['vu_field'] ) || empty( $_POST['vu_field'] ) || ! wp_verify_nonce( $_POST['vu_metabox_nonce'], 'vu_metabox_nonce' ) ) {
			return;
		}

		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		foreach ( $_POST['vu_field'] as $key => $value ) {
			bakery_update_post_meta( $post_id, $key, $value );
		}
	}
}

add_action( 'save_post', 'bakery_save_meta_box' );

// Update Post Meta Data
if ( ! function_exists( 'bakery_update_post_meta' ) ) {
	function bakery_update_post_meta( $post_id, $meta_key, $meta_value, $prev_value = null ) {
		if ( is_array( $meta_value ) ) {
			$meta_value = bakery_json_encode( $meta_value );
		}

		$meta_value = apply_filters( 'bakery/post_meta/set', $meta_value, $meta_key, $post_id );

		$meta_value = apply_filters( 'bakery/post_meta/set/' . $meta_key, $meta_value, $post_id );

		update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );
	}
}

// Get Post Meta Data
if ( ! function_exists( 'bakery_get_post_meta' ) ) {
	function bakery_get_post_meta( $post_id, $key, $json = true ) {
		$data = get_post_meta( $post_id, $key, true );

		if ( $json ) {
			$data = bakery_json_decode( $data );
		}

		$data = apply_filters( 'bakery/post_meta/get', $data, $key, $post_id );

		$data = apply_filters( 'bakery/post_meta/get/' . $key, $data, $post_id );

		return $data;
	}
}

// JSON Encode
if ( ! function_exists( 'bakery_json_encode' ) ) {
	function bakery_json_encode( $array ) {
		return wp_slash( json_encode( $array ) );
	}
}

// JSON Decode
if ( ! function_exists( 'bakery_json_decode' ) ) {
	function bakery_json_decode( $json ) {
		return ( ! empty( $json ) ) ? wp_unslash( json_decode( $json, true ) ) : false;
	}
}
