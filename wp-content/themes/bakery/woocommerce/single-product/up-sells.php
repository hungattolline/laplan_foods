<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( bakery_get_option( 'shop-show-upsells-products', true ) == false ) {
	return;
}

if ( $upsells ) : ?>
	<div class="clear"></div>
	<section class="up-sells upsells products">
		<?php 
			$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like...', 'bakery' ) );
			$subheading = apply_filters( 'woocommerce_product_upsells_products_subheading', '' );
		?>

		<?php if ( ! empty( $heading ) || ! empty( $subheading ) ) : ?>
			<header class="m-b-30 clearfix">
				<?php if ( ! empty( $heading ) ) : ?>
					<h2 class="vu_wc-heading<?php echo ( ! empty( $subheading ) ) ? ' m-b-20' : ''; ?>"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $subheading ) ) : ?>
					<p class="m-b-0"><?php echo esc_html( $subheading ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php 
			//Modified by Milingona
			$carousel_options = array(
				"singleItem" => false,
				"items" => absint( $columns ),
				"itemsDesktop" => array( 1199, $columns ),
				"itemsDesktopSmall" => array( 980, 3 ),
				"itemsTablet" => array( 768, 2 ),
				"itemsMobile" => array( 479, 1 ),
				"navigation" => false,
				"pagination" => true,
				"autoHeight" => true,
				"rewindNav" => true,
				"scrollPerPage" => false
			);
		?>

		<?php woocommerce_product_loop_start(); ?>

		<div class="row">
			<div class="vu_wc-upsells-products vu_carousel" data-options="<?php echo esc_attr( json_encode( $carousel_options ) ); ?>">
				<?php foreach ( $upsells as $upsell ) : ?>
					<?php
					 	$post_object = get_post( $upsell->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

						wc_get_template_part( 'content', 'product' ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif;

wp_reset_postdata();
