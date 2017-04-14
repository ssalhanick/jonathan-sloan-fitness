<?php
load_theme_textdomain( 'oshin', get_template_directory() . '/languages' );
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'masterslider_disable_auto_update', '__return_true' );
add_theme_support( 'title-tag' );
if ( ! isset( $content_width ) ) {
	$content_width = 1160;
}
add_editor_style('css/custom-editor-style.css'); 
$more_text =  __('Read More','oshin');
$meta_sep = '&middot;';

/* -------------------------------------------
			Theme Setup
---------------------------------------------  */
add_action( 'after_setup_theme', 'be_themes_setup' );
if ( ! function_exists( 'be_themes_setup' ) ):
	function be_themes_setup() {
		register_nav_menu( 'main_nav', 'Main Menu' );
		register_nav_menu( 'sidebar_nav', 'Sidebar Menu' );	
		register_nav_menu( 'topbar_nav', 'Topbar Menu' );	
		register_nav_menu( 'footer_nav', 'Footer Menu' );
		register_nav_menu( 'main_left_nav', 'Main Left Menu' );
		register_nav_menu( 'main_right_nav', 'Main Right Menu' );		
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'video', 'audio','link' ) );
		 add_theme_support( 'custom-header' );
		 add_theme_support( 'custom-background' );
		add_theme_support( 'woocommerce' );
	}
endif;
// Re-define meta box path and URL

require_once( get_template_directory().'/functions/helpers.php' );
require_once( get_template_directory().'/functions/common-helpers.php' );
require_once( get_template_directory().'/headers/header-functions.php' );
require_once( get_template_directory().'/functions/widget-functions.php' );
require_once( get_template_directory().'/ajax-handler.php' );
require_once( get_template_directory().'/functions/be-styles-functions.php' );
if ( !in_array( 'meta-box/meta-box.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( get_template_directory().'/meta-box/meta-box.php' );
}
require_once( get_template_directory().'/be-themes-metabox.php' );
require_once( get_template_directory().'/functions/be-tgm-plugins.php' );
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once( get_template_directory().'/woocommerce/be-woo-functions.php' );
}
require_once( get_template_directory().'/bb-press/be-bb-press-functions.php' );
if ( ! function_exists( 'be_themes_image_sizes' ) ) {
	function be_themes_image_sizes( $sizes ) {
		global $_wp_additional_image_sizes;
		if ( empty( $_wp_additional_image_sizes ) )
			return $sizes;
		foreach ( $_wp_additional_image_sizes as $id => $data ) {
			if ( !isset($sizes[$id]) )
				$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
		}
		return $sizes;
	}
}

/* ---------------------------------------------  */
// Include Redux Framework
/* ---------------------------------------------  */

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' );
}
require_once( get_template_directory() .'/functions/be-themes-options-config.php' );
require_once( get_template_directory() .'/functions/be-themes-update-config.php' );



/* ---------------------------------------------  */
// Include Metabox Custom Fields
/* ---------------------------------------------  */

add_action( 'wp_loaded', 'be_metabox_sidebar_select_field', 1 );
function be_metabox_sidebar_select_field()
{
    require_once( get_template_directory() .'/functions/sidebar-select.php' );
}

/* ---------------------------------------------  */
// Specifying the various image sizes for theme
/* ---------------------------------------------  */

