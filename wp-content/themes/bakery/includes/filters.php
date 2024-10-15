<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! class_exists( 'Bakery_Filters' ) ) {
	class Bakery_Filters {
		private $dequeue_libraries = array();

		function __construct() {
			$this->dequeue_libraries = bakery_get_dequeue_libraries();

			add_filter( 'widget_text', 'do_shortcode' ); // Allow Shortcodes to be used on Text Widgets
			add_filter( 'document_title_separator', array( $this, 'document_title_separator' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );
			add_filter( 'the_content', array( $this, 'the_content' ) );
			add_filter( 'nav_menu_link_attributes', array( $this, 'nav_menu_link_attributes' ), 10, 3 );
			add_filter( 'wp_nav_menu_items', array( $this, 'wp_nav_menu_items' ), 10, 2);
			add_filter( 'wp_nav_menu', array( $this, 'wp_nav_menu' ), 10, 2 );
			add_filter( 'comment_form_fields', array( $this, 'comment_form_fields' ) );
			add_filter( 'wpcf7_ajax_loader', array( $this, 'wpcf7_ajax_loader' ) );

			add_filter( 'bakery/page_header/show', array( $this, 'page_header_show' ), 10, 2 );
			add_filter( 'bakery/sidebar/has', array( $this, 'has_sidebar' ), 10, 2 );

			add_filter( 'bakery/enqueue_styles', array( $this, 'enqueue_styles' ), 10, 1 );
			add_filter( 'bakery/enqueue_scripts', array( $this, 'enqueue_scripts' ), 10, 1 );
		}
		
		// Filter document_title_separator
		function document_title_separator( $sep ) {
			return '|';
		}
		
		// Add specific CSS class by filter
		function body_class( $classes ) {
			// Skin
			if ( bakery_get_option( 'site-skin', 'light' ) == 'light' ) {
				$classes[] = 'vu_site-skin-light';
			} else {
				$classes[] = 'vu_site-skin-dark';
			}

			// Layout
			if ( bakery_get_option( 'boxed-layout' ) == true ) {
				$classes[] = 'vu_site-layout-boxed';
			} else {
				$classes[] = 'vu_site-layout-full';
			}

			// Search Icon
			if ( bakery_get_option( 'header-show-search-icon', false ) == true ) {
				$classes[] = 'vu_site-with-search-icon';
			}

			// Comments
			if ( comments_open() || get_comments_number() ) {
				$classes[] = 'vu_page-with-comments';
			}

			// YouTube Player API
			if ( $this->dequeue_libraries['youtube-player-api'] == '1' ) {
				$classes[] = 'vu_no-youtube-player-api';
			}

			return $classes;
		}
		
		// Fix VC bug if page content has '<!--nextpage-->'
		function the_content( $content ) {
			global $multipage;

			if ( is_page() && $multipage ) {
				global $page;

				$_content = strip_tags( $content );

				if ( $page >= 2 ) {
					if ( bakery_string_starts_with( $_content, '[/vc_column_text]' ) ) {
						$content = preg_replace( '/(\[\/vc_column_text]\[\/vc_column]\[\/vc_row\])/', '', $content, 1 );
					}

					if ( bakery_string_starts_with( $_content, '[/vc_section]' ) ) {
						$content = preg_replace( '/(\[\/vc_section\])/', '', $content, 1 );
					}
				}
			}

			return $content;
		}

		// Add 'itemprop' attribute for links in menu
		function nav_menu_link_attributes( $atts, $item, $args ) {
			$atts['itemprop'] = 'url';
			return $atts;
		}
		
		// Show search icon in menu
		function wp_nav_menu_items( $items, $args ) {
			if ( ( $args->theme_location == 'main-menu-full' || $args->theme_location == 'main-menu-right' ) && bakery_get_option( 'header-show-search-icon', false ) == true ) {

				ob_start(); ?>
					<li class="vu_search-menu-item">
						<a href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
					</li>
				<?php

				$items .= ob_get_clean();
			}

			return $items;
		}

		// Add Font Awesome icons to menu - (https://wordpress.org/plugins/font-awesome-4-menus/)
		function wp_nav_menu( $nav, $args ) {
			if ( ( $args->theme_location == 'main-menu-full' || $args->theme_location == 'main-menu-left' || $args->theme_location == 'main-menu-right' ) ) {
				$menu_item = preg_replace_callback(
					'/(<li[^>]+class=")([^"]+)("?[^>]+>[^>]+>)([^<]+)<\/a>/',
					array( $this, 'wp_nav_menu_replace' ),
					$nav
				);

				return $menu_item;
			}

			return $nav;
		}
		
		function wp_nav_menu_replace( $a ) {
			$start = $a[ 1 ];
			$classes = $a[ 2 ];
			$rest = $a[ 3 ];
			$text = $a[ 4 ];
			$before = true;
			
			$class_array = explode( ' ', $classes );
			$fontawesome_classes = array();

			foreach ( $class_array as $key => $val ) {
				if ( 'fa' == substr( $val, 0, 2 ) ){
					if ( 'fa' == $val ){
						unset( $class_array[ $key ] );
					} elseif ( 'fa-after' == $val ){
						$before = false;
						unset( $class_array[ $key ] );
					} else {
						$fontawesome_classes[] = $val;
						unset( $class_array[ $key ] );
					}
				}
			}
			
			if ( ! empty( $fontawesome_classes ) ) {
				$fontawesome_classes[] = 'fa';
				if ( $before ) {
					$newtext = '<i class="' . implode( ' ', $fontawesome_classes ) . '"></i><span>' . $text . '</span>';
				} else {
					$newtext = '<span>' . $text . '</span><i class="' . implode( ' ', $fontawesome_classes ) . '"></i>';
				}
			} else {
				$newtext = $text;
			}
			
			$item = $start . implode( ' ', $class_array ) . $rest . $newtext . '</a>';

			return $item;
		}

		// Moving the Comment Text Field to Bottom
		function comment_form_fields( $fields ) {
			$comment_field = $fields['comment'];

			unset( $fields['comment'] );

			$fields['comment'] = $comment_field;

			return $fields;
		}

		// Contact Form 7 change ajax loader image
		function wpcf7_ajax_loader( $url ) {
			return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHdpZHRoPScyOHB4JyBoZWlnaHQ9JzI4cHgnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIiBjbGFzcz0idWlsLXJpbmctYWx0Ij48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0ibm9uZSIgY2xhc3M9ImJrIj48L3JlY3Q+PGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNDAiIHN0cm9rZT0iI2RkZCIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L2NpcmNsZT48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI0MCIgc3Ryb2tlPSIjNDQ0NDQ0IiBmaWxsPSJub25lIiBzdHJva2Utd2lkdGg9IjYiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCI+PGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ic3Ryb2tlLWRhc2hvZmZzZXQiIGR1cj0iMnMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiBmcm9tPSIwIiB0bz0iNTAyIj48L2FuaW1hdGU+PGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ic3Ryb2tlLWRhc2hhcnJheSIgZHVyPSIycyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIHZhbHVlcz0iMTUwLjYgMTAwLjQ7MSAyNTA7MTUwLjYgMTAwLjQiPjwvYW5pbWF0ZT48L2NpcmNsZT48L3N2Zz4=';
		}

		// Show/Hide page header
		function page_header_show( $return, $post_id ) {
			$bakery_page_header_settings = bakery_get_post_meta( $post_id, 'bakery_page_header_settings' );

			if ( isset( $bakery_page_header_settings['show'] ) && ( $bakery_page_header_settings['show'] == 'no' || ( $bakery_page_header_settings['show'] == 'inherit' && bakery_get_option( 'page-header-show' ) == false ) ) ) {
				$return = false;
			}

			if ( is_single() && get_post_type() == 'post' && bakery_get_option( 'blog-single-show-page-header', true ) == false ) {
				$return = false;
			}

			return $return;
		}

		// Show/Hide page sidebar
		function has_sidebar( $has_sidebar, $data ) {
			if ( is_single() && get_post_type() == 'post' && bakery_get_option( 'blog-single-show-sidebar', $has_sidebar ) == false && $has_sidebar == true ) {
				$has_sidebar = false;
			}

			return $has_sidebar;
		}

		// Enqueue/Dequeue Styles
		function enqueue_styles( $styles ) {
			if ( $this->dequeue_libraries['bootstrap-datepicker'] == '1' ) {
				if ( ( $key = array_search( 'bootstrap-datepicker', $styles ) ) !== false ) {
					unset( $styles[ $key ] );
				}
			}

			if ( $this->dequeue_libraries['bootstrap-timepicker'] == '1' ) {
				if ( ( $key = array_search( 'bootstrap-datepicker', $styles ) ) !== false ) {
					unset( $styles[ $key ] );
				}
			}

			return $styles;
		}

		// Enqueue/Dequeue Scripts
		function enqueue_scripts( $scripts ) {
			foreach ( $this->dequeue_libraries as $k => $v ) {
				if ( $this->dequeue_libraries[ $k ] == '1' ) {
					if ( ( $id = array_search( $k, $scripts ) ) !== false ) {
						unset( $scripts[ $id ] );
					}
				}
			}

			return $scripts;
		}
	}

	$Bakery_Filters = new Bakery_Filters();
}
