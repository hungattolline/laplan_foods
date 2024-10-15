<?php if ( ! defined('ABSPATH' ) ) exit();

add_action( 'add_meta_boxes', 'bakery_page_header_settings_meta_box' );

if ( ! function_exists( 'bakery_page_header_settings_meta_box' ) ) {
	function bakery_page_header_settings_meta_box() {
		add_meta_box(
			'vu_page-header-settings',
			esc_html__( 'Page Header Settings', 'bakery' ),
			'bakery_page_header_settings_meta_box_content',
			'page',
			'normal',
			'core'
		);
	}
}

add_filter( 'bakery/post_meta/get/bakery_page_header_settings', 'bakery_page_header_settings_defaults' );

if ( ! function_exists( 'bakery_page_header_settings_defaults' ) ) {
	function bakery_page_header_settings_defaults( $data ) {
		$data = wp_parse_args( (array) $data, array(
			'transparent' => 'inherit',
			'show' => 'inherit',
			'style' => 'inherit',
			'breadcrumbs' => array(
				'show' => 'inherit',
				'content' => ''
			),
			'title' => '',
			'subtitle' => '',
			'height' => '',
			'height' => '',
			'bg' => '',
			'parallax' => 'inherit',
			'color-overlay' => ''
		) );

		if ( ! is_array( $data['breadcrumbs'] ) ) {
			$data['breadcrumbs'] = array(
				'show' => ( ( $data['breadcrumbs'] == 'inherit' ) ? 'inherit' : ( ( $data == 'yes' ) ? 'no' : 'yes' ) ),
				'content' => ''
			);
		}

		return $data;
	}
}

