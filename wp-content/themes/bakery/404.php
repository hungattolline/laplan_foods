<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php get_header(); ?>

<!-- Container -->
<div class="vu_container clearfix">
	<div class="container">
		<div class="row">
			<div class="vu_content col-xs-12">
				<div class="vu_error-page">
					<div class="vu_ep-404"><?php esc_html_e( '404!', 'bakery' ); ?></div>

					<div class="vu_ep-content clearfix">
						<h2 class="vu_ep-title">
							<?php 
								if ( !empty( bakery_get_option( 'error-page-heading', '' ) ) ) {
									echo esc_html( bakery_get_option( 'error-page-heading' ) );
								} else {
									esc_html_e( 'The requested page cannot be found', 'bakery' );
								}
							?>
						</h2>

						<p class="vu_ep-desc">
							<?php 
								if ( ! empty( bakery_get_option( 'error-page-description', '' ) ) ) {
									echo wp_kses( bakery_get_option( 'error-page-description' ), array( 'br' => array() ) );
								} else {
									echo wp_kses( __( 'Sorry but the page you are looking for cannot be found.<br>Please make sure you have typed the correct url.', 'bakery' ), array( 'br' => array() ) );
								}
							?>
						</p>
						
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vu_ep-btn btn btn-secondary btn-default">
							<?php 
								if ( ! empty( bakery_get_option( 'error-page-btn-text', '' ) ) ) {
									echo esc_html( bakery_get_option( 'error-page-btn-text' ) );
								} else {
									esc_html_e( 'Return to home', 'bakery' );
								}
							?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Container -->

<?php get_footer(); ?>
