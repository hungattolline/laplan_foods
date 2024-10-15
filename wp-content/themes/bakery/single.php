<?php if ( ! defined( 'ABSPATH' ) ) exit();

get_header();

$bakery_page_sidebar = bakery_get_post_meta( get_option( 'page_for_posts' ), 'bakery_page_sidebar' );

$has_sidebar = bakery_has_sidebar( $bakery_page_sidebar ); ?>

<!-- Content -->
<div class="vu_container vu_blog-single-post <?php echo esc_attr( ( $has_sidebar == true ) ? 'vu_with-sidebar' : 'vu_no-sidebar' ); ?> clearfix">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-<?php echo esc_attr( ( $has_sidebar == true ) ? ( 12 - absint( $bakery_page_sidebar['layout'] ) ) . ( ( $bakery_page_sidebar['position'] == 'left' ) ? ' col-md-push-'. absint( $bakery_page_sidebar['layout'] ) : '' ) : '12' ); ?>">
				<div class="vu_bsp-content">
					<?php 
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							get_template_part( 'templates/post/' . ( get_post_format() != '' ? get_post_format() : 'standard' ) );

							if ( is_single() ) : ?>
								<div class="vu_bp-social-tags-container">
									<div class="row">
										<div class="col-sm-6">
											<?php if ( bakery_get_option( 'blog-single-show-tags' ) && has_tag() ) : ?>
												<div class="vu_bp-tags">
													<?php the_tags( '<span>' . esc_html__( 'Tags:', 'bakery' ) . '</span>', ', ', '' ); ?>
												</div>
											<?php endif; ?>
										</div>
										<div class="col-sm-6">
											<?php get_template_part( 'templates/post/parts/social-networks' ); ?>
										</div>
									</div>
								</div>
								
								<?php if ( bakery_get_option( 'blog-single-show-next-prev' ) ) : ?>
									<div class="vu_bp-next-prev-container">
										<div class="row">
											<div class="col-sm-6">
												<div class="vu_bp-prev-link">
													<?php previous_post_link( '<i class="fa fa-angle-double-left" aria-hidden="true"></i>%link' ); ?>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="vu_bp-next-link">
													<?php next_post_link( '%link<i class="fa fa-angle-double-right" aria-hidden="true"></i>' ); ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif;
							endif;
						endwhile; endif;
					?>

					<?php wp_link_pages(); ?>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<div class="vu_bsp-comments clearfix">
							<?php comments_template(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		
			<?php get_sidebar( '', $bakery_page_sidebar ); ?>
		</div>
	</div>
</div>
<!-- /Content -->

<?php get_footer(); ?>