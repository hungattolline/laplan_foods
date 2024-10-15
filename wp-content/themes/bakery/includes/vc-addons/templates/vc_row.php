<?php if ( ! defined( 'ABSPATH' ) ) exit();

$atts = shortcode_atts( array(
	"content_layout" => "",
	"equal_height" => "",
	"css_animation" => "",
	"animation_delay" => "",
	"disable" => "",
	"id" => "",
	"class" => "",
	"bg_type" => "",
	"bg_image" => "",
	"bg_video" => "",
	"color_overlay" => "",
	"enable_parallax" => "",
	"enable_pattern" => "",
	"pattern_image" => "",
	"pattern_opacity" => "",
	"css" => ""
), $atts );

// Variables
$custom_class = 'vu_r-custom-'. rand(100000, 999999);
$custom_css = '';

// Get bg image url from css code
if ( preg_match('~\bbackground(-image)?\s*:(.*?)\(\s*(\'|")?(?<image>.*?)\3?\s*\)~i', $atts['css'], $match) ) {
	$atts['bg_image'] = $match['image'];
} else {
	if ( !empty($atts['bg_image']) ) {
		$atts['bg_image'] = bakery_get_attachment_image_src($atts['bg_image'], 'full');
		$custom_css .= '.vu_row .'. esc_attr($custom_class) .'{background-image:url('. esc_url($atts['bg_image']) .')}';
	}
}

// Image background
if ( $atts['bg_type'] == 'image' and !empty($atts['bg_image']) ) {
	$atts['class'] .= ' vu_r-bg-image';
}

// Video background
if ( $atts['bg_type'] == 'video' and !empty($atts['bg_video']) ) {
	$atts['class'] .= ' vu_r-bg-video';

	$video_property = array();

	$video_property['videoURL'] = esc_url($atts['bg_video']);
	$video_property['containment'] = 'self';
	$video_property['showControls'] = false;
	$video_property['autoPlay'] = true;
	$video_property['mute'] = true;
	$video_property['loop'] = true;
	$video_property['showYTLogo'] = false;
	$video_property['opacity'] = 1;
}

// Equal height css class
if ( $atts['equal_height'] == 'true' ) {
	$atts['class'] .= ' vu_r-equal-height';
}

// Color overlay css class
if ( !empty($atts['color_overlay']) ) {
	$atts['class'] .= ' vu_r-color-overlay';
	$custom_css .= '.vu_row .'. esc_attr($custom_class) .'.vu_r-wrapper.vu_r-color-overlay:before{background-color:'. esc_attr($atts['color_overlay']) .'}';
}

// Pattern overlay css class
if ( $atts['enable_pattern'] == 'true' && !empty($atts['pattern_image']) ) {
	$atts['class'] .= ' vu_r-pattern-overlay';
	$custom_css .= '.vu_row .'. esc_attr($custom_class) .'.vu_r-wrapper.vu_r-pattern-overlay:after{background-image:url('. esc_url(bakery_get_attachment_image_src($atts['pattern_image'], 'full')) .');'. (!empty($atts['pattern_opacity']) ? 'opacity:'. esc_attr($atts['pattern_opacity']) : '') .'}';
}

// Disable element
if ( $atts['disable'] == 'true' ) {
	$atts['class'] .= ' hide';
}

// VU custom css class
$atts['class'] .= ' '. $custom_class;

// VC custom css class
if( function_exists('vc_shortcode_custom_css_class') ) {
	$atts['class'] .= ' '. vc_shortcode_custom_css_class( $atts['css'] );
}

// Animation delay
$atts['animation_delay'] = absint($atts['animation_delay']);

ob_start(); ?>
<div<?php echo !empty($atts['id']) ? ' id="'. esc_attr($atts['id']) .'"' : ''; ?> class="vu_row row vu_r-layout-<?php echo esc_attr($atts['content_layout']); ?>">
	<?php echo !empty($custom_css) ? '<style scoped>'. $custom_css .'</style>' : ''; ?>
	<div class="vu_r-wrapper<?php bakery_extra_class($atts['class']); ?>"<?php echo '' . ( $atts['enable_parallax'] == 'true' && !empty( $atts['bg_image'] ) ) ? ' data-parallax="scroll" data-parallax-image="'. esc_url( $atts['bg_image'] ) .'" data-parallax-speed="1"' : ''; ?><?php echo '' . ( $atts['bg_type'] == 'video' && ! empty( $atts['bg_video'] ) ) ? ' data-property="'. esc_attr( json_encode( $video_property ) ) .'"' : ''; ?><?php echo '' . ( $atts['css_animation'] != 'none' && $atts['css_animation'] != '' ) ? ' data-animation="'. esc_attr( $atts['css_animation'] ) .'"' . ( ( $atts['animation_delay'] > 0 ) ? ' data-delay="'. $atts['animation_delay'] .'"' : '' ) : ''; ?>>
		<div class="vu_r-content <?php echo '' . ( $atts['content_layout'] == 'boxed' ) ? 'container' : 'clearfix'; ?>">
			<?php echo bakery_remove_wpautop( $content ); ?>
		</div>
	</div>
</div>
<?php echo ob_get_clean(); ?>