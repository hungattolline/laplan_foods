<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php if ( bakery_get_option( 'blog-show-date' ) ) : ?>
    <span class="vu_bp-m-item vu_bp-date">
        <i class="fa fa-calendar-o" aria-hidden="true"></i>
        <a href="<?php echo esc_url( get_permalink() ); ?>">
            <time class="published"><?php echo get_the_date(); ?></time>
        </a>
    </span>
<?php endif; ?>