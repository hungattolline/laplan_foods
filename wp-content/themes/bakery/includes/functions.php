<?php if ( ! defined( 'ABSPATH' ) ) exit();

// Main Menu Wrap
if ( ! function_exists( 'bakery_main_menu_wrap' ) ) {
	function bakery_main_menu_wrap() {
		return '<ul id="%1$s" class="%2$s' . ( trim( bakery_get_option( array( 'main-sub-menu-typography', 'text-align' ) ) ) != '' ? ' vu_mm-submenu-' . bakery_get_option( array( 'main-sub-menu-typography', 'text-align' ) ) : '' ) . '">%3$s</ul>';
	}
}

// Main Menu fallback_cb
if ( ! function_exists( 'bakery_main_menu_fallback_cb' ) ) {
	function bakery_main_menu_fallback_cb( $menu_location = 'main-menu-full' ) {
		$nav_menu_locations = get_theme_mod( 'nav_menu_locations' );
		
		if ( ! isset( $nav_menu_locations[ $menu_location ] ) || $nav_menu_locations[ $menu_location ] == 0 ) {
			$menu = wp_page_menu(
				array(
					'menu_id'     => 'vu_mm-top',
					'menu_class'  => 'vu_mm-list vu_mm-top list-unstyled',
					'container'   => 'ul',
					'echo'        => false,
					'before'      => '',
					'after'       => ''
				)
			);

			$menu = preg_replace( "/class='children'/", "class='children sub-menu'", $menu );

			$menu = preg_replace( "/page_item_has_children/", "page_item_has_children menu-item-has-children", $menu );

			echo preg_replace( "/current_page_item/", "current_page_item current-menu-item", $menu );
		}
	}
}

