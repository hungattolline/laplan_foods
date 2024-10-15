<?php if ( ! defined( 'ABSPATH' ) ) exit();

get_header();

$bakery_page_sidebar = bakery_get_post_meta( get_option( 'page_for_posts' ), 'bakery_page_sidebar' );

$has_sidebar = bakery_has_sidebar( $bakery_page_sidebar ); ?>

<!-- Container -->
<div class="vu_container vu_tag-page <?php echo esc_attr( ( $has_sidebar == true ) ? 'vu_with-sidebar' : 'vu_no-sidebar' ); ?> clearfix">
	<div class="container">
		<div class="row">
			<div class="vu_content col-xs-12 col-sm-12 col-md-<?php echo esc_attr( ( $has_sidebar == true ) ? ( 12 - absint( $bakery_page_sidebar['layout'] ) ) . ( ( $bakery_page_sidebar['position'] == 'left' ) ? ' col-md-push-'. absint( $bakery_page_sidebar['layout'] ) : '' ) : '12' ); ?>">
				<?php if ( have_posts() ) :  ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="row">
							<div class="col-xs-12">
								<?php get_template_part( 'templates/post/' . ( get_post_format() != '' ? get_post_format() : 'standard' ) ); ?>
							</div>
						</div>
					<?php endwhile; ?>
				<?php else : ?>
					<p><?php esc_html_e( 'No posts found', 'bakery' ); ?></p>
				<?php endif; ?>
				
				<?php bakery_pagination(); ?>
			</div>

			<?php get_sidebar( '', $bakery_page_sidebar ); ?>
		</div>
	</div>
</div>
<!-- /Container -->

<?php get_footer(); ?>