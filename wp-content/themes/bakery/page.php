<?php if ( ! defined( 'ABSPATH' ) ) exit();

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post(); 
	$bakery_page_sidebar = bakery_get_post_meta( $post->ID, 'bakery_page_sidebar' );

	$has_sidebar = bakery_has_sidebar( $bakery_page_sidebar ); ?>
	
	<!-- Container -->
	<div class="vu_container<?php echo has_shortcode( $post->post_content, 'vc_row' ) ? ' vu_c-type-fullwidth' : ''; ?> <?php echo esc_attr( ( $has_sidebar == true ) ? 'vu_with-sidebar' : 'vu_no-sidebar' ); ?> clearfix">
		<div class="container">
			<div class="row">
				<div class="vu_content col-xs-12 col-sm-12 col-md-<?php echo esc_attr( ( $has_sidebar == true ) ? ( 12 - absint( $bakery_page_sidebar['layout'] ) ) . ( ( $bakery_page_sidebar['position'] == 'left' ) ? ' col-md-push-'. absint( $bakery_page_sidebar['layout'] ) : '' ) : '12' ); ?>">
					<?php the_content(); ?>

					<?php bakery_wp_link_pages(); ?>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<div class="clear"></div>
						<div class="vu_page-comments container m-t-30">
							<?php comments_template(); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php get_sidebar( '', $bakery_page_sidebar ); ?>
			</div>
		</div>
	</div>
	<!-- /Container -->

<?php endwhile; endif;

get_footer();
