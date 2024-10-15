<?php if ( ! defined( 'ABSPATH' ) ) exit();

/* ----------------------------------------------------------------------------------
	* The following functions are also declared in the Bakery Shortcodes Plugin.
	* If you want to modify any of these functions you may need to make the same changes
	* to the functions in Bakery Shortcodes Plugin as well.
	* ---------------------------------------------------------------------------------- */

// Get theme option value
if ( ! function_exists( 'bakery_get_option' ) ) {
	function bakery_get_option( $option, $default = '' ) {
		global $bakery_theme_options;

		if ( ( empty( $bakery_theme_options ) || ! isset( $bakery_theme_options['last_tab'] ) ) && ! isset( $bakery_theme_options['default-options'] ) ) {
			$bakery_theme_options = bakery_default_theme_options();
		}

		if ( is_array( $option ) ){
			$count = count( $option );

			switch ( $count ) {
				case 2:
					return isset( $bakery_theme_options[ $option[0] ][ $option[1] ] ) ? $bakery_theme_options[ $option[0] ][ $option[1] ] : $default;
					break;
				case 3:
					return isset( $bakery_theme_options[ $option[0] ][ $option[1] ][ $option[2] ] ) ? $bakery_theme_options[ $option[0] ][ $option[1] ][ $option[2] ] : $default;
					break;
					
				default:
					return isset( $bakery_theme_options[ $option[0] ] ) ? $bakery_theme_options[ $option[0] ] : $default;
					break;
			}
		}
		
		return isset( $bakery_theme_options[ $option ] ) ? $bakery_theme_options[ $option ] : $default;
	}
}

