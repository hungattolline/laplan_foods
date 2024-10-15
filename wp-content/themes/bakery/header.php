<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php do_action( 'bakery/header/before' ); ?>
	
	<!-- Main Container -->
	<div class="vu_main-container">
		<?php 
			$post_id = ! empty( $post->ID ) ? $post->ID : null;
			$header_title = $header_subtitle = $header_bg = null;
			$page_for_posts = get_option( 'page_for_posts' );

			if ( is_home() || is_page() || is_single() && get_post_type() != 'product' ) {
				$post_id = ( get_post_type() == 'post' ) ? $page_for_posts : $post_id;
			} else if ( is_tax() ) {
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

				$header_title = $term->name;

				// WooCommerce
				if ( $term->taxonomy == 'product_cat' ) {
					$post_id = get_option( 'woocommerce_shop_page_id' );

					$header_subtitle = sprintf( __( "All products from '%s' category", 'bakery' ), $term->name );

					if ( function_exists( 'get_term_meta' ) ) {
						$header_bg = get_term_meta( $term->term_id, 'thumbnail_id', true );
					}

					if ( empty( $header_bg ) ) {
						$header_bg = bakery_get_page_header_bg( get_option( 'woocommerce_shop_page_id' ) );
					}
				} else if ( $term->taxonomy == 'product_tag' ) {
					$post_id = get_option( 'woocommerce_shop_page_id' );

					$header_subtitle = sprintf( __( "All products tagged with '%s'", 'bakery' ), $term->name );
					$header_bg = bakery_get_page_header_bg( get_option( 'woocommerce_shop_page_id' ) );
				}
			} else if ( is_tag() ) {
				$header_title = single_tag_title( '', false );
				$header_subtitle = sprintf(__("All posts tagged with '%s'", 'bakery' ), single_tag_title( '', false ) );
				$header_bg = bakery_get_page_header_bg( $page_for_posts );
			} else if ( is_category() ) {
				$header_title = single_cat_title( '', false );
				$header_subtitle = sprintf(__("All posts from '%s' category", 'bakery' ), single_cat_title( '', false ) );
				$header_bg = bakery_get_page_header_bg( $page_for_posts );
			} else if ( is_author() ) {
				$current_author = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );

				$header_title = $current_author->nickname;
				$header_subtitle = sprintf( __( "Posts by '%s'", 'bakery' ), $current_author->nickname );
				$header_bg = bakery_get_page_header_bg( $page_for_posts );
			} else if ( is_archive() ) {
				if ( is_day() ) {
					$header_title = get_the_date();
				} else if ( is_month() ) {
					$header_title = get_the_date( 'F Y' );
				} else {
					$header_title = get_the_date( 'Y' );
				}

				$header_subtitle = sprintf( __( "Archives from '%s'", 'bakery' ), $header_title );
				$header_bg = bakery_get_page_header_bg( $page_for_posts );

				if ( function_exists( 'is_shop' ) && is_shop() ) {
					$post_id = get_option( 'woocommerce_shop_page_id' );
					$header_title = $header_subtitle = $header_bg = null;
				}

				if ( function_exists( 'tribe_is_event_query' ) && tribe_is_event_query() ) {
					$header_title = ( function_exists( 'tribe_get_events_title' ) ) ? tribe_get_events_title() : esc_html__( 'Events', 'bakery' );
					$header_subtitle = $header_bg = null;
				}
			} else if ( is_search() ) {
				$post_id = null;
				$header_title = esc_html__( 'Search', 'bakery' );
				$header_subtitle = sprintf( __( "Search results for: '%s'", 'bakery' ), get_search_query() );

				if ( get_query_var( 'post_type' ) == 'portfolio-item' ) {
					$header_bg = bakery_get_option( array( 'portfolio-header-bg', 'url' ) );
				} else {
					$header_bg = bakery_get_page_header_bg( $page_for_posts );
				}
			} else if ( is_404() ) {
				$error_page_title = bakery_get_option( 'error-page-title', '' );
				$error_page_subtitle = bakery_get_option( 'error-page-subtitle', '' );

				$post_id = $page_for_posts;
				$header_title = ! empty( $error_page_title ) ? $error_page_title : esc_html__( 'Page not found', 'bakery' );
				$header_subtitle = ! empty( $error_page_subtitle ) ? $error_page_subtitle : esc_html__( 'Opps something went wrong', 'bakery' );
				$header_bg = null;
			} else if ( function_exists( 'is_cart' ) && is_cart() ) {
				$post_id = get_option( 'woocommerce_cart_page_id' );
			} else if ( function_exists( 'is_product' ) && is_product() ) {
				$post_id = get_option( 'woocommerce_shop_page_id' );

				$product_cats = get_the_terms( $post->ID, 'product_cat' );
					
				if ( $product_cats && ! is_wp_error( $product_cats ) ) {
					foreach ( $product_cats as $product_cat ) {
						if ( function_exists( 'get_term_meta' ) ) {
							$header_bg = get_term_meta( $product_cat->term_id, 'thumbnail_id', true );
							break;
						}
					}
				}
			} else if ( is_page() ) {
				$post_id = $post->ID;
			} else {
				$header_title = $header_subtitle = $header_bg = null;
			}

			if ( is_front_page() && function_exists( 'is_shop' ) && is_shop() ) {
				$post_id = get_option( 'woocommerce_shop_page_id' );
				$header_title = $header_subtitle = $header_bg = null;
			}

			$bakery_page_header_settings = bakery_get_post_meta( $post_id, 'bakery_page_header_settings' );
			$bakery_page_menu = bakery_get_post_meta( $post_id, 'bakery_page_menu' );
		?>

		<!-- Header -->
		<header id="vu_main-header" class="vu_main-header vu_mh-layout-<?php echo esc_attr( bakery_get_option( 'header-layout', 'boxed' ) ); ?> vu_mh-type-<?php echo esc_attr( bakery_get_option( 'header-type', '1' ) ); ?><?php echo ( isset( $bakery_page_header_settings['transparent'] ) && ( $bakery_page_header_settings['transparent'] == 'yes' || ( $bakery_page_header_settings['transparent'] == 'inherit' && bakery_get_option( 'header-transparent' ) == true ) ) || ! empty( $bakery_page_menu['transparent'] ) ) ? ' vu_mh-transparent' : ''; ?>">
			<?php if ( bakery_get_option( 'top-bar-show' ) ) : ?>
				<div class="vu_top-bar vu_tb-layout-<?php echo esc_attr( bakery_get_option( 'top-bar-layout', 'boxed' ) ); ?>">
					<div class="container">
						<div class="row">
							<?php $top_bar_columns = explode( '-', bakery_get_option( 'top-bar-columns', '7-5' ) ); ?>
							<div class="vu_tb-left col-md-<?php echo esc_attr( $top_bar_columns[0] ); ?>">
								<?php echo do_shortcode( wp_kses_post( bakery_get_option( 'top-bar-left-content' ) ) ); ?>
							</div>
							<div class="vu_tb-right col-md-<?php echo esc_attr( $top_bar_columns[1] ); ?>">
								<?php echo do_shortcode( wp_kses_post( bakery_get_option( 'top-bar-right-content' ) ) ); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="container">
				<div id="vu_menu-affix" class="vu_menu-affix"<?php echo ( bakery_get_option( 'header-fixed' ) ) ? ' data-spy="affix" data-offset-top="' . absint( bakery_get_option( 'header-fixed-offset' ) ) . '"' : ''; ?>>
					<div class="vu_main-menu-container">
						<div class="vu_d-tr">
							<?php if ( bakery_get_option( 'header-type', '1' ) == '1' ) : ?>
								<nav class="vu_main-menu vu_mm-top-left vu_d-td text-right" aria-label="Main">
									<?php 
										// Main Menu Left
										wp_nav_menu(
												array(
												'theme_location'  => ( isset( $bakery_page_menu['menu-left'] ) && $bakery_page_menu['menu-left'] != '' ) ? '' : 'main-menu-left',
												'menu'            => ( isset( $bakery_page_menu['menu-left'] ) && $bakery_page_menu['menu-left'] != '' ) ? $bakery_page_menu['menu-left'] : '',
												'container'       => false,
												'container_id'    => false,
												'container_class' => false,
												'menu_id'         => 'vu_mm-top-left',
												'menu_class'      => 'vu_mm-list vu_mm-top-left list-unstyled',
												'items_wrap'      => bakery_main_menu_wrap(),
												'fallback_cb'     => bakery_main_menu_fallback_cb( 'main-menu-left' ),
											)
										);
									?>
								</nav>
							<?php endif; ?>

							<div class="vu_logo-container vu_d-td"> 
								<div class="vu_site-logo">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
										<img class="vu_sl-dark" alt="site-logo-dark" width="<?php echo esc_attr( bakery_get_option( array( 'logo-dark', 'width' ) ) ); ?>" height="<?php echo esc_attr( bakery_get_option( array( 'logo-dark', 'height' ) ) ); ?>" src="<?php echo esc_url( bakery_get_option( array( 'logo-dark', 'url' ) ) ); ?>">
										<img class="vu_sl-light" alt="site-logo-light" width="<?php echo esc_attr( bakery_get_option( array( 'logo-light', 'width' ) ) ); ?>" height="<?php echo esc_attr( bakery_get_option( array( 'logo-light', 'height' ) ) ); ?>" src="<?php echo esc_url( bakery_get_option( array( 'logo-light', 'url' ) ) ); ?>">
										<?php if ( bakery_get_option( 'header-fixed' ) ) : ?>
											<img class="vu_sl-small" alt="site-logo-small" width="<?php echo esc_attr( bakery_get_option( array( 'header-fixed-logo', 'width' ) ) ); ?>" height="<?php echo esc_attr( bakery_get_option( array( 'header-fixed-logo', 'height' ) ) ); ?>" src="<?php echo esc_url( bakery_get_option( array( 'header-fixed-logo', 'url' ) ) ); ?>">
										<?php endif; ?>
									</a>
								</div>
								
								<a href="#" class="vu_mm-toggle vu_mm-open"><i class="fa fa-bars" aria-hidden="true"></i></a>

								<?php if ( bakery_get_option( 'header-show-search-icon', false ) == true ) : ?>
									<a href="#" class="vu_search-icon vu_si-responsive"><i class="fa fa-search" aria-hidden="true"></i></a>
								<?php endif; ?>

								<?php do_action( 'bakery/wc/responsive_basket_icon' ); ?>
							</div>

							<?php if ( bakery_get_option( 'header-type', '1' ) == '1' ) : ?>
								<nav class="vu_main-menu vu_mm-top-right vu_d-td text-left" aria-label="Main">
									<?php 
										// Main Menu Right
										wp_nav_menu(
												array(
												'theme_location'  => ( isset( $bakery_page_menu['menu-right'] ) && $bakery_page_menu['menu-right'] != '' ) ? '' : 'main-menu-right',
												'menu'            => ( isset( $bakery_page_menu['menu-right'] ) && $bakery_page_menu['menu-right'] != '' ) ? $bakery_page_menu['menu-right'] : '',
												'container'       => false,
												'container_id'    => false,
												'container_class' => false,
												'menu_id'         => 'vu_mm-top-right',
												'menu_class'      => 'vu_mm-list vu_mm-top-right list-unstyled',
												'items_wrap'      => bakery_main_menu_wrap(),
												'fallback_cb'     => bakery_main_menu_fallback_cb( 'main-menu-right' ),
											)
										);
									?>
								</nav>
							<?php else : ?>
								<nav class="vu_main-menu vu_mm-top-full vu_d-td text-right" aria-label="Main">
									<?php 
										// Main Menu Full
										wp_nav_menu(
												array(
												'theme_location'  => ( isset( $bakery_page_menu['menu-full'] ) && $bakery_page_menu['menu-full'] != '' ) ? '' : 'main-menu-full',
												'menu'            => ( isset( $bakery_page_menu['menu-full'] ) && $bakery_page_menu['menu-full'] != '' ) ? $bakery_page_menu['menu-full'] : '',
												'container'       => false,
												'container_id'    => false,
												'container_class' => false,
												'menu_id'         => 'vu_mm-top-full',
												'menu_class'      => 'vu_mm-list vu_mm-top-full list-unstyled',
												'items_wrap'      => bakery_main_menu_wrap(),
												'fallback_cb'     => bakery_main_menu_fallback_cb( 'main-menu-full' ),
											)
										);
									?>
								</nav>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="vu_menu-affix-height"></div>
			</div>
		</header>
		<!-- /Header -->

		<?php do_action( 'bakery/header/after' ); ?>

		<?php bakery_page_header( $post_id, $header_title, $header_subtitle, $header_bg ); ?>