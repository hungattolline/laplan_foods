<?php if ( ! defined( 'ABSPATH' ) ) exit();

$title = $el_class = $open = '';

/**
 * @var string $title
 * @var string $el_class
 * @var string $open
 *
 * @var array $atts
 */
extract( shortcode_atts( array(
	'title' => esc_html__( "Click to toggle", 'bakery' ),
	'el_class' => '',
	'open' => 'false'
), $atts ) );

$elementClass = array(
	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle', $this->settings['base'], $atts ),
	'open' => ( $open == 'true' ) ? 'vc_toggle_active' : '',
	'extra' => $this->getExtraClass( $el_class ),
);

$elementClass = trim( preg_replace( '/\s+/', ' ', implode( ' ', $elementClass ) ) ); ?>
<div class="vu_toggle <?php echo esc_attr( $elementClass ); ?>">
	<div class="vu_t-title vc_toggle_title clearfix">
		<i class="vu_t-active-icon fa fa-angle-down" aria-hidden="true"></i>
		<i class="vu_t-inactive-icon fa fa-angle-up" aria-hidden="true"></i>
		<?php echo apply_filters( 'wpb_toggle_heading', '<h4>' . esc_html( $title ) . '</h4>', array('title' => $title, 'open' => $open) ); ?>
	</div>
	<div class="vu_t-content vc_toggle_content">
		<div class="vu_t-content-inner vc_toggle_content_inner">
			<?php echo bakery_remove_wpautop( apply_filters( 'the_content', $content ), true ); ?>
		</div>
	</div>
</div>