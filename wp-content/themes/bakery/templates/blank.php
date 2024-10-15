<?php 
	/*
		Template Name: Blank
	*/

	if ( ! defined( 'ABSPATH' ) ) exit();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo("charset") ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php do_action( 'bakery/header/before' ); ?>
	
	<!-- Main Container -->
	<div class="vu_main-container<?php echo ( bakery_get_option( 'boxed-layout' ) == true ) ? ' boxed' : ''; ?>">
		<?php 
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();

					the_content();
				endwhile;
			endif;
		?>
	</div><!-- /Main Container -->

	<?php wp_footer(); ?>
</body>
</html>