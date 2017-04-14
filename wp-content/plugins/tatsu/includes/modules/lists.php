<?php
if ( !function_exists('tatsu_lists') ) {
	function tatsu_lists( $atts, $content ) {
		return '<ul class="tatsu-module tatsu-list">'.do_shortcode( $content ).'</ul>';
	}
	add_shortcode( 'tatsu_lists', 'tatsu_lists' );
	add_shortcode( 'lists', 'tatsu_lists' );
}
if ( !function_exists( 'tatsu_list' ) ) {
	function tatsu_list( $atts, $content ) {
		global $be_themes_data;
		extract(shortcode_atts( array( 
			'icon' => '',
			'circled' => '',
			'icon_bg' => $be_themes_data['color_scheme'], 
			'icon_color' => $be_themes_data['alt_bg_text_color'], 
		), $atts ) );
		if( $icon != 'none' ) { 
		 	if( 1 == $circled ) {
		 		$circled = 'circled';
		 		$background_color = 'background-color:'.$icon_bg.';';
		 	} else {
		 		$circled = '';
		 		$background_color = ''; 		
		 	}
		} 
		return '<li class="tatsu-list-content"><i class="tatsu-icon '.$icon.' '.$circled.'" style="'.$background_color.'color:'.$icon_color.';"></i><span class="tatsu-list-inner">'.$content.'</span></li>';
	}
	add_shortcode( 'tatsu_list', 'tatsu_list' );
	add_shortcode( 'list', 'tatsu_list' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_lists');
// add_action( 'tatsu_register_modules', 'tatsu_register_list');
// function tatsu_register_lists() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('Lists','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => 'list',
// 	        'allowed_sub_modules' => array( 'tatsu_list' ),
// 	       // 'default_child_size' => 2, future addition
// 	        'type' => 'multi',
// 	        'isBuiltIn' => false,
// 	        'atts' => array (),
// 	    );
// 	tatsu_register_module( 'tatsu_lists', $controls );
// }
// function tatsu_register_list() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('List','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => '',
// 	        'type' => 'single',
// 	        'isInBuilt' => true,
// 	        'atts' => array (
// 	            array (
// 	        		'att_name' => 'icon',
// 	        		'type' => 'icon_picker',
// 	        		'label' => __('Icon','tatsu'),
// 	        		'options' => '',
// 	        		'defaultValue' => '',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	              	'att_name' => 'circled',
// 	              	'type' => 'switch',
// 	              	'label' => __('Circle the Icon','tatsu'),
// 	              	'defaultValue' => false,
// 	              	'tooltip' => '',
// 	            ),
// 	            array (
// 		            'att_name' => 'icon_bg',
// 		            'type' => 'colorpicker',
// 		            'label' => __('Background Color if circled','tatsu'),
// 		            'defaultValue' => '', //color_scheme
// 		            'tooltip' => '',
// 	            ),
// 	            array (
// 		            'att_name' => 'icon_color',
// 		            'type' => 'colorpicker',
// 		            'label' => __('Icon Color','tatsu'),
// 		            'defaultValue' => '#141414',
// 		            'tooltip' => '',
// 	            ),
// 	            array (
// 	        		'att_name' => 'content',
// 	        		'type' => 'tinymce',
// 	        		'label' => __('Content','tatsu'),
// 	        		'defaultValue' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum',
// 	        		'tooltip' => ''
//  	        	),	
// 	        ),
// 	    );
// 	tatsu_register_module( 'tatsu_list', $controls );
// }

?>