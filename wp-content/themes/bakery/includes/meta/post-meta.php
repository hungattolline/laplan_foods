<?php if ( ! defined( 'ABSPATH' ) ) exit();

add_action( 'add_meta_boxes', 'bakery_post_format_settings_meta_box' );

if ( ! function_exists( 'bakery_post_format_settings_meta_box' ) ) {
	function bakery_post_format_settings_meta_box() {
		add_meta_box(
			'vu_post-format-settings',
			esc_html__( 'Post Format Settings', 'bakery' ),
			'bakery_post_format_settings_meta_box_content',
			'post',
			'normal',
			'core'
		);
	}
}

add_filter( 'bakery/post_meta/get/bakery_post_format_settings', 'bakery_post_format_settings_defaults' );

if ( ! function_exists( 'bakery_post_format_settings_defaults' ) ) {
	function bakery_post_format_settings_defaults( $data ) {
		$data = wp_parse_args( (array) $data, array(
			'audio' => array(
				'mp3-file-url' => '',
				'oga-file-url' => ''
			),
			'video' => array(
				'm4v' => '',
				'ogg' => '',
				'poster' => '',
				'embed-code' => ''
			),
			'gallery' => array(
				'images' => ''
			),
			'link' => array(
				'url' => ''
			),
			'quote' => array(
				'content' => '',
				'author' => ''
			),
			'aside' => array(
				'content' => ''
			)
		) );

		return $data;
	}
}

