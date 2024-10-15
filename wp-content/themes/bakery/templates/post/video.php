<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vu_blog-post vu_bp-type-video' ); ?>>
	<?php $bakery_post_format_settings = bakery_get_post_meta( $post->ID, 'bakery_post_format_settings' ); ?>

	<?php if ( ! empty( $bakery_post_format_settings['video']['embed-code'] ) ) : ?>
		<div class="vu_bp-image">
			<?php 
				echo do_shortcode( bakery_generate_shortcode( 'vu_embed', array(
					"src" => esc_attr( $bakery_post_format_settings['video']['embed-code'] )
				) ) );
			?>
		</div>
	<?php elseif ( ! empty( $bakery_post_format_settings['video']['m4v'] ) || ! empty( $bakery_post_format_settings['video']['ogg'] ) ) : ?>
		<div class="vu_bp-image">
			<div class="embed-responsive embed-responsive-<?php echo str_replace( ':', 'by', bakery_get_option( 'blog-image-ratio', '2:1' ) ); ?>">
				<video class="embed-responsive-item" controls poster="<?php echo esc_url( $bakery_post_format_settings['video']['poster'] ); ?>">
					<?php if ( ! empty( $bakery_post_format_settings['video']['m4v'] ) ) : ?>
						<source src="<?php echo esc_url( $bakery_post_format_settings['video']['m4v'] ); ?>" type="video/mp4">
					<?php endif; ?>
					<?php if ( ! empty( $bakery_post_format_settings['video']['ogg'] ) ) : ?>
						<source src="<?php echo esc_url( $bakery_post_format_settings['video']['ogg'] ); ?>" type="video/ogg">
					<?php endif; ?>
					<?php esc_html_e( 'Your browser does not support the video tag.', 'bakery' ); ?>
				</video>
			</div>
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