if ( function_exists( 'add_image_size' ) ) {
	$portfolio_image_height = (isset($be_themes_data['portfolio_aspect_ratio']) && !empty($be_themes_data['portfolio_aspect_ratio']) && $be_themes_data['portfolio_aspect_ratio']) ? round(650 / floatval($be_themes_data['portfolio_aspect_ratio'])) : 385;
	$portfolio_2_col = (isset($be_themes_data['portfolio_aspect_ratio']) && !empty($be_themes_data['portfolio_aspect_ratio']) && $be_themes_data['portfolio_aspect_ratio']) ? round(1000 / floatval($be_themes_data['portfolio_aspect_ratio'])) : 592;
	$portfolio_3_col_wide_width_height_image_height = (isset($be_themes_data['portfolio_aspect_ratio']) && !empty($be_themes_data['portfolio_aspect_ratio']) && $be_themes_data['portfolio_aspect_ratio']) ? round(1250 / floatval($be_themes_data['portfolio_aspect_ratio'])) : 766;
	$portfolio_3_col_wide_width_image_height = (isset($be_themes_data['portfolio_aspect_ratio']) && !empty($be_themes_data['portfolio_aspect_ratio']) && $be_themes_data['portfolio_aspect_ratio']) ? round(1250 / floatval($be_themes_data['portfolio_aspect_ratio'])) : 350;
	$portfolio_3_col_wide_height_image_height = (isset($be_themes_data['portfolio_aspect_ratio']) && !empty($be_themes_data['portfolio_aspect_ratio']) && $be_themes_data['portfolio_aspect_ratio']) ? 2*round(650 / floatval($be_themes_data['portfolio_aspect_ratio'])) : 770;
	add_image_size( 'blog-image', 1160, 700, true);
	add_image_size( 'blog-image-2', 330, 270, true);
	add_image_size( 'carousel-thumb', 0, 50, true );
	// PORTFOLIO
	add_image_size( 'portfolio', 650, $portfolio_image_height, true );
	add_image_size( 'portfolio-masonry', 650 );
	add_image_size( '2col-portfolio', 1000, $portfolio_2_col, true );
	add_image_size( '2col-portfolio-masonry', 1000 );
	add_image_size( '3col-portfolio-wide-width-height', 1250, $portfolio_3_col_wide_width_height_image_height, true );
	add_image_size( '3col-portfolio-wide-width', 1250, $portfolio_3_col_wide_width_image_height, true );
	add_image_size( '3col-portfolio-wide-height', 650, $portfolio_3_col_wide_height_image_height, true );
	add_filter( 'image_size_names_choose', 'be_themes_image_sizes' );
}



/* ---------------------------------------------  */
// Function for generating dynamic css
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_options_css' ) ) {
	function be_themes_options_css() {
		global $be_themes_data;
		 if( !$be_themes_data['site_status'] ) {
			delete_transient( 'be_themes_css' );
		}
		if ( false === ( $css = get_transient( 'be_themes_css' ) ) ) {
			$be_themes_path = get_template_directory_uri();
			$css_dir = get_stylesheet_directory() . '/css/'; 
			ob_start(); // Capture all output (output buffering)
			require(get_template_directory() .'/css/be-themes-styles.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			set_transient( 'be_themes_css', $css );
		}
		echo '<style type="text/css"> '.$css.' </style>';
	}
	add_action( 'wp_head', 'be_themes_options_css' );
}


/* ---------------------------------------------  */
// Function to change Portfolio Post type 'slug'
/* ---------------------------------------------  */
add_filter('be_portfolio_post_type_slug', 'be_themes_change_post_type_slug');
function be_themes_change_post_type_slug() {
	global $be_themes_data;
	if(!isset($be_themes_data['portfolio_slug']) || empty($be_themes_data['portfolio_slug'])){
		return 'portfolio';
	}
	else{
		return $be_themes_data['portfolio_slug'];
	}
} 

$be_custom_font_arr = array(
    "Hans Kendrick Light" => "Hans Kendrick Light",
    "Hans Kendrick Regular" => "Hans Kendrick Regular",
    "Hans Kendrick Medium" => "Hans Kendrick Medium",
    "Hans Kendrick Heavy" => "Hans Kendrick Heavy",
);

