<?php 
/*
	Template Name: WooCommerce
*/

if ( ! defined( 'ABSPATH' ) ) exit();

get_header();

$bakery_shop_sidebar = bakery_get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'bakery_page_sidebar' );

$has_sidebar = ( function_exists( 'is_product' ) && is_product() && ( bakery_get_option( 'shop-show-sidebar-single-product', false ) == false ) ) ? false : bakery_has_sidebar( $bakery_shop_sidebar ); ?>

<!-- Container -->
<div class="vu_container vu_wc-page <?php echo esc_attr( ( $has_sidebar == true ) ? 'vu_with-sidebar' : 'vu_no-sidebar' ); ?> clearfix">
	<div class="container">
		<div class="row">
			<div class="vu_content col-xs-12 col-sm-12 col-md-<?php echo esc_attr( ( $has_sidebar == true ) ? ( 12 - absint( $bakery_shop_sidebar['layout'] ) ) . ( ( $bakery_shop_sidebar['position'] == 'left' ) ? ' col-md-push-' . absint( $bakery_shop_sidebar['layout'] ) : '' ) : '12' ); ?>">
				<?php if ( function_exists( 'woocommerce_content' ) ) { woocommerce_content(); } ?>
			</div>

			<?php if ( $has_sidebar == true ) : ?>
				<aside class="vu_sidebar vu_wc-sidebar vu_s-<?php echo esc_attr( $bakery_shop_sidebar['sidebar'] ); ?> col-xs-12 col-md-<?php echo absint( $bakery_shop_sidebar['layout'] ) . ( ( $bakery_shop_sidebar['position'] == 'left' ) ? ' col-md-pull-' . ( 12 - absint( $bakery_shop_sidebar['layout'] ) ) : '' ); ?>">
					<?php bakery_dynamic_sidebar( $bakery_shop_sidebar['sidebar'] ); ?>
				</aside>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- /Container -->

<?php get_footer(); ?>