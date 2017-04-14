<?php
/**
 * Plugin Name:       BE to Tatsu Converter
 * Plugin URI:        http://brandexponents.com
 * Description:       Convert page & post content built using BE Page Builder to a format recognized by Tatsu
 * Version:           1.0.1
 * Author:            Brand Exponents
 * Author URI:        http://brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       be-to-tatsu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


function activate_be_to_tatsu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-be-to-tatsu-activator.php';
	Be_To_Tatsu_Activator::activate();
}


function deactivate_be_to_tatsu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-be-to-tatsu-deactivator.php';
	Be_To_Tatsu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_be_to_tatsu' );
register_deactivation_hook( __FILE__, 'deactivate_be_to_tatsu' );

require  plugin_dir_path( __FILE__ ). 'plugin-update-checker/plugin-update-checker.php';
$be_to_tatsu_update_checker = new PluginUpdateChecker_3_1 (
    'http://brandexponents.com/oshin-plugins/be-to-tatsu.json',
    __FILE__,
    'be-to-tatsu'
);


require plugin_dir_path( __FILE__ ) . 'includes/class-be-to-tatsu.php';


function run_be_to_tatsu() {

	$plugin = new Be_To_Tatsu();
	$plugin->run();

}
run_be_to_tatsu();
