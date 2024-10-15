<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$bakery_product_image_id = get_post_thumbnail_id();
$bakery_product_style = bakery_get_option( 'shop-product-style', '1' );
$bakery_product_options = bakery_get_option( 'shop-product-options', array( 'show-zoom-icon' => '1', 'show-link-icon' => '1', 'show-cart-icon' => '1', 'show-title' => '1', 'show-categories' => '1', 'show-quantity' => '0', 'show-price' => '1', 'disable-link' => '0' ) );
?>

<div class="vu_wc-product-container <?php echo ( isset( $woocommerce_loop['name'] ) && ( $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] == 'up-sells' ) ) ? 'col-xs-12' : 'col-tn-12 col-xs-6 col-sm-4 col-md-' . absint( 12 / apply_filters( 'loop_shop_columns', 4 ) ); ?>">
	<article <?php wc_product_class( 'vu_wc-product vu_p-style-' . esc_attr( $bakery_product_style ) . ' clearfix' ); ?> data-id="vu_wc-<?php echo get_the_ID(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php woocommerce_show_product_loop_sale_flash(); ?>

			<?php if ( $bakery_product_style == '1' || $bakery_product_style == '2' ) : ?>
				<div class="vu_p-image vu_p-img-<?php echo esc_attr( bakery_get_option( 'shop-product-image-display', 'portrait' ) ); ?> vu_lazy-load" data-img="<?php echo bakery_get_attachment_image_src( $bakery_product_image_id, 'full' ); ?>">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'bakery_ratio-1:1' ); ?>
					</a>
					<?php if ( $bakery_product_options['disable-link'] != '1' ) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'bakery_ratio-1:1' ); ?>
						</a>
					<?php else : ?>
						<span><?php the_post_thumbnail( 'bakery_ratio-1:1' ); ?></span>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<div class="vu_p-image vu_lazy-load" data-img="<?php echo bakery_get_attachment_image_src( $bakery_product_image_id, 'full' ); ?>">
					<span><?php the_post_thumbnail( 'bakery_ratio-1:1' ); ?></span>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<div class="vu_p-content<?php echo esc_attr( ( $bakery_product_style == '1' || $bakery_product_style == '2' ) ? ' vu_p-content-' . bakery_get_option( 'shop-product-content-display', 'hover' ) : '' ); ?>">
			<?php if ( $bakery_product_options['show-zoom-icon'] == '1' || $bakery_product_options['show-link-icon'] == '1' || $bakery_product_options['show-cart-icon'] == '1' ) : ?>
				<div class="vu_p-icons">
					<?php if ( $bakery_product_options['show-zoom-icon'] == '1' ) : ?>
						<a href="<?php echo esc_url( bakery_get_attachment_image_src( $bakery_product_image_id, 'full' ) ); ?>" title="<?php the_title(); ?>" class="vu_p-icon vu_p-i-zoom vu_lightbox"><i class="fa fa-search" aria-hidden="true"></i></a>
					<?php endif; ?>

					<?php if ( $bakery_product_options['show-link-icon'] == '1' ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="vu_p-icon vu_p-i-link"><i class="fa fa-link" aria-hidden="true"></i></a>
					<?php endif; ?>

					<?php if ( $bakery_product_options['show-cart-icon'] == '1' and !bakery_wc_ywctm_check_hide_add_cart_loop() ) : ?>
						<?php woocommerce_template_loop_add_to_cart(); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $bakery_product_options['show-title'] == '1' ) : ?>
				<h3 class="vu_p-name">
					<?php if ( $bakery_product_options['disable-link'] != '1' ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					<?php else : ?>
						<?php the_title(); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<?php if ( $bakery_product_options['show-categories'] == '1' ) :
				$bakery_product_categories = bakery_wc_product_terms( get_the_ID(), false, ', ', false, 'product_cat' );
				if ( ! empty( $bakery_product_categories ) ) : ?>
					<div class="vu_p-categories">
						<p><?php echo esc_html( $bakery_product_categories ); ?></p>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( isset( $bakery_product_options['show-quantity'] ) && $bakery_product_options['show-quantity'] == '1' ) : ?>
				<div class="vu_p-quantity">
					<?php woocommerce_quantity_input( array(), $product, true ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $bakery_product_options['show-price'] == '1' ) : ?>
				<?php woocommerce_template_loop_price(); ?>
			<?php endif; ?>
		</div>
	</article>
</div>
