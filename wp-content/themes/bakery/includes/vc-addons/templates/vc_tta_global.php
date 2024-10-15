<?php if ( ! defined( 'ABSPATH' ) ) exit();

/**
 * Tabs, Tours and Accordions
 * 
 * Modified by Milingona
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

// Get all sections
preg_match_all('/\[(\[?)(vc_tta_section)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', $content, $sections_matches);

if( $this->getShortcode() === 'vc_tta_tabs' ) : ?>
<div class="vu_tabs wpb_tabs wpb_content_element vu_t-style-<?php echo esc_attr($atts['style']); ?> vu_t-nav-<?php echo esc_attr($atts['position']); ?> vu_t-nav-<?php echo esc_attr($atts['alignment']); ?><?php bakery_extra_class($atts['class']); ?>" data-interval="<?php echo esc_attr($atts['autoplay']); ?>">
	<div class="vu_t-wrapper wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">
		<ul class="vu_t-nav wpb_tabs_nav ui-tabs-nav vc_clearfix">
			<?php 
				if( isset($sections_matches[3]) && !empty($sections_matches[3]) ) {
					foreach ($sections_matches[3] as $value) {
						$section_atts = shortcode_parse_atts($value);

						echo '<li class="vu_t-nav-item"><a href="#'. esc_attr($section_atts['tab_id']) .'">'. esc_html($section_atts['title']) .'</a></li>';
					}
				}
			?>
		</ul>
		<?php 
			if( isset($sections_matches[5]) && !empty($sections_matches[5]) ) {
				foreach ($sections_matches[5] as $key => $section_content) {
					$section_atts = shortcode_parse_atts($sections_matches[3][$key]);
				?>
					<div id="<?php echo esc_attr($section_atts['tab_id']); ?>" class="vu_t-panel wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix<?php bakery_extra_class($section_atts['class']); ?>">
						<?php echo do_shortcode($section_content); ?>
					</div>
				<?php 
				}
			}
		?>
	</div>
</div>
<?php elseif ( $this->getShortcode() === 'vc_tta_tour' ) : ?>
<div class="vu_tour wpb_tour wpb_content_element default vu_t-nav-<?php echo esc_attr($atts['position']); ?><?php bakery_extra_class($atts['class']); ?>" data-interval="<?php echo esc_attr($atts['autoplay']); ?>">
	<div class="vu_t-wrapper wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">
		<ul class="vu_t-nav wpb_tabs_nav ui-tabs-nav vc_clearfix">
			<?php 
				if( isset($sections_matches[3]) && !empty($sections_matches[3]) ) {
					foreach ($sections_matches[3] as $value) {
						$section_atts = shortcode_parse_atts($value);

						echo '<li class="vu_t-nav-item"><a href="#'. esc_attr($section_atts['tab_id']) .'">'. esc_html($section_atts['title']) .'</a></li>';
					}
				}
			?>
		</ul>
		<?php 
			if( isset($sections_matches[5]) && !empty($sections_matches[5]) ) {
				foreach ($sections_matches[5] as $key => $section_content) {
					$section_atts = shortcode_parse_atts($sections_matches[3][$key]);
				?>
					<div id="<?php echo esc_attr($section_atts['tab_id']); ?>" class="vu_t-panel wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix<?php bakery_extra_class($section_atts['class']); ?>">
						<?php echo do_shortcode($section_content); ?>
					</div>
				<?php 
				}
			}
		?>
	</div>
</div>
<?php else : ?>
<div class="vu_accordion wpb_accordion wpb_content_element not-column-inherit<?php bakery_extra_class($atts['class']); ?>" data-collapsible="<?php echo (isset($atts['collapsible_all']) && !empty($atts['collapsible_all'])) ? 'yes' : 'no'; ?>" data-vc-disable-keydown="false" data-active-tab="<?php echo absint($atts['active_section']); ?>">
	<div class="vu_a-wrapper wpb_wrapper wpb_accordion_wrapper ui-accordion">
		<?php 
			if( isset($sections_matches[5]) && !empty($sections_matches[5]) ) {
				foreach ($sections_matches[5] as $key => $section_content) {
					$section_atts = shortcode_parse_atts($sections_matches[3][$key]);
				?>
					<div class="vu_a-section wpb_accordion_section group">
						<h3 class="vu_a-header wpb_accordion_header ui-accordion-header"><a href="#<?php echo esc_attr($section_atts['tab_id']); ?>"><?php echo esc_html($section_atts['title']); ?></a></h3>
						<div class="vu_a-content wpb_accordion_content ui-accordion-content vc_clearfix">
							<?php echo do_shortcode($section_content); ?>
						</div>
					</div>
				<?php 
				}
			}
		?>
	</div>
</div>
<?php endif; ?>