if ( ! function_exists( 'bakery_page_header_settings_meta_box_content' ) ) {
	function bakery_page_header_settings_meta_box_content() {
		global $post;

		$bakery_page_header_settings = bakery_get_post_meta( $post->ID, 'bakery_page_header_settings' );

		wp_nonce_field( 'vu_metabox_nonce', 'vu_metabox_nonce' ); ?>

		<div class="vu_metabox-container">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label><?php esc_html_e( 'Make Transparent?', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Select whether or not to make header area transparent.', 'bakery' ); ?></span>
					</td>
					<td>
						<label for="vu_field_header-transparent-yes" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][transparent]" id="vu_field_header-transparent-yes" value="yes" <?php echo ( empty( $bakery_page_header_settings['transparent'] ) || $bakery_page_header_settings['transparent'] == 'yes' ) ? 'checked="checked"' : ''; ?>><?php esc_html_e( 'Yes', 'bakery' ); ?></label>
						<label for="vu_field_header-transparent-no" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][transparent]" id="vu_field_header-transparent-no" value="no" <?php echo ( empty( $bakery_page_header_settings['transparent'] ) || $bakery_page_header_settings['transparent'] == 'no' ) ? 'checked="checked"' : ''; ?>><?php esc_html_e( 'No', 'bakery' ); ?></label>
						<label for="vu_field_header-transparent-inherit" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][transparent]" id="vu_field_header-transparent-inherit" value="inherit" <?php echo ( empty( $bakery_page_header_settings['transparent'] ) || $bakery_page_header_settings['transparent'] == 'inherit' ) ? 'checked="checked"' : ''; ?>><?php esc_html_e( 'Inherit from Theme Options', 'bakery' ); ?></label>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label><?php esc_html_e( 'Show Page Header?', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Select whether or not to show page header.', 'bakery' ); ?></span>
					</td>
					<td>
						<label for="vu_field_header-show-yes" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][show]" id="vu_field_header-show-yes" value="yes" <?php echo trim( ( $bakery_page_header_settings['show'] == 'yes' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'Yes', 'bakery' ); ?></label>
						<label for="vu_field_header-show-no" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][show]" id="vu_field_header-show-no" value="no" <?php echo trim( ( $bakery_page_header_settings['show'] == 'no' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'No', 'bakery' ); ?></label>
						<label for="vu_field_header-show-inherit" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][show]" id="vu_field_header-show-inherit" value="inherit" data-value="<?php echo trim( ( bakery_get_option( 'page-header-show' ) == '1' ) ? 'yes' : 'no' ); ?>" <?php echo trim( ( $bakery_page_header_settings['show'] == 'inherit' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'Inherit from Theme Options', 'bakery' ); ?></label>
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][show]" data-value="yes">
					<td scope="row">
						<label for="vu_field_header-style"><?php esc_html_e( 'Style', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Select page header style.', 'bakery' ); ?></span>
					</td>
					<td>
						<select name="vu_field[bakery_page_header_settings][style]" id="vu_field_header-style">
							<option value="inherit" data-value="<?php echo esc_attr( bakery_get_option( 'page-header-style' ) ); ?>"<?php echo trim( ( $bakery_page_header_settings['style'] == 'inherit' ) ? ' selected="selected"' : '' ); ?>><?php esc_html_e( 'Inherit from Theme Options', 'bakery' ); ?></option>
							<option value="1"<?php echo trim( ( $bakery_page_header_settings['style'] == '1' ) ? ' selected="selected"' : '' ); ?>><?php esc_html_e( 'Style 1', 'bakery' ); ?></option>
							<option value="2"<?php echo trim( ( $bakery_page_header_settings['style'] == '2' ) ? ' selected="selected"' : '' ); ?>><?php esc_html_e( 'Style 2', 'bakery' ); ?></option>
						</select>
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][show]" data-value="yes">
					<td scope="row">
						<label for="vu_field_header-title"><?php esc_html_e( 'Title', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Enter page header title. Page name will be shown by default.', 'bakery' ); ?></span>
					</td>
					<td>
						<input id="vu_field_header-title" name="vu_field[bakery_page_header_settings][title]" class="regular-text" type="text" value="<?php echo esc_attr( $bakery_page_header_settings['title'] ); ?>" />
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][style]" data-value="2">
					<td scope="row">
						<label for="vu_field_header-subtitle"><?php esc_html_e( 'Subtitle', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Enter page header subtitle.', 'bakery' ); ?></span>
					</td>
					<td>
						<input id="vu_field_header-subtitle" name="vu_field[bakery_page_header_settings][subtitle]" class="regular-text" type="text" value="<?php echo esc_attr( $bakery_page_header_settings['subtitle'] ); ?>" />
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][style]" data-value="1">
					<td scope="row">
						<label><?php esc_html_e( 'Show Breadcrumbs?', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Select whether or not to show breadcrumbs.', 'bakery' ); ?></span>
					</td>
					<td>
						<label for="vu_field_header-breadcrumbs-show-yes" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][breadcrumbs][show]" id="vu_field_header-breadcrumbs-show-yes" value="yes" <?php echo trim( ( $bakery_page_header_settings['breadcrumbs']['show'] == 'yes' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'Yes', 'bakery' ); ?></label>
						<label for="vu_field_header-breadcrumbs-show-no" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][breadcrumbs][show]" id="vu_field_header-breadcrumbs-show-no" value="no" <?php echo trim( ( $bakery_page_header_settings['breadcrumbs']['show'] == 'no' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'No', 'bakery' ); ?></label>
						<label for="vu_field_header-breadcrumbs-show-inherit" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][breadcrumbs][show]" id="vu_field_header-breadcrumbs-show-inherit" value="inherit" data-value="<?php echo trim( ( bakery_get_option( 'page-header-breadcrumbs-show', true ) == true ) ? 'yes' : 'no' ); ?>" <?php echo trim( ( $bakery_page_header_settings['breadcrumbs']['show'] == 'inherit' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'Inherit from Theme Options', 'bakery' ); ?></label>
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][breadcrumbs][show]" data-value="yes">
					<td scope="row">
						<label for="vu_field_header-title"><?php esc_html_e( 'Breadcrumbs Content', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Enter custom breadcrumbs content. Breadcrumbs content specified from theme options will be shown by default.', 'bakery' ); ?></span>
					</td>
					<td>
						<input id="vu_field_header-title" name="vu_field[bakery_page_header_settings][breadcrumbs][content]" class="regular-text" type="text" value="<?php echo esc_attr( $bakery_page_header_settings['breadcrumbs']['content'] ); ?>" />
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][show]" data-value="yes">
					<td scope="row">
						<label for="vu_field_header-height"><?php esc_html_e( 'Height', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Enter page header height in pixels. Height specified from theme options will be applied by default.', 'bakery' ); ?></span>
					</td>
					<td>
						<input id="vu_field_header-height" name="vu_field[bakery_page_header_settings][height]" class="regular-text" type="text" value="<?php echo esc_attr( $bakery_page_header_settings['height'] ); ?>" />
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][show]" data-value="yes">
					<td scope="row">
						<label><?php esc_html_e( 'Background Image', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Upload page header background image. The image should have minimum 1200px width and 300px height for best results.', 'bakery' ); ?></span>
					</td>
					<td>
						<img id="vu_img_header-bg" class="vu_media-img" src="<?php echo bakery_get_attachment_image_src( $bakery_page_header_settings['bg'], 'full' ); ?>">
						<input id="vu_field_header-bg" name="vu_field[bakery_page_header_settings][bg]" class="regular-text" type="hidden" value="<?php echo absint( $bakery_page_header_settings['bg'] ); ?>" />
						<a href="#" data-input="vu_field_header-bg" data-img="vu_img_header-bg" data-title="<?php esc_attr_e( 'Add Image', 'bakery' ); ?>" data-button="<?php esc_attr_e( 'Add Image', 'bakery' ); ?>" class="vu_open-media button button-default"><?php esc_html_e( 'Upload', 'bakery' ); ?></a>
						<a href="#" data-input="vu_field_header-bg" data-img="vu_img_header-bg" class="vu_remove-media button button-default"><?php esc_html_e( 'Remove', 'bakery' ); ?></a>
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][show]" data-value="yes">
					<td scope="row">
						<label><?php esc_html_e( 'Parallax Effect?', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Select whether or not to enable parallax effect on page header background image.', 'bakery' ); ?></span>
					</td>
					<td>
						<label for="vu_field_header-parallax-yes" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][parallax]" id="vu_field_header-parallax-yes" value="yes" <?php echo trim( ( $bakery_page_header_settings['parallax'] == 'yes' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'Yes', 'bakery' ); ?></label>
						<label for="vu_field_header-parallax-no" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][parallax]" id="vu_field_header-parallax-no" value="no" <?php echo trim( ( $bakery_page_header_settings['parallax'] == 'no' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'No', 'bakery' ); ?></label>
						<label for="vu_field_header-parallax-inherit" style="margin-right: 15px;"><input type="radio" name="vu_field[bakery_page_header_settings][parallax]" id="vu_field_header-parallax-inherit" value="inherit" <?php echo trim( ( $bakery_page_header_settings['parallax'] == 'inherit' ) ? 'checked="checked"' : '' ); ?>><?php esc_html_e( 'Inherit from Theme Options', 'bakery' ); ?></label>
					</td>
				</tr>
				<tr class="vu_dependency" data-element="vu_field[bakery_page_header_settings][show]" data-value="yes">
					<td scope="row">
						<label for="vu_field_header-color-overlay"><?php esc_html_e( 'Color Overlay', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Select page header color overlay. Color specified from theme options will be applied by default.', 'bakery' ); ?></span>
					</td>
					<td>
						<input id="vu_field_header-color-overlay" name="vu_field[bakery_page_header_settings][color-overlay]" class="vu_colorpicker" type="text" value="<?php echo esc_attr( $bakery_page_header_settings['color-overlay'] ); ?>" />
					</td>
				</tr>
			</table>
		</div>
	<?php
	}
}
