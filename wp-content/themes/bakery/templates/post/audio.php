<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vu_blog-post vu_bp-type-audio' ); ?>>
	<?php $bakery_post_format_settings = bakery_get_post_meta( $post->ID, 'bakery_post_format_settings' ); ?>

	<?php if ( ! empty( $bakery_post_format_settings['audio']['mp3-file-url'] ) || ! empty( $bakery_post_format_settings['audio']['oga-file-url'] ) ) : ?>
		<div class="vu_bp-image">
			<audio class="wp-audio-shortcode" style="width: 100%; visibility: hidden;" preload="none" controls="controls">
				<?php if ( ! empty( $bakery_post_format_settings['audio']['oga-file-url'] ) ) : ?>
					<source src="<?php echo esc_url( $bakery_post_format_settings['audio']['oga-file-url'] ); ?>" type="audio/ogg">
				<?php endif; ?>
				<?php if ( ! empty( $bakery_post_format_settings['audio']['mp3-file-url'] ) ) : ?>
					<source src="<?php echo esc_url( $bakery_post_format_settings['audio']['mp3-file-url'] ); ?>" type="audio/mpeg">
				<?php endif; ?>	
				<?php echo esc_html__( 'Your browser does not support the audio element.', 'bakery' ); ?>
			</audio>
		</div>
	<?php elseif ( has_post_thumbnail() ) : ?>
		<?php get_template_part( 'templates/post/parts/image' ); ?>
	<?php endif; ?>
	
	<div class="vu_bp-content-wrapper">
		<header class="vu_bp-header">
			<?php get_template_part( 'templates/post/parts/title' ); ?>
			
			<div class="vu_bp-meta">
				<?php get_template_part( 'templates/post/meta/date' ); ?>

				<?php get_template_part( 'templates/post/meta/author' ); ?>

				<?php get_template_part( 'templates/post/meta/categories' ); ?>

				<?php get_template_part( 'templates/post/meta/comments' ); ?>

				<?php get_template_part( 'templates/post/meta/tags' ); ?>

				<div class="clear"></div>
			</div>					
			<div class="clear"></div>
		</header>

		<div class="vu_bp-content">
			<?php get_template_part( 'templates/post/parts/content' ); ?>
		</div>
	</div>
	<div class="clear"></div>
</article>
