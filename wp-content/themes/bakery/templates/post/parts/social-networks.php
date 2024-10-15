<?php if ( ! defined( 'ABSPATH' ) ) exit();

$url = isset( $args['url'] ) ? $args['url'] : get_permalink();
$title = isset( $args['title'] ) ? $args['title'] : get_the_title();
$post_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

if ( bakery_get_option( 'blog-social' ) ) : ?>
    <div class="vu_bp-social-networks">
        <ul class="list-unstyled">
            <?php if ( bakery_get_option( array( 'blog-social-networks', 'facebook' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="http://www.facebook.com/sharer.php?u=<?php echo esc_url( $url ); ?>&amp;t=<?php echo urlencode( $title ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( bakery_get_option( array( 'blog-social-networks', 'twitter' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="https://twitter.com/share?text=<?php echo urlencode( $title ); ?>&amp;url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( bakery_get_option( array( 'blog-social-networks', 'google-plus' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="https://plus.google.com/share?url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( bakery_get_option( array( 'blog-social-networks', 'pinterest' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( $url ); ?>&amp;description=<?php echo urlencode( $title ); ?>&amp;media=<?php echo bakery_get_attachment_image_src( $post_id, array( 705, 470 ) ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>
            
            <?php if ( bakery_get_option( array( 'blog-social-networks', 'linkedin' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="http://linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode( $title ); ?>&amp;url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( bakery_get_option( array( 'blog-social-networks', 'whatsapp' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="https://web.whatsapp.com/send?text=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( bakery_get_option( array( 'blog-social-networks', 'viber' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="viber://forward?text=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fab fa-viber" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>

            <?php if ( bakery_get_option( array( 'blog-social-networks', 'telegram' ) ) == '1' ) : ?>
                <li>
                    <a href="#" class="vu_social-link" data-href="https://telegram.me/share/url?url=<?php echo esc_url( $url ); ?>" rel="nofollow noopener noreferrer"><i class="fa fa-telegram" aria-hidden="true"></i></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif;