// Print Page Header
if ( ! function_exists( 'bakery_page_header' ) ) {
	function bakery_page_header( $post_id, $title = null, $subtitle = null, $bg = null ) {
		$bakery_page_header_settings = bakery_get_post_meta( $post_id, 'bakery_page_header_settings' );

		if ( apply_filters( 'bakery/page_header/show', true, $post_id ) == false ) {
			return;
		}

		$page_header_style = ( ! isset( $bakery_page_header_settings['style'] ) || $bakery_page_header_settings['style'] == 'inherit' || empty( $bakery_page_header_settings['style'] ) ) ? bakery_get_option( 'page-header-style' ) : $bakery_page_header_settings['style'];

		if ( empty( $title ) ) {
			if ( ! empty( $bakery_page_header_settings['title'] ) ) {
				$title = $bakery_page_header_settings['title'];
			} else if ( is_front_page() && is_home() ) {
				$title = esc_html__( 'Latest Posts', 'bakery' );
			} else if ( is_single() && get_post_type() != 'product' ) {
				$title = ( get_option( 'page_for_posts', false ) != false ) ? get_the_title( get_option( 'page_for_posts' ) ) : esc_html__( 'Latest Posts', 'bakery' );
			} else {
				$title = get_the_title( $post_id );
			}
		}

		$title = apply_filters( 'bakery/page_header/title', $title, $post_id );

		if ( empty( $subtitle ) ) {
			$subtitle = ( isset( $bakery_page_header_settings['subtitle'] ) ) ? $bakery_page_header_settings['subtitle'] : '';
		}

		$subtitle = apply_filters( 'bakery/page_header/subtitle', $subtitle, $post_id );

		$breadcrumbs = ( isset( $bakery_page_header_settings['breadcrumbs']['show'] ) && ( $bakery_page_header_settings['breadcrumbs']['show'] == 'yes' || ( $bakery_page_header_settings['breadcrumbs']['show'] == 'inherit' && bakery_get_option( 'page-header-breadcrumbs-show', true ) == true ) ) ) ? true : false;

		$height = ( empty( $bakery_page_header_settings['height'] ) ) ? bakery_get_option( 'page-header-height' ) : $bakery_page_header_settings['height'];

		$height = apply_filters( 'bakery/page_header/height', $height, $post_id );

		if ( empty( $bg ) ) {
			$bg = ( isset( $bakery_page_header_settings['bg'] ) ) ? absint( $bakery_page_header_settings['bg'] ) : false;
		}

		if ( empty( $bg ) ) {
			$bg = absint( bakery_get_option( array( 'page-header-bg-image', 'id' ) ) );
		}

		$bg = apply_filters( 'bakery/page_header/bg', $bg, $post_id );

		$parallax = ( isset( $bakery_page_header_settings['parallax'] ) && ( $bakery_page_header_settings['parallax'] == 'yes' || ( $bakery_page_header_settings['parallax'] == 'inherit' && bakery_get_option( 'page-header-parallax' ) == true ) ) ) ? true : false;

		$parallax = apply_filters( 'bakery/page_header/parallax', $parallax, $post_id );

		$color_overlay = ( ! empty( $bakery_page_header_settings['color-overlay'] ) ) ? $bakery_page_header_settings['color-overlay'] : ( ( trim( bakery_get_option( 'page-header-color-overlay' ) != '' ) ) ? 'rgba(' . bakery_hex2rgb( bakery_get_option( 'page-header-color-overlay' ), true ) . ',' . bakery_get_option( 'page-header-color-overlay-opacity' ) . ')' : '' );

		$color_overlay = apply_filters( 'bakery/page_header/color_overlay', $color_overlay, $post_id );

		$extra_class = array();

		if ( bakery_get_option( array( 'page-header-others-options', 'border' ) ) == true ) {
			array_push( $extra_class, 'vu_ph-with-border' );
		}

		if ( bakery_get_option( array( 'page-header-others-options', 'pattern' ) ) == true ) {
			array_push( $extra_class, 'vu_ph-with-pattern' );
		}

		?>
			<!-- Page Header -->
			<section class="vu_page-header vu_ph-style-<?php echo esc_attr( $page_header_style ); ?><?php echo ( ! empty( $bg ) ) ? ' vu_ph-with-bg' : ''; ?><?php echo ( ! empty( $bg ) && $parallax != true ) ? ' vu_lazy-load' : ''; ?><?php echo ( isset( $extra_class ) ) ? ' ' . implode( ' ', (array) $extra_class ) : ''; ?>"<?php echo ( ! empty( $bg ) && $parallax == true ) ? ' data-parallax="scroll" data-parallax-image="' . bakery_get_attachment_image_src( $bg, 'full' ) . '" data-parallax-speed="1"' : ' data-img="' . bakery_get_attachment_image_src( $bg, 'full' ) . '"'; ?>>
				<style scoped>
					.vu_page-header { height: <?php echo absint( $height ); ?>px; }
					<?php echo ( ! empty( $color_overlay ) && ! empty( $bg ) ) ? '.vu_page-header.vu_ph-with-bg:before { background-color: ' . esc_attr( $color_overlay ) . '; }' : ''; ?>
				</style>
				<div class="vu_ph-container">
					<div class="vu_ph-content">
						<div class="container">
							<?php if ( ! empty( $title ) ) : ?>
								<h1 class="vu_ph-title"><?php echo esc_html( $title ); ?></h1>
							<?php endif; ?>

							<?php if ( $page_header_style == '1' && $breadcrumbs != false ) : ?>
								<div class="vu_ph-breadcrumbs"><?php echo do_shortcode( bakery_get_option( 'page-header-breadcrumbs-content', '' ) ); ?></div>
							<?php endif; ?>

							<?php if ( $page_header_style == '2' && ! empty( $subtitle ) ) : ?>
								<span class="vu_ph-subtitle"><?php echo nl2br( $subtitle ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>
			<!-- /Page Header -->
		<?php 
	}
}

// Get Page Header Background
if ( ! function_exists( 'bakery_get_page_header_bg' ) ) {
	function bakery_get_page_header_bg( $post_id ) {
		$bakery_page_header_settings = bakery_get_post_meta( $post_id, 'bakery_page_header_settings' );

		if ( isset( $bakery_page_header_settings['bg'] ) && ! empty( $bakery_page_header_settings['bg'] ) ){
			return absint( $bakery_page_header_settings['bg'] );
		}

		return false;
	}
}

// Get the URL (src) for an image attachment
if ( ! function_exists( 'bakery_get_attachment_image_src' ) ) {
	function bakery_get_attachment_image_src( $attachment_id, $size = 'thumbnail', $icon = false, $return = 'url' ) {
		$image_attributes = wp_get_attachment_image_src( $attachment_id, $size, $icon );
		
		if ( $image_attributes ) {
			switch ( $return ) {
				case 'all':
					return $image_attributes;
					break;
				case 'url':
					return esc_url( $image_attributes[0] );
					break;
				case 'width':
					return $image_attributes[1];
					break;
				case 'height':
					return $image_attributes[2];
					break;
				case 'resized ':
					return $image_attributes[3];
					break;
			}
		}
		
		return false;
	}
}

// Get dequeue libraries
if ( ! function_exists( 'bakery_get_dequeue_libraries' ) ) {
	function bakery_get_dequeue_libraries() {
		$dequeue_libraries = bakery_get_option( 'advanced-dequeue-libraries', array() );

		return wp_parse_args( (array) $dequeue_libraries, array(
			'youtube-player-api' => '0',
			'bootstrap-datepicker' => '0',
			'bootstrap-timepicker' => '0',
		) );
	}
}

// Print Pagination
if ( ! function_exists( 'bakery_pagination' ) ) {
	function bakery_pagination($query = null) {
		global $wp_query, $wp_rewrite;

		if ( !empty($query) ) {
			$wp_query = $query;
		}

		$current_page = max(1, $wp_query->query_vars['paged']);
		$total_pages = $wp_query->max_num_pages;

		if ($total_pages > 1) {
			$permalink_structure = get_option( 'permalink_structure' );
			$query_type = (count($_GET)) ? '&' : '?';
			$format = empty( $permalink_structure ) ? $query_type .'paged=%#%' : 'page/%#%/';
		
			echo '<div class="row"><div class="col-xs-12"><div class="vu_pagination">';
			
			$paginate_links = paginate_links(array(
				'base' => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
				'format' => $format,
				'current' => $current_page,
				'total' => $total_pages,
				'type' => 'list',
				'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
				'next_text' => '<i class="fa fa-arrow-right" aria-hidden="true"></i>',
				'before_page_number' => '',
				'after_page_number' => ''
			));

			$paginate_links = str_replace( '/page/1/', '/', $paginate_links );

			echo str_replace("<ul class='page-numbers'>", '<ul class="vu_p-list list-unstyled">', $paginate_links);
			
			echo  '</div></div></div>';
		}
	}
}

// Print Pages Links
if ( ! function_exists( 'bakery_wp_link_pages' ) ) {
	function bakery_wp_link_pages( $args = '' ) {
		$defaults = array(
			'before' => '<div class="row"><div class="col-xs-12"><div class="vu_pagination"><ul class="vu_p-list list-unstyled">', 
			'after' => '</ul></div></div></div>',
			'text_before' => '',
			'text_after' => '',
			'next_or_number' => 'number',
			'nextpagelink' => '<i class="fa fa-arrow-right" aria-hidden="true"></i>',
			'previouspagelink' => '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
			'pagelink' => '%',
			'echo' => 1
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );

		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';

		if ( $multipage ) {
			if ( 'number' == $next_or_number ) {
				$output .= $before;

				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $pagelink );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= '<li>'. str_replace( '<a ', '<a class="page-numbers" ', _wp_link_page( $i ) );
					else
						$output .= '<li><span class="page-numbers current">';

					$output .= $text_before . $j . $text_after;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= '</a></li>';
					else
						$output .= '</span></li>';
				}

				$output .= $after;
			} else {
				if ( $more ) {
					$output .= $before;

					$i = $page - 1;

					if ( $i && $more ) {
						$output .= '<li>'. str_replace( '<a ', '<a class="prev page-numbers" ', _wp_link_page( $i ) );
						$output .= $text_before . $previouspagelink . $text_after . '</a></li>';
					}

					$i = $page + 1;

					if ( $i <= $numpages && $more ) {
						$output .= '<li>'. str_replace( '<a ', '<a class="next page-numbers" ', _wp_link_page( $i ) );
						$output .= $text_before . $nextpagelink . $text_after . '</a></li>';
					}

					$output .= $after;
				}
			}
		}

		if ( $echo ) {
			echo trim( $output );
		} else {
			return $output;
		}
	}
}

