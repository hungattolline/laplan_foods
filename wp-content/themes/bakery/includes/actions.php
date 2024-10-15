<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! class_exists( 'Bakery_Actions' ) ) {
	class Bakery_Actions {
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'init', array( $this, 'fonts' ) );
			add_action( 'after_setup_theme', array( $this, 'load_theme_textdomain' ) );
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
			add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'template_redirect', array( $this, 'site_mode' ) );
			add_action( 'wp_head', array( $this, 'wp_head' ) );
			add_action( 'wp_head', array( $this, 'custom_css' ), 200 );
			add_action( 'wp_footer', array( $this, 'wp_footer' ) );
			add_action( 'wp_footer', array( $this, 'custom_js' ), 200 );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );

			add_action( 'bakery/header/before', array( $this, 'preloader' ) );
			add_action( 'bakery/search_form', array( $this, 'search_form' ) );

			if ( class_exists( 'Bakery_License' ) && Bakery_License::is_valid() ) {
				add_action( 'tgmpa_register', array( $this, 'tgmpa_register' ) );
			}
		}

		// Theme Initialization
		function init() {
			$dequeue_libraries = bakery_get_dequeue_libraries();

			// Font Milingona
			wp_register_style( 'font-milingona', BAKERY_THEME_ASSETS . 'lib/font-milingona/css/font-milingona.css', array(), '1.0.0' );

			// Font Awesome
			wp_register_style( 'font-awesome-v4-shims', BAKERY_THEME_ASSETS . 'lib/font-awesome/css/v4-shims.min.css', array(), '6.6.0' );
			wp_register_style( 'font-awesome', BAKERY_THEME_ASSETS . 'lib/font-awesome/css/all.min.css', array( 'font-awesome-v4-shims' ), '6.6.0' );

			// Font Bakery
			wp_register_style( 'font-bakery', BAKERY_THEME_ASSETS . 'lib/font-bakery/css/font-bakery.css', array(), BAKERY_THEME_VERSION );

			// Bootstrap
			wp_register_style( 'bootstrap', BAKERY_THEME_ASSETS . 'lib/bootstrap/css/bootstrap.min.css', array(), '3.3.7' );
			wp_register_script( 'bootstrap', BAKERY_THEME_ASSETS . 'lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );

			// Datepicker
			if ( isset( $dequeue_libraries['bootstrap-datepicker'] ) && $dequeue_libraries['bootstrap-datepicker'] != '1' ) {
				wp_register_style( 'bootstrap-datepicker', BAKERY_THEME_ASSETS . 'lib/bootstrap-datepicker/bootstrap-datepicker.css', array(), '1.5' );
				wp_register_script( 'bootstrap-datepicker', BAKERY_THEME_ASSETS . 'lib/bootstrap-datepicker/bootstrap-datepicker.js', array( 'jquery' ), '1.5', true );
			}
			
			// Timepicker
			if ( isset( $dequeue_libraries['bootstrap-timepicker'] ) && $dequeue_libraries['bootstrap-timepicker'] != '1' ) {
				wp_register_style( 'bootstrap-timepicker', BAKERY_THEME_ASSETS . 'lib/bootstrap-timepicker/bootstrap-timepicker.min.css', array(), '0.2.6' );
				wp_register_script( 'bootstrap-timepicker', BAKERY_THEME_ASSETS . 'lib/bootstrap-timepicker/bootstrap-timepicker.min.js', array( 'jquery' ), '0.2.6', true );
			}

			// Select2
			wp_register_style( 'select2', BAKERY_THEME_ASSETS . 'lib/select2/css/select2.min.css', array(), '4.0.3' );
			wp_register_script( 'select2', BAKERY_THEME_ASSETS . 'lib/select2/js/select2.full.min.js', array( 'jquery' ), '4.0.3', true );
			
			// Owl Carousel
			wp_register_style( 'owl-carousel', BAKERY_THEME_ASSETS . 'lib/owl-carousel/owl.carousel.min.css', array(), '1.3.3' );
			wp_register_script( 'owl-carousel', BAKERY_THEME_ASSETS . 'lib/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '1.3.3', true );

			// Magnific Popup
			wp_register_style( 'magnific-popup', BAKERY_THEME_ASSETS . 'lib/magnific-popup/magnific-popup.min.css', array(), '1.1.0' );
			wp_register_script( 'magnific-popup', BAKERY_THEME_ASSETS . 'lib/magnific-popup/magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );

			// Common
			wp_register_style( 'bakery-common-css', BAKERY_THEME_ASSETS . 'css/common.css', array(), BAKERY_THEME_VERSION );
			wp_register_script( 'bakery-common-js', BAKERY_THEME_ASSETS . 'js/common.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs' ), BAKERY_THEME_VERSION, true );
			
			// Main
			wp_register_style( 'bakery-main', BAKERY_THEME_URL . 'style.css', array( 'bakery-common-css' ), BAKERY_THEME_VERSION );
			wp_register_script( 'bakery-main', BAKERY_THEME_ASSETS . 'js/main.js', array( 'jquery', 'bakery-common-js' ), BAKERY_THEME_VERSION, true );
			
			// Config Object
			wp_localize_script( 'bakery-main', 'bakery_config',
				array(
					'ajaxurl' => admin_url("admin-ajax.php"),
					'home_url' => esc_url( home_url( '/' ) ),
					'version' => BAKERY_THEME_VERSION,
					'google_maps_api_key' => trim( bakery_get_option( 'map-google-api-key', '' ) ),
					'countdown_lang' => bakery_get_option( 'advanced-countdown-language', '' )
				)
			);

			// Admin
			wp_register_style( 'bakery-admin-style', BAKERY_THEME_ADMIN_ASSETS . 'css/admin.css', array(), BAKERY_THEME_VERSION );
			wp_register_script( 'bakery-admin-script', BAKERY_THEME_ADMIN_ASSETS . 'js/admin.js', array( 'jquery', 'wp-color-picker' ), BAKERY_THEME_VERSION, true );

			// Editor Style
			add_editor_style( 'mce-editor-style.css' );
		}

		// Register Fonts
		function fonts() {
			$fonts_url = '';
			$fonts     = array();
			$subsets   = 'latin,latin-ext';

			/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
			if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'bakery' ) ) {
				$fonts[] = 'Open Sans:400,400i,600,600i,700,700i';
			}

			/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
			if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'bakery' ) ) {
				$fonts[] = 'Montserrat:400,500,600,700';
			}

			if ( $fonts ) {
				$fonts_url = add_query_arg( array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				), 'https://fonts.googleapis.com/css' );
			}

			wp_register_style( 'bakery-fonts', $fonts_url, array(), BAKERY_THEME_VERSION );
		}

		// Theme Textdomain
		function load_theme_textdomain() {
			load_theme_textdomain( 'bakery', get_template_directory() . '/languages' );
		}

		// After Setup Theme
		function after_setup_theme() {
			// Theme Support
			add_theme_support( 'wp-block-styles' );
			add_theme_support( 'responsive-embeds' );
			add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
			add_theme_support( 'custom-logo', array( 'width' => 120, 'height' => 120 ) );
			add_theme_support( 'align-wide' );

			add_theme_support( 'widgets' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'featured-image' );
			add_theme_support( 'woocommerce' );
			add_theme_support( 'custom-header' );
			add_theme_support( 'custom-background' );
			add_theme_support( 'post-formats', array( 'image', 'audio', 'video', 'gallery', 'link', 'quote', 'aside' ) );

			// Attachment sizes
			add_image_size( 'bakery_ratio-1:1', 600, 600, true );
			add_image_size( 'bakery_ratio-2:1', 800, 400, true );
			add_image_size( 'bakery_ratio-3:2', 800, 533, true );
			add_image_size( 'bakery_ratio-3:4', 450, 600, true );
			add_image_size( 'bakery_ratio-4:3', 800, 600, true );
			add_image_size( 'bakery_ratio-16:9', 800, 450, true );
			
			// Register Menus
			register_nav_menus(
				array(
					'main-menu-full' => esc_html__( 'Main Menu Full', 'bakery' ),
					'main-menu-left' => esc_html__( 'Main Menu Left', 'bakery' ),
					'main-menu-right' => esc_html__( 'Main Menu Right', 'bakery' )
				)
			);
		}

		// Theme Content Width
		function content_width() {
			$GLOBALS['content_width'] = apply_filters( 'bakery/content/width', 1170 );
		}

		// Enqueue Scripts
		function wp_enqueue_scripts() {
			// Styles
			$styles = array(
				'bakery-fonts',
				'wp-mediaelement',
				'font-milingona',
				'font-awesome',
				'font-bakery',
				'bootstrap',
				'bootstrap-datepicker',
				'bootstrap-timepicker',
				'magnific-popup',
				'owl-carousel',
				'select2',
				'bakery-common-css',
				'bakery-main'
			);

			$styles = apply_filters( 'bakery/enqueue_styles', $styles );

			wp_enqueue_style( $styles );

			// Comment Reply
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		// Enqueue Admin Scritps
		function admin_enqueue_scripts() {
			// Styles
			wp_enqueue_style(
				array(
					'font-milingona',
					'font-awesome',
					'font-bakery',
					'wp-color-picker',
					'bakery-admin-style'
				)
			);

			//Media Frame
			wp_enqueue_media();

			// Scripts
			wp_enqueue_script( 'bakery-admin-script' );
		}

		// Site Mode
		function site_mode() {
			if ( bakery_get_option( 'site-mode' ) == 'under_construction' && get_the_ID() != bakery_get_option( 'site-mode-page' ) && ! is_user_logged_in() ) {
				$site_mode_page = bakery_get_option( 'site-mode-page' );

				if ( ! empty( $site_mode_page ) ) {
					wp_redirect( get_permalink( absint( bakery_get_option( 'site-mode-page' ) ) ) ); exit;
				}
			}
		}

		// Head Init
		function wp_head() {
			echo '<meta name="generator" content="Powered by Milingona" />';

			// Pingback
			if ( pings_open() ) {
				echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">';
			}

			// Cookie Consent
			if ( bakery_get_option( 'cookieconsent-show', true ) == true ) {
				echo bakery_get_option( 'cookieconsent-head-code' );
			}

			if ( bakery_get_option( 'footer-type' ) == 'page' && trim( bakery_get_option( 'footer-page' ) ) != '' ) {
				$footer_custom_css = bakery_get_vc_page_custom_css( bakery_get_option( 'footer-page' ) );

				if ( ! empty( $footer_custom_css ) ) {
					echo '<style type="text/css" id="bakery_footer-custom-css">' . $footer_custom_css . '</style>';
				}
			}
		}

		// Custom CSS form Theme Options
		function custom_css() {
			echo '<style type="text/css" id="bakery_custom-css">' . bakery_custom_css() . '</style>';
		}

		// Footer Init
		function wp_footer() {
			// Scripts
			$scripts = array(
				'wp-mediaelement',
				'jquery-ui-core',
				'jquery-ui-accordion',
				'jquery-ui-tabs',
				'bootstrap',
				'bootstrap-datepicker',
				'bootstrap-timepicker',
				'select2',
				'magnific-popup',
				'owl-carousel',
				'bakery-common-js',
				'bakery-main'
			);
			
			$scripts = apply_filters( 'bakery/enqueue_scripts', $scripts );

			wp_enqueue_script( $scripts );

			// Google Analytics Tracking Code
			if ( trim( bakery_get_option( 'google-analytics-tracking-code' ) ) !== '' ) {
				echo bakery_get_option( 'google-analytics-tracking-code' );
			}

			// Cookie Consent
			if ( bakery_get_option( 'cookieconsent-show', true ) == true ) {
				echo bakery_get_option( 'cookieconsent-body-code' );
			}

			// Search Modal
			if ( bakery_get_option( 'header-show-search-icon', false ) == true ) {
				?>
					<div class="vu_search-modal">
						<div class="vu_sm-content">
							<a href="#" class="vu_sm-close"><i class="fa fa-times" aria-hidden="true"></i></a>
							<?php get_search_form(); ?>
						</div>
					</div>
				<?php 
			}
		}

		// Custom JS form Theme Options
		function custom_js() {
			if ( trim( bakery_get_option( 'custom-js' ) ) !== '' ) {
				echo '<script id="bakery_custom-js">' . bakery_get_option( 'custom-js' ) . '</script>';
			}
		}

		// Widgets Init
		function widgets_init() {
			// Blog Sidebar
			register_sidebar(
				array(
					'id' => 'blog-sidebar',
					'name' => esc_html__( 'Blog Sidebar', 'bakery' ),
					'before_widget' => '<div class="widget %2$s %1$s clearfix">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widget_title">',
					'after_title' => '</h3>'
				)
			);

			// Footer Sidebars
			for ( $i = 1;  $i <= 4;  $i++ ) {
				register_sidebar(
					array(
						'id' => 'footer-' . $i,
						'name' => 'Footer #' . $i,
						'before_widget' => '<div class="widget %2$s %1$s clearfix">',
						'after_widget' => '</div>',
						'before_title' => '<h3 class="widget_title">',
						'after_title' => '</h3>'
					)
				);
			}

			// Custom Sidebars
			$sidebars = bakery_get_option( 'sidebars' );

			if ( ! empty( $sidebars ) && is_array( $sidebars ) ) {
				foreach ( $sidebars as $sidebar ) {
					if ( ! empty( $sidebar ) ) {
						register_sidebar(
							array(
								'id' => sanitize_title( $sidebar ),
								'name' => $sidebar,
								'before_widget' => '<div class="widget %2$s %1$s clearfix">',
								'after_widget' => '</div>',
								'before_title' => '<h3 class="widget_title">',
								'after_title' => '</h3>'
							)
						);
					}
				}
			}
		}

		// Preloader
		function preloader() {
			if ( bakery_get_option( 'preloader' ) == true ) {
				echo '<div id="vu_preloader"></div>';
			}
		}

		// Search Form
		function search_form() {
			if ( bakery_get_option( 'header-show-search-icon', false ) == true ) {
				$search_type = bakery_get_option( 'header-search-scope', 'post' );

				if ( ! empty( $search_type ) && $search_type != 'all' ) {
					echo '<input type="hidden" name="post_type" value="' . esc_attr( $search_type ) . '">';
				}
			}
		}

		// Register Theme Plugins
		function tgmpa_register() {
			$plugins = array(
				array(
					'name'                   => 'Bakery Options',
					'slug'                   => 'bakery-options',
					'source'                 => BAKERY_THEME_DIR . 'plugins/bakery-options.zip',
					'required'               => true,
					'version'                => BAKERY_THEME_VERSION,
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'Bakery Shortcodes',
					'slug'                   => 'bakery-shortcodes',
					'source'                 => BAKERY_THEME_DIR . 'plugins/bakery-shortcodes.zip',
					'required'               => true,
					'version'                => BAKERY_THEME_VERSION,
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'WPBakery Page Builder',
					'slug'                   => 'js_composer',
					'source'                 => BAKERY_THEME_DIR . 'plugins/js_composer.zip',
					'required'               => true,
					'version'                => '7.9',
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'Slider Revolution',
					'slug'                   => 'revslider',
					'source'                 => BAKERY_THEME_DIR . 'plugins/revslider.zip',
					'required'               => true,
					'version'                => '6.7.20',
					'force_activation'       => false,
					'force_deactivation'     => false,
				),
				array(
					'name'                   => 'Contact Form 7',
					'slug'                   => 'contact-form-7',
					'required'               => true
				),
				array(
					'name'                   => 'WooCommerce',
					'slug'                   => 'woocommerce',
					'required'               => false
				),
				array(
					'name'                   => 'MailChimp for WordPress',
					'slug'                   => 'mailchimp-for-wp',
					'required'               => false
				),
				array(
					'name'                   => 'Yoast SEO',
					'slug'                   => 'wordpress-seo',
					'required'               => false
				)
			);
			
			$config = array(
				'domain'                              => 'bakery', 
				'default_path'                        => '',
				'parent_slug'                         => 'themes.php',
				'capability'                          => 'edit_theme_options',
				'menu'                                => 'install-required-plugins',
				'has_notices'                         => true,
				'dismissable'                         => true,
				'is_automatic'                        => false,
				'message'                             => '',
				'strings'                             => array(
					'page_title'                         => esc_html__( 'Install Required Plugins', 'bakery' ),
					'menu_title'                         => esc_html__( 'Install Plugins', 'bakery' ),
					'installing'                         => esc_html__( 'Installing Plugin: %s', 'bakery' ),
					'oops'                               => esc_html__( 'Something went wrong with the plugin API.', 'bakery' ),
					'notice_can_install_required'        => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'bakery' ),
					'notice_can_install_recommended'     => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'bakery' ),
					'notice_cannot_install'              => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'bakery' ),
					'notice_can_activate_required'       => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'bakery' ),
					'notice_can_activate_recommended'    => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'bakery' ), 
					'notice_cannot_activate'             => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'bakery' ),
					'notice_ask_to_update'               => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'bakery' ),
					'notice_cannot_update'               => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'bakery' ),
					'install_link'                       => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'bakery' ),
					'activate_link'                      => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'bakery' ),
					'return'                             => esc_html__( 'Return to Required Plugins Installer', 'bakery' ),
					'plugin_activated'                   => esc_html__( 'Plugin activated successfully.', 'bakery' ),
					'complete'                           => esc_html__( 'All plugins installed and activated successfully. %s', 'bakery' ), 
					'nag_type'                           => 'updated'
				)
			);

			tgmpa( $plugins, $config );
		}
	}
}

$Bakery_Actions = new Bakery_Actions();