// Default theme options
if ( ! function_exists( 'bakery_default_theme_options' ) ) {
	function bakery_default_theme_options() {
		return json_decode( '{"last_tab":"","logo-dark":{"url":"' . get_template_directory_uri() . '/assets/img/bakery-logo-dark.png","id":"","height":"1000","width":"1000","thumbnail":"","title":"","caption":"","alt":"","description":""},"logo-light":{"url":"' . get_template_directory_uri() . '/assets/img/bakery-logo-light.png","id":"","height":"1000","width":"1000","thumbnail":"","title":"","caption":"","alt":"","description":""},"logo-width":"130","preloader":"","preloader-image":{"url":"' . get_template_directory_uri() . '/assets/img/preloader.svg","id":"","height":"","width":"","thumbnail":"","title":"","caption":"","alt":"","description":""},"site-mode":"normal","site-mode-page":"","primary-color":"#fdb822","secondary-color":"#684f40","tertiary-color":"#ff4800","boxed-layout":"","body-background":{"background-color":"#fff","background-repeat":"","background-size":"","background-attachment":"","background-position":"","background-image":"","media":{"id":"","height":"","width":"","thumbnail":""}},"body-typography":{"font-family":"Open Sans","font-options":"","google":"1","font-weight":"","font-style":"400","subsets":"latin","text-transform":"none","font-size":"14px","line-height":"24px","color":"#696969"},"nav-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"700","subsets":"latin","text-transform":"uppercase","font-size":"14px","line-height":"24px","color":"#684f40"},"nav-submenu-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"600","subsets":"latin","text-transform":"none","font-size":"14px","line-height":"20px","color":"#684f40"},"h1-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"700","subsets":"latin","text-transform":"none","font-size":"28px","line-height":"38px","color":"#684f40"},"h2-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"700","subsets":"latin","text-transform":"none","font-size":"24px","line-height":"34px","color":"#684f40"},"h3-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"700","subsets":"latin","text-transform":"none","font-size":"20px","line-height":"30px","color":"#684f40"},"h4-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"700","subsets":"latin","text-transform":"none","font-size":"17px","line-height":"27px","color":"#684f40"},"h5-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"700","subsets":"latin","text-transform":"none","font-size":"16px","line-height":"26px","color":"#684f40"},"h6-typography":{"font-family":"Montserrat","font-options":"","google":"1","font-weight":"","font-style":"700","subsets":"latin","text-transform":"none","font-size":"14px","line-height":"24px","color":"#684f40"},"others-typography":{"font-family":"Montserrat","font-options":"","google":"1","subsets":"latin"},"top-bar-show":"0","top-bar-layout":"boxed","top-bar-columns":"7-5","top-bar-bg-color":{"background-color":"#343434"},"top-bar-text-color":"#ffffff","top-bar-left-content":"<span><i class=\"fa fa-phone-square\"></i>+1 0123 456 789</span>|<span><i class=\"fa fa-clock-o\"></i>Mon - Sat: 7:00 - 17:00</span>|<span><i class=\"fa fa-envelope-o\"></i> info@yourdomain.com</span>","top-bar-right-content":"<div class=\"vu_social-icon\"><a href=\"#\" target=\"_self\"><i class=\"fa fa-facebook\"></i></a></div><div class=\"vu_social-icon\"><a href=\"#\" target=\"_self\"><i class=\"fa fa-twitter\"></i></a></div><div class=\"vu_social-icon\"><a href=\"#\" target=\"_self\"><i class=\"fa fa-youtube\"></i></a></div><div class=\"vu_social-icon m-r-0\"><a href=\"#\" target=\"_self\"><i class=\"fa fa-instagram\"></i></a></div>","header-type":"2","header-layout":"boxed","header-padding":{"padding-top":"25px","padding-bottom":"25px","units":"px"},"header-transparent":"","header-show-search-icon":"","header-search-scope":"all","header-nav-submenu-width":"200","header-hamburger-menu":"1000","header-fixed":"1","header-fixed-offset":"150","header-fixed-logo":{"url":"' . get_template_directory_uri() . '/assets/img/bakery-logo-small.png","id":"","height":"331","width":"575","thumbnail":"","title":"","caption":"","alt":"","description":""},"header-fixed-logo-width":"90","header-fixed-padding":{"padding-top":"20px","padding-bottom":"20px","units":"px"},"page-header-show":"1","page-header-style":"1","page-header-breadcrumbs-show":"","page-header-breadcrumbs-content":"","page-header-height":"250","page-header-bg-image":{"url":"","id":"","height":"","width":"","thumbnail":"","title":"","caption":"","alt":"","description":""},"page-header-parallax":"1","page-header-color-overlay":"#000000","page-header-color-overlay-opacity":"0.5","page-header-others-options":{"border":"1","pattern":"1"},"blog-image-ratio":"2:1","blog-social":"0","blog-social-networks":{"facebook":"1","twitter":"1","google-plus":"1","pinterest":"1","linkedin":""},"blog-show-date":"1","blog-show-author":"","blog-show-comments-number":"1","blog-show-categories":"","blog-show-tags":"","blog-single-show-tags":"1","blog-single-show-next-prev":"1","shop-product-style":"1","shop-product-image-display":"portrait","shop-product-content-display":"hover","shop-product-options":{"show-zoom-icon":"1","show-link-icon":"1","show-cart-icon":"1","show-title":"1","show-categories":"1","show-price":"1","disable-link":""},"shop-product-count":"12","shop-show-basket-icon":"1","shop-show-sidebar-single-product":"","shop-show-product-socials":"1","shop-product-socials":{"facebook":"1","twitter":"1","google-plus":"1","pinterest":"1","linkedin":""},"shop-show-upsells-products":"1","shop-show-related-products":"1","shop-related-products-items-count":"4","map-google-api-key":"","map-center-lat":"","map-center-lng":"","map-zoom-level":"","map-height":"580","map-type":"roadmap","map-id":"","map-tilt-45":"","map-use-marker-img":"","map-marker-img":{"url":"","id":"","height":"","width":"","thumbnail":"","title":"","caption":"","alt":"","description":""},"map-enable-animation":"","map-others-options":{"draggable":"","zoomControl":"","disableDoubleClickZoom":"1","panControl":"","fullscreenControl":"1","mapTypeControl":"","scaleControl":"","streetViewControl":""},"map-number-of-locations":"1","map-point-1":"","map-lat-1":"","map-lng-1":"","map-info-1":"","map-point-2":"","map-lat-2":"","map-lng-2":"","map-info-2":"","map-point-3":"","map-lat-3":"","map-lng-3":"","map-info-3":"","map-point-4":"","map-lat-4":"","map-lng-4":"","map-info-4":"","map-point-5":"","map-lat-5":"","map-lng-5":"","map-info-5":"","map-point-6":"","map-lat-6":"","map-lng-6":"","map-info-6":"","map-point-7":"","map-lat-7":"","map-lng-7":"","map-info-7":"","map-point-8":"","map-lat-8":"","map-lng-8":"","map-info-8":"","map-point-9":"","map-lat-9":"","map-lng-9":"","map-info-9":"","map-point-10":"","map-lat-10":"","map-lng-10":"","map-info-10":"","map-point-11":"","map-lat-11":"","map-lng-11":"","map-info-11":"","map-point-12":"","map-lat-12":"","map-lng-12":"","map-info-12":"","map-point-13":"","map-lat-13":"","map-lng-13":"","map-info-13":"","map-point-14":"","map-lat-14":"","map-lng-14":"","map-info-14":"","map-point-15":"","map-lat-15":"","map-lng-15":"","map-info-15":"","map-point-16":"","map-lat-16":"","map-lng-16":"","map-info-16":"","map-point-17":"","map-lat-17":"","map-lng-17":"","map-info-17":"","map-point-18":"","map-lat-18":"","map-lng-18":"","map-info-18":"","map-point-19":"","map-lat-19":"","map-lng-19":"","map-info-19":"","map-point-20":"","map-lat-20":"","map-lng-20":"","map-info-20":"","map-point-21":"","map-lat-21":"","map-lng-21":"","map-info-21":"","map-point-22":"","map-lat-22":"","map-lng-22":"","map-info-22":"","map-point-23":"","map-lat-23":"","map-lng-23":"","map-info-23":"","map-point-24":"","map-lat-24":"","map-lng-24":"","map-info-24":"","map-point-25":"","map-lat-25":"","map-lng-25":"","map-info-25":"","map-point-26":"","map-lat-26":"","map-lng-26":"","map-info-26":"","map-point-27":"","map-lat-27":"","map-lng-27":"","map-info-27":"","map-point-28":"","map-lat-28":"","map-lng-28":"","map-info-28":"","map-point-29":"","map-lat-29":"","map-lng-29":"","map-info-29":"","map-point-30":"","map-lat-30":"","map-lng-30":"","map-info-30":"","map-point-31":"","map-lat-31":"","map-lng-31":"","map-info-31":"","map-point-32":"","map-lat-32":"","map-lng-32":"","map-info-32":"","map-point-33":"","map-lat-33":"","map-lng-33":"","map-info-33":"","map-point-34":"","map-lat-34":"","map-lng-34":"","map-info-34":"","map-point-35":"","map-lat-35":"","map-lng-35":"","map-info-35":"","map-point-36":"","map-lat-36":"","map-lng-36":"","map-info-36":"","map-point-37":"","map-lat-37":"","map-lng-37":"","map-info-37":"","map-point-38":"","map-lat-38":"","map-lng-38":"","map-info-38":"","map-point-39":"","map-lat-39":"","map-lng-39":"","map-info-39":"","map-point-40":"","map-lat-40":"","map-lng-40":"","map-info-40":"","map-point-41":"","map-lat-41":"","map-lng-41":"","map-info-41":"","map-point-42":"","map-lat-42":"","map-lng-42":"","map-info-42":"","map-point-43":"","map-lat-43":"","map-lng-43":"","map-info-43":"","map-point-44":"","map-lat-44":"","map-lng-44":"","map-info-44":"","map-point-45":"","map-lat-45":"","map-lng-45":"","map-info-45":"","map-point-46":"","map-lat-46":"","map-lng-46":"","map-info-46":"","map-point-47":"","map-lat-47":"","map-lng-47":"","map-info-47":"","map-point-48":"","map-lat-48":"","map-lng-48":"","map-info-48":"","map-point-49":"","map-lat-49":"","map-lng-49":"","map-info-49":"","map-point-50":"","map-lat-50":"","map-lng-50":"","map-info-50":"","footer-show":"1","footer-type":"widgetized","footer-layout":"3-3-3-3","footer-background":{"background-color":"#1a1a1a","background-repeat":"","background-size":"","background-attachment":"","background-position":"","background-image":"","media":{"id":"","height":"","width":"","thumbnail":""}},"footer-text-color":"#ffffff","subfooter-show":"1","subfooter-layout":"1","subfooter-alignment":"center","subfooter-full-content":"Copyright &copy; 2019 <a href=\"http://themeforest.net/user/milingona_/portfolio\" target=\"_blank\">Milingona</a>. All Rights Reserved.","subfooter-left-content":"Copyright &copy; 2019 <a href=\"http://themeforest.net/user/milingona_/portfolio\" target=\"_blank\">Milingona</a>. All Rights Reserved.","subfooter-right-content":"","subfooter-bg-color":{"background-color":"#000000"},"subfooter-text-color":"#ffffff","back-to-top-show":"1","sidebars":[],"error-page-header-title":"","error-page-header-subtitle":"","error-page-heading":"","error-page-description":"","error-page-btn-text":"","advanced-dequeue-libraries":{"bootstrap-datepicker":"","bootstrap-timepicker":""},"advanced-countdown-language":"en","google-analytics-tracking-code":"","twitter-consumer-key":"","twitter-consumer-secret":"","twitter-user-token":"","twitter-user-secret":"","custom-css":"body:not(.vu_page-with-comments) .vu_content{margin-bottom:70px}.vu_blog-post .vu_bp-title,.vu_bp-next-prev-container a{word-wrap:break-word}.gallery.gallery-columns-3{display:flex;flex-wrap:wrap;text-align:center}.gallery.gallery-columns-2 .gallery-item{flex:0 0 50%}.gallery.gallery-columns-3 .gallery-item{flex:0 0 33.33333%}.gallery.gallery-columns-4 .gallery-item{flex:0 0 25%}@media (max-width:768px){.gallery .gallery-item{flex:0 0 100%!important}}","custom-js":"","default-options":"1"}', true );
	}
}