// Single Comment Template
if ( ! function_exists( 'bakery_comments' ) ) {
	function bakery_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class( 'clearfix' ); ?> id="vu_c-comment-<?php comment_ID(); ?>">
		<?php if ( $comment->comment_type == 'pingback' || $comment->comment_type == 'trackback' ) : ?>
			<?php edit_comment_link( esc_html__( 'Edit', 'bakery' ), '<span class="vu_c-a-m-item vu_c-a-edit">', '</span>' ); ?>
			<p><?php echo esc_html__( 'Pingback:', 'bakery' ); ?> <?php comment_author_link(); ?></p>
		<?php else : ?>
			<article id="comment-<?php comment_ID(); ?>" class="vu_c-article">
				<div class="vu_c-a-avatar">
					<?php echo get_avatar( get_comment_author_email() ); ?>
				</div>

				<div class="vu_c-a-container">
					<header class="vu_c-a-header">
						<h5 class="vu_c-a-author">
							<?php $comment_author_url = get_comment_author_url(); ?>

							<?php if ( ! empty( $comment_author_url ) ) : ?>
								<a href="<?php comment_author_url(); ?>" rel="external nofollow"><?php comment_author(); ?></a>
							<?php 
								else :
									comment_author();
								endif;
							?>
						</h5>

						<div class="vu_c-a-meta">
							<span class="vu_c-a-m-item vu_c-a-date">
								<time datetime="<?php comment_date( 'c' ); ?>"><?php comment_date( get_option( 'date_format' ) ) ?> <?php esc_html_e( 'at', 'bakery' ); ?> <?php comment_date( get_option( 'time_format' ) ); ?></time>
							</span>

							<?php edit_comment_link( esc_html__( 'Edit', 'bakery' ), '<span class="vu_c-a-m-item vu_c-a-edit">', '</span>' ); ?>

							<span class="vu_c-a-m-item vu_c-a-reply">
								<a href="#" class="vu_c-a-reply-link" data-id="<?php comment_ID(); ?>"><?php esc_html_e( 'Reply', 'bakery' ); ?></a>
							</span>
						</div>
					</header>
					
					<div class="vu_c-a-content">
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<p><em class="vu_c-a-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'bakery' ); ?></em></p>
						<?php endif; ?>

						<?php comment_text(); ?>
					</div>
				</div>
			</article>
		<?php endif; ?>
	<?php 
	}
}

