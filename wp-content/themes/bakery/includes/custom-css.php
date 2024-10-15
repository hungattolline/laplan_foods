<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! function_exists( 'bakery_custom_css' ) ) {
	function bakery_custom_css( $echo = false ) {
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
		/* Colors */
		:root {
			--primary-color: <?php echo esc_attr( $primary_color_hex ); ?>;
			--secondary-color: <?php echo esc_attr( $secondary_color_hex ); ?>;
			--tertiary-color: <?php echo esc_attr( $tertiary_color_hex ); ?>;
		}

		/* Main Style */
		.vu_main-menu > ul > li {
			border-left: 1px solid rgba(<?php echo esc_attr( $secondary_color_rgb ); ?>,0.2);
		}
		.vu_team-member.vu_tm-style-1 .vu_tm-social-networks {
			background-color: rgba(<?php echo esc_attr( $secondary_color_rgb ); ?>,0.6);
		}
		.vu_team-member.vu_tm-style-2:after {
			background-color: rgba(<?php echo esc_attr( $secondary_color_rgb ); ?>,0.8);
		}
		.vu_team-member.vu_tm-style-3 .vu_tm-social-networks {
			background-color: rgba(<?php echo esc_attr( $secondary_color_rgb ); ?>,0.6);
		}
		.vu_product.vu_p-style-1 .vu_p-image .vu_p-i-cover {
			background-color: rgba(<?php echo esc_attr( $primary_color_rgb ); ?>,0.6);
		}
		.vu_product.vu_p-style-2 .vu_p-content,
		.vu_product.vu_p-style-3 .vu_p-content {
			background-color: rgba(<?php echo esc_attr( $primary_color_rgb ); ?>,0.9);
		}
		.vu_gallery-item .vu_gi-details-container {
			background-color: rgba(<?php echo esc_attr( $primary_color_rgb ); ?>,0.8);
		}

		/* Logo */
		.vu_main-header:not(.vu_mh-type-3) .vu_main-menu-container .vu_logo-container,
		.vu_main-header.vu_mh-type-3 .vu_main-menu-container .vu_logo-container .vu_site-logo {
			width:<?php echo absint( bakery_get_option( 'logo-width' ) ); ?>px;
		}
		.vu_main-menu-container .vu_logo-container img {
			max-width:<?php echo absint( bakery_get_option( 'logo-width' ) ); ?>px;
		}

		/* Fixed Header Logo */
		.vu_main-header:not(.vu_mh-type-3) .vu_menu-affix.affix .vu_main-menu-container .vu_logo-container,
		.vu_main-header.vu_mh-type-3 .vu_menu-affix.affix .vu_main-menu-container .vu_logo-container .vu_site-logo {
			width:<?php echo absint( bakery_get_option( 'header-fixed-logo-width' ) ); ?>px;
		}
		.vu_menu-affix.affix .vu_main-menu-container .vu_logo-container img {
			max-width:<?php echo absint( bakery_get_option( 'header-fixed-logo-width' ) ); ?>px;
		}

		/* Submenu width */
		.vu_main-menu ul li ul.sub-menu { width:<?php echo bakery_get_option( 'header-nav-submenu-width', '200' ); ?>px; }


		/* Megamenu */
		/*.vu_main-menu .vu_mega-menu > a:before { height: calc(<?php echo bakery_get_option( array( 'header-padding', 'padding-bottom' ), '100%' ); ?> + 2px); }*/


		/* Hamburger Menu */
		@media (max-width: <?php echo absint( bakery_get_option( 'header-hamburger-menu' ) ); ?>px) {
			.vu_main-menu {
				display: none !important;
			}
			.vu_mm-open,
			.vu_search-icon.vu_si-responsive,
			.vu_wc-menu-item.vu_wc-responsive {
				display: block !important;
			}
			.vu_main-menu-container .vu_logo-container {
				padding-right: 68px !important;
			}
			.vu_site-with-search-icon .vu_main-menu-container .vu_logo-container {
				padding-right: 130px !important;
			}
			.vu_wc-with-basket-icon .vu_main-menu-container .vu_logo-container {
				padding-left: 68px !important;
			}
			.vu_site-with-search-icon.vu_wc-with-basket-icon .vu_main-menu-container .vu_logo-container {
				padding-left: 130px !important;
			}
		}

		/* Page Header */
		.vu_page-header.vu_ph-with-bg:before {
			background-color: rgba(<?php echo esc_attr( bakery_hex2rgb( bakery_get_option( 'page-header-color-overlay' ), true ) ); ?>,<?php echo esc_attr( bakery_get_option( 'page-header-color-overlay-opacity' ) ); ?>);
		}
		.vu_page-header.vu_ph-style-default,
		.vu_page-header.vu_ph-style-custom .vu_ph-container {
			height: <?php echo absint( bakery_get_option( 'page-header-height' ) ) ?>px;
		}
	<?php 
		$custom_css = ob_get_clean();

		// Preloader Image
		if ( bakery_get_option( 'preloader' ) == true and trim( bakery_get_option( array( 'preloader-image', 'url' ) ) ) != '' ) {
			$custom_css .= '#vu_preloader { background-image: url(' . bakery_get_option( array( 'preloader-image', 'url' ) ) . '); }';
		}

		// Custom CSS from Theme Options
		if ( trim( bakery_get_option( 'custom-css' ) ) != '' ) {
			$custom_css .= bakery_get_option( 'custom-css' );
		}

		if ( $echo ) {
			echo bakery_css_compress( $custom_css );
		} else {
			return bakery_css_compress( $custom_css );
		}
	}
}
