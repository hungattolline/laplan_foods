<?php if ( ! defined( 'ABSPATH' ) ) exit();

// Constants
define( 'BAKERY_THEME_DIR', get_template_directory() . '/' );
define( 'BAKERY_THEME_URL', get_template_directory_uri() . '/' );
define( 'BAKERY_THEME_ASSETS', BAKERY_THEME_URL . 'assets/' );
define( 'BAKERY_THEME_ADMIN_ASSETS', BAKERY_THEME_URL . 'includes/admin/' );
define( 'BAKERY_THEME_VERSION', '2.8.1' );

// Core Files
require_once( BAKERY_THEME_DIR . 'includes/utilities.php' );
require_once( BAKERY_THEME_DIR . 'includes/helpers.php' );
require_once( BAKERY_THEME_DIR . 'includes/functions.php' );
require_once( BAKERY_THEME_DIR . 'includes/license.php' );
require_once( BAKERY_THEME_DIR . 'includes/actions.php' );
require_once( BAKERY_THEME_DIR . 'includes/filters.php' );

// Meta
require_once( BAKERY_THEME_DIR . 'includes/meta/config.php' );
require_once( BAKERY_THEME_DIR . 'includes/meta/page-header-settings.php' );
require_once( BAKERY_THEME_DIR . 'includes/meta/page-menu.php' );
require_once( BAKERY_THEME_DIR . 'includes/meta/page-sidebar.php' );
require_once( BAKERY_THEME_DIR . 'includes/meta/post-meta.php' );

// Library Files
require_once( BAKERY_THEME_DIR . 'includes/lib/class-tgm-plugin-activation.php' );

// Custom CSS
require_once( BAKERY_THEME_DIR . 'includes/custom-css.php' );

// VC Files
if ( class_exists( 'Vc_Manager' ) ) {
	require_once( BAKERY_THEME_DIR . 'includes/vc-addons/config.php' );
	require_once( BAKERY_THEME_DIR . 'includes/vc-addons/params.php' );
	require_once( BAKERY_THEME_DIR . 'includes/vc-addons/modify.php' );
} else {
	require_once( BAKERY_THEME_DIR . 'includes/vc-addons/functions.php' );
}

// WC Files
if ( class_exists( 'WooCommerce' ) ) {
	require_once( BAKERY_THEME_DIR . 'includes/wc-addons/custom-css.php' );
	require_once( BAKERY_THEME_DIR . 'includes/wc-addons/functions.php' );
	require_once( BAKERY_THEME_DIR . 'includes/wc-addons/actions.php' );
	require_once( BAKERY_THEME_DIR . 'includes/wc-addons/filters.php' );
}
