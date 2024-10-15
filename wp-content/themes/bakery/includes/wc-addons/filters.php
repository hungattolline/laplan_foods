<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! class_exists( 'Bakery_WC_Filters' ) ) {
	class Bakery_WC_Filters {
		function __construct() {
			add_filter( 'body_class', array( $this, 'body_class' ) );
			add_filter( 'product_cat_class', array( $this, 'product_cat_class' ), 10, 3 );
			add_filter( 'wp_nav_menu_items', array( $this, 'wp_nav_menu_items' ), 10, 2);
			add_filter( 'woocommerce_form_field_args', array( $this, 'woocommerce_form_field_args' ), 10, 3 );
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ), 10, 1 );
			add_filter( 'woocommerce_pagination_args', array( $this, 'woocommerce_pagination_args' ) );
			add_filter( 'woocommerce_upsells_columns', array( $this, 'woocommerce_upsells_columns' ), 10, 1 );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'woocommerce_output_related_products_args' ), 10, 1 );

			add_filter( 'woocommerce_show_page_title', '__return_false' );
		}
		
		// Add specific CSS class by filter
		function body_class( $classes ) {
			// Basket Icon
			if ( bakery_get_option( 'shop-show-basket-icon', false ) == true ) {
				$classes[] = 'vu_wc-with-basket-icon';
			}

			// Shop page display
			$wc_shop_page_display = get_option( 'woocommerce_shop_page_display' );
			$wc_shop_page_display = ( $wc_shop_page_display != '' ) ? $wc_shop_page_display : 'products';

			$classes[] = 'vu_wc-shop-display-' . $wc_shop_page_display;

			// Category display
			$wc_category_display = get_option( 'woocommerce_category_archive_display' );
			$wc_category_display = ( $wc_category_display != '' ) ? $wc_category_display : 'products';
			
			$classes[] = 'vu_wc-category-display-' . $wc_category_display;

			return $classes;
		}
		
		// Add specific CSS class by filter
		function product_cat_class( $classes, $class, $category ) {
			if ( ( $key = array_search( 'product', $classes ) ) !== false ) {
				unset( $classes[ $key ] );
			}

			return $classes;
		}
		
		// Show basket icon in menu
		function wp_nav_menu_items( $items, $args ) {
			if ( ( $args->theme_location == 'main-menu-full' || $args->theme_location == 'main-menu-right' ) && bakery_get_option( 'shop-show-basket-icon', false ) == true ) {
				
				if ( class_exists( 'YITH_WC_Catalog_Mode' ) ) {
					global $YITH_WC_Catalog_Mode;

					if ( method_exists( $YITH_WC_Catalog_Mode, 'check_hide_cart_checkout_pages' ) && $YITH_WC_Catalog_Mode->check_hide_cart_checkout_pages() ) {
						return $items;
					}
				}

				ob_start(); ?>
					<li class="vu_wc-menu-item">
						<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="vu_wc-cart-link"><span><i class="fa fa-shopping-cart"></i><span class="vu_wc-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span></span></a>
						
						<div class="vu_wc-menu-container">
							<div class="vu_wc-cart-notification"><span class="vu_wc-item-name"></span><?php esc_html_e( 'was successfully added to your cart.', 'bakery' ); ?></div>
							<div class="vu_wc-cart widget woocommerce widget_shopping_cart"><div class="widget_shopping_cart_content"><?php woocommerce_mini_cart(); ?></div></div>
						</div>
					</li>
				<?php

				$items .= ob_get_clean();
			}

			return $items;
		}

		// Add an extra class for WC fields
		function woocommerce_form_field_args( $args, $key, $value ) {
			$args['input_class'] = array( 'form-control' );

			return $args;
		}

		// Change number of products displayed per page
		function loop_shop_per_page( $cols ) {
			return absint( bakery_get_option( 'shop-product-count' ) );
		}

		// Change number of product columns
		function loop_shop_columns($number_columns) {
			$shop_page = get_option( 'woocommerce_shop_page_id' );
			$shop_sidebar = bakery_get_post_meta( absint( $shop_page ), 'bakery_page_sidebar' );

			return ( isset( $shop_sidebar['sidebar'] ) && $shop_sidebar['sidebar'] != '' ) ? 3 : 4;
		}

		// Change pagination args
		function woocommerce_pagination_args( $args ) {
			$args['prev_text'] = '<i class="fa fa-arrow-left" aria-hidden="true"></i>';
			$args['next_text'] = '<i class="fa fa-arrow-right" aria-hidden="true"></i>';

			return $args;
		}

		// Change columns number of upsells products on product page
		function woocommerce_upsells_columns( $columns ) {
			if ( bakery_wc_single_product_has_sidebar() ) {
				$columns = 3;
			} else {
				$columns = 4;
			}

			return absint( $columns );
		}

		// Change number of related products on product page
		function woocommerce_output_related_products_args( $args ) {
			$args['posts_per_page'] = bakery_get_option( 'shop-related-products-items-count', 4 );

			if ( bakery_wc_single_product_has_sidebar() ) {
				$args['columns'] = 3;
			} else {
				$args['columns'] = 4;
			}

			return $args;
		}
	}
}

$Bakery_WC_Filters = new Bakery_WC_Filters();