// Check If Has Sidebar
if ( ! function_exists( 'bakery_has_sidebar' ) ) {
	function bakery_has_sidebar( $data ) {
		$has_sidebar = true;

		if ( ! isset( $data['sidebar'] ) || $data['sidebar'] == 'none' || empty( $data['sidebar'] ) || ! is_active_sidebar( $data['sidebar'] ) ) {
			$has_sidebar = false;
		}

		return apply_filters( 'bakery/sidebar/has', $has_sidebar, $data );
	}
}

// Print Dynamic Sidebar
if ( ! function_exists( 'bakery_dynamic_sidebar' ) ) {
	function bakery_dynamic_sidebar( $sidebar ) {
		if ( $sidebar == 'none' ) {
			return;
		}

		if ( ! empty( $sidebar ) ) {
			dynamic_sidebar( $sidebar );
		}
	}
}

// Check if footer sidebars has widgets
if ( ! function_exists( 'bakery_footer_sidebars_has_widgets' ) ) {
	function bakery_footer_sidebars_has_widgets() {
		$footer_layout = explode( '-', bakery_get_option( 'footer-layout', '3-3-3-3' ) );

		for ( $i = 1; $i <= count( $footer_layout ); $i++ ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				return true;
			}
		}

		return false;
	}
}

// Get Footer Page
if ( ! function_exists( 'bakery_get_footer_page' ) ) {
	function bakery_get_footer_page() {
		$page_id = bakery_get_option( 'footer-page' );

		// Polylang
		if ( function_exists( 'pll_get_post' ) ) {
			$page_id = pll_get_post( $page_id );
		}

		// WPML
		if ( has_filter( 'wpml_object_id' ) ) {
			$page_id = apply_filters( 'wpml_object_id', $page_id, 'page', true );
		}
		
		return get_post( $page_id );
	}
}

// Get Footer Custom CSS
if ( ! function_exists( 'bakery_get_vc_page_custom_css' ) ) {
	function bakery_get_vc_page_custom_css( $page_id ) {
		$custom_css = '';

		// Shortcodes custom css
		$shortcodes_custom_css = get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );
		
		if ( ! empty( $shortcodes_custom_css ) ) {
			$custom_css .= strip_tags( $shortcodes_custom_css );
		}

		// Post custom css
		$post_custom_css = get_post_meta( $page_id, '_wpb_post_custom_css', true );
		
		if ( ! empty( $post_custom_css ) ) {
			$custom_css .= strip_tags( $post_custom_css );
		}

		return $custom_css;
	}
}

// Get Current URL
if ( ! function_exists( 'bakery_get_current_url' ) ) {
	function bakery_get_current_url() {
		global $wp;
		return home_url( add_query_arg( array() , $wp->request ) );
	}
}
