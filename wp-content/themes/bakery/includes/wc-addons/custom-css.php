<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! function_exists( 'bakery_wc_custom_css' ) ) {
	function bakery_wc_custom_css( $echo = false ) {
		// Primary Color - Default : #fdb822
		$primary_color_hex = bakery_get_option( 'primary-color', '#fdb822' );
		$primary_color_rgb = bakery_hex2rgb( $primary_color_hex, true );

		// Secondary Color - Default : #684f40
		$secondary_color_hex = bakery_get_option( 'secondary-color', '#684f40' );
		$secondary_color_rgb = bakery_hex2rgb( $secondary_color_hex, true );

		// Tertiary Color - Default : #ff4800
		$tertiary_color_hex = bakery_get_option( 'tertiary-color', '#ff4800' );
		$tertiary_color_rgb = bakery_hex2rgb( $tertiary_color_hex, true );

		ob_start();
	?>
		/* WooCommerce */
		.vu_wc-product.vu_p-style-1 .vu_p-content,
		.vu_wc-product.vu_p-style-2 .vu_p-content {
			background-color: rgba(<?php echo esc_attr( $primary_color_rgb ); ?>,0.9);
		}
	<?php 
		$custom_css = ob_get_clean();

		if ( $echo ) {
			echo bakery_css_compress( $custom_css );
		} else {
			return bakery_css_compress( $custom_css );
		}
	}
}
