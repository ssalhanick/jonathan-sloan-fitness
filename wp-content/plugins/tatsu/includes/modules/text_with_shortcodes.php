<?php
if ( !function_exists( 'tatsu_text_with_shortcodes' ) ) {
	function tatsu_text_with_shortcodes( $atts, $content ) {
		extract( shortcode_atts( array(
	        'animate'=>0,
	        'animation_type'=>'fadeIn',
	    ),$atts ) );
		$output = '';
		$class = 'tatsu-module';
		$data = '';
		if( isset( $animate ) && 1 == $animate ) {
			$class .= ' tatsu-animate';
			$data = 'data-animation="'.$animation_type.'"';
		}
		//var_dump($content);
		//var_dump(do_shortcode($content));

		$output .= '<div class="'.$class.'" '.$data.'>';
		$output .= do_shortcode( shortcode_unautop( $content ) );
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_text_with_shortcodes', 'tatsu_text_with_shortcodes' );
}


// add_action( 'tatsu_register_modules', 'tatsu_register_text_with_shortcodes');
// function tatsu_register_text_with_shortcodes() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('Shortcode Modules','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => '',
// 	        'type' => 'single',
// 	        'isInBuilt' => false,
// 	        'atts' => array (
// 	            array (
// 	        		'att_name' => 'text_block',
// 	        		'type' => 'tinymce',
// 	        		'label' => __('Shortcode','tatsu'),
// 	        		'defaultValue' => '',
// 	        		'tooltip' => ''
//  	        	),	
// 	        ),
// 	    );
// 	tatsu_register_module( 'tatsu_text_with_shortcodes', $controls );
// }



?>