if ( ! function_exists( 'bakery_post_format_settings_meta_box_content' ) ) {
	function bakery_post_format_settings_meta_box_content() {
		global $post;

		$bakery_post_format_settings = bakery_get_post_meta( $post->ID, 'bakery_post_format_settings' );

		wp_nonce_field( 'vu_metabox_nonce', 'vu_metabox_nonce' ); ?>
		
		<!-- Audio Settings -->
		<div class="vu_metabox-container" data-format="audio">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label for="vu_field_audio-mp3-file-url"><?php esc_html_e( 'MP3 File URL', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Please enter in the URL to the .mp3 file', 'bakery' ); ?></span>
					</td>
					<td><input id="vu_field_audio-mp3-file-url" name="vu_field[bakery_post_format_settings][audio][mp3-file-url]" class="regular-text" type="text" value="<?php echo esc_url( $bakery_post_format_settings['audio']['mp3-file-url'] ); ?>" /></td>
				</tr>
				<tr>
					<td scope="row">
						<label for="vu_field_audio-oga-file-url"><?php esc_html_e( 'OGA File URL', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Please enter in the URL to the .ogg or .oga file', 'bakery' ); ?></span>
					</td>
					<td><input id="vu_field_audio-oga-file-url" name="vu_field[bakery_post_format_settings][audio][oga-file-url]" class="regular-text" type="text" value="<?php echo esc_url( $bakery_post_format_settings['audio']['oga-file-url'] ); ?>" /></td>
				</tr>
			</table>
		</div>
		<!-- /Audio Settings -->
		
		<!-- Video Settings -->
		<div class="vu_metabox-container" data-format="video">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label for="vu_field_video-m4v"><?php esc_html_e( 'M4V File URL', 'bakery' ); ?></label>
						<span class="vu_desc"><?php echo wp_kses( __( 'Please upload the .m4v video file.<br><b>You must include both formats.</b>', 'bakery' ), array( 'br' => array(), 'b' => array() ) ); ?></span>
					</td>
					<td>
						<input id="vu_field_video-m4v" name="vu_field[bakery_post_format_settings][video][m4v]" class="regular-text" style="margin: 0 0 10px 0;" type="text" value="<?php echo esc_url( $bakery_post_format_settings['video']['m4v'] ); ?>" /><br>
						<a href="#" data-input="vu_field_video-m4v" data-title="<?php esc_attr_e( 'Choose a File', 'bakery' ); ?>" data-button="<?php esc_attr_e( 'Select File', 'bakery' ); ?>" data-type="video" class="vu_open-media button button-default"><?php esc_html_e( 'Add Media', 'bakery' ); ?></a>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label for="vu_field_video-ogg"><?php esc_html_e( 'OGV File URL', 'bakery' ); ?></label>
						<span class="vu_desc"><?php echo wp_kses( __( 'Please upload the .ogv video file<br><b>You must include both formats.</b>', 'bakery' ), array( 'br' => array(), 'b' => array() ) ); ?></span>
					</td>
					<td>
						<input id="vu_field_video-ogg" name="vu_field[bakery_post_format_settings][video][ogg]" class="regular-text" style="margin: 0 0 10px 0;" type="text" value="<?php echo esc_url( $bakery_post_format_settings['video']['ogg'] ); ?>" /><br>
						<a href="#" data-input="vu_field_video-ogg" data-title="<?php esc_attr_e( 'Choose a File', 'bakery' ); ?>" data-button="<?php esc_attr_e( 'Select File', 'bakery' ); ?>" data-type="video" class="vu_open-media button button-default"><?php esc_html_e( 'Add Media', 'bakery' ); ?></a>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label for=""><?php esc_html_e( 'Preview Image', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Image should be at least 680px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted videos.', 'bakery' ); ?></span>
					</td>
					<td>
						<img id="vu_img_video-poster" class="vu_media-img" src="<?php echo esc_url( $bakery_post_format_settings['video']['poster'] ); ?>">
						<input id="vu_field_video-poster" name="vu_field[bakery_post_format_settings][video][poster]" class="regular-text" type="hidden" value="<?php echo esc_url( $bakery_post_format_settings['video']['poster'] ); ?>" />
						<a href="#" data-input="vu_field_video-poster" data-img="vu_img_video-poster" data-title="<?php esc_attr_e( 'Add Image', 'bakery' ); ?>" data-button="<?php esc_attr_e( 'Add Image', 'bakery' ); ?>" class="vu_open-media button button-default"><?php esc_html_e( 'Upload', 'bakery' ); ?></a>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label for="vu_field_video-embed-code"><?php esc_html_e( 'Embedded Code', 'bakery' ); ?></label>
						<span class="vu_desc"><?php echo wp_kses( __( 'If the video is an embed rather than self hosted, enter in a Vimeo or Youtube embed code here. <b>Embeds work worse with the parallax effect, but if you must use this, Vimeo is recommended.</b>', 'bakery' ), array( 'b' => array() ) ); ?></span>
					</td>
					<td>
						<textarea name="vu_field[bakery_post_format_settings][video][embed-code]" id="vu_field_video-embed-code" rows="7"><?php echo esc_url( $bakery_post_format_settings['video']['embed-code'] ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<!-- Video Settings -->
		
		<!-- Gallery Settings -->
		<div class="vu_metabox-container" data-format="gallery">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label><?php esc_html_e( 'Gallery', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Click the "Upload" button to begin uploading your images, followed by "Add Images" once you have made your selection.', 'bakery' ); ?></span>
					</td>
					<td>
						<div id="vu_img_gallery-images" data-input="vu_field_gallery-images" class="vu_media-images">
							<?php 
								$gallery_images = ! empty( $bakery_post_format_settings['gallery']['images'] ) ? explode( ',', $bakery_post_format_settings['gallery']['images'] ) : '';

								if ( ! empty( $gallery_images ) ) {
									foreach ( $gallery_images as $img_id ) {
										echo '<div><img data-id="' . absint( $img_id ) . '" src="' . bakery_get_attachment_image_src( $img_id ) . '"><span>&times;</span></div>';
									}
								}
							?>
						</div>

						<input id="vu_field_gallery-images" name="vu_field[bakery_post_format_settings][gallery][images]" class="regular-text" type="hidden" value="<?php echo esc_attr( $bakery_post_format_settings['gallery']['images'] ); ?>" />
						<a href="#" data-input="vu_field_gallery-images" data-title="<?php esc_attr_e( 'Add Images', 'bakery' ); ?>" data-button="<?php esc_attr_e( 'Add Images', 'bakery' ); ?>" data-img="vu_img_gallery-images" class="vu_open-media multiple button button-default"><?php esc_html_e( 'Upload', 'bakery' ); ?></a>
					</td>
				</tr>
			</table>
		</div>
		<!-- Gallery Settings -->
		
		<!-- Link Settings -->
		<div class="vu_metabox-container" data-format="link">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label for="vu_field_link-url"><?php esc_html_e( 'Link URL', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Please input the URL for your link. I.e. https://milingona.co', 'bakery' ); ?></span>
					</td>
					<td><input id="vu_field_link-url" name="vu_field[bakery_post_format_settings][link][url]" class="regular-text" type="text" value="<?php echo esc_url( $bakery_post_format_settings['link']['url'] ); ?>" /></td>
				</tr>
			</table>
		</div>
		<!-- /Link Settings -->
		
		<!-- Quote Settings -->
		<div class="vu_metabox-container" data-format="quote">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label for="vu_field_quote-content"><?php esc_html_e( 'Quote Content', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Please type the text for your quote here.', 'bakery' ); ?></span>
					</td>
					<td>
						<textarea name="vu_field[bakery_post_format_settings][quote][content]" id="vu_field_quote-content" class="regular-text" rows="7"><?php echo esc_html( $bakery_post_format_settings['quote']['content'] ); ?></textarea>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label for="vu_field_quote-author"><?php esc_html_e( 'Quote Author', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Please input the author qoute.', 'bakery' ); ?></span>
					</td>
					<td><input id="vu_field_quote-author" name="vu_field[bakery_post_format_settings][quote][author]" class="regular-text" type="text" value="<?php echo esc_attr( $bakery_post_format_settings['quote']['author'] ); ?>" /></td>
				</tr>
			</table>
		</div>
		<!-- /Quote Settings -->
		
		<!-- Aside Settings -->
		<div class="vu_metabox-container" data-format="aside">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label for="vu_field_aside-content"><?php esc_html_e( 'Aside Content', 'bakery' ); ?></label>
						<span class="vu_desc"><?php esc_html_e( 'Please type the text for your aside here.', 'bakery' ); ?></span>
					</td>
					<td>
						<textarea name="vu_field[bakery_post_format_settings][aside][content]" id="vu_field_aside-content" class="regular-text" rows="5"><?php echo esc_html( $bakery_post_format_settings['aside']['content'] ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<!-- /Aside Settings -->
	<?php
	}
}
