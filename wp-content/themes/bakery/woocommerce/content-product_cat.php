<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div <?php wc_product_cat_class( 'vu_wc-category col-tn-12 col-xs-6 col-sm-4 col-md-' . absint( 12 / apply_filters( 'loop_shop_columns', 4 ) ), $category ); ?>>
	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
		<section class="vu_c-container">
			<?php $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true ); ?>
			<div class="vu_c-image vu_lazy-load" data-img="<?php echo ( ! empty( $thumbnail_id ) ) ? bakery_get_attachment_image_src( $thumbnail_id, 'full' ) : wc_placeholder_img_src(); ?>">
				<?php do_action( 'woocommerce_before_subcategory_title', $category ); ?>
			</div>

			<div class="vu_c-content">
				<h3 class="vu_c-name"><?php echo esc_html( $category->name ); ?></h3>

				<?php do_action( 'woocommerce_after_subcategory_title', $category ); ?>

				<?php 
					if ( $category->count > 0 ) {
						echo apply_filters( 'woocommerce_subcategory_count_html', '<mark class="vu_c-count">(' . esc_html( $category->count ) . ')</mark>', $category );
					}
				?>
			</div>
		</section>
	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
</div>