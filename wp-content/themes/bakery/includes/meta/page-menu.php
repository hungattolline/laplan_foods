<?php if ( ! defined( 'ABSPATH' ) ) exit();

add_action( 'add_meta_boxes', 'bakery_page_menu_meta_box' );

if ( ! function_exists( 'bakery_page_menu_meta_box' ) ) {
	function bakery_page_menu_meta_box() {
		add_meta_box(
			'vu_page-menu',
			esc_html__( 'Page Menu', 'bakery' ),
			'bakery_page_menu_meta_box_content',
			'page',
			'side',
			'core'
		);
	}
}

add_filter( 'bakery/post_meta/get/bakery_page_menu', 'bakery_page_menu_defaults' );

if ( ! function_exists( 'bakery_page_menu_defaults' ) ) {
	function bakery_page_menu_defaults( $data ) {
		$data = wp_parse_args( (array) $data, array(
			'menu-full' => '',
			'menu-left' => '',
			'menu-right' => ''
		) );

		return $data;
	}
}

if ( ! function_exists( 'bakery_page_menu_meta_box_content' ) ) {
	function bakery_page_menu_meta_box_content() {
		global $post;

		$bakery_page_menu = bakery_get_post_meta( $post->ID, 'bakery_page_menu' );

		$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

		$registered_menus = get_registered_nav_menus();

		wp_nonce_field( 'vu_metabox_nonce', 'vu_metabox_nonce' ); ?>

		<div class="vu_metabox-container">
			<table class="form-table vu_metabox-table">
				<tr class="vu_bt-none">
					<td scope="row">
						<label for="vu_field_menu-full"><?php esc_html_e( 'Full Menu', 'bakery' ); ?></label>
						
						<select id="vu_field_menu-full" name="vu_field[bakery_page_menu][menu-full]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo esc_attr( $bakery_page_menu['menu-full'] ); ?>">
							<option value=""><?php esc_html_e( 'Default Menu', 'bakery' ); ?></option>
							<?php 
								foreach ( $menus as $menu ) {
									if ( $registered_menus['main-menu-full'] != $menu->name ) {
										echo '<option value="' . absint( $menu->term_id  ). '">' . esc_html( $menu->name ) . '</option>';
									}
								}
							?>
						</select>

						<div class="clear" style="margin-bottom: 10px;"></div>
						
						<label for="vu_field_menu-left"><?php esc_html_e( 'Left Menu', 'bakery' ); ?></label>
						
						<select id="vu_field_menu-left" name="vu_field[bakery_page_menu][menu-left]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo esc_attr( $bakery_page_menu['menu-left'] ); ?>">
							<option value=""><?php esc_html_e( 'Default Menu', 'bakery' ); ?></option>
							<?php 
								foreach ( $menus as $menu ) {
									if ( $registered_menus['main-menu-left'] != $menu->name ) {
										echo '<option value="' . absint( $menu->term_id  ). '">' . esc_html( $menu->name ) . '</option>';
									}
								}
							?>
						</select>

						<div class="clear" style="margin-bottom: 10px;"></div>

						<label for="vu_field_menu-right"><?php esc_html_e( 'Right Menu', 'bakery' ); ?></label>
						
						<select id="vu_field_menu-right" name="vu_field[bakery_page_menu][menu-right]" class="regular-text vu_select-change" style="width: 100%; margin: 5px 0;" data-value="<?php echo esc_attr( $bakery_page_menu['menu-right'] ); ?>">
							<option value=""><?php esc_html_e( 'Default Menu', 'bakery' ); ?></option>
							<?php 
								foreach ( $menus as $menu ) {
									if ( $registered_menus['main-menu-right'] != $menu->name ) {
										echo '<option value="' . absint( $menu->term_id  ). '">' . esc_html( $menu->name ) . '</option>';
									}
								}
							?>
						</select>

						<span class="vu_desc"><?php esc_html_e( 'Select page menu if you want to display other menu instead of default one.', 'bakery' ); ?></span>
					</td>
				</tr>
			</table>
		</div>
	<?php
	}
}
