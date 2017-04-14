<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Frame {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function init() {
		if ( is_admin() || ! $this->loaded_from_iframe() ) {
			return;
		}

		// Disable the WP admin bar in preview mode.
		add_filter( 'show_admin_bar', '__return_false' );
		remove_action('wp_head', '_admin_bar_bump_cb');

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'the_content', array( $this, 'builder_wrapper' ) );
		add_action( 'wp_footer', array( $this, 'frame_footer' ), 999999 );

		// Set the headers to prevent caching for the different browsers
		nocache_headers();

		// Tell to WP Cache plugins do not cache this request.
		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}
	}	

	private function loaded_from_iframe() {
		// if ( ! User::is_current_user_can_edit() ) {
		// 	return false;
		// }

		if ( !current_user_can ('edit_pages') ) {
			return false;
		}

		if ( isset( $_GET['tatsu-frame'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Add custom class in `<body>` element.
	 *
	 * @since 1.0.0
	 * @param array $classes
	 *
	 * @return array
	 */
	public function body_class( $classes = array() ) {
		$classes[] = 'tatsu-frame';
		return $classes;
	}

	/**
	 * Do not show the conent from the page. Just print empty start HTML.
	 * The Javascript will add the content later.
	 *
	 * @since 1.0.0
	 * @param string $content
	 *
	 * @return string
	 */
	public function builder_wrapper( $content ) {
		return '<div id="tatsu-content-wrap"></div>';
	}

	public function frame_footer() {
		echo '<div class="tatsu-observer"><div class="tatsu-observer-tooltip"></div></div><div class="tatsu-drag-observer"></div><div class="tatsu-focus-edit"></div><div id="tatsu-tinymce-helper"></div><input type = "text" id = "tatsu-copy-paste-helper">';
	}	

	/**
	 * Enqueue preview scripts and styles.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'tatsu-frame-css', plugins_url( 'builder/css/tatsu-frame.css', dirname(__FILE__) ) );
		wp_enqueue_script( 'tatsu-frame-js', plugins_url( 'builder/js/tatsu-frame.js', dirname(__FILE__) ), array(), $this->version , true );
		do_action('tatsu_frame_enqueue');
	}	
}