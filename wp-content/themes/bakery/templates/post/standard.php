<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vu_blog-post vu_bp-type-standard' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
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
