<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_To_Tatsu_Settings {

	private $handle;

	public function __construct() {

	}	 

	public function add_options_page () {
	 
		$this->handle = add_options_page(
		        'BE To Tatsu Converter',
		        'BE Page Builder to Tatsu Converter',
		        'manage_options',
		        'be-to-tatsu',
		        array($this, 'options_markup')
		    );
	}

	public function options_markup() {
		global $wpdb;
		echo '<h2>Convert BE Page Builder Content to Tatsu Content Format</h2>';

		if( is_plugin_active( 'be-page-builder/be-page-builder.php' ) ) {
			echo '<h4><span id="number-of-posts"></span> pages, posts & portfolios found, that have been built using the BE Page Builder.</h4>';
			echo '<button id="tatsu-convert" class="panel-save button-primary">Convert to Tatsu</button>';
			echo '<div id="progressBarWrap"><div id="progressBar"><div></div></div></div>';
			echo '<div id="status-counts">';
			echo '<h5 style="margin:12px 0;line-height:1;">Success: <span id="bt-debug-successcount"></span></h5>';
			echo '<h5 style="margin:12px 0;line-height:1;">Failure: <span id="bt-debug-failurecount"></span></h5>';
			echo '</div>';
			echo '<ol id="bt-debuglist"></ol>';
		} else {
			echo '<h4> Kindly activate the BE PAGE BUILDER plugin, in order to proceed with the conversion. </h4>';
		}
	}
}

?>