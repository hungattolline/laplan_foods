<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php if ( ! is_single() ) : ?>
    <div class="vu_bp-content-excerpt"><?php the_excerpt(); ?></div>
    <div class="clear"></div>
    <?php get_template_part( 'templates/post/parts/read-more' ); ?>
<?php else : ?>
    <div class="vu_bp-content-full">
        <?php the_content(); ?>
    </div>
<?php endif; ?>