<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php if ( bakery_get_option( 'blog-show-author' ) ) : ?>
    <span class="vu_bp-m-item vu_bp-author">
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php esc_attr_e( 'Posts by', 'bakery' ); ?> <?php the_author(); ?>"><span><?php the_author(); ?></span></a>
    </span>
<?php endif; ?>