<?php
if ( !function_exists( 'tatsu_icon_group' ) ) {	
	function tatsu_icon_group( $atts, $content ){
		extract( shortcode_atts( array (
			'alignment' => 'center'
		), $atts ) );
		$output = '<div class="tatsu-module tatsu-icon-group align-'.$alignment.'" >'.do_shortcode( $content ).'</div>';		
		return $output;	
	}	
	add_shortcode( 'tatsu_icon_group', 'tatsu_icon_group' );
	add_shortcode( 'icon_group', 'tatsu_icon_group' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_icon_group');
// function tatsu_register_icon_group() {
// 		$controls = array(
// 	        'icon' => '',
// 	        'title' => __('Icon Group','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'type' => 'multi',
// 	        'allowed_sub_modules' => array (
// 	        	'tatsu_icon'
// 	        ),
// 	        'default_child_size' => '2',	        
// 	        'childModule' => 'Icon',
// 	        'isInBuilt' => false,
// 	        'atts' => array(
// 	            array(
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
// 	tatsu_register_module( 'tatsu_icon_group', $controls );
// }
?>