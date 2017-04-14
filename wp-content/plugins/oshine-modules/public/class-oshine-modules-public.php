<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/public
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Oshine_Modules_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Oshine_Modules_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Oshine_Modules_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'be-slider', plugin_dir_url( __FILE__ ) . 'css/be-slider.css' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/oshine-modules.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Oshine_Modules_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Oshine_Modules_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'asyncloader', plugin_dir_url( __FILE__ ) . 'js/vendor/asyncloader.js', array( 'jquery' ), '1.0', true );
		//wp_enqueue_script( 'isotope', plugin_dir_url( __FILE__ ) . 'js/vendor/isotope.js', array( 'jquery' ), '1.0', true );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/oshine-modules.js', array( 'jquery', 'asyncloader', 'jquery-ui-core','jquery-ui-accordion','jquery-ui-tabs' ), $this->version, true );
		
		wp_localize_script(
			$this->plugin_name, 
			'oshineModulesConfig', 
			array(
				'pluginUrl' => plugins_url().'/'.$this->plugin_name.'/',
				'vendorScriptsUrl' => plugins_url().'/'.$this->plugin_name.'/public/js/vendor/',
			) 
		);		

	}

	public function frame_enqueue() {
		wp_enqueue_script( 'resizetoparent', plugin_dir_url( __FILE__ ) . 'js/vendor/resizetoparent.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'be-slider', plugin_dir_url( __FILE__ ) . 'js/vendor/beslider.js', array( 'jquery', 'resizetoparent' ), false , true );
	}

}
