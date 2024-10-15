<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! class_exists( 'Bakery_WC_Actions' ) ) {
	class Bakery_WC_Actions {
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
			add_action( 'wp_head', array( $this, 'wp_head' ) );
			add_action( 'wp_footer', array( $this, 'wp_footer' ) );
			add_action( 'woocommerce_share', array( $this, 'woocommerce_share' ) );
			add_action( 'bakery/wc/responsive_basket_icon', array( $this, 'wc_responsive_basket_icon' ) );
		}

		// Theme initialization
		function init() {
			wp_register_style( 'bakery-woocommerce', BAKERY_THEME_ASSETS . 'css/woocommerce.css', array( 'bakery-main' ), BAKERY_THEME_VERSION );
			wp_register_script( 'bakery-woocommerce', BAKERY_THEME_ASSETS . 'js/woocommerce.js', array( 'jquery', 'bakery-main' ), BAKERY_THEME_VERSION, true );
			
			// Config Object
			wp_localize_script( 'bakery-woocommerce', 'bakery_wc_config',
				array(
					'shop_url' => esc_url( wc_get_page_permalink( 'shop' ) ),
					'cart_url' => esc_url( wc_get_cart_url() ),
					'checkout_url' => esc_url( wc_get_checkout_url() ),
					'version' => BAKERY_THEME_VERSION
				)
			);

			if ( function_exists( 'is_shop' ) && is_shop() ) {
				$shop_page_id = wc_get_page_id( 'shop' );
				$shop_page = get_post( $shop_page_id );

				if ( ! function_exists( 'visual_composer' ) ) {
					return;
				}

				$vc_shortcodes_custom_css = visual_composer()->parseShortcodesCustomCss( $shop_page->post_content );

				wp_add_inline_style( 'bakery-woocommerce', $vc_shortcodes_custom_css );
			}
		}

		// Enqueue Scripts
		function wp_enqueue_scripts() {
			wp_enqueue_style( 'bakery-woocommerce' );
		}

		// Head Init
		function wp_head() {
			echo '<style type="text/css" id="bakery_wc-custom-css">' . bakery_wc_custom_css() . '</style>';
		}

		// Footer Init
		function wp_footer() {
			if ( bakery_get_option( 'shop-show-basket-icon', false ) == true ) {
				wp_enqueue_script( 'wc-cart-fragments' );
			}

			wp_enqueue_script( 'bakery-woocommerce' );
		}
		
		// Print Product Socials Networks
		function woocommerce_share() {
			global $post;

			$url = get_permalink();
			$title = get_the_title();
			$post_id = get_the_ID();

			if ( bakery_get_option( 'shop-show-product-socials' ) ) : ?>
				<div class="vu_wc-product-social-networks vu_product-social-networks clearfix">
					<ul class="list-unstyled">
						<?php if ( bakery_get_option( array( 'shop-product-socials', 'facebook' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="http://www.facebook.com/sharer.php?u=<?php echo esc_url( $url ); ?>&amp;t=<?php echo urlencode( $title ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-facebook"></i></a>
							</li>
						<?php endif; ?>

						<?php if ( bakery_get_option( array( 'shop-product-socials', 'twitter' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="https://twitter.com/share?text=<?php echo urlencode( $title ); ?>&amp;url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-twitter"></i></a>
							</li>
						<?php endif; ?>

						<?php if ( bakery_get_option( array( 'shop-product-socials', 'google-plus' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="https://plus.google.com/share?url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-google-plus"></i></a>
							</li>
						<?php endif; ?>

						<?php if ( bakery_get_option( array( 'shop-product-socials', 'pinterest' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( $url ); ?>&amp;description=<?php echo urlencode( $title ); ?>&amp;media=<?php echo bakery_get_attachment_image_src( $post_id, array( 705, 470 ) ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-pinterest"></i></a>
							</li>
						<?php endif; ?>

						<?php if ( bakery_get_option( array( 'shop-product-socials', 'linkedin' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="http://linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode( $title ); ?>&amp;url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-linkedin"></i></a>
							</li>
						<?php endif; ?>

						<?php if ( bakery_get_option( array( 'shop-product-socials', 'whatsapp' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="https://web.whatsapp.com/send?text=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-whatsapp"></i></a>
							</li>
						<?php endif; ?>
						
						<?php if ( bakery_get_option( array( 'shop-product-socials', 'viber' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="viber://forward?text=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fab fa-viber"></i></a>
							</li>
						<?php endif; ?>

						<?php if ( bakery_get_option( array( 'shop-product-socials', 'telegram' ) ) == '1' ) : ?>
							<li>
								<a href="#" class="vu_social-link" data-href="https://telegram.me/share/url?url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-telegram"></i></a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
		<?php 
			endif;
		}

		// Show responsive basket icon
		function wc_responsive_basket_icon() { 
			if ( bakery_get_option( 'shop-show-basket-icon', false ) == true ) :
				ob_start(); ?>

				<div class="vu_wc-menu-item vu_wc-responsive">
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="vu_wc-cart-link"><span><i class="fa fa-shopping-cart"></i><span class="vu_wc-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span></span></a>
					
					<div class="vu_wc-menu-container">
						<div class="vu_wc-cart-notification"><span class="vu_wc-item-name"></span><?php esc_html_e( 'was successfully added to your cart.', 'bakery' ); ?></div>
						<div class="vu_wc-cart widget woocommerce widget_shopping_cart"><?php woocommerce_mini_cart(); ?></div>
					</div>
				</div>
				
			<?php 
				echo ob_get_clean();
			endif;
		}
	}
}

$Bakery_WC_Actions = new Bakery_WC_Actions();
