<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Be_To_Tatsu
 * @subpackage Be_To_Tatsu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Be_To_Tatsu
 * @subpackage Be_To_Tatsu/admin
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Be_To_Tatsu_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Be_To_Tatsu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Be_To_Tatsu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */



		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/be-to-tatsu-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Be_To_Tatsu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Be_To_Tatsu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/be-to-tatsu-admin.js', array( 'jquery' ), $this->version, true );
		wp_localize_script(
			$this->plugin_name,
			'be_to_tatsu_config',
			array (
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'restapiurl' => get_rest_url(null, '/be-to-tatsu/v1/'),
				'post_ids' => implode(',' , $this->get_posts_to_convert() ),
			)
		);

	}

	private function get_posts_to_convert() {
		global $wpdb;
		 $post_ids = $wpdb->get_col( "SELECT DISTINCT main.ID FROM 
					$wpdb->posts	main  INNER JOIN
					$wpdb->postmeta meta1 ON main.ID = meta1.post_id AND 
					meta_key = '_be_pb_disable' AND 
					meta_value = 'no'
				 "); 
		 // $post_ids = $wpdb->get_col( "SELECT main.ID FROM 
		 // 			$wpdb->posts	main  INNER JOIN
		 // 			$wpdb->postmeta meta1 ON main.ID = meta1.post_id AND 
		 // 			meta_key = '_be_pb_disable'
		 // 		 ");		
		return $post_ids;
	}

}
