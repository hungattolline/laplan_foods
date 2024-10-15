<?php if ( ! defined( 'ABSPATH' ) ) exit();

add_action( 'add_meta_boxes', 'bakery_page_sidebar_meta_box' );

if ( ! function_exists( 'bakery_page_sidebar_meta_box' ) ) {
	function bakery_page_sidebar_meta_box() {
		add_meta_box(
			'vu_page-sidebar',
			esc_html__( 'Page Sidebar', 'bakery' ),
			'bakery_page_sidebar_meta_box_content',
			'page',
			'side',
			'core'
		);
	}
}

add_filter( 'bakery/post_meta/get/bakery_page_sidebar', 'bakery_page_sidebar_defaults' );

if ( ! function_exists( 'bakery_page_sidebar_defaults' ) ) {
	function bakery_page_sidebar_defaults( $data ) {
		$data = wp_parse_args( (array) $data, array(
			'sidebar' => '',
			'layout' => '3',
			'position' => 'right'
		) );

		return $data;
	}
}

if ( ! function_exists( 'bakery_page_sidebar_meta_box_content' ) ) {
	function bakery_page_sidebar_meta_box_content() {
		global $post;

		$bakery_page_sidebar = bakery_get_post_meta( $post->ID, 'bakery_page_sidebar' );

		wp_nonce_field( 'vu_metabox_nonce', 'vu_metabox_nonce' ); ?>

		<div class="vu_metabox-container">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label for="vu_field_sidebar"><?php esc_html_e( 'Sidebar', 'bakery' ); ?></label>
						
						<select id="vu_field_sidebar" name="vu_field[bakery_page_sidebar][sidebar]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo esc_attr( $bakery_page_sidebar['sidebar'] ); ?>">
							<option value=""><?php esc_html_e( 'No Sidebar', 'bakery' ); ?></option>
							<?php 
								foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
									echo '<option value="' . esc_attr( $sidebar['id'] ) . '">' . esc_html( $sidebar['name'] ) . '</option>';
								}
							?>
						</select>

						<span class="vu_desc"><?php esc_html_e( 'Select page sidebar.', 'bakery' ); ?></span>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label for="vu_field_layout"><?php esc_html_e( 'Layout', 'bakery' ); ?></label>

						<select id="vu_field_layout" name="vu_field[bakery_page_sidebar][layout]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo esc_attr( $bakery_page_sidebar['layout'] ); ?>">
							<option value="4">1/3</option>
							<option value="3">1/4</option>
						</select>

						<span class="vu_desc"><?php esc_html_e( 'Select sidebar layout.', 'bakery' ); ?></span>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label for="vu_field_position"><?php esc_html_e( 'Position', 'bakery' ); ?></label>

						<select id="vu_field_position" name="vu_field[bakery_page_sidebar][position]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo esc_attr( $bakery_page_sidebar['position'] ); ?>">
							<option value="left"><?php esc_html_e( 'Left', 'bakery' ); ?></option>
							<option value="right"><?php esc_html_e( 'Right', 'bakery' ); ?></option>
						</select>

						<span class="vu_desc"><?php esc_html_e( 'Select sidebar positon.', 'bakery' ); ?></span>
					</td>
				</tr>
			</table>
		</div>
	<?php
	}
}
