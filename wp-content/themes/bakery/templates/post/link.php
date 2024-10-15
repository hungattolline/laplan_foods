<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vu_blog-post vu_bp-type-link' ); ?>>
	<div class="vu_bp-content-wrapper">
		<?php $bakery_post_format_settings = bakery_get_post_meta( $post->ID, 'bakery_post_format_settings' ); ?>

		<header class="vu_bp-header">
			<?php 
				get_template_part( 'templates/post/parts/title', '', array(
					'url' => ( ! empty( $bakery_post_format_settings['link']['url'] ) ) ? esc_url( $bakery_post_format_settings['link']['url'] ) : '#'
				) );
			?>
			<div class="clear"></div>
		</header>

		<div class="vu_bp-content">
			<div class="vu_bp-content-excerpt">
				<?php echo wpautop( $bakery_post_format_settings['link']['url'] ); ?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</article>
