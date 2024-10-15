<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<div class="vu_bp-image">
    <a href="<?php echo ( is_single() ) ? bakery_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) : esc_url( get_permalink() ); ?>"<?php echo ( is_single() ) ? ' class="vu_lightbox"' : ''; ?>>
        <?php the_post_thumbnail( 'bakery_ratio-2:1' ); ?>
    </a>
</div>