<?php if ( ! defined( 'ABSPATH' ) ) exit(); ?>

<span class="vu_bp-m-item vu_bp-comments">
    <i class="fa fa-comment-o" aria-hidden="true"></i>
    <a href="<?php comments_link(); ?>"><?php comments_number( esc_html__( 'No Comments', 'bakery' ), esc_html__( 'One Comment ', 'bakery' ), esc_html__( '% Comments', 'bakery' ) ); ?></a>
</span>