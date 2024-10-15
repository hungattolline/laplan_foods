<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vu_blog-post vu_bp-type-aside' ); ?>>
	<div class="vu_bp-content-wrapper">
		<div class="vu_bp-content">
			<div class="vu_bp-content-full">
				<?php 
					$bakery_post_format_settings = bakery_get_post_meta( $post->ID, 'bakery_post_format_settings' );

					if ( ! empty( $bakery_post_format_settings['aside']['content'] ) ) {
						echo wpautop( esc_html( $bakery_post_format_settings['aside']['content'] ) );
					} else {
						the_content();
					}
				?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</article>
