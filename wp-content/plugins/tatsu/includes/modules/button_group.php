<?php
if (!function_exists('tatsu_button_group')) {	
	function tatsu_button_group( $atts, $content ){
		extract( shortcode_atts( array (
			'alignment' => 'center'
		), $atts ) );
		$output = '<div class="tatsu-module tatsu-button-group align-'.$alignment.'" >'.do_shortcode( $content ).'</div>';		
		return $output;	
	}	
	add_shortcode( 'tatsu_button_group', 'tatsu_button_group' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_button_group' );
// function tatsu_register_button_group() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('Button Group','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => 'button',
// 	        'type' => 'multi',
// 	        'isInBuilt' => true,
// 	        'atts' => array (
// 	            array (
// 	        		'att_name' => 'alignment',
// 	        		'type' => 'buttongroup',
// 	        		'label' => __('Alignment','tatsu'),
// 	        		'options' => array(
// 	        			'Left' => 'left',
// 	        			'Center' => 'center',
// 	        			'Right' => 'right'
// 	        		),
// 	        		'defaultValue' => 'center',
// 	        		'tooltip' => ''
// 	        	),
// 	        ),
// 	    );
// 	tatsu_register_module( 'tatsu_button_group', $controls );
// }

?>