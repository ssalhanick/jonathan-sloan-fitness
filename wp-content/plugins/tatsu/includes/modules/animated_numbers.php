<?php
if (!function_exists('tatsu_animated_numbers')) {
	function tatsu_animated_numbers( $atts, $content ) {
		extract( shortcode_atts( array(
			'number' => '',
			'caption' => '',
	        'number_size' => '45',
	        'number_color' => '#141414',
	        'caption_size' => '13',
	        'caption_color' => '#141414',
	        'alignment' => 'center'
	    ), $atts ) );
		$output = '';
		$output = '<div class="tatsu-module tatsu-an-wrap align-'.$alignment.'">';
		$output .= '<div class="tatsu-an animate" data-number="'.$number.'" style="color:'.$number_color.';font-size:'.$number_size.'px;line-height:1.3"></div>';
		$output .= '<h6><span class="tatsu-an-caption" style="color:'.$caption_color.';font-size:'.$caption_size.'px;">'.$caption.'</span></h6>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_animated_numbers', 'tatsu_animated_numbers' );
	add_shortcode( 'animated_numbers', 'tatsu_animated_numbers' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_animated_numbers' );
// function tatsu_register_animated_numbers() {	
// 		$controls =  array(
// 	        'icon' => '',
// 	        'is_js_dependant' => true,
// 	        'childModule' => '',
// 	        'type' => 'single',
// 	        'atts' => array(
// 	        	array(
// 	        		'att_name' => 'number',
// 	        		'type' => 'text',
// 	        		'label' => 'Number',
// 	        		'defaultValue' => '27',
// 	        		'tooltip' => ''
//  	        	),		        	
// 	        	array(
// 	        		'att_name' => 'caption',
// 	        		'type' => 'text',
// 	        		'label' => 'Caption',
// 	        		'defaultValue' => 'Demos',
// 	        		'tooltip' => ''
//  	        	),	
// 	        	array(
// 	        		'att_name' => 'number_size',
// 	        		'type' => 'slider',
// 	        		'label' => 'Font Size of Number',
// 	        		'defaultValue' => '45',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array(
// 	        		'att_name' => 'caption_size',
// 	        		'type' => 'slider',
// 	        		'label' => 'Font Size of Caption',
// 	        		'defaultValue' => '13',
// 	        		'tooltip' => ''
// 	        	),
// 	             array(
// 	              'att_name' => 'number_color',
// 	              'type' => 'colorpicker',
// 	              'label' => 'Number Color',
// 	              'defaultValue' => '#141414',
// 	              'tooltip' => '',
// 	            ),
// 	             array(
// 	              'att_name' => 'caption_color',
// 	              'type' => 'colorpicker',
// 	              'label' => 'Caption Color',
// 	              'defaultValue' => '#141414',
// 	              'tooltip' => '',
// 	            ),
// 	        	array(
// 	        		'att_name' => 'alignment',
// 	        		'type' => 'buttongroup',
// 	        		'label' => 'Alignment',
// 	        		'options' => array(
// 	        			'Left' => 'left',
// 	        			'Right' => 'right',
// 	        			'center' => 'center'
// 	        		),
// 	        		'defaultValue' => 'center',
// 	        		'tooltip' => ''
// 	        	),
// 	        ),
// 		);
// 	tatsu_register_module( 'tatsu_animated_numbers', $controls );
// }

?>