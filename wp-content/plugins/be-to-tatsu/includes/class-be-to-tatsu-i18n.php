<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Be_To_Tatsu
 * @subpackage Be_To_Tatsu/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Be_To_Tatsu
 * @subpackage Be_To_Tatsu/includes
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Be_To_Tatsu_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'be-to-tatsu',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
