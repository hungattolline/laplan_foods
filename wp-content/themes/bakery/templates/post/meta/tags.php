<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php if ( ! is_single() && bakery_get_option( 'blog-show-tags' ) && has_tag() ) : ?>
    <span class="vu_bp-m-item vu_bp-tags">
        <i class="fa fa-tags" aria-hidden="true"></i>
        <?php the_tags( '', ', ' ,'' ); ?>
    </span>
<?php endif; ?>