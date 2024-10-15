<?php if ( ! defined( 'ABSPATH' ) ) exit();

$has_sidebar = bakery_has_sidebar( $args );

if ( $has_sidebar ) : ?>
	<?php do_action( 'bakery/sidebar/before', $args ); ?>

	<aside class="vu_sidebar vu_s-<?php echo esc_attr( $args['sidebar'] ); ?> col-xs-12 col-md-<?php echo absint( $args['layout'] ) . ( ( $args['position'] == 'left' ) ? ' vu_s-position-left col-md-pull-' . ( 12 - absint( $args['layout'] ) ) : ' vu_s-position-right' ); ?>">
		<?php do_action( 'bakery/sidebar/widgets/before' ); ?>
		<?php bakery_dynamic_sidebar( $args['sidebar'] ); ?>
		<?php do_action( 'bakery/sidebar/widgets/after' ); ?>
	</aside>

	<?php do_action( 'bakery/sidebar/after', $args ); ?>
<?php endif; ?>