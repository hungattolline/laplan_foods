<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php $url = isset( $args['url'] ) ? $args['url'] : get_permalink(); ?>

<?php if ( ! is_single() ) : ?>
    <h3 class="vu_bp-title">
        <a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a>
    </h3>
<?php else : ?>
    <h1 class="vu_bp-title"><?php the_title(); ?></h1>
<?php endif; ?>