$be_fonts_arr = $be_custom_font_arr;
$be_fonts_arr = apply_filters('be_themes_custom_font_filter', $be_custom_font_arr) ;
/* ---------------------------------------------  */
// Enqueue Stylesheets
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_add_styles' ) ) {
	function be_themes_add_styles() {		

		wp_register_style( 'be-style-css', get_stylesheet_uri() );
		wp_enqueue_style( 'be-style-css' );

		wp_register_style( 'be-themes-layout', get_template_directory_uri().'/css/layout.css' );
		wp_enqueue_style( 'be-themes-layout' );	
	
		wp_deregister_style( 'oshine_icons' );
		wp_register_style( 'oshine_icons', get_template_directory_uri().'/fonts/icomoon/style.css' );
		wp_enqueue_style( 'oshine_icons' );	

		wp_deregister_style( 'magnific-popup' );
		wp_register_style( 'magnific-popup', get_template_directory_uri().'/css/magnific-popup.css' );
		wp_enqueue_style( 'magnific-popup' );

		wp_register_style( 'scrollbar', get_template_directory_uri().'/css/scrollbar.css' );
		wp_enqueue_style( 'scrollbar' );

		wp_register_style( 'flickity', get_template_directory_uri().'/css/flickity.css' );
		wp_enqueue_style( 'flickity' );		

		// wp_register_style( 'be-animations', get_template_directory_uri().'/css/animate-custom.css' );
		// wp_enqueue_style( 'be-animations' );

		// wp_register_style( 'be-slider', get_template_directory_uri().'/css/be-slider.css' );
		// wp_enqueue_style( 'be-slider' );

		wp_register_style( 'be-custom-fonts', get_template_directory_uri().'/fonts/fonts.css' );
		wp_enqueue_style( 'be-custom-fonts' );			

	}
	add_action( 'wp_enqueue_scripts', 'be_themes_add_styles');
}
/* ---------------------------------------------  */
// Enqueue scripts
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_add_scripts' ) ) {
	function be_themes_add_scripts() {
		global $be_themes_data;

		
		wp_register_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr.js', '2.6.2', false );
		wp_enqueue_script( 'modernizr' );
		
		wp_register_script( 'asyncloader',  get_template_directory_uri() . '/js/vendor/asyncloader.js', array( 'jquery' ), '1.0' , true );
		wp_enqueue_script( 'asyncloader' );	
	
		wp_register_script( 'custom-scrollbar',  get_template_directory_uri() . '/js/vendor/perfect-scrollbar.jquery.min.js', array( 'jquery' ), false , true );
		wp_enqueue_script( 'custom-scrollbar' );	
		
		//wp_register_script( 'be-themes-script-js', get_template_directory_uri() . '/js/script.js', array( 'jquery','jquery-ui-core','jquery-ui-widget','jquery-ui-mouse','jquery-ui-position','jquery-ui-draggable','jquery-ui-resizable','jquery-ui-selectable','jquery-ui-sortable','jquery-ui-accordion','jquery-ui-tabs','jquery-effects-core','jquery-effects-blind','jquery-effects-bounce','jquery-effects-clip','jquery-effects-drop','jquery-effects-explode','jquery-effects-fade','jquery-effects-fold','jquery-effects-core','jquery-effects-pulsate','jquery-effects-scale','jquery-effects-shake','jquery-effects-slide','jquery-effects-transfer','be-theme-plugins-js','be-main-plugins-js'), FALSE, TRUE );
		wp_register_script( 'be-themes-script-js', get_template_directory_uri() . '/js/script.js', array( 'jquery', 'asyncloader', 'custom-scrollbar'), '5.0', true );
		wp_enqueue_script( 'be-themes-script-js' );

		wp_localize_script(
			'be-themes-script-js', 
			'oshineThemeConfig', 
			array(
				'vendorScriptsUrl' => get_template_directory_uri().'/js/vendor/',
			) 
		);

		
		
	}
	add_action( 'wp_enqueue_scripts', 'be_themes_add_scripts' );
}
require_once( get_template_directory().'/functions/theme-updates/theme-update-checker.php' );
$be_themes_update_checker = new ThemeUpdateChecker(
    'oshin',
    'http://brandexponents.com/oshin-plugins/oshine-purchase-verifier.php'
);
add_filter ('tuc_request_update_query_args-oshin','be_themes_autoupdate_verify');
function be_themes_autoupdate_verify( $query_args ) {
	global $be_themes_purchase_data;
	if(is_array($be_themes_purchase_data) && array_key_exists('theme_purchase_code', $be_themes_purchase_data)){
		$query_args['purchase_key'] = $be_themes_purchase_data['theme_purchase_code'];
	}else{
		$query_args['purchase_key'] = '';
	}

	return $query_args;
}
if(function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'be_themes_revslider_in_theme' );
	function be_themes_revslider_in_theme() {
		set_revslider_as_theme();
	}
}

if(!function_exists( 'be_themes_redirect_fix' )){
	function be_themes_redirect_fix( $link ) {
		if ( $link === get_the_permalink() ) {
			return '';
		};
		return $link;
	}
	add_filter( 'old_slug_redirect_url', 'be_themes_redirect_fix' );
}
//global $redux_welcome;
//remove_action('init', array('Redux_Welcome','do_redirect') );
add_action( 'tatsu_frame_enqueue', 'oshine_enqueue_to_tatsu_frame' );
function oshine_enqueue_to_tatsu_frame() {
	wp_enqueue_style( 'oshine-tatsu-frame-css', get_template_directory_uri().'/css/oshine-tatsu-frame.css' );
}
?>