// Remove wpautop
if ( ! function_exists( 'bakery_remove_wpautop' ) ) {
	function bakery_remove_wpautop( $content, $autop = false ) {
		if ( $autop ) {
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}

		return do_shortcode( shortcode_unautop( $content ) );
	}
}

// Shortcode atts
if ( ! function_exists( 'bakery_shortcode_atts' ) ) {
	function bakery_shortcode_atts( $pairs, $atts, $shortcode = '' ) {
		$atts = shortcode_atts( $pairs, $atts, $shortcode );

		return bakery_prepare_atts( $atts );
	}
}

// Prepare shortcode atts
if ( ! function_exists( 'bakery_prepare_atts' ) ) {
	function bakery_prepare_atts( $atts ) {
		$return = array();

		if ( is_array( $atts ) ) {
			foreach ( $atts as $key => $val ) {
				$return[ $key ] = str_replace(
					array(
						'`{`',
						'`}`',
						'``',
					),
					array(
						'[',
						']',
						'"',
					),
					$val
				);
			}
		}

		return $return;
	}
}

// Convert shortcode atts to string
if ( ! function_exists( 'bakery_shortcode_atts_to_str' ) ) {
	function bakery_shortcode_atts_to_str( $atts ) {
		$return = '';

		foreach ( $atts as $key => $value ) {
			$return .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		return $return;
	}
}

// Generate shortcode as string
if ( ! function_exists( 'bakery_generate_shortcode' ) ) {
	function bakery_generate_shortcode( $tag, $atts, $content = null ) {
		$return = '['. $tag . bakery_shortcode_atts_to_str( $atts ) .']';

		if ( ! empty( $content ) ) {
			$return .= $content . '[/' . $tag . ']';
		}

		return $return;
	}
}

// Extra class for shortcode
if ( ! function_exists( 'bakery_extra_class' ) ) {
	function bakery_extra_class( $class, $echo = true ) {
		$return = ( ( ! empty( $class ) ) ? ' '. trim( $class ) : '' );

		if ( $echo == true ) {
			echo esc_attr( $return );
		} else {
			return esc_attr( $return );
		}
	}
}

// Custom/Random class for shortcode
if ( ! function_exists( 'bakery_custom_class' ) ) {
	function bakery_custom_class() {
		return esc_attr( 'vu_custom_' . rand( 1000000, 9999999 ) );
	}
}

// Get image ratios
if ( ! function_exists( 'bakery_get_image_ratios' ) ) {
	function bakery_get_image_ratios() {
		return array(
			"1:1" => "1:1",
			"2:1" => "2:1",
			"3:2" => "3:2",
			"3:4" => "3:4",
			"4:3" => "4:3",
			"16:9" => "16:9"
		);
	}
}

// Print Excerpt with Custom Length
if ( ! function_exists( 'bakery_the_excerpt' ) ) {
	function bakery_the_excerpt( $num_of_words, $post_excerpt = null ) {
		$excerpt = empty( $post_excerpt ) ? get_the_excerpt() : $post_excerpt;

		$exwords = explode( ' ', trim( mb_substr( $excerpt, 0, mb_strlen( $excerpt ) - 5 ) ) );

		if ( count( $exwords ) > $num_of_words ) {
			$excerpt = array();

			$i = 0;
			foreach ( $exwords as $value ) {
				if ( $i >= $num_of_words ) break;

				array_push( $excerpt, $value );

				$i++;
			}

			echo implode( ' ', $excerpt ) . ' [...]';
		} else {
			echo trim( $excerpt );
		}
	}
}

// Get Map Options from Theme Options
if ( ! function_exists( 'bakery_get_map_options' ) ) {
	function bakery_get_map_options() {
		$map_options = array(
			'map_id' => esc_attr( bakery_get_option( 'map-id' ) ),
			'zoom_level' => esc_attr( bakery_get_option( 'map-zoom-level' ) ),
			'center_lat' => esc_attr( bakery_get_option( 'map-center-lat' ) ),
			'center_lng' => esc_attr( bakery_get_option( 'map-center-lng' ) ),
			'map_type' => esc_attr( bakery_get_option( 'map-type' ) ),
			'tilt_45' => esc_attr( bakery_get_option( 'map-tilt-45' ) ),
			'others_options' => array(
				'draggable' => esc_attr( bakery_get_option( array( 'map-others-options', 'draggable' ) ) ),
				'zoomControl' => esc_attr( bakery_get_option( array( 'map-others-options', 'zoomControl' ) ) ),
				'disableDoubleClickZoom' => esc_attr( bakery_get_option( array( 'map-others-options', 'disableDoubleClickZoom' ) ) ),
				'scrollwheel' => esc_attr( bakery_get_option( array( 'map-others-options', 'scrollwheel' ) ) ),
				'panControl' => esc_attr( bakery_get_option( array( 'map-others-options', 'panControl' ) ) ),
				'fullscreenControl' => esc_attr( bakery_get_option( array( 'map-others-options', 'fullscreenControl' ) ) ),
				'mapTypeControl' => esc_attr( bakery_get_option( array( 'map-others-options', 'mapTypeControl' ) ) ),
				'scaleControl' => esc_attr( bakery_get_option( array( 'map-others-options', 'scaleControl' ) ) ),
				'streetViewControl' => esc_attr( bakery_get_option( array( 'map-others-options', 'streetViewControl' ) ) )
			),
			'use_custom_marker' => esc_attr( bakery_get_option( 'map-use-marker-img' ) ),
			'custom_marker' => esc_attr( bakery_get_option( array( 'map-marker-img', 'url' ) ) ),
			'enable_animation' => esc_attr( bakery_get_option( 'map-enable-animation' ) ),
			'locations' => array()
		);

		$number_of_locations = bakery_get_option( 'map-number-of-locations' );

		for ( $i = 1; $i <= $number_of_locations; $i++ ) {
			if ( bakery_get_option( 'map-point-' . $i ) != false ) {
				array_push( $map_options['locations'], array( 'lat' => esc_attr( bakery_get_option( 'map-lat-' . $i ) ), 'lng' => esc_attr( bakery_get_option( 'map-lng-' . $i ) ), 'info' => esc_attr( bakery_get_option( 'map-info-' . $i ) ) ) );
			}
		}

		return $map_options;